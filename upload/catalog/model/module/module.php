<?php
class ModelModuleModule extends Model {
	public function getPositions($data) {
            $results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` LIKE '%module%' AND `serialized` = '1'");  

                 
				$modules = array();
			foreach($results->rows as $result){
				if($result['key'] !='pp_layout_module'){
					  $modules[] = array("name"=>$result['key'], array(unserialize($result['value'])) );
				}
			}
$ms = array();

foreach($modules as $module) {
    foreach($module as $array) {
        if (!empty($array[0]) && is_array($array[0])) {
   	    foreach ($array[0] as $module_value) {
		if (!empty($module_value['layout_id'])) {
			$ms[$module_value['layout_id']][] = array('name'				=> $module['name'],
												  		 'position'			=> $module_value['position'],
												 		);
		}
	}
}
}
				if( isset($ms[$data['layout_id']]) ){
								$layouts = $ms[$data['layout_id']];
				} else {
								$layouts = array();
				}
				$position = array( "left" => '', "right"=>'' );

				           if(count($layouts) > 0){
				              foreach($layouts as $layout){
				                   if($layout['position'] == 'column_left'){
				                     $position['left'] = true;
				                     continue;
				                   }
				                   if($layout['position'] == 'column_right'){
				                     $position['right'] = true;
				                     continue;
				                   }
				              }    
				           } 
			return $position; 
  }
}
}
?>