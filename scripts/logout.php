<?php

require_once __DIR__.'/config.php';

/* 
	check to see if $_SESSION is set
 	check to see if authtoken & csrf token variables are set
	destroy session if its set
	update users profile in database
		- session _token - clear entry 
	
		
*/

// instantiate new response object
$response = new Response();

// store sent data in variable
$post_data = $_POST;
$user = $_POST['user'];


if(!isset($_SESSION['authToken'])){
	// return logout error as no authToken for session has been set
	$custom_message = [
		"message"=>"You are not logged in. You'll be redirected to login page",
		"redirect"=> "/login"
	];

	$response->editErrorResponseInfo($custom_message);
	echo Projectfunctions::returnJSON($response->error_response());

	die();
}

// destroy authToken session 
Auth::deleteUserSession($user, $DB);

// successfull logout response

if(!isset($_SESSION['authToken'])){
	$custom_message = [
		"message"=>"logged out successfully",
		"session"=>$_SESSION,
		"redirect"=>"/login"
	];

	$response->editSuccessResponseInfo($custom_message);
	echo Projectfunctions::returnJSON($response->success_response());

	die();
}

// return error as authToken session variable is still active 

$custom_message = [
	"message"=>"Unfortunately there was an error logging you out. Try again"
];

$response->editErrorResponseInfo($custom_message);
echo Projectfunctions::returnJSON($response->error_response());

die();








	