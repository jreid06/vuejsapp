<?php

use Phpfastcache\CacheManager;
use Phpfastcache\Config\Config;

define("CONFIG", 'footballformations.vue');
define("BACKEND_URL", "admin.footballformations.vue");
define("HTTP_STATUS", 'http://');
define("USER_COLUMNS", "id,account_holder_email,account_holder_first_name,account_holder_last_name,account_holder_full_name,account_id_code,account_type,date_user_registered,selected__package,stripe_account_id_,session_token,account_holder_password,login_history_json, last_login_date_,login_history_json,managers_teams,player_brief_catalogue,file_uploads");

require_once dirname(__DIR__).'/vendor/autoload.php';
require_once dirname(__DIR__).'/vendor/stripe-php/init.php';
require_once dirname(__DIR__).'/scripts/classes/Functions.php';

CacheManager::setDefaultConfig(new Config([
	"path" => __DIR__.'/../cache',
	"itemDetailedDate" => false
  ]));

// initialize directus

$directus = \Directus\SDK\ClientFactory::create('ZsU2BSdaeLwL84ggLDVYKiTIzYeTV9t3', [
    // Directus API Path without its version
    'base_url' => HTTP_STATUS.BACKEND_URL.'/',
    'version' => '1.1' // Optional - default 1.1
]);

// initialize stripe

$stripe = array(
	"secret_key"      => "sk_test_10YDKMLOYIvY3nDXIAAwwKPh",
	"publishable_key" => "pk_test_WFOvijLzP7fJuTxydIq1RIuP"
  );

\Stripe\Stripe::setApiKey($stripe['secret_key']);


$_classes = scandir(dirname(__DIR__).'/scripts/classes/');
$classes = Projectfunctions::removeNonFiles($_classes);

foreach ($classes as $key => $value) {
	require_once dirname(__DIR__).'/scripts/classes/'.$value;
}

// create our directus instance
$DB = new Directus();
$DB->setInstance($directus);

session_start();



