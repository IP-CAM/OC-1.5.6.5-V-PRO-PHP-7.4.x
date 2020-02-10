<?php
class DbCache {
private static $instance;
public static function getInstance() {
if (null === static::$instance) {
static::$instance = new static();
}
return static::$instance;
}

public static function isCreated() {
return static::$instance !== NULL;
}

private static function getCacheTimeout() {
$cacheTimeoutSeconds = (int)Registry::getInstance()->get('config')->get('db_cache_cacheTimeoutSeconds');
if (!$cacheTimeoutSeconds) {
$cacheTimeoutSeconds = self::DEFAULT_CACHE_TIMEOUT_SECONDS;
}
return $cacheTimeoutSeconds;
}

private $cacheChanged = FALSE;

public function isChanged() {
return $this->cacheChanged;
}

protected function __construct()
{
$this->loadCacheFromFile();
}

private function __clone()
{
}

private function __wakeup()
{
}
	
private $cacheMap = array();
const DEFAULT_CACHE_TIMEOUT_SECONDS = 3600;
		
public function clear() {
$dbCache = $this;
$dirPath = $dbCache->getCacheDirPath();
$files = scandir($dirPath);
foreach ($files as $filePath) {
if ($filePath == '.' || $filePath == '..') continue;
unlink($dirPath.$filePath);
}
rmdir($dirPath);
}

public function getCacheDirPath() {
$dirPath = DIR_CACHE.'db_cache/';
if (!file_exists($dirPath)) mkdir($dirPath);
return $dirPath;
}

private function getCacheMapFilePath() {

$dir = DIR_DOWNLOAD . 'db_cache/';
$dbCacheFilePath = $dir.'db_cache.dat';
if (file_exists($dbCacheFilePath)) unlink($dbCacheFilePath);
if (file_exists($dir)) rmdir($dir);

$latestPath = $this->getCacheDirPath();
$latestPath .= '_cache';

return $latestPath;
}

public function loadCacheFromFile() {
$cacheFilePath = $this->getCacheMapFilePath();
if (!file_exists($cacheFilePath))
return;
$handle = fopen($cacheFilePath, "r");
flock($handle, LOCK_SH);
$cacheSerialized = fread($handle, filesize($cacheFilePath));
fclose($handle);
$this->cacheMap = unserialize($cacheSerialized);
}

public function saveCacheToFile() {
$cacheFilePath = $this->getCacheMapFilePath();

$cacheSerialized = serialize($this->cacheMap);

$handle = fopen($cacheFilePath, 'w');
flock($handle, LOCK_EX);
fwrite($handle, $cacheSerialized);
fflush($handle);
fclose($handle);
}

public function addSelectFetchToCache($queryText, $fetchData) {
$this->setCacheEntry($queryText, $fetchData);
}
	
public function getCachedSelectFetch($queryText) {
$cachedFetchData = $this->getCachedDataFromCacheMap($queryText);
return $cachedFetchData;
}

private function getCachedDataFromCacheMap($queryText) {

if (isset($this->cacheMap[$queryText]) && $this->cacheMap[$queryText] != null) {
$cachedEntry = $this->cacheMap[$queryText];
$cacheTime = $cachedEntry['time'];
$nowTime = date_create();
$secondsDiffSpan = date_diff($cacheTime, $nowTime);
$daysDiffCount = $secondsDiffSpan->format('%a');
if ($daysDiffCount >= self::getCacheTimeout()) {
$this->removeCacheEntry($queryText);
return null;
}
return $cachedEntry['data'];
}
return null;
}
	
public function processModificationQuery($queryText) {
$dbTableNamesInQuery = DbCache::extractDbTableNamesFromQueryText($queryText);
foreach ($this->cacheMap as $queryTextKey => $cacheEntry) {
foreach ($dbTableNamesInQuery as $dbTableName) { 
if (stripos($queryTextKey, $dbTableName)) {
$this->removeCacheEntry($queryTextKey);
//echo 'remove db cache: '.$queryTextKey.'<br />';
}   
}
}
}

private function getCacheEntryFilePath($cacheKey) {
return $this->getCacheDirPath().$this->getCacheEntryFileNameByHash($this->getSelectQueryHash($cacheKey));
}

private function getCacheEntryFileNameByHash($hash) {
return $hash;
}

private function getCacheEntryData($cacheKey) {
if (!file_exists($this->getCacheEntryFilePath($cacheKey))) return NULL;
$nowTime = date_create();

$timeModified = date_create();
date_timestamp_set($timeModified, filemtime($this->getCacheEntryFilePath($cacheKey)));

$secondsDiffSpan = date_diff($timeModified, $nowTime);
$daysDiffCount = $secondsDiffSpan->format('%a');
if ($daysDiffCount >= self::getCacheTimeout()) {
$this->removeCacheEntry($cacheKey);
return NULL;
}
return unserialize(file_get_contents($this->getCacheEntryFilePath($cacheKey)));
}

private function removeCacheEntry($queryTextKey) {
if (isset($this->cacheMap[$queryTextKey])) {
//$cacheEntryFilePath = $this->getCacheDirPath().$this->getCacheEntryFileNameByHash($this->cacheMap[$queryTextKey]);
//if (file_exists($cacheEntryFilePath)) unlink($cacheEntryFilePath);
$this->cacheMap[$queryTextKey] = null;
unset($this->cacheMap[$queryTextKey]);   
$this->cacheChanged = TRUE;
}
}

private function getSelectQueryHash($queryText) {
return md5($queryText);
}

private function setCacheEntry($cacheKey, $cacheData) {
$cachedTime = date_create();
$this->cacheMap[$cacheKey] = array('time' => $cachedTime, 'data' => $cacheData);
$this->cacheChanged = TRUE;
}
	
public static function isModificationQuery($queryText) {
$arReadQueries = array('select', 'show tables', 'show columns');
foreach ($arReadQueries as $queryRead) {
$striposSelect = stripos(trim($queryText), $queryRead);
if ($striposSelect === 0 || $striposSelect === '0') return FALSE;
}
return TRUE;
}

public static function extractDbTableNamesFromQueryText($queryText) {
$tableNames = preg_grep('/'.DB_PREFIX.'.+/', explode(' ', $queryText));
return $tableNames;
}

public static function processDbQuery($db, $sql) {
$dbCache = DbCache::getInstance();
if (stripos($sql, 'now()')) {
$c = 0;
$sql = str_ireplace('NOW()', '\''.date('Y-m-d H:i').':00\'', $sql, $c);
}
if (DbCache::isModificationQuery($sql)) {
$dbCache->processModificationQuery($sql);
} else {
if (!Registry::getInstance()->get('config')->get('db_cache_status')) 
return $db->queryNonCache($sql);
if (!stripos($_SERVER['REQUEST_URI'], '/admin')) {
$cachedFetch = $dbCache->getCachedSelectFetch($sql);
if ($cachedFetch != null) {
return $cachedFetch;
}
} else {
return $db->queryNonCache($sql);
}
}
$freshDbFetch = $db->queryNonCache($sql);
if (!DbCache::isModificationQuery($sql)) {
$dbCache->addSelectFetchToCache($sql, $freshDbFetch);   
}
return $freshDbFetch;
}
}
?>