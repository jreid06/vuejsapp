<?php
//  header("Access-Control-Allow-Origin: *");
 
 require_once __DIR__.'/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SERVER['SERVER_NAME'] != CONFIG) {
    $testjson_data = ['SERVER_REQUEST'=> $_SERVER['REQUEST_METHOD']];

	echo Projectfunctions::returnJSON($testjson_data);
    // kill script
    die();
}

// store the sent parameters
$post_parameters = $_POST;

// init response
$response = new Response();
$json_data = true ? '' : ['server'=> $_SERVER, 'post'=> $post_parameters];

switch ($post_parameters['frontend_data_key']) {
	case 'get_account_type':
        
		$data = $DB->getAllActiveItems('account_types');

		$custom_response = [
			"message" => "account types retrieved",
			"data" => $data
		];

		$response->editSuccessResponseInfo($custom_response);
		$json_data = $response->success_response();
		break;

	case 'value':
		# code...
		break;
    
}

// exit with json

exit(Projectfunctions::returnJSON($json_data));
