<?php
class ModelSaleCustomerBlock extends Model {
	public function getCustomerBlock($customer_block_id) {
		$sql = "
			SELECT
				  cb.customer_block_id
				, cb.block_type
				, cb.block_value
				, cb.note
				, cb.status
				, cb.date_added
			FROM " . DB_PREFIX . "customer_block cb
			WHERE 
				cb.customer_block_id = '" . (int)$this->db->escape($customer_block_id) . "'
		";																																					  
		$query = $this->db->query($sql);																																				
		return $query->row;	
	}
	public function getCustomerBlocks($data = array()) {
		$sql = "
			SELECT
				  cb.customer_block_id
				, cb.block_type
				, cb.block_value
				, cb.note
				, cb.status
				, cb.date_added
			FROM " . DB_PREFIX . "customer_block cb				
		";		
		$implode = array();																																			  
		if (isset($data['block_type']) && !is_null($data['block_type'])) {
			$implode[] = "cb.block_type = '" . $this->db->escape($data['block_type']) . "'";
		}
		if (isset($data['block_value']) && !is_null($data['block_value'])) {
			$implode[] = "cb.block_value = '" . $this->db->escape($data['block_value']) . "'";
		}
		
		if (!empty($implode)) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		
		$sort_data = array(
			'cb.customer_block_id',
			'cb.block_type',
			'cb.block_value',
			'cb.note',
			'cb.date_added',
			'cb.status',
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY cb.customer_block_id";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

    // second ORDER BY
    if (isset($data['sort']) AND isset($data['order'])) {
      switch ($data['sort']) {
        case "cb.block_type":
          $sql .= ", cb.block_value " . $data['order']; 
          break; 
        case "cb.block_value":
          $sql .= ", cb.block_type " . $data['order']; 
          break;
        case "cb.status":
          $sql .= ", cb.block_value ASC"; 
          break;                    
      } // switch
    } // if
		
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
	
	public function getTotalCustomerBlocks($data = array()) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_block");
		
		return $query->row['total'];
	}
	
	public function addCustomerBlock($data) {
		$this->db->query("
			INSERT INTO " . DB_PREFIX . "customer_block 
			SET
				block_type = '" . $this->db->escape($data['block_type']) . "', 
				block_value = '" . $this->db->escape($data['block_value']) . "', 
				note = '" . $this->db->escape(strip_tags($data['note'])) . "', 
				status = '" . $this->db->escape(strip_tags($data['status'])) . "',
				date_added = NOW()
			
		");
	}
	
	public function editCustomerBlock($customer_block_id, $data) {
		$this->db->query("
			UPDATE " . DB_PREFIX . "customer_block 
			SET
				block_type = '" . $this->db->escape($data['block_type']) . "', 
				block_value = '" . $this->db->escape($data['block_value']) . "', 
				note = '" . $this->db->escape(strip_tags($data['note'])) . "', 
				status = '" . $this->db->escape(strip_tags($data['status'])) . "'
			WHERE 
				customer_block_id = '" . (int)$customer_block_id . "'
		");
	}
	
	public function deleteCustomerBlock($customer_block_id) {
		$this->db->query("
			DELETE FROM " . DB_PREFIX . "customer_block 
				WHERE customer_block_id = '" . (int)$customer_block_id . "'");
	}
	
}
?>