<?php
class ModelOpenshopInfo extends Model {
    public function firstfunction() {

		//This is for just a demo purpose. 
        $sql = "SELECT x FROM `" . DB_PREFIX . "y`)"; 
        $implode = array();
        $query = $this->db->query($sql);
        return $query->row['total'];    
    }       
}
?>