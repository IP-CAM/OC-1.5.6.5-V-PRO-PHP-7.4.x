<?php
class ModelCommonLogin extends Model {

	public function getTotalIpChecks() {
		function check_ip() {
			$ipaddress = 'UNKNOWN';
			if (getenv('HTTP_CLIENT_IP'))
				$ipaddress = getenv('HTTP_CLIENT_IP');
			else if(getenv('REMOTE_ADDR'))
				$ipaddress = getenv('REMOTE_ADDR');
			return $ipaddress;
		}

		$sql_query = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "admin_ip_whitelist` ( " .
			"  `admin_ip_whitelist_id` int(11) NOT NULL AUTO_INCREMENT, " .
			"  `ip` varchar(15) COLLATE utf8_bin NOT NULL, " .
			"  PRIMARY KEY (`admin_ip_whitelist_id`), " .
			"  KEY `ip` (`ip`) " .
			") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ";
		$this->db->query($sql_query);

		$sql_query = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "admin_ip_whitelist` ";
		$query = $this->db->query($sql_query);
		if ((int)$query->row['total'] > 0) {
			$ip = check_ip();
			$query = $this->db->query($sql_query . " WHERE ip = '" . $ip . "'");
			return (int)$query->row['total'];
		} else {
			return 1;
		}
	}
}
?>