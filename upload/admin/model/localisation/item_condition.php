<?php 
class ModelLocalisationItemCondition extends Model {
	public function addItemCondition($data) {
		foreach ($data['item_condition'] as $language_id => $value) {
			if (isset($item_condition_id)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "item_condition SET item_condition_id = '" . (int)$item_condition_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "item_condition SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
				
				$item_condition_id = $this->db->getLastId();
			}
		}
		
		$this->cache->delete('item_condition');
	}

	public function editItemCondition($item_condition_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "item_condition WHERE item_condition_id = '" . (int)$item_condition_id . "'");

		foreach ($data['item_condition'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "item_condition SET item_condition_id = '" . (int)$item_condition_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
				
		$this->cache->delete('item_condition');
	}
	
	public function deleteItemCondition($item_condition_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "item_condition WHERE item_condition_id = '" . (int)$item_condition_id . "'");
	
		$this->cache->delete('item_condition');
	}
		
	public function getItemCondition($item_condition_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item_condition WHERE item_condition_id = '" . (int)$item_condition_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getItemConditions($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "item_condition WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";
      		
			$sql .= " ORDER BY name";	
			
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
		} else {
			$item_condition_data = $this->cache->get('item_condition.' . (int)$this->config->get('config_language_id'));
		
			if (!$item_condition_data) {
				$query = $this->db->query("SELECT item_condition_id, name FROM " . DB_PREFIX . "item_condition WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");
	
				$item_condition_data = $query->rows;
			
				$this->cache->set('item_condition.' . (int)$this->config->get('config_language_id'), $item_condition_data);
			}	
	
			return $item_condition_data;			
		}
	}
	
	public function getItemConditionDescriptions($item_condition_id) {
		$item_condition_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "item_condition WHERE item_condition_id = '" . (int)$item_condition_id . "'");
		
		foreach ($query->rows as $result) {
			$item_condition_data[$result['language_id']] = array('name' => $result['name']);
		}
		
		return $item_condition_data;
	}
	
	public function getTotalItemConditions() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "item_condition WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row['total'];
	}	
}
?>