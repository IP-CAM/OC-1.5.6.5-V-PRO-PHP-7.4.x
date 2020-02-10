<?php
class ModelModuleRedirect extends Model {
	private $current_url;
	private $tracking;
	private $exception;

	public function __construct($registry) {
		parent::__construct($registry);
		
		$this->current_url = $this->getCurrentUrl();
		$this->exception = false;
		$exceptions = explode("\n", str_replace(array("\r\n", "\r", "\n"), "\n", trim($this->config->get('redirect_exceptions'))));

		foreach($exceptions as $exception_keyword) {
			if (stripos($this->current_url, $exception_keyword) !== false) {
				$this->exception = true;
				break;
			}
		}

		$config = $this->config->get('redirect_config');		
		
		if (is_array($config)) {
			$this->tracking = $config['tracking'];
		} else {
			$this->tracking = 0;
		}		
	}

	private function validateUrl($url) {
		if (!empty($url)) {

			preg_match('/^((?<sheme>[^:\/?#]+):)?(\/\/(?<host>[^\/?#]*))?(?<path>[^?#]*)(\?(?<query>[^#]*))?(#(?<fragment>.*))?/', html_entity_decode($url, ENT_COMPAT, 'UTF-8'), $url_info);
			
			$path_data = array_map('urlencode', explode('/', $url_info['path']));
			
			$url_info['path'] = implode('/', $path_data);
			
			$url = $url_info['sheme'] . '://' . $url_info['host'] . $url_info['path'];
			
			if (!empty($url_info['query'])) {
				$data = explode('&', $url_info['query']);
				
				$query = '';
				
				foreach ($data as $query_string) {
					$query_string_param = explode('=', $query_string);
					
					$query_string_param_path = array_map('urlencode', explode('/', $query_string_param[0]));
					
					$query .= '&' . implode('/', $query_string_param_path);
					
					if (isset($query_string_param[1])) {
						$query_string_param_path = array_map('urlencode', explode('/', $query_string_param[1]));
						
						$query .= '=' . implode('/', $query_string_param_path);
					}
				}
				
				if ($query) {
					$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
				}
				
				$url .= $query;
			}
			
			if (!empty($url_info['fragment'])) {
				$url .= '#' . $url_info['fragment'];
			}
		}
		return $url;
	}
	
	public function detect404Status() {
	
		if ($this->current_url) {
			$current_url = $this->current_url;
		} else {
			$current_url = $this->getCurrentUrl();
		}
	
		if ($this->tracking == '1' && !$this->exception) {	
			$referer = '';
			
			if (!empty($_SERVER['HTTP_REFERER'])) {
				$referer = $this->urlDecoded($_SERVER['HTTP_REFERER']);
			}
			
			$data = array(				
				'url' => $current_url,
				'referer' => $referer
			);
			
			$url_exists = $this->getUrlByName($current_url);

			if (!$url_exists) {
				$this->addUrl($data);
			}
		}
	}
	
	public function detect301Status() {
	
		if ($this->current_url) {
			$current_url = $this->current_url;
		} else {
			$current_url = $this->getCurrentUrl();
		}
	
		if ($this->tracking) {	
			$url_exists = $this->getUrlByName($current_url);

			if ($url_exists) {
				if ($url_exists['status'] && !empty($url_exists['new_url'])) {
					$url = $this->model_module_redirect->validateUrl($url_exists['new_url']);
					
					$this->redirect($url, 301);
				}
			}
		}
	}	

	private function getCurrentUrl() {
		$url = '';
		
		if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
			$url .= 'https://' . $_SERVER['SERVER_NAME'];
		} else {
			$url .= 'http://' . $_SERVER['SERVER_NAME'];
		}
		
		$url .= in_array( $_SERVER['SERVER_PORT'], array('80', '443') ) ? '' : ':' . $_SERVER['SERVER_PORT'];
		$url .= $_SERVER['REQUEST_URI'];
		
		return $this->urlDecoded($url);	
	}
		
	private function urlDecoded($url) {
		$url = str_replace('&amp;', '&', $url);
		
		return $this->request->clean(urldecode($url));
	}

	private function redirect($url, $status = 302) {
		header('Status: ' . $status);
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url));
		exit();				
	}	

	private function addUrl($data) {
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "redirect SET old_url = '" . $this->db->escape($data['url']) . "', referer = '" . $this->db->escape($data['referer']) . "', date_added = NOW()");
	}
	
	private function getUrlByName($url) {
	
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "redirect` WHERE old_url = '" . $this->db->escape($url) . "'");
	
		return $query->row;
	}
}
?>