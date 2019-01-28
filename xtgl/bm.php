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
$hotel=$_GET["hotel"];

?>

<form id="pagerForm" method="post" action="xtgl/user.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>



<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="xtgl/addbm.php?hotel=<?php echo $hotel;?>" target="dialog" mask="true" width="660" height="152"><span>添加</span></a></li>
			
		</ul>
	</div><script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">部门名称</th>
				<th align="center">部门编码</th>
				<th align="center">所属公司</th>
				<th align="center">启用标志</th>
		
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 
			require_once $_SESSION["ROOT"].'/db/db.php';
			$result=mysqli_query($con,"select * from t_dept where hotel='".$hotel."'" );
			$resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			//分页显示
			$resultnum=count($resultarray);
			@$page=ceil($resultnum/$numPerPage);
			@$sr=($pageNum-1)*$numPerPage;

			$resultnow=mysqli_query($con,"select * from t_dept where hotel='".$hotel ."'  limit ".$sr.",".$numPerPage );
			$resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			for($a=0;$a<count($resultnowarray);$a++){
			    
			?>
			  <tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php echo $resultnowarray[$a]['deptname'];?>
            </td><td ><?php echo $resultnowarray[$a]['deptcode'];?>
			</td><td  ><?php 
			$resulthotel=mysqli_query($con,"select hotelname from t_hotel where hotelcode='".$resultnowarray[$a]['hotel']."'" );
			$resulhoteltarray=mysqli_fetch_all($resulthotel,MYSQLI_ASSOC);
			for($b=0;$b<count($resulhoteltarray);$b++){
			    echo $resulhoteltarray[$b]['hotelname'];
			}
			?>

</td><td ><?php echo $resultnowarray[$a]['state'];?>
			</td></tr>
<?php			
}
 
    ?>
		</tbody>
	</table>
	
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
		
				<option value="20" <?php if($numPerPage==20){echo "selected='selected'";}?>>20</option>
				<option value="50"<?php if($numPerPage==50){echo "selected='selected'";}?>>50</option>
				<option value="100"<?php if($numPerPage==100){echo "selected='selected'";}?>>100</option>
				<option value="150"<?php if($numPerPage==150){echo "selected='selected'";}?>>150</option>
				<option value="200"<?php if($numPerPage==200){echo "selected='selected'";}?>>200</option>
				<option value="250"<?php if($numPerPage==250){echo "selected='selected'";}?>>250</option>
			</select>
			<span>条，共<?php echo count($resultarray); ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo count($resultarray); ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
</div>