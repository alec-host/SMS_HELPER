<?php
require('vendor/autoload.php');

use App\SQLiteConn as SQLiteConn;
use App\SQLiteCreateTable as SQLiteCreateTable;
use App\SQLiteInsert as SQLiteInsert;

use App\Config as Config;

$db = new SQLiteCreateTable((new SQLiteConn())->connect());

$db->createTable();

$list = $db->getTableList();

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || ($_SERVER['PHP_AUTH_USER'] != Config::ADMIN_LOGIN) || ($_SERVER['PHP_AUTH_PW'] != Config::ADMIN_PASSWORD)) { 

	header('HTTP/1.1 401 Unauthorized'); 

	header('WWW-Authenticate: Basic realm="Config Dashboard"'); 
	print("<!DOCTYPE html>");
	print("<html>");
	print("<head><title>Error</title></head>");
	print("<body>");
	print("<center><kbd>Access Denied: Username and password required.</kbd></center>");
	print("</body>");
	print("</html>");

}else{

?>
<!DOCTYPE html>
<html>
	<head>
	<script src="script/jquery-1.9.1.js" type="text/javascript"></script>
	<style>
	@font-face {
		font-family: customFont;
		src: url('font/Sansation.ttf');
	}
	
	html,body,table,tr,td,input[type=text],button,textarea {
		font-family: customFont;
	}
	
	textarea,input[type=text]{
		font-size: 16px;
		border:solid 1px #C0C0C0;
		background-color:#606060;
		color:#fff;
	}
	.main,.td {
		border: 1px solid #fff;
		border-collapse:collapse;
	}
	#header{
		color:#252525;
		border: 1px solid #fff;
		border-collapse:collapse;
		height:30px;
	}
	.button{
		background-color: #007C00;
		border: none;
		color:#fff;
		padding: 15px 30px;
		text-align: center;
		text-decoration:none;
		font-weight: bold;
		display: incline-block;
		font-size: 16px;
	}
	.tr:nth-child(odd){
		background:#252525;
		color:#fff;
	}
	.tr:nth-child(even){
		background:#E0C362;
		color:#000;
	}
	.tr{
		transition:background 0.2s ease-in;
	}
	.tr{
		background:#fff;
		cursor:pointer;
	}
	::placeholder{
		color:#fff;
		opacity: 1;
	}
	:-ms-input-placeholder{
		color:#fff;
	}
	::-ms-input-placeholder{
		color:#fff;
	}
	#msg{
		color:#fff;
		padding: 8px 12%;
		text-align: center;
		text-decoration:none;
		font-weight: bold;
		background-color:#D3B000;
	}
	</style>
	<script type="text/javascript">
		function numOnly(evt){
			var theEvent = evt || window.event;
			if(theEvent.type === 'paste') {
				key = event.clipboardData.getData('text/plain');
				
			}else{
				var key = theEvent.keyCode || theEvent.which;
				key = String.fromCharCode(key);
			}
			
			var regex = /[0-9]|\./;
			if(!regex.test(key)){
				theEvent.returnValue = false;
				if(theEvent.preventDefault) theEvent.preventDefault();
			}
		}

		function validate(){
			var mobile  = $('#mobile').val();
			var message = $('#message').val();

			if(mobile == ''){
				alert('Mobile number must be checked.');
				return false;
			}else if(mobile.substring(0,1) != '7' || mobile.length != '9'){
				alert('Enter correct mobile number i.e. 712 345 678.');
				return false;
			}else{
				return (true);
			}
		}	
	</script>
	</head>
	<body style="background:#EFEFEF">
		<br><br><br><br><br><br><br><br>
		<center>
			<?php
			if(isset($_GET['msg']) && trim($_GET['msg']) != ''){
				$msg = $_GET['msg'];
			}else{
				$msg = '';
			}
			if($msg == 'fail'){			
			?>
				<small id="msg">Message not submitted</small>
			<?php
			}else if(($msg == 'success')){
				$pdo = (new SQLiteConn())->connect();
				$sql = new SQLiteInsert($pdo);	
				$sql->insertMessage(Config::COUNTRY_CODE.$_GET['mobile'],$_GET['message'],date("Y-m-d H:i:s"));
			?>
				<small id="msg">Message submitted successfully</small>
			<?php			
			}
			?>
			<br><br>
			<table class="main" width="40%" cellspacing="0" cellpadding="0">
			    <tr style="background-color:#252525;"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
				<tr style="background-color:#252525;">
					<td colspan="3">
						<table width="100%" cellspacing="0" cellpadding="0">
							<form method="post" action="messaging/index.php" onsubmit="return(validate());">
							<tr>
								<td>&nbsp;<input type="text" id="mobile" name="mobile" size="40" onkeypress="numOnly(event);" placeholder="Enter mobile number: (712 345 678)" maxlength="9"/></td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
							<td>
								<table cellspacing="0" cellpadding="0">
									<tr>
										<td>&nbsp;<textarea id="message" name="message" rows="4" cols="58" readonly>Hello world!, test messsage from BetVantage</textarea></td>
									</tr>
								</table>
							</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td align="right"><button class="button" id="btnSend" name="btnSend"><kbd>SEND</kbd></button>&nbsp;</td>
							</tr>
							</form>
						</table>
					</td>
				</tr>
				<tr height="5px" style="background-color:#252525;"><td></td><td></td><td></td></tr>				
				<tr style="background:#E0C362">
					<th id="header" width="15%">MOBILE</th>
					<th id="header" width="60%">MESSAGE</th>
					<th id="header" width="30%">TIME STAMP</th>
				</tr>
				<?php
				for($j=0;$j<count($list);$j++){
				?>
				<tr class="tr">
					<?php 
						print(
							'<td class="td" width="15%" align="center">&nbsp;<small>'.$list[$j]['msisdn'].'</small>&nbsp;</td>'.
							'<td class="td" width="60%" align="center">&nbsp;<small>'.$list[$j]['message'].'</small>&nbsp;</td>'.
							'<td class="td" width="25%" align="center">&nbsp;<small>'.$list[$j]['date_created'].'</small>&nbsp;</td>'
						);
					?>
				</tr>
				<?php
				}
				?>
			</table>
		</center>
	</body>
</html>
<?php
}
?>