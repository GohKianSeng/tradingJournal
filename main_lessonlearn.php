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
$result = $sqlconn->GetAllLessonLearn();


?>
<br />
<br />
List of Lesson Learn<br />
<table border=1>
	<tr>
		<td>Lesson Learn Remarks</td>
		<td></td>
		<td></td>
	</tr>
	
	<?php
	
	for ($i = 0; $i < count($result ); $i++) {
    		$obj = $result[$i];
    		echo "<tr>
				<td>".$obj->LessonLearnRemarks."</td>
				<td><a href='main_lessonlearn.php?ActionType=Modify&LessonLearnRemarks=".$obj->LessonLearnRemarks."&LessonLearnID=".$obj->LessonLearnID."'>Modify</a></td>
				<td><a href='main_lessonlearn.php?ActionType=Delete&LessonLearnRemarks=".$obj->LessonLearnRemarks."&LessonLearnID=".$obj->LessonLearnID."'>Delete</a></td>
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

Modify your Lesson learn Below<br />
<form action="PerformTransaction.php" method="post">
    Strategy Name:
    <input type="text" name="LessonLearnRemarks" id="LessonLearnRemarks" value="<?php echo $_GET["LessonLearnRemarks"] ?>">
    <input type="hidden" name="LessonLearnID" id="LessonLearnID" value="<?php echo $_GET["LessonLearnID"] ?>">
    <input type="submit" value="Modify Lesson Learn" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="ModifyLessonLearn" >
</form>


<?php
}
else if ($_GET["ActionType"] == "Delete"){
?>

<br />
<br />

Are your sure you want to delete <?php echo $_GET["LessonLearnRemarks"] ?>?<br />
If there is trade found for this lesson learn, it will NOT be deleted.
<br />
<form action="PerformTransaction.php" method="post">
    <input type="hidden" name="LessonLearnRemarks" id="LessonLearnRemarks" value="<?php echo $_GET["LessonLearnRemarks"] ?>">
    <input type="hidden" name="LessonLearnID" id="LessonLearnID" value="<?php echo $_GET["LessonLearnID"] ?>">
    <input type="submit" value="Yes, Delete It" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="DeleteLessonLearn" >
</form>


<?php
}
else{
?>
<br />
<br />

Add New Lesson Learn Below<br />
<form action="PerformTransaction.php" method="post">
    Strategy Name:
    <input type="text" name="LessonLearnRemarks" id="LessonLearnRemarks">
    <input type="submit" value="Add Lesson Learn" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="AddLessonLearn" >
</form>
<?php
}
?>

