<?php
require('vendor/autoload.php');
require('app/Config.php');

use AfricasTalking\SDK\AfricasTalking;

// Initialize the SDK
$AT = new AfricasTalking(Config::USER_NAME, Config::API_KEY);

// Get the SMS service
$sms = $AT->sms();

$data = file_get_contents("php://input");

$obj = json_decode($data);

// Set your shortCode or senderId
$from  = "BetVantage";

try {
    // Thats it, hit send and we'll take care of the rest
    $result = $sms->send([
        'to'      => Config::COUNTRY_CODE.$obj->mobile,
        'message' => $obj->message,
        'from'    => Config::SENDER_ID
    ]);
	print('{"status":"'.$result['status'].'","error":"0"}');
} catch (Exception $e) {
    print('{"status":"fail","error":"'.$e->getMessage().'"}');
}

?>