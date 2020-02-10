<?php
class Cache
{
	private $expire = 3600;
	private $APCmode=false;
	private $cache=array();
	
	public function __construct($expire=3600)
	{	
		$this->expire = $expire;
		$this->APCmode=false;
		
		if(extension_loaded('apcu')) //APC new version
			$this->APCmode='apcu';
		elseif (extension_loaded('apc')) //APC old version
			$this->APCmode='apc';
	}
		
	public function get($key)
	{			
		$hashKey=md5(HTTP_SERVER.$key);
		
		if(isset($this->cache[$hashKey]) && $this->cache[$hashKey]['time']+$this->expire>=time()) return $this->cache[$hashKey]['data'];
		
		//APC(u)
		if($this->APCmode!==false)
		{
			$result=false;
			$data=$this->APCmode=='apcu'?apcu_fetch($hashKey,$result):apc_fetch($hashKey,$result);
			if(!$result || !is_array($data)) return null;
		}
		else
		{
			//File Cache
			$file=DIR_CACHE. $hashKey.'.cache';
			$data=false;
			if(file_exists($file))
			{
				$cache = file_get_contents($file);
				$data = unserialize($cache);
			}
			if($data===false) return null;
		}
		
		if(isset($data['time']) && $data['time']+$this->expire>=time())
		{
			$this->cache[$hashKey]=$data;
			return $data['data'];
		}
		
		return null;
	}

	public function set($key, $value)
	{
		$hashKey=md5(HTTP_SERVER.$key);
		
		$cache=array(
			'time'=>time(),
			'data'=>$value,
		);
		
		$this->cache[$hashKey]=$cache;

		//APC(u)
		if($this->APCmode!==false)
		{
			$this->APCmode=='apcu'? apcu_store($hashKey, $cache, $this->expire) : apc_store($hashKey, $cache, $this->expire);
		}
		else
		{
			//File Cache
			$file=DIR_CACHE.$hashKey.'.cache';		
			file_put_contents($file,serialize($cache),LOCK_EX);
		}
	}

	public function delete($key)
	{
		$hashKey=md5(HTTP_SERVER.$key);
		
		if(isset($this->cache[$hashKey])) unset($this->cache[$hashKey]);
		
		//APC(u)
		if($this->APCmode!==false)
		{
			$this->APCmode=='apcu'? apcu_delete($hashKey) : apc_delete($hashKey);
		}
		else
		{
			//File Cache
			$file=DIR_CACHE.$hashKey.'.cache';
			if(file_exists($file)) unlink($file);
		}
	}
	
	
	public function setExpire($expire)
	{
		$this->expire=$expire;
	}
	
	public function getExpire()
	{
		return $this->expire;
	}
	
	public function __destruct()
	{
		$this->cache=array();
	}
}
?>