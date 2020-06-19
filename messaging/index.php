<?php
require('vendor/autoload.php');
require('app/Config.php');

use AfricasTalking\SDK\AfricasTalking;

// Initialize the SDK
$AT = new AfricasTalking(Config::USER_NAME, Config::API_KEY);

// Get the SMS service
$sms = $AT->sms();

//-.validate mobile.
if(isset($_REQUEST['mobile']) && trim( $_REQUEST['mobile']) != ''){
	$mobile  = $_REQUEST['mobile'];
}else{
	$mobile = '';	
}
//-.validate message.
if(isset($_REQUEST['message']) && trim( $_REQUEST['message']) != ''){
	$message  = $_REQUEST['message'];
}else{
	$message = '';	
}

try {
    // Thats it, hit send and we'll take care of the rest
    $result = $sms->send([
        'to'      => Config::COUNTRY_CODE.$mobile,
        'message' => $message,
        'from'    => Config::SENDER_ID
    ]);
	print('{"status":"'.$result['status'].'","error":"0"}');
	header('Location:../view.php?msg='.$result['status'].'&mobile='.Config::COUNTRY_CODE.$mobile.'&message='.$message);
} catch (Exception $e) {
    print('{"status":"fail","error":"'.$e->getMessage().'"}');
	header('Location:../view.php?msg=fail&mobile='.Config::COUNTRY_CODE.$mobile.'&message='.$message);
}

?>