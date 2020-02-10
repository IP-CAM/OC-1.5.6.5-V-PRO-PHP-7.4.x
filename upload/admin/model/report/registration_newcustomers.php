<?php
class ModelReportRegistrationNewcustomers extends Model {

	// zjisti kraje registrovanych zakazniku
  public function getTotalRegister($data = array()) {
    
    $sql = "SELECT COUNT(customer_id) AS customers
            FROM `" . DB_PREFIX . "customer` ";
            
    if ( isset($data['filter_date_end']) ) {
      $sql .= " WHERE DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
    }
        
    $query = $this->db->query($sql);

		return $query->row['customers'];
  } // getTotalRegister

}
?>