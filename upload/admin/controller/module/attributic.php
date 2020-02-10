<?php
class ControllerModuleAttributic extends Controller {
	private $error = array(); 
	
	public function index() {
		$this->load->language('module/attributic');

		$this->document->setTitle($this->language->get('heading_title_fake'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate_modify()) {
			$this->model_setting_setting->editSetting('attributic', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('module/attributic', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['add_template'] = $this->language->get('add_template');
		$this->data['tab_template'] = $this->language->get('tab_template');
		$this->data['name_template'] = $this->language->get('name_template');
		$this->data['select_attributes'] = $this->language->get('select_attributes');
		$this->data['attribute_name'] = $this->language->get('attribute_name');
		$this->data['attribute_group'] = $this->language->get('attribute_group');
		$this->data['attribute_value'] = $this->language->get('attribute_value');

		$this->load->model('module/attributic');

		$results = $this->model_module_attributic->getAttributes();
 
    	foreach ($results as $result) {
			$this->data['attributes'][] = array(
				'attribute_id'    => $result['attribute_id'],
				'name'            => $result['name'],
				'attribute_group' => $result['attribute_group'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['attribute_id'], $this->request->post['selected'])
			);
		}	

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
			'href'      => $this->url->link('module/attributic', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/attributic', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['settings'])) {
			$this->data['modules'] = $this->request->post['settings'];
		} elseif ($this->config->get('settings')) { 
			$this->data['modules'] = $this->config->get('settings');
		}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->template = 'module/attributic.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function getTemplates() {
		$this->load->language('module/attributic');
		
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_delete_all'] = $this->language->get('text_delete_all');
		$this->data['text_delete_empty'] = $this->language->get('text_delete_empty');

		$this->data['modules'] = array();
		
		if ($this->config->get('settings')) { 
			$this->data['modules'] = $this->config->get('settings');
		}

		$this->template = 'module/attributic_select.tpl';		

		$this->response->setOutput($this->render());
  	}

	public function addAttributes() {
		if ($this->config->get('settings')) { 
			$settings[] = array(
			    $this->config->get('settings')
			);
		}

		foreach ($settings as $setting) {
     		$attribute_ids = $setting[0][$this->request->post['this_template_id']]['selected'];
		}

		if (isset($attribute_ids)) {
			$this->load->model('module/attributic');
			
			foreach ($attribute_ids as $attribute_id) {
			    $datas[] = $this->model_module_attributic->getAttribute($attribute_id);
			}

			foreach ($settings as $setting) {
			    foreach ($datas as $data) {
				    $json[] = array(
     			        'attribute_id'                  => $data['attribute_id'],
						'name'                          => $data['name'],
						'product_attribute_description' => $setting[0][$this->request->post['this_template_id']][$data['attribute_id']]['product_attribute_description']
			        );
			    }
		    }

			$this->response->setOutput(json_encode($json));
		}
  	}

	private function validate_modify() {
		if (!$this->user->hasPermission('modify', 'module/attributic')) {
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