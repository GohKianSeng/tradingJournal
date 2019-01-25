<?php include("header.php"); 

include './cloudinary/Cloudinary.php';

if ($_GET["ActionType"] == "Modify"){
$sqlconn = new MysqlConn();
$result = $sqlconn->GetSelectedPreMarket($_GET["PreMarketID"]);

?>				
	
<!-- Dropzone.js -->
<link href="../vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
<script src="../vendors/dropzone/dist/min/dropzone.min.js"></script>
<link href="https://unpkg.com/nanogallery2/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="https://unpkg.com/nanogallery2/dist/jquery.nanogallery2.min.js"></script>
				
					<div class="row">
					  <div class="col-md-12 col-xs-12">
						<div class="x_panel">
						  <div class="x_title">
							<h2>Modify Premarket Analysis</h2>
							
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
						  <br />
							
							<form action="PerformTransaction.php" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left input_mask" data-parsley-validate>

							      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                          <div class='input-group date'>
						                       <input type='text' autocomplete='off' name='MarketDate' id='MarketDate' class="form-control" placeholder="Date" value="<?php echo $result->MarketDate ?>" />
						                       <span class="input-group-addon">
						                       <span class="glyphicon glyphicon-calendar"></span>
						                       </span>
						                  </div>	
					                      </div>
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="OPG430Difference" id="OPG430Difference" placeholder="OPG 430 Difference" step="0.01" value="<?php echo $result->OPG430Difference ?>">					                        
					                      </div>
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="OPG1amDifference" id="OPG1amDifference" placeholder="OPG 1am Difference" step="0.01" value="<?php echo $result->OPG1amDifference ?>">					                        
					                      </div>
					                      
					                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					                        <textarea rows="4" class="form-control" cols="50" maxlength="10000" name="Remarks" id="Remarks" placeholder="Remarks"><?php echo $result->Remarks ?></textarea>        
					                      </div>
					                      
							      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					                        <label class="control-label">Premarket Screenshot</label>
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                          <div id="dZUpload" class="dropzone">
					                          	<div class="dz-message" data-dz-message>
					                          		<span>Click here to upload screenshots</span>
					                          	</div>
					                          </div>
					                        </div>
					                      </div>			
		
							      <div class="col-md-12 col-sm-12 col-xs-12">
					                          <label class="control-label">Uploaded Screenshots</label>
					                          <div ID="ngy2p" style="overflow: visible;opacity: 1;width: 100%;" data-nanogallery2='{
									"thumbnailWidth": "80",
									"thumbnailHeight": "80",
									"colorScheme": {
										"thumbnail": {
											"background": "rgba(255,0,0,1)"
										}
									},
									"thumbnailLabel": {
										"display": false
									},
									"galleryDisplayMode": "rows",
									"galleryMaxRows": 10,
									"thumbnailAlignment": "left",
									"displayBreadcrumb": false,
									"breadcrumbAutoHideTopLevel": false,
									"breadcrumbOnlyCurrentLevel": false,
									"thumbnailSelectable":    true,
									"thumbnailHoverEffect2":  null
								     }'>
					      
					      
					      			<?php
							      		for ($j = 0; $j < count($result->TradeURL); $j++) {
							      				echo date('Y-m-d H:i:s');
							      			$arrayThumbnail = array("cloud_name" => "tradingjournal", "width"=>250, "crop"=>"scale", "quality"=>"auto");
							      			$arrayFullImage = array("cloud_name" => "tradingjournal", "quality"=>100);
							      			echo "<a id='" . $result->Trade_PublicID[$j] . "' href='" . Cloudinary::cloudinary_url($result->Trade_PublicID[$j], $arrayFullImage) . "' data-ngthumb='" . Cloudinary::cloudinary_url($result->Trade_PublicID[$j], $arrayThumbnail) . "'></a>";
							      		}
							      ?>					      					   		
					 			</div>
								<button type="button" id="deleteImageButton" style="display:none">Delete Selected Image</button>
					                         
					                        
					                      </div>
		
		
		
							      <script type="text/javascript">
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
						    	        	
						        		
						        		
						        		$(document).ready(function () {

									    Dropzone.autoDiscover = false;
									    $("#dZUpload").dropzone({
									        url: "PerformTransaction.php",
									        params: {
									         ActionType: "UploadPremarketImage",
									         PremarketID: "<?php echo $_GET["PreMarketID"] ?>",
									    	},
									    	parallelUploads: 10,
									        addRemoveLinks: false,
									        success: function (file, response) {
									            file.previewElement.classList.add("dz-success");
									            
									            var result = response.split("{");
									            
									            if (result.length == 3){
									            
										          var ngy2data = $("#ngy2p").nanogallery2('data');
											  var instance = $("#ngy2p").nanogallery2('instance');
											        
											  // create the new item
											  var ID = result[0];
											  var albumID = '0';
											  var newItem = NGY2Item.New(instance, 'new berlin ' + ID, '', ID, albumID, 'image', '' );
											
											  // define thumbnail -> image displayed in the gallery
											  newItem.thumbSet( result[2], 80, 80); // w,h
											
											  // define URL of the media to display in lightbox
											  newItem.setMediaURL( result[1], 'img');
											  
											  // currently displayed album
											  if( ngy2data.items[ngy2data.gallery.albumIdx].GetID() == 0 ) {
											
											    // add new item to current Gallery Object Model (GOM) 
											    newItem.addToGOM();
											  
											    // refresh the display (-> only once if you add multiple items)
											    $("#ngy2p").nanogallery2('resize');
									            	}
									            
									            }
									            
									            
									            console.log("Successfully uploaded :" + imgName);
									        },
									        error: function (file, response) {
									            file.previewElement.classList.add("dz-error");
									        }
									    });
									
									      $("#uploadImageButton").click(function () {
									        var filename = $("#file").val();
									
									        $.ajax({
									            type: "POST",
									            url: "addFile.do",
									            enctype: 'multipart/form-data',
									            data: {
									                file: filename
									            },
									            success: function () {
									                alert("Data Uploaded: ");
									            }
									        });
									    });
									
									      $('#deleteImageButton').on('click', function() {
										  if (confirm('Are you sure you want to delete selected images?')) {
										     	  var ngy2data = $("#ngy2p").nanogallery2('data');
											  ngy2data.items.forEach( function(item) {
											    if( item.selected ) {
											      
											      
											      var myKeyVals = { PremarketID : "<?php echo $_GET["PreMarketID"] ?>", PublicID: item.GetID(), ActionType : "deletePremarketImage" };
											      
											      var saveData = $.ajax({
												      type: 'POST',
												      url: "PerformTransaction.php",
												      data: myKeyVals,
												      dataType: "text",
												      success: function(resultData) { 
												      	item.delete(); 
												      	$("#my_nanogallery2").nanogallery2('resize');
												      	$('#deleteImageButton').hide();
												      }
												});
											    }
											  });
											  
										    } 	  
										});
									
									      function mylistener(e) {
									        var selectedImages = $('#ngy2p').nanogallery2('itemsSelectedGet');
									        if(selectedImages.length > 0){
									        	$('#deleteImageButton').show();
									        }
									        else{
									        	$('#deleteImageButton').hide();
									        }
									      }      
									
									      $("#ngy2p").on('itemSelected.nanogallery2 itemUnSelected.nanogallery2', mylistener);      
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
							  
							<input type="hidden" name="PublicGUID" id="PublicGUID" value="<?php echo $result->PublicGUID ?>" >  
							<input type="hidden" name="PreMarketID" id="PreMarketID" value="<?php echo $_GET["PreMarketID"] ?>" >  
							<input type="hidden" name="ActionType" id="ActionType" value="ModifyPreMarket" >  
							</form>
							
						  </div>
						</div>

					   </div>
					</div>
				
<?php 
}

include("footer.php"); ?>