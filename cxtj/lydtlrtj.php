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


require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
?>
<script type="text/javascript" src="ajax/js/main.js"></script>
<script type="text/javascript" >
function test(){
	window.open("other/print.php?"+$("#dtlrtjbox").serialize());
}

</script>
<form id="pagerForm" method="post" action="cxtj/dtlrtj.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" id="dtlrtjbox" action="cxtj/lydtlrtj.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				
				<td class="dateRange">
					按出团日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
				
				<td >
					
					计  调 :
					<input type="hidden" name="jd.id" value="<?php echo @$_POST["jd_id"];?>"/>
				<input type="text"  class=" getjd" name="jd.jd" value="<?php echo @$_POST["jd_jd"];?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jd.php" lookupGroup="jd">选择用户</a>
				</td>
				<td >
					组团社:
				<input type="hidden" name="zts.id" value="<?php echo @$_POST["zts_id"];?>"/>
				<input type="text" class="getzts" name="zts.zts" value="<?php echo @$_POST["zts_zts"];?>" suggestFields="zts"   lookupGroup="zts" />
				<a class="btnLook" style="float: right;" href="ajax/dh/zts.php" lookupGroup="zts">选择组团社</a>
				</td>
				
				
				
				<td >
					团号:
					<input name="groupnum"  type="text" size="30" value="<?php echo @$_POST["groupnum"];?>" />
				</td>
					<td><button type="submit">搜索</button></td><td><button type="button" onclick="test()">打印</button></td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<input name="searchtype"  type="hidden" size="30" value="dtlrtj"/>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
	</div>
	<table class="table" width="100%" layoutH="158" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">发团</th>
				<th align="center">散团</th>
				<th align="center">预定日期</th>
				<th align="center">代定项目</th>
				<th align="center">计调	</th>
				
				<th align="center">组团社</th>
				<th align="center" width="120">备注</th>

				<th align="center">总收入</th>
				<th align="center">总成本</th>
				<th align="center">毛利</th>
				<th align="center">毛利率</th>
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 

			 $shouru=0;
			 $chengben=0;
			 $maoli=0;
			 $shouruz=0;
			 $chengbenz=0;
			 $maoliz=0;
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"select * from t_groupmanage where hotelManage='代订旅游' and startDate between '".$firstday."' and '".$lastday."'" );
			     //echo "select * from t_groupmanage where updateDate between '".$firstday."' and '".$firstday."'";
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			         $allmoneysqlz=mysqli_query($con, "select * from t_reserveplan where  groupNumber='".$resultarray[$z]["teamNumber"]."'");
			         $allmoneyz=mysqli_fetch_all($allmoneysqlz,MYSQLI_ASSOC);
			         $zsr=0;
			         $zcb=0;
			         for($am=0;$am<count($allmoneyz);$am++){
			             $zsr+=$allmoneyz[$am]["sumPrice"];
			             $zcb+=$allmoneyz[$am]["hotelCommissionSum"];
			         }
			         $shouruz+=$zsr;
			         $chengbenz+=$zcb;
			         $maoliz=$shouruz-$chengbenz;
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage  where hotelManage='代订旅游' and  startDate between '".$firstday."' and '".$lastday."' order by id DESC limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }else {
			     $sql="";
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_POST["zts_id"]!=""?" and groupName='".$_POST["zts_id"]."'":"";
			     //$sql.=$_POST["jdian222_id"]!=""?" and hotelName='".$_POST["jdian222_id"]."'":"";
			     $sql.=$_POST["jd_id"]!=""?" and jd='".$_POST["jd_id"]."'":"";
			     $sql.=$_POST["groupnum"]!=""?" and teamNumber like '%".$_POST["groupnum"]."%'":"";
			     $result=mysqli_query($con,"select * from t_groupmanage  where hotelManage='代订旅游'  ".$sql );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     
			     for($z=0;$z<count($resultarray);$z++){
			         $allmoneysqlz=mysqli_query($con, "select * from t_reserveplan where groupNumber='".$resultarray[$z]["teamNumber"]."'");
			         $allmoneyz=mysqli_fetch_all($allmoneysqlz,MYSQLI_ASSOC);
			         $zsr=0;
			         $zcb=0;
			         for($am=0;$am<count($allmoneyz);$am++){
			             $zsr+=$allmoneyz[$am]["sumPrice"];
			             $zcb+=$allmoneyz[$am]["hotelCommissionSum"];
			         }
			         $shouruz+=$zsr;
			         $chengbenz+=$zcb;
			         $maoliz=$shouruz-$chengbenz;
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage  where hotelManage='代订旅游' ".$sql." order by id DESC limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			 
			 
			
			for($a=0;$a<count($resultnowarray);$a++){
			   
			    $jdid=$resultnowarray[$a]['jd'];
			    $jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
			    $jd=mysqli_fetch_array($jdsql);
			    $ztsid=$resultnowarray[$a]['groupName'];
			    $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			    @$zts=mysqli_fetch_array($ztssql); 
			    ?>
<tr  >
			<td ><?php echo $a+1;?>
			</td>
			<td ><?php echo $resultnowarray[$a]["teamNumber"];?>
			</td>
			<td ><?php echo $resultnowarray[$a]["startDate"];?>
			</td>
			<td ><?php echo $resultnowarray[$a]["endDate"];?>
			</td>
			<td ><?php echo $resultnowarray[$a]["reserveDate"];?>
			</td>
			<td >	
代订酒店
			</td>
			<td ><?php echo $jd["username"];?>
			</td>
			<td ><?php echo $zts["travel_name"];?>
			</td>
			<td ><?php echo $resultnowarray[$a]["remark"];?>
			</td>
			<td ><?php 
			$allmoneysql=mysqli_query($con, "select * from t_reserveplan where groupNumber='".$resultnowarray[$a]["teamNumber"]."'");
			$allmoney=mysqli_fetch_all($allmoneysql,MYSQLI_ASSOC);
			$sr=0;
			$cb=0;
			for($am=0;$am<count($allmoney);$am++){
			    $sr+=$allmoney[$am]["sumPrice"];
			    $cb+=$allmoney[$am]["hotelCommissionSum"];
			}
			echo $sr;
			?>
			</td>
			<td ><?php echo $cb;?>
			</td>
			<td ><?php echo $sr-$cb;?>
			</td>
			<td ><?php 
			echo $sr!=0?sprintf("%.2f", floatval(($sr-$cb)/$sr)*100):"0";
		?>%
			</td>
		
			</tr>
		
		<?php 	
			$shouru+=$sr;
			$chengben+=$cb;
			$maoli+=$sr-$cb;;
			
			}
 
    ?>
     <tr class="tfoot">
				<th align="center">小计：</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $shouru;?></th>
				<th align="center"><?php echo $chengben;?></th>
				<th align="center"><?php echo $maoli;?></th>
				<th align="center"></th>


			</tr>
			<tr class="tfoot">
				<th align="center">总计：</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $shouruz;?></th>
				<th align="center"><?php echo $chengbenz;?></th>
				<th align="center"><?php echo $maoliz;?></th>
				<th align="center"></th>


			</tr>
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