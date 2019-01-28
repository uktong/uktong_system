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
date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));


?>
<script type="text/javascript" src="ajax/js/main.js"></script>
<form id="pagerForm" method="post" action="daiding/index.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="daiding/lydd.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				
			<td class="dateRange">
					按录单日期:
						<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
				<td >
					计调:
					<input type="hidden" name="jd.id" value="<?php
					echo  isset($_POST["jd_id"])?$_POST["jd_id"]:'';?>"/>
				<input type="text" class="getjd" name="jd.jd" value="<?php
					echo  isset($_POST["jd_jd"])?$_POST["jd_jd"]:'';?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jd.php" lookupGroup="jd">选择用户</a>
				</td>
				<td >
					团号:
					<input name="groupnum"  type="text" size="30" value="<?php
					echo  isset($_POST["groupnum"])?$_POST["groupnum"]:'';?>" />
				</td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<div class="subBar">
			<ul>
				<li><div class="button"><div class="buttonContent"><button type="reset">重置</button></div></div></li>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="daiding/lydingdan.php" target="navTab" rel="add"><span>添加</span></a></li>
<!-- 			<li class="line">line</li> -->
<!-- 			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li> -->
		</ul>
	</div>
	<table class="table" width="100%" layoutH="158" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">我社团号</th>
				<th align="center">发团日期</th>
				<th align="center">代定项目</th>
				<th align="center">计调	</th>
				<th align="center">录单时间</th>
				<th align="center">组团社</th>
				<th align="center" width="120">备注</th>
				<th align="center">最后修改时间</th>
				<th align="center">最后修改人</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 require_once $_SESSION["ROOT"].'/db/db.php';
			 date_default_timezone_set('prc');
			 if(@$_POST["search"]==null){
			     if(isset($_GET["msg"])){
			         $result=mysqli_query($con,"select * from t_groupmanage where jd='".$_SESSION["userid"]."' and groupName=''" );
			         $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			         //分页显示
			         $resultnum=count($resultarray);
			         @$page=ceil($resultnum/$numPerPage);
			         @$sr=($pageNum-1)*$numPerPage;
			         $resultnow=mysqli_query($con,"select * from t_groupmanage where jd='".$_SESSION["userid"]."' and groupName='' order by enteringDate DESC limit ".$sr.",".$numPerPage  );
			         $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			     }else{
			     $result=mysqli_query($con,"select * from t_groupmanage where hotelManage='代订旅游'" );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage where hotelManage='代订旅游' order by enteringDate DESC limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			     }
			 }else {
			     $sql="";
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         $sql.=" and enteringDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_POST["zts_id"]!=""?" and groupName='".$_POST["zts_id"]."'":"";
			     $sql.=$_POST["jd_id"]!=""?" and jd='".$_POST["jd_id"]."'":"";
			     $sql.=$_POST["groupnum"]!=""?" and teamNumber like '%".$_POST["groupnum"]."%'":"";
			     $result=mysqli_query($con,"select * from t_groupmanage where hotelManage='代订旅游' ".$sql );
			    // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage where hotelManage='代订旅游' ".$sql." order by enteringDate desc limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			
			for($a=0;$a<count($resultnowarray);$a++){
			    if($resultnowarray[$a]['orderstates']=="yes"){
			        
			        $orderstates="<span style='color:green;'>确认</span>";
			    }else{
			        $orderstates="<span style='color:red;'>未确认</span>";
			    }
			    $jdid=$resultnowarray[$a]['jd'];
			    $jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
			    $jd=mysqli_fetch_array($jdsql);
			    $ztsid=$resultnowarray[$a]['groupName'];
			    $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			    @$zts=mysqli_fetch_array($ztssql); 
			    
			    
			    $getnumsql=mysqli_query($con, "select teamNumber from  t_groupmanage where id=".$resultnowarray[$a]['id']);
			    $getnum=mysqli_fetch_array($getnumsql);
			    $number=$getnum["teamNumber"];
			    $yifusql=mysqli_query($con, "select fee from t_hoteldebt where groupnumber='".$number."'");
			    $yifu=mysqli_fetch_all($yifusql,MYSQLI_ASSOC);
			    $yifuje=0;
			    for($yf=0;$yf<count($yifu);$yf++){
			        $yifuje+=@$yifu[$yf]["fee"];
			    }
			    
			    $getyishousql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where groupNumber='".$number."'");
			    $yishoure=mysqli_fetch_array($getyishousql);
			    
			    if($yishoure["money"]!=0||$yifuje!=0){
			        echo "<tr style='color:rgb(144, 140, 140);' >
			<td >".($a+1)."
			</td><td >".$resultnowarray[$a]['teamNumber']."
            </td><td >".$resultnowarray[$a]['startDate']."
			</td><td  >代定旅游
			</td><td  >".$jd['username']."
			</td><td  >".$resultnowarray[$a]['enteringDate']."
			</td><td  >".$zts['travel_name']."
			</td><td >".$resultnowarray[$a]['groupNumber']."
</td><td >".$resultnowarray[$a]['updateDate']."
</td><td >".$resultnowarray[$a]['updatePeople']."
			</td><td  >
<a style='color:rgb(144, 140, 140);' href='db/lydaiding.php?action=delete&id=".$resultnowarray[$a]['id']."' title='确定要删除吗?' target='ajaxTodo'     >删除</a> 
<a href='daiding/editly.php?id=".$resultnowarray[$a]['id']."' class='edit' target='navtab' title='修改".$resultnowarray[$a]['id']."'  style='color:rgb(144, 140, 140);'>查看</a></td></tr>";
			}
			else{
			    echo "<tr  >
			<td >".($a+1)."
			</td><td >".$resultnowarray[$a]['teamNumber']."
            </td><td >".$resultnowarray[$a]['startDate']."
			</td><td  >代定旅游
			</td><td  >".$jd['username']."
			</td><td  >".$resultnowarray[$a]['enteringDate']."
			</td><td  >".$zts['travel_name']."
			</td><td >".$resultnowarray[$a]['groupNumber']."
</td><td >".$resultnowarray[$a]['updateDate']."
</td><td >".$resultnowarray[$a]['updatePeople']."
			</td><td  >
<a style='color:blue;' href='db/lydaiding.php?action=delete&id=".$resultnowarray[$a]['id']."' title='确定要删除吗?' target='ajaxTodo'     >删除</a>
<a href='daiding/editly.php?id=".$resultnowarray[$a]['id']."' class='edit' target='navtab' title='修改".$resultnowarray[$a]['id']."'  style='color:blue;'>查看</a></td></tr>";
			    
			}
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