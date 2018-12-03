<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./library/datetimepicker/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./library/datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="./library/datetimepicker/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>

<link href="./library/datetimepicker/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="./library/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">





<link href="https://unpkg.com/nanogallery2/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="https://unpkg.com/nanogallery2/dist/jquery.nanogallery2.min.js"></script>


<?php
	echo date('Y-m-d H:i:s');
include './config/MysqlConn.php';
include './cloudinary/Cloudinary.php';

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

if ($_GET["ActionType"] == "ModifyV2"){
$sqlconn = new MysqlConn();
$tradeResult = $sqlconn->GetSelectedTrade($_GET["TradeID"]);

?>

<br />
<br />

Modify your Trade Below<br />
<form action="PerformTransaction.php" method="post" enctype="multipart/form-data">
    Symbol:
    <input type="text" name="Symbol" value="<?php echo $tradeResult->Symbol ?>"><br />
    Strategy:
    <select name="StrategyID">
	    <?php
	    	$sqlconn = new MysqlConn();
		$result = $sqlconn->GetAllStrategy();
	    
	    	for ($i = 0; $i < count($result ); $i++) {
    			$obj = $result[$i];
    			echo $tradeResult ->StrategyName;
    			if($obj->StrategyName == $tradeResult->StrategyName){
    				echo "<option value='".$obj->StrategyID."' selected>".$obj->StrategyName."</option>";
    			}
    			else
    			{
    				echo "<option value='".$obj->StrategyID."'>".$obj->StrategyName."</option>";

    			}
    		}
	    ?>	    
    </select><br />
    Trade Type:
    <input type="radio" name="TradeType" value="Real" <?php if($tradeResult->TradeType == "Real"){echo "checked='checked'";}?> >Real
    <input type="radio" name="TradeType" value="Missed" <?php if($tradeResult->TradeType == "Missed"){echo "checked='checked'";}?> > Missed
    <input type="radio" name="TradeType" value="Statistics" <?php if($tradeResult->TradeType == "Statistics"){echo "checked='checked'";}?> > Statistics
    <br />
    Order Type:
    <input type="radio" name="OrderType" value="Buy" <?php if($tradeResult->OrderType == "Buy"){echo "checked='checked'";}?> >Buy
    <input type="radio" name="OrderType" value="Sell" <?php if($tradeResult->OrderType == "Sell"){echo "checked='checked'";}?> > Sell<br>
    <br />
    Lot Size:
    <input type="number" name="LotSize" id="LotSize" step="0.001" value="<?php echo $tradeResult->LotSize ?>" required><br />
    Entry Datetime:
    <input size="20" name="EntryDateTime" id="EntryDateTime" type="text" value="<?php echo $tradeResult->EntryDateTime ?>" required readonly class="form_datetime">
    <br />
    Entry Price:
    <input type="number" name="EntryPrice" id="EntryPrice" step="0.00001" value="<?php echo $tradeResult->EntryPrice ?>" required><br />
    Stop Loss Pips:
    <input type="number" name="SL_Pips" id="SL_Pips" step="1" value="<?php echo $tradeResult->SL_Pips ?>" required><br />
    Take Profit Pips:
    <input type="number" name="TP_Pips" id="TP_Pips" step="1" value="<?php echo $tradeResult->TP_Pips ?>" required><br />
    Exit Datetime:
    <input size="20" name="ExitDateTime" id="ExitDateTime" type="text" value="<?php echo $tradeResult->ExitDateTime ?>" required readonly class="form_datetime">
    <script type="text/javascript">
    	$(".form_datetime").datetimepicker({        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        //use24hours: true;
        minuteStep: 1});
    </script>            
    <br />
    Exit Price:
    <input type="number" name="ExitPrice" id="ExitPrice" step="0.00001" value="<?php echo $tradeResult->ExitPrice ?>" required><br />
    Profit Loss:
    <input type="number" name="ProfitLoss" id="ProfitLoss" step="0.01" value="<?php echo $tradeResult->ProfitLoss ?>" required><br />
    Remarks:
    <textarea rows="4" cols="50" maxlength="10000" name="Remarks" id="Remarks"><?php echo $tradeResult->Remarks ?></textarea><br />
    Trade Screenshot:
    <input type="file" id="file" name="file" size="10"/>
    <input id="uploadbutton" type="button" value="Upload"/>

    <div ID="ngy2p" style="overflow: visible;opacity: 1;width: 500px;" data-nanogallery2='{
	"thumbnailWidth": "auto",
	"thumbnailHeight": "80",
	"colorScheme": {
		"thumbnail": {
			"background": "rgba(255,0,0,1)"
		}
	},
	"thumbnailLabel": {
		"display": false
	},
	"galleryDisplayMode": "rows",
	"galleryMaxRows": 10,
	"thumbnailAlignment": "left",
	"displayBreadcrumb": false,
	"breadcrumbAutoHideTopLevel": false,
	"breadcrumbOnlyCurrentLevel": false,
	"thumbnailSelectable":    true,
	"thumbnailHoverEffect2":  null
     }'>
					      
					      
					      <?php
					      		for ($j = 0; $j < count($tradeResult->TradeURL); $j++) {
					      				echo date('Y-m-d H:i:s');
					      			$arrayThumbnail = array("cloud_name" => "tradingjournal", "width"=>250, "crop"=>"scale", "quality"=>"auto");
					      			$arrayFullImage = array("cloud_name" => "tradingjournal", "quality"=>100);
					      			echo "<a id='" . $tradeResult->Trade_PublicID[$j] . "' href='" . Cloudinary::cloudinary_url($tradeResult->Trade_PublicID[$j], $arrayFullImage) . "' data-ngthumb='" . Cloudinary::cloudinary_url($tradeResult->Trade_PublicID[$j], $arrayThumbnail) . "'></a>";
					      		}
					      ?>					      					   		
					 </div>
	<button type="button" id="deleteImageButton" style="display:none">Delete Selected Image</button>
	
	<br/><br/>
	
	<?php
	    	$sqlconn = new MysqlConn();
		$result = $sqlconn->GetAllLessonLearn();
	    	
	    	$pieces = explode(", ", $tradeResult->LessonLearn);	    	
	    	
	    	for ($i = 0; $i < count($result ); $i++) {
    			$obj = $result[$i];
    			
    			if (in_array($obj->LessonLearnRemarks, $pieces )) {
    				echo "&nbsp;&nbsp;<input type='checkbox' name='LessonLearn[]' value='".$obj->LessonLearnID."' checked='checked'>".$obj->LessonLearnRemarks."<br>";
    			}
    			else{
    				echo "&nbsp;&nbsp;<input type='checkbox' name='LessonLearn[]' value='".$obj->LessonLearnID."'>".$obj->LessonLearnRemarks."<br>";

    			}
    			
    			
    		}
	    ?>
    
    

    <input type="submit" value="Modify Trade" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="ModifyTrade" >
    <input type="hidden" name="TradeID" id="TradeID" value="<?php echo $_GET["TradeID"] ?>" >

