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

$sqlconn = new MysqlConn();
$result = $sqlconn->GetAllStrategy();


?>
<br />
<br />
List of Strategy<br />
<table border=1>
	<tr>
		<td>Strategy Name</td>
		<td></td>
		<td></td>
	</tr>
	
	<?php
	
	for ($i = 0; $i < count($result ); $i++) {
    		$obj = $result[$i];
    		echo "<tr>
				<td>".$obj->StrategyName."</td>
				<td><a href='main_strategy.php?ActionType=Modify&StrategyName=".$obj->StrategyName."&StrategyID=".$obj->StrategyID."'>Modify</a></td>
				<td><a href='main_strategy.php?ActionType=Delete&StrategyName=".$obj->StrategyName."&StrategyID=".$obj->StrategyID."'>Delete</a></td>
			</tr>
		";
	}
	
	?>
</table>

<?php
if ($_GET["ActionType"] == "Modify"){
?>

<br />
<br />

Modify your Strategy Below<br />
<form action="PerformTransaction.php" method="post">
    Strategy Name:
    <input type="text" name="StrategyName" id="StrategyName" value="<?php echo $_GET["StrategyName"] ?>">
    <input type="hidden" name="StrategyID" id="StrategyID" value="<?php echo $_GET["StrategyID"] ?>">
    <input type="submit" value="Modify Strategy" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="ModifyStrategy" >
</form>


<?php
}
else if ($_GET["ActionType"] == "Delete"){
?>

<br />
<br />

Are your sure you want to delete <?php echo $_GET["StrategyName"] ?>?<br />
If there is trade found for this strategy, it will NOT be deleted.
<br />
<form action="PerformTransaction.php" method="post">
    <input type="hidden" name="StrategyName" id="StrategyName" value="<?php echo $_GET["StrategyName"] ?>">
    <input type="hidden" name="StrategyID" id="StrategyID" value="<?php echo $_GET["StrategyID"] ?>">
    <input type="submit" value="Yes, Delete It" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="DeleteStrategy" >
</form>


<?php
}
else{
?>
<br />
<br />

Add New Strategy Below<br />
<form action="PerformTransaction.php" method="post">
    Strategy Name:
    <input type="text" name="StrategyName" id="StrategyName">
    <input type="submit" value="Add Strategy" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="AddStrategy" >
</form>
<?php
}
?>

