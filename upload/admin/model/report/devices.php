<?php
class ModelReportDevices extends Model {

	// zjisti info o zarizeni
  public function getDeviceMobile($device = '', $data = array()) {
    
    // pocet objednavek, soucet castky
    $sql_data = "SELECT 
                  COUNT(order_id) AS orders_count,
                  SUM(total) AS orders_total              
                FROM `" . DB_PREFIX . "order`
                WHERE order_status_id > 0 
              ";

    // ID cisla objednavek
    $sql_o_id = "SELECT order_id              
                 FROM `" . DB_PREFIX . "order`
                 WHERE order_status_id > 0 
                ";

		if (!empty($data['filter_date_start'])) {
			$sql = " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
      $sql_data .= $sql;
      $sql_o_id .= $sql;
		}

		if (!empty($data['filter_date_end'])) {
			$sql = " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
      $sql_data .= $sql;
      $sql_o_id .= $sql;
		}

		if ($device != '') {
			$sql = " AND LCASE(user_agent) LIKE '%" . strtolower($device) . "%'";
      $sql_data .= $sql;
      $sql_o_id .= $sql;
		}
    
    $sql_o_id .= " ORDER BY order_id ASC ";
        
    $query_data = $this->db->query($sql_data);
    $query_o_id = $this->db->query($sql_o_id);
    
    $o_id = ( isset($query_o_id->rows) ? $query_o_id->rows : $query_o_id->row );
    $orders_id = array('orders_id' => '');
    foreach($o_id AS $key => $value) {
      $orders_id['orders_id'] .= ( strlen($orders_id['orders_id']) > 0 ? ', ' : ''); // castka pred IDckama
      $orders_id['orders_id'] .= $value['order_id']; // IDcko      
    }
    
		return array_merge($query_data->row, $orders_id);
  } // getDeviceMobile

	// zjisti info o zarizeni
  public function getDeviceMobile_UPDATE($device = '', $data = array()) {
    
    $sql = "UPDATE `" . DB_PREFIX . "order`
            SET user_agent_device = 1                        
            WHERE order_status_id > 0 
          ";

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if ($device != '') {
			$sql .= " AND LCASE(user_agent) LIKE '%" . strtolower($device) . "%'";
		}
        
    $query = $this->db->query($sql);
    
		return $query->row;
  } // getDeviceMobile

	// zjisti info o zarizeni
  public function getDeviceDesktop($device = '', $data = array()) {
    
    // pocet objednavek, soucet castky
    $sql_data = "SELECT 
                  COUNT(order_id) AS orders_count,
                  SUM(total) AS orders_total              
                FROM `" . DB_PREFIX . "order`
                WHERE order_status_id > 0 
              ";

    $sql_o_id = "SELECT order_id            
                 FROM `" . DB_PREFIX . "order`
                 WHERE order_status_id > 0   
              ";

		if (!empty($data['filter_date_start'])) {
			$sql = " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
      $sql_data .= $sql;
      $sql_o_id .= $sql;
		}

		if (!empty($data['filter_date_end'])) {
			$sql = " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
      $sql_data .= $sql;
      $sql_o_id .= $sql;
		}

		if ($device != '') {
			$sql = " AND LCASE(user_agent) LIKE '%" . strtolower($device) . "%'";
      $sql_data .= $sql;
      $sql_o_id .= $sql;
		}
    
    if (!empty($data['mobiles'])) {
      foreach($data['mobiles'] AS $key => $mobile) {
        $sql = " AND LCASE(user_agent) NOT LIKE '%" . strtolower($key) . "%'";
        $sql_data .= $sql;
        $sql_o_id .= $sql;
      }
		}    
        
    $sql_o_id .= " ORDER BY order_id ASC ";
    
    $query_data = $this->db->query($sql_data);
    $query_o_id = $this->db->query($sql_o_id);
    
    $o_id = ( isset($query_o_id->rows) ? $query_o_id->rows : $query_o_id->row );     
    $orders_id = array('orders_id' => '');
    foreach($o_id AS $key => $value) {
      $orders_id['orders_id'] .= ( strlen($orders_id['orders_id']) > 0 ? ', ' : ''); // castka pred IDckama
      $orders_id['orders_id'] .= $value['order_id']; // IDcko      
    }
    
		return array_merge($query_data->row, $orders_id);    
  } // getDeviceDesktop

