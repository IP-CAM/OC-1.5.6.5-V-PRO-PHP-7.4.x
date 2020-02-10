<?php
class ControllerCheckoutPaypalPay extends Controller { 
	public function index() {
	if (isset($this->request->get['order_id']) && isset($this->request->get['check'])) {
	
	$this->language->load('payment/paypal_email');
	
	$this->data['text_testmode'] = $this->language->get('text_testmode');
	$this->data['text_pay'] = $this->language->get('text_pay');
	$this->data['testmode'] = $this->config->get('paypal_email_test');
	
	if (!$this->config->get('paypal_email_test')) {
	$this->data['action'] = 'https://www.paypal.com/cgi-bin/webscr';
	} else {
	$this->data['action'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	}

	$this->load->model('checkout/order');

	$order_info = $this->model_checkout_order->getOrder($this->request->get['order_id']);

	if ($order_info) {
	$this->data['business'] = $this->config->get('paypal_email_email');
	$this->data['item_name'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');	
	
	$this->data['products'] = array();
	$subtotal = 0;
	$order_products = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$this->request->get['order_id'] . "'");

	foreach ($order_products->rows as $product) {
	$option_data = array();
	$order_options = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$this->request->get['order_id'] . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
	
	foreach ($order_options->rows as $option) {
	if ($option['type'] != 'file') {
	$value = $option['option_value'];	
	} else {
	$filename = $this->encryption->decrypt($option['option_value']);
	
	$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
	}
	
	$option_data[] = array(
	'name'  => $option['name'],
	'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
	);
	}
	
	$this->data['products'][] = array(
	'name'     => $product['name'],
	'model'    => $product['model'],
	'price'    => $this->currency->format($product['price'], $order_info['currency_code'], false, false),
	'quantity' => $product['quantity'],
	'option'   => $option_data
	);
	
	$subtotal += ($product['quantity'] * $product['price']);
	}	
	
	$this->data['discount_amount_cart'] = 0;
	$total = $this->currency->format($order_info['total'] - $subtotal, $order_info['currency_code'], false, false);

	if ($total > 0) {
	$this->data['products'][] = array(
	'name'     => $this->language->get('text_total'),
	'model'    => '',
	'price'    => $total,
	'quantity' => 1,
	'option'   => array(),
	'weight'   => 0
	);	
	} else {
	$this->data['discount_amount_cart'] -= $total;
	}
	
	$this->data['currency_code'] = $order_info['currency_code'];
	$this->data['first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');	
	$this->data['last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');	
	$this->data['address1'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');	
	$this->data['address2'] = html_entity_decode($order_info['payment_address_2'], ENT_QUOTES, 'UTF-8');	
	$this->data['city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');	
	$this->data['zip'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');	
	$this->data['country'] = $order_info['payment_iso_code_2'];
	$this->data['email'] = $order_info['email'];
	$this->data['invoice'] = $this->request->get['order_id'] . ' - ' . html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
	$this->data['lc'] = $this->session->data['language'];
	$this->data['notify_url'] = $this->url->link('payment/paypal_email/callback', '', 'SSL');
	$this->data['return'] = $this->url->link('common/home');
	$this->data['cancel_return'] = $this->url->link('checkout/paypal_pay&order_id='.$this->request->get['order_id'].'&check='.sha1($order_info['email']), '', 'SSL');
	
	if (!$this->config->get('paypal_email_transaction')) {
	$this->data['paymentaction'] = 'authorization';
	} else {
	$this->data['paymentaction'] = 'sale';
	}
	
	$this->data['custom'] = $this->request->get['order_id'];
	
	}
	
	if($this->request->get['check'] == sha1($order_info['email'])) $this->data['button_paypal'] = $this->config->get('config_url') . 'image/data/paypal_email.jpg';

	}	
	 
	$this->language->load('checkout/paypal_success');
	
	$this->document->setTitle($this->language->get('text_pay'));
	
	$this->data['breadcrumbs'] = array(); 

	$this->data['breadcrumbs'][] = array(
	'href'      => $this->url->link('common/home'),
	'text'      => $this->language->get('text_home'),
	'separator' => false
	); 
	
	$this->data['breadcrumbs'][] = array(
	'href'      => $this->url->link('checkout/paypal_pay'),
	'text'      => $this->language->get('text_pay'),
	'separator' => $this->language->get('text_separator')
	);

	$this->data['heading_title'] = $this->language->get('text_pay');
	$this->data['text_paypal'] = '';
   	$this->data['text_message1'] = isset($this->data['button_paypal']) ? sprintf($this->language->get('text_pay_msg1'),$this->request->get['order_id']) : $this->language->get('text_pay_error');
	$this->data['text_message2'] = $this->language->get('text_pay_msg2');
	
	$this->data['button_continue'] = $this->language->get('button_continue');

	$this->data['continue'] = $this->url->link('common/home');

	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/paypal_success.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/common/paypal_success.tpl';
	} else {
	$this->template = 'default/template/common/paypal_success.tpl';
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
}
?>