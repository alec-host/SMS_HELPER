<?php
namespace App;

class SQLiteConn {
private $pdo;
	public function connect(){
		if($this->pdo == null) {
		   try{
			   $this->pdo = new \PDO("sqlite:".Config::PATH_TO_SQLITE_FILE);
		   }catch(\PDOException $e){
			   print($e);
		   }
		}	
		return $this->pdo;
	}
}
?>