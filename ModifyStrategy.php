<?php include("header.php"); 
if($_GET["ActionType"] == "Modify")
{

$sqlconn = new MysqlConn();
$strategyResult = $sqlconn->GetSelectedStrategy($_GET["StrategyID"]);	
	
?>					
					
					<div class="row">
					  <div class="col-md-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2>Modify Strategy</h2>
							
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<br />
							<form action="PerformTransaction.php" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left input_mask" data-parsley-validate>

							      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                        <input type="text" class="form-control" id="StrategyName" name="StrategyName" placeholder="Strategy Name" value="<?php echo $_GET["StrategyName"]; ?>" required>
					                        
					                      </div>
							  
					                      <div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					                      
					                      <div class="form-group">
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                          <button type="submit" class="btn btn-primary">Submit</button>
					                        </div>
					                      </div>							  
							  
								<div class="form-group" style="padding-top: 100px;Display:block">
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                          <div class="x_title">
									<h4>Predefined Value on Add New Trade<small> (below fields are not mandatory)</small></h4>
									
									<div class="clearfix"></div>
								  </div>
					                        </div>
					                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                          <input type="number" name="LotSize" id="LotSize" class="form-control" step="0.01" placeholder="Lot Size" value="<?php echo $strategyResult->LotSize; ?>" />	
					                        </div>
					                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                          <div class='input-group date'>
						                       <input type='text' autocomplete='off' name='EntryDateTime' id='EntryDateTime' class="form-control" placeholder="Entry Time" value="<?php echo $strategyResult->EntryTime; ?>" />
						                       <span class="input-group-addon">
						                       <span id="extraClockClick1" class="glyphicon glyphicon-time"></span>
						                       </span>						                      
						                  </div>	
					                      </div>
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                          <div class='input-group date'>
						                       <input type='text' autocomplete='off' name='ExitDateTime' id='ExitDateTime' class="form-control" placeholder="Exit Time" value="<?php echo $strategyResult->ExitTime; ?>" />
						                       <span class="input-group-addon">
						                       <span id="extraClockClick2" class="glyphicon glyphicon-time"></span>
						                       </span>
						                  </div>	
					                      </div>
					                      
					                      <script>
									        $('#EntryDateTime').clockTimePicker({
												OtherOnClickShow : 'extraClockClick1', colors: {selectorColor: '#5179A2', hoverCircleColor: 'C5D3E2'}});
											
										    $('#ExitDateTime').clockTimePicker({
												OtherOnClickShow : 'extraClockClick2', colors: {selectorColor: '#5179A2', hoverCircleColor: 'C5D3E2'}});
											
									    </script>
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                          <select id="TradeType" name="TradeType" class="form-control">
					                            <option value="">Trade Type??</option>
					                            <option value="Real" <?php if($strategyResult->TradeType == "Real") {echo "SELECTED";} ?> >Real</option>
					                            <option value="Missed" <?php if($strategyResult->TradeType == "Missed") {echo "SELECTED";} ?> >Missed</option>
					                            <option value="Statistics" <?php if($strategyResult->TradeType == "Statistics") {echo "SELECTED";} ?> >Statistics</option>
					                          </select>	
					                      </div>
							      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="SL_Pips" id="SL_Pips" placeholder="Stop Loss in Pips" step="1" value="<?php echo $strategyResult->SL_Pips; ?>" />					                        
					                      </div>	
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="TP_Pips" id="TP_Pips" placeholder="Take Profit in Pips" step="1" value="<?php echo $strategyResult->TP_Pips; ?>" />					                        
					                      </div>
					                  </div>
							
							<input type="hidden" name="StrategyID" id="StrategyID" value="<?php echo $_GET["StrategyID"] ?>">  
							<input type="hidden" name="ActionType" id="ActionType" value="ModifyStrategy" >  
							</form>
						  </div>
						</div>

					   </div>
					</div>
<?php }
else if($_GET["ActionType"] == "Delete")
{ 
?>				
					<div class="row">
					  <div class="col-md-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2>Delete Strategy</h2>
							
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<br />
							<form action="PerformTransaction.php" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left input_mask" data-parsley-validate>

							      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                        <input type="text" class="form-control" id="StrategyName" name="StrategyName" placeholder="Strategy Name" value="<?php echo $_GET["StrategyName"]; ?>" readonly>
					                        
					                      </div>
							  
					                      <div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					                      
					                      <div class="form-group">
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                          <button type="submit" class="btn btn-primary">Yes, Delete It</button>
					                        </div>
					                      </div>							  
							  
							  
							<input type="hidden" name="StrategyID" id="StrategyID" value="<?php echo $_GET["StrategyID"] ?>">  
							<input type="hidden" name="ActionType" id="ActionType" value="DeleteStrategy" >  
							</form>
						  </div>
						</div>

					   </div>
					</div>
<?php }?>
					<script>
						$(document).ready(function() {
							<?php
								if(isset($_GET["Message"])){
							?>
									
									new PNotify({
					                                  title: 'Notification',
					                                  text: '<?php echo $_GET["Message"] ?>',
					                                  type: 'info',
					                                  styling: 'bootstrap3',
					                                  addclass: 'dark'
					                              	});
							<?php
								}														
							?>																		
									
						});	
					</script>

					
					
				
<?php include("footer.php"); ?>