<?php
class ModelMassPriceMassPrice extends Model {

public function updatePrice($percent = 0, $cats_id = 0, $date_available = null, $quantity = null, $sign = null, $substract_stock = null, $minimal_quantity) {

	$this->db->query("DELETE PS FROM " . DB_PREFIX . "product_special PS
		LEFT JOIN " . DB_PREFIX . "product_to_category PC ON PC.product_id = PS.product_id
		WHERE PC.category_id in(".$cats_id.")");
	
	
	
	if($cats_id && ($percent ||  $date_available || $quantity)) {
	
		$query = $this->db->query("SELECT P.product_id, P.price, P.quantity, P.date_available, P.subtract, P.minimum FROM " . DB_PREFIX . "product P
			 LEFT JOIN " . DB_PREFIX . "product_to_category PC ON P.product_id = PC.product_id
			 WHERE PC.category_id in(".$cats_id.")");
			 
		

		foreach ($query->rows as $result) {
		
			if($sign==1){
			
			$new_price= $result['price'] + (($result['price'] / 100) * $percent);
			
			} else {
			
			$new_price= $result['price'] - (($result['price'] / 100) * $percent);
			
			}

			$this->db->query("UPDATE " . DB_PREFIX . "product SET 
			".(($percent > 0 )?"`price` = '".(($new_price > 0)?$new_price:'0.01')."'":"")."
			".(($quantity > 0 )?",`quantity` = '".$quantity."'":"")."
			".(($date_available > 0 )?",`date_available` = '".$date_available."'":"")."
			".(($substract_stock < 9 )?",`subtract` = '".$substract_stock."'":"")."
			".(($minimal_quantity > 0 )?",`minimum` = '".$minimal_quantity."'":"")."
			WHERE  product_id = '".$result['product_id']."'");
			
			
			} 
		}
	}
}
?>