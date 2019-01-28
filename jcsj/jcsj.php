<?php
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end
$firstday = date("Y-m");
?>
<style type="text/css">
	ul.rightTools {float:right; display:block;}
	ul.rightTools li{float:left; display:block; margin-left:5px}
</style>

<div class="pageContent" style="padding:5px">
	<div class="tabs">
		<div class="tabsContent">
			<div>
	
				<div layoutH="36" style="float:left; display:block; overflow:auto; width:240px; border:solid 1px #CCC; line-height:21px; background:#fff">
				    <ul class="tree treeFolder">
				  	
				    
						
						<li><a href="javascript:;">基础数据分类</a>
						<?php  
				    $resultarray=$db->select("t_base", "Type,id", "1=1");
				    for($a=0;$a<count($resultarray);$a++){ ?>
							<ul><li>
						<a href="jcsj/jcsjlr.php?km=<?php echo $resultarray[$a]["id"]."&J=".$_GET["J"]; ?>" target="ajax" rel="jcsjbox">
						<?php echo $resultarray[$a]["Type"]; ?></a>
						</li>
							</ul>
							<?php }?>
						</li>
				     </ul>
				</div>
				
				<div id="jcsjbox" class="unitBox" style="margin-left:246px;">
		
	</div>
			</div>
		</div>
		<div class="tabsFooter">
			<div class="tabsFooterContent"></div>
		</div>
	</div>
	
</div>


	

