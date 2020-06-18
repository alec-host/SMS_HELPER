<?php

require('vendor/autoload.php');

use AfricasTalking\SDK\AfricasTalking;

use App\SQLiteConn as SQLiteConn;
use App\SQLiteInsert as SQLiteInsert;
use App\GeneralUtiliy as GeneralUtiliy;


$pdo = (new SQLiteConn())->connect();
$sql = new SQLiteInsert($pdo);

$data = file_get_contents("php://input");

$obj = json_decode($data);

$countryCode = "254";

$post = new GeneralUtiliy();

$result = $post->_curlPost('http://localhost/Vantagehelp/messaging/index.php',$data);

$obj2 = json_decode($result);

if($obj2->status == 'success'){
	$sql->insertMessage($countryCode.$obj->mobile,$obj->message,date("Y-m-d H:i:s"));
	echo('{"Result":"success"}');
	exit(0);
}else{
	echo('{"Result":"fail"}');
	exit(0);
}

?>