<?php

include './config/MysqlConn.php';
include './config/UploadToCloud.php';
include './config/SendEmail.php';

// Always start this first
session_start();

if ( ! empty( $_POST ) ) {
	if($_POST["ActionType"] == "UploadImage"){
		$fileUploadtotal = count($_FILES['file']['name']);
		$TradeURL1_temp = new UploadToCloudinary();
		$TradeURL1_temp->UploadNowV3("file");
		$returnString = "";	
		if($TradeURL1_temp->uploadSuccessfully == 1){
			$TradeURL = $TradeURL1_temp->CloudinaryResult["secure_url"];
			$Trade_PublicID = $TradeURL1_temp->CloudinaryResult["public_id"];
				
			$sqlconn = new MysqlConn();
			$tradeResult = $sqlconn->AddImage($TradeURL, $Trade_PublicID, $_POST["TradeID"]);
			$returnString = $Trade_PublicID;
			
			
			$arrayThumbnail = array("cloud_name" => "tradingjournal", "width"=>250, "crop"=>"scale", "quality"=>"auto");
			$arrayFullImage = array("cloud_name" => "tradingjournal", "quality"=>100);
			
			
			$returnString = $returnString . "{" . Cloudinary::cloudinary_url($Trade_PublicID, $arrayFullImage);
			$returnString = $returnString . "{" . Cloudinary::cloudinary_url($Trade_PublicID, $arrayThumbnail);
		}
		else{
			//uploading error;
		}
		
		echo $returnString;
	}
	else if($_POST["ActionType"] == "UploadPremarketImage"){
		$fileUploadtotal = count($_FILES['file']['name']);
		$TradeURL1_temp = new UploadToCloudinary();
		$TradeURL1_temp->UploadNowV3("file");
		$returnString = "";	
		if($TradeURL1_temp->uploadSuccessfully == 1){
			$TradeURL = $TradeURL1_temp->CloudinaryResult["secure_url"];
			$Trade_PublicID = $TradeURL1_temp->CloudinaryResult["public_id"];
				
			$sqlconn = new MysqlConn();
			$tradeResult = $sqlconn->AddPremarketImage($TradeURL, $Trade_PublicID, $_POST["PremarketID"]);
			$returnString = $Trade_PublicID;
			
			
			$arrayThumbnail = array("cloud_name" => "tradingjournal", "width"=>250, "crop"=>"scale", "quality"=>"auto");
			$arrayFullImage = array("cloud_name" => "tradingjournal", "quality"=>100);
			
			
			$returnString = $returnString . "{" . Cloudinary::cloudinary_url($Trade_PublicID, $arrayFullImage);
			$returnString = $returnString . "{" . Cloudinary::cloudinary_url($Trade_PublicID, $arrayThumbnail);
		}
		else{
			//uploading error;
		}
		
		echo $returnString;
	}
	else if($_POST["ActionType"] == "deleteImage"){
		
		$sqlconn = new MysqlConn();
		$sqlconn->DeleteImage($_POST["TradeID"], $_POST["PublicID"]);
				
		$oldFile = new UploadToCloudinary();
		$oldFile->Delete($_POST["PublicID"]);
		
		echo "Deleted";
	}
	else if($_POST["ActionType"] == "deletePremarketImage"){
		
		$sqlconn = new MysqlConn();
		$sqlconn->DeletePremarketImage($_POST["PremarketID"], $_POST["PublicID"]);
		
		$oldFile = new UploadToCloudinary();
		$oldFile->Delete($_POST["PublicID"]);
		
		echo "Deleted";
	}
	else if($_POST["ActionType"] == "ModifyTrade"){
		if (isset( $_POST["TradeID"]) && isset( $_POST["EntryDateTime"]) && isset( $_POST["ExitDateTime"])) {				
			$sqlconn = new MysqlConn();
			$tradeResult = $sqlconn->GetSelectedTrade($_POST["TradeID"]);

			$TradeURL1 = $tradeResult->TradeURL1;
			$TradeURL1_PublicID = $tradeResult->TradeURL1_PublicID;
			
			$IMC_URL = $tradeResult->IMC_URL;
			$IMC_URL_PublicID = $tradeResult->IMC_URL_PublicID;
									
			if (file_exists($_FILES["TradeURL1"]['tmp_name']) && is_uploaded_file($_FILES["TradeURL1"]['tmp_name'])){ 
				$TradeURL1_temp = new UploadToCloudinary();
				$TradeURL1_temp->UploadNow("TradeURL1");
				
				if($TradeURL1_temp->uploadSuccessfully == 1){
					if(isset($TradeURL1_PublicID))
					{
						$oldFile = new UploadToCloudinary();
						$oldFile->Delete($TradeURL1_PublicID);
					}
					$TradeURL1 = $TradeURL1_temp->CloudinaryResult["secure_url"];
					$TradeURL1_PublicID = $TradeURL1_temp->CloudinaryResult["public_id"];

				}
				else{
					//uploading error;
				}

			}
					
			if (file_exists($_FILES["IMC_URL"]['tmp_name']) && is_uploaded_file($_FILES["IMC_URL"]['tmp_name'])){
				$IMC_URL_temp = new UploadToCloudinary();
				$IMC_URL_temp->UploadNow("IMC_URL");

				if($IMC_URL_temp->uploadSuccessfully == 1){
					if(isset($IMC_URL_PublicID))
					{
						$oldFile = new UploadToCloudinary();
						$oldFile->Delete($IMC_URL_PublicID);
					}
					$IMC_URL = $IMC_URL_temp->CloudinaryResult["secure_url"];
					$IMC_URL_PublicID = $IMC_URL_temp->CloudinaryResult["public_id"];
				}
				else{
					//uploading error;
				}

			}
			
			$sqlconn = new MysqlConn();
			$result = $sqlconn->ModifyTrade($_POST["TradeID"], $_POST["Symbol"], $_POST["StrategyID"], $_POST["TradeType"], $_POST["OrderType"], $_POST["LotSize"], $_POST["EntryDateTime"], $_POST["EntryPrice"], $_POST["SL_Pips"], $_POST["TP_Pips"], $_POST["ExitDateTime"], $_POST["ExitPrice"], $_POST["ProfitLoss"], $_POST["Remarks"], $TradeURL1, $TradeURL1_PublicID, $_POST["IMCRemarks"], $IMC_URL, $IMC_URL_PublicID, $_POST["LessonLearn"], $_POST["PublicGUID"]);		    				    		
		    		
		    	if ( $result == true ) {
		    		header('Location: ViewTrades.php?Message='.'Trade Modified Successfully.');

		    	}
		    	else{
		    		header('Location: ViewTrades.php?Message='.'Trade Modification Failed.');
 		
		    	}
		}
	}

	else if($_POST["ActionType"] == "DeleteTrade"){
		if (isset( $_POST["TradeID"])) {
		
			$sqlconn = new MysqlConn();
			$tradeResult = $sqlconn->GetSelectedTrade($_POST["TradeID"]);

			$fileUploadtotal = count($tradeResult->TradeURL);
			for( $i=0 ; $i < $fileUploadtotal ; $i++ ) {
				$oldFile = new UploadToCloudinary();
				$oldFile->Delete($tradeResult->Trade_PublicID[$i]);
			}		

			$TradeURL1 = $tradeResult->TradeURL1;
			$TradeURL1_PublicID = $tradeResult->TradeURL1_PublicID;
			
			$IMC_URL = $tradeResult->IMC_URL;
			$IMC_URL_PublicID = $tradeResult->IMC_URL_PublicID;

			if(isset($IMC_URL_PublicID))
			{
				$oldFile = new UploadToCloudinary();
				$oldFile->Delete($IMC_URL_PublicID);
			}
		
			if(isset($TradeURL1_PublicID))
			{
				$oldFile = new UploadToCloudinary();
				$oldFile->Delete($TradeURL1_PublicID);
			}
			
			$sqlconn = new MysqlConn();
			$result = $sqlconn->DeleteTrade($_POST["TradeID"]);
			
			header('Location: ViewTrades.php?Message=Trade Deleted Successfully.');
		}
	}
	else if($_POST["ActionType"] == "AddTradeV2"){
		
		if (isset( $_POST["EntryDateTime"]) && isset( $_POST["ExitDateTime"])) {
			
			$TradeURL = array();
			$Trade_PublicID = array();
			
			$fileUploadtotal = count($_FILES['TradeImages']['name']);
			
			for( $i=0 ; $i < $fileUploadtotal && $i < 10 ; $i++ ) {
				$TradeURL1_temp = new UploadToCloudinary();
				$TradeURL1_temp->UploadNowV2("TradeImages", $i);
				
				if($TradeURL1_temp->uploadSuccessfully == 1){
					$TradeURL[$i] = $TradeURL1_temp->CloudinaryResult["secure_url"];
					$Trade_PublicID[$i] = $TradeURL1_temp->CloudinaryResult["public_id"];
				}
				else{
					//uploading error;
				}
			
			}
			
			$sqlconn = new MysqlConn();
			$result = $sqlconn->AddTradeV2($_POST["Symbol"], $_POST["StrategyID"], $_POST["TradeType"], $_POST["OrderType"], $_POST["LotSize"], $_POST["EntryDateTime"], $_POST["EntryPrice"], $_POST["SL_Pips"], $_POST["TP_Pips"], $_POST["ExitDateTime"], $_POST["ExitPrice"], $_POST["ProfitLoss"], $_POST["Remarks"], $_POST["IMCRemarks"], $_POST["LessonLearn"], $TradeURL, $Trade_PublicID);
		    		
		    	if ( $result == true ) {
		    		header('Location: ViewTrades.php?Message='.'Trade Added Successfully.');

		    	}
		    	else{
		    		header('Location: ViewTrades.php?Message='.'Trade Not Added');
 		
		    	}
		}
	}
	else if($_POST["ActionType"] == "AddTrade"){
		if (isset( $_POST["EntryDateTime"]) && isset( $_POST["ExitDateTime"])) {
			
			if (file_exists($_FILES["TradeURL1"]['tmp_name']) && is_uploaded_file($_FILES["TradeURL1"]['tmp_name'])){ 
				$TradeURL1_temp = new UploadToCloudinary();
				$TradeURL1_temp->UploadNow("TradeURL1");
				
				if($TradeURL1_temp->uploadSuccessfully == 1){
					$TradeURL1 = $TradeURL1_temp->CloudinaryResult["secure_url"];
					$TradeURL1_PublicID = $TradeURL1_temp->CloudinaryResult["public_id"];

				}
				else{
					//uploading error;
				}

			}
									
			if (file_exists($_FILES["IMC_URL"]['tmp_name']) && is_uploaded_file($_FILES["IMC_URL"]['tmp_name'])){
				$IMC_URL_temp = new UploadToCloudinary();
				$IMC_URL_temp->UploadNow("IMC_URL");
				
				if($IMC_URL_temp->uploadSuccessfully == 1){
					$IMC_URL = $IMC_URL_temp->CloudinaryResult["secure_url"];
					$IMC_URL_PublicID = $IMC_URL_temp->CloudinaryResult["public_id"];

				}
				else{
					//uploading error;
				}

			}
			
			$sqlconn = new MysqlConn();
			$result = $sqlconn->AddTrade($_POST["Symbol"], $_POST["StrategyID"], $_POST["TradeType"], $_POST["OrderType"], $_POST["LotSize"], $_POST["EntryDateTime"], $_POST["EntryPrice"], $_POST["SL_Pips"], $_POST["TP_Pips"], $_POST["ExitDateTime"], $_POST["ExitPrice"], $_POST["ProfitLoss"], $_POST["Remarks"], $TradeURL1, $TradeURL1_PublicID, $_POST["IMCRemarks"], $IMC_URL, $IMC_URL_PublicID, $_POST["LessonLearn"]);
		    		
		    	if ( $result == true ) {
		    		header('Location: main_trades.php?Message='.'Trade Added Successfully.');

		    	}
		    	else{
		    		header('Location: main_trades.php?Message='.'Trade Not Added');
 		
		    	}
		}
	}else if($_POST["ActionType"] == "DeletePreMarket"){
		if (isset( $_POST["PreMarketID"])) {
						
			$sqlconn = new MysqlConn();
			$old_result = $sqlconn->GetSelectedPreMarket($_POST["PreMarketID"]);
			
			$fileUploadtotal = count($old_result->TradeURL);
			for( $i=0 ; $i < $fileUploadtotal ; $i++ ) {
				$oldFile = new UploadToCloudinary();
				$oldFile->Delete($old_result->Trade_PublicID[$i]);
			}
			
			if(isset($old_result->MySR_PublicID)){
				$oldFile = new UploadToCloudinary();
				$oldFile->Delete($old_result->MySR_PublicID);

			}
						
			if(isset($old_result->RaymondSR_PublicID)){
				$oldFile = new UploadToCloudinary();
				$oldFile->Delete($old_result->RaymondSR_PublicID);

			}
						
			$result = $sqlconn->DeletePreMarket($_POST["PreMarketID"]);
		    		
		    	if ( $result == true ) {
		    		header('Location: ViewPremarket.php?Message=Pre-Market Delete Successfully.');

		    	}
		    	else{
		    		header('Location: ViewPremarket.php?Message=Pre-Market Delete Failed.'); 		
		    	}
		}
	}
	else if($_POST["ActionType"] == "ModifyPreMarket")
	{
		if (isset( $_POST["MarketDate"]) && isset( $_POST["PreMarketID"])) {
			$OPG430Diff = null;
			$OPG1amDiff = null;
			$Remarks = null;
			$mySR_URL = null;
			$mySR_PublicID = null;
			$RaymondSR_URL = null;
			$RaymondSR_PublicID = null;
		
			if(isset($_POST["OPG430Difference"])){
				$OPG430Diff = $_POST["OPG430Difference"];
			}
			
			if(isset($_POST["OPG1amDifference"])){
				$OPG1amDiff = $_POST["OPG1amDifference"];
			}

			if(isset($_POST["Remarks"])){
				$Remarks = $_POST["Remarks"];
			}

						
			if (file_exists($_FILES["MySRFile"]['tmp_name']) && is_uploaded_file($_FILES["MySRFile"]['tmp_name'])){ 
				$mySR_temp = new UploadToCloudinary();
				$mySR_temp->UploadNow("MySRFile");
				
				if($mySR_temp->uploadSuccessfully == 1){
					$mySR_URL = $mySR_temp->CloudinaryResult["secure_url"];
					$mySR_PublicID = $mySR_temp->CloudinaryResult["public_id"];

				}
				else{
					//uploading error;
				}

			}
									
			if (file_exists($_FILES["RaymondSRFile"]['tmp_name']) && is_uploaded_file($_FILES["RaymondSRFile"]['tmp_name'])){
				$RaymondSR_temp = new UploadToCloudinary();
				$RaymondSR_temp->UploadNow("RaymondSRFile");
				
				if($RaymondSR_temp->uploadSuccessfully == 1){
					$RaymondSR_URL = $RaymondSR_temp->CloudinaryResult["secure_url"];
					$RaymondSR_PublicID = $RaymondSR_temp->CloudinaryResult["public_id"];

				}
				else{
					//uploading error;
				}

			}
			
			$sqlconn = new MysqlConn();
			$old_result = $sqlconn->GetSelectedPreMarket($_POST["PreMarketID"]);
			if(isset($old_result->MySR_PublicID) && isset($mySR_PublicID)){
				$oldFile = new UploadToCloudinary();
				$oldFile->Delete($old_result->MySR_PublicID);

			}
			else if(isset($old_result->MySR_PublicID) && !isset($mySR_PublicID)){
				$mySR_PublicID = $old_result->MySR_PublicID;
				$mySR_URL = $old_result->MySR_URL;
			}
			
			if(isset($old_result->RaymondSR_PublicID) && isset($RaymondSR_PublicID)){
				$oldFile = new UploadToCloudinary();
				$oldFile->Delete($old_result->RaymondSR_PublicID);

			}
			else if(isset($old_result->RaymondSR_PublicID) && !isset($RaymondSR_PublicID)){
				$RaymondSR_PublicID = $old_result->RaymondSR_PublicID;
				$RaymondSR_URL = $old_result->RaymondSR_URL;
			}

			
			
			$result = $sqlconn->ModifyPreMarket($_POST["PreMarketID"], $_POST["MarketDate"], $OPG430Diff, $OPG1amDiff, $Remarks, $mySR_URL, $mySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID, $_POST["PublicGUID"]);
		    		
		    	if ( $result == true ) {
		    		header('Location: ViewPremarket.php?Message=Pre-Market Modify Successfully.');

		    	}
		    	else{
		    		header('Location: ViewPremarket.php?Message=Pre-Market Modify Failed.');
 		
		    	}
		}
	}
	else if($_POST["ActionType"] == "AddPreMarketV2"){
	
		if (isset( $_POST["MarketDate"])) {
			$OPG430Diff = null;
			$OPG1amDiff = null;
			$Remarks = null;
			$mySR_URL = null;
			$mySR_PublicID = null;
			$RaymondSR_URL = null;
			$RaymondSR_PublicID = null;
		
			if(isset($_POST["OPG430Difference"])){
				$OPG430Diff = $_POST["OPG430Difference"];
			}
			
			if(isset($_POST["OPG1amDifference"])){
				$OPG1amDiff = $_POST["OPG1amDifference"];
			}

			if(isset($_POST["Remarks"])){
				$Remarks = $_POST["Remarks"];
			}

						
			$TradeURL = array();
			$Trade_PublicID = array();
			
			$fileUploadtotal = count($_FILES['TradeImages']['name']);
			for( $i=0 ; $i < $fileUploadtotal && $i < 10; $i++ ) {
				$TradeURL1_temp = new UploadToCloudinary();
				$TradeURL1_temp->UploadNowV2("TradeImages", $i);
				
				if($TradeURL1_temp->uploadSuccessfully == 1){
					$TradeURL[$i] = $TradeURL1_temp->CloudinaryResult["secure_url"];
					$Trade_PublicID[$i] = $TradeURL1_temp->CloudinaryResult["public_id"];
				}
				else{
					//uploading error;
				}
			
			}			
					
			
			$sqlconn = new MysqlConn();
			$result = $sqlconn->AddPreMarketV2($_POST["MarketDate"], $OPG430Diff, $OPG1amDiff, $Remarks, $TradeURL, $Trade_PublicID);
				    		
		    	if ( $result == true ) {
		    		header('Location: ViewPremarket.php?Message='.'Pre-Market Added Successfully.');

		    	}
		    	else{
		    		header('Location: ViewPremarket.php?Message='.'Pre-Market Already Exists.');
 		
		    	}
		}
	}
	else if($_POST["ActionType"] == "AddPreMarket"){
		if (isset( $_POST["MarketDate"])) {
			$OPG430Diff = null;
			$OPG1amDiff = null;
			$Remarks = null;
			$mySR_URL = null;
			$mySR_PublicID = null;
			$RaymondSR_URL = null;
			$RaymondSR_PublicID = null;
		
			if(isset($_POST["OPG430Difference"])){
				$OPG430Diff = $_POST["OPG430Difference"];
			}
			
			if(isset($_POST["OPG1amDifference"])){
				$OPG1amDiff = $_POST["OPG1amDifference"];
			}

			if(isset($_POST["Remarks"])){
				$Remarks = $_POST["Remarks"];
			}

						
			if (file_exists($_FILES["MySRFile"]['tmp_name']) && is_uploaded_file($_FILES["MySRFile"]['tmp_name'])){ 
				$mySR_temp = new UploadToCloudinary();
				$mySR_temp->UploadNow("MySRFile");
				
				if($mySR_temp->uploadSuccessfully == 1){
					$mySR_URL = $mySR_temp->CloudinaryResult["secure_url"];
					$mySR_PublicID = $mySR_temp->CloudinaryResult["public_id"];

				}
				else{
					//uploading error;
				}

			}
									
			if (file_exists($_FILES["RaymondSRFile"]['tmp_name']) && is_uploaded_file($_FILES["RaymondSRFile"]['tmp_name'])){
				$RaymondSR_temp = new UploadToCloudinary();
				$RaymondSR_temp->UploadNow("RaymondSRFile");
				
				if($RaymondSR_temp->uploadSuccessfully == 1){
					$RaymondSR_URL = $RaymondSR_temp->CloudinaryResult["secure_url"];
					$RaymondSR_PublicID = $RaymondSR_temp->CloudinaryResult["public_id"];

				}
				else{
					//uploading error;
				}

			}
			
			$sqlconn = new MysqlConn();
			$result = $sqlconn->AddPreMarket($_POST["MarketDate"], $OPG430Diff, $OPG1amDiff, $Remarks, $mySR_URL, $mySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);
		    		
		    	if ( $result == true ) {
		    		header('Location: main_premarket.php?Message='.'Pre-Market Added Successfully.');

		    	}
		    	else{
		    		header('Location: main_premarket.php?Message='.'Pre-Market Already Exists.');
 		
		    	}
		}
	}
	else if($_POST["ActionType"] == "AddLessonLearn"){

		if (isset( $_POST["LessonLearnRemarks"])) {
	        
		        $sqlconn = new MysqlConn();
		        $result = $sqlconn->AddLessonLearn($_POST["LessonLearnRemarks"]);
		    		
		    	if ( $result == true ) {
		    		header('Location: ViewLessonLearn.php?Message='.'Lesson Learn Added Successfully.');

		    	}
		    	else{
		    		header('Location: ViewLessonLearn.php?Message='.'Lesson Learn Already Exists.');
 		
		    	}
		}
    	}
    	else if($_POST["ActionType"] == "ModifyLessonLearn"){
    		if (isset( $_POST[LessonLearnRemarks]) && isset( $_POST['LessonLearnID'])) {
        
		        $sqlconn = new MysqlConn();
		        $result = $sqlconn->ModifyLessonLearn($_POST['LessonLearnRemarks'], $_POST['LessonLearnID']);
		    		
		    	if ( $result == true ) {
		    		header('Location: ViewLessonLearn.php?Message='.'Lesson Learn Modified Successfully.');
		    	}
		    	else{
		    		header('Location: ViewLessonLearn.php?Message='.'Lesson Learn Does Not Exists.');
		    	}
		}

    		
    	}
    	else if($_POST["ActionType"] == "DeleteLessonLearn"){
    		if (isset( $_POST[LessonLearnRemarks]) && isset( $_POST['LessonLearnID'])) {
        
		        $sqlconn = new MysqlConn();
		        $result = $sqlconn->DeleteLessonLearn($_POST['LessonLearnRemarks'], $_POST['LessonLearnID']);
		    		
		    	// Verify user password and set $_SESSION
		    	if ( $result == true ) {
		    		header('Location: ViewLessonLearn.php?Message='.'Lesson Learn Deleted Successfully.');
		    	}
		    	else{
		    		header('Location: ViewLessonLearn.php?Message='.'Delete Lesson Learn Fail.');
		    	}
		}

    		
    	}

	
	else if($_POST["ActionType"] == "AddStrategy"){

		if (isset( $_POST["StrategyName"])) {
	        
		        $sqlconn = new MysqlConn();
		        $result = $sqlconn->AddStrategy($_POST["StrategyName"]);
		    		
		    	// Verify user password and set $_SESSION
		    	if ( $result == true ) {
		    		header('Location: ViewStrategy.php?Message='.'Strategy Added Successfully.');

		    	}
		    	else{
		    		header('Location: ViewStrategy.php?Message='.'Strategy Already Exists.');
 		
		    	}
		}
    	}
    	else if($_POST["ActionType"] == "ModifyStrategy"){
    		if (isset( $_POST['StrategyName']) && isset( $_POST['StrategyID'])) {
        
		        $sqlconn = new MysqlConn();
		        $result = $sqlconn->ModifyStrategy($_POST['StrategyName'], $_POST['StrategyID']);
		    		
		    	// Verify user password and set $_SESSION
		    	if ( $result == true ) {
		    		header('Location: ViewStrategy.php?Message='.'Strategy Modified Successfully.');
		    	}
		    	else{
		    		header('Location: ViewStrategy.php?Message='.'Strategy Does Not Exists.');
		    	}
		}

    		
    	}
    	else if($_POST["ActionType"] == "DeleteStrategy"){
    		if (isset( $_POST['StrategyName']) && isset( $_POST['StrategyID'])) {
        
		        $sqlconn = new MysqlConn();
		        $result = $sqlconn->DeleteStrategy($_POST['StrategyName'], $_POST['StrategyID']);
		    		
		    	// Verify user password and set $_SESSION
		    	if ( $result == true ) {
		    		header('Location: ViewStrategy.php?Message='.'Strategy Deleted Successfully.');
		    	}
		    	else{
		    		header('Location: ViewStrategy.php?Message='.'Delete Strategy Fail.');
		    	}
		}

    		
    	}
	else if($_POST["ActionType"] == "ForgotPassword"){
    		if ( isset( $_POST['username'] ) ) {
        
		        $sqlconn = new MysqlConn();
		        $result = $sqlconn->ForgotPassword($_POST['username']);
		    	
		    	if(strlen($result->ResetPasswordToken) > 11){
		    		$sendMail = new SendEmail();
				$sendMail->SendResetPasswordEmailNow($_POST['username'], $result->ResetPasswordToken, $result->Name);
		    	
		    	}
		    		
		    	header('Location: login.php?Message=ForgotPasswordOK');
		}
		
    	}
    	else if($_POST["ActionType"] == "VerifyLogin"){
    		if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
        
		        $sqlconn = new MysqlConn();
		        $result = $sqlconn->VerifyLogin($_POST['username'], $_POST['password']);
		    		
		    	// Verify user password and set $_SESSION
		    	if ( $result == true ) {
		    		header('Location: main.php');
		    	}
		    	else{
		    		header('Location: login.php?Message=Login Fail');   		
		    	}
		}
		
    	}
    	else if($_POST["ActionType"] == "AddUser"){
		if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) && isset( $_POST['name'] ) ) {
        
		        $sqlconn = new MysqlConn();
		        $result = $sqlconn->AddUser($_POST['username'], $_POST['password'], $_POST['name']);		    				    				    			    			    				    				    		
		    		
		    	if ( substr( $result, 0, 2 ) === "OK" ) {
		    		
		    		$result = substr( $result, 2, 99 );
		    		$sendMail = new SendEmail();
				$sendMail->SendVerifyUserEmailNow($_POST['username'], $_POST['name'], $result);
				header('Location: login.php?Message=OK');
		    	}
		    	else if ( $result == "UnverifiedFound" ){
		    		header('Location: login.php?Message=UnverifiedFound');   		
		    	}
		    	else if ( $result == "UserNameExist" ){
		    		header('Location: login.php?Message=UserNameExist');   		
		    	}
		}
		
	}
	else if($_POST["ActionType"] == "ResetPasswordNow"){
		
		if (isset( $_POST['password'] ) && isset( $_POST['Token'] ) ) {
        
        		$sqlconn = new MysqlConn();
			$UserGUID = $sqlconn->VerifyResetPaswoordToken($_POST['Token']);
			if(isset($UserGUID)){
        			$sqlconn = new MysqlConn();
		        	$result = $sqlconn->UpdateUserPassword($UserGUID, $_POST['password']);
		        	if ( $result == 1 ){
		    			header('Location: login.php?Message=PasswordChanged');   		
		    		}

		        }
		        else{
		        	header('Location: login.php?Message=ResetPasswordTokenExpired');
		        }
		
		}
	}

}
?>