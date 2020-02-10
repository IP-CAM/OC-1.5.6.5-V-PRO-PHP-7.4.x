<?php
class ModelModuleModule extends Model {
	public function getPositions($data) {
            $results = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` LIKE '%module%';");  

                 
				$modules = array();
			foreach($results->rows as $result){
				if($result['key'] !='pp_layout_module' && $result['key'] !='amazon_checkout_layout_module'){
					$modules[] = array("name"=>$result['key'], array(unserialize($result['value'])) );
				}
			}
			
			$ms = array();
			foreach($modules as $module){		
					foreach($module as $array){	
					 	   if(count($array[0]) > 0 && is_array($array)){
								for($i = 0; $i<count($array[0]); $i++){
									if( isset($array[0][$i]['layout_id']) ){
									    $ms[$array[0][$i]['layout_id']][] = array("name"=> $module['name'], "position" => $array[0][$i]['position']);
								   }
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