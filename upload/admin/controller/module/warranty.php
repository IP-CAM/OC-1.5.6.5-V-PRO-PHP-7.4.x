<?php
class ControllerModuleWarranty extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/warranty');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('warranty', $this->request->post);			
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('module/warranty', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_product'] = $this->language->get('text_product');		
		$this->data['text_defined'] = $this->language->get('text_defined');		

		$this->data['help_product'] = $this->language->get('help_product');
		$this->data['help_defined'] = $this->language->get('help_defined');

		$this->data['column_description'] = $this->language->get('column_description');

		$this->data['button_save_reload'] = $this->language->get('button_save_reload');
		$this->data['button_done'] = $this->language->get('button_done');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_remove'] = $this->language->get('button_remove');
		

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
			'href'      => $this->url->link('module/warranty', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		
		$this->data['action'] = $this->url->link('module/warranty', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['done'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['warranty_front'])) {
			$this->data['warranty_front'] = $this->request->post['warranty_front'];
		} else {
			$this->data['warranty_front'] = $this->config->get('warranty_front');
		}
			
		$this->template = 'module/warranty.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/warranty')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function install() {
		define('FILE', '../vqmod/xml/warranty_details.xml_');
		define('CACHE', '../vqmod/vqcache/');
		if(file_exists(FILE)){
			@rename(FILE, rtrim(FILE, '_'));
			foreach (glob(CACHE . '*.*') as $cachefile) {
				@unlink($cachefile);
			}
		}
		$this->db->query("ALTER TABLE " . DB_PREFIX . "product_description ADD warranty_details VARCHAR( 255 ) AFTER name");
	}
	
	public function uninstall() {
		define('FILE', '../vqmod/xml/warranty_details.xml');
		define('CACHE', '../vqmod/vqcache/');
		if(file_exists(FILE)){
			@rename(FILE, FILE.'_');
			foreach (glob(CACHE . '*.*') as $cachefile) {
				@unlink($cachefile);
			}
		}
		$this->db->query("ALTER TABLE " . DB_PREFIX . "product_description DROP COLUMN warranty_details");
	}
}
?>