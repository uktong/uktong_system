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
    $numPerPage=20;
    $pageNum=1;
}
// $sql=mysqli_query($con, "select * from t_moneychange where accountid=".$_GET["id"]);
// $moneychange=mysqli_fetch_all($sql,MYSQLI_ASSOC);

date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));

?>
<script type="text/javascript" src="ajax/js/main.js"></script>

<form id="pagerForm" method="post" action="zyzx/showzhgl.php?id=<?php echo $_GET["id"];?>">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>



<div class="pageContent">
<div class="searchBar">
	<form onsubmit="return dwzSearch(this, 'dialog');" action="zyzx/showzhgl.php?id=<?php echo $_GET["id"];?>" method="post" >
		<table class="searchContent">
			<tr>
				
				
				
				<td class="dateRange">
					日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
				<td >
					
				 <select class="combox" name="guid" style="float:right;" ref="guid"  >
		<option value="">财务方向</option>
		<option value="in">进账</option>
		<option value="out">出账</option>
	</select>
				</td>
				
				
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<div class="subBar">
			<ul>
				<li><div class="button"><div class="buttonContent"><button type="reset">重置</button></div></div></li>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
			</ul>
		</div></form>
	</div><script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="100" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">科目</th>
				<th align="center">支出</th>
				<th align="center">收入</th>
				<th align="center">操作时间</th>
				<th align="center">操作人</th>
				<th align="center">账务类型</th>
				<th align="center">备注</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 
			
			if(@$_POST["search"]==null){
			    $result=mysqli_query($con,"select * from t_moneychange where dotime between '".$firstday."' and '".$lastday."' and accountid='".$_GET["id"]."'"  );
			    //echo "select * from t_groupmanage where updateDate between '".$firstday."' and '".$firstday."'";
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_moneychange where dotime between '".$firstday."' and '".$lastday."' and accountid='".$_GET["id"]."' order by id DESC limit ".$sr.",".$numPerPage  );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}else {
			    $sql="";
			    if($_POST["startDate"]!=""){
			        $startdate=$_POST["startDate"];
			        $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			        $sql.=" and dotime between '".$startdate."' and '".$enddate."'";
			    }
			    $sql.=$_POST["guid"]!=""?" and changetype='".$_POST["guid"]."'":"";
			    $result=mysqli_query($con,"select * from t_moneychange where accountid='".$_GET["id"]."' ".$sql );
// 			    echo "select * from t_moneychange where accountid='".$_GET["id"]."' ".$sql;
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_moneychange where accountid='".$_GET["id"]."' ".$sql." limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}
			for($a=0;$a<count($resultnowarray);$a++){
			    
			    ?>
			  <tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php echo $resultnowarray[$a]['km'];?>
            </td><td ><?php echo $resultnowarray[$a]['mout'];?>
            </td><td ><?php echo $resultnowarray[$a]['min'];?>
            </td><td ><?php echo $resultnowarray[$a]['dotime'];?>
            </td><td ><?php echo $resultnowarray[$a]['douser'];?>
			</td><td  ><?php echo $resultnowarray[$a]['changetype'];?>
			</td><td  ><?php echo $resultnowarray[$a]['remark'];?>
</td></tr><?php			
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