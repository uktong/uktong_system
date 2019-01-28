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
if($_GET["id"]==""){
    echo "<script>alert('请返回选择组团社');</script>";
    die();
}
?>

<form id="pagerForm" method="post" action="ajax/dh/lxr.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>



<div class="pageHeader">
	<form onsubmit="return dwzSearch(this, 'dialog');" action="ajax/dh/lxr.php" method="post" >
	<div class="searchBar">
<input name="search"  type="hidden" size="30" value="yes"/>
      <span> 姓名</span>
    <input name="name"  id="name" type="text" ltype="text" ligerui="{width:100}" value="" /><button type="search">检索</button>
	</div>
	
	</form>

</div>

<div class="pageContent">
	<script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="0" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">姓名</th>
				<th align="center">手机</th>
				<th align="center">电话</th>
				<th align="center">传真</th>
				<th align="center">QQ</th>
<!-- 				<th align="center">销售</th> -->
				<th align="center">职务</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 
			require_once $_SESSION["ROOT"].'/db/db.php';
			
			
			if(@$_POST["search"]==null){
			    $result=mysqli_query($con,"select * from t_linkman where travel_id=".$_GET["id"] );
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_linkman  where travel_id='".$_GET["id"]."' limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}else {
			    $sql="";
			    $sql.=$_POST["name"]!=""?" and name like '%".$_POST["name"]."%'":"";
			    
			    $result=mysqli_query($con,"select * from t_linkman where 1=1 ".$sql );
			    // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
// 			    			    echo $sql;
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_linkman where 1=1 ".$sql." limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}
			for($a=0;$a<count($resultnowarray);$a++){
			    
			?>
			  <tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php echo $resultnowarray[$a]['name'];?>
            </td><td ><?php echo $resultnowarray[$a]['phone'];?>
            </td><td ><?php echo $resultnowarray[$a]['tel'];?>
            </td><td ><?php echo $resultnowarray[$a]['fax'];?>
                        </td><td ><?php echo $resultnowarray[$a]['qq'];?>
            </td><td ><?php echo $resultnowarray[$a]['department'];?>
			</td><td  >
			<a class="btnSelect" href="javascript:$.bringBack({id:'<?php echo $resultnowarray[$a]['id'];?>', lxr:'<?php echo $resultnowarray[$a]['name'];?>'})" title="查找带回">选择</a></td>
			</tr>
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