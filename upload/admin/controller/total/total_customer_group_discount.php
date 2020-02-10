<?php
class ControllerTotalTotalCustomerGroupDiscount extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('total/total_customer_group_discount');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('total_customer_group_discount', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_help'] = $this->language->get('text_help');

		$this->data['entry_discount'] = $this->language->get('entry_discount');
		$this->data['entry_special'] = $this->language->get('entry_special');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_show'] = $this->language->get('entry_show');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_total'),
			'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('total/total_customer_group_discount', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('total/total_customer_group_discount', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('sale/customer_group');
		$customer_groups = $this->model_sale_customer_group->getCustomerGroups(array('sort' => 'cg.sort_order'));
		$discounts = $this->config->get('total_customer_group_discount_customer_group_id');

		foreach($customer_groups as $key => $group){
			if(isset($discounts[$group['customer_group_id']])){
				$customer_groups[$key]['discount'] = $discounts[$group['customer_group_id']];
			}else{
				$customer_groups[$key]['discount'] = 0;
			}
		}

		$this->data['customer_groups'] = $customer_groups;

		if (isset($this->request->post['total_customer_group_discount_special'])) {
			$this->data['total_customer_group_discount_special'] = $this->request->post['total_customer_group_discount_special'];
		} else {
			$this->data['total_customer_group_discount_special'] = $this->config->get('total_customer_group_discount_special');
		}

		if (isset($this->request->post['total_customer_group_discount_tax'])) {
			$this->data['total_customer_group_discount_tax'] = $this->request->post['total_customer_group_discount_tax'];
		} else {
			$this->data['total_customer_group_discount_tax'] = $this->config->get('total_customer_group_discount_tax');
		}

		if (isset($this->request->post['total_customer_group_discount_show'])) {
			$this->data['total_customer_group_discount_show'] = $this->request->post['total_customer_group_discount_show'];
		} else {
			$this->data['total_customer_group_discount_show'] = $this->config->get('total_customer_group_discount_show');
		}

		$this->data['total_customer_group_discount_show_vars'] = array(
			0 => $this->language->get('text_show_var0'),
			1 => $this->language->get('text_show_var1'),
			2 => $this->language->get('text_show_var2'),
		);

		if (isset($this->request->post['total_customer_group_discount_status'])) {
			$this->data['total_customer_group_discount_status'] = $this->request->post['total_customer_group_discount_status'];
		} else {
			$this->data['total_customer_group_discount_status'] = $this->config->get('total_customer_group_discount_status');
		}

		if (isset($this->request->post['total_customer_group_discount_sort_order'])) {
			$this->data['total_customer_group_discount_sort_order'] = $this->request->post['total_customer_group_discount_sort_order'];
		} else {
			$this->data['total_customer_group_discount_sort_order'] = $this->config->get('total_customer_group_discount_sort_order');
		}


		$this->template = 'total/total_customer_group_discount.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'total/total_customer_group_discount')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['total_customer_group_discount_sort_order']) < 1) {
			$this->error['warning'] = $this->language->get('error_order');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

}
?>