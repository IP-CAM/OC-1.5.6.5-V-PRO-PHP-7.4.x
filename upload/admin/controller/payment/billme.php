<?php 
class ControllerPaymentBillMe extends Controller {
	private $error = array(); 
	 
	public function index() { 
		$this->load->language('payment/billme');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {

			// our form uses an array, but editSetting can't handle it
			// therefore, we need to convert the array to a string
			$clean = $this->request->post;
			if (isset($clean['billme_allowed_groups'])) {
				$clean['billme_allowed_groups'] = implode(',', $clean['billme_allowed_groups']);
			}
		
			$this->model_setting_setting->editSetting('billme', $clean);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
				
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_allowed_groups'] = $this->language->get('entry_allowed_groups');
		$this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=payment/billme&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/billme&token=' . $this->session->data['token'];
		// $this->data['action'] = 'http://funaticstore.com/store/postdump.php?token=' . $this->session->data['token'];

		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];	
		
		if (isset($this->request->post['billme_order_status_id'])) {
			$this->data['billme_order_status_id'] = $this->request->post['billme_order_status_id'];
		} else {
			$this->data['billme_order_status_id'] = $this->config->get('billme_order_status_id'); 
		} 
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['billme_status'])) {
			$this->data['billme_status'] = $this->request->post['billme_status'];
		} else {
			$this->data['billme_status'] = $this->config->get('billme_status');
		}
		
		if (isset($this->request->post['billme_sort_order'])) {
			$this->data['billme_sort_order'] = $this->request->post['billme_sort_order'];
		} else {
			$this->data['billme_sort_order'] = $this->config->get('billme_sort_order');
		}

		if (file_exists(DIR_APPLICATION . 'model/sale/customer_group.php')) {
			$this->load->model('sale/customer_group');
			$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		} else {
			$this->load->model('customer/customer_group');
			$this->data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		}

		if (isset($this->request->post['billme_allowed_groups'])) {
			$this->data['billme_allowed_groups'] = implode(',', $this->request->post['billme_allowed_groups']);
		} else {
			$this->data['billme_allowed_groups'] = explode(',', $this->config->get('billme_allowed_groups'));
		}
	
		$this->load->model('localisation/stock_status');
		
		$this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();
		array_unshift($this->data['stock_statuses'], array('stock_status_id' => '0', 'name' => 'Any'));
   
		if (isset($this->request->post['billme_stock_status_id'])) {
      		$this->data['billme_stock_status_id'] = $this->request->post['billme_stock_status_id'];
    	} else {
      		$this->data['billme_stock_status_id'] = $this->config->get('billme_stock_status_id');
    	}

		$this->template = 'payment/billme.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/billme')) {
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