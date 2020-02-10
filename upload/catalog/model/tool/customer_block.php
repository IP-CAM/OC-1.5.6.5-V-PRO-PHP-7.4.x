<?php
class ModelToolCustomerBlock extends Model {
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
			// osetreni pro velikosti pismen v e-mailu (zaznam v DB i email porovnava jako mala pismana)
      $implode[] = " LCASE(cb.block_value) = '" . strtolower( $this->db->escape($data['block_value']) ) . "'";
		}
																																						  
		if (isset($data['status']) && !is_null($data['status'])) {
			$implode[] = "cb.status = '" . $this->db->escape($data['status']) . "'";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'cb.customer_block_id',
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY cb.customer_block_id";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " DESC";
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
}
?>