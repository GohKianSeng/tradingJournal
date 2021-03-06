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
$DateStart = date('Y-m-01');
$DateEnd = date('Y-m-t');

if (isset($_GET["Date"]) && strlen($_GET["Date"]) > 0){
	$DateStart = $_GET["Date"];
	$dateTime = strtotime($_GET["Date"]);
	$DateEnd = date('Y-m-t', $dateTime);
}
if (isset($_GET["LessonLearnID"])){
	$result = $sqlconn->GetAllLessonLearnTrades($DateStart, $DateEnd, $_GET["LessonLearnID"]);
}
else if (isset($_GET["StrategyID"])){
	$result = $sqlconn->GetAllStrategyTrades($DateStart, $DateEnd, $_GET["StrategyID"], $_GET["ProfitLoss"]);
}
else{
	$result = $sqlconn->GetAllTrades();
}


for ($i = 0; $i < count($result ); $i++) {
	$obj = $result[$i];
?>		
	    <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 style="width:85%">
					    <font size="2">
						<table width="100%">
							<tr>
								<td style="text-align:left"><b><?php echo $obj->Symbol; ?> <?php echo $obj->StrategyName; ?> 
									<?php if($obj->OrderType == "Sell")
										{ 
											echo "<font color='red'>" . $obj->OrderType . "</font>";
										}
										else
										{
											echo "<font color='blue'>" . $obj->OrderType . "</font>";
										} ?></b> On: <?php echo $obj->EntryDateTime; ?></td>
								<td style="text-align:left"></td>
								<td style="text-align:right">P/L: <b>$<?php echo $obj->ProfitLoss; ?></b></td>
							</tr>
						</table>
						</font>
					</h2>
					<ul class="nav navbar-right panel_toolbox">
                      <li><a href="ModifyTradeV2.php?ActionType=ModifyV2&TradeID=<?php echo $obj->TradeID; ?>"><i class="fa fa-pencil"></i></a>
                      </li>
                      <li><a></a></li><li><a></a></li>
                      <li><a href="#" onClick="CopyURL('<?php echo $obj->TradeID; ?>');"><i class="fa fa-share-alt"></i></a>
                      	<div style="display:block"><textarea style="width:0px;height:0px;opacity:0" name="PublicGUID<?php echo $obj->TradeID; ?>" id="PublicGUID<?php echo $obj->TradeID; ?>"><?php echo url()."/ViewPublicTrade.php?PublicGUID=".$obj->PublicGUID; ?></textarea></div>
                      </li>
                      <li><a></a></li><li><a></a></li>
                      <li><a href="#" onClick="DeleteTrade('<?php echo $obj->TradeID; ?>');"><i class="fa fa-trash"></i></a>
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
								$arrayThumbnail = array("cloud_name" => "tradingjournal", "width"=>650, "crop"=>"scale", "quality"=>100);
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
								  <a>Closed on</a>
								</h5>
								<p class="excerpt" style="text-align:left"><?php echo $obj->ExitDateTime; ?></p>
							  </div>
							  <div class="block_content">
								<h5 class="title" style="text-align:left">
								  <a>Lot Size</a>
								</h5>
								<p class="excerpt" style="text-align:left"><?php echo $obj->LotSize; ?></p>
							  </div>
			     </div>
                          </div>
                          
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                        <div class="row" style="text-align: center;">
                          <div class="col-md-12">
                            <div class="block">
							  <div class="block_content">
								<h5 class="title" style="text-align:left">
								  <a>Trade Type</a>
								</h5>
								<p class="excerpt" style="text-align:left">
									<?php 
										if($obj->TradeType == "Missed"){
											echo "<b><font color='red'>" . $obj->TradeType. "</font></b>";
										} 
										else if($obj->TradeType == "Statistics"){
											echo "<font color='purple'>" . $obj->TradeType. "</font>";
										}
										else{
											echo $obj->TradeType;
										}
									?></p>
							  </div>
							  <div class="block_content">
								<h5 class="title" style="text-align:left">
								  <a>Lesson Learned</a>
								</h5>
								<p class="excerpt" style="text-align:left"><?php echo $obj->LessonLearn; ?></p>
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

	function CopyURL(tradeid)
	{
		dummy = document.getElementById("PublicGUID" + tradeid);		
		dummy.select();
    		document.execCommand("copy");
    		alert("URL link copied to clipboard.");
	}
	
	function DeleteTrade(tradeid)
	{
	   if (confirm('Are you sure you want to delete this trade record?')) {
		    $.redirectPost('PerformTransaction.php', { TradeID: tradeid, ActionType: "DeleteTrade" });	    
	    } 
	    
	}
      
  </script>