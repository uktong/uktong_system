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
	window.open("other/print.php?"+$("#ystktjform").serialize());
}
function print(id){
	window.open("other/printo.php?printtype=ystkcx&id="+id+"&"+$("#ystktjform").serialize());
}
</script>
<form id="pagerForm" method="post" action="cxtj/ystktj.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" id="ystktjform" action="cxtj/yslytktj.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				
				<td class="dateRange">
					出团日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
				<td >
					计调:
					<input type="hidden" name="jd.id" value="<?php echo @$_POST["jd_id"];?>"/>
				<input type="text" class="getjd" name="jd.jd" value="<?php echo @$_POST["jd_jd"];?>" suggestFields="jd"  lookupGroup="jd" />
				</td>
			<td >
					外联:
					<input type="hidden" name="wl.id" value="<?php echo @$_POST["wl_id"];?>"/>
				<input type="text" class="getwl" name="wl.wl" value="<?php echo @$_POST["wl_wl"];?>" suggestFields="wl"  lookupGroup="wl" />
				</td>
				</tr><tr>
				
				<td >
					团号:
					<input name="groupnum"  type="text" size="30" value="<?php echo @$_POST["groupnum"];?>" />
				</td>
				<td >
					组团社:
				<input type="hidden" name="zts.id" value="<?php echo @$_POST["zts_id"];?>"/>
				<input type="text" class="getzts" name="zts.zts" value="<?php echo @$_POST["zts_zts"];?>" suggestFields="zts"   lookupGroup="zts" />
				<a class="btnLook" style="float: right;" href="ajax/dh/zts.php" lookupGroup="zts">选择组团社</a>
				</td>
				<td><button type="submit">搜索</button> <button type="button" onclick="test()">打印</button></td><td></td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<input name="searchtype"  type="hidden" size="30" value="ystktj"/>
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
				<th align="center">组团社</th>
				<th align="center">本期应收</th>
				<th align="center" >本期已收</th>
				<th align="center">本期欠收</th>
				<th align="center">总欠收</th>

			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 $xjys=0;
			 $xjysshou=0;
			 $xjqs=0;
			 $xjzqs=0;
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"select distinct groupName from t_groupmanage where hotelManage='代订旅游' and groupName is not null and groupName!='' and  startDate between '".$firstday."' and '".$lastday."'" );
			     //echo "select * from t_groupmanage where updateDate between '".$firstday."' and '".$firstday."'";
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select distinct groupName from t_groupmanage  where hotelManage='代订旅游' and groupName is not null and groupName!='' and  startDate between '".$firstday."' and '".$lastday."' order by id DESC limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }else {
			     $sql="";
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_POST["zts_id"]!=""?" and groupName='".$_POST["zts_id"]."'":"";
			     $sql.=$_POST["jd_id"]!=""?" and jd='".$_POST["jd_id"]."'":"";
			     $sql.=$_POST["wl_id"]!=""?" and wl='".$_POST["wl_id"]."'":"";
			     $sql.=$_POST["groupnum"]!=""?" and teamNumber like '%".$_POST["groupnum"]."%'":"";
			     $result=mysqli_query($con,"select distinct groupName from t_groupmanage where hotelManage='代订旅游' and groupName is not null and groupName!=''  ".$sql );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select distinct groupName from t_groupmanage where hotelManage='代订旅游' and groupName is not null and groupName!='' ".$sql." order by id DESC limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			 
			 
			 
			    
			    
			for($a=0;$a<count($resultnowarray);$a++){
			    ?>
			    <tr  >
			<td  >
			<?php echo $a+1;?>
			</td>
			<td  ><?php 
			$ztsid=$resultnowarray[$a]['groupName'];
			$ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			$zts=mysqli_fetch_array($ztssql); 
			
			?>
			<a href="javascript:print(<?php echo $ztsid;?>);"  style="color:blue;"><?php echo $zts['travel_name'];?></a>
			</td>

			<td  ><?php 
			$getgroupNumbersql=mysqli_query($con, "select teamNumber from t_groupmanage where groupName=".$ztsid);
			$getgroupNumber=mysqli_fetch_all($getgroupNumbersql,MYSQLI_ASSOC);
			$ys=0;
			
			
			if(@$_POST["search"]==null){
			    
			    for($gn=0;$gn<count($getgroupNumber);$gn++){
			        $yssql=mysqli_query($con, "select sum(sumPrice) as money from t_reserveplan where startDate between '".$firstday."' and '".$lastday."' and  groupNumber='".$getgroupNumber[$gn]["teamNumber"]."'");
			        $ysje=mysqli_fetch_array($yssql);
			        $ys+= $ysje["money"];
			    }
			}else {
			    $sql="";
			    if($_POST["startDate"]!=""){
			        $startdate=$_POST["startDate"];
			        $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			        $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
			    }
			    for($gn=0;$gn<count($getgroupNumber);$gn++){
			        $yssql=mysqli_query($con, "select sum(sumPrice) as money from t_reserveplan where 
 groupNumber='".$getgroupNumber[$gn]["teamNumber"]."' ".$sql);
			        $ysje=mysqli_fetch_array($yssql);
			        $ys+= $ysje["money"];
			    }
			    
			}
			echo $ys;
			?>
			</td>
			<td  >
			<?php 
			$yshou=0;
			if(@$_POST["search"]==null){
			    
			   
			    for($gn=0;$gn<count($getgroupNumber);$gn++){
			        $yssql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where dater between '".$firstday."' and '".$lastday."' and  groupNumber='".$getgroupNumber[$gn]["teamNumber"]."'");
			        $yshouje=mysqli_fetch_array($yssql);
			        $yshou+= $yshouje["money"];
			    }
			}else {
			    $sql="";
			    if($_POST["startDate"]!=""){
			        $startdate=$_POST["startDate"];
			        $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			        $sql.=" and dater between '".$startdate."' and '".$enddate."'";
			    }
			    
			    for($gn=0;$gn<count($getgroupNumber);$gn++){
			        $yssql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where   groupNumber='".$getgroupNumber[$gn]["teamNumber"]."'".$sql);
			        $yshouje=mysqli_fetch_array($yssql);
			        $yshou+= $yshouje["money"];
			    }
			 
			    
			}
			
			echo $yshou;
			?>
			</td>
			<td  >
			<?php 
			
			echo $ys-$yshou;
			?>
			</td>
		<td  >
		<?php 
			echo $ys-$yshou;
			?>
			</td>
			</tr>
		<?php
		$xjys+=$ys;
		$xjysshou+=$yshou;
		$xjqs+=($ys-$yshou);
		$xjzqs+=($ys-$yshou);
			}
 
    ?>
	    <tr class="tfoot">
				<th align="center">小计：</th>
				<th align="center"></th>
				<th align="center"><?php echo $xjys;?></th>
				<th align="center"><?php echo $xjysshou;?></th>
				<th align="center"><?php echo $xjqs;?></th>
				<th align="center"><?php echo $xjzqs;?></th>


			</tr>
			<tr class="tfoot">
				<th align="center">合计：</th>
				<th align="center"></th>
				<th align="center"><?php echo $xjys;?></th>
				<th align="center"><?php echo $xjysshou;?></th>
				<th align="center"><?php echo $xjqs;?></th>
				<th align="center"><?php echo $xjzqs;?></th>


			</tr>
	    </tbody>
	</table>
	<style>
	.tfoot{
		height:30px;
		line-height:30px;
		background-color:#eef3ff;
		
	}
	.tfoot:hover{
		background-color:#eef3ff;
	}</style>
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