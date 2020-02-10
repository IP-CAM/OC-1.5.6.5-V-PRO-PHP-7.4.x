<?php
class ModelModuleCurrencyUpdate extends Model {
	
	protected $log_instance;
	
	public function __construct($registry) {
		parent::__construct($registry);
		
		$this->log_instance = new Log('currency_update.log');
	}
	
	public function update($force = false) {
		
		if ($this->config->get('module_currency_update_status') == 0) {
			return false;
		}

		if ($this->config->get('module_currency_update_autoupdate') == 1 || $force) {
			
			$comission = $this->config->get('module_currency_update_comission') > 0 ? (float) $this->config->get('module_currency_update_comission') / 100 : false;
			$base_currency = $this->config->get('config_currency');
			
			$sql = "SELECT * FROM " . DB_PREFIX . "currency WHERE code != '" . $this->db->escape($this->config->get('config_currency')) . "'";
		
			if (!$force) {
				$sql .= " AND date_modified < '" .  $this->db->escape(date('Y-m-d H:i:s', strtotime('-1 day'))) . "'";
			}
			
			$query = $this->db->query($sql);
			
			$currency_codes = array();

			foreach ($query->rows as $result) {
				$currency_codes[] = $result['code'];
			}
			
					
			// alphavantage.co
			if ($this->config->get('module_currency_update_source') == 'alphavantage.co') {
				
				$api_key = $this->config->get('module_currency_update_alphavantage_api_key');
				
				foreach ($currency_codes as $code) {
					$response = $this->curlRequest('https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency='.$base_currency.'&to_currency='.$code.'&apikey='.$api_key);
					
					if ($response) {
						$json = json_decode($response);
						
						$value = (float) $json->{"Realtime Currency Exchange Rate"}->{"5. Exchange Rate"};
						$value = $comission ? $value + ($value * $comission) : $value;
						$this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '" . $this->db->escape($value) . "', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($code) . "'");

					} else {
						return false;
					}
				}
				
				$this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '1.00000', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($base_currency) . "'");
			
			$this->cache->delete('currency');
			
			return true;
		}
	}
		}
	private function curlRequest($url, $options = array()) {
		
		$this->log('Curl init : '.$url);
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		
		if (curl_error($ch)) {
			$this->log('Curl error : '.curl_error($ch));
			return false;
		}
		
		if (in_array($info['http_code'], array(401,403,404))) {
			$this->log('Curl error : '.$info['http_code'].' header status');
			return false;
		}
		
		return $result;
	}
	
	private function log($str) {
		if ($this->config->get('module_currency_update_debug') == 1) {
			$this->log_instance->write($str);
		}
	}
}