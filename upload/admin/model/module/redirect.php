<?php
class ModelModuleRedirect extends Model {

	public function validateUrl($url) {
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
	
	public function addUrl($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "redirect SET old_url = '" . $this->db->escape($data['url']['old']) . "', new_url = '" . $this->db->escape($data['url']['new']) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
	}
		
	public function editUrl($data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "redirect SET new_url = '" . $this->db->escape($data['link']) . "', status = '" . (int)$data['status'] . "' WHERE url_id = '" . (int)$data['id'] . "'");	
	}

	public function deleteUrl($url_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "redirect WHERE url_id = '" . (int)$url_id . "'");
	} 	
	
	public function getUrl($url_id) {
	
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "redirect` WHERE url_id = '" . (int)$url_id . "'");
		
		return $query->row;
	}

	public function getUrls($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "redirect`";
			
		$sort_data = array(
			'status',
			'date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY url_id";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			
			
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
			
		$query = $this->db->query($sql);
	
		return $query->rows;
	}

	public function getTotalUrls() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "redirect`");
		
		return $query->row['total'];
	}
	
	public function getUrlByName($old_url) {
	
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "redirect` WHERE old_url = '" . $this->db->escape($old_url) . "'");
	
		return $query->row;
	}
	
	public function editSetting($group, $data, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");

		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
			}
		}
	}
	
	public function deleteSetting($group, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
	}
	
	public function editSettingValue($group = '', $key = '', $value = '', $store_id = 0) {
		if (!is_array($value)) {
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape($value) . "' WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape(serialize($value)) . "' WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '" . (int)$store_id . "' AND serialized = '1'");
		}
	}

	public function getSetting($group, $store_id = 0) {
		$data = array(); 
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
		
		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = unserialize($result['value']);
			}
		}

		return $data;
	}

	public function createModuleData() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "redirect` (
		  `url_id` int(11) NOT NULL AUTO_INCREMENT,
		  `old_url` text NOT NULL,
		  `new_url` text NOT NULL,
		  `referer` text NOT NULL,
		  `status` tinyint(1) NOT NULL DEFAULT '0',
		  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		  PRIMARY KEY (`url_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;");
		
		$data = array(
			'redirect_config' => array(
				'tracking' => '1',
				),
			'redirect_exceptions' => ''
		);
		$this->editSetting('redirect_module', $data);
	}
	
	public function deleteModuleData() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "redirect`;");
		$this->deleteSetting('redirect_module');
	}
}
?>