<?php include("header.php"); ?>					
					
					<div class="row">
					  <div class="col-md-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2>Add New Lesson Learn</h2>
							
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<br />
							<form action="PerformTransaction.php" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left input_mask" data-parsley-validate>

							      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                        <input type="text" class="form-control" id="LessonLearnRemarks" name="LessonLearnRemarks" placeholder="Lesson Learn Remarks" required>
					                        
					                      </div>
							  
					                      <div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					                      
					                      <div class="form-group">
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                          <button type="submit" class="btn btn-primary">Submit</button>
					                        </div>
					                      </div>							  
							  
							  
							  
							<input type="hidden" name="ActionType" id="ActionType" value="AddLessonLearn" >  
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