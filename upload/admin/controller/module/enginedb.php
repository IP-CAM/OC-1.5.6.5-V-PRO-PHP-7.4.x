<?php
class ControllerModuleEnginedb extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('module/enginedb');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/enginedb');
		$this->load->model('setting/setting');


		$this->data['heading_title'] = $this->language->get('heading_title');


		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/enginedb', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '

		);
		
		$this->data['action'] = $this->url->link('module/enginedb', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		$this->data['button_innodb'] = $this->language->get('Button_innodb');
		$this->data['button_myisam'] = $this->language->get('Button_myisam');

		$this->data['innodb'] = $this->model_setting_enginedb->showEnginedb('InnoDB');
		$this->data['myisam'] = $this->model_setting_enginedb->showEnginedb('MyISAM');
	
		$this->data['success'] = '';
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {			
			$this->model_setting_setting->editSetting('enginedb', $this->request->post);		

			$this->session->data['success'] = $this->language->get('error_convert');

			if (isset($this->request->post['button_innodb']) && isset($this->request->post['innodb'])) {

				$list_table = $this->request->post['innodb'];

				$this->model_setting_enginedb->convertEnginedb($list_table,'MyISAM');
				
				$this->session->data['success'] = $this->language->get('success_myisam');

				$this->redirect($this->url->link('module/enginedb', 'token=' . $this->session->data['token'], 'SSL'));	

			} elseif (isset($this->request->post['button_myisam']) && isset($this->request->post['myisam'])) { 

				$list_table = $this->request->post['myisam'];

				$this->model_setting_enginedb->convertEnginedb($list_table,'InnoDB');

				$this->session->data['success'] =  $this->language->get('success_innodb');

				$this->redirect($this->url->link('module/enginedb', 'token=' . $this->session->data['token'], 'SSL'));	
			}
			else{
				$this->session->data['error_warning'] = $this->language->get('error_none');
			}
			
		}
		if(isset($this->session->data['success'])){
			$this->data['success'] = $this->session->data['success'];
		}else{
			$this->data['success'] = '';
		}

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/enginedb.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());

	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/enginedb')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>