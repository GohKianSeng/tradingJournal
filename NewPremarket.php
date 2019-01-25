<?php include("header.php"); ?>					
					
					<div class="row">
					  <div class="col-md-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2>Add Premarket Analysis</h2>
							
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<br />
							<form action="PerformTransaction.php" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left input_mask" data-parsley-validate>

							      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                          <div class='input-group date'>
						                       <input type='text' autocomplete='off' name='MarketDate' id='MarketDate' class="form-control" placeholder="Date" />
						                       <span class="input-group-addon">
						                       <span class="glyphicon glyphicon-calendar"></span>
						                       </span>
						                  </div>	
					                      </div>
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="OPG430Difference" id="OPG430Difference" placeholder="OPG 430 Difference" step="0.01">					                        
					                      </div>
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="OPG1amDifference" id="OPG1amDifference" placeholder="OPG 1am Difference" step="0.01">					                        
					                      </div>
					                      
					                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					                        <textarea rows="4" class="form-control" cols="50" maxlength="10000" name="Remarks" id="Remarks" placeholder="Remarks"></textarea>        
					                      </div>
					                      
							      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					                        <label class="control-label">Premarket Screenshot</label>
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                          <input type="file" name="TradeImages[]" id="TradeImages" multiple accept="image/jpg, image/jpeg, image/png" />
					                        </div>
					                      </div>			
		
							      <script type="text/javascript">
						    	      	$( document ).ready(function() {
  									$('#MarketDate').daterangepicker({
						    	        		singleDatePicker: true,
						    	        		singleClasses: "picker_3",
						    	        		timePicker24Hour: true,
						    	        		timePicker: false,
										timePickerIncrement: 1,
										autoUpdateInput: true,
										locale: {
											format: 'YYYY-MM-DD'
										}
						    	        		
						    	        	});
						    	        	
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
					
							      
							      <div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					                      
					                      <div class="form-group">
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                          <button type="submit" class="btn btn-primary">Submit</button>
					                        </div>
					                      </div>							  
							  
							  
							  
							<input type="hidden" name="ActionType" id="ActionType" value="AddPreMarketV2" >  
							</form>
						  </div>
						</div>

					   </div>
					</div>
				
<?php include("footer.php"); ?>