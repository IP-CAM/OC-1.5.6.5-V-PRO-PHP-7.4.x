<?php  
class ControllerModuleRedirect extends Controller {  
	private $error = array();
   
  	public function index() {
    	$this->language->load('module/redirect');

    	$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('module/redirect');
		
    	$this->getList();
  	}
	
  	public function exceptions() {
    	$this->language->load('module/redirect');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('module/redirect');
		
    	if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			
			$this->model_module_redirect->editSettingValue('redirect_module', 'redirect_exceptions', $this->request->post['exceptions']);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('module/redirect', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getExceptionForm();
  	}	
   
  	public function insert() {
    	$this->language->load('module/redirect');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('module/redirect');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_module_redirect->addUrl($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('module/redirect', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function delete() { 
    	$this->language->load('module/redirect');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('module/redirect');
		
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {
      		foreach($this->request->post['selected'] as $url_id) {
				$this->model_module_redirect->deleteUrl($url_id);	
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('module/redirect', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getList();
  	}

  	protected function getList() {

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'date_added';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}
			
		$url = '';
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->document->addStyle('view/stylesheet/redirect.css');
		$this->document->addScript('view/javascript/jquery/jquery.blockUI.custom.js');
					
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/redirect', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['text_tracking'] = $this->language->get('text_tracking');
		$this->data['save_redirects'] = $this->language->get('text_save_redirects');		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_save'] = $this->language->get('text_save');
		$this->data['button_apply'] = $this->language->get('button_apply');

			
		$this->data['insert'] = $this->url->link('module/redirect/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('module/redirect/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['exceptions'] = $this->url->link('module/redirect/exceptions', 'token=' . $this->session->data['token'] . $url, 'SSL');		
		
    	$this->data['redirects'] = array();
		
		$this->config->set('config_admin_limit', 20);

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$redirect_total = $this->model_module_redirect->getTotalUrls();
		
		$results = $this->model_module_redirect->getUrls($filter_data);
    	
		foreach ($results as $result) {
					
      		$this->data['redirects'][] = array(
				'url_id'    => $result['url_id'],
				'old_url'   => $result['old_url'],
				'old_valid_url' => $this->model_module_redirect->validateUrl($result['old_url']),
				'new_url'   => $result['new_url'],
				'referer'   => $result['referer'],
				'valid_referer' => $this->model_module_redirect->validateUrl($result['referer']),
				'status'     => $result['status'],
				'date_added' => $result['date_added'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['url_id'], $this->request->post['selected'])
			);
		}	
			
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_old_url'] = $this->language->get('column_old_url');
		$this->data['column_new_url'] = $this->language->get('column_new_url');
		$this->data['column_referer'] = $this->language->get('column_referer');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_exceptions'] = $this->language->get('text_exceptions');		
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];	
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$this->data['sort_status'] = $this->url->link('module/redirect', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('module/redirect', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		
		$config = $this->config->get('redirect_config');

		if (is_array($config)) {
			$this->data['tracking'] = $config['tracking'];
		} else {
			$this->data['tracking'] = 2;
		}
		
		$this->data['token'] = $this->session->data['token'];
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $redirect_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/redirect', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
								
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'module/redirect_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
  	}
	
	protected function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		
    	$this->data['entry_old_url'] = $this->language->get('entry_old_url');
    	$this->data['entry_new_url'] = $this->language->get('entry_new_url');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_apply'] = $this->language->get('button_apply');
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
    
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['url'])) {
			$this->data['error_url'] = $this->error['url'];
		} else {
			$this->data['error_url'] = array();
		}
		
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/redirect', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/redirect/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		  
    	$this->data['cancel'] = $this->url->link('module/redirect', 'token=' . $this->session->data['token'] . $url, 'SSL');

    	if (isset($this->request->get['url_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$url_info = $this->model_module_redirect->getUrl($this->request->get['url_id']);
    	}
		
		$this->data['urls'] = array();

    	if (isset($this->request->post['url']['old'])) {
      		$this->data['urls']['old'] = $this->request->post['url']['old'];
    	} elseif (!empty($url_info)) {
			$this->data['urls']['old'] = $url_info['old_url'];
		} else {
      		$this->data['urls']['old'] = '';
    	}
  
    	if (isset($this->request->post['url']['new'])) {
      		$this->data['urls']['new'] = $this->request->post['url']['new'];
    	} elseif (!empty($url_info)) {
			$this->data['urls']['new'] = $url_info['new_url'];
		} else {
      		$this->data['urls']['new'] = '';
    	}
 
     	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (!empty($url_info)) {
			$this->data['status'] = $url_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
		
		$this->template = 'module/redirect_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());	
  	}
	
	protected function getExceptionForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title_exception');
		
		$this->document->setTitle($this->language->get('heading_title_exception'));

		$this->data['heading_title'] = $this->language->get('heading_title_exception');
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
    	$this->data['entry_exceptions'] = $this->language->get('entry_exceptions');		
		
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/redirect', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_exceptions'),
			'href'      => $this->url->link('module/exceptions', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/redirect/exceptions', 'token=' . $this->session->data['token'] . $url, 'SSL');
		  
    	$this->data['cancel'] = $this->url->link('module/redirect', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$config = $this->model_module_redirect->getSetting('redirect_module');
		
		$this->data['exceptions'] = isset($this->request->post['exceptions']) ? $this->request->post['exceptions'] : $config['redirect_exceptions'];
		
		$this->template = 'module/redirect_exceptions.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());	
  	}
  	
  	protected function validateForm() {
    	if (!$this->user->hasPermission('modify', 'module/redirect')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
   
		foreach($this->request->post['url'] as $key => &$string) {
		    if (utf8_strlen(trim($string)) < 1 || utf8_strlen(trim($string)) > 2000) {
				$this->error['url'][$key] = $this->language->get('error_url');
			}	
			$string = $this->request->clean(str_replace('&amp;', '&', html_entity_decode($string, ENT_COMPAT, 'UTF-8')));
		}
		
		$url_info = $this->model_module_redirect->getUrlByName($this->request->post['url']['old']);
		
		if ($url_info) {
			$this->error['warning'] = $this->language->get('error_exists');
		}
	
    	return !$this->error;
  	}

  	protected function validateDelete() { 
    	if (!$this->user->hasPermission('modify', 'module/redirect')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	} 
		 
		return !$this->error;
  	}
	
	public function tracking() {
	
		$this->load->model('module/redirect');
	
		$json = array();
		
		if (isset($this->request->get['status'])) {
			
			$status = (int)$this->request->get['status'];
			
			$this->model_module_redirect->editSettingValue('redirect_module', 'redirect_config', array('tracking' => $status));
			
			$json['tracking'] = $status;
			
		} else {
		
			$json['tracking'] = '1';
		}
	
		$this->response->setOutput(json_encode($json));
	}
	
	public function save() {
	
		$this->load->model('module/redirect');
		$this->language->load('module/redirect');
	
		$json = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && (isset($this->request->post['url']) && is_array($this->request->post['url']))) {

			foreach($this->request->post['url'] as $url) {
			
				$this->model_module_redirect->editUrl($url);
			}
		
			$json['success'] = $this->language->get('text_success');
		} else {
			$json['error'] = $this->language->get('error_save');
		}
	
		$this->response->setOutput(json_encode($json));
	}	
	
	public function install() {
		$this->load->model('module/redirect');
		$this->model_module_redirect->createModuleData();
	}
	
	public function uninstall() {
		$this->load->model('module/redirect');
		$this->model_module_redirect->deleteModuleData();
	}
}
?>