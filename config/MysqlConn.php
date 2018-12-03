<?php

include './config/AllClasses.php';

class MysqlConn {

    	public $conn;
    	public $conn2;

	function __construct()    {
	    $this->conn= NULL;
	    $this->conn= new mysqli('localhost', 'wefewfwe_KS', 'yWqikr1981', 'wefewfwe_tradingjournal');
	    
	    $this->conn2= NULL;
	    $this->conn2= new mysqli('localhost', 'wefewfwe_KS', 'yWqikr1981', 'wefewfwe_tradingjournal');
	}			    
	
	function AddImage($TradeURL, $Trade_PublicID, $TradeID)  {
	    
	    $stmt = $this->conn->prepare("INSERT INTO tb_TradePix(UserGUID, TradeID, URL, PublicID) VALUES (?, ?, ?, ?)");
	    $stmt->bind_param('iiss', $_SESSION['UserGUID'], $TradeID, $TradeURL, $Trade_PublicID);
	    $stmt->execute();
	    $stmt->close();
	}
	
	function ModifyTrade($TradeID, $Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID, $LessonLearn)  {
	    
	    if (true) {
	   	
	   	$sqlconn1 = new MysqlConn();	   		  	   	
		$result = $sqlconn1->DeleteTradeNotImage($TradeID);		
 	
	   	$sqlconn1 = new MysqlConn();
		$result = $sqlconn1->AddTrade($Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID, $LessonLearn, $TradeID);
		
		return $result;	    
	    }
	}

	
	function GetSelectedTrade($TradeID)  {
	    $stmt = $this->conn->prepare("SELECT A.TradeID, A.Symbol, B.StrategyName, A.TradeType, A.OrderType, A.LotSize, A.EntryDateTime, A.EntryPrice, A.SL_Pips, A.TP_Pips, A.ExitDateTime,
	    				 A.ExitPrice, A.ProfitLoss, A.Remarks, A.TradeURL1, A.TradeURL1_PublicID, A.IMCRemarks, A.IMC_URL, A.IMC_URL_PublicID,
					(SELECT GROUP_CONCAT(Y.LessonLearnRemarks SEPARATOR ', ')
					FROM tb_TradesLessonLearn AS Z
					INNER JOIN tb_LessonLearn AS Y ON Z.UserGUID = Y.UserGUID AND Z.LessonLearnID = Y.LessonLearnID
					WHERE Z.UserGUID = A.UserGUID AND Z.TradeID = A.TradeID
					GROUP BY Z.TradeID) AS LessonLearn
					FROM tb_Trades AS A 
					INNER JOIN tb_Strategy AS B ON A.StrategyID = B.StrategyID AND A.UserGUID = B.UserGUID
					WHERE A.UserGUID = ? AND TradeID = ? ORDER BY EntryDateTime DESC");
	    $stmt->bind_param('ii', $_SESSION['UserGUID'], $TradeID);
	    $stmt->execute();	     		 
	    $stmt->bind_result($TradeID, $Symbol, $StrategyName, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID, $LessonLearn);
	    
	    
	    
	   while ($stmt->fetch()) {
	    	$temp_trade = new Trade();
	    	$temp_trade->TradeID= $TradeID;
                $temp_trade->Symbol= $Symbol;
		$temp_trade->StrategyName= $StrategyName;
		$temp_trade->TradeType= $TradeType;
		$temp_trade->OrderType= $OrderType;
		$temp_trade->LotSize= $LotSize;
		$temp_trade->EntryDateTime= $EntryDateTime;
		$temp_trade->EntryPrice= $EntryPrice;
		$temp_trade->SL_Pips= $SL_Pips;
		$temp_trade->TP_Pips= $TP_Pips;
		$temp_trade->ExitDateTime= $ExitDateTime;
		$temp_trade->ExitPrice= $ExitPrice;
		$temp_trade->ProfitLoss= $ProfitLoss;
		$temp_trade->TradeURL1= $TradeURL1;
		$temp_trade->TradeURL1_PublicID= $TradeURL1_PublicID;
		$temp_trade->Remarks= $Remarks;
		$temp_trade->IMCRemarks= $IMCRemarks;
		$temp_trade->IMC_URL= $IMC_URL;
		$temp_trade->IMC_URL_PublicID= $IMC_URL_PublicID;
		$temp_trade->LessonLearn= $LessonLearn;
					
       	    }
       	    $stmt->close();
       	    
       	    $stmt = $this->conn->prepare("SELECT URL, PublicID FROM tb_TradePix WHERE UserGUID = ? AND TradeID = ?");	    	
	    $stmt->bind_param('ii', $_SESSION['UserGUID'], $TradeID);
	    $stmt->execute();	    		    	
	    $stmt->bind_result($URL, $PublicID);
	    
	    $index = 0;
       	    while ($stmt->fetch()) {
       	    	$temp_trade->TradeURL[$index] = $URL;
       	    	$temp_trade->Trade_PublicID[$index] = $PublicID;
       	    	$index = $index + 1;
       	    }
       	    $stmt->close();
       	    return $temp_trade;	
	}

	function DeleteTradeNotImage($TradeID)  {
		$stmt = $this->conn->prepare("DELETE FROM tb_TradesLessonLearn WHERE UserGUID = ? AND TradeID = ?");	    	
	    	$stmt->bind_param('ii', $_SESSION['UserGUID'], $TradeID);
	    	$stmt->execute();	    		    	
	    	$stmt->close();
	    			
		$stmt = $this->conn->prepare("DELETE FROM tb_Trades WHERE UserGUID = ? AND TradeID = ?");	    	
	    	$stmt->bind_param('ii', $_SESSION['UserGUID'], $TradeID);
	    	$stmt->execute();	    		    	
	    	$stmt->close();
	    	
	    	return true;
	}
	
	function DeleteImage($TradeID, $PublicID){
		$stmt = $this->conn->prepare("DELETE FROM tb_TradePix WHERE UserGUID = ? AND TradeID = ? AND PublicID = ?");	    	
	    	$stmt->bind_param('iis', $_SESSION['UserGUID'], $TradeID, $PublicID);
	    	$stmt->execute();	    		    	
	    	$stmt->close();	    		    	
	    	
	    	return true;
	}
	
	function DeleteTrade($TradeID)  {
		$stmt = $this->conn->prepare("DELETE FROM tb_TradesLessonLearn WHERE UserGUID = ? AND TradeID = ?");	    	
	    	$stmt->bind_param('ii', $_SESSION['UserGUID'], $TradeID);
	    	$stmt->execute();	    		    	
	    	$stmt->close();
	    	
	    	$stmt = $this->conn->prepare("DELETE FROM tb_TradePix WHERE UserGUID = ? AND TradeID = ?");	    	
	    	$stmt->bind_param('ii', $_SESSION['UserGUID'], $TradeID);
	    	$stmt->execute();	    		    	
	    	$stmt->close();
		
		$stmt = $this->conn->prepare("DELETE FROM tb_Trades WHERE UserGUID = ? AND TradeID = ?");	    	
	    	$stmt->bind_param('ii', $_SESSION['UserGUID'], $TradeID);
	    	$stmt->execute();	    		    	
	    	$stmt->close();
	    	
	    	return true;
	}
	
	function AddTradeV2($Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks,  $IMCRemarks, $LessonLearn, $TradeURL, $Trade_PublicID, $TradeID = -1)  {
	    
	    if (true) {
	   	
	   	if($TradeID == -1){
	    		$stmt = $this->conn->prepare("INSERT INTO tb_Trades(UserGUID, Symbol, StrategyID, TradeType, OrderType, LotSize, EntryDateTime, EntryPrice, SL_Pips, TP_Pips, ExitDateTime, ExitPrice, ProfitLoss, Remarks, IMCRemarks) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	    		    	
	    		$stmt->bind_param('isissdsdiisddss', $_SESSION['UserGUID'], $Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $IMCRemarks);	
    	    	}
    	    	else{
    	    		$stmt = $this->conn->prepare("INSERT INTO tb_Trades(UserGUID, Symbol, StrategyID, TradeType, OrderType, LotSize, EntryDateTime, EntryPrice, SL_Pips, TP_Pips, ExitDateTime, ExitPrice, ProfitLoss, Remarks, IMCRemarks, TradeID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	    		    	
	    		$stmt->bind_param('isissdsdiisddssi', $_SESSION['UserGUID'], $Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $IMCRemarks, $TradeID);
    	    	}
	    	$stmt->execute();	    	
	    	$insertID = mysqli_insert_id($this->conn);	   	
	    	$stmt->close();
	    	
	    	for ($i = 0; $i < count($TradeURL); $i++) {
	    		$stmt = $this->conn->prepare("INSERT INTO tb_TradePix(UserGUID, TradeID, URL, PublicID) VALUES (?, ?, ?, ?)");
	    		$stmt->bind_param('iiss', $_SESSION['UserGUID'], $insertID, $TradeURL[$i], $Trade_PublicID[$i]);
	    		$stmt->execute();
	    		$stmt->close();
		}    	
	    	
	    	for ($i = 0; $i < count($LessonLearn); $i++) {
	    		$stmt = $this->conn->prepare("INSERT INTO tb_TradesLessonLearn(UserGUID, TradeID, LessonLearnID) VALUES (?, ?, ?)");
	    		$stmt->bind_param('iii', $_SESSION['UserGUID'], $insertID, $LessonLearn[$i]);
	    		$stmt->execute();
	    		$stmt->close();
		}
		
		if($insertID > 1){    	    	
	    		return true;	
	    	}
	    	else{
	    		return false;	
	    	}
	    }
	}
	
	function AddTrade($Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID, $LessonLearn, $TradeID = -1)  {
	    
	    if (true) {
	   	
	   	if($TradeID == -1){
	    		$stmt = $this->conn->prepare("INSERT INTO tb_Trades(UserGUID, Symbol, StrategyID, TradeType, OrderType, LotSize, EntryDateTime, EntryPrice, SL_Pips, TP_Pips, ExitDateTime, ExitPrice, ProfitLoss, Remarks, TradeURL1, TradeURL1_PublicID, IMCRemarks, IMC_URL, IMC_URL_PublicID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	    		    	
	    		$stmt->bind_param('isissdsdiisddssssss', $_SESSION['UserGUID'], $Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID);	
    	    	}
    	    	else{
    	    		$stmt = $this->conn->prepare("INSERT INTO tb_Trades(UserGUID, Symbol, StrategyID, TradeType, OrderType, LotSize, EntryDateTime, EntryPrice, SL_Pips, TP_Pips, ExitDateTime, ExitPrice, ProfitLoss, Remarks, TradeURL1, TradeURL1_PublicID, IMCRemarks, IMC_URL, IMC_URL_PublicID, TradeID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	    		    	
	    		$stmt->bind_param('isissdsdiisddssssssi', $_SESSION['UserGUID'], $Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID, $TradeID);
    	    	}
	    	$stmt->execute();	    	
	    	$insertID = mysqli_insert_id($this->conn);	   	
	    	$stmt->close();
	    	
	    	
	    	
	    	for ($i = 0; $i < count($LessonLearn); $i++) {
	    		$stmt = $this->conn->prepare("INSERT INTO tb_TradesLessonLearn(UserGUID, TradeID, LessonLearnID) VALUES (?, ?, ?)");
	    		$stmt->bind_param('iii', $_SESSION['UserGUID'], $insertID, $LessonLearn[$i]);
	    		$stmt->execute();
	    		$stmt->close();
		}
		if($insertID > 1){    	    	
	    		return true;	
	    	}
	    	else{
	    		return false;	
	    	}
	    }
	}
	
	function GetAllTrades()  {
	    $stmt = $this->conn->prepare("SELECT A.TradeID, A.Symbol, B.StrategyName, A.TradeType, A.OrderType, A.LotSize, A.EntryDateTime, A.EntryPrice, A.SL_Pips, A.TP_Pips, A.ExitDateTime,
	    				 A.ExitPrice, A.ProfitLoss, A.Remarks, A.TradeURL1, A.IMCRemarks, A.IMC_URL,
					(SELECT GROUP_CONCAT(Y.LessonLearnRemarks SEPARATOR ', ')
					FROM tb_TradesLessonLearn AS Z
					INNER JOIN tb_LessonLearn AS Y ON Z.UserGUID = Y.UserGUID AND Z.LessonLearnID = Y.LessonLearnID
					WHERE Z.UserGUID = A.UserGUID AND Z.TradeID = A.TradeID
					GROUP BY Z.TradeID) AS LessonLearn
					FROM tb_Trades AS A 
					INNER JOIN tb_Strategy AS B ON A.StrategyID = B.StrategyID AND A.UserGUID = B.UserGUID
					WHERE A.UserGUID = ? ORDER BY EntryDateTime DESC");
	    $stmt->bind_param('i', $_SESSION['UserGUID']);
	    $stmt->execute();	     		 
	    $stmt->bind_result($TradeID, $Symbol, $StrategyName, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $IMCRemarks, $IMC_URL, $LessonLearn);
	    
	    
	    
	    $array = array();
	    while ($stmt->fetch()) {
	    	$temp_trade = new Trade();
	    	$temp_trade->TradeID= $TradeID;
                $temp_trade->Symbol= $Symbol;
		$temp_trade->StrategyName= $StrategyName;
		$temp_trade->TradeType= $TradeType;
		$temp_trade->OrderType= $OrderType;
		$temp_trade->LotSize= $LotSize;
		$temp_trade->EntryDateTime= $EntryDateTime;
		$temp_trade->EntryPrice= $EntryPrice;
		$temp_trade->SL_Pips= $SL_Pips;
		$temp_trade->TP_Pips= $TP_Pips;
		$temp_trade->ExitDateTime= $ExitDateTime;
		$temp_trade->ExitPrice= $ExitPrice;
		$temp_trade->ProfitLoss= $ProfitLoss;
		$temp_trade->TradeURL1= $TradeURL1;
		$temp_trade->Remarks= $Remarks;
		$temp_trade->IMCRemarks= $IMCRemarks;
		$temp_trade->IMC_URL= $IMC_URL;
		$temp_trade->LessonLearn= $LessonLearn;
		if(strlen($LessonLearn) == 0 || is_null($LessonLearn)){
			$temp_trade->LessonLearn = "-";
		}


		$stmt2 = $this->conn2->prepare("SELECT URL, PublicID FROM tb_TradePix WHERE UserGUID = ? AND TradeID = ?");	    	
		$stmt2->bind_param('ii', $_SESSION['UserGUID'], $TradeID);
		$stmt2->execute();	    		    	
		$stmt2->bind_result($URL, $PublicID);
		    
		$index = 0;
	       	while ($stmt2->fetch()) {
	       	 $temp_trade->TradeURL[$index] = $URL;
	       	 $temp_trade->Trade_PublicID[$index] = $PublicID;
	       	 $index = $index + 1;
	       	}
	       	$stmt2->close();

		array_push($array , $temp_trade);			
       	    }
       	    
       	    return $array;	
	}

	
	function DeletePreMarket($PreMarketID)  {
	    $stmt = $this->conn->prepare("DELETE FROM tb_PreMarket WHERE PreMarketID = ?");
	    $stmt->bind_param('i', $PreMarketID);
	    $stmt->execute();	    		 
	    $stmt->close();	
	    
	    return true;	    
	}

	
	function ModifyPreMarket($PreMarketID, $Date, $OPG430Difference, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID)  {
	    $stmt = $this->conn->prepare("DELETE FROM tb_PreMarket WHERE PreMarketID = ?");
	    $stmt->bind_param('i', $PreMarketID);
	    $stmt->execute();	    		 
	    $stmt->close();	
	    
	    if ( !isset($PreMarketID) ) {
	    	
	    	return false;
	    }
	    else{
	    	$column = "UserGUID, MarketDate, ";
	    	$type = "is";
	    	$questionmark = "?, ?, ";
	    	if(isset($OPG430Difference) && strlen($OPG430Difference) > 0)
	    	{
	    		$column = $column."OPG430Difference".", ";
	    		$type = $type ."i";
	    		$questionmark = $questionmark."?, ";
	    	}
	    	
	    	if(isset($OPG1amDifference) && strlen($OPG1amDifference) > 0)
	    	{
	    		$column = $column."OPG1amDifference".", ";
	    		$type = $type ."i";
	    		$questionmark = $questionmark."?, ";
	    	}

		$column = $column."Remarks, MySR_URL, MySR_PublicID, RaymondSR_URL,RaymondSR_PublicID";
	    	$type = $type ."sssss";
		$questionmark = $questionmark."?, ?, ?, ?, ?";
	    	
	    	$stmt = $this->conn->prepare("INSERT INTO tb_PreMarket (".$column.") VALUES(".$questionmark.")");

	    		    	
	    	if(isset($OPG430Difference) && strlen($OPG430Difference) > 0 && isset($OPG1amDifference) && strlen($OPG1amDifference) > 0)
		{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $OPG430Difference, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);

		}
		else if(isset($OPG430Difference) && strlen($OPG430Difference) > 0)
	    	{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $OPG430Difference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);

		}
		else if(isset($OPG1amDifference) && strlen($OPG1amDifference) > 0)
	    	{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);

		}
		else
		{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);
		}
	    		    		    	
	    	$stmt->execute();		    		    	
	    	$stmt->close();
	    	    	
	    	$stmt = $this->conn->prepare("SELECT PreMarketID FROM tb_PreMarket WHERE UserGUID = ? AND MarketDate = ?");
		$stmt->bind_param('is', $_SESSION['UserGUID'], $Date);
		$stmt->execute();
		$stmt->bind_result($PreMarketID );
		$stmt->fetch();			    
	        $stmt->close();
	        
	        if ( isset($PreMarketID ) ) {
	    	
	    	    return true;
	        }
	    	else{
	    		return false;   	
	    	}	
	    }
	}

	
	function GetSelectedPreMarket($id)  {
	
	    $stmt = $this->conn->prepare("SELECT PreMarketID, MarketDate, OPG430Difference, OPG1amDifference, Remarks, MySR_URL, MySR_PublicID, RaymondSR_URL, RaymondSR_PublicID FROM tb_PreMarket WHERE UserGUID = ? AND PreMarketID = ? ORDER BY MarketDate DESC");
	    $stmt->bind_param('ii', $_SESSION['UserGUID'], $id);
	    $stmt->execute();	     		 
	    $stmt->bind_result($PreMarketID, $MarketDate, $OPG430Difference, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);
	    
	    $array = array();
	    $stmt->fetch();
	    $temp_premarket = new PreMarket();
	    $temp_premarket->PreMarketID= $PreMarketID;
	    $temp_premarket->MarketDate= $MarketDate;
	    $temp_premarket->OPG430Difference= $OPG430Difference;
	    $temp_premarket->OPG1amDifference= $OPG1amDifference;
	    $temp_premarket->Remarks= $Remarks;
	    $temp_premarket->MySR_URL= $MySR_URL;
	    $temp_premarket->MySR_PublicID= $MySR_PublicID;
	    $temp_premarket->RaymondSR_URL= $RaymondSR_URL;
	    $temp_premarket->RaymondSR_PublicID= $RaymondSR_PublicID;
	       	    
       	    return $temp_premarket;	
	}

	
	function GetAllPreMarket()  {
	    $stmt = $this->conn->prepare("SELECT PreMarketID, MarketDate, OPG430Difference, OPG1amDifference, Remarks, MySR_URL, MySR_PublicID, RaymondSR_URL, RaymondSR_PublicID FROM tb_PreMarket WHERE UserGUID = ? ORDER BY MarketDate DESC");
	    $stmt->bind_param('i', $_SESSION['UserGUID']);
	    $stmt->execute();	     		 
	    $stmt->bind_result($PreMarketID, $MarketDate, $OPG430Difference, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);
	    
	    $array = array();
	    while ($stmt->fetch()) {
	    	$temp_premarket = new PreMarket();
	    	$temp_premarket->PreMarketID= $PreMarketID;
		$temp_premarket->MarketDate= $MarketDate;
		$temp_premarket->OPG430Difference= $OPG430Difference;
		$temp_premarket->OPG1amDifference= $OPG1amDifference;
		$temp_premarket->Remarks= $Remarks;
		$temp_premarket->MySR_URL= $MySR_URL;
		$temp_premarket->MySR_PublicID= $MySR_PublicID;
		$temp_premarket->RaymondSR_URL= $RaymondSR_URL;
		$temp_premarket->RaymondSR_PublicID= $RaymondSR_PublicID;

		array_push($array , $temp_premarket);			
       	    }
       	    
       	    return $array;	
	}

	
	function AddPreMarket($Date, $OPG430Difference, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID)  {
	    $stmt = $this->conn->prepare("SELECT PreMarketID FROM tb_PreMarket WHERE UserGUID = ? AND MarketDate = ?");
	    $stmt->bind_param('is', $_SESSION['UserGUID'], $Date);
	    $stmt->execute();
	    $stmt->bind_result($PreMarketID);
	    $stmt->fetch();	    		 
	    $stmt->close();	
	    
	    if ( isset($PreMarketID) ) {
	    	
	    	return false;
	    }
	    else{
	    	$column = "UserGUID, MarketDate, ";
	    	$type = "is";
	    	$questionmark = "?, ?, ";
	    	if(isset($OPG430Difference) && strlen($OPG430Difference) > 0)
	    	{
	    		$column = $column."OPG430Difference".", ";
	    		$type = $type ."i";
	    		$questionmark = $questionmark."?, ";
	    	}
	    	
	    	if(isset($OPG1amDifference) && strlen($OPG1amDifference) > 0)
	    	{
	    		$column = $column."OPG1amDifference".", ";
	    		$type = $type ."i";
	    		$questionmark = $questionmark."?, ";
	    	}

		$column = $column."Remarks, MySR_URL, MySR_PublicID, RaymondSR_URL,RaymondSR_PublicID";
	    	$type = $type ."sssss";
		$questionmark = $questionmark."?, ?, ?, ?, ?";
	    	
	    	$stmt = $this->conn->prepare("INSERT INTO tb_PreMarket (".$column.") VALUES(".$questionmark.")");

	    		    	
	    	if(isset($OPG430Difference) && strlen($OPG430Difference) > 0 && isset($OPG1amDifference) && strlen($OPG1amDifference) > 0)
		{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $OPG430Difference, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);

		}
		else if(isset($OPG430Difference) && strlen($OPG430Difference) > 0)
	    	{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $OPG430Difference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);

		}
		else if(isset($OPG1amDifference) && strlen($OPG1amDifference) > 0)
	    	{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);

		}
		else
		{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);
		}
	    		    		    	
