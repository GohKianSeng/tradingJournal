<?php include("header.php"); 

include './cloudinary/Cloudinary.php';

if ($_GET["ActionType"] == "ModifyV2"){
$sqlconn = new MysqlConn();
$tradeResult = $sqlconn->GetSelectedTrade($_GET["TradeID"]);

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
							<h2>Add New Trade</h2>
							
							<div class="clearfix"></div>
						  </div>
						  <div class="x_content">
							<br />
							<form action="PerformTransaction.php" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left input_mask" data-parsley-validate>

							      <div class="col-md-2 col-sm-2 col-xs-12 form-group">
					                        <input type="text" class="form-control" id="Symbol" name="Symbol" placeholder="Symbol" value="<?php echo $tradeResult->Symbol ?>" required>
					                        
					                      </div>
					                      
							  
					                      <div class="col-md-3 col-sm-3 col-xs-12 form-group">
					                          <select id="StrategyID" class="form-control" name="StrategyID" required>
					                            <option value="">Strategy??</option>
					                            <?php
								    	$sqlconn = new MysqlConn();
									$result = $sqlconn->GetAllStrategy();
								    
								    	for ($i = 0; $i < count($result ); $i++) {
							    			$obj = $result[$i];
							    			if($obj->StrategyName == $tradeResult->StrategyName){
							    				echo "<option value='".$obj->StrategyID."' selected>".$obj->StrategyName."</option>";
							    			}
							    			else
							    			{
							    				echo "<option value='".$obj->StrategyID."'>".$obj->StrategyName."</option>";
							
							    			}
							    		}
								    ?>
					                          </select>
					                      </div>
					
							      <div class="col-md-3 col-sm-3 col-xs-12 form-group">
					                          <select id="TradeType" name="TradeType" class="form-control" required>
					                            <option value="">Trade Type??</option>
					                            <option value="Real" <?php if($tradeResult->TradeType == "Real"){echo "selected";}?>>Real</option>
					                            <option value="Missed" <?php if($tradeResult->TradeType == "Missed"){echo "selected";}?>>Missed</option>
					                            <option value="Statistics" <?php if($tradeResult->TradeType == "Statistics"){echo "selected";}?>>Statistics</option>
					                          </select>	
					                      </div>
					
							      <div class="col-md-2 col-sm-2 col-xs-12 form-group">
					                          <select id="TradeType" name="OrderType" class="form-control" required>
					                            <option value="">Order Type??</option>
					                            <option value="Buy" <?php if($tradeResult->OrderType == "Buy"){echo "selected";}?>>Buy</option>
					                            <option value="Sell" <?php if($tradeResult->OrderType == "Sell"){echo "selected";}?>>Sell</option>					                            
					                          </select>	
					                      </div>
					                      					                      
					                      <div class="col-md-2 col-sm-2 col-xs-12 form-group">
					                          <input type="number" name="LotSize" id="LotSize" class="form-control" step="0.01" placeholder="Lot Size" value="<?php echo $tradeResult->LotSize ?>" required>	
					                      </div>
					
					<div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					
							     <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                          <div class='input-group date'>
						                       <input type='text' autocomplete='off' name='EntryDateTime' id='EntryDateTime' class="form-control" placeholder="Entry Date & Time" value="<?php echo $tradeResult->EntryDateTime ?>" />
						                       <span class="input-group-addon">
						                       <span class="glyphicon glyphicon-calendar"></span>
						                       </span>
						                  </div>	
					                      </div>
					                      
					                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                          <div class='input-group date'>
						                       <input type='text' autocomplete='off' name='ExitDateTime' id='ExitDateTime' class="form-control" placeholder="Entry Date & Time" value="<?php echo $tradeResult->ExitDateTime ?>" />
						                       <span class="input-group-addon">
						                       <span class="glyphicon glyphicon-calendar"></span>
						                       </span>
						                  </div>	
					                      </div>			
		
							      <script type="text/javascript">
							      
							      		$('#EntryDateTime').daterangepicker({
						    	        		singleDatePicker: true,
						    	        		singleClasses: "picker_3",
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

						    		</script>	
					
							      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="SL_Pips" id="SL_Pips" placeholder="Stop Loss in Pips" step="1" value="<?php echo $tradeResult->SL_Pips ?>" required>					                        
					                      </div>	
					                      
					                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="TP_Pips" id="TP_Pips" placeholder="Take Profit in Pips" step="1" value="<?php echo $tradeResult->TP_Pips ?>" required>					                        
					                      </div>
					
							      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="EntryPrice" id="EntryPrice" placeholder="Entry Price" step="0.00001" value="<?php echo $tradeResult->EntryPrice ?>" required>					                        
					                      </div>	
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="ExitPrice" id="ExitPrice" placeholder="Exit Price" step="0.00001" value="<?php echo $tradeResult->ExitPrice ?>" required>					                        
					                      </div>
					                      
					                      <div class="col-md-4 col-sm-4 col-xs-12 form-group">
					                        <input type="number" class="form-control" name="ProfitLoss" id="ProfitLoss" placeholder="Profit Loss in $" step="0.01" value="<?php echo $tradeResult->ProfitLoss ?>" required>					                        
					                      </div>
					
							     <div class="form-group">
					                        
					                      </div>
					                      <div class="ln_solid"></div>
					                      
					                      
					                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					                        <textarea rows="4" class="form-control" cols="50" maxlength="10000" name="Remarks" id="Remarks" placeholder="Remarks for this trade"><?php echo $tradeResult->Remarks ?></textarea>        
					                      </div>
					                      
					                      
					                      
					                      
					                      
					                      
					                      
					                      
					                      
					                      
					                      
					                      <div class="form-group">
					                        <label class="control-label">Upload Trade Screenshot</label>
					                        <div class="col-md-12 col-sm-12 col-xs-12">
						                  <div class="x_content">
						                    <div id="dZUpload" class="dropzone"><div class="dz-message" data-dz-message>								<span>Click here to upload screenshots</span></div></div>
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
							      		for ($j = 0; $j < count($tradeResult->TradeURL); $j++) {
							      				echo date('Y-m-d H:i:s');
							      			$arrayThumbnail = array("cloud_name" => "tradingjournal", "width"=>250, "crop"=>"scale", "quality"=>"auto");
							      			$arrayFullImage = array("cloud_name" => "tradingjournal", "quality"=>100);
							      			echo "<a id='" . $tradeResult->Trade_PublicID[$j] . "' href='" . Cloudinary::cloudinary_url($tradeResult->Trade_PublicID[$j], $arrayFullImage) . "' data-ngthumb='" . Cloudinary::cloudinary_url($tradeResult->Trade_PublicID[$j], $arrayThumbnail) . "'></a>";
							      		}
							      ?>					      					   		
					 			</div>
								<button type="button" id="deleteImageButton" style="display:none">Delete Selected Image</button>
					                          
<script type="text/javascript">
$(document).ready(function () {

    Dropzone.autoDiscover = false;
    $("#dZUpload").dropzone({
        url: "PerformTransaction.php",
        params: {
         ActionType: "UploadImage",
         TradeID: "<?php echo $_GET["TradeID"] ?>",
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
		      
		      
		      var myKeyVals = { TradeID : "<?php echo $_GET["TradeID"] ?>", UserGUID : "<?php echo $_SESSION['UserGUID'] ?>", PublicID: item.GetID(), ActionType : "deleteImage" };
		      
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
					                          
					                          
					                          
					                        </div>
					                      </div>					                      
					                      
					             
					                      <div class="ln_solid"></div>
					                      
					                      
					                      <label class="control-label">Lesson Learn</label><br />
					                      
				
				
					                      <?php
								    	$sqlconn = new MysqlConn();
									$result = $sqlconn->GetAllLessonLearn();
								    
								    	$pieces = explode(", ", $tradeResult->LessonLearn);
								    
								    	for ($i = 0; $i < count($result); $i++) {
							    			$obj = $result[$i];
							    			
							    			if (in_array($obj->LessonLearnRemarks, $pieces )) {
							    				echo "<div class='col-md-3 col-sm-3 col-xs-12' style='padding-bottom: 2px;'><input type='checkbox' class='flat' name='LessonLearn[]' value='".$obj->LessonLearnID."' checked='checked'>".$obj->LessonLearnRemarks."</div>";
							    			}
							    			else{
							    				echo "<div class='col-md-3 col-sm-3 col-xs-12' style='padding-bottom: 2px;'><input type='checkbox' class='flat' name='LessonLearn[]' value='".$obj->LessonLearnID."'>".$obj->LessonLearnRemarks."</div>";
							    			}
							    			
							    			
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
							  
							  
							  
							<input type="hidden" name="ActionType" id="ActionType" value="ModifyTrade" >
							<input type="hidden" name="TradeID" id="TradeID" value="<?php echo $_GET["TradeID"] ?>" >  
							</form>
						  </div>
						</div>

					   </div>
					</div>
				
<?php 
}

include("footer.php"); ?>