<?php include("header.php"); ?>					
					
					<div class="row">
					  <div class="col-md-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2>Add New Trade</h2>
							
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<br />
							<form action="PerformTransaction.php" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left input_mask" data-parsley-validate>

							      <div class="col-md-2 col-sm-2 col-xs-12 form-group">
					                        <input type="text" class="form-control" id="Symbol" name="Symbol" placeholder="Symbol" required>
					                        
					                      </div>
					                      
							  
					                      <div class="col-md-3 col-sm-3 col-xs-12 form-group">
					                          <select id="StrategyID" class="form-control" name="StrategyID" required>
					                            <option value="">Strategy??</option>
					                            <?php
								    	$sqlconn = new MysqlConn();
										$strategyResult = $sqlconn->GetAllStrategy();
								    
								    	for ($i = 0; $i < count($strategyResult ); $i++) {
							    			$obj = $strategyResult[$i];
							    			
							    			echo "<option value='".$obj->StrategyID."'>".$obj->StrategyName."</option>";
							
							    		}
								    ?>
					                          </select>
					                      </div>
					
							      <div class="col-md-3 col-sm-3 col-xs-12 form-group">
					                          <select id="TradeType" name="TradeType" class="form-control" required>
					                            <option value="">Trade Type??</option>
					                            <option value="Real">Real</option>
					                            <option value="Missed">Missed</option>
					                            <option value="Statistics">Statistics</option>
					                          </select>	
					                      </div>
					
							      <div class="col-md-2 col-sm-2 col-xs-12 form-group">
					                          <select id="TradeType" name="OrderType" class="form-control" required>
					                            <option value="">Order Type??</option>
					                            <option value="Buy">Buy</option>
					                            <option value="Sell">Sell</option>					                            
					                          </select>	
					                      </div>
					                      					                      
					                      <div class="col-md-2 col-sm-2 col-xs-12 form-group">
					                          <input type="number" name="LotSize" id="LotSize" class="form-control" step="0.01" placeholder="Lot Size" required>	
					                      </div>
					
					<div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					
							     <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                          <div class='input-group date'>
						                       <input type='text' autocomplete='off' name='EntryDateTime' id='EntryDateTime' class="form-control" placeholder="Entry Date & Time" />
						                       <span class="input-group-addon">
						                       <span class="glyphicon glyphicon-calendar"></span>
						                       </span>
						                  </div>	
					                      </div>
					                      
					                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                          <div class='input-group date'>
						                       <input type='text' autocomplete='off' name='ExitDateTime' id='ExitDateTime' class="form-control" placeholder="Entry Date & Time" />
						                       <span class="input-group-addon">
						                       <span class="glyphicon glyphicon-calendar"></span>
						                       </span>
						                  </div>	
					                      </div>			
		
							      <script type="text/javascript">
						    	      	   
										   var dictStrategy = {};
										   <?php
										   for ($i = 0; $i < count($strategyResult ); $i++) {
												$obj = $strategyResult[$i];
												echo "var tempStrategy = {
														  LotSize: '".$obj->LotSize."',
														  EntryTime: '".$obj->EntryTime."',
														  ExitTime: '".$obj->ExitTime."',
														  TradeType: '".$obj->TradeType."',
														  SL_Pips: '".$obj->SL_Pips."',
														  TP_Pips: '".$obj->TP_Pips."',
														};
														
														dictStrategy['".$obj->StrategyID."'] = tempStrategy;
														"
														
														
														
														
														
														;
							    			
											}
										    ?>
										   
										   $( document ).ready(function() {
											   
											$("#StrategyID").change(function () {
												
												tempStrategy = dictStrategy[$("#StrategyID").val()];
												if(tempStrategy.LotSize != null && tempStrategy.LotSize.length > 0){
													$("#LotSize").val(tempStrategy.LotSize);
												}
												
												if(tempStrategy.EntryTime != null && tempStrategy.EntryTime.length > 0){
													var d = new Date();
													var strDate = d.getFullYear();
													if((d.getMonth()+1).toString().length == 1){
														strDate = strDate + "-0" + (d.getMonth()+1);
													}														
													else{
														strDate = strDate + "-" + (d.getMonth()+1);
													}
													
													if((d.getDate()).toString().length == 1){
														strDate = strDate + "-0" + (d.getDate());
													}														
													else{
														strDate = strDate + "-" + (d.getDate());
													}
													
													$('#EntryDateTime').data('daterangepicker').setStartDate(strDate + " " + tempStrategy.EntryTime);													
												}
												
												
												if(tempStrategy.ExitTime != null && tempStrategy.ExitTime.length > 0){
													var d = new Date();
													var strDate = d.getFullYear();
													if((d.getMonth()+1).toString().length == 1){
														strDate = strDate + "-0" + (d.getMonth()+1);
													}														
													else{
														strDate = strDate + "-" + (d.getMonth()+1);
													}
													
													if((d.getDate()).toString().length == 1){
														strDate = strDate + "-0" + (d.getDate());
													}														
													else{
														strDate = strDate + "-" + (d.getDate());
													}
													
													$('#ExitDateTime').data('daterangepicker').setStartDate(strDate + " " + tempStrategy.ExitTime);													
												}
												
												
												if(tempStrategy.TradeType != null && tempStrategy.TradeType.length > 0){
													$("#TradeType").val(tempStrategy.TradeType);
												}
												
												if(tempStrategy.SL_Pips != null && tempStrategy.SL_Pips.length > 0){
													$("#SL_Pips").val(tempStrategy.SL_Pips);
												}
												
												if(tempStrategy.TP_Pips != null && tempStrategy.TP_Pips.length > 0){
													$("#TP_Pips").val(tempStrategy.TP_Pips);
												}
												
											});   
											   
						    	        	$('#EntryDateTime').daterangepicker({
						    	        		singleDatePicker: true,
						    	        		timePicker24Hour: true,
						    	        		timePicker: true,
										timePickerIncrement: 1,
										autoUpdateInput: true,
										locale: {
											format: 'YYYY-MM-DD HH:mm'
										}
						    	        		
						    	        	});
						    	        	$('#ExitDateTime').daterangepicker({
						    	        		singleDatePicker: true,
						    	        		singleClasses: "picker_3",
						    	        		autoApply: true,
						    	        		timePicker24Hour: true,
						    	        		timePicker: true,
										timePickerIncrement: 1,
										autoUpdateInput: true,
										locale: {
											format: 'YYYY-MM-DD HH:mm'
										}
						    	        	});
						        		$('#ExitDateTime').val("");
						        		$('#EntryDateTime').val("");
						        								        		
						        		$('form').on('submit', function() {
									    	var $fileUpload = $("input[type='file']");
									        if (parseInt($fileUpload.get(0).files.length)>10){
									        	alert("You can only upload a maximum of 10 files");
									        	
									        	return false;
									        }
									        
									        return true;
									});
						        	    });
						    		</script>	
					
							      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="SL_Pips" id="SL_Pips" placeholder="Stop Loss in Pips" step="1" required>					                        
					                      </div>	
					                      
					                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="TP_Pips" id="TP_Pips" placeholder="Take Profit in Pips" step="1" required>					                        
					                      </div>
					
							      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="EntryPrice" id="EntryPrice" placeholder="Entry Price" step="0.00001" required>					                        
					                      </div>	
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="ExitPrice" id="ExitPrice" placeholder="Exit Price" step="0.00001" required>					                        
					                      </div>
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="ProfitLoss" id="ProfitLoss" placeholder="Profit Loss in $" step="0.01" required>					                        
					                      </div>
					
							     <div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					                      
					                      
					                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					                        <textarea rows="4" class="form-control" cols="50" maxlength="10000" name="Remarks" id="Remarks" placeholder="Remarks for this trade"></textarea>        
					                      </div>
					                      
					                      <div class="form-group">
					                        <label class="control-label">Upload Trade Screenshot</label>
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                          <input type="file" name="TradeImages[]" id="TradeImages" multiple/>
					                        </div>
					                      </div>					                      
					                      
					                      <div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					                      
					                      
					                      <label class="control-label">Lesson Learn</label><br />
					                      
				
				
					                      <?php
								    	$sqlconn = new MysqlConn();
									$result = $sqlconn->GetAllLessonLearn();
								    
								    	for ($i = 0; $i < count($result); $i++) {
							    			$obj = $result[$i];
							    			//echo "&nbsp;&nbsp;<input type='checkbox' class='flat' name='LessonLearn[]' value='".$obj->LessonLearnID."'> ".$obj->LessonLearnRemarks."<br>";
							    		
							    			echo "<div class='col-md-3 col-sm-3 col-xs-12' style='padding-bottom: 2px;'><input type='checkbox' class='flat' name='LessonLearn[]' value='".$obj->LessonLearnID."'>".$obj->LessonLearnRemarks."</div>";
							    		}
								    ?>
					                      
							
							      <div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					                      
					                      <div class="form-group">
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                          <button type="submit" class="btn btn-primary">Submit</button>
					                        </div>
					                      </div>							  
							  
							  
							  
							<input type="hidden" name="ActionType" id="ActionType" value="AddTradeV2" >  
							</form>
						  </div>
						</div>

					   </div>
					</div>
				
<?php include("footer.php"); ?>