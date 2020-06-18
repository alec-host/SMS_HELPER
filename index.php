<?php
require('vendor/autoload.php');

use App\SQLiteConn;

$pdo =(new SQLiteConn)->connect();

if($pdo != null){
	echo('connected to SQLite');
}else{
	echo('Whoops something happened');
}

?>