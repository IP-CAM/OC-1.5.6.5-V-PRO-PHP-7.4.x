<?php
class ControllerCommonCustomerBlock extends Controller {
	public function index() {
	$this->load->language('common/customer_block');
	$this->load->language('common/footer'); // for load text_contact: contact us
	$this->document->setTitle($this->language->get('heading_title'));
	$this->data['title'] = $this->language->get('heading_title');
	$this->data['heading_title'] = $this->language->get('heading_title');
	$this->document->breadcrumbs = array();
	$this->data['breadcrumbs'] = $this->document->breadcrumbs;
	$this->data['message'] = $this->language->get('text_message');

	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/customer_block.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/common/customer_block.tpl';
	} else {
	$this->template = 'default/template/common/customer_block.tpl';
	}
	
	$this->children = array(
	'common/header',
	'common/footer'
	);

	$this->response->setOutput($this->render(TRUE));
	}
	public function check() {
	$this->_install_customer_block();
	$this->load->model('tool/customer_block');
	if ( !method_exists($this->model_design_layout, "getLayout") ) { 
	$this->load->model('design/layout');
	}

	$ignore = array(
	'information/contact',
	);

	$match = false;
	if (isset($this->request->get['route'])) {
	foreach ($ignore as $i) {
	if (strpos($this->request->get['route'], $i) !== false) {
	$match = true;
	break;
	}
	}
	}
	if(!$match)
	{
	$blocked = false;

	if($this->customer->isLogged())
	{
	$data = array(
	'block_type'	=>	'email'
	, 'block_value'	=>	$this->customer->getEmail()
	, 'status'	=>	1
	);
	$results = $this->model_tool_customer_block->getCustomerBlocks($data);
	if(!empty($results))
	{
	$blocked = true;
	if ($this->config->get('config_error_log')) {
	$this->log->write('Customer Blocked: '. $this->customer->getEmail(). ' at '.date("Y/m/d H:i:s"));
	}
	}
	}

	if($blocked == false)
	{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$data = array(
	'block_type'	=>	'ip'
	, 'block_value'	=>	$ip_address
	, 'status'	  =>	1
	);
	$results = $this->model_tool_customer_block->getCustomerBlocks($data);
	if(!empty($results))
	{
	$blocked = true;
	if ($this->config->get('config_error_log')) {
	$this->log->write('Customer Blocked: '. $ip_address. ' at '.date("Y/m/d H:i:s"));
	}
	}	
	}

	if($blocked == true)
	{
	return $this->forward('common/customer_block');
	}
	}
	}

	private function _install_customer_block()
	{
	$query = $this->db->query("SHOW TABLES FROM `".DB_DATABASE."` LIKE '".DB_PREFIX."customer_block'");

	if(empty($query->rows))
	{
	$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."customer_block` (
	`customer_block_id` BIGINT NULL AUTO_INCREMENT,
	`block_type` VARCHAR(50) NULL,
	`block_value` VARCHAR(50) NULL,
	`note` TEXT NULL,
	`status` TINYINT NULL,
	`date_added` DATETIME NULL,
	PRIMARY KEY (`customer_block_id`)
	);";
	$result = $this->db->query($sql);
	}
	return true;
	}
}
?>