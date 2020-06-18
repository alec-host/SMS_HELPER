<?php
namespace App;

class SQLiteCreateTable {
	
	private $pdo;
	
	public function __construct($pdo) {
		$this->pdo = $pdo;
	}
	#-.create table.
	public function createTable() {	
		$cmd = 'CREATE TABLE IF NOT EXISTS tbl_outbound (
				_id INTEGER PRIMARY KEY,
				_msisdn TEXT,
				_message TEXT NOT NULL,
				_time_stamp TEXT
			    )';
				
		$this->pdo->exec($cmd);
	}
	#-.get table.
	public function getTableList() {
		
		$stmt = $this->pdo->query('SELECT _msisdn,_message,_time_stamp FROM tbl_outbound ORDER BY _time_stamp DESC LIMIT 5');
		$messages = [];
		
		while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
			$messages[] = ['msisdn'=>trim($row['_msisdn']),'message'=>trim($row['_message']),'date_created'=>trim($row['_time_stamp'])];
		}
		
		return $messages;
	}
}
?>