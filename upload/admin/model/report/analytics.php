<?php
class ModelReportAnalytics extends Model {
	
	public function mostPopularDay($data = array()) {
		
		$sql = "select count(o.order_id) as order_placed, date(o.date_added) as date_placed FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id = '5'";

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND o.date_added >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND o.date_added <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql .= " group by date(o.date_added) order by order_placed desc limit 1";

		$query = $this->db->query($sql);
		
		return $query->row;	
	}

	public function mostPopularTime($data = array()) {
		
		$sql = "SELECT HOUR(o.date_added) as time_placed, count(o.order_id) as order_placed FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id = '5'";

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND o.date_added >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND o.date_added <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql .= " group by date(o.date_added) order by order_placed desc limit 1";

		$query = $this->db->query($sql);
		
		return $query->row;	
	}	
	
}
?>