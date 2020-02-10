<?php 
class ControllerPaymentVariablePay extends Controller {
	private $error = array(); 
	 
	public function index() { 
		$this->load->language('payment/variable_pay');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			foreach($this->request->post['variable_pay'] as $key=> $variable)
			{
				$tmp1 = 'variable_pay_'.$key.'_title';
				$tmp2 = 'variable_pay_'.$key.'_description';
				$this->request->post[$tmp1] = $variable['title'];
				$this->request->post[$tmp2] = $variable['description'];
			}
			unset($this->request->post['variable_pay']);
			
			$this->model_setting_setting->editSetting('variable_pay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
				
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
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
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/variable_pay', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('payment/variable_pay', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');	
		
		if (isset($this->request->post['variable_pay_total'])) {
			$this->data['variable_pay_total'] = $this->request->post['variable_pay_total'];
		} else {
			$this->data['variable_pay_total'] = $this->config->get('variable_pay_total'); 
		}
				
		if (isset($this->request->post['variable_pay_order_status_id'])) {
			$this->data['variable_pay_order_status_id'] = $this->request->post['variable_pay_order_status_id'];
		} else {
			$this->data['variable_pay_order_status_id'] = $this->config->get('variable_pay_order_status_id'); 
		} 
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['variable_pay_geo_zone_id'])) {
			$this->data['variable_pay_geo_zone_id'] = $this->request->post['variable_pay_geo_zone_id'];
		} else {
			$this->data['variable_pay_geo_zone_id'] = $this->config->get('variable_pay_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');						
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['variable_pay_status'])) {
			$this->data['variable_pay_status'] = $this->request->post['variable_pay_status'];
		} else {
			$this->data['variable_pay_status'] = $this->config->get('variable_pay_status');
		}
		
		if (isset($this->request->post['variable_pay_sort_order'])) {
			$this->data['variable_pay_sort_order'] = $this->request->post['variable_pay_sort_order'];
		} else {
			$this->data['variable_pay_sort_order'] = $this->config->get('variable_pay_sort_order');
		}

		$rs = array();
		foreach($this->data['languages'] as $key=> $lang)
		{
			
			$t = 'variable_pay_'.$lang['language_id'].'_title';
			
			
			$t1 = 'variable_pay_'.$lang['language_id'].'_description';
			$tmp = array(
					'title' => $this->config->get($t),
					'description' => $this->config->get($t1)
					);
			$rs[$lang['language_id']] = $tmp;
		
		}
		
		
		if (isset($this->request->post['variable_pay'])) {
			$this->data['variable_pay'] = $this->request->post['variable_pay'];
		} else {
			$this->data['variable_pay'] = $rs;
		}
		
		
		
		$this->template = 'payment/variable_pay.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/variable_pay')) {
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