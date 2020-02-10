<?php
class ControllerSaleCustomerBlock extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('sale/customer_block');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/customer_block');
		
		$this->getList();
	} 

	private function getList() {
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       	'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       	'text'      => $this->language->get('text_home'),
      	'separator' => FALSE
   		);

   		$this->data['breadcrumbs'][] = array(
   			'href'      => $this->url->link('sale/customer_block', 'token=' . $this->session->data['token'], 'SSL'),
       	'text'      => $this->language->get('heading_title'),
      	'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('sale/customer_block/insert', 'token=' . $this->session->data['token'], 'SSL');	
		$this->data['delete'] = $this->url->link('sale/customer_block/delete', 'token=' . $this->session->data['token'], 'SSL');	

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cb.block_value'; 
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$this->data['customer_blocks'] = array();
		
		$data = array(
			'sort'  => $sort,
      'order' => $order,
      'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')    
    );        
    
		$customer_block_total = $this->model_sale_customer_block->getTotalCustomerBlocks($data);
    
    $results = $this->model_sale_customer_block->getCustomerBlocks($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/customer_block/update', 'token=' . $this->session->data['token']. '&customer_block_id=' . $result['customer_block_id'], 'SSL')
			);
						
			$this->data['customer_blocks'][] = array(
				'customer_block_id'  	=> $result['customer_block_id'],
				'block_type'       		=> $result['block_type'],
				'block_value'      		=> $result['block_value'],
				'note'       			=> $result['note'],
				'status'     			=> $result['status'],
				'date_added' 			=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'   			=> isset($this->request->post['selected']) && in_array($result['customer_block_id'], $this->request->post['selected']),
				'action'     			=> $action
			);
		}	
	
		$this->data['heading_title'] 			= $this->language->get('heading_title');

		$this->data['text_no_results'] 			= $this->language->get('text_no_results');

    $this->data['select_ip_address'] = $this->language->get('select_ip_address');
    $this->data['select_email']      = $this->language->get('select_email');
		
    $this->data['column_customer_block_id'] = $this->language->get('column_customer_block_id');
		$this->data['column_block_type'] 		= $this->language->get('column_block_type');
		$this->data['column_block_value'] 		= $this->language->get('column_block_value');
		$this->data['column_note'] 				= $this->language->get('column_note');
		$this->data['column_status'] 			= $this->language->get('column_status');
		$this->data['column_date_added'] 		= $this->language->get('column_date_added');
		$this->data['column_action'] 			= $this->language->get('column_action');		
		
		$this->data['button_insert'] 			= $this->language->get('button_insert');
		$this->data['button_delete'] 			= $this->language->get('button_delete');
 		
		$this->data['text_enabled'] 			= $this->language->get('text_enabled');
		$this->data['text_disabled'] 			= $this->language->get('text_disabled');
		
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

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

    $this->data['sort_customer_block_id']  = $this->url->link('sale/customer_block', 'token=' . $this->session->data['token'] . '&sort=cb.customer_block_id' . $url, 'SSL');
    $this->data['sort_block_type'] = $this->url->link('sale/customer_block', 'token=' . $this->session->data['token'] . '&sort=cb.block_type' . $url, 'SSL');
    $this->data['sort_block_value'] = $this->url->link('sale/customer_block', 'token=' . $this->session->data['token'] . '&sort=cb.block_value' . $url, 'SSL');
    $this->data['sort_note'] = $this->url->link('sale/customer_block', 'token=' . $this->session->data['token'] . '&sort=cb.note' . $url, 'SSL');
    $this->data['sort_date_added'] = $this->url->link('sale/customer_block', 'token=' . $this->session->data['token'] . '&sort=cb.date_added' . $url, 'SSL');
    $this->data['sort_status'] = $this->url->link('sale/customer_block', 'token=' . $this->session->data['token'] . '&sort=cb.status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $customer_block_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer_block', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort']  = $sort;
		$this->data['order'] = $order;
    
    $this->template = 'sale/customer_block_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	
  } // getList
	
	
  	public function insert() {
    	$this->load->language('sale/customer_block');

		  $this->document->setTitle($this->language->get('heading_title'));
      $this->data['text_your_ip_address'] = $this->language->get('text_your_ip_address');
		
		  $this->load->model('sale/customer_block');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {		    
        $this->model_sale_customer_block->addCustomerBlock($this->request->post);			
		    $this->session->data['success'] = $this->language->get('text_success');			
		    $this->redirect($this->url->link('sale/customer_block', 'token=' . $this->session->data['token'], 'SSL'));
    	}
	
    	$this->getForm();
  	} // insert

	public function update() {
		$this->load->language('sale/customer_block');

		$this->document->setTitle($this->language->get('heading_title'));
    $this->data['text_your_ip_address'] = $this->language->get('text_your_ip_address');
		
		$this->load->model('sale/customer_block');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_customer_block->editCustomerBlock($this->request->get['customer_block_id'], $this->request->post);			
			$this->session->data['success'] = $this->language->get('text_success');									
			$this->redirect($this->url->link('sale/customer_block', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	} // update

	public function delete() { 
		$this->load->language('sale/customer_block');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/customer_block');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $customer_block_id) {
				$this->model_sale_customer_block->deleteCustomerBlock($customer_block_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('sale/customer_block', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	} // delete
	
	private function getForm() {
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['select_ip_address'] = $this->language->get('select_ip_address');
    $this->data['select_email']      = $this->language->get('select_email');
    
    $this->data['entry_customer_block_id'] 	= $this->language->get('entry_customer_block_id');
		$this->data['entry_block_type'] 		= $this->language->get('entry_block_type');
		$this->data['entry_block_value'] 		= $this->language->get('entry_block_value');
		$this->data['entry_note'] 				= $this->language->get('entry_note');
		$this->data['entry_status'] 			= $this->language->get('entry_status');
		$this->data['entry_date_added'] 		= $this->language->get('entry_date_added');
		
    $this->data['text_enabled'] 			= $this->language->get('text_enabled');
		$this->data['text_disabled'] 			= $this->language->get('text_disabled');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['block_value'])) {
			$this->data['error_block_value'] = $this->error['block_value'];
		} else {
			$this->data['error_block_value'] = '';
		}
 		
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
   			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'), 
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->data['breadcrumbs'][] = array(
   			'href'		=> $this->url->link('sale/customer_block', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
										
		if (!isset($this->request->get['customer_block_id'])) {
			$this->data['action'] = $this->url->link('sale/customer_block/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/customer_block/update', 'token=' . $this->session->data['token'] . '&customer_block_id=' . $this->request->get['customer_block_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('sale/customer_block', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['customer_block_id'])) {
			$customer_block_info = $this->model_sale_customer_block->getCustomerBlock($this->request->get['customer_block_id']);
		}
		
		if(isset($customer_block_info['customer_block_id']))
		{
			$this->data['customer_block_id'] 	= $customer_block_info['customer_block_id'];	
		}
		else
		{
			$this->data['customer_block_id'] 	= "";	
		}
		
		if (isset($this->request->post['block_type'])) 
		{
			$this->data['block_type'] = $this->request->post['block_type'];
		}
		elseif(isset($customer_block_info['block_type']))
		{
			$this->data['block_type'] 			= $customer_block_info['block_type'];
		}
		elseif(isset($this->request->get['block_type']))
		{
			$this->data['block_type'] 			= $this->request->get['block_type'];
		}
		else
		{
			$this->data['block_type'] 			= "";
		}
		
		if (isset($this->request->post['block_value'])) 
		{
			$this->data['block_value'] = $this->request->post['block_value'];
		}
		elseif(isset($customer_block_info['block_value']))
		{
			$this->data['block_value'] 			= $customer_block_info['block_value'];
		}
		elseif(isset($this->request->get['block_value']))
		{
			$this->data['block_value'] 			= $this->request->get['block_value'];
		}
		else
		{
			$this->data['block_value'] 			= "";
		}
		
		if (isset($this->request->post['note'])) 
		{
			$this->data['note'] = $this->request->post['note'];
		}
		elseif(isset($customer_block_info['note']))
		{
			$this->data['note'] 				= $customer_block_info['note'];
		}
		else
		{
			$this->data['note'] 				= "";	
		}
		
		if (isset($this->request->post['status'])) 
		{
			$this->data['status'] = $this->request->post['status'];
		}
		elseif(isset($customer_block_info['status']))
		{
			$this->data['status'] 				= $customer_block_info['status'];	
		}
		else
		{
			$this->data['status'] 				= 1;	
		}
		
		$this->template = 'sale/customer_block_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	} // getForm
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/customer_block')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		
		if ($this->request->post['block_type'] == 'ip' && $this->validateIpAddress($this->request->post['block_value']) == false) {
			$this->error['block_value'] = $this->language->get('error_ip_address');
		}
		
		if($this->request->post['customer_block_id'] == '' 
				&& ($this->request->post['block_type'] == 'ip' && $this->request->post['block_value'] != ''))
		{
			$data = array(
				  'block_type'	=>	'ip'
				, 'block_value'	=>	$this->request->post['block_value']
			);
			$results = $this->model_sale_customer_block->getCustomerBlocks($data);
			if(!empty($results))
			{
				$this->error['block_value'] = $this->language->get('error_ip_address_duplicated');
			}
		}		

		if ($this->request->post['block_type'] == 'email' && $this->validateEmail($this->request->post['block_value']) == false) {
			$this->error['block_value'] = $this->language->get('error_email');
		}
		
		if($this->request->post['customer_block_id'] == '' 
				&& ($this->request->post['block_type'] == 'email' && $this->request->post['block_value'] != ''))
		{
			$data = array(
				  'block_type'	=>	'email'
				, 'block_value'	=>	$this->request->post['block_value']
			);
			$results = $this->model_sale_customer_block->getCustomerBlocks($data);
			if(!empty($results))
			{
				$this->error['block_value'] = $this->language->get('error_email_duplicated');
			}
		}		


		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/customer_block')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}	
	
	//function to validate ip address format in php by Roshan Bhattarai(http://roshanbh.com.np)
	function validateIpAddress($ip_addr)
	{
	  //first of all the format of the ip address is matched
	  if(preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/",$ip_addr))
	  {
	    //now all the intger values are separated
	    $parts=explode(".",$ip_addr);
	    //now we need to check each part can range from 0-255
	    foreach($parts as $ip_parts)
	    {
	      if(intval($ip_parts)>255 || intval($ip_parts)<0)
	      return false; //if number is not within range of 0-255
	    }
	    return true;
	  }
	  else
	    return false; //if format of ip address doesn't matches
	}
	
	function validateEmail($email)
	{
		//if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
    if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email))
		{
    		return true;
  		}
  		return false;	
	}
}
?>