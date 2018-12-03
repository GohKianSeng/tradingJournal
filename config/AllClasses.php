<?php
class Strategy {
	public $StrategyName;
	public $StrategyID;
}

class User{
	public $Name;
	public $Username;
	public $ResetPasswordToken;
}

class LessonLearn {
	public $LessonLearnRemarks;
	public $LessonLearnID;
}

class Trade{
	public $TradeID;
	public $Symbol;
	public $StrategyName;
	public $TradeType;
	public $OrderType;
	public $LotSize;
	public $EntryDateTime;
	public $EntryPrice;
	public $SL_Pips;
	public $TP_Pips;
	public $ExitDateTime;
	public $ExitPrice;
	public $ProfitLoss;
	public $Remarks;
	public $TradeURL1;
	public $TradeURL1_PublicID;
	public $IMCRemarks;
	public $IMC_URL;
	public $IMC_URL_PublicID;
	public $LessonLearn;
	public $TradeURL = array();
	public $Trade_PublicID = array();
}

class PreMarket{
	public $PreMarketID;
	public $MarketDate;
	public $OPG430Difference;
	public $OPG1amDifference;
	public $Remarks;
	public $MySR_URL;
	public $MySR_PublicID;
	public $RaymondSR_URL;
	public $RaymondSR_PublicID;
	
}

?>