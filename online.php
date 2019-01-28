<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
if(@$_POST["numPerPage"]!=null){
    $numPerPage=$_POST["numPerPage"];
    //      $keywords=$_POST["keywords"];
    $pageNum=$_POST["pageNum"];
    //     $status=$_POST["status"];
    //     $orderField=$_POST["orderField"];
    
}else{
    $numPerPage=50;
    $pageNum=1;
}
date_default_timezone_set('prc');
$checktime=date('Y-m-d H:i:s',strtotime("-5 minute"));
$countsql=mysqli_query($con, "select * from online where lasttime>'".$checktime."'");
$usernum= mysqli_fetch_all($countsql,MYSQLI_ASSOC);
?>
<form id="pagerForm" method="post" action="online.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>
<div class="pageContent">

	<table class="table" width="100%" layoutH="158" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">用户名</th>
				<th align="center">真实名</th>
				<th align="center">状态</th>

			</tr>
		</thead>
		<tbody>
		
		<?php 
		for($a=0;$a<count($usernum);$a++){
		?><tr>
				<td align="center"><?php echo $a+1;?></td>
				<td align="center"><?php
				if($usernum[$a]["usertype"]=="lxs"){
				    $isusersql=mysqli_query($con, "select realName,username from t_user where id=".$usernum[$a]['userid']);
				}else if($usernum[$a]["usertype"]=="travel"){
				    $isusersql=mysqli_query($con, "select realname,username,travel from t_traveluser where id=".$usernum[$a]['userid']);
				}else{
				    $isusersql=mysqli_query($con, "select realname,username,hotel from t_hoteluser where id=".$usernum[$a]['userid']);
				}
				
				$isuser=mysqli_fetch_array($isusersql);
				echo $isuser["username"];
				
				
				?></td>
				<td align="center"><?php echo @$isuser["realname"]?$isuser["realname"]:$isuser["realName"];?></td>
				<td align="center">在线</td>
				</tr>	
<?php }?>
		
		
		</tbody></table>
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
			<span>条，共<?php echo count($usernum); ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo count($usernum); ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
		
		
		</div>