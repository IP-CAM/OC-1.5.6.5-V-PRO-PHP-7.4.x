<?php
class ControllerExtensionNews extends Controller {
	private $error = array();
	
	public function index() {
		$this->language->load('extension/news');
		
		$this->load->model('extension/news');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$url = '';
		
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
			'href'      => $this->url->link('extension/news', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->error['warning'])) {
			$this->data['error'] = $this->error['warning'];
		
			unset($this->error['warning']);
		} else {
			$this->data['error'] = '';
		}
		
		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else { 
			$page = 1;
		}
		
		$url = '';
		
		$data = array(
			'page' => $page,
			'limit' => $this->config->get('config_admin_limit'),
			'start' => $this->config->get('config_admin_limit') * ($page - 1),
		);
		
		$total = $this->model_extension_news->getTotalNews();
		
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('extension/news', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_title'] = $this->language->get('text_title');
		$this->data['text_short_description'] = $this->language->get('text_short_description');
		$this->data['text_date'] = $this->language->get('text_date');
		$this->data['text_action'] = $this->language->get('text_action');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['insert'] = $this->url->link('extension/news/insert', '&token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('extension/news/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['all_news'] = array();
		
		$all_news = $this->model_extension_news->getAllNews($data);
		
		foreach ($all_news as $news) {
			$this->data['all_news'][] = array (
				'news_id' 			=> $news['news_id'],
				'title' 			=> $news['title'],
				'short_description'	=> $news['short_description'],
				'date_added' 		=> date($this->language->get('date_format_short'), strtotime($news['date_added'])),
				'edit' 				=> $this->url->link('extension/news/edit', 'news_id=' . $news['news_id'] . '&token=' . $this->session->data['token'] . $url, 'SSL')
			);
		}
		
		$this->template = 'extension/news_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());		
	}
	
	public function edit() {
		$this->language->load('extension/news');
		
		$this->load->model('extension/news');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_extension_news->editNews($this->request->get['news_id'], $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/news', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/news', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('extension/news/edit', '&news_id=' . $this->request->get['news_id'] . '&token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/news', '&token=' . $this->session->data['token'], 'SSL');
		
		$this->form();
	}
	
	public function insert() {
		$this->language->load('extension/news');
		
		$this->load->model('extension/news');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_extension_news->addNews($this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/news', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/news', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('extension/news/insert', '&token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/news', '&token=' . $this->session->data['token'], 'SSL');
		
		$this->form();
	}
	
	protected function form() {
		$this->language->load('extension/news');
		
		$this->load->model('extension/news');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_image'] = $this->language->get('text_image');
		$this->data['text_title'] = $this->language->get('text_title');
		$this->data['text_description'] = $this->language->get('text_description');
		$this->data['text_short_description'] = $this->language->get('text_short_description');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_keyword'] = $this->language->get('text_keyword');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_submit'] = $this->language->get('button_submit');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->error['warning'])) {
			$this->data['error'] = $this->error['warning'];
		} else {
			$this->data['error'] = '';
		}
		
		if (isset($this->request->get['news_id'])) {
			$news = $this->model_extension_news->getNews($this->request->get['news_id']);
		} else {
			$news = array();
		}
		
		if (isset($this->request->post['news'])) {
			$this->data['news'] = $this->request->post['news'];
		} elseif (!empty($news)) {
			$this->data['news'] = $this->model_extension_news->getNewsDescription($this->request->get['news_id']);
		} else {
			$this->data['news'] = '';
		}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($news)) {
			$this->data['image'] = $news['image'];
		} else {
			$this->data['image'] = '';
		}
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 500, 300);
		} elseif (!empty($news)) {
			$this->data['thumb'] = $this->model_tool_image->resize($news['image'] ? $news['image'] : 'no_image.jpg', 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($news)) {
			$this->data['keyword'] = $news['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($news)) {
			$this->data['status'] = $news['status'];
		} else {
			$this->data['status'] = '';
		}
		
		$this->template = 'extension/news_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	public function delete() {
		$this->language->load('extension/news');
		
		$this->load->model('extension/news');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_extension_news->deleteNews($news_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$this->redirect($this->url->link('extension/news', 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/news')) {
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