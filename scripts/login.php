<?php

require_once __DIR__.'/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SERVER['SERVER_NAME'] != CONFIG) {
    echo Projectfunctions::returnJSON(['error'=>'no access to script']);
    // kill script. No access allowed
    die();
}

// $session_already_set = Auth::checkSession();

// if()

// instantiate response class
$response = new Response();

// generate date
$_date = Projectfunctions::generate_current_date();

// get the post details from the request
$login_user_details = $_POST['data'];

// check to make sure email is valid
$valid_email = Projectfunctions::validateEmail($login_user_details['email']);

if (!$valid_email) {
    $custom_message = [
        "message" => 'Oops!! email entered is not valid',
        "valid_email"=> $valid_email
    ];

    $response->editErrorResponseInfo($custom_message);
    echo Projectfunctions::returnJSON($response->error_response());
    die();
}

// validate login credentials now to make sure they match a user in Database
$user_exists = Auth::validateLoginCredentials($login_user_details, $DB, USER_COLUMNS);

if ($user_exists['status']) {
    
    // login user and set token
    if (Auth::createSession()) {

        // log new session token for user in database.
        $session_logged = Auth::logNewSessionData($_SESSION['authToken'],$user_exists['user'], $DB);

        // send back a response for front end
        $custom_message = [
            "message" => 'Login successful. You\'ll be redirected to your dashboard',
            "session" => $_SESSION,
            "log_session"=> $session_logged,
            "user"=> $user_exists['user']
        ];

        $response->editSuccessResponseInfo($custom_message);
        echo Projectfunctions::returnJSON($response->success_response());

        die();
    }

    $custom_message = [
        "message"=> "Unfortunately there was an issue logging you in. Try again"
    ];
    $response->editErrorResponseInfo($custom_message);
    echo Projectfunctions::returnJSON($response->error_response());
    die();
}

// error section if user login credentials arent correct
$custom_message = [
    "message"=>"Credentials provided aren't correct. Please check the email and/or password entered",
    "user_exists"=>$user_exists,
    "valid_email"=> $valid_email
];

$response->editErrorResponseInfo($custom_message);
echo Projectfunctions::returnJSON($response->error_response());

die();
