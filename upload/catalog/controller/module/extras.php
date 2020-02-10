<?php  
class ControllerModuleExtras extends Controller {
	protected function index() {
	$this->language->load('module/extras');
	
	$this->data['heading_title'] = $this->language->get('heading_title');
	
	$this->data['text_brands'] 	= $this->language->get('text_brands');
	$this->data['text_gift']	= $this->language->get('text_gift');
	$this->data['text_affiliates']	= $this->language->get('text_affiliates');
	$this->data['text_specials'] 	= $this->language->get('text_specials');
	
	$this->data['brands']	= $this->url->link('product/manufacturer');
	$this->data['gift'] 	= $this->url->link('checkout/voucher');
	$this->data['affiliates']	= $this->url->link('affiliate/account');
	$this->data['specials'] 	= $this->url->link('product/special');
	
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/extras.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/module/extras.tpl';
	} else {
	$this->template = 'default/template/module/extras.tpl';
	}
	
	$this->render();
	}
}
?>