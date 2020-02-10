<?php
class ModelToolIpAdmin extends Model {
	public function addAdminWhitelist($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "admin_ip_whitelist` SET `ip` = '" . $this->db->escape($data['ip']) . "'");
	}
	
	public function editAdminWhitelist($admin_ip_whitelist_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "admin_ip_whitelist` SET `ip` = '" . $this->db->escape($data['ip']) . "' WHERE admin_ip_whitelist_id = '" . (int)$admin_ip_whitelist_id . "'");
	}
	
	public function deleteAdminWhitelist($admin_ip_whitelist_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "admin_ip_whitelist` WHERE admin_ip_whitelist_id = '" . (int)$admin_ip_whitelist_id . "'");
	}
	
	public function getAdminWhitelist($admin_ip_whitelist_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "admin_ip_whitelist` WHERE admin_ip_whitelist_id = '" . (int)$admin_ip_whitelist_id . "'");
	
		return $query->row;
	}
	
	public function getAdminWhitelists($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "admin_ip_whitelist`";
				
		$sql .= " ORDER BY `ip`";	
			
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
	
	public function getTotalAdminWhitelists($data = array()) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "admin_ip_whitelist`");
				 
		return $query->row['total'];
	}
}
?>