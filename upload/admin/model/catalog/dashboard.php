<?php
class ModelCatalogDashboard extends Model {
 public function getTotalSalesForDashboard($store_id) {
        $sql = '';
        $sql = "SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0'";
        if($store_id!="")
            $sql .= " AND store_id=$store_id";
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
   public function getPurchasedForDashboard($store_id) {
		$sql = "SELECT op.name, op.model, SUM(op.quantity) AS quantity, SUM(op.total + op.total * op.tax / 100) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)";
        if($store_id!="") 
            $sql .= " WHERE o.store_id=$store_id";

        $sql .= " GROUP BY op.model ORDER BY quantity DESC LIMIT 0, 5";

		$query = $this->db->query($sql);

		return $query->rows;
	}
    
} 
?>