<?php
class ControllerModuleCurrencyUpdate extends Controller {
	
	private $error = array();
	
	public function __construct($registry) {
		parent::__construct($registry);
		
		$this->language->load('module/currency_update');
		
		//error_reporting(-1);
		//ini_set('display_errors', 1);
	}

	public function index() {

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_loading'] = $this->language->get('text_loading');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_source_alphavantage'] = $this->language->get('text_source_alphavantage');
		$this->data['text_alphavantage_api_key'] = $this->language->get('text_alphavantage_api_key');
		
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_source'] = $this->language->get('entry_source');
		$this->data['entry_autoupdate'] = $this->language->get('entry_autoupdate');
		$this->data['entry_comission'] = $this->language->get('entry_comission');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_alphavantage_api_key'] = $this->language->get('entry_alphavantage_api_key');
		
		$this->data['help_source'] = $this->language->get('help_source');
		$this->data['help_autoupdate'] = $this->language->get('help_autoupdate');
		$this->data['help_comission'] = $this->language->get('help_comission');
		$this->data['help_alphavantage_api_key'] = $this->language->get('help_alphavantage_api_key');
		
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_update'] = $this->language->get('button_update');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_currency_update', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['error_success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['error_success'] = '';
		}

		if (isset($this->session->data['warning'])) {
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['alphavantage_api_key'])) {
			$this->data['error_alphavantage_api_key'] = $this->error['alphavantage_api_key'];
		} else {
			$this->data['error_alphavantage_api_key'] = '';
		}
		
		if (isset($this->error['comission'])) {
			$this->data['error_comission'] = $this->error['comission'];
		} else {
			$this->data['error_comission'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/currency_update', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/currency_update', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['update'] = $this->url->link('module/currency_update/update', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['module_currency_update_autoupdate'])) {
			$this->data['module_currency_update_autoupdate'] = $this->request->post['module_currency_update_autoupdate'];
		} elseif ($this->config->get('module_currency_update_autoupdate')) {
			$this->data['module_currency_update_autoupdate'] = $this->config->get('module_currency_update_autoupdate');
		} else {
			$this->data['module_currency_update_autoupdate'] = 0;
		}
		
		if (isset($this->request->post['module_currency_update_source'])) {
			$this->data['module_currency_update_source'] = $this->request->post['module_currency_update_source'];
		} elseif ($this->config->get('module_currency_update_source')) {
			$this->data['module_currency_update_source'] = $this->config->get('module_currency_update_source');
		} else {
			$this->data['module_currency_update_source'] = 'fixer.io';
		}
		
		if (isset($this->request->post['module_currency_update_alphavantage_api_key'])) {
			$this->data['module_currency_update_alphavantage_api_key'] = $this->request->post['module_currency_update_alphavantage_api_key'];
		} elseif ($this->config->get('module_currency_update_alphavantage_api_key')) {
			$this->data['module_currency_update_alphavantage_api_key'] = $this->config->get('module_currency_update_alphavantage_api_key');
		} else {
			$this->data['module_currency_update_alphavantage_api_key'] = '';
		}
		
		if (isset($this->request->post['module_currency_update_comission'])) {
			$this->data['module_currency_update_comission'] = $this->request->post['module_currency_update_comission'];
		} elseif ($this->config->get('module_currency_update_comission')) {
			$this->data['module_currency_update_comission'] = $this->config->get('module_currency_update_comission');
		} else {
			$this->data['module_currency_update_comission'] = 0;
		}
		
		if (isset($this->request->post['module_currency_update_debug'])) {
			$this->data['module_currency_update_debug'] = $this->request->post['module_currency_update_debug'];
		} elseif ($this->config->get('module_currency_update_comission')) {
			$this->data['module_currency_update_debug'] = $this->config->get('module_currency_update_debug');
		} else {
			$this->data['module_currency_update_debug'] = 0;
		}
		
		if (isset($this->request->post['module_currency_update_status'])) {
			$this->data['module_currency_update_status'] = $this->request->post['module_currency_update_status'];
		} elseif ($this->config->get('module_currency_update_status')) {
			$this->data['module_currency_update_status'] = $this->config->get('module_currency_update_status');
		} else {
			$this->data['module_currency_update_status'] = 0;
		}
		
		$this->template = 'module/currency_update.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	
	public function update() {	
		$this->load->model('module/currency_update');
		$status = $this->model_module_currency_update->update(true);
		
		if ($status) {
			$this->session->data['success'] = $this->language->get('text_update_success');
		} else {
			$this->session->data['warning'] = $this->language->get('text_update_error');
		}
		
		$this->redirect($this->url->link('module/currency_update', 'token=' . $this->session->data['token'], 'SSL'));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/currency_update')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ($this->request->post['module_currency_update_source'] == 'alphavantage.co') {
			if (strlen($this->request->post['module_currency_update_alphavantage_api_key']) <= 0) {
				$this->error['alphavantage_api_key'] = $this->language->get('error_alphavantage_api_key');
			}
		}
		
		if (strlen($this->request->post['module_currency_update_comission']) > 0) {
			preg_match_all('/^(?:\d+|\d*\.\d+)$/', $this->request->post['module_currency_update_comission'], $matches, PREG_SET_ORDER, 0);
			if (empty($matches)) {
				$this->error['comission'] = $this->language->get('error_comission');
			}
		}

		return !$this->error;
	}
}