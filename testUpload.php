<?php

include './config/MysqlConn.php';

$sqlconn = new MysqlConn();
$graphData = $sqlconn->testSP();

?>
   
<script type="text/javascript">
	var chart_plot_IncrementalGross_data = [
			<?php
				for ($i = 0; $i < count($graphData->IncrementalGross); $i++) {
					if($i == count($graphData->IncrementalGross)-1)
					{
						$obj = $graphData->IncrementalGross[$i];
						echo "[" . $obj->Date . ",". $obj->Value . "]\n";
					}
					else{
						$obj = $graphData->IncrementalGross[$i];
						echo "[" . $obj->Date . ",". $obj->Value . "],\n";
					}
				}
			?>];
	
	var chart_plot_DailyGross_data = [
			<?php
				for ($i = 0; $i < count($graphData->DailyGross); $i++) {
					if($i == count($graphData->DailyGross)-1)
					{
						$obj = $graphData->DailyGross[$i];
						echo "[" . $obj->Date . ",". $obj->Value . "]\n";
					}
					else{
						$obj = $graphData->DailyGross[$i];
						echo "[" . $obj->Date . ",". $obj->Value . "],\n";
					}
				}
			?>];
			
	var chart_plot_ProfitTrade_data = [
			<?php
				for ($i = 0; $i < count($graphData->ProfitTrade); $i++) {
					if($i == count($graphData->ProfitTrade)-1)
					{
						$obj = $graphData->ProfitTrade[$i];
						echo "[" . $obj->Date . ",". $obj->Value . "]\n";
					}
					else{
						$obj = $graphData->ProfitTrade[$i];
						echo "[" . $obj->Date . ",". $obj->Value . "],\n";
					}
				}
			?>];
			
	var chart_plot_LossTrade_data = [
			<?php
				for ($i = 0; $i < count($graphData->LossTrade); $i++) {
					if($i == count($graphData->LossTrade)-1)
					{
						$obj = $graphData->LossTrade[$i];
						echo "[" . $obj->Date . ",". $obj->Value . "]\n";
					}
					else{
						$obj = $graphData->LossTrade[$i];
						echo "[" . $obj->Date . ",". $obj->Value . "],\n";
					}
				}
			?>];
			
	var chart_plot_MissedTrade_data = [
			<?php
				for ($i = 0; $i < count($graphData->MissedTrade); $i++) {
					if($i == count($graphData->MissedTrade)-1)
					{
						$obj = $graphData->MissedTrade[$i];
						echo "[" . $obj->Date . ",". $obj->Value . "]\n";
					}
					else{
						$obj = $graphData->MissedTrade[$i];
						echo "[" . $obj->Date . ",". $obj->Value . "],\n";
					}
				}
			?>];
</script>   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   