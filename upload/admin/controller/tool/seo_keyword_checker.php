<?php
class ControllerToolSeoKeywordChecker extends Controller {
	private $error = array();
	private $duplicates = array();
	private $validItemTypes = array('product', 'category', 'manufacturer', 'information');
	
	public function index() {
		$route = explode("/", $this->request->get['route']);
		$this->data['tool'] = end($route);
		
		$this->load->language('tool/seo_keyword_checker');
			
		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['heading_title'] = $this->language->get('heading_title').sprintf($this->language->get('version'), $this->version);
		
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_updated'] = $this->language->get('text_updated');
		$this->data['text_deleted'] = $this->language->get('text_deleted');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_find_duplicates'] = $this->language->get('button_find_duplicates');
		$this->data['button_update'] = $this->language->get('button_update');
		$this->data['button_delete'] = $this->language->get('button_delete');
		
		$this->data['column_type'] = $this->language->get('column_type');
		$this->data['column_query'] = $this->language->get('column_query');
		$this->data['column_keyword'] = $this->language->get('column_keyword');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['error_unexpected_error'] = $this->language->get('error_unexpected_error');
		
		
		/* warning */
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		/* breadcrumbs */
		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/seo_keyword_checker', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		
		$this->data['action'] = $this->url->link('tool/seo_keyword_checker', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['searchForDuplicatesUrl'] = $this->url->link('tool/seo_keyword_checker/searchForDuplicates', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['duplicateDeleteUrl'] = $this->url->link('tool/seo_keyword_checker/delete', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['duplicateUpdateUrl'] = $this->url->link('tool/seo_keyword_checker/update', 'token=' . $this->session->data['token'], 'SSL');
		
		
		$this->template = 'tool/seo_keyword_checker.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/seo_keyword_checker')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function searchForDuplicates() {
		$json = array();
		
		$this->load->language('tool/seo_keyword_checker');
		$this->load->model('tool/seo_keyword_checker');
		
		$duplicates = $this->model_tool_seo_keyword_checker->getDuplicates();
		if (sizeof($duplicates)>0) {
			$json['error'] = $this->language->get('error_duplicates_found');
			foreach($duplicates as $i => $duplicate) {
				$typeArray = explode('=', $duplicate['query']);
				$typeArrayParts = explode('_', $typeArray[0]);
				
				$itemName = '';
				if (in_array($typeArrayParts[0], $this->validItemTypes)) {
					$type = $this->language->get('text_'.$typeArrayParts[0]);
					$itemName = $this->model_tool_seo_keyword_checker->getItemName($typeArrayParts[0], $typeArray[0], $typeArray[1]);
				} else {
					//$type = $this->language->get('text_unsupported_type');
					$type = $this->language->get('text_unknown_type');
				}
				
				$this->duplicates[] = array(
					'url_alias_id'    => $duplicate['url_alias_id'],
					'query'           => $duplicate['query'],
					'keyword'         => $duplicate['keyword'],
					'type'            => $type,
					'itemName'        => $itemName,
				);
			}
			$json['duplicates'] = $this->duplicates;
		} else {
			$json['success'] = $this->language->get('success_no_duplicates');
		}
		
		/* set output */
		$this->response->setOutput(json_encode($json));
	}
	
	/* url_alias updating */
	public function update() {
		$json = array();
		
		$this->load->language('tool/seo_keyword_checker');
		if (isset($this->request->post['url_alias_id']) && ($this->request->post['url_alias_id'] > 0)) {
			if (isset($this->request->post['keyword']) && !empty($this->request->post['keyword'])) {
				$this->load->model('tool/seo_keyword_checker');
				
				$keywordIsAvailable = $this->model_tool_seo_keyword_checker->keywordIsAvailable($this->request->post['keyword']);
				if ($keywordIsAvailable) {
					if ($this->model_tool_seo_keyword_checker->updateUrlAliasById($this->request->post['url_alias_id'], $this->request->post['keyword'])) {
						$json['success'] = $this->language->get('text_updated');
					} else {
						$json['error'] = $this->language->get('error_update_error');
					}
				} else {
					$json['error'] = $this->language->get('error_keyword_taken');
				}
			} else {
				$json['error'] = $this->language->get('error_update_no_keyword');
			}
		} else {
			$json['error'] = $this->language->get('error_no_url_alias_id');
		}
		
		/* set output */
		$this->response->setOutput(json_encode($json));
	}
	
	/* url_alias deletion */
	public function delete() {
		$json = array();
		
		$this->load->language('tool/seo_keyword_checker');
		if (isset($this->request->post['url_alias_id']) && ($this->request->post['url_alias_id'] > 0)) {
			$this->load->model('tool/seo_keyword_checker');
			if ($this->model_tool_seo_keyword_checker->deleteUrlAliasById($this->request->post['url_alias_id'])) {
				$json['success'] = $this->language->get('text_deleted');
			} else {
				$json['error'] = $this->language->get('error_url_alias_delete_error');
			}
		} else {
			$json['error'] = $this->language->get('error_no_url_alias_id');
		}
		
		/* set output */
		$this->response->setOutput(json_encode($json));
	}
	
	
	
	public function getCurrentVersion() {
		return $this->version;
	}
}
?>