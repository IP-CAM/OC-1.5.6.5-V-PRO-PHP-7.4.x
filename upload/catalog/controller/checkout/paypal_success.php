<?php
class ControllerCheckoutPaypalSuccess extends Controller { 
	public function index() {
	if (isset($this->session->data['order_id'])) {
	
	$this->language->load('payment/paypal_email');
	
	$this->data['text_testmode'] = $this->language->get('text_testmode');

	$this->data['button_paypal'] = $this->config->get('config_url') . 'image/data/paypal_email.jpg';
	$this->data['text_pay'] = $this->language->get('text_pay');	

	$this->data['testmode'] = $this->config->get('paypal_email_test');
	
	if (!$this->config->get('paypal_email_test')) {
	$this->data['action'] = 'https://www.paypal.com/cgi-bin/webscr';
	} else {
	$this->data['action'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	}

	$this->load->model('checkout/order');

	$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

	if ($order_info) {
	$this->data['business'] = $this->config->get('paypal_email_email');
	$this->data['item_name'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');	
	
	$this->data['products'] = array();
	
	foreach ($this->cart->getProducts() as $product) {
	$option_data = array();
	
	foreach ($product['option'] as $option) {
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
	'option'   => $option_data,
	'weight'   => $product['weight']
	);
	}	
	
	$this->data['discount_amount_cart'] = 0;
	
	$total = $this->currency->format($order_info['total'] - $this->cart->getSubTotal(), $order_info['currency_code'], false, false);

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
	$this->data['invoice'] = $this->session->data['order_id'] . ' - ' . html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
	$this->data['lc'] = $this->session->data['language'];
	$this->data['notify_url'] = $this->url->link('payment/paypal_email/callback', '', 'SSL');
	$this->data['return'] = $this->url->link('common/home');
	$this->data['cancel_return'] = $this->url->link('checkout/paypal_pay&order_id='.$this->session->data['order_id'].'&check='.sha1($order_info['email']), '', 'SSL');
	
	if (!$this->config->get('paypal_email_transaction')) {
	$this->data['paymentaction'] = 'authorization';
	} else {
	$this->data['paymentaction'] = 'sale';
	}
	
	$this->data['custom'] = $this->session->data['order_id'];
	
	}

	$this->cart->clear();

	unset($this->session->data['shipping_method']);
	unset($this->session->data['shipping_methods']);
	unset($this->session->data['payment_method']);
	unset($this->session->data['payment_methods']);
	unset($this->session->data['guest']);
	unset($this->session->data['comment']);
	unset($this->session->data['order_id']);	
	unset($this->session->data['coupon']);
	unset($this->session->data['reward']);
	unset($this->session->data['voucher']);
	unset($this->session->data['vouchers']);
	}	
	 
	$this->language->load('checkout/paypal_success');
	
	$this->document->setTitle($this->language->get('heading_title'));
	
	$this->data['breadcrumbs'] = array(); 

	$this->data['breadcrumbs'][] = array(
	'href'      => $this->url->link('common/home'),
	'text'      => $this->language->get('text_home'),
	'separator' => false
	); 
	
	$this->data['breadcrumbs'][] = array(
	'href'      => $this->url->link('checkout/cart'),
	'text'      => $this->language->get('text_basket'),
	'separator' => $this->language->get('text_separator')
	);
	
	$this->data['breadcrumbs'][] = array(
	'href'      => $this->url->link('checkout/checkout', '', 'SSL'),
	'text'      => $this->language->get('text_checkout'),
	'separator' => $this->language->get('text_separator')
	);	
	
	$this->data['breadcrumbs'][] = array(
	'href'      => $this->url->link('checkout/paypal_success'),
	'text'      => $this->language->get('text_success'),
	'separator' => $this->language->get('text_separator')
	);

	$this->data['heading_title'] = $this->language->get('heading_title');
	$this->data['text_paypal'] = $this->language->get('text_paypal');
	
	if ($this->customer->isLogged()) {
	$this->data['text_message1'] = $this->language->get('text_customer_pre');
	$this->data['text_message2'] = sprintf($this->language->get('text_customer_post'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
	} else {
	$this->data['text_message1'] = $this->language->get('text_guest_pre');
	$this->data['text_message2'] = sprintf($this->language->get('text_guest_post'), $this->url->link('information/contact'));
	}
	
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