<style>

span.ex1 {
  min-width: 300px;
  display: inline-block;
}
</style>

<?php 
include("header.php"); 
include './cloudinary/Cloudinary.php';
include './config/CommonFunction.php';
			
$sqlconn = new MysqlConn();
$result = $sqlconn->GetAllPreMarket();
for ($i = 0; $i < count($result ); $i++) {
	$obj = $result[$i];
?>		
	    <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $obj->MarketDate; ?></h2>
		    <ul class="nav navbar-right panel_toolbox">
                      <li><a href="ModifyPremarket.php?ActionType=Modify&PreMarketID=<?php echo $obj->PreMarketID; ?>"><i class="fa fa-pencil"></i></a>
                      </li>
                      <li><a></a></li><li><a></a></li>
                      <li><a href="#" onClick="CopyURL('<?php echo $obj->PreMarketID; ?>');"><i class="fa fa-share-alt"></i></a>
                      	<div style="display:block"><textarea style="width:0px;height:0px;opacity:0" name="PublicGUID<?php echo $obj->PreMarketID; ?>" id="PublicGUID<?php echo $obj->PreMarketID; ?>"><?php echo url()."/ViewPublicPremarket.php?PublicGUID=".$obj->PublicGUID; ?></textarea></div>
                      </li>
                      <li><a></a></li><li><a></a></li>
                      <li><a href="#" onClick="DeleteTrade('<?php echo $obj->PreMarketID; ?>');"><i class="fa fa-trash"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				   
                    <div class="row" style="padding-bottom: 5px; margin-bottom: 5px;">
                      <div class="col-md-5 col-sm-5 col-xs-12 form-group">
                        
                        <?php
                        	if(count($obj->TradeURL) > 0){
                        
                        ?>
                        
                        	<div ID="ngy2p<?php echo $i; ?>" style="overflow: visible;opacity: 1;width: 100%;" data-nanogallery2='{
					        "thumbnailWidth": "auto",
					        "thumbnailHeight": "360",
					        "colorScheme": {
					          "thumbnail": {
					            "background": "rgba(255,0,0,1)"
					          }
					        },
					        "thumbnailLabel": {
					          "display": false
					        },
					        "galleryDisplayMode": "rows",
					        "galleryMaxRows": 1,
					        "thumbnailAlignment": "left",
					        "displayBreadcrumb": false,
					        "breadcrumbAutoHideTopLevel": false,
					        "breadcrumbOnlyCurrentLevel": false,
						"thumbnailSelectable":    false,
					        "thumbnailHoverEffect2":  null
					      }'>
					      			
						<?php
							for ($j = 0; $j < count($obj->TradeURL); $j++) {
								$arrayThumbnail = array("cloud_name" => "tradingjournal", "width"=>650, "crop"=>"scale", "quality"=>"100");
									$arrayFullImage = array("cloud_name" => "tradingjournal", "quality"=>100);
									echo "<a href='" . Cloudinary::cloudinary_url($obj->Trade_PublicID[$j], $arrayFullImage) . "' data-ngthumb='" . Cloudinary::cloudinary_url($obj->Trade_PublicID[$j], $arrayThumbnail) . "'></a>";
							}
						?>	     
								
							</div>	      
					      
			<?php
				}				
                        ?>
                        <span class="ex1"></span>
                      </div>					  
		      <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                        <div class="row" style="text-align: center;">
                          <div class="col-md-12">
                            <div class="block">
							  <div class="block_content">
								<h5 class="title" style="text-align:left">
								  <a>430pm Difference</a>
								</h5>
								<p class="excerpt" style="text-align:left"><?php echo $obj->OPG430Difference; ?></p>
							  </div>
							  <div class="block_content">
								<h5 class="title" style="text-align:left">
								  <a>1am Difference</a>
								</h5>
								<p class="excerpt" style="text-align:left"><?php echo $obj->OPG1amDifference; ?></p>
							  </div>					  
			     </div>
                          </div>
                          
                        </div>
                      </div>                      
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <div class="row" style="text-align: center;">
                          <div class="col-md-12">
                            <div class="block">
							  <div class="block_content">
								<h5 class="title" style="text-align:left">
								  <a>Trade Remarks</a>
								</h5>
								<p class="excerpt" style="text-align:left"><?php echo $obj->Remarks; ?></p>
							  </div>
							</div>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
				
<?php 
}

include("footer.php"); ?>




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

    $(document).ready(function () {
	$('#mainRightCol').attr('style','');
	

    });
    
    function CopyURL(premarketid)
	{
		dummy = document.getElementById("PublicGUID" + premarketid);		
		dummy.select();
    		document.execCommand("copy");
    		alert("URL link copied to clipboard.");
	}
    
    function DeleteTrade(premarketid)
	{
	   if (confirm('Are you sure you want to delete this premarket record?')) {
		    $.redirectPost('PerformTransaction.php', { PreMarketID: premarketid, ActionType: "DeletePreMarket" });	    
	    } 
	    
	}
      
  </script>