<?php 
class ModelSettingEnginedb extends Model {
	public function showEnginedb($enginedb) {
		
		$query = $this->db->query("SHOW TABLE STATUS WHERE `Engine` = '".$enginedb."'");
		
		$data = array('');

		foreach ($query->rows as $key => $value) {
			$data[$key] = $value['Name'];
		}
		return $data;
	}
	public function convertEnginedb($list_table,$enginedb) {
		
		foreach ($list_table as $value) {
			$this->db->query("ALTER TABLE ".$value." ENGINE=".$enginedb);
		}
		return true;
	}
}
?>