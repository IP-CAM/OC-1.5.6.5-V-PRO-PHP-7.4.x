<?php

/**
 * Description templates module
 * 
 * @author AnRe //developer.lt//
 *
 */
class ModelModuleDescTemplate extends Model {
	
	public function install() {
		//
		// Create desc_templates table
		//
		$insertSql = "CREATE TABLE `" . DB_PREFIX . "product_desc_templates` ("
		  				."`template_id` int(11) NOT NULL AUTO_INCREMENT,"
		  				."`template_name` varchar(100) NOT NULL,"
		  				."`template_body` text COLLATE utf8_bin NOT NULL,"
		  				."`template_status` tinyint(1) NOT NULL DEFAULT 1,"
		  				."`language_id` int(11),"
		  				."PRIMARY KEY (`template_id`)"
	  				.") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
		
  		$this->db->query($insertSql);
	}
	
	public function uninstall() {
		$this->db->query("DROP TABLE `" . DB_PREFIX . "product_desc_templates`");
	}
	
	/**
	 * Returns templates data
	 * 
	 * @param [mixed] $status - template status. may be anything castable to boolean type. if cast result will result FALSE - all templates will be shown; if TRUE - only enabled
	 * 
	 * @return [object] query result object - all templates data
	 */
	public function getTemplates($status = null) {
		$result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_desc_templates`" . (!$status ? "" : " WHERE template_status <> 0") . " ORDER BY template_name ASC");
		return $result;
	}
	
	/**
	 * Returns template data by its ID
	 * 
	 * @param [int] $template_id - template ID
	 * @return [array] template data
	 */
	public function getTemplateById($template_id) {
		$result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_desc_templates` WHERE template_id = " . (int)$template_id);
		return $result->num_rows ? $result->row : null;
	}
	
	/**
	 * Updates template data
	 * 
	 * @param [int]		$template_id - template id
	 * @param [array] 	$data		 - updated data
	 */
	public function updateTemplate($template_id, $data) {
		$query = "UPDATE " . DB_PREFIX . "product_desc_templates SET template_id = " . (int)$template_id;
		$query .= ", template_name = '" . $this->db->escape($data['template_name']) . "'";
		$query .= ", template_body = '" . $this->db->escape($data['template_body']) . "'";
		$query .= ", template_status = " . ((int)$data['template_status'] == 0 ? 0 : 1);
		$query .= " WHERE template_id = " . (int)$template_id;
		
		$this->db->query($query);
	}
	
	/**
	 * Creates new template
	 * 
	 * @param [array] $data - new template data
	 * @return [int] created template ID
	 */
	public function createTemplate($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_desc_templates (template_name, template_body, template_status) VALUES ('" . $this->db->escape($data['template_name']) . "', '" . $this->db->escape($data['template_body']) . "', " . ((int)$data['template_status'] == 0 ? 0 : 1) . ")");
		return $this->db->getLastId();
	}
	
	/**
	 * Deletes template
	 * 
	 * @param [int] $template_id - template id to remove
	 */
	public function deleteTemplate($template_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_desc_templates WHERE template_id = " . (int)$template_id);
	}
}

?>