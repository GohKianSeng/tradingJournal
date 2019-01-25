<?php

include './config/AllClasses.php';

class MysqlConn {

    	public $conn;
    	public $conn2;

	function __construct()    {
	    $this->calledByConstructor();
	}	
	
	function calledByConstructor(){
	    $this->conn= NULL;
	    $this->conn= new mysqli('localhost', 'wefewfwe_KS', 'yWqikr1981', 'wefewfwe_tradingjournal');
	    
	    $this->conn2= NULL;
	    $this->conn2= new mysqli('localhost', 'wefewfwe_KS', 'yWqikr1981', 'wefewfwe_tradingjournal');
	}		    
	
	function GetStatsDateRange()  {
	    $stmt = $this->conn->prepare("CALL sp_GetStatsDateRange()");
	    $stmt->execute();	     		 
	    $stmt->bind_result($StatsDate, $StatsDateName);
	    
	    $array = array();
	    while ($stmt->fetch()) {
	    	$temp = new StatsDateRange();
	    	$temp->StatsDate = $StatsDate;
		$temp->StatsDateName = $StatsDateName;
		array_push($array , $temp);			
       	    }
       	    
       	    return $array;	
	}
	
	function GetStats($dateStart, $dateEnd){
	    
	    if ($this->conn->multi_query("CALL sp_GetStats(STR_TO_DATE('" . $dateStart .  "', '%Y-%m-%d'), STR_TO_DATE('" . $dateEnd .  "', '%Y-%m-%d'), 1)")) {
		    
		    	$graphresult = new GraphResult();		    	
		        
		        $DateRangeResult = $this->conn->store_result();
		        while ($row = $DateRangeResult->fetch_row()) {
		                $temp_value = new GraphDateValue();
		                $graphresult->MaxDate = $row[0];
		                $graphresult->MinDate = $row[1];		                
		        }
		        $this->conn->next_result();
		        
		        $incrementalDailyGrossResult = $this->conn->store_result();
			$incrementalDailyGrossArray = Array();
		        while ($row = $incrementalDailyGrossResult->fetch_row()) {
		                $temp_value = new GraphDateValue();
		                $temp_value->Date = $row[0];
		                $temp_value->Value = $row[1];
		                array_push($incrementalDailyGrossArray, $temp_value);
		        }
		        $graphresult->IncrementalGross = $incrementalDailyGrossArray;
		        $this->conn->next_result();
		        
		        $DailyGrossResult = $this->conn->store_result();
		        $DailyGrossArray = Array();
		        while ($row = $DailyGrossResult->fetch_row()) {
		                $temp_value = new GraphDateValue();
		                $temp_value->Date = $row[0];
		                $temp_value->Value = $row[1];
		                array_push($DailyGrossArray, $temp_value);
		        }
		        $graphresult->DailyGross = $DailyGrossArray;
		        $this->conn->next_result();
		        
		        $ProfitTradeResult = $this->conn->store_result();
		        $ProfitTradeArray = Array();
		        while ($row = $ProfitTradeResult->fetch_row()) {
		                $temp_value = new GraphDateValue();
		                $temp_value->Date = $row[0];
		                $temp_value->Value = $row[1];
		                array_push($ProfitTradeArray, $temp_value);
		        }
		        $graphresult->ProfitTrade = $ProfitTradeArray;
		        $this->conn->next_result();
		        
		        $LossTradeResult = $this->conn->store_result();
		        $LossTradeArray = Array();
		        while ($row = $LossTradeResult->fetch_row()) {
		                $temp_value = new GraphDateValue();
		                $temp_value->Date = $row[0];
		                $temp_value->Value = $row[1];
		                array_push($LossTradeArray, $temp_value);
		        }
		        $graphresult->LossTrade = $LossTradeArray;
		        $this->conn->next_result();
		        
		        $MissedTradeResult = $this->conn->store_result();
		        $MissedTradeArray = Array();
		        while ($row = $MissedTradeResult->fetch_row()) {
		                $temp_value = new GraphDateValue();
		                $temp_value->Date = $row[0];
		                $temp_value->Value = $row[1];
		                array_push($MissedTradeArray, $temp_value);
		        }	
		        $graphresult->MissedTrade = $MissedTradeArray;
		        $this->conn->next_result();
		        
		        $LessonLearnResult = $this->conn->store_result();
		        $LessonLearnArray = Array();
		        while ($row = $LessonLearnResult->fetch_row()) {
		                $temp_value = new LessonLearnStats();
		                $temp_LL = new LessonLearn();
		                
		                $temp_LL->LessonLearnID = $row[0];
		                $temp_LL->LessonLearnRemarks = $row[1];
		                $temp_value->LessonLearn = $temp_LL;
		                $temp_value->Total = $row[2];
		                array_push($LessonLearnArray, $temp_value);
		        }	
		        $graphresult->LessonLearnStats = $LessonLearnArray;
		        $this->conn->next_result();
		        
		        $ProfitStrategyResult = $this->conn->store_result();
		        $ProfitStrategyArray = Array();
		        while ($row = $ProfitStrategyResult->fetch_row()) {
		                $temp_value = new StrategyStats();
		                $temp_S = new Strategy();
		                
		                $temp_S->StrategyID = $row[0];
		                $temp_S->StrategyName = $row[1];
		                $temp_value->Strategy = $temp_S ;
		                $temp_value->Total = $row[2];
		                array_push($ProfitStrategyArray, $temp_value);
		        }	
		        $graphresult->ProfitStrategy = $ProfitStrategyArray;
		        $this->conn->next_result();
		        
		        $LoseStrategyResult = $this->conn->store_result();
		        $LoseStrategyArray = Array();
		        while ($row = $LoseStrategyResult->fetch_row()) {
		                $temp_value = new StrategyStats();
		                $temp_S = new Strategy();
		                
		                $temp_S->StrategyID = $row[0];
		                $temp_S->StrategyName = $row[1];
		                $temp_value->Strategy = $temp_S ;
		                $temp_value->Total = $row[2];
		                array_push($LoseStrategyArray , $temp_value);
		        }	
		        $graphresult->LoseStrategy = $LoseStrategyArray;		
		        		        
		        
		        return $graphresult;
		
	    }
	    
	}
	
	
	function AddImage($TradeURL, $Trade_PublicID, $TradeID)  {
	    
	    $stmt = $this->conn->prepare("INSERT INTO tb_TradePix(UserGUID, TradeID, URL, PublicID) VALUES (?, ?, ?, ?)");
	    $stmt->bind_param('iiss', $_SESSION['UserGUID'], $TradeID, $TradeURL, $Trade_PublicID);
	    $stmt->execute();
	    $stmt->close();
	}
	
