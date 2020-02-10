<?php
class ModelCatalogCareer extends Model {
	public function addCareer($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "career SET type = '" . $this->db->escape($data['type']) . "', publish_date = '" . $this->db->escape($data['publish_date']) . "', country_id = '" . (int)($data['country_id']) . "', zone_id = '" . $this->db->escape($data['zone_id']) . "', num_of_position = '" . (int)$data['num_of_position'] . "', contact_person = '" . $this->db->escape($data['contact_person']) . "',address = '" . $this->db->escape($data['address']) . "', phone = '" . $this->db->escape($data['phone']) . "',sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
		
		$career_id = $this->db->getLastId();
		
		foreach ($data['career_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "career_description SET career_id = '" . (int)$career_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', min_requirement = '" . $this->db->escape($value['min_requirement']) . "', walkin_timing = '" . $this->db->escape($value['walkin_timing']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		if (isset($data['career_store'])) {
			foreach ($data['career_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "career_to_store SET career_id = '" . (int)$career_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['career_layout'])) {
			foreach ($data['career_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "career_to_layout SET career_id = '" . (int)$career_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
			
	}
	
	public function editCareer($career_id, $data) {
		
		$this->db->query("UPDATE " . DB_PREFIX . "career SET type = '" . $this->db->escape($data['type']) . "', publish_date = '" . $this->db->escape($data['publish_date']) . "', country_id = '" . (int)($data['country_id']) . "', zone_id = '" . $this->db->escape($data['zone_id']) . "', num_of_position = '" . (int)$data['num_of_position'] . "', contact_person = '" . $this->db->escape($data['contact_person']) . "',address = '" . $this->db->escape($data['address']) . "', phone = '" . $this->db->escape($data['phone']) . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE career_id = '" . (int)$career_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "career_description WHERE career_id = '" . (int)$career_id . "'");

		foreach ($data['career_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "career_description SET career_id = '" . (int)$career_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', min_requirement = '" . $this->db->escape($value['min_requirement']) . "', walkin_timing = '" . $this->db->escape($value['walkin_timing']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "career_to_store WHERE career_id = '" . (int)$career_id . "'");
		
		if (isset($data['career_store'])) {		
			foreach ($data['career_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "career_to_store SET career_id = '" . (int)$career_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "career_to_layout WHERE career_id = '" . (int)$career_id . "'");

		if (isset($data['career_layout'])) {
			foreach ($data['career_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "career_to_layout SET career_id = '" . (int)$career_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
		
	}
	
	public function deleteCareer($career_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "career WHERE career_id = '" . (int)$career_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "career_description WHERE career_id = '" . (int)$career_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "career_to_store WHERE career_id = '" . (int)$career_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "career_to_layout WHERE career_id = '" . (int)$career_id . "'");
		
	}

public function getCareer($career_id) {
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "career c LEFT JOIN " . DB_PREFIX . "career_description cd ON (c.career_id = cd.career_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.career_id = '" . (int)$career_id . "'");
		
		return $query->row;
	} 
	
	public function getCareers() {
		
		$query = $this->db->query("SELECT *, (SELECT count(a.applicant_id) FROM " . DB_PREFIX . "career_applicant a WHERE c.career_id  = a.career_id) AS applicant FROM " . DB_PREFIX . "career c LEFT JOIN " . DB_PREFIX . "career_description cd ON (c.career_id = cd.career_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.title ASC");
		
		return $query->rows;
	}
	
	public function getCareerDescriptions($career_id) {
		$career_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "career_description WHERE career_id = '" . (int)$career_id . "'");
		
		foreach ($query->rows as $result) {
			$career_description_data[$result['language_id']] = array(
				'title'             => $result['title'],
				'min_requirement'     => $result['min_requirement'],
				'walkin_timing' => $result['walkin_timing'],
				'description'      => $result['description']
			);
		}
		
		return $career_description_data;
	}	
	
	public function getCareerStores($career_id) {
		$career_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "career_to_store WHERE career_id = '" . (int)$career_id . "'");

		foreach ($query->rows as $result) {
			$career_store_data[] = $result['store_id'];
		}
		
		return $career_store_data;
	}

	public function getCareerLayouts($career_id) {
		$career_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "career_to_layout WHERE career_id = '" . (int)$career_id . "'");
		
		foreach ($query->rows as $result) {
			$career_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $career_layout_data;
	}
		
	public function getTotalCareers() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "career");
		
		return $query->row['total'];
	}	
		
	public function getTotalCareersByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "career WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}

	public function getTotalCareersByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "career_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
	
	public function deleteCareerApplicant($applicant_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "career_applicant WHERE applicant_id = '" . (int)$applicant_id . "'");
	}
	
	public function getTotalCareersAwatingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "career WHERE status = '0'");
		
		return $query->row['total'];
	}	


	public function getCareerApplicants($career_id, $data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "career_applicant WHERE career_id = '" . $career_id . "'";

		$sort_data = array(
			'name',
			'status',
			'date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY date_added";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
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
	
	public function getTotalCareerApplicants($career_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "career_applicant WHERE career_id = '" . $career_id . "'");
		
		return $query->row['total'];
	}
}
?>