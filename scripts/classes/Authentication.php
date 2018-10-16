<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Auth extends Projectfunctions
{
    public static function checkSession($directus, $columns, $join_all_data)
    {
        if (isset($_SESSION) && isset($_SESSION['authToken'])) {

            // if ($join_all_data) {
                /*
                    - get registered user
                    - get columns 
                */
            // }

            // compare the authtoken to any user that is logged in
            $loggedInUser = $directus->getItems('registered_users', [
                "in[session_token]" => $_SESSION['authToken'],
                "columns"=>$columns
            ]);

            $data = $loggedInUser->getData();
            
            // check if user data has been retrieved
            if (!empty($data)) {
                return ["status" => true, "user"=> $data];
            } else {
                // TODO log user out if this is the case e.g return to login page

                /*
                    destroy user session for this browser or device if the AUTH token dont match correctly

                    ON FRONT END
                        - make sure all loggedInData values are reset back to default
                        - direct user back to login page if they havent been already
                */

                
                return ["status" => false ];
            }
        }

        return ["status" => false];
    }

    public static function validateLoginCredentials($credentials, $DB, $columns="")
    {
        $email = $credentials['email'];
        $password = $credentials['password'];

        //
        $options = ["status"=>1, "in[account_holder_email]"=>$email, "columns"=>$columns];
        $user_exists = $DB->entryExists('registered_users', $options);

        // validate password against sent password
        if ($user_exists['status']) {
            $user_details = $user_exists['result'];

            if (Projectfunctions::validatePassword($password, $user_details['account_holder_password'])) {
                return [
                    "status"=>true,
                    "user"=>$user_details
                ];
            }

            return ["status"=>false];
        }

        return ["status"=>false];
    }

    public static function createSession()
    {
        if (!isset($_SESSION)) {
            // session_destroy();
            session_start();
        }

        // set the session auth token variable
        $_SESSION['authToken'] = bin2hex(random_bytes(20));

        if (isset($_SESSION['authToken'])) {
            return true;
        }

        return false;
    }



    public static function logNewSessionData($token, $user, $DB)
    {
        try{
            // generate date & time
            $date = parent::generate_current_date();

            // validate login history json data to check if its been set before
            $login_history_set = parent::validJSON($user['login_history_json']);

            // get geolocation & device data of user location when logging in
            $geo = parent::geoLocationData();
            $deviceDetector = parent::deviceDetector();

            if ($login_history_set) {
                // parse login history json
                $login_history = parent::parseJSON($user['login_history_json']);

                // create new login session entry
                $login_report = parent::LoginSessionReport($date, $geo, $deviceDetector); 

                 // add new login session entry to login history array
                array_push($login_history, $login_report);

                $history_arr_updated = parent::returnJSON($login_history);

            } else {
                // create new login history array with login json data
                $history_arr_new = [];

                $initial_login = parent::LoginSessionReport($date, $geo, $deviceDetector);

                array_push($history_arr_new, $initial_login);

                $history_arr_new = parent::returnJSON($history_arr_new);
            }

            $history_log = isset($history_arr_updated) ? $history_arr_updated : $history_arr_new;

            $fields = [
                "session_token"=>$token,
                "last_login_date_"=>$date['readable_date_db'],
                "login_history_json"=>$history_log
            ];

            $DB->updateEntryData('registered_users', $user, $fields);

            return true;
        }catch(Exception $e){
            return false;
        }
    }



    public static function deleteUserSession($user, $DB)
    {
        // destroy authToken session variable
        unset($_SESSION['authToken']);

        // set the session token to "empty string" as user is no longer logged in
        $fields = [
            "session_token"=>""
        ];

        $DB->updateEntryData('registered_users', $user, $fields);
    }

    public static function checkAccountExists($DB, $email)
    {
        try {
            $exists = $DB->getItems('registered_users', [
                "in[email]"=> $email
            ]);
            
            $data = $exists->getData();

            if (empty($data)) {
                throw new Exception("No data retrieved", 1);
            }
        } catch (Exception $e) {
        }
    }

    public static function registerUser()
    {
        // TODO
    }
}
