<?php
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end
if(isset($_POST["numPerPage"])){
    $numPerPage=$_POST["numPerPage"];
    $pageNum=$_POST["pageNum"];
}
?>
<style type="text/css">
	ul.rightTools {float:right; display:block;}
	ul.rightTools li{float:left; display:block; margin-left:5px}
</style>

<div class="pageContent" style="padding:5px">
	<div class="tabs">
		<div class="tabsContent">
			<div>
	
				<div layoutH="32" style="float:left; display:block; overflow:auto; width:240px; border:solid 1px #CCC; line-height:21px; background:#fff">
				    <ul class="tree treeFolder">
				    <?php

				    $resultarray=$base->data("company");
				    for($a=0;$a<count($resultarray);$a++){
				    ?>
						<li><a href="javascript:;"><?php echo $resultarray[$a]["hotelname"];?></a>
							<ul>
							<?php
							$resultdeptarray=$db->select("t_dept","*","hotel='".$resultarray[$a]["hotelcode"]."'");
				    for($b=0;$b<count($resultdeptarray);$b++){?>
								<li><a href="xtgl/user.php?dept=<?php echo $resultdeptarray[$b]["id"]; ?>&hotel=<?php echo $resultarray[$a]["hotelcode"]; ?>" target="ajax" rel="jbsxBox"><?php echo $resultdeptarray[$b]["deptname"]; ?></a></li>
								<?php }?>
							</ul>
						</li>
						<?php }?>
				     </ul>
				</div>
				
				<div id="jbsxBox" class="unitBox" style="margin-left:246px;">
					
<form id="pagerForm" method="post" action="xtgl/yhgl.php">

	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />

</form>



<div class="pageContent">
	
	<table class="table" width="100%" layoutH="78" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">登录账号</th>
				<th align="center">姓名</th>
				<th align="center">职务</th>
				<th align="center">所属公司</th>
				<th align="center">所属部门</th>
				<th align="center">启用标志</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 

			$result=$db->tabledata($pageNum,$numPerPage,"t_user","*","1=1","id");
			$resultnum=$result["amount"];
			$resultnowarray=$result["result"];
			for($a=0;$a<count($resultnowarray);$a++){
			    
			?>
			  <tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php echo $resultnowarray[$a]['username'];?>
            </td><td ><?php echo $resultnowarray[$a]['realName'];?>
            </td><td ><?php echo $resultnowarray[$a]['duty'];?>
			</td><td  ><?php 

			echo $base->getdata("company",$resultnowarray[$a]['hotel'])["hotelname"];
			?>
			</td><td  ><?php 

			echo $base->getdata("department",$resultnowarray[$a]['dept'])["deptname"];
			?>

</td><td ><?php echo $resultnowarray[$a]['isUser'];?>
			</td>
			<td><a href="xtgl/qxgl.php?id=<?php echo $resultnowarray[$a]['id'];?>"  style="color:blue;" target="dialog" mask="true"  width="800" height="610" rel="qxgl">权限管理</a>
			<a  href="xtgl/edituser.php?id=<?php echo $resultnowarray[$a]["id"];?>" style="color:blue;" target="dialog" mask="true" width="660" height="292" rel="edituser" >修改</a>
	
			</td>
			
			</tr>
<?php			
}
 
    ?>
		</tbody>
	</table>
	
<?php require R.'temp/table/default_footer.php';?>
</div>
				</div>
	
			</div>
		</div>
		<div class="tabsFooter">
			<div class="tabsFooterContent"></div>
		</div>
	</div>
	
</div>


	

