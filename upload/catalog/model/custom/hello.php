<?php
class ModelCustomHello extends Model
{
    public function HelloWorld()
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "category_description"; 
        $implode = array();
        $query = $this->db->query($sql);
        return $query->rows;    
    }
}
?>