	function AddPremarketImage($TradeURL, $Trade_PublicID, $PremarketID)  {
	    
	    $stmt = $this->conn->prepare("INSERT INTO tb_PremarketPix(UserGUID, PremarketID, URL, PublicID) VALUES (?, ?, ?, ?)");
	    $stmt->bind_param('iiss', $_SESSION['UserGUID'], $PremarketID, $TradeURL, $Trade_PublicID);
	    $stmt->execute();
	    $stmt->close();
	}
	
	function ModifyTrade($TradeID, $Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID, $LessonLearn, $PublicGUID)  {
	    
	    if (true) {
	   	
	   	$sqlconn1 = new MysqlConn();	   		  	   	
		$result = $sqlconn1->DeleteTradeNotImage($TradeID);		
 	
	   	$sqlconn1 = new MysqlConn();
		$result = $sqlconn1->AddTrade($Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID, $LessonLearn, $TradeID, $PublicGUID);
		
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
					GROUP BY Z.TradeID) AS LessonLearn, PublicGUID
					FROM tb_Trades AS A 
					INNER JOIN tb_Strategy AS B ON A.StrategyID = B.StrategyID AND A.UserGUID = B.UserGUID
					WHERE A.UserGUID = ? AND TradeID = ? ORDER BY EntryDateTime DESC");
	    $stmt->bind_param('ii', $_SESSION['UserGUID'], $TradeID);
	    $stmt->execute();	     		 
	    $stmt->bind_result($TradeID, $Symbol, $StrategyName, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID, $LessonLearn, $PublicGUID);
	    
	    
	    
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
		$temp_trade->PublicGUID= $PublicGUID;
					
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
	
	function DeletePremarketImage($PremarketID, $PublicID){
		$stmt = $this->conn->prepare("DELETE FROM tb_PremarketPix WHERE UserGUID = ? AND PremarketID = ? AND PublicID = ?");	    	
	    	$stmt->bind_param('iis', $_SESSION['UserGUID'], $PremarketID, $PublicID);
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
	
	function AddTradeV2($Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks,  $IMCRemarks, $LessonLearn, $TradeURL, $Trade_PublicID, $TradeID = -1, $PublicGUID = "1")  {
	    
	    if (true) {
	   	
	   	if($TradeID == -1){
	    		$stmt = $this->conn->prepare("INSERT INTO tb_Trades(UserGUID, Symbol, StrategyID, TradeType, OrderType, LotSize, EntryDateTime, EntryPrice, SL_Pips, TP_Pips, ExitDateTime, ExitPrice, ProfitLoss, Remarks, IMCRemarks, PublicGUID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CONCAT(MD5(CONCAT(UUID(),UUID())),MD5(CONCAT(UUID(),UUID()))) )");
	    		    	
	    		$stmt->bind_param('isissdsdiisddss', $_SESSION['UserGUID'], $Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $IMCRemarks);	
    	    	}
    	    	else{
    	    		$stmt = $this->conn->prepare("INSERT INTO tb_Trades(UserGUID, Symbol, StrategyID, TradeType, OrderType, LotSize, EntryDateTime, EntryPrice, SL_Pips, TP_Pips, ExitDateTime, ExitPrice, ProfitLoss, Remarks, IMCRemarks, TradeID, PublicGUID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	    		    	
	    		$stmt->bind_param('isissdsdiisddssi', $_SESSION['UserGUID'], $Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $IMCRemarks, $TradeID, $PublicGUID);
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
	
	function AddTrade($Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID, $LessonLearn, $TradeID = -1, $PublicGUID = "-1")  {
	    
	    if (true) {
	   	
	   	if($TradeID == -1){
	    		$stmt = $this->conn->prepare("INSERT INTO tb_Trades(UserGUID, Symbol, StrategyID, TradeType, OrderType, LotSize, EntryDateTime, EntryPrice, SL_Pips, TP_Pips, ExitDateTime, ExitPrice, ProfitLoss, Remarks, TradeURL1, TradeURL1_PublicID, IMCRemarks, IMC_URL, IMC_URL_PublicID, PublicGUID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CONCAT(MD5(CONCAT(UUID(),UUID())),MD5(CONCAT(UUID(),UUID()))) )");
	    		    	
	    		$stmt->bind_param('isissdsdiisddssssss', $_SESSION['UserGUID'], $Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID);	
    	    	}
    	    	else{
    	    		$stmt = $this->conn->prepare("INSERT INTO tb_Trades(UserGUID, Symbol, StrategyID, TradeType, OrderType, LotSize, EntryDateTime, EntryPrice, SL_Pips, TP_Pips, ExitDateTime, ExitPrice, ProfitLoss, Remarks, TradeURL1, TradeURL1_PublicID, IMCRemarks, IMC_URL, IMC_URL_PublicID, TradeID, PublicGUID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	    		    	
	    		$stmt->bind_param('isissdsdiisddssssssis', $_SESSION['UserGUID'], $Symbol, $StrategyID, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $TradeURL1_PublicID, $IMCRemarks, $IMC_URL, $IMC_URL_PublicID, $TradeID, $PublicGUID);
	    		
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
	
	function GetAllStrategyTrades($dateStart, $dateEnd, $ID, $ProfitLoss)  {
	    $stmt = $this->conn->prepare("SELECT A.TradeID, A.Symbol, B.StrategyName, A.TradeType, A.OrderType, A.LotSize, A.EntryDateTime, A.EntryPrice, A.SL_Pips, A.TP_Pips, A.ExitDateTime,
	    				 A.ExitPrice, A.ProfitLoss, A.Remarks, A.TradeURL1, A.IMCRemarks, A.IMC_URL,
					(SELECT GROUP_CONCAT(Y.LessonLearnRemarks SEPARATOR ', ')
					FROM tb_TradesLessonLearn AS Z
					INNER JOIN tb_LessonLearn AS Y ON Z.UserGUID = Y.UserGUID AND Z.LessonLearnID = Y.LessonLearnID
					WHERE Z.UserGUID = A.UserGUID AND Z.TradeID = A.TradeID
					GROUP BY Z.TradeID) AS LessonLearn, PublicGUID
					FROM tb_Trades AS A 
					INNER JOIN tb_Strategy AS B ON A.StrategyID = B.StrategyID AND A.UserGUID = B.UserGUID
					WHERE A.StrategyID = ? AND A.UserGUID = ? AND (A.EntryDateTime BETWEEN ? AND ?) AND A.TradeType = 'Real' 
					AND(
						('Profit' = ? AND ((OrderType = 'Sell' AND EntryPrice >= ExitPrice) OR (OrderType = 'Buy' AND EntryPrice <= ExitPrice)))
						OR
						('Loss' = ? AND ((OrderType = 'Buy' AND EntryPrice >= ExitPrice) OR (OrderType = 'Sell' AND EntryPrice <= ExitPrice)))
					)
					ORDER BY EntryDateTime DESC");
	    $stmt->bind_param('iissss', $ID, $_SESSION['UserGUID'], $dateStart, $dateEnd, $ProfitLoss, $ProfitLoss);
	    $stmt->execute();	     		 
	    $stmt->bind_result($TradeID, $Symbol, $StrategyName, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $IMCRemarks, $IMC_URL, $LessonLearn, $PublicGUID);
	    
	    
	    
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
		$temp_trade->PublicGUID = $PublicGUID;
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
	
	function GetAllLessonLearnTrades($dateStart, $dateEnd, $ID)  {
	    $stmt = $this->conn->prepare("SELECT A.TradeID, A.Symbol, B.StrategyName, A.TradeType, A.OrderType, A.LotSize, A.EntryDateTime, A.EntryPrice, A.SL_Pips, A.TP_Pips, A.ExitDateTime,
	    				 A.ExitPrice, A.ProfitLoss, A.Remarks, A.TradeURL1, A.IMCRemarks, A.IMC_URL,
					(SELECT GROUP_CONCAT(Y.LessonLearnRemarks SEPARATOR ', ')
					FROM tb_TradesLessonLearn AS Z
					INNER JOIN tb_LessonLearn AS Y ON Z.UserGUID = Y.UserGUID AND Z.LessonLearnID = Y.LessonLearnID
					WHERE Z.UserGUID = A.UserGUID AND Z.TradeID = A.TradeID
					GROUP BY Z.TradeID) AS LessonLearn, PublicGUID
					FROM tb_Trades AS A 
					INNER JOIN tb_Strategy AS B ON A.StrategyID = B.StrategyID AND A.UserGUID = B.UserGUID
					INNER JOIN tb_TradesLessonLearn AS C ON C.UserGUID = A.UserGUID AND C.TradeID = A.TradeID AND C.LessonLearnID = ?
					WHERE A.UserGUID = ? AND (A.EntryDateTime BETWEEN ? AND ?) ORDER BY EntryDateTime DESC");
	    $stmt->bind_param('iiss', $ID, $_SESSION['UserGUID'], $dateStart, $dateEnd);
	    $stmt->execute();	     		 
	    $stmt->bind_result($TradeID, $Symbol, $StrategyName, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $IMCRemarks, $IMC_URL, $LessonLearn, $PublicGUID);
	    
	    
	    
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
		$temp_trade->PublicGUID = $PublicGUID;
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
	
	function GetAllTrades()  {
	    $stmt = $this->conn->prepare("SELECT A.TradeID, A.Symbol, B.StrategyName, A.TradeType, A.OrderType, A.LotSize, A.EntryDateTime, A.EntryPrice, A.SL_Pips, A.TP_Pips, A.ExitDateTime,
	    				 A.ExitPrice, A.ProfitLoss, A.Remarks, A.TradeURL1, A.IMCRemarks, A.IMC_URL,
					(SELECT GROUP_CONCAT(Y.LessonLearnRemarks SEPARATOR ', ')
					FROM tb_TradesLessonLearn AS Z
					INNER JOIN tb_LessonLearn AS Y ON Z.UserGUID = Y.UserGUID AND Z.LessonLearnID = Y.LessonLearnID
					WHERE Z.UserGUID = A.UserGUID AND Z.TradeID = A.TradeID
					GROUP BY Z.TradeID) AS LessonLearn, PublicGUID
					FROM tb_Trades AS A 
					INNER JOIN tb_Strategy AS B ON A.StrategyID = B.StrategyID AND A.UserGUID = B.UserGUID
					WHERE A.UserGUID = ? ORDER BY EntryDateTime DESC LIMIT 20");
	    $stmt->bind_param('i', $_SESSION['UserGUID']);
	    $stmt->execute();	     		 
	    $stmt->bind_result($TradeID, $Symbol, $StrategyName, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $IMCRemarks, $IMC_URL, $LessonLearn, $PublicGUID);
	    
	    
	    
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
		$temp_trade->PublicGUID = $PublicGUID;
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
	
	function GetPublicGUIDTrade($PublicGUID)  {
	    $stmt = $this->conn->prepare("SELECT A.TradeID, A.Symbol, B.StrategyName, A.TradeType, A.OrderType, A.LotSize, A.EntryDateTime, A.EntryPrice, A.SL_Pips, A.TP_Pips, A.ExitDateTime,
	    				 A.ExitPrice, A.ProfitLoss, A.Remarks, A.TradeURL1, A.IMCRemarks, A.IMC_URL,
					(SELECT GROUP_CONCAT(Y.LessonLearnRemarks SEPARATOR ', ')
					FROM tb_TradesLessonLearn AS Z
					INNER JOIN tb_LessonLearn AS Y ON Z.UserGUID = Y.UserGUID AND Z.LessonLearnID = Y.LessonLearnID
					WHERE Z.UserGUID = A.UserGUID AND Z.TradeID = A.TradeID
					GROUP BY Z.TradeID) AS LessonLearn, PublicGUID, A.UserGUID
					FROM tb_Trades AS A 
					INNER JOIN tb_Strategy AS B ON A.StrategyID = B.StrategyID AND A.UserGUID = B.UserGUID
					WHERE A.PublicGUID = ? ORDER BY EntryDateTime DESC LIMIT 20");
	    $stmt->bind_param('s', $PublicGUID);
	    $stmt->execute();	     		 
	    $stmt->bind_result($TradeID, $Symbol, $StrategyName, $TradeType, $OrderType, $LotSize, $EntryDateTime, $EntryPrice, $SL_Pips, $TP_Pips, $ExitDateTime, $ExitPrice, $ProfitLoss, $Remarks, $TradeURL1, $IMCRemarks, $IMC_URL, $LessonLearn, $PublicGUID, $UserGUID);
	    
	    
	    
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
		$temp_trade->PublicGUID = $PublicGUID;
		$temp_trade->LessonLearn= $LessonLearn;
		if(strlen($LessonLearn) == 0 || is_null($LessonLearn)){
			$temp_trade->LessonLearn = "-";
		}


		$stmt2 = $this->conn2->prepare("SELECT URL, PublicID FROM tb_TradePix WHERE UserGUID = ? AND TradeID = ?");	    	
		$stmt2->bind_param('ii', $UserGUID, $TradeID);
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
	    $stmt = $this->conn->prepare("DELETE FROM tb_PreMarket WHERE PreMarketID = ? AND UserGUID = ?");
	    $stmt->bind_param('ii', $PreMarketID, $_SESSION['UserGUID']);
	    $stmt->execute();	    		 
	    $stmt->close();	
	    	    
	    $stmt = $this->conn->prepare("DELETE FROM tb_PremarketPix WHERE PreMarketID = ? AND UserGUID = ?");
	    $stmt->bind_param('ii', $PreMarketID, $_SESSION['UserGUID']);
	    $stmt->execute();	    		 
	    $stmt->close();
	    
	    return true;	    
	}

	function AddPreMarketV2($Date, $OPG430Difference, $OPG1amDifference, $Remarks, $TradeURL, $Trade_PublicID)  {
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

		$column = $column."Remarks";
	    	$type = $type ."s";
		$questionmark = $questionmark."?";
	    	
	    	$stmt = $this->conn->prepare("INSERT INTO tb_PreMarket (".$column.") VALUES(".$questionmark.")");
	    		    	
	    	if(isset($OPG430Difference) && strlen($OPG430Difference) > 0 && isset($OPG1amDifference) && strlen($OPG1amDifference) > 0)
		{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $OPG430Difference, $OPG1amDifference, $Remarks);
		}
		else if(isset($OPG430Difference) && strlen($OPG430Difference) > 0)
	    	{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $OPG430Difference, $Remarks);

		}
		else if(isset($OPG1amDifference) && strlen($OPG1amDifference) > 0)
	    	{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $OPG1amDifference, $Remarks);

		}
		else
		{
			$stmt->bind_param($type, $_SESSION['UserGUID'], $Date, $Remarks);
		}
	    		    		    	
	    	$stmt->execute();
	    	$insertID = mysqli_insert_id($this->conn);
	    	$stmt->close();

		$stmt = $this->conn->prepare("UPDATE tb_PreMarket SET PublicGUID = CONCAT(MD5(CONCAT(UUID(),UUID())),MD5(CONCAT(UUID(),UUID()))) WHERE PremarketID = ?");
	    	$stmt->bind_param('i', $insertID);
	    	$stmt->execute();
	    	$stmt->close();


	    	for ($i = 0; $i < count($TradeURL); $i++) {
	    		$stmt = $this->conn->prepare("INSERT INTO tb_PremarketPix(UserGUID, PremarketID, URL, PublicID) VALUES (?, ?, ?, ?)");
	    		$stmt->bind_param('iiss', $_SESSION['UserGUID'], $insertID, $TradeURL[$i], $Trade_PublicID[$i]);
	    		$stmt->execute();
	    		$stmt->close();
		}    		    	    
	        
	        if ( isset($insertID) ) {
	    	
	    	    return true;
	        }
	    	else{
	    		return false;   	
	    	}	
	    }
	}
	
	function ModifyPreMarket($PreMarketID, $Date, $OPG430Difference, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID, $PublicGUID)  {
	    $stmt = $this->conn->prepare("DELETE FROM tb_PreMarket WHERE PreMarketID = ?");
	    $stmt->bind_param('i', $PreMarketID);
	    $stmt->execute();	    		 
	    $stmt->close();	
	    
	    if ( !isset($PreMarketID) ) {
	    	
	    	return false;
	    }
	    else{
	    	$column = "PreMarketID, UserGUID, MarketDate, ";
	    	$type = "iis";
	    	$questionmark = "?, ?, ?, ";
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
			$stmt->bind_param($type, $PreMarketID, $_SESSION['UserGUID'], $Date, $OPG430Difference, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);

		}
		else if(isset($OPG430Difference) && strlen($OPG430Difference) > 0)
	    	{
			$stmt->bind_param($type, $PreMarketID, $_SESSION['UserGUID'], $Date, $OPG430Difference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);

		}
		else if(isset($OPG1amDifference) && strlen($OPG1amDifference) > 0)
	    	{
			$stmt->bind_param($type, $PreMarketID, $_SESSION['UserGUID'], $Date, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);

		}
		else
		{
			$stmt->bind_param($type, $PreMarketID, $_SESSION['UserGUID'], $Date, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID);
		}
	    		    		    	
	    	$stmt->execute();		    		    	
	    	$stmt->close();	    	    		    	    	
	    	    		    	    	
	    	/*$stmt = $this->conn->prepare("SELECT PreMarketID FROM tb_PreMarket WHERE UserGUID = ? AND MarketDate = ?");
		$stmt->bind_param('is', $_SESSION['UserGUID'], $Date);
		$stmt->execute();
		$stmt->bind_result($PreMarketID );
		$stmt->fetch();			    
	        $stmt->close();*/
	        
	        $stmt = $this->conn->prepare("UPDATE tb_PreMarket SET PublicGUID = ? WHERE PremarketID = ?");
	    	$stmt->bind_param('si', $PublicGUID, $PreMarketID);
	    	$stmt->execute();
	    	$stmt->close();
	    	
	    	return true;
	    		
	    }
	}

	
	function GetSelectedPreMarket($id)  {
	
	    $stmt = $this->conn->prepare("SELECT PreMarketID, MarketDate, OPG430Difference, OPG1amDifference, Remarks, MySR_URL, MySR_PublicID, RaymondSR_URL, RaymondSR_PublicID, PublicGUID FROM tb_PreMarket WHERE UserGUID = ? AND PreMarketID = ? ORDER BY MarketDate DESC");
	    $stmt->bind_param('ii', $_SESSION['UserGUID'], $id);
	    $stmt->execute();	     		 
	    $stmt->bind_result($PreMarketID, $MarketDate, $OPG430Difference, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID, $PublicGUID);
	    
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
	    $temp_premarket->PublicGUID = $PublicGUID;
	    $stmt->close();
	    
	    $stmt = $this->conn->prepare("SELECT URL, PublicID FROM tb_PremarketPix WHERE UserGUID = ? AND PremarketID = ?");	    	
	    $stmt->bind_param('ii', $_SESSION['UserGUID'], $id);
	    $stmt->execute();	    		    	
	    $stmt->bind_result($URL, $PublicID);
	    
	    $index = 0;
       	    while ($stmt->fetch()) {
       	    	$temp_premarket->TradeURL[$index] = $URL;
       	    	$temp_premarket->Trade_PublicID[$index] = $PublicID;
       	    	$index = $index + 1;
       	    }
       	    $stmt->close();
	    
	       	    
       	    return $temp_premarket;	
	}

	function GetPublicGUIDPreMarket($PublicGUID)  {
	    $stmt = $this->conn->prepare("SELECT PreMarketID, MarketDate, OPG430Difference, OPG1amDifference, Remarks, MySR_URL, MySR_PublicID, RaymondSR_URL, RaymondSR_PublicID, UserGUID FROM tb_PreMarket WHERE PublicGUID = ? ORDER BY MarketDate DESC LIMIT 20");
	    $stmt->bind_param('s', $PublicGUID);
	    $stmt->execute();	     		 
	    $stmt->bind_result($PreMarketID, $MarketDate, $OPG430Difference, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID, $UserGUID);
	    
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

		$stmt2 = $this->conn2->prepare("SELECT URL, PublicID FROM tb_PremarketPix WHERE UserGUID = ? AND PremarketID = ?");	    	
		$stmt2->bind_param('ii', $UserGUID, $PreMarketID);
		$stmt2->execute();	    		    	
		$stmt2->bind_result($URL, $PublicID);
		    
		$index = 0;
	       	while ($stmt2->fetch()) {
	       	 $temp_premarket->TradeURL[$index] = $URL;
	       	 $temp_premarket->Trade_PublicID[$index] = $PublicID;
	       	 $index = $index + 1;
	       	}
	       	$stmt2->close();

		array_push($array , $temp_premarket);			
       	    }
       	    
       	    return $array;	
	}
	
	function GetAllPreMarket()  {
	    $stmt = $this->conn->prepare("SELECT PreMarketID, MarketDate, OPG430Difference, OPG1amDifference, Remarks, MySR_URL, MySR_PublicID, RaymondSR_URL, RaymondSR_PublicID, PublicGUID FROM tb_PreMarket WHERE UserGUID = ? ORDER BY MarketDate DESC LIMIT 20");
	    $stmt->bind_param('i', $_SESSION['UserGUID']);
	    $stmt->execute();	     		 
	    $stmt->bind_result($PreMarketID, $MarketDate, $OPG430Difference, $OPG1amDifference, $Remarks, $MySR_URL, $MySR_PublicID, $RaymondSR_URL, $RaymondSR_PublicID, $PublicGUID);
	    
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
		$temp_premarket->PublicGUID = $PublicGUID;

		$stmt2 = $this->conn2->prepare("SELECT URL, PublicID FROM tb_PremarketPix WHERE UserGUID = ? AND PremarketID = ?");	    	
		$stmt2->bind_param('ii', $_SESSION['UserGUID'], $PreMarketID);
		$stmt2->execute();	    		    	
		$stmt2->bind_result($URL, $PublicID);
		    
		$index = 0;
	       	while ($stmt2->fetch()) {
	       	 $temp_premarket->TradeURL[$index] = $URL;
	       	 $temp_premarket->Trade_PublicID[$index] = $PublicID;
	       	 $index = $index + 1;
	       	}
	       	$stmt2->close();

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