<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;

class Projectfunctions
{
    public static function returnJSON($value)
    {
        return json_encode($value, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    public static function HashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function validJSON($json)
    {
        if(empty($json)) return false;
        
        try {
            json_encode($json);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function parseJSON($json)
    {
        return json_decode($json, true);
    }

    public static function geoLocationData()
    {
        $geo_location = new geoPlugin();

        $geo_location->locate();
        $geo_data = $geo_location->returnLocationData();

        if (!empty($geo_data) && !is_null($geo_data['geoplugin_city'])) {
            return $geo_data;
        }

        // do a manual request directly to the geolocation WEB API
        $geo_api = self::geoWebAPIrequest();

        if($geo_api){
            return $geo_api;
        }

        return false;
    }

    public static function geoWebAPIrequest()
    {
        $ip_data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp'));

        if ($ip_data['geoplugin_status'] === 200) {
            $ip_data['API'] = true;

            return $ip_data;
        }

        return false;
    }

    public static function deviceDetector()
    {
        DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);

        $userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse

        $dd = new DeviceDetector($userAgent);

        $dd->parse();

        return [
             // holds information about browser, feed reader, media player, ...
            "clientInfo" => $dd->getClient(),
            "osInfo" => $dd->getOs(),
            "device" => $dd->getDeviceName(),
            "brand" => $dd->getBrandName(),
            "model" => $dd->getModel()
        ];
    }
    
    public static function setCSRFtoken()
    {
        if (!isset($_SESSION['csrftoken']) || empty($_SESSION['csrftoken'])) {
            $_SESSION['csrftoken'] = bin2hex(random_bytes(15));

            // return as true as NEW csrf token session has been created
            return [
                "message" => 'user session has been created',
                "token"=> $_SESSION['csrftoken'],
                "status" => true
            ];
        }

        // return as false as csrftoken has already been set
        return [
            "message" => 'user visited session ALREADY exists',
            "token"=> $_SESSION['csrftoken'],
            "status" => false
        ];
    }

    public static function LoginSessionReport($date, $geo, $deviceDetector)
    {
        if (empty($date) || empty($geo) || empty($deviceDetector)) {

            $date = self::generate_current_date();

            return [
                "day" => $date['day'],
                "month_num"=> $date['month_digit'],
                "month" => $date['month'],
                "year" => $date['year'],
                "time" => $date['time'],
                "date_uk" => $date['readable_date'],
                "ip"=> "null",
                "device"=> "null",
                "error"=> [
                    "status"=> true,
                    "message"=>"geo location data not available. This issues arises  when using a personal hotspot connection"
                ]
            ];
        }
        
        $session_report = [
            "day" => $date['day'],
            "month_num"=> $date['month_digit'],
            "month" => $date['month'],
            "year" => $date['year'],
            "time" => $date['time'],
            "date_uk" => $date['readable_date'],
            "ip"=> $geo,
            "device"=> $deviceDetector
        ];

        return $session_report;
    }
    
    public static function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    public static function validatePassword($raw, $hashed)
    {
        if (password_verify($raw, $hashed)) {
            return true;
        }

        return false;
    }
    
    // @files = ARRAY
    public static function removeNonFiles($files)
    {
        $classes = [];

        try {
            if (!is_array($files) || count($files) <= 2) {
                throw new Exception("Error with parameter supplied to function", 1);
            }

            foreach ($files as $key => $value) {
                if ($value === '..' || $value === '.') {
                    continue;
                }
                array_push($classes, $value);
            }

            return $classes;
        } catch (Exception $e) {
            return [false, $e->getMessage()];
        }
    }

    public static function submitToMailingList($email)
    {
        $table = 'mailing_list_users';
        $response = new Response();

        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Email entered is not valid', 1);
            }

            $create_subscriber = $directus->createItem($table, [
                'status' => 1,
                'email' => $email,
                'first_name' => 'Anonymous',
            ]);
        } catch (Exception $e) {
            $error_arr_info = [
                'message' => $e->getMessage(),
            ];

            $response->editErrorResponseInfo($error_arr_info);
            $encoded = json_encode($response->error_response());

            // exit with json encoded date
            // echo $encoded;
            // exit($encoded);
            return [
                'encoded' => $encoded,
                'raw' => $response->error_response()
            ];
        }
    }

    public static function InitPHPmailer($use_settings, $smtp_settings)
    {
        try {
            $mail = new PHPMailer();

            if ($use_settings) {
                $mail->isSMTP();
                //Enable SMTP debugging
                // 0 = off (for production use)
                // 1 = client messages
                // 2 = client and server messages
                $mail->SMTPDebug = $smtp_settings['debug'];
                //Set the hostname of the mail server
                $mail->Host = $smtp_settings['host'];
                //Set the SMTP port number - likely to be 25, 465 or 587
                $mail->Port = $smtp_settings['port_number'];
                //Whether to use SMTP authentication
                $mail->SMTPAuth = $smtp_settings['smtpauth'] ? true : false;
                //Username to use for SMTP authentication
                $mail->Username = $smtp_settings['email'];
                //Password to use for SMTP authentication
                $mail->Password = $smtp_settings['password'];
                $mail->SMTPSecure = $smtp_settings['smtpsecure'];
            }

            return ['status' => true, 'mailer' => $mail];
        } catch (\Exception $e) {
            return ['status' => false];
        }
    }

    public static function updateEmailManager($email_data, $directus)
    {
        file_put_contents('update_email_init.txt', 'it runs');
        $date_info = self::generate_current_date();

        file_put_contents('update_email_date.json', json_encode($date_info));

        try {
            file_put_contents('update_email_try.txt', 'try init');

            $update_email_table = $directus->createItem('emails_manager', [
                'email' => $email_data['user_email'],
                'date_sent' => $date_info['readable_date_db'],
                'subject' => $email_data['subject'],
                'message' => $email_data['message'],
                'sender_email' => $email_data['sender'],
                'send_email_to_user' => $email_data['user_email'],
            ]);

            file_put_contents('update_status.json', json_encode($update_email_table));

            return true;
        } catch (\Exception $e) {
            file_put_contents('update_email_catch.txt', 'error in try');

            return false;
        }
    }

    /*
        * @instance type OBJECT
        * @email_data type ARRAY ($_POST request)
        // TODO: MOVE TO ANOTHER FUNCTION
        * @multiple type BOOLEAN
        //
        * @attachments type ARRAY
    */

    public static function send_email($instance, $from_email, $email_data, $attachement = false)
    {
        $mail = $instance;
        $from = $from_email;

        $mail->setFrom($from);
        $mail->addAddress($email_data['email']);
        if ($attachement) {
            $mail->addAttachment($attachement['file_path']);
        }
        $mail->isHTML(true);
        $mail->Subject = $email_data['email_subject'];
        $mail->Body = $email_data['email_message'];

        if ($mail->send()) {
            return [true];
        } else {
            return [false, $mail->ErrorInfo, $from];
        }
    }

    public static function send_bulk_emails($instance, $from_email, $emails, $subject, $message)
    {
        $mail = $instance;
        $from = $from_email;

        $mail->setFrom($from);

        for ($i = 0; $i < count($emails); ++$i) {
            $mail->addAddress($emails[$i]);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if ($mail->send()) {
            return [true];
        } else {
            return [false, $mail->ErrorInfo, $from];
        }
    }

    public static function generate_current_date()
    {
        $current_date = getdate();
        $timestamp = $current_date[0];
        $month_digit = $current_date['mon'];

        $readable_date = date('d/m/Y H:i:s', $timestamp);
        $readable_date_db = date('Y-m-d H:i:s', $timestamp);
        $time = date('H:i:s', $timestamp);
        $date_now = date('d/m/Y', $timestamp);
        $date_now_db = date('Y-m-d', $timestamp);
        $year = date('Y', $timestamp);
        $month = $current_date['month'];
        $weekday = $current_date['weekday'];
        $day = $current_date['mday'];

        return array(
            'readable_date' => $readable_date,
            'readable_date_db' => $readable_date_db,
            'time' => $time,
            'date_style_uk' => $date_now,
            'date_style_db' => $date_now_db,
            'month' => $month,
            'weekday_txt' => $weekday,
            'month_digit' => $month_digit,
            'year' => $year,
            'timestamp' => $timestamp,
            'day' => $day,
        );
    }
}
