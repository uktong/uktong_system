<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
if(@$_POST["numPerPage"]!=null){
    $numPerPage=$_POST["numPerPage"];
    //      $keywords=$_POST["keywords"];
    $pageNum=$_POST["pageNum"];
    //     $status=$_POST["status"];
    //     $orderField=$_POST["orderField"];
    
}else{
    $numPerPage=20;
    $pageNum=1;
}

?>

<form id="pagerForm" method="post" action="ajax/dh/jd.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>




<div class="pageContent">

	<table class="table" layoutH="45" targetType="dialog" width="100%">
		<thead>
			<tr>
				<th orderfield="orgName">姓名</th>
				<th orderfield="orgNum">登录账号</th>
				<th orderfield="leader">职务</th>
				<th orderfield="creator">所属公司</th>
				<th orderfield="creator">所属部门</th>
				<th orderfield="creator">启用标志</th>
				<th width="80">查找带回</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			require_once $_SESSION["ROOT"].'/db/db.php';
			$result=mysqli_query($con,"select * from t_user " );
			$resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			//分页显示
			$resultnum=count($resultarray);
			@$page=ceil($resultnum/$numPerPage);
			@$sr=($pageNum-1)*$numPerPage;
			$resultnow=mysqli_query($con,"select * from t_user   limit ".$sr.",".$numPerPage);
			$resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			for($a=0;$a<count($resultnowarray);$a++){
			    
			?>
			  <tr  >
			<td ><?php echo $resultnowarray[$a]['realName'];?>
            </td><td ><?php echo $resultnowarray[$a]['username'];?>
            </td><td ><?php echo $resultnowarray[$a]['duty'];?>
			</td><td  ><?php 
			$resulthotel=mysqli_query($con,"select hotelname from t_hotel where id=".$resultnowarray[$a]['hotel'] );
			$resulhoteltarray=mysqli_fetch_all($resulthotel,MYSQLI_ASSOC);
			for($b=0;$b<count($resulhoteltarray);$b++){
			    echo $resulhoteltarray[$b]['hotelname'];
			}
			?>
</td><td  ><?php 
			$resultdept=mysqli_query($con,"select deptname from t_dept where id=".$resultnowarray[$a]['dept'] );
			$resuldepttarray=mysqli_fetch_all($resultdept,MYSQLI_ASSOC);
			for($c=0;$c<count($resulhoteltarray);$c++){
			    echo $resuldepttarray[$c]['deptname'];
			}
			?>
</td><td ><?php echo $resultnowarray[$a]['isUser'];?>
			</td><td  >
			<a class="btnSelect" href="javascript:$.bringBack({id:'<?php echo $resultnowarray[$a]['id'];?>', wl:'<?php echo $resultnowarray[$a]['username'];?>'})" title="查找带回">选择</a></td>
<?php			
}
 
    ?>
			
					

		</tbody>
	</table>

	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="dialogPageBreak({numPerPage:this.value})">
		
				<option value="20" <?php if($numPerPage==20){echo "selected='selected'";}?>>20</option>
				<option value="50"<?php if($numPerPage==50){echo "selected='selected'";}?>>50</option>
				<option value="100"<?php if($numPerPage==100){echo "selected='selected'";}?>>100</option>
				<option value="150"<?php if($numPerPage==150){echo "selected='selected'";}?>>150</option>
				<option value="200"<?php if($numPerPage==200){echo "selected='selected'";}?>>200</option>
				<option value="250"<?php if($numPerPage==250){echo "selected='selected'";}?>>250</option>
			</select>
			<span>条，共<?php echo count($resultarray); ?>条</span>
		</div>

		<div class="pagination" targetType="dialog" totalCount="<?php echo count($resultarray); ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
</div>