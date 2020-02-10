<?php
class ControllerModuleSqlExecutor extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/sqlexecutor');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/setting');


		if(!isset($this->session->data['sqlexecutor'])) {
			$this->session->data['sqlexecutor'] = array();
		}

		$this->data['sql_query'] = "";
		if(($this->request->server['REQUEST_METHOD'] == 'POST') || isset($this->request->get['query'])) {
			if(isset($this->request->get['query']) && isset($this->session->data['sqlexecutor'][(int)$this->request->get['query']])) {
				$this->request->post['sql_query'] = $this->session->data['sqlexecutor'][(int)$this->request->get['query']];
				$this->request->post['action'] = $this->request->get['action'];
			}

			$this->data['sql_query'] = $this->request->post['sql_query'];


			$queries = $this->session->data['sqlexecutor'];

			array_unshift($queries, $this->request->post['sql_query']);

			$this->session->data['sqlexecutor'] = array_slice(array_unique($queries), 0, 5);

			$query = $this->db->query(htmlspecialchars_decode($this->request->post['sql_query'], ENT_QUOTES));
			if(is_bool($query)) {
				$this->data['success'] = sprintf($this->language->get('text_affected'), $this->db->countAffected());
			} else {
				$this->data['result'] = $query->rows;
				$this->data['cols'] = array_keys($query->row);
			}
			if($this->request->post['action'] == 'export') {
				$this->export($this->data['result']);
				exit();
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['queries'] = $this->session->data['sqlexecutor'];

		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['button_execute'] = $this->language->get('button_execute');
		$this->data['button_apply'] = $this->language->get('button_apply');

		if(isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/sqlexecutor', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/sqlexecutor', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['query_href'] = $this->url->link('module/sqlexecutor', 'token=' . $this->session->data['token'] . "&query=", 'SSL');

		$this->template = 'module/sqlexecutor.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function export($data = array()) {
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=" . DB_DATABASE . "_" . date("d.m.Y_h:i:s") . ".csv");

		if(count($data) == 0) {
			return null;
		}
		reset($data);

		$df = fopen("php://output", 'w');
		fputcsv($df, array_keys($data[key($data)]), ";", "\"");
		foreach($data as $row) {
			fputcsv($df, $row, ";", "\"");
		}
		fclose($df);

	}
}

?>