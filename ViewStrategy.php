<?php include("header.php"); 

$sqlconn = new MysqlConn();
$result = $sqlconn->GetAllStrategy();

?>					
					
		<div class="row">
              


              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Strategy</h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th width="50px"></th>
                          <th width="50px"></th>
                          <th>Description</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        for ($i = 0; $i < count($result ); $i++) {
    				$obj = $result[$i];
    				$temp = $i+1;
    				echo "<tr>
					
					<td><a href='ModifyStrategy.php?ActionType=Modify&StrategyName=".$obj->StrategyName."&StrategyID=".$obj->StrategyID."'><i class='fa fa-pencil'></i></a></td>
					<td><a href='ModifyStrategy.php?ActionType=Delete&StrategyName=".$obj->StrategyName."&StrategyID=".$obj->StrategyID."'><i class='fa fa-trash'></i></a></td>
					<td>".$obj->StrategyName."</td>
				</tr>";
			}
                        ?>                        
                      </tbody>
                    </table>

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