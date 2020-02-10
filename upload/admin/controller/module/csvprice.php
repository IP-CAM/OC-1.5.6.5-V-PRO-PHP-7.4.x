<?php
class ControllerModuleCSVPrice extends Controller {
	private $_name = 'csvprice';
	private $_version = '0.1.5b';
	private $error = array();

	public function index() {
		$this->language->load('module/csvprice');
		$this->load->model('module/csvprice');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['csvprice_version'] = $this->_version;

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
			if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
				$this->model_module_csvprice->import($this->request->files['import']['tmp_name']);
			} else {
				$this->error['warning'] = $this->language->get('error_empty');
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_module'] = $this->language->get('text_module');
		$this->data['text_notes'] = $this->language->get('text_notes');

		$this->data['entry_import'] = $this->language->get('entry_import');
		$this->data['entry_import_help'] = $this->language->get('entry_import_help');
		$this->data['entry_export'] = $this->language->get('entry_export');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_category_help'] = $this->language->get('entry_category_help');

		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['button_import'] = $this->language->get('button_import');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		foreach ($languages as $language) {
			if (isset($this->error['code' . $language['language_id']])) {
				$this->data['error_code' . $language['language_id']] = $this->error['code' . $language['language_id']];
			} else {
				$this->data['error_code' . $language['language_id']] = '';
			}
		}

        //Set up breadcrumb trail.
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
			'href'      => $this->url->link('module/'.$this->_name, 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
   		);

		$this->data['import'] = $this->url->link('module/csvprice', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['export'] = $this->url->link('module/csvprice/export', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);

		$this->template = 'module/csvprice.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());
	}

	public function export() {
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {

			$price_export = date("Ymd-Hi").'_price_export.csv';

			$this->response->addheader('Pragma: public');
			$this->response->addheader('Expires: 0');
			$this->response->addheader('Content-Description: File Transfer');
			$this->response->addheader('Content-Type: application/octet-stream');
			$this->response->addheader('Content-Disposition: attachment; filename='.$price_export);
			$this->response->addheader('Content-Transfer-Encoding: binary');

			$this->load->model('module/csvprice');

			if ( ! isset($this->request->post['product_category'])) {
				$product_category = NULL;
			} else {
				$product_category = $this->request->post['product_category'];
			}

			$this->response->setOutput($this->model_module_csvprice->export($product_category));
		} else {
			return $this->forward('error/permission');
		}
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/csvprice')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>