	// zjisti info o zarizeni
  public function getDeviceDesktop_UPDATE($device = '', $data = array()) {
    
    $sql = "UPDATE `" . DB_PREFIX . "order`
            SET user_agent_device = 1            
            WHERE order_status_id > 0 
          ";

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if ($device != '') {
			$sql .= " AND LCASE(user_agent) LIKE '%" . strtolower($device) . "%'";
		}
    
    if (!empty($data['mobiles'])) {
      foreach($data['mobiles'] AS $key => $mobile) {
        $sql .= " AND LCASE(user_agent) NOT LIKE '%" . strtolower($key) . "%'";
      }
		}    
        
    $query = $this->db->query($sql);
    
		return $query->row;
  } // getDeviceDesktop

	// zjisti info o zarizeni
  public function getDeviceUnknown($device = '', $data = array()) {
    
    $sql_data = "SELECT 
                  COUNT(order_id) AS orders_count,
                  SUM(total) AS orders_total              
                FROM `" . DB_PREFIX . "order`
                WHERE order_status_id > 0 
              ";

    $sql_o_id = "SELECT order_id             
                FROM `" . DB_PREFIX . "order`
                WHERE order_status_id > 0 
              ";

		if (!empty($data['filter_date_start'])) {
			$sql = " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
      $sql_data .= $sql;
      $sql_o_id .= $sql;
		}

		if (!empty($data['filter_date_end'])) {
			$sql = " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
      $sql_data .= $sql;
      $sql_o_id .= $sql;
		}

		if ($device != '' ) {
			$sql = " AND LCASE(user_agent) LIKE '%" . strtolower($device) . "%'";
      $sql_data .= $sql;
      $sql_o_id .= $sql;
		}
    
    if (!empty($data['mobiles'])) {
      foreach($data['mobiles'] AS $key => $mobile) {
        $sql = " AND LCASE(user_agent) NOT LIKE '%" . strtolower($key) . "%'";
        $sql_data .= $sql;
        $sql_o_id .= $sql;
      }
		}    

    if (!empty($data['computers'])) {
      foreach($data['computers'] AS $key => $mobile) {
        $sql = " AND LCASE(user_agent) NOT LIKE '%" . strtolower($key) . "%'";
        $sql_data .= $sql;
        $sql_o_id .= $sql;
      }
		}
        
    $sql_o_id .= " ORDER BY order_id ASC ";
    
    $query_data = $this->db->query($sql_data);
    $query_o_id = $this->db->query($sql_o_id);
    
    $o_id = ( isset($query_o_id->rows) ? $query_o_id->rows : $query_o_id->row );     
    $orders_id = array('orders_id' => '');
    foreach($o_id AS $key => $value) {
      $orders_id['orders_id'] .= ( strlen($orders_id['orders_id']) > 0 ? ', ' : ''); // castka pred IDckama
      $orders_id['orders_id'] .= $value['order_id']; // IDcko      
    }
    
		return array_merge($query_data->row, $orders_id);

  } // getDeviceUnknown   

}

/*
column
sorting order: SORT_ASC | SORT_DESC (optional)
sorting type: SORT_NUMERIC | SORT_STRING (optional) 
*/
// Seradi multi-pole = Sorting MultiArray + ORDER BY
// $sorted_data = array_orderby('city', SORT_ASC, SORT_STRING, 'zip', SORT_DESC, SORT_NUMERIC, $data) // array_orderby (nova funkce 2014)
if ( function_exists('array_orderby') ) { 
} else {  
  function array_orderby() {
    $params = func_get_args();
    $array = array_pop($params);
    
    if (!is_array($array)) {return false;}
  
    $multisort_params = array();
    foreach ($params as $i => $param) {
      if (is_string($param)) {
        ${"param_$i"} = array();
        foreach ($array as $index => $row) {
          ${"param_$i"}[$index] = $row[$param];
        } // foreach array
      } else { 
        ${"param_$i"} = $params[$i];
      }  
      $multisort_params[] = &${"param_$i"};
    } // forerach params
    
    $multisort_params[] = &$array; 
  
    call_user_func_array("array_multisort", $multisort_params);
    return $array;
  } // array_orderby
} // if function

?>