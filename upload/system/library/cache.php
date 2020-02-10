<?php
/*
 * Fast cache class for OpenCart without using function glob 
 */
class Cache {
	private $expire = 3600;

	public function get($key) {
		
		$file = DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.cache';
		
		if (file_exists($file)) {
			$fp = fopen($file, 'r');
			flock($fp, LOCK_SH);
			$data = unserialize(fread($fp, filesize($file))); 
			flock($fp, LOCK_UN);
			fclose($fp);

			if ((filemtime($file) + $this->expire) < time()) {
				if (file_exists($file)) {	
					unlink($file);
				}
				return false;
			}
			
			return $data;
		}else{
			return false;
		}
		
	}

	public function set($key, $value) {
	if ($key == 'sitemap') $this->expire = 90000;
		$this->delete($key);

		$file = DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.cache';
		
		if (!$fp = fopen($file, 'w')) return false;
		if (flock($fp, LOCK_EX)){  
			fwrite($fp, serialize($value));  
			flock($fp, LOCK_UN);
			fclose($fp);
			
			clearstatcache();
			
			return true;
		} else {

			return false;  
		}
	}

	public function delete($key) {
		$file = DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.cache';
		if (file_exists($file)) {
			unlink($file);
		}
	}
	
	public function validate(){
		$files = glob(DIR_CACHE . 'cache.*.cache', GLOB_NOSORT );
		
		error_reporting(0);

		foreach ($files as $file) {
			if (file_exists($file)) {
				if ((filemtime($file) + $this->expire) < time()) {
					unlink($file);
				}
			}
		}
	}
	
	function __destruct() {
		if (mt_rand(0, 600) == 15) {
			$this->validate();
		}
	}

}
?>