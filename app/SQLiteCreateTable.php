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
	public function getTableList_old() {
		
		$stmt = $this->pdo->query('SELECT _msisdn,_message,_time_stamp FROM tbl_outbound ORDER BY _time_stamp DESC LIMIT 5');
		$messages = [];
		
		while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
			$messages[] = ['msisdn'=>trim($row['_msisdn']),'message'=>trim($row['_message']),'date_created'=>trim($row['_time_stamp'])];
		}
		
		return $messages;
	}
	
	public function getTableList_old2() {
		
		$stmt = $this->pdo->query('SELECT _msisdn AS msisdn,_message AS message,_time_stamp AS date_created FROM tbl_outbound ORDER BY _time_stamp DESC LIMIT 5');
		$messages = [];
		
		$messages[] = $stmt->fetch(\PDO::FETCH_ASSOC);
		
		/*
		while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
			$messages[] = ['msisdn'=>trim($row['_msisdn']),'message'=>trim($row['_message']),'date_created'=>trim($row['_time_stamp'])];
		}
		*/
		
		return $messages;		
	}
	
	
		public function getTableList() {
			
		$stmt = $this->pdo->query('SELECT _msisdn AS msisdn,_message AS message,_time_stamp AS date_created FROM tbl_outbound ORDER BY _time_stamp DESC LIMIT 5');
		
		$messages = [];
		
		$messages[] = $stmt->fetch(\PDO::FETCH_ASSOC);
		
		//$stmt = $this->pdo->prepare($sql);
		
		
		///////print_r($stmt);
		
		///////$message[] = $stmt->fetch(\PDO::FETCH_OBJ);
		///////$stmt->execute();
		
		print_r($messages);
		
		/*
		while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
			$messages[] = ['msisdn'=>trim($row['_msisdn']),'message'=>trim($row['_message']),'date_created'=>trim($row['_time_stamp'])];
		}
		*/
		
		return $messages;		
	}
	
	/*	
	$query->execute(array($ques_id, $author_ques_id));
	$money = $query->fetch(PDO::FETCH_ASSOC);
	$asker_amount = $money['asker'];
	$responder_amount = $money['responder'];
	
	$stmt = $this->pdo->prepare($sql);
	$stmt->bindValue(':_msisdn',$mobile);
	$stmt->bindValue(':_message',$message);
	$stmt->bindValue(':_time_stamp',$date);

	$stmt->execute();
	
	
	*/
}
?>