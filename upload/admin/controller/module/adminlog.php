<?php
class ControllerModuleAdminLog extends Controller {
	private $error = array();

	public function install(){
		$this->load->model('module/adminlog');
		$this->model_module_adminlog->install();
	}

	public function uninstall(){
		$this->load->model('module/adminlog');
		$this->model_module_adminlog->uninstall();
	}

	public function index() {
		$this->load->language('module/adminlog');
		$this->load->model('module/adminlog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if(!empty($this->request->post['clear'])){
				if (isset($this->request->post['selected'])) {
					foreach ($this->request->post['selected'] as $entry) {
						$this->model_module_adminlog->deleteEntry($entry);
	  				}
	  				$this->model_module_adminlog->deleteEntryLog($this->user->getId(), $this->user->getUserName(), count($this->request->post['selected']));
	  			}else{
					$this->model_module_adminlog->clearDataBaseLog($this->user->getId(), $this->user->getUserName());
				}
			}else{
				$this->model_setting_setting->editSetting('adminlog', $this->request->post);
            }
			$this->session->data['success'] = $this->language->get('text_success');

			if( !empty($this->request->post['stay']) ){
				$this->redirect($this->url->link('module/adminlog', 'token=' . $this->session->data['token'], 'SSL'));
			}else{
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		if(isset($this->session->data['success'])){
			$this->data['success'] =  $this->session->data['success'];
			unset($this->session->data['success']);
		}
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['tab_log'] = $this->language->get('tab_log');
		$this->data['tab_settings'] = $this->language->get('tab_settings');
		$this->data['tab_help'] = $this->language->get('tab_help');

		$this->data['text_description'] = $this->language->get('text_description');
		$this->data['text_help'] = $this->language->get('text_help');

		$this->data['button_save_go'] = $this->language->get('button_save_go');
		$this->data['button_save_stay'] = $this->language->get('button_save_stay');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['text_no_results'] = $this->language->get('text_no_results');


		// DataBase Log Tab
		$this->document->addStyle('view/stylesheet/adminlog.css');
		$this->data['button_clear_go'] = $this->language->get('button_clear_go');
		$this->data['button_clear_stay'] = $this->language->get('button_clear_stay');

		$this->data['column_user'] = $this->language->get('column_user');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_allowed'] = $this->language->get('column_allowed');
		$this->data['column_url'] = $this->language->get('column_url');
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_date'] = $this->language->get('column_date');

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$this->data['entries'] = array();

		$data = array(
			'start'           => ($page - 1) * $this->config->get('adminlog_display'),
			'limit'           => $this->config->get('adminlog_display')
		);

		$entries_total = $this->model_module_adminlog->getTotalDataBaseLog($data);
  		$entries = $this->model_module_adminlog->getDataBaseLog($data);

		foreach ($entries as $entry) {
			$entryUrl = preg_replace("/&token=[a-z0-9]+/", "", htmlspecialchars_decode($entry['url']));

      		$this->data['entries'][] = array(
      			'log_id'	=> $entry['log_id'],
      			'user'		=> $this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $entry['user_id'], 'SSL'),
      			'user_name'	=> $entry['user_name'],
				'action'	=> $entry['action'],
				'allowed'	=> $entry['allowed'],
				'url_link'	=> $entryUrl.'&token=' . $this->session->data['token'],
				'url'		=> $entryUrl,
				'ip'		=> $entry['ip'],
				'date'		=> $entry['date'],
			);
    	}

		$pagination = new Pagination();
		$pagination->total = $entries_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('adminlog_display');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/adminlog', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();


		// Settings tab
		$this->data['entry_adminlog_enable'] = $this->language->get('entry_adminlog_enable');
		$this->data['entry_adminlog_login'] = $this->language->get('entry_adminlog_login');
		$this->data['entry_adminlog_logout'] = $this->language->get('entry_adminlog_logout');
		$this->data['entry_adminlog_hacklog'] = $this->language->get('entry_adminlog_hacklog');
		$this->data['entry_adminlog_access'] = $this->language->get('entry_adminlog_access');
		$this->data['entry_adminlog_modify'] = $this->language->get('entry_adminlog_modify');
		$this->data['entry_adminlog_allowed'] = $this->language->get('entry_adminlog_allowed');
		$this->data['entry_adminlog_display'] = $this->language->get('entry_adminlog_display');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['text_denied'] = $this->language->get('text_denied');
		$this->data['text_allowed'] = $this->language->get('text_allowed');
		$this->data['text_all'] = $this->language->get('text_all');

		// Variables
		if (isset($this->request->post['adminlog_enable'])) {
			$this->data['adminlog_enable'] = $this->request->post['adminlog_enable'];
		} elseif ($this->config->get('adminlog_enable')) {
			$this->data['adminlog_enable'] = $this->config->get('adminlog_enable');
		} else {
			$this->data['adminlog_enable'] = 0;
		}

		if (isset($this->request->post['adminlog_login'])) {
			$this->data['adminlog_login'] = $this->request->post['adminlog_login'];
		} elseif ($this->config->get('adminlog_login')) {
			$this->data['adminlog_login'] = $this->config->get('adminlog_login');
		} else {
			$this->data['adminlog_login'] = 0;
		}

		if (isset($this->request->post['adminlog_logout'])) {
			$this->data['adminlog_logout'] = $this->request->post['adminlog_logout'];
		} elseif ($this->config->get('adminlog_logout')) {
			$this->data['adminlog_logout'] = $this->config->get('adminlog_logout');
		} else {
			$this->data['adminlog_logout'] = 0;
		}

		if (isset($this->request->post['adminlog_hacklog'])) {
			$this->data['adminlog_hacklog'] = $this->request->post['adminlog_hacklog'];
		} elseif ($this->config->get('adminlog_hacklog')) {
			$this->data['adminlog_hacklog'] = $this->config->get('adminlog_hacklog');
		} else {
			$this->data['adminlog_hacklog'] = 0;
		}

		if (isset($this->request->post['adminlog_access'])) {
			$this->data['adminlog_access'] = $this->request->post['adminlog_access'];
		} elseif ($this->config->get('adminlog_access')) {
			$this->data['adminlog_access'] = $this->config->get('adminlog_access');
		} else {
			$this->data['adminlog_access'] = 0;
		}

		if (isset($this->request->post['adminlog_modify'])) {
			$this->data['adminlog_modify'] = $this->request->post['adminlog_modify'];
		} elseif ($this->config->get('adminlog_modify')) {
			$this->data['adminlog_modify'] = $this->config->get('adminlog_modify');
		} else {
			$this->data['adminlog_modify'] = 0;
		}

		if (isset($this->request->post['adminlog_allowed'])) {
			$this->data['adminlog_allowed'] = $this->request->post['adminlog_allowed'];
		} elseif ($this->config->get('adminlog_allowed')) {
			$this->data['adminlog_allowed'] = $this->config->get('adminlog_allowed');
		} else {
			$this->data['adminlog_allowed'] = 2;
		}

		if (isset($this->request->post['adminlog_display'])) {
			$this->data['adminlog_display'] = $this->request->post['adminlog_display'];
		} elseif ($this->config->get('adminlog_display')) {
			$this->data['adminlog_display'] = $this->config->get('adminlog_display');
		} else {
			$this->data['adminlog_display'] = 50;
		}


		//============================================

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
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/adminlog', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('module/adminlog', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');


		$this->template = 'module/adminlog.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/adminlog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>