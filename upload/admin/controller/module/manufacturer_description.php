<?php
class ControllerModuleManufacturerdescription extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/manufacturer_description');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_module'] = $this->language->get('text_module');
		$this->data['text_module_status'] = $this->language->get('text_module_status');

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
			'href'      => $this->url->link('module/manufacturer_description', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/manufacturer_description.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "manufacturer_description"); 
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "manufacturer_description ( 
				`manufacturer_id` int(11) NOT NULL, 
				`language_id` int(11) NOT NULL, 
				`description` text NOT NULL, 
				`meta_description` varchar(255) NOT NULL, 
				`meta_keyword` varchar(255) NOT NULL, 
				PRIMARY KEY (`manufacturer_id`,`language_id`) 
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "manufacturer_description");
	}
	

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/manufacturer_description')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['manufacturer_description_code']) {
			$this->error['code'] = $this->language->get('error_code');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>