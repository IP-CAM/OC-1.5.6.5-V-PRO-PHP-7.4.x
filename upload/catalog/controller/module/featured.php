<?php
class ControllerModuleFeatured extends Controller {
	protected function index($setting) {
	$this->language->load('module/featured'); 

	$this->data['heading_title'] = $this->language->get('heading_title');
	
	$this->data['button_cart'] = $this->language->get('button_cart');
	$this->data['text_tax'] = $this->language->get('text_tax');
	$this->data['position'] = $setting['position'];
	$this->data['button_compare'] = $this->language->get('button_compare');
	$this->data['button_wishlist'] = $this->language->get('button_wishlist');

	$change = $this->config->get('change_module_css');

	if($change && $this->config->get('change_module_css_status')){
	$this->data['change'] = $change['featured'];
	$this->data['description_status'] = $change['featured']['desc_status'];
	$this->data['max'] = $change['featured']['css_strlen'];
	$this->data['title_length'] = $change['featured']['css_productname'];
	$this->data['tax_status'] = $change['featured']['tax_status'];
	$this->data['status'] = true;
 
	$this->load->model('module/module');
	  
	$this->data['sidebar_info'] =  $this->model_module_module->getPositions($setting);
	
	 } else {
	$this->data['change'] = array();
	$this->data['status'] = false;
	$this->data['description_status'] = '';
	$this->data['max'] = '';
	$this->data['title_length'] = '';
	$this->data['tax_status'] = '';
	 }
	$this->load->model('catalog/product'); 
	
	$this->load->model('tool/image');

	$this->data['products'] = array();

	$products = explode(',', $this->config->get('featured_product'));
	shuffle($products);

	if (empty($setting['limit'])) {
	$setting['limit'] = 5;
	}
	
	$products = array_slice($products, 0, (int)$setting['limit']);
	
	foreach ($products as $product_id) {
	$product_info = $this->model_catalog_product->getProduct($product_id);
	
	if ($product_info) {
	if ($product_info['image']) {
	$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
	} else {
	$image = $this->model_tool_image->resize('placeholder.png', $setting['image_width'], $setting['image_height']);
	}

	if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
	$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
	} else {
	$price = false;
	}
	
	if ((float)$product_info['special']) {
	$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
	} else {
	$special = false;
	}
	
	if ($this->config->get('config_tax')) {
	$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
	} else {
	$tax = false;
	}
	if ($this->config->get('config_review_status')) {
	$rating = $product_info['rating'];
	} else {
	$rating = false;
	}
	
	$this->data['products'][] = array(
	'product_id' => $product_info['product_id'],
	'thumb'	=> $image,
	'name'	=> utf8_substr(strip_tags(html_entity_decode($product_info['name'], ENT_QUOTES, 'UTF-8')), 0, 50),
	'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 70) . '...',
	'tax'	 => $tax,
	'price'	=> $price,
	'special' 	 => $special,
	'rating'	  => $rating,
	'reviews'	 => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
	'href'	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
	);
	}
	}

	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/module/featured.tpl';
	} else {
	$this->template = 'default/template/module/featured.tpl';
	}

	$this->render();
	}
}
?>