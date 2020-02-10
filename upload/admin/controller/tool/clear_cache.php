<?php
	class ControllerToolClearCache extends Controller {
		public function index() {
			
			$status = array();
			
			if (!isset($_POST['push']) or !$this->user->hasPermission('modify', 'tool/clear_cache')) {
				$status = 'Permission error!';
			}else{
			
				// Clear cache
				$files = glob(DIR_CACHE . 'cache.*');
				foreach($files as $file){
					$this->deldir($file);
				}
				
// Clear image cache
//				$imgfiles = glob(DIR_IMAGE . 'cache/*');
//				foreach($imgfiles as $imgfile){
//					$this->deldir($imgfile);
//				}
				
				// Clear vqmod cache 
				$this->clear_vqcache();
				
				$status = 'Success: You have successfully cleared your cache!';
			}
			
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($status));
		}
		
		private function deldir($file){         
			if(file_exists($file)) {
				if(is_dir($file)){
					$dir = opendir($file);
					while($filename = readdir($dir)){
						if($filename != "." && $filename != "..") {
							$this->deldir($file . "/" . $filename); 
						}
					}
					closedir($dir);  
					rmdir($file);
				}else if (basename($file) != 'index.html') {
					@unlink($file);
				}			
			}
		}
		
		private function clear_vqcache($return = false) {
			$vqcache_files = substr_replace(DIR_SYSTEM, '/vqmod/vqcache/vq*', -8);
			$vqmod_modcache = substr_replace(DIR_SYSTEM, '/vqmod/mods.cache', -8);
			
			$files = glob($vqcache_files);
			
			if ($files) {
				foreach($files as $file) {
					if (is_file($file)) {
						unlink($file);
					}
				}
			}
			
			if (is_file($vqmod_modcache)) {
				unlink($vqmod_modcache);
			}
			
			if ($return) {
				return;
			}
		}
		
	}