<?php

require_once __DIR__.'/../config.php';


// $ip_data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp'));
// echo json_encode($ip_data, true);
$geo_data = Projectfunctions::geoLocationData();
$geo_data['deviceDetector'] = Projectfunctions::deviceDetector();
// $geo_data['session'] = $_SESSION;ls
$geo_data['cookie'] = $_COOKIE;
$geo_data['timezone'] = date_default_timezone_get();
if($geo_data){
	echo Projectfunctions::returnJSON($geo_data);
}

// // echo json_encode($ip);
// $date = Projectfunctions::generate_current_date();
// $date['server'] = $_SERVER;

// session_destroy();


// // echo Projectfunctions::returnJSON($date);

// $browser = new Browser();

// $date['browser'] = [
// 	"platform"=> $browser->getPlatform(),
// 	"name"=> $browser->getBrowser(),
// 	"version"=> $browser->getVersion()
// ];

// echo Projectfunctions::returnJSON($date);

// $me = Auth::validateLoginCredentials($login_user_details, $DB, USER_COLUMNS);