</form>

<script type="text/javascript">
$(document).ready(function () {

      $("#uploadImageButton").click(function () {
        var filename = $("#file").val();

        $.ajax({
            type: "POST",
            url: "addFile.do",
            enctype: 'multipart/form-data',
            data: {
                file: filename
            },
            success: function () {
                alert("Data Uploaded: ");
            }
        });
    });

      $('#deleteImageButton').on('click', function() {
	  if (confirm('Are you sure you want to delete selected images?')) {
	     	  var ngy2data = $("#ngy2p").nanogallery2('data');
		  ngy2data.items.forEach( function(item) {
		    if( item.selected ) {
		      
		      
		      var myKeyVals = { TradeID : "<?php echo $_GET["TradeID"] ?>", UserGUID : "<?php echo $_SESSION['UserGUID'] ?>", PublicID: item.GetID(), ActionType : "deleteImage" };
		      
		      var saveData = $.ajax({
			      type: 'POST',
			      url: "PerformTransaction.php",
			      data: myKeyVals,
			      dataType: "text",
			      success: function(resultData) { 
			      	item.delete(); 
			      	$("#my_nanogallery2").nanogallery2('resize');
			      	$('#deleteImageButton').hide();
			      }
			});
		    }
		  });
		  
	    } 	  
	});

      function mylistener(e) {
        var selectedImages = $('#ngy2p').nanogallery2('itemsSelectedGet');
        if(selectedImages.length > 0){
        	$('#deleteImageButton').show();
        }
        else{
        	$('#deleteImageButton').hide();
        }
      }      

      $("#ngy2p").on('itemSelected.nanogallery2 itemUnSelected.nanogallery2', mylistener);      
    });
  </script>



