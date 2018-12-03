<?php

include './config/MysqlConn.php';

session_start();
if (isset($_SESSION['UserGUID']) && $_SESSION['loggedin'] == true) {
    echo 'welcome ' . $_SESSION['name'];
    
    if(isset($_GET["Message"])){
    	echo "<br/><br/><font color='red'>".$_GET["Message"]."</font>";
    }
    
} else {
    header('Location: login_page.php');
    exit;
}

if ($_GET["ActionType"] == "Modify"){

$sqlconn = new MysqlConn();
$result = $sqlconn->GetSelectedPreMarket($_GET["PreMarketID"]);

?>

<br />
<br />

Modify your Pre-Market Below<br />
<form action="PerformTransaction.php" method="post" enctype="multipart/form-data">
    Date:
    <input type="date" name="MarketDate" id="MarketDate" Required value="<?php echo $result->MarketDate ?>"><br />
    OPG 430 Difference:
    <input type="number" step="0.01" name="OPG430Difference" id="OPG430Difference" value="<?php echo $result->OPG430Difference ?>"><br />
    OPG 1am Difference:
    <input type="number" step="0.01" name="OPG1amDifference" id="OPG1amDifference" value="<?php echo $result->OPG1amDifference ?>"><br />
    Remarks:
    <textarea rows="4" cols="50" maxlength="10000" name="Remarks" id="Remarks"><?php echo $result->Remarks ?></textarea><br />
    My S/R Screenshot:
    <input type="file" name="MySRFile" id="MySRFile"><br />
    Raymonds S/R Screenshot:
    <input type="file" name="RaymondSRFile" id="RaymondSRFile"><br />

    <input type="submit" value="Modify Pre-Market" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="ModifyPreMarket" >
    <input type="hidden" name="PreMarketID" id="PreMarketID" value="<?php echo $result->PreMarketID ?>" >
</form>


<?php
}
else if ($_GET["ActionType"] == "Delete"){
?>

<br />
<br />

Are your sure you want to delete <?php echo $_GET["MarketDate"] ?> Pre-Market?<br />
<br />
<form action="PerformTransaction.php" method="post">
    <input type="hidden" name="PreMarketID" id="PreMarketID" value="<?php echo $_GET["PreMarketID"] ?>">
    <input type="submit" value="Yes, Delete It" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="DeletePreMarket" >
</form>


<?php
}
else{
?>
<br />
<br />

Add New Pre-Market Information Below<br />
<form action="PerformTransaction.php" method="post" enctype="multipart/form-data">
    Date:
    <input type="date" name="MarketDate" id="MarketDate" Required><br />
    OPG 430 Difference:
    <input type="number" step="0.01" name="OPG430Difference" id="OPG430Difference"><br />
    OPG 1am Difference:
    <input type="number" step="0.01" name="OPG1amDifference" id="OPG1amDifference"><br />
    Remarks:
    <textarea rows="4" cols="50" maxlength="10000" name="Remarks" id="Remarks"></textarea><br />
    My S/R Screenshot:
    <input type="file" name="MySRFile" id="MySRFile"><br />
    Raymond S/R Screenshot:
    <input type="file" name="RaymondSRFile" id="RaymondSRFile"><br />

    <input type="submit" value="Add Pre-Market" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="AddPreMarket" >
</form>
<?php
}
?>

<br />
<br />
List of Pre-Market<br />
<table border=1>
	<tr>
		<td>Market Date</td>
		<td>OPG 430 Difference</td>
		<td>OPG 1am Difference</td>
		<td>Remarks</td>
		<td>My S/R ScreenShot</td>
		<td>Raymond S/R ScreenShot</td>
		<td></td>
		<td></td>
		
	</tr>
	
	<?php
	$sqlconn = new MysqlConn();
	$result = $sqlconn->GetAllPreMarket();

	
	for ($i = 0; $i < count($result ); $i++) {
    		$obj = $result[$i];
    		echo "<tr>
				<td>".$obj->MarketDate."</td>
				<td>".$obj->OPG430Difference."</td>
				<td>".$obj->OPG1amDifference."</td>
				<td>".$obj->Remarks."</td>
				<td><img src='".$obj->MySR_URL."' width='500' height='333' /></td>
				<td><img src='".$obj->RaymondSR_URL."' width='500' height='333' /></td>
				<td><a href='main_premarket.php?ActionType=Modify&PreMarketID=".$obj->PreMarketID."'>Modify</a></td>
				<td><a href='main_premarket.php?ActionType=Delete&MarketDate=".$obj->MarketDate."&PreMarketID=".$obj->PreMarketID."'>Delete</a></td>
		</tr>";
	}
	
	?>
</table>


