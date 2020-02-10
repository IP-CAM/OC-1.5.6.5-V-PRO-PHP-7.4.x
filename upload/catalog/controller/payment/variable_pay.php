<?php
class ControllerPaymentVariablePay extends Controller {
	protected function index() {
	$this->data['button_confirm'] = $this->language->get('button_confirm');

	$this->data['continue'] = $this->url->link('checkout/success');
	$tmp = 'variable_pay_'.$this->config->get('config_language_id').'_description';
	$this->data['description'] = $this->config->get($tmp);
	
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/variable_pay.tpl')) {
	$this->template = $this->config->get('config_template') . '/template/payment/variable_pay.tpl';
	} else {
	$this->template = 'default/template/payment/variable_pay.tpl';
	}
	
	$this->render();
	}
	
	public function confirm() {
	$this->load->model('checkout/order');
	
	$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('variable_pay_order_status_id'));
	}
}
?>