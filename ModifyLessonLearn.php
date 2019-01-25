<?php include("header.php"); 
if($_GET["ActionType"] == "Modify")
{
?>					
					
					<div class="row">
					  <div class="col-md-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2>Modify Lesson Learn</h2>
							
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<br />
							<form action="PerformTransaction.php" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left input_mask" data-parsley-validate>

							      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                        <input type="text" class="form-control" id="LessonLearnRemarks" name="LessonLearnRemarks" placeholder="Lesson Learn Remarks" value="<?php echo $_GET["LessonLearnRemarks"]; ?>" required>
					                        
					                      </div>
							  
					                      <div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					                      
					                      <div class="form-group">
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                          <button type="submit" class="btn btn-primary">Submit</button>
					                        </div>
					                      </div>							  
							  
							  
							<input type="hidden" name="LessonLearnID" id="LessonLearnID" value="<?php echo $_GET["LessonLearnID"] ?>">  
							<input type="hidden" name="ActionType" id="ActionType" value="ModifyLessonLearn" >  
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
							<h2>Delete Lesson Learn</h2>
							
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<br />
							<form action="PerformTransaction.php" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left input_mask" data-parsley-validate>

							      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                        <input type="text" class="form-control" id="LessonLearnRemarks" name="LessonLearnRemarks" placeholder="Lesson Learn Remarks" value="<?php echo $_GET["LessonLearnRemarks"]; ?>" readonly>
					                        
					                      </div>
							  
					                      <div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					                      
					                      <div class="form-group">
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                          <button type="submit" class="btn btn-primary">Yes, Delete It</button>
					                        </div>
					                      </div>							  
							  
							  
							<input type="hidden" name="LessonLearnID" id="LessonLearnID" value="<?php echo $_GET["LessonLearnID"] ?>">  
							<input type="hidden" name="ActionType" id="ActionType" value="DeleteLessonLearn" >  
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