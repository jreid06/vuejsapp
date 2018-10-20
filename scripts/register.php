<?php

require_once __DIR__.'/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SERVER['SERVER_NAME'] != CONFIG) {
	echo Projectfunctions::returnJSON(['error'=>'no access to script']);
    // kill script. No access allowed 
    die();
}

// instantiate response class
$response = new Response();

// generate date
$_date = Projectfunctions::generate_current_date();

// get the post details from the request 
$registered_user_details = $_POST;
$valid_email = false;

if (filter_var($registered_user_details['email'], FILTER_VALIDATE_EMAIL)) {
	$valid_email = true;
}

if (!$valid_email) {
	$custom_message = [
		"message" => 'Oops!! email entered is not valid',
		"valid_email"=> $valid_email
	];

	$response->editErrorResponseInfo($custom_message);

	echo Projectfunctions::returnJSON($response->error_response());

	// kill script
	die();
}

$user_exists = $DB->createCustomRequest('registered_users', [
	"in[account_holder_email]"=> $registered_user_details['email']
]);


// Register User to App as no user exists with this email

if (!$user_exists['status']) {
	$_full_name = $registered_user_details['first_name'].' '.$registered_user_details['last_name'];
	$stripe_user_description = "Football formations account for ".$_full_name;

	// create a customer on stripe 
	$stripe_customer_created = Stripecore::createCustomer($stripe_user_description, $registered_user_details['email']);

	// hash user entered password
	$hashed_password = Projectfunctions::HashPassword($registered_user_details['password']);

	// set up the array to create entry for registered_user table

	// TODO - create a register user function in Authentication Class
	
	$database_data = [
		"status"=> 1,
		"account_type" => $registered_user_details['account_type_id'],
		"account_id_code" => bin2hex(random_bytes(20)),
		"account_holder_email" => $registered_user_details['email'],
		"account_holder_first_name" => ucwords($registered_user_details['first_name']),
		"account_holder_last_name" => ucwords($registered_user_details['last_name']),
		"account_holder_full_name" => ucwords($_full_name),
		"account_holder_password" => $hashed_password,
		"selected__package" => $registered_user_details['package_id'],
		"date_user_registered" => $_date['readable_date_db'],
		"reset_password_token" => bin2hex(random_bytes(20)), 
		"stripe_account_id_" => $stripe_customer_created['info']['stripe_data']['id']
	];

	// add the newly created user to the database using directus 

	$user_registered = $DB->addEntry('registered_users', $database_data);
	
	// return response

	switch ($user_registered['status']['code']) {
		case 200:
			// success
			$custom_response = [
				"message" => $registered_user_details['first_name'].", your account has been successfully!",
				"url" => "/login"
			];

			$response->editSuccessResponseInfo($custom_response);
			$response->updateActiveResponse($response->success_response());
			break;

		case 400:
			// error
			$custom_response = [
				"message" => "error creating your account. Try again". $registered_user_details['first_name']
			];

			$response->editErrorResponseInfo($custom_response);
			$response->updateActiveResponse($response->success_response());
			break;
	}

	echo Projectfunctions::returnJSON($response->active_response());
}else{
	$custom_message = [
		"message"=> 'Account with this email already exist. Log in ?',
		"valid_email"=> $valid_email
	];

	$response->editErrorResponseInfo($custom_message);
	echo Projectfunctions::returnJSON($response->error_response());
}



