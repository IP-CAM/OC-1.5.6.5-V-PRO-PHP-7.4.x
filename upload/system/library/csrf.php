<?php
final class Csrf {
	private $config;
	private $request;
	private $session;
	
	public function __construct($registry) {
		$this->config 		= $registry->get('config');
		$this->request 		= $registry->get('request');
		$this->session 		= $registry->get('session');
		
		if ($this->config->get('csrf_protection_enable') && $this->config->get('csrf_protection_frontend')) {
			$this->csrf_start(false);		
		}
	}
	
	private function csrf_start($use_show_error = false) {
		$this->csrf_check($use_show_error);
		$this->csrf_rewrite();
	}

	public function csrf_rewrite() {
		global $nocsrfrewrite;
		if (!isset($nocsrfrewrite)) {
			$this->csrf_token();			
		}
	}
	
	public function csrf_form_input() {
		$token = $this->csrf_token();
		$csrf_protection_name = $this->config->get('csrf_protection_name');
		$endslash = ($this->config->get('csrf_protection_xhtml')) ? ' /' : '';
		return "<input type=\"hidden\" name=\"" . $csrf_protection_name . "\" value=\"" . $token . "\"" . $endslash . ">\n";
	}

	public function csrf_token() {				
		static $token;
				
		$csrf_protection_name = $this->config->get('csrf_protection_name');

		if (!$token) {
			$token = md5(uniqid(mt_rand(), true));
			$session = (isset($this->session->data[$csrf_protection_name])) ? $this->session->data[$csrf_protection_name] : '__csrf';
			if (!is_array($session)) {
				$session = array();
			}
			$session[$token] = time();
			$this->session->data[$csrf_protection_name] = $session;
		}
			return $token;
	}

	private function csrf_check($use_show_error = false) {
		if ($this->request->server['REQUEST_METHOD'] !== 'POST') {				
			return;
		}
		
		$csrf_protection_name = $this->config->get('csrf_protection_name');								
		if (isset($this->request->post[$csrf_protection_name])) {
			$session = $this->session->data[$csrf_protection_name];
			if (!is_array($session)) {
				return false;
			}

			$found = false;					
					
			$csrf_protection_expires = $this->config->get('csrf_protection_expires');

			foreach ($session as $token => $time) {
				if (!$this->secure_compare($token, (string)$this->request->post[$csrf_protection_name])) {
					continue;
				}

				if ($csrf_protection_expires) {
					if (time() <= $time + $csrf_protection_expires) {
						$found = true;
					} else {
						unset($session[$token]);
					}
				} else {
					$found = true;
				}
					break;
			}
				
			$this->session->data[$csrf_protection_name] = $session;
				if ($found) {
				return;
			}
		}
		header($this->request->server['SERVER_PROTOCOL'] . ' 403 Forbidden');
		echo "<html><head><title>CSRF check failed</title></head><body>CSRF check failed.</body></html>";
		exit;				
	}
			
	private function secure_compare($a, $b) {
	  if (strlen($a) !== strlen($b)) {
		return false;
	  }
	  $result = 0;
	  for ($i = 0; $i < strlen($a); $i++) {
		$result |= ord($a[$i]) ^ ord($b[$i]);
	  }
	  return $result == 0;
	}
}
?>