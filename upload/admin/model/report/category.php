<?php
class Modelreportcategory extends Model {
	
	public function getPurchased($data = array()) {
		$sql = "SELECT cd.name, ptc.category_id, op.model, SUM(op.quantity) AS quantity, SUM(op.total + op.total * op.tax / 100) AS total FROM " . DB_PREFIX . "category_description cd LEFT JOIN " . DB_PREFIX . "product_to_category ptc ON(cd.category_id = ptc.category_id) LEFT JOIN " . DB_PREFIX . "order_product op ON (ptc.product_id=op.product_id) LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)";

		$sql .= " WHERE o.order_status_id = '5'";

		if (!empty($data['filter_date_start'])) {
				if(empty($data['filter_time_start']))
					$sql .= " AND o.date_added >= '" . $this->db->escape($data['filter_date_start']) . "'";
				else
					$sql .= " AND o.date_added >= '" . $this->db->escape($data['filter_date_start']) .' '. $this->db->escape($data['filter_time_start']) ."'";
		}

		if (!empty($data['filter_date_end'])) {
			if(empty($data['filter_time_end']))
				$sql .= " AND o.date_added <= '" . $this->db->escape($data['filter_date_end']) . "'";
			else
				$sql .= " AND o.date_added <= '" . $this->db->escape($data['filter_date_end']) .' '. $this->db->escape($data['filter_time_end']) ."'";
		}

		$sql .= " GROUP BY cd.category_id ORDER BY total DESC";

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

	public function getTotalPurchased($data) {

		$sql = "SELECT cd.category_id AS total, cd.name, ptc.category_id, op.model, SUM(op.quantity) AS quantity FROM " . DB_PREFIX . "category_description cd LEFT JOIN " . DB_PREFIX . "product_to_category ptc ON(cd.category_id = ptc.category_id) LEFT JOIN " . DB_PREFIX . "order_product op ON (ptc.product_id=op.product_id) LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)";

		$sql .= " WHERE o.order_status_id = '5'";
		
		if (!empty($data['filter_date_start'])) {
			if(empty($data['filter_time_start']))
					$sql .= " AND o.date_added >= '" . $this->db->escape($data['filter_date_start']) . "'";
				else
					$sql .= " AND o.date_added >= '" . $this->db->escape($data['filter_date_start']) .' '. $this->db->escape($data['filter_time_start']) ."'";
		
		}

		if (!empty($data['filter_date_end'])) {
			if(empty($data['filter_time_end']))
				$sql .= " AND o.date_added <= '" . $this->db->escape($data['filter_date_end']) . "'";
			else
				$sql .= " AND o.date_added <= '" . $this->db->escape($data['filter_date_end']) .' '. $this->db->escape($data['filter_time_end']) ."'";
		
		}
		
		$sql .= " GROUP BY cd.category_id ORDER BY total DESC";

		$query = $this->db->query($sql);
		
		$total = count($query->rows);

		return $total;
	}
}
?>