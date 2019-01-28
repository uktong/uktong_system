<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
?>
<style type="text/css">
	ul.rightTools {float:right; display:block;}
	ul.rightTools li{float:left; display:block; margin-left:5px}
</style>

<div class="pageContent" style="padding:5px">
	<div class="tabs">
		<div class="tabsContent">
			<div>
	
				<div layoutH="146" style="float:left; display:block; overflow:auto; width:240px; border:solid 1px #CCC; line-height:21px; background:#fff">
				    <ul class="tree treeFolder">
				  
						<li><a href="javascript:;">公司</a>
							<ul>
							<?php   require_once $_SESSION["ROOT"].'/db/db.php';
				    $result=mysqli_query($con,"select hotelname,hotelcode from t_hotel" );
				    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
				    for($a=0;$a<count($resultarray);$a++){ ?>
				    
								<li><a href="xtgl/bm.php?hotel=<?php echo $resultarray[$a]["hotelcode"]; ?>" target="ajax" rel="bmglbox"><?php echo $resultarray[$a]["hotelname"]; ?></a></li>
								<?php }?>
							</ul>
						</li>
						
				     </ul>
				</div>
				
				<div id="bmglbox" class="unitBox" style="margin-left:246px;">
					<!--#include virtual="list1.html" -->
				</div>
	
			</div>
		</div>
		<div class="tabsFooter">
			<div class="tabsFooterContent"></div>
		</div>
	</div>
	
</div>


	

