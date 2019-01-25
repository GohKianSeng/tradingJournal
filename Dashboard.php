<?php 
include("header.php"); 


$dateStart = "";
$dateEnd = "";
if (isset($_POST["StatsDate"]) == false){
	$dateStart = date('Y-m-01');
	$dateEnd = date('Y-m-t');
}
else{    	
	$dateStart = $_POST["StatsDate"];
	$dateTime = strtotime($_POST["StatsDate"]);
	$dateEnd = date('Y-m-t', $dateTime);
}
	    
$sqlconn = new MysqlConn();
$graphData = $sqlconn->GetStats($dateStart, $dateEnd);

?>					
					
	<div class="">
            
			
            
            			
        
			<div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    
						<table>
							<tr>
								<td style="width:10%"><h2>Trading Dashboard</h2></td>
								<td><div class="" width="100%">
                <div id="" class="pull-right" style="background: #fff;  padding: 5px 10px; border: 0px solid #ccc">
                    <j style="padding-right: 10px;">Interested Period</j><i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                    <span><select id="StatsDateRangeID" class="" name="StatsDateRangeID" required>
					                            <?php
								    	$sqlconn = new MysqlConn();
									$result = $sqlconn->GetStatsDateRange();
								    
								    	for ($i = 0; $i < count($result ); $i++) {
							    			$obj = $result[$i];
							    			
							    			if($obj->StatsDate == $_POST["StatsDate"])
							    			{
							    				echo "<option value='".$obj->StatsDate."' Selected>".$obj->StatsDateName."</option>";
							    			}
							    			else{
							    				echo "<option value='".$obj->StatsDate."'>".$obj->StatsDateName."</option>";
										}
							    		}
								    ?>
					                            </select></span>
				</div>
            </div></td>
							</tr>
						</table>
					
					
					                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="padding-top: 5px;">
                    <div class="col-md-12 col-sm-12 col-xs-12">				
                      <div class="demo-container" style="height:280px">
                        <div id="chart_plot_02" class="demo-placeholder"></div>
                      </div>
                      <div class="tiles">
                        <div class="col-md-3 tile">
                          <span>Total Sessions</span>
                          <h2>231,809</h2>
                          <span class="sparkline11 graph" style="height: 160px;">
                               <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                        <div class="col-md-3 tile">
                          <span>Total Revenue</span>
                          <h2>$231,809</h2>
                          <span class="sparkline22 graph" style="height: 160px;">
                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                        <div class="col-md-3 tile">
                          <span>Total Sessions</span>
                          <h2>231,809</h2>
                          <span class="sparkline11 graph" style="height: 160px;">
                                 <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
						<div class="col-md-3 tile">
                          <span>Total Sessions</span>
                          <h2>231,809</h2>
                          <span class="sparkline11 graph" style="height: 160px;">
                                 <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                        </div>
                      </div>


					

                   </div> 

                  </div>
                </div>
              </div>
            </div>
		
		
			<div class="row" style="padding-bottom: 30px;">
              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Top 5 Lesson Learned </h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  
                  	
                  	
                  	<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
					   
					  <?php
						for ($i = 0; $i < count($graphData->LessonLearnStats); $i++) {
							$obj = $graphData->LessonLearnStats[$i];
					  ?>								
							  <article class="media event">
					                      <a class="pull-left date" style="padding-bottom: 10px;padding-top: 10px;padding-left: 10px;padding-right: 10px;">
					                        <p class="day"><?php echo $obj->Total; ?><br/></p>
					                      </a>
					                      <div class="media-body">
					                        <p ><a class="title"><?php echo $obj->LessonLearn->LessonLearnRemarks; ?></a></p>
					                        <a class="" href="ViewTrades.php?Date=<?php echo $_POST["StatsDate"]; ?>&LessonLearnID=<?php echo $obj->LessonLearn->LessonLearnID; ?>"><small>View Related Trades</small></a>
					                      </div>
					                   </article>
							
					 <?php	
							
						}
					  ?>
				
                    	</div>
                  
                  
                  
                    
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Profitable Strategy</h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    			  <?php
					  	for ($i = 0; $i < count($graphData->ProfitStrategy); $i++) {
							$obj = $graphData->ProfitStrategy[$i];
					  ?>								
							  <article class="media event">
					                      <a class="pull-left date" style="padding-bottom: 10px;padding-top: 10px;padding-left: 10px;padding-right: 10px;">
					                        <p class="day"><?php echo $obj->Total; ?><br/></p>
					                      </a>
					                      <div class="media-body">
					                        <p ><a class="title"><?php echo $obj->Strategy->StrategyName; ?></a></p>
					                        <a class="" href="ViewTrades.php?ProfitLoss=Profit&Date=<?php echo $_POST["StatsDate"]; ?>&StrategyID=<?php echo $obj->Strategy->StrategyID; ?>"><small>View Related Trades</small></a>
					                      </div>
					                   </article>
							
					 <?php	
							
						}
					  ?>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Losing Strategy</h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    			<?php
					  	for ($i = 0; $i < count($graphData->LoseStrategy); $i++) {
							$obj = $graphData->LoseStrategy[$i];
					  ?>								
							  <article class="media event">
					                      <a class="pull-left date" style="padding-bottom: 10px;padding-top: 10px;padding-left: 10px;padding-right: 10px;">
					                        <p class="day"><?php echo $obj->Total; ?><br/></p>
					                      </a>
					                      <div class="media-body">
					                        <p ><a class="title"><?php echo $obj->Strategy->StrategyName; ?></a></p>
					                        <a class="" href="ViewTrades.php?ProfitLoss=Loss&Date=<?php echo $_POST["StatsDate"]; ?>&StrategyID=<?php echo $obj->Strategy->StrategyID; ?>"><small>View Related Trades</small></a>
					                      </div>
					                   </article>
							
					 <?php	
							
						}
					  ?>
                  </div>
                </div>
              </div>
            </div>
		
			
           </div>		
        
