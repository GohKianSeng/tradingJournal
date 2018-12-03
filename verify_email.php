<?php
include './config/MysqlConn.php';

session_start();

if(isset($_GET["token"])){

	$sqlconn = new MysqlConn();
	$tradeResult = $sqlconn->VerifyUserToken($_GET["token"]);
	
	if($tradeResult == "OK"){	
		header('Location: login.php?Message=VerifiedOK');
	}
	else{
		header('Location: login.php?Message=VerifiedFail');
	}
}
?>