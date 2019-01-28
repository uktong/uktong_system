<?php
//base start
require "../../hzb/config.php";
require R.'hzb/inc/load.php';
//base end

if(isset($_POST["numPerPage"])){
    $numPerPage=$_POST["numPerPage"];
    $pageNum=$_POST["pageNum"];
}
?>


<form id="pagerForm" method="post" action="ajax/dh/jd.php">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
</form>




<div class="pageContent">

	<table class="table" layoutH="45" targetType="dialog" width="100%">
		<thead>
			<tr>
				<th align="center">姓名</th>
				<th align="center">登录账号</th>
				<th align="center">职务</th>
				<th align="center">所属公司</th>
				<th align="center">所属部门</th>
				<th align="center">启用标志</th>
				<th align="center">查找带回</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			
			    $resultarray=$base->data("user");
			    $resultnum=count($resultarray);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnowarray=array_slice($resultarray,$sr,$numPerPage);
			for($a=0;$a<count($resultnowarray);$a++){
			    
			?>
			  <tr  >
			<td ><?php echo $resultnowarray[$a]['realName'];?>
            </td><td ><?php echo $resultnowarray[$a]['username'];?>
            </td><td ><?php echo $resultnowarray[$a]['duty'];?>
			</td><td  ><?php 
	
			echo $base->getdata("company", $resultnowarray[$a]['hotel'])["hotelname"];
			?>
</td><td  ><?php 
		
			echo $base->getdata("department", $resultnowarray[$a]['dept'])["deptname"];
			?>
</td><td ><?php echo $resultnowarray[$a]['isUser'];?>
			</td><td  >
			<a class="btnSelect" href="javascript:$.bringBack({id:'<?php echo $resultnowarray[$a]['id'];?>', jd:'<?php echo $resultnowarray[$a]['username'];?>'})" title="选择">选择</a></td>
<?php			
}
 
    ?>
			
					

		</tbody>
	</table>

<?php require R.'temp/table/dialog_footer.php';?>
</div>