<script type="text/javascript">
			
	// jquery extend function
	$.extend(
	{
	    redirectPost: function(location, args)
	    {
	        var form = '';
	        $.each( args, function( key, value ) {
	            value = value.split('"').join('\"')
	            form += '<input type="hidden" name="'+key+'" value="'+value+'">';
	        });
	        $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo($(document.body)).submit();
	    }
	});		
			
	$(document).ready(function() {
		
		init_tradingSummary_chart();
		
		$( "#StatsDateRangeID").change(function() {
		  $.redirectPost('Dashboard.php', { StatsDate: $( "#StatsDateRangeID").val() });
		});	
		
	});		
										
	function init_tradingSummary_chart(){
		if( typeof ($.plot) === 'undefined'){ return; }
		
	var chart_plot_IncrementalGross_data = [
			<?php
				for ($i = 0; $i < count($graphData->IncrementalGross); $i++) {
					if($i == count($graphData->IncrementalGross)-1)
					{
						$obj = $graphData->IncrementalGross[$i];
						echo "[" . $obj->Date . "000,". $obj->Value . "]\n";
					}
					else{
						$obj = $graphData->IncrementalGross[$i];
						echo "[" . $obj->Date . "000,". $obj->Value . "],\n";
					}
				}
			?>];
		
	var chart_plot_DailyGross_data = [
			<?php
				for ($i = 0; $i < count($graphData->DailyGross); $i++) {
					if($i == count($graphData->DailyGross)-1)
					{
						$obj = $graphData->DailyGross[$i];
						echo "[" . $obj->Date . "000,". $obj->Value . "]\n";
					}
					else{
						$obj = $graphData->DailyGross[$i];
						echo "[" . $obj->Date . "000,". $obj->Value . "],\n";
					}
				}
			?>];
			
	var chart_plot_ProfitTrade_data = [
			<?php
				for ($i = 0; $i < count($graphData->ProfitTrade); $i++) {
					if($i == count($graphData->ProfitTrade)-1)
					{
						$obj = $graphData->ProfitTrade[$i];
						echo "[" . $obj->Date . "000,". $obj->Value . "]\n";
					}
					else{
						$obj = $graphData->ProfitTrade[$i];
						echo "[" . $obj->Date . "000,". $obj->Value . "],\n";
					}
				}
			?>];
			
	var chart_plot_LossTrade_data = [
			<?php
				for ($i = 0; $i < count($graphData->LossTrade); $i++) {
					if($i == count($graphData->LossTrade)-1)
					{
						$obj = $graphData->LossTrade[$i];
						echo "[" . $obj->Date . "000-16000000,". $obj->Value . "]\n";
					}
					else{
						$obj = $graphData->LossTrade[$i];
						echo "[" . $obj->Date . "000-16000000,". $obj->Value . "],\n";
					}
				}
			?>];
			
	var chart_plot_MissedTrade_data = [
			<?php
				for ($i = 0; $i < count($graphData->MissedTrade); $i++) {
					if($i == count($graphData->MissedTrade)-1)
					{
						$obj = $graphData->MissedTrade[$i];
						echo "[" . $obj->Date . "000+16000000,". $obj->Value . "]\n";
					}
					else{
						$obj = $graphData->MissedTrade[$i];
						echo "[" . $obj->Date . "000+16000000,". $obj->Value . "],\n";
					}
				}
			?>];	
	/*		
	var chart_plot_LL_data = [
			<?php
				for ($i = 0; $i < count($graphData->LessonLearnStats); $i++) {
					if($i == count($graphData->LessonLearnStats)-1)
					{
						$obj = $graphData->LessonLearnStats[$i];
						echo "[" . $obj->LessonLearn->LessonLearnRemarks . ",". $obj->Total. "]\n";
					}
					else{
						$obj = $graphData->LessonLearnStats[$i];
						echo "[" . $obj->LessonLearn->LessonLearnRemarks . ",". $obj->Total. "],\n";
					}
				}
			?>];*/
		
		var chart_plot_02_settings = {
			grid: {
				show: true,
				aboveData: true,
				color: "#3f3f3f",
				labelMargin: 10,
				axisMargin: 0,
				borderWidth: 0,
				borderColor: null,
				minBorderMargin: 5,
				clickable: true,
				hoverable: true,
				autoHighlight: true,
				mouseActiveRadius: 20
			},
			legend: {
				position: "ne",
				margin: [0, -25],
				noColumns: 0,
				labelBoxBorderColor: null,
				labelFormatter: function(label, series) {
					return label + '&nbsp;&nbsp;';
				},
				width: 70,
				height: 1
			},
			colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
			shadowSize: 0,
			tooltip: true,
			tooltipOpts: {
				content: "%s: %y.0",
				xDateFormat: "%d/%m",
				shifts: {
					x: -30,
					y: -50
				},
			defaultTheme: false
			},
			yaxes: [ {position: "left", min: -10 }, { position: "left", min: 0}, {position: "right", min: 0 } ],
			xaxis: {
				mode: "time",
				minTickSize: [1, "day"],
				timeformat: "%d/%m/%y",
				min: <?php echo $graphData->MinDate."000"; ?>,
				max: <?php echo $graphData->MaxDate."000"; ?>
			}
		};	
	
		
		
		
		if ($("#chart_plot_02").length){
			
	
		tbarWidth  = 0.5;
		$.plot("#chart_plot_02", [ 
		{
			label: "Profit/Loss", 
			data: chart_plot_DailyGross_data,
			lines: { show: true },
			points: { show: true },
			xaxis: 1, 
			yaxis: 1,
			color: "black"
		},
		{
			label: "Gross Profit/Loss", 
			data: chart_plot_IncrementalGross_data,
			lines: { show: true },
			points: { show: true },
			xaxis: 1, 
			yaxis: 3,
			color: "silver"
		},
		{
			label: "Missed Trade", 
			data: chart_plot_MissedTrade_data,
			bars: { show: true,	barWidth: tbarWidth, align: "center", order: 1},
			points: { show: true },
			xaxis: 1, 
			yaxis: 2,
			color: "blue",
			order: 2
		},
		{
			label: "Profit Trade", 
			data: chart_plot_ProfitTrade_data,
			bars: { show: true,	barWidth: tbarWidth, align: "center", order: 1},
			points: { show: true },
			xaxis: 1, 
			yaxis: 2,
			color: "lime",
			order: 1
		},
		{
			label: "Loss Trade", 
			data: chart_plot_LossTrade_data,
			bars: { show: true,	barWidth: tbarWidth, align: "center", order: 3},
			points: { show: true },
			xaxis: 1, 
			yaxis: 2,
			color: "red",
			order: 3
		}], chart_plot_02_settings);
			
		
		}
		
		$("<div id='tooltip'></div>").css({
			position: "absolute",
			display: "none",
			border: "1px solid #fdd",
			padding: "2px",
			"background-color": "#fee",
			opacity: 0.80
		}).appendTo("body");
	  
	  
	  $("#chart_plot_02").bind("plothover", function (event, pos, item) {

			if (true) {
				if (item) {
					var date = "";
					if(item.series.label == "Loss Trade" || item.series.label == "Profit Trade")
					{
						temp = new Date(item.datapoint[0]);
						temp.setDate(temp.getDate() + 1);
						date = temp.format("d M Y");													
					}
					else{
						date = new Date(item.datapoint[0]).format("d M Y");
					}
					var x = date,
						y = item.datapoint[1];

					$("#tooltip").html(item.series.label + " of " + x + " = " + y)
						.css({top: item.pageY+5, left: item.pageX+5})
						.fadeIn(200);
				} else {
					$("#tooltip").hide();
				}
			}
		});
	}
			
			
</script>       
        
				
<?php include("footer.php"); ?>