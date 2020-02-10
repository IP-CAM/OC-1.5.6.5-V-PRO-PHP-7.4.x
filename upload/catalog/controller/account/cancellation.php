<?php 
class ControllerAccountCancellation extends Controller { 
	public function index() {
	if (!$this->customer->isLogged()) {
	$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
	
	$this->redirect($this->url->link('account/login', '', 'SSL'));
	}
	
	$this->language->load('account/cancellation');

	$this->document->setTitle($this->language->get('heading_title'));

	$this->data['breadcrumbs'] = array();

	$this->data['breadcrumbs'][] = array(
	'text'      => $this->language->get('text_home'),
	'href'      => $this->url->link('common/home'),
	'separator' => false
	); 

	$this->data['breadcrumbs'][] = array( 	
	'text'      => $this->language->get('text_account'),
	'href'      => $this->url->link('account/account', '', 'SSL'),
	'separator' => $this->language->get('text_separator')
	);
	
	$this->data['breadcrumbs'][] = array( 	
	'text'      => $this->language->get('text_account_cancellation'),
	'href'      => $this->url->link('account/cancellation', '', 'SSL'),
	'separator' => $this->language->get('text_separator')
	);
	
	if (isset($this->session->data['success'])) {
	$this->data['success'] = $this->session->data['success'];
	
	unset($this->session->data['success']);
	} else {
	$this->data['success'] = '';
	}
	
	$this->data['heading_title'] = $this->language->get('heading_title');
	
	$this->data['text_account_cancellation'] = $this->language->get('text_account_cancellation');

	$this->data['text_account_cancellation_message'] = $this->language->get('text_account_cancellation_message');
	
	$this->data['button_continue'] = $this->language->get('button_continue');
	
	$this->data['continue'] = $this->url->link('account/cancellation/update', '', 'SSL');	
	
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/cancellation.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/account/cancellation.tpl';
	} else {
	$this->template = 'default/template/account/cancellation.tpl';
	}
	
	$this->children = array(
	'common/column_left',
	'common/column_right',
	'common/content_top',
	'common/content_bottom',
	'common/footer',
	'common/header'	
	);
	
	$this->response->setOutput($this->render());
  	}
	
	public function update() {
	$this->language->load('account/cancellation');
	
	if (!$this->customer->isLogged()) {
	$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
	
	$this->redirect($this->url->link('account/login', '', 'SSL'));
	}
	
	$this->load->model('account/customer');
	
	$this->model_account_customer->changeStatus($this->customer->getId());
	
	$this->session->data['success'] = $this->language->get('text_account_cancellation_success');
	
	$this->customer->logout();
	
	$this->redirect($this->url->link('account/account'));	
	}
}
?>