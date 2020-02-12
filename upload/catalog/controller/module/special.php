<?php
class ControllerModuleSpecial extends Controller {
	protected function index($setting) {
	$this->language->load('module/special');

	$this->data['heading_title'] = $this->language->get('heading_title');

	$this->data['button_cart'] = $this->language->get('button_cart');
	$this->data['text_tax'] = $this->language->get('text_tax');
	$this->data['position'] = $setting['position'];
	$this->data['button_compare'] = $this->language->get('button_compare');
	$this->data['button_wishlist'] = $this->language->get('button_wishlist');	
	$this->load->model('catalog/product');

	$change = $this->config->get('change_module_css');

	if($change && $this->config->get('change_module_css_status')){
	$this->data['change'] = $change['special'];
	$this->data['description_status'] = $change['special']['desc_status'];
	$this->data['max'] = $change['special']['css_strlen'];
	$this->data['title_length'] = $change['special']['css_productname'];
	$this->data['tax_status'] = $change['special']['tax_status'];
	$this->data['status'] = true;
	  
	$this->data['sidebar_info'] =  $this->model_module_module->getPositions($setting);
	
	 } else {
	$this->data['change'] = array();
	$this->data['status'] = false;
	$this->data['description_status'] = '';
	$this->data['max'] = '';
	$this->data['title_length'] = '';
	$this->data['tax_status'] = '';
	 }
	$this->load->model('tool/image');

	$this->data['products'] = array();
	
	$data = array(
	'sort'  => 'pd.name',
	'order' => 'ASC',
	'start' => 0,
	'limit' => $setting['limit']
	);

	$results = $this->model_catalog_product->getProductSpecials($data);

	foreach ($results as $result) {
	if ($result['image']) {
	$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
	} else {
	$image = $this->model_tool_image->resize('placeholder.png', $setting['image_width'], $setting['image_height']);
	}

	if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
	$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
	} else {
	$price = false;
	}
	
	if ((float)$result['special']) { 
	$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
	} else {
	$special = false;
	}
	
	if ($this->config->get('config_tax')) {
	$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
	} else {
	$tax = false;
	}
	if ($this->config->get('config_review_status')) {
	$rating = $result['rating'];
	} else {
	$rating = false;
	}
	
	$this->data['products'][] = array(
	'product_id' => $result['product_id'],
	'thumb'	=> $image,
	'name'	=> utf8_substr(strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 0, 50),
	'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 70) . '...',
	'tax'	 => $tax,
	'price'	=> $price,
	'special' 	 => $special,
	'rating'	  => $rating,
	'reviews'	 => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
	'href'	 => $this->url->link('product/product', 'product_id=' . $result['product_id'])
	);
	}

	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/special.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/module/special.tpl';
	} else {
	$this->template = 'default/template/module/special.tpl';
	}

	$this->render();
	}
}
?>