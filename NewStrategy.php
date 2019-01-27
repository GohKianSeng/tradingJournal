<?php include("header.php"); ?>					
					
					<div class="row">
					  <div class="col-md-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2>Add New Strategy</h2>
							
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<br />
							<form action="PerformTransaction.php" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left input_mask" data-parsley-validate>

							      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                        <input type="text" class="form-control" id="StrategyName" name="StrategyName" placeholder="Strategy Name" required>
					                        
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
					                          <input type="number" name="LotSize" id="LotSize" class="form-control" step="0.01" placeholder="Lot Size">	
					                        </div>
					                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                          <div class='input-group date'>
						                       <input type='text' autocomplete='off' name='EntryDateTime' id='EntryDateTime' class="form-control" placeholder="Entry Time" />
						                       <span class="input-group-addon">
						                       <span id="extraClockClick1" class="glyphicon glyphicon-time"></span>
						                       </span>						                      
						                  </div>	
					                      </div>
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                          <div class='input-group date'>
						                       <input type='text' autocomplete='off' name='ExitDateTime' id='ExitDateTime' class="form-control" placeholder="Exit Time" />
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
					                            <option value="Real">Real</option>
					                            <option value="Missed">Missed</option>
					                            <option value="Statistics">Statistics</option>
					                          </select>	
					                      </div>
							      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="SL_Pips" id="SL_Pips" placeholder="Stop Loss in Pips" step="1">					                        
					                      </div>	
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="TP_Pips" id="TP_Pips" placeholder="Take Profit in Pips" step="1">					                        
					                      </div>
					                  </div>
							<input type="hidden" name="ActionType" id="ActionType" value="AddStrategy" >  
							</form>
						  </div>
						</div>

					   </div>
					</div>
					
					
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