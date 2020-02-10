<?php
class ControllerPaymentPaypalEmail extends Controller {
	protected function index() {
	$this->language->load('payment/paypal_email');
	$this->data['text_testmode'] = $this->language->get('text_testmode');	
	$this->data['text_instruction'] = $this->language->get('text_instruction');
	$this->data['text_description'] = $this->language->get('text_description');
	$this->data['text_payment'] = $this->language->get('text_payment');
	$this->data['text_order'] = $this->language->get('text_order');
	$this->data['button_confirm'] = $this->language->get('button_confirm');
	$this->data['paypal_info'] = nl2br($this->config->get('paypal_email_info_' . $this->config->get('config_language_id')));
	$this->data['continue'] = $this->url->link('checkout/paypal_success');
	$this->data['testmode'] = $this->config->get('paypal_email_test');

	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/paypal_email.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/payment/paypal_email.tpl';
	} else {
	$this->template = 'default/template/payment/paypal_email.tpl';
	}

	$this->render();
	}

	public function confirm() {
	$this->language->load('payment/paypal_email');

	$this->load->model('checkout/order');
	$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
	$urlpay = $this->url->link('checkout/paypal_pay&order_id='.$this->session->data['order_id'].'&check='.sha1($order_info['email']), '', 'SSL');
	$comment  = $this->language->get('text_instruction') . "\n\n";
	$comment .= $this->config->get('paypal_email_info_' . $this->config->get('config_language_id')) . "\n\n";
	$comment .= $this->language->get('text_how_to_pay') . " <a href=\"$urlpay\">".$this->language->get('text_pay_now')."</a>\n\n";
	$comment .= $this->language->get('text_payment');
	$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('paypal_email_processed_status_id'), $comment, true);
	}

	public function callback() {
	if (isset($this->request->post['custom'])) {
	$order_id = $this->request->post['custom'];
	} else {
	$order_id = 0;
	}	

	$this->load->model('checkout/order');
	$order_info = $this->model_checkout_order->getOrder($order_id);

	if ($order_info) {
	$request = 'cmd=_notify-validate';

	foreach ($this->request->post as $key => $value) {
	$request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
	}

	if (!$this->config->get('paypal_email_test')) {
	$curl = curl_init('https://www.paypal.com/cgi-bin/webscr');
	} else {
	$curl = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
	}
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($curl);

	if (!$response) {
	$this->log->write('PAYPAL_EMAIL :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
	}

	if ($this->config->get('paypal_email_debug')) {
	$this->log->write('PAYPAL_EMAIL :: IPN REQUEST: ' . $request);
	$this->log->write('PAYPAL_EMAIL :: IPN RESPONSE: ' . $response);
	}

	if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($this->request->post['payment_status'])) {
	$order_status_id = $this->config->get('config_order_status_id');

	switch($this->request->post['payment_status']) {
	case 'Canceled_Reversal':
	$order_status_id = $this->config->get('paypal_email_canceled_reversal_status_id');
	break;
	case 'Completed':
	if ((strtolower($this->request->post['receiver_email']) == strtolower($this->config->get('paypal_email_email'))) && ((float)$this->request->post['mc_gross'] == $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false))) {
	$order_status_id = $this->config->get('paypal_email_completed_status_id');
	} else {
	$this->log->write('PAYPAL_EMAIL :: RECEIVER EMAIL MISMATCH! ' . strtolower($this->request->post['receiver_email']));
	}
	break;
	case 'Denied':
	$order_status_id = $this->config->get('paypal_email_denied_status_id');
	break;
	case 'Expired':
	$order_status_id = $this->config->get('paypal_email_expired_status_id');
	break;
	case 'Failed':
	$order_status_id = $this->config->get('paypal_email_failed_status_id');
	break;
	case 'Pending':
	$order_status_id = $this->config->get('paypal_email_pending_status_id');
	break;
	case 'Processed':
	$order_status_id = $this->config->get('paypal_email_processed_status_id');
	break;
	case 'Refunded':
	$order_status_id = $this->config->get('paypal_email_refunded_status_id');
	break;
	case 'Reversed':
	$order_status_id = $this->config->get('paypal_email_reversed_status_id');
	break;	 
	case 'Voided':
	$order_status_id = $this->config->get('paypal_email_voided_status_id');
	break;	
	}
	if (!$order_info['order_status_id']) {
	$this->model_checkout_order->confirm($order_id, $order_status_id);
	} else {
	$this->model_checkout_order->update($order_id, $order_status_id, '', true);
	}
	} else {
	$this->model_checkout_order->confirm($order_id, $this->config->get('config_order_status_id'));
	}
	curl_close($curl);
	}	
	}
}
?>