<?php
namespace App;

class SQLiteInsert {
	
	private $pdo;
	
	public function __construct($pdo) {
		$this->pdo = $pdo;
	}
	#-.get table.
	public function insertMessage($mobile,$message,$date) {	
		$sql = 'INSERT INTO tbl_outbound(_msisdn,_message,_time_stamp)VALUES(:_msisdn,:_message,:_time_stamp)';
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':_msisdn',$mobile);
		$stmt->bindValue(':_message',$message);
		$stmt->bindValue(':_time_stamp',$date);
		
		$stmt->execute();
				
		return $this->pdo->lastInsertId();
	}
}
?>