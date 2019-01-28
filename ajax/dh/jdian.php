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

<form id="pagerForm" method="post" action="ajax/dh/jdian.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>


<div class="pageHeader">

	<form onsubmit="return dwzSearch(this, 'dialog');" action="zyzx/jdda.php" method="post" >
	<div class="searchBar">
      <span>公司名称</span>
        <input id="txtCmpName" name="txtCmpName" type="text" ligerui="{width:100}"/>
            <span>手机</span>
            <input name="txtCmpManagerMobile" type="text" ligerui="{width:80}"  /><br/>
            <span>电话</span>
            <input name="txtCmpTel" type="text" ligerui="{width:80}"  />
            <span>传真</span>
            <input name="txtCmpFax" type="text" ligerui="{width:80}"  />
            <span>负责人</span>
            <input name="txtCmpManager" type="text" ligerui="{width:80}"  />
      <span> 状态</span>
      <select id="dropUseChk" name="UseChk">
      <option value="on" >启用</option>
      <option value="off">停用</option>
      <option value="">全部</option>
      </select>
      <input name="search"  type="hidden" size="30" value="yes"/>
<button type="search">检索</button>
	</div>
	</form>
</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="zyzx/addjdda.php" target="dialog" mask="true" width="700" height="600"><span>添加</span></a></li>
		</ul>
	</div><script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
					<tr>
				<th align="center">序号</th>
				<th align="center">酒店名</th>
				<th align="center">负责人</th>
				<th align="center">手机</th>
				<th align="center">电话</th>
				<th align="center">传真</th>
	
				<th align="center">所在城市</th>

				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 
			require_once $_SESSION["ROOT"].'/db/db.php';
			if(@$_POST["search"]==null){
			    $result=mysqli_query($con,"select * from t_allhotel" );
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_allhotel  limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}else {
			    $sql="";
			    
			    $sql.=$_POST["txtCmpName"]!=""?" and hotelname like '%".$_POST["txtCmpName"]."%'":"";
			    $sql.=$_POST["txtCmpManagerMobile"]!=""?" and hotelphone like '%".$_POST["txtCmpManagerMobile"]."%'":"";
			    $sql.=$_POST["txtCmpTel"]!=""?" and hoteltel like '%".$_POST["txtCmpTel"]."%'":"";
			    $sql.=$_POST["txtCmpFax"]!=""?" and hotelfax like '%".$_POST["txtCmpFax"]."%'":"";
			    $sql.=$_POST["txtCmpManager"]!=""?" and hotelleader like '%".$_POST["txtCmpManager"]."%'":"";
			    $sql.=$_POST["UseChk"]!=""?" and hotelisUse='".$_POST["UseChk"]."'":"";
			    $result=mysqli_query($con,"select * from t_allhotel where 1=1 ".$sql );
			    // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			    //echo $sql;
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_allhotel where 1=1 ".$sql." limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}
			for($a=0;$a<count($resultnowarray);$a++){
			    echo "<tr >
			<td >".($a+1)."
			</td>
<td >".$resultnowarray[$a]['hotelname']."
			</td><td >".$resultnowarray[$a]['hotelleader']."
			</td><td >".$resultnowarray[$a]['hotelphone']."
			</td><td  >".$resultnowarray[$a]['hoteltel']."
			</td><td >".$resultnowarray[$a]['hotelfax']."

			</td><td >".$resultnowarray[$a]['hotelcityid']."
			</td><td >";
			    $i=$_GET["id"];
			    ?>
			   
			<a class="btnSelect" href="javascript:$.bringBack({id:'<?php echo $resultnowarray[$a]['id'];?>', jdian<?php echo $i;?>:'<?php echo $resultnowarray[$a]['hotelname'];?>'})" title="查找带回">选择</a></td>
	<?php }
 
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