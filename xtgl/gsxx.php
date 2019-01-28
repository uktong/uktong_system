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

<form id="pagerForm" method="post" action="xtgl/gsxx.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="xtgl/gsxx.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				
				<td class="dateRange">
					公司名称:
					<input  type="text" name="hotelname" oninput="alert($(this).val());" id="search" value="">
					
				</td><script>
		
</script>
				<td><div class="button"><div class="buttonContent"><button type="search">检索</button></div></div></td>
			</tr>
			
		</table>
		
			
		
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="xtgl/add.php" target="dialog" mask="true" width="700" height="600"><span>添加</span></a></li>
			
		</ul>
	</div><script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">公司编码</th>
				<th align="center">公司名</th>
				<th align="center">负责人</th>
				<th align="center">手机</th>
				<th align="center">电话</th>
				<th align="center">传真</th>
				<th align="center">所在城市</th>
				<th align="center">启用标志</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 
			require_once $_SESSION["ROOT"].'/db/db.php';
			$result=mysqli_query($con,"select * from t_hotel" );
			$resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			//分页显示
			$resultnum=count($resultarray);
			@$page=ceil($resultnum/$numPerPage);
			@$sr=($pageNum-1)*$numPerPage;
			@$er=$pageNum*$numPerPage;
			$resultnow=mysqli_query($con,"select * from t_hotel limit ".$sr.",".$er );
			$resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			for($a=0;$a<count($resultnowarray);$a++){
			    echo "<tr id='".$resultnowarray[$a]['id']."' >
			<td id='".$resultnowarray[$a]['id']."'  '>".($a+1)."
			</td><td id='".$resultnowarray[$a]['id']."'>
			".$resultnowarray[$a]['hotelcode']."</td>
<td id='".$resultnowarray[$a]['id']."' >".$resultnowarray[$a]['hotelname']."
			</td><td id='".$resultnowarray[$a]['id']."' >".$resultnowarray[$a]['hotelleader']."
			</td><td id='".$resultnowarray[$a]['id']."' >".$resultnowarray[$a]['hotelphone']."
			</td><td id='".$resultnowarray[$a]['id']."' >".$resultnowarray[$a]['hoteltel']."
			</td><td id='".$resultnowarray[$a]['id']."' >".$resultnowarray[$a]['hotelfax']."
			</td><td id='".$resultnowarray[$a]['id']."' >".$resultnowarray[$a]['hotelcityid']."
			</td><td id='".$resultnowarray[$a]['id']."' >".$resultnowarray[$a]['hotelisUse']."
			</td><td id='".$resultnowarray[$a]['id']."' >
			<a href='xtgl/showxx.php?id=".$resultnowarray[$a]['id']."' class='show' id=''target='dialog' mask='true' width='700' height='600' style='color:blue;'>查看</a>

<a href='xtgl/editxx.php?id=".$resultnowarray[$a]['id']."' class='edit' id=''target='dialog' mask='true' width='700' height='600' style='color:blue;'>修改</a></td></tr>";
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