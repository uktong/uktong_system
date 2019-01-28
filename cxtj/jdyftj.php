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
<form id="pagerForm" method="post" action="cxtj/jdyftj.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>
<script type="text/javascript" >
function test(){
	window.open("other/print.php?"+$("#ystktjform").serialize());
}
function print(id){
	window.open("other/printo.php?printtype=jdyfcx&id="+id+"&"+$("#jdyftjform").serialize());
}
</script>
<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="cxtj/jdyftj.php" id="jdyftjform" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				
				<td class="dateRange">
					入住日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
			
				<td >
					单位:
				<input type="hidden" name="jdian222.id" value="<?php echo @$_POST["jdian222_id"];?>"/>
				<input type="text" class="getjdian222" oninput="getjdian(222);" name="jdian222.jdian222" value="<?php echo @$_POST["jdian222_jdian222"];?>"
				 suggestFields="jdian222"   lookupGroup="jdian222" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jdian.php?id=222" lookupGroup="jdian222">选择酒店</a>
				</td>
				<td><button type="submit">搜索</button></td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
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
				<th >酒店</th>
<th align="center">数量</th>
				<th align="center">本期应付</th>
				<th align="center" >本期已付</th>
				<th align="center">本期欠付</th>
				<th align="center">总欠付</th>

			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"select distinct hotelName from t_reserveplan where type is null and startDate between '".$firstday."' and '".$lastday."'" );
			     //echo "select * from t_groupmanage where updateDate between '".$firstday."' and '".$firstday."'";
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select distinct hotelName from t_reserveplan  where type is null and startDate between '".$firstday."' and '".$lastday."' order by id DESC limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }else {
			     $sql="";
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
			     }
			     //$sql.=$_POST["zts_id"]!=""?" and groupName='".$_POST["zts_id"]."'":"";
			     $sql.=$_POST["jdian222_id"]!=""?" and hotelName='".$_POST["jdian222_id"]."'":"";
			    // $sql.=$_POST["wl_id"]!=""?" and wl='".$_POST["wl_id"]."'":"";
			     //$sql.=$_POST["groupnum"]!=""?" and teamNumber like '%".$_POST["groupnum"]."%'":"";
			     $result=mysqli_query($con,"select distinct hotelName from t_reserveplan where type is null  ".$sql );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select distinct hotelName from t_reserveplan where type is null  ".$sql." order by id DESC limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			 
			     
			     $shuliang=0;
			     $xjyf=0;
			     $xjyfu=0;
			     $xjqf=0;
			     $xjzqf=0;
			for($a=0;$a<count($resultnowarray);$a++){
			    ?>
			    <tr  >
			<td  >
			<?php echo $a+1;?>
			</td>
			<td   style="text-align: left;"><?php 
			
			$jddianid=$resultnowarray[$a]['hotelName'];
			$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			$jddian=mysqli_fetch_array($jddiansql);
			
			?>
			<a href="javascript:print(<?php echo $jddianid;?>);"  style="color:blue;"><?php echo $jddian["hotelname"];?></a>
			</td>
<td  ><?php 
			
if(@$_POST["search"]==null){
    $jdshuliangsql=mysqli_query($con, "select sum(number) as shuliang from t_reserveplan where  startDate between '".$firstday."' and '".$lastday."' and hotelName=".$jddianid);
    $jdshuliang=mysqli_fetch_array($jdshuliangsql);
}else {
    $sql="";
    if($_POST["startDate"]!=""){
        $startdate=$_POST["startDate"];
        $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
        $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
    }

    $jdshuliangsql=mysqli_query($con, "select sum(number) as shuliang from t_reserveplan where hotelName=".$jddianid.$sql);
    $jdshuliang=mysqli_fetch_array($jdshuliangsql);
}
			
			echo $jdshuliang["shuliang"];
			?>
			</td>
			<td  ><?php 
			
			if(@$_POST["search"]==null){
			    $yingfusql=mysqli_query($con, "select sum(hotelCommissionSum) as yingfu from t_reserveplan where startDate between '".$firstday."' and '".$lastday."' and hotelName=".$jddianid);
			    $yingfu=mysqli_fetch_array($yingfusql);
			}else {
			    $sql="";
			    if($_POST["startDate"]!=""){
			        $startdate=$_POST["startDate"];
			        $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			        $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
			    }
			    
			    $yingfusql=mysqli_query($con, "select sum(hotelCommissionSum) as yingfu from t_reserveplan where  hotelName=".$jddianid.$sql);
			    $yingfu=mysqli_fetch_array($yingfusql);
			}
			
			
			
			echo $yingfu["yingfu"];
			?>
			</td>
			<td  >
			<?php 
			if(@$_POST["search"]==null){
			 
			    $yifusql=mysqli_query($con, "select sum(fee) as yifu from t_hoteldebt where createTime between '".$firstday."' and '".$lastday."' and name=".$jddianid);
			    @$yifu=mysqli_fetch_array($yifusql);
			}else {
			    $sql="";
			    if($_POST["startDate"]!=""){
			        $startdate=$_POST["startDate"];
			        $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			        $sql.=" and createTime between '".$startdate."' and '".$enddate."'";
			    }
			    
			    $yifusql=mysqli_query($con, "select sum(fee) as yifu from t_hoteldebt where name=".$jddianid.$sql);
			    @$yifu=mysqli_fetch_array($yifusql);
			}
			
			
			echo $yifu["yifu"];
			?>
			</td>
			<td  >
			<?php 
			
			echo $yingfu["yingfu"]-$yifu["yifu"];
			?>
			</td>
		<td  >
		<?php 
		echo $yingfu["yingfu"]-$yifu["yifu"];
			?>
			</td>
			</tr>
		<?php
		$shuliang+=$jdshuliang["shuliang"];
		$xjyf+=$yingfu["yingfu"];
		$xjyfu+=$yifu["yifu"];
		$xjqf+=$yingfu["yingfu"]-$yifu["yifu"];
		$xjzqf+=$yingfu["yingfu"]-$yifu["yifu"];
			}
 
    ?>
	    <tr class="tfoot">
				<th align="center">小计：</th>
				<th align="center"></th>
				<th align="center"><?php echo $shuliang;?></th>
				<th align="center"><?php echo $xjyf;?></th>
				<th align="center"><?php echo $xjyfu;?></th>
				<th align="center"><?php echo $xjqf;?></th>
				<th align="center"><?php echo $xjzqf;?></th>


			</tr>
			<tr class="tfoot">
				<th align="center">总计：</th>
				<th align="center"></th>
				<th align="center"><?php echo $shuliang;?></th>
				<th align="center"><?php echo $xjyf;?></th>
				<th align="center"><?php echo $xjyfu;?></th>
				<th align="center"><?php echo $xjqf;?></th>
				<th align="center"><?php echo $xjzqf;?></th>


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