<?php
}
else if ($_GET["ActionType"] == "Modify"){

$sqlconn = new MysqlConn();
$tradeResult = $sqlconn->GetSelectedTrade($_GET["TradeID"]);

?>

<br />
<br />

Modify your Trade Below<br />
<form action="PerformTransaction.php" method="post" enctype="multipart/form-data">
    Symbol:
    <input type="text" name="Symbol" value="<?php echo $tradeResult->Symbol ?>"><br />
    Strategy:
    <select name="StrategyID">
	    <?php
	    	$sqlconn = new MysqlConn();
		$result = $sqlconn->GetAllStrategy();
	    
	    	for ($i = 0; $i < count($result ); $i++) {
    			$obj = $result[$i];
    			echo $tradeResult ->StrategyName;
    			if($obj->StrategyName == $tradeResult->StrategyName){
    				echo "<option value='".$obj->StrategyID."' selected>".$obj->StrategyName."</option>";
    			}
    			else
    			{
    				echo "<option value='".$obj->StrategyID."'>".$obj->StrategyName."</option>";

    			}
    		}
	    ?>	    
    </select><br />
    Trade Type:
    <input type="radio" name="TradeType" value="Real" <?php if($tradeResult->TradeType == "Real"){echo "checked='checked'";}?> >Real
    <input type="radio" name="TradeType" value="Missed" <?php if($tradeResult->TradeType == "Missed"){echo "checked='checked'";}?> > Missed
    <input type="radio" name="TradeType" value="Statistics" <?php if($tradeResult->TradeType == "Statistics"){echo "checked='checked'";}?> > Statistics
    <br />
    Order Type:
    <input type="radio" name="OrderType" value="Buy" <?php if($tradeResult->OrderType == "Buy"){echo "checked='checked'";}?> >Buy
    <input type="radio" name="OrderType" value="Sell" <?php if($tradeResult->OrderType == "Sell"){echo "checked='checked'";}?> > Sell<br>
    <br />
    Lot Size:
    <input type="number" name="LotSize" id="LotSize" step="0.001" value="<?php echo $tradeResult->LotSize ?>" required><br />
    Entry Datetime:
    <input size="20" name="EntryDateTime" id="EntryDateTime" type="text" value="<?php echo $tradeResult->EntryDateTime ?>" required readonly class="form_datetime">
    <br />
    Entry Price:
    <input type="number" name="EntryPrice" id="EntryPrice" step="0.00001" value="<?php echo $tradeResult->EntryPrice ?>" required><br />
    Stop Loss Pips:
    <input type="number" name="SL_Pips" id="SL_Pips" step="1" value="<?php echo $tradeResult->SL_Pips ?>" required><br />
    Take Profit Pips:
    <input type="number" name="TP_Pips" id="TP_Pips" step="1" value="<?php echo $tradeResult->TP_Pips ?>" required><br />
    Exit Datetime:
    <input size="20" name="ExitDateTime" id="ExitDateTime" type="text" value="<?php echo $tradeResult->ExitDateTime ?>" required readonly class="form_datetime">
    <script type="text/javascript">
    	$(".form_datetime").datetimepicker({        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        //use24hours: true;
        minuteStep: 1});
    </script>            
    <br />
    Exit Price:
    <input type="number" name="ExitPrice" id="ExitPrice" step="0.00001" value="<?php echo $tradeResult->ExitPrice ?>" required><br />
    Profit Loss:
    <input type="number" name="ProfitLoss" id="ProfitLoss" step="0.01" value="<?php echo $tradeResult->ProfitLoss ?>" required><br />
    Remarks:
    <textarea rows="4" cols="50" maxlength="10000" name="Remarks" id="Remarks"><?php echo $tradeResult->Remarks ?></textarea><br />
    Trade Screenshot:
    <input type="file" name="TradeURL1" id="TradeURL1"><br />
    IMC Remarks:
    <textarea rows="4" cols="50" maxlength="10000" name="IMCRemarks" id="IMCRemarks"><?php echo $tradeResult->IMCRemarks ?></textarea><br />
    IMC Screenshot:
    <input type="file" name="IMC_URL" id="IMC_URL"><br />
	<?php
	    	$sqlconn = new MysqlConn();
		$result = $sqlconn->GetAllLessonLearn();
	    	
	    	$pieces = explode(", ", $tradeResult->LessonLearn);	    	
	    	
	    	for ($i = 0; $i < count($result ); $i++) {
    			$obj = $result[$i];
    			
    			if (in_array($obj->LessonLearnRemarks, $pieces )) {
    				echo "&nbsp;&nbsp;<input type='checkbox' name='LessonLearn[]' value='".$obj->LessonLearnID."' checked='checked'>".$obj->LessonLearnRemarks."<br>";
    			}
    			else{
    				echo "&nbsp;&nbsp;<input type='checkbox' name='LessonLearn[]' value='".$obj->LessonLearnID."'>".$obj->LessonLearnRemarks."<br>";

    			}
    			
    			
    		}
	    ?>
    
    

    <input type="submit" value="Modify Trade" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="ModifyTrade" >
    <input type="hidden" name="TradeID" id="TradeID" value="<?php echo $_GET["TradeID"] ?>" >

</form>



<?php
}
else if ($_GET["ActionType"] == "Delete"){
?>

<br />
<br />

Are your sure you want to delete <?php echo $_GET["TradeID"] ?> Trade?<br />
<br />
<form action="PerformTransaction.php" method="post">
    <input type="hidden" name="TradeID" id="TradeID" value="<?php echo $_GET["TradeID"] ?>">
    <input type="submit" value="Yes, Delete It" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="DeleteTrade" >
</form>


<?php
}
else{

?>
<br />
<br />

Add New Trades<br />
<form action="PerformTransaction.php" method="post" enctype="multipart/form-data">
    Symbol:
    <input type="text" name="Symbol"><br />
    Strategy:
    <select name="StrategyID">
	    <?php
	    	$sqlconn = new MysqlConn();
		$result = $sqlconn->GetAllStrategy();
	    
	    	for ($i = 0; $i < count($result ); $i++) {
    			$obj = $result[$i];
    			echo "<option value='".$obj->StrategyID."'>".$obj->StrategyName."</option>";
    		}
	    ?>	    
    </select><br />
    Trade Type:
    <input type="radio" name="TradeType" value="Real" checked="checked">Real
    <input type="radio" name="TradeType" value="Missed"> Missed
    <input type="radio" name="TradeType" value="Statistics"> Statistics
    <br />
    Order Type:
    <input type="radio" name="OrderType" value="Buy" checked="checked">Buy
    <input type="radio" name="OrderType" value="Sell"> Sell<br>
    <br />
    Lot Size:
    <input type="number" name="LotSize" id="LotSize" step="0.001" value="" required><br />
    Entry Datetime:
    <input size="20" name="EntryDateTime" id="EntryDateTime" type="text" value="" required readonly class="form_datetime">
    <br />
    Entry Price:
    <input type="number" name="EntryPrice" id="EntryPrice" step="0.00001" required><br />
    Stop Loss Pips:
    <input type="number" name="SL_Pips" id="SL_Pips" step="1" value="100" required><br />
    Take Profit Pips:
    <input type="number" name="TP_Pips" id="TP_Pips" step="1" value="100" required><br />
    Exit Datetime:
    <input size="20" name="ExitDateTime" id="ExitDateTime" type="text" value="" required readonly class="form_datetime">
    <script type="text/javascript">
    	$(".form_datetime").datetimepicker({        format: "yyyy-mm-dd hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep: 1});
    </script>            
    <br />
    Exit Price:
    <input type="number" name="ExitPrice" id="ExitPrice" step="0.00001" required><br />
    Profit Loss:
    <input type="number" name="ProfitLoss" id="ProfitLoss" step="0.01" required><br />
    Remarks:
    <textarea rows="4" cols="50" maxlength="10000" name="Remarks" id="Remarks"></textarea><br />
    Trade Screenshot:
    <input type="file" name="TradeURL1" id="TradeURL1"><br />
    IMC Remarks:
    <textarea rows="4" cols="50" maxlength="10000" name="IMCRemarks" id="IMCRemarks"></textarea><br />
    IMC Screenshot:
    <input type="file" name="IMC_URL" id="IMC_URL"><br />
	<?php
	    	$sqlconn = new MysqlConn();
		$result = $sqlconn->GetAllLessonLearn();
	    
	    	for ($i = 0; $i < count($result ); $i++) {
    			$obj = $result[$i];
    			echo "&nbsp;&nbsp;<input type='checkbox' name='LessonLearn[]' value='".$obj->LessonLearnID."'> ".$obj->LessonLearnRemarks."<br>";
    		}
	    ?>
    
    

    <input type="submit" value="Add Trade" name="submit">
    <input type="hidden" name="ActionType" id="ActionType" value="AddTrade" >
</form>
<?php
}
?>

<br />
<br />
List of Trades<br />
<table border=1>
	<tr>
		<td>Strategy</td>
		<td>TradeType</td>
		<td>Order Type</td>
		<td>ProfitLoss</td>
		<td>Remarks</td>
		<td>Lesson Learn</td>
		<td>Trade Screenshot</td>
		<td>IMC Screenshot</td>
		<td></td>
		<td></td>
		
	</tr>
	
	<?php
	$sqlconn = new MysqlConn();
	$result = $sqlconn->GetAllTrades();

	
	for ($i = 0; $i < count($result ); $i++) {
    		$obj = $result[$i];
    		$newImage = "";
    		if(count($obj->TradeURL) > 0){
    			$newImage =  "<br/>...<br/>";
    			echo "<tr>
				<td>".$obj->StrategyName.$newImage."</td>
				<td>".$obj->TradeType."</td>
				<td>".$obj->OrderType."</td>
				<td>".$obj->ProfitLoss."</td>
				<td>".$obj->Remarks."</td>
				<td>".$obj->LessonLearn."</td>
				<td colspan='2'>";
				?>													
					<div ID="ngy2p" style="overflow: visible;opacity: 1;width: 500px;" data-nanogallery2='{
					        "thumbnailWidth": "auto",
					        "thumbnailHeight": "80",
					        "colorScheme": {
					          "thumbnail": {
					            "background": "rgba(255,0,0,1)"
					          }
					        },
					        "thumbnailLabel": {
					          "display": false
					        },
					        "galleryDisplayMode": "rows",
					        "galleryMaxRows": 1,
					        "thumbnailAlignment": "left",
					        "displayBreadcrumb": false,
					        "breadcrumbAutoHideTopLevel": false,
					        "breadcrumbOnlyCurrentLevel": false,
						"thumbnailSelectable":    false,
					        "thumbnailHoverEffect2":  null
					      }'>
					      
					      
					      <?php
					      		for ($j = 0; $j < count($obj->TradeURL); $j++) {
					      				echo date('Y-m-d H:i:s');
					      			$arrayThumbnail = array("cloud_name" => "tradingjournal", "width"=>250, "crop"=>"scale", "quality"=>"auto");
					      			$arrayFullImage = array("cloud_name" => "tradingjournal", "quality"=>100);
					      			echo "<a href='" . Cloudinary::cloudinary_url($obj->Trade_PublicID[$j], $arrayFullImage) . "' data-ngthumb='" . Cloudinary::cloudinary_url($obj->Trade_PublicID[$j], $arrayThumbnail) . "'></a>";
					      		}
					      ?>					      					   		
					 </div>
				<?php
				echo "
				</td>
				<td width='1px'><a href='ModifyTradeV2.php?ActionType=ModifyV2&TradeID=".$obj->TradeID."'>Modify</a></td>
				<td width='1px'><a href='main_trades.php?ActionType=Delete&TradeID=".$obj->TradeID."'>Delete</a></td>
				</tr>";
    		}
    		else{
    			echo "<tr>
				<td>".$obj->StrategyName.$newImage."</td>
				<td>".$obj->TradeType."</td>
				<td>".$obj->OrderType."</td>
				<td>".$obj->ProfitLoss."</td>
				<td>".$obj->Remarks."</td>
				<td>".$obj->LessonLearn."</td>
				<td><img src='".$obj->TradeURL1."' width='500' height='333' /></td>
				<td><img src='".$obj->IMC_URL."' width='500' height='333' /></td>
				<td><a href='main_trades.php?ActionType=Modify&TradeID=".$obj->TradeID."'>Modify</a></td>
				<td><a href='main_trades.php?ActionType=Delete&TradeID=".$obj->TradeID."'>Delete</a></td>
				</tr>";
    		
    		}    		
	}
	
	?>
</table>
