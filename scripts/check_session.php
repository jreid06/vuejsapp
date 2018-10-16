<?php
 header("Access-Control-Allow-Origin: *");


// require define script here
// && $_SERVER['REQUEST_METHOD'] !== 'footballformtions.vue'
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // kill script
    die();
}

require_once dirname(__DIR__).'/scripts/config.php';

$headers = apache_request_headers();
$response = new Response();

$join_all_data = isset($_POST['all_data']) ? $_POST['all_data'] : false;

$user_logged_in = Auth::checkSession($directus, USER_COLUMNS, $join_all_data);

if ($user_logged_in['status']) {

    $csrf_set = Projectfunctions::setCSRFtoken();

    // $DB->updateEntryData('registered_users', )

    $custom_response = [
        "message"=> 'user IS logged in',
        "csrf_data" => $csrf_set,
        "logged_in"=> [
            "status"=> true,
        ],
        "session"=>isset($_SESSION) ? $_SESSION : "no session",
        "user"=> $user_logged_in['user'][0]
    ];

    $response->editSuccessResponseInfo($custom_response);
    $response->updateActiveResponse($response->success_response());
} else {
	$csrf_set = Projectfunctions::setCSRFtoken();

    $custom_response = [
        "message"=> 'user NOT logged in',
        "csrftoken" => $_SESSION['csrftoken'],
        "csrf_data" => $csrf_set,
        "logged_in"=> false
    ];

    $response->editWarningResponseInfo($custom_response);
    $response->updateActiveResponse($response->warning_response());
}

echo Projectfunctions::returnJSON($response->active_response());