	    	$stmt->execute();		    		    	
	    	$stmt->close();
	    	    	
	    	$stmt = $this->conn->prepare("SELECT PreMarketID FROM tb_PreMarket WHERE UserGUID = ? AND MarketDate = ?");
		$stmt->bind_param('is', $_SESSION['UserGUID'], $Date);
		$stmt->execute();
		$stmt->bind_result($PreMarketID );
		$stmt->fetch();			    
	        $stmt->close();
	        
	        if ( isset($PreMarketID ) ) {
	    	
	    	    return true;
	        }
	    	else{
	    		return false;   	
	    	}	
	    }
	}

	
	function AddLessonLearn($LessonLearnRemarks)  {
	    $stmt = $this->conn->prepare("SELECT LessonLearnID FROM tb_LessonLearn WHERE UserGUID = ? AND LessonLearnRemarks = ?");
	    $stmt->bind_param('is', $_SESSION['UserGUID'], $LessonLearnRemarks);
	    $stmt->execute();
	    $stmt->bind_result($LessonLearnID);
	    $stmt->fetch();	    		 
	    $stmt->close();	
	    
	    if ( isset($LessonLearnID) ) {
	    	
	    	return false;
	    }
	    else{
	    	
	    	$stmt = $this->conn->prepare("INSERT INTO tb_LessonLearn (UserGUID, LessonLearnRemarks) VALUES(?, ?)");	    	
	    	$stmt->bind_param('is', $_SESSION['UserGUID'], $LessonLearnRemarks);
	    	$stmt->execute();		    		    	
	    	$stmt->close();
	    	    	
	    	$stmt = $this->conn->prepare("SELECT LessonLearnID FROM tb_LessonLearn WHERE UserGUID = ? AND LessonLearnRemarks = ?");
		$stmt->bind_param('is', $_SESSION['UserGUID'], $LessonLearnRemarks);
		$stmt->execute();
		$stmt->bind_result($LessonLearnID);
		$stmt->fetch();			    
	        $stmt->close();
	        
	        if ( isset($LessonLearnID) ) {
	    	
	    	    return true;
	        }
	    	else{
	    		return false;   	
	    	}	
	    }
	}

	
	function ModifyLessonLearn($LessonLearnRemarks, $old_LessonLearnID)  {
	    $stmt = $this->conn->prepare("SELECT LessonLearnID FROM tb_LessonLearn WHERE UserGUID = ? AND LessonLearnID = ?");
	    $stmt->bind_param('ii', $_SESSION['UserGUID'], $old_LessonLearnID);
	    $stmt->execute();
	    $stmt->bind_result($LessonLearnID);
	    $stmt->fetch();	    		 
	    
	    $stmt->close();	
	    
	    if ( !isset($LessonLearnID) ) {
	    	
	    	return false;
	    }
	    else{	    	
	    	$stmt = $this->conn->prepare("UPDATE tb_LessonLearn SET LessonLearnRemarks = ? WHERE UserGUID = ? AND LessonLearnID = ?");	    	      	
	    	$stmt->bind_param('sii', $LessonLearnRemarks, $_SESSION['UserGUID'], $old_LessonLearnID);
	    	$status = $stmt->execute();		    		    	   	
	    	$stmt->close();
	    	    	
	    	$stmt = $this->conn->prepare("SELECT LessonLearnID FROM tb_LessonLearn WHERE UserGUID = ? AND LessonLearnRemarks = ? AND LessonLearnID = ?");
		$stmt->bind_param('isi', $_SESSION['UserGUID'], $LessonLearnRemarks, $old_LessonLearnID);
		$stmt->execute();
		$stmt->bind_result($LessonLearnID);
		$stmt->fetch();			    
	        $stmt->close();
	        
	        if ( isset($LessonLearnID) ) {
	    	
	    	    return true;
	        }
	    	else{
	    		return false;   	
	    	}	
	    }
	}

	
	function DeleteLessonLearn($LessonLearnRemarks, $old_LessonLearnID)  {
	    $stmt = $this->conn->prepare("SELECT Count(1) FROM tb_TradesLessonLearn WHERE UserGUID = ? AND LessonLearnID = ?");
	    $stmt->bind_param('ii', $_SESSION['UserGUID'], $old_LessonLearnID);
	    $stmt->execute();
	    $stmt->bind_result($count);
	    $stmt->fetch();	    		 
	    
	    $stmt->close();	
	    
	    if ( isset($count) && $count > 0 ) {
	    	
	    	return false;
	    }
	    else{	    		    	
	    	$stmt = $this->conn->prepare("DELETE FROM tb_LessonLearn WHERE UserGUID = ? AND LessonLearnID = ?");	    		 	      	
	    	$stmt->bind_param('ii', $_SESSION['UserGUID'], $old_LessonLearnID);
	    	$status = $stmt->execute();		    		    	   	
	    	$stmt->close();
	    	    	
	    	$stmt = $this->conn->prepare("SELECT LessonLearnID FROM tb_LessonLearn WHERE UserGUID = ? AND LessonLearnRemarks = ? AND LessonLearnID = ?");
		$stmt->bind_param('isi', $_SESSION['UserGUID'], $LessonLearnRemarks, $old_LessonLearnID);
		$stmt->execute();
		$stmt->bind_result($LessonLearnID);
		$stmt->fetch();			    
	        $stmt->close();
	        
	        if ( !isset($LessonLearnID) ) {
	    	
	    	    return true;
	        }
	    	else{
	    		return false;   	
	    	}	
	    }
	}

	
	function GetAllLessonLearn()  {
	    $stmt = $this->conn->prepare("SELECT LessonLearnID, LessonLearnRemarks FROM tb_LessonLearn WHERE UserGUID = ?");
	    $stmt->bind_param('i', $_SESSION['UserGUID']);
	    $stmt->execute();	     		 
	    $stmt->bind_result($LessonLearnID, $LessonLearnRemarks );
	    
	    $array = array();
	    while ($stmt->fetch()) {
	    	$temp_lessonlearn = new LessonLearn();
	    	$temp_lessonlearn ->LessonLearnRemarks = $LessonLearnRemarks ;
		$temp_lessonlearn ->LessonLearnID= $LessonLearnID;
		array_push($array , $temp_lessonlearn );			
       	    }
       	    
       	    return $array;	
	}

	
	function GetAllStrategy()  {
	    $stmt = $this->conn->prepare("SELECT StrategyID, StrategyName FROM tb_Strategy WHERE UserGUID = ?");
	    $stmt->bind_param('i', $_SESSION['UserGUID']);
	    $stmt->execute();	     		 
	    $stmt->bind_result($StrategyID, $StrategyName );
	    
	    $array = array();
	    while ($stmt->fetch()) {
	    	$temp_strategy = new Strategy();
	    	$temp_strategy->StrategyName = $StrategyName;
		$temp_strategy->StrategyID= $StrategyID;
		array_push($array , $temp_strategy);			
       	    }
       	    
       	    return $array;	
	}

	function DeleteStrategy($StrategyName, $old_StrategyID)  {
	    $stmt = $this->conn->prepare("SELECT Count(1) FROM tb_Trades WHERE UserGUID = ? AND StrategyID = ?");
	    $stmt->bind_param('ii', $_SESSION['UserGUID'], $old_StrategyID);
	    $stmt->execute();
	    $stmt->bind_result($count);
	    $stmt->fetch();	    		 
	    
	    $stmt->close();	
	    // Verify user password and set $_SESSION
	    if ( isset($count) && $count > 0 ) {
	    	
	    	return false;
	    }
	    else{	    		    	
	    	$stmt = $this->conn->prepare("DELETE FROM tb_Strategy WHERE UserGUID = ? AND StrategyID = ?");	    		 	      	
	    	$stmt->bind_param('ii', $_SESSION['UserGUID'], $old_StrategyID);
	    	$status = $stmt->execute();		    		    	   	
	    	$stmt->close();
	    	    	
	    	$stmt = $this->conn->prepare("SELECT StrategyID FROM tb_Strategy WHERE UserGUID = ? AND StrategyName = ? AND StrategyID = ?");
		$stmt->bind_param('isi', $_SESSION['UserGUID'], $StrategyName, $old_StrategyID);
		$stmt->execute();
		$stmt->bind_result($StrategyID);
		$stmt->fetch();			    
	        $stmt->close();
	        
	        if ( !isset($StrategyID) ) {
	    	
	    	    return true;
	        }
	    	else{
	    		return false;   	
	    	}	
	    }
	}

	
	function ModifyStrategy($StrategyName, $old_StrategyID)  {
	    $stmt = $this->conn->prepare("SELECT StrategyID FROM tb_Strategy WHERE UserGUID = ? AND StrategyID = ?");
	    $stmt->bind_param('ii', $_SESSION['UserGUID'], $old_StrategyID);
	    $stmt->execute();
	    $stmt->bind_result($StrategyID);
	    $stmt->fetch();	    		 
	    
	    $stmt->close();	
	    // Verify user password and set $_SESSION
	    if ( !isset($StrategyID) ) {
	    	
	    	return false;
	    }
	    else{	    	
	    	$stmt = $this->conn->prepare("UPDATE tb_Strategy SET StrategyName = ? WHERE UserGUID = ? AND StrategyID = ?");	    		 	      	
	    	$stmt->bind_param('sii', $StrategyName, $_SESSION['UserGUID'], $old_StrategyID);
	    	$status = $stmt->execute();		    		    	   	
	    	$stmt->close();
	    	    	
	    	$stmt = $this->conn->prepare("SELECT StrategyID FROM tb_Strategy WHERE UserGUID = ? AND StrategyName = ? AND StrategyID = ?");
		$stmt->bind_param('isi', $_SESSION['UserGUID'], $StrategyName, $old_StrategyID);
		$stmt->execute();
		$stmt->bind_result($StrategyID);
		$stmt->fetch();			    
	        $stmt->close();
	        
	        if ( isset($StrategyID) ) {
	    	
	    	    return true;
	        }
	    	else{
	    		return false;   	
	    	}	
	    }
	}
	
	function AddStrategy($StrategyName)  {
	    $stmt = $this->conn->prepare("SELECT StrategyID FROM tb_Strategy WHERE UserGUID = ? AND StrategyName = ?");
	    $stmt->bind_param('is', $_SESSION['UserGUID'], $StrategyName);
	    $stmt->execute();
	    $stmt->bind_result($StrategyID);
	    $stmt->fetch();	    		 
	    $stmt->close();	
	    
	    if ( isset($StrategyID) ) {
	    	
	    	return false;
	    }
	    else{
	    	
	    	$stmt = $this->conn->prepare("INSERT INTO tb_Strategy (UserGUID, StrategyName) VALUES(?, ?)");	    	
	    	$stmt->bind_param('is', $_SESSION['UserGUID'], $StrategyName);
	    	$stmt->execute();		    		    	
	    	$stmt->close();
	    	    	
	    	$stmt = $this->conn->prepare("SELECT StrategyID FROM tb_Strategy WHERE UserGUID = ? AND StrategyName = ?");
		$stmt->bind_param('is', $_SESSION['UserGUID'], $StrategyName);
		$stmt->execute();
		$stmt->bind_result($StrategyID);
		$stmt->fetch();			    
	        $stmt->close();
	        
	        if ( isset($StrategyID) ) {
	    	
	    	    return true;
	        }
	    	else{
	    		return false;   	
	    	}	
	    }
	}
	
	
	function AddUser($username, $password, $name)  {
	    $stmt = $this->conn->prepare("SELECT UserGUID FROM tb_Users WHERE Username = ?");
	    $stmt->bind_param('s', $_POST['username']);
	    $stmt->execute();
	    $stmt->bind_result($userguid);
	    $stmt->fetch();
	    $stmt->close();		
	    
	    if ( isset($userguid) ) {
	    	
	    	return "UserNameExist";
	    }
	    else{
	    	
	    	$stmt = $this->conn->prepare("SELECT Token FROM tb_UnverifiedUser WHERE Username = ?");
	        $stmt->bind_param('s', $_POST['username']);
	        $stmt->execute();
	        $stmt->bind_result($unverified_user);
	        $stmt->fetch();
	        $stmt->close();		
	    
	        if ( isset($unverified_user) ) {
	    	
	    	    return "UnverifiedFound";
	        }
	    	
	    	
	    	$password = password_hash($password, PASSWORD_BCRYPT);
	    	$token = uniqid().'_'.uniqid();
	    	
	    	$stmt = $this->conn->prepare("INSERT INTO tb_UnverifiedUser(Username, Name, Password, Token) VALUES(?, ?, ?, ?)");
	    	$stmt->bind_param('ssss', $username, $name, $password, $token);	    	
	    	$stmt->execute();
	    	$stmt->close();
	    	
	    	$stmt = $this->conn->prepare("SELECT Token FROM tb_UnverifiedUser WHERE Username = ?");
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($Token);
		$stmt->fetch();
	    	$stmt->close();
	    	 	
       	        if ( isset($Token) ) {
	    	
	    	    return "OK".$Token;
	        }
	    	else{
	    	    return "Fail";   	
	    	}	
	    }
	}
	
	function VerifyUserToken($token)  {
	    $stmt = $this->conn->prepare("SELECT Username, Name, Password FROM tb_UnverifiedUser WHERE Token = ?");
	    $stmt->bind_param('s', $token);
	    $stmt->execute();
	    $stmt->bind_result($username, $name, $password);
	    $stmt->fetch();
	    $stmt->close();		
	    $date = "1900-01-01";
	    if(isset($username)){

		    $ResetToken = uniqid().'_'.uniqid();	
		    $stmt = $this->conn->prepare("INSERT INTO tb_Users(Username, Name, Password, ResetPasswordToken, ResetPasswordTokenValidity) VALUES(?, ?, ?, ?, ?)");
		    $stmt->bind_param('sssss', $username, $name, $password, $ResetToken, $date);	    	
		    echo "ssdddds";
		    $stmt->execute();
		    $insertID = mysqli_insert_id($this->conn);
		    $stmt->close();
		    
		    if($insertID > 0){
		    	    $stmt = $this->conn->prepare("DELETE FROM tb_UnverifiedUser WHERE Token = ?");
			    $stmt->bind_param('s', $token);	    	
			    $stmt->execute();
			    $insertID = mysqli_insert_id($this->conn);
			    $stmt->close();
		
		    }
	
		    return "OK";
	    }
	    else{
	    	return "VerifiedFail";
	    }
	}
	
	function VerifyResetPaswoordToken($token)  {
	    $stmt = $this->conn->prepare("SELECT UserGUID FROM tb_Users WHERE ResetPasswordToken = ? AND ResetPasswordTokenValidity > NOW()");
	    $stmt->bind_param('s', $token);
	    $stmt->execute();
	    $stmt->bind_result($UserGUID);
	    $stmt->fetch();
	    $stmt->close();		

	    return $UserGUID;
	}

	
	function ForgotPassword($username)  {
	    
	    $ResetToken = uniqid().'_'.uniqid();
	    $stmt = $this->conn->prepare("UPDATE tb_Users SET ResetPasswordToken = ?, ResetPasswordTokenValidity = DATE_ADD(NOW(), INTERVAL 1 DAY) WHERE Username = ?");
	    $stmt->bind_param('ss', $ResetToken, $username);
	    $stmt->execute();
	    $stmt->bind_result($ResetPasswordToken, $name);
	    $stmt->fetch();
	    $stmt->close();		

	    
	    $stmt = $this->conn->prepare("SELECT ResetPasswordToken, Name FROM tb_Users WHERE Username = ?");
	    $stmt->bind_param('s', $username);
	    $stmt->execute();
	    $stmt->bind_result($ResetPasswordToken, $name);
	    $stmt->fetch();
	    $stmt->close();		

	    $user = new User();
	    $user->Name = $name;
	    $user->ResetPasswordToken = $ResetPasswordToken;


	    return $user;
	}

	function UpdateUserPassword($UserGUID, $newPassword)  {
	    $password = password_hash($newPassword, PASSWORD_BCRYPT);
	    $stmt = $this->conn->prepare("UPDATE tb_Users SET Password = ? WHERE UserGUID = ?");
	    $stmt->bind_param('si', $password, $UserGUID);
	    $stmt->execute();
	    $row = mysqli_affected_rows($this->conn);
	    $stmt->close();	    	   
	    	
	    if($row == 1){
	    	    $date = "1900-01-01";
	    	    $stmt = $this->conn->prepare("UPDATE tb_Users SET ResetPasswordTokenValidity = ? WHERE UserGUID = ?");
		    $stmt->bind_param('si', $date, $UserGUID);
		    $stmt->execute();
		    $row = mysqli_affected_rows($this->conn);
		    $stmt->close();
	    }	    			   	
	    return $row;		
	}

	
	function VerifyLogin($username, $password)  {
	    $stmt = $this->conn->prepare("SELECT UserGUID, Password, Name FROM tb_Users WHERE Username = ?");
	    $stmt->bind_param('s', $_POST['username']);
	    $stmt->execute();
	    $stmt->bind_result($userguid, $password, $name);
	    $stmt->fetch();
	    $stmt->close();
	    		
	    // Verify user password and set $_SESSION
	    if ( password_verify( $_POST['password'], $password ) ) {
	    	$_SESSION['UserGUID'] = $userguid;
	    	$_SESSION['loggedin'] = true;
	    	$_SESSION['username'] = $_POST['username'];
	    	$_SESSION['name'] = $name;
	    	return true;
	    }
	    else{
	    	return false;   		
	    }
	}
}

?>