<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'footballformtions.vue') {
	// kill script
	die();
}

use Phpfastcache\CacheManager;
use Phpfastcache\Core\phpFastCache;

require_once dirname(__DIR__).'/scripts/config.php';

// $key = "test";
// $test_null = null;
// // In your class, function, you can call the Cache
// $PHPfastCache = CacheManager::getInstance('Files');

// // $cache_cleared = $PHPfastCache->clear();

// // get cache item
// $cacheItem = $PHPfastCache->getItem($key);


// if (is_null($cacheItem->get())) {
// 	// write to products cache key as no cache exists
// 	//expires after a minute
// 	$cacheItem->set('NEW.---cache has been set for: '.$key)->expiresAfter(60);
// 	$PHPfastCache->save($cacheItem);
// 	$cache_message = 'cache key has no value. set it here ';
	
// 	$retrieved_cache = $cacheItem->get();
// 	$json_data = $cacheItem->getDataAsJsonString();
// }else {
// 	// $cacheItem->set('cache set for: '.$key)->;
// 	// $cache_message = 'cache exists. expires: '.$cacheItem->getExpirationDate()->format(DateTime::W3C);
// 	$cache_expiry = $cacheItem->getExpirationDate();
// 	$cache_message = 'cache has been set. ';
// 	$retrieved_cache = $cacheItem->get();
// 	$json_data = $cacheItem->getDataAsJsonString();
// }	


$headers = apache_request_headers();

if(!isset($_SESSION['csrftoken']) || !isset($_SESSION['visit_session'])){
	!isset($_SESSION['csrftoken']) ? Projectfunctions::setUniqueSessionID() : '';

	!isset($_SESSION['visit_session']) ? Projectfunctions::set
}

if

// $dta = Login::checkSession($directus);

$response = new Response();
// $new_response_data = [
// 	"dir"=>__DIR__,
// 	"header_token"=> $headers,
// 	"config"=> [
// 		"default"=> $PHPfastCache,
// 		"edited"=> $PHPfastCache->getConfig(),
// 	],
// 	"cache"=> [
// 		"isNull"=> is_null($cacheItem),
// 		"cacheJSON"=> $json_data,
// 		"testIsNull"=> is_null($test_null),
// 		"cacheItemVal"=> $retrieved_cache,
// 		"cacheisNullvalTest"=> $test_null,
// 		"message"=> $cache_message,
// 		"expiry"=> isset($cache_expiry) ? $cache_expiry : false
// 	],
// 	"token"=> $dta
// ];


// $response->editSuccessResponseInfo($new_response_data);

echo json_encode($response->success_response());