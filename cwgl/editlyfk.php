<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$today= date("Y-m-d");
$todaydate=date("Y-m");
$firstday =date("Y-01-01");
$lastday =date("Y-m-d",strtotime("$firstday +1 month -1 day"));
$id=$_GET["id"];
$getmsgsql=mysqli_query($con, "select * from t_sktravel where id=".$id);
$getmsg=mysqli_fetch_array($getmsgsql);
?>
<script type="text/javascript" src="ajax/js/main.js">


</script>

<style>
<!--

-->
</style>

<script type="text/javascript">
<!--
function searcheditfk(){
	var hotelid=$("#jdianfk").val();
	var startDate=$("#startDate").val();
	var endDate=$("#endDate").val();
	var groupnum=$("#groupnumefk").val();
	var cusname=$("#cusnameefk").val();
	
	$("#searchefkbutton").attr("href","ajax/fkwxz.php?id=<?php echo $id;?>&search=yes&travelid="+hotelid+"&startDate="+startDate+"&endDate="+endDate+"&groupnum="+groupnum+"&cusname="+cusname);
}
function searcheditfky(){
	var hotelid=$("#jdianfk").val();
	var startDate=$("#startDatey").val();
	var endDate=$("#endDatey").val();
	var groupnum=$("#groupnumefky").val();
	var cusname=$("#cusnameefky").val();
	
	$("#searchefkbuttony").attr("href","ajax/fkyxz.php?id=<?php echo $id;?>&search=yes&travelid="+hotelid+"&startDate="+startDate+"&endDate="+endDate+"&groupnum="+groupnum+"&cusname="+cusname);
}
//-->
</script>
<form method="post" action="db/addlyfk.php?action=edit&id=<?php echo $id; ?>" onsubmit="return validateCallback(this, dialogAjaxDone)" class="pageForm required-validate" >
<div class="pageHeader">
<h2 class="contentTitle" style="text-align: center;">修改旅游付款</h2>
		
	<div class="searchBar">
	
		<table class="searchContent" id="fftable"  cellspacing="0">
			<tr>
				<td >
					交给社:
				
				<input type="hidden" id="jdianfk" name="zts.id" value="<?php echo @$getmsg["jgs"];?>"/>
				<input type="text" class="getjgs" name="zts.zts" value="<?php
				$jddianid=$getmsg["jgs"];
				$jddiansql=mysqli_query($con, "select travel_name from t_jgtravel where id=".$jddianid);
				$jddian=mysqli_fetch_array($jddiansql);
				echo $jddian["travel_name"];
				?>
				" style="width:100px; " suggestFields="zts"  lookupGroup="zts" />
				<a class="btnLook" href="ajax/dh/zts.php"style="float:right;margin-right:100px;"  lookupGroup="zts">选择用户</a>
				
				</td><td>	归档时间:<?php echo $getmsg["gddate"];?>月
				</td>
				<td >
					金额:
					<input type="hidden" name="havingmoney"  id="fkhavingmoney" value="<?php echo @$getmsg["mhaving"];?>">
				<input type="text" name="money" readonly id="allmoney" onchange="$('#fklastmoney').html($(this).val());$('#havingmoney').val($(this).val());"  style="width:100px;" value="<?php echo @$getmsg["money"];?>"/>余额：<span id="fklastmoney"><?php echo @$getmsg["mhaving"];?></span>
				</td>
<!-- 				<td > -->
<!-- 					酒店: -->

<!-- 				</td> -->
<!-- 				</tr>--><tr> 
				<td >
					方式:
					<select   name="paytype">
			<option value="">------</option>
			<?php $getpaytype=mysqli_query($con, "select * from t_baseconfig where basenote=5 ");
			$getpay=mysqli_fetch_all($getpaytype, MYSQLI_ASSOC);
			foreach ($getpay as $pay){
			?>
			<option <?php if($getmsg["paytype"]==$pay["id"]){echo "selected='selected'";}?> value="<?php echo $pay["id"];?>"><?php echo $pay["basetype"];?></option>
			<?php }?>
			</select>
				</td><td>日期：<input name="doDate" class="date readonly" readonly="readonly" type="text" value="<?php echo @$getmsg["dodate"];?>"></td>
				<td >
					发票金额:
					<input name="invoice"  type="text" size="30" style="width:150px;" value="<?php echo @$getmsg["invoice"];?>" />
				</td>
				</tr><tr>
				<td >
					账户:
					<select   name="account" id="account"  onchange="getyue()">
			<option value="">------</option>
			<?php $getpaytype=mysqli_query($con, "select * from t_account ");
			$getpay=mysqli_fetch_all($getpaytype, MYSQLI_ASSOC);
			foreach ($getpay as $pay){
			?>
			<option  <?php if($getmsg["account"]==$pay["id"]){echo "selected='selected'";}?> value="<?php echo $pay["id"];?>"><?php echo $pay["accountTitle"];?>-<?php echo $pay["bankName"];?>-<?php echo $pay["accountNumber"];?></option>
			
			<?php }?>
			</select>
				</td>
			
				<td><span id="yue" style="color:red;"></span></td><td>付款人:<input type="hidden" name="jd.id" value="<?php echo @$getmsg["dopeople"];?>"/>
				<input type="text" class=" getjd"  name="jd.jd" value="<?php echo @$getmsg["dopeoplename"];?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jd.php"  rel="ffyh" lookupGroup="jd">选择用户</a></td>
				
			<td >
					备注:
				<input type="text" name="remark" id="remark" style="width:150px;" value="<?php echo @$getmsg["remark"];?>"/>
				</td>
			</tr>
		</table>
		
	</div></div>
<?php

if(@$_POST["numPerPage"]!=null){
    $numPerPage=$_POST["numPerPage"];
    //      $keywords=$_POST["keywords"];
    $pageNum=$_POST["pageNum"];
    //     $status=$_POST["status"];
    //     $orderField=$_POST["orderField"];
    
}else{
    $numPerPage=100;
    $pageNum=1;
}



?>


<div class="tabs" currentIndex="0" eventType="click">
		<div class="tabsHeader">
			<div class="tabsHeaderContent">
				<ul>
					<li><a href="javascript:;"><span>未下帐数据</span></a></li>
					<li><a href="javascript:;"><span>已下帐数据</span></a></li>
				</ul>
			</div>
		</div>

		<div class="tabsContent" style="height:350px;">
			<div id="fkwxz">

	<table class="searchContent">
			<tr>
			<td class="dateRange">
					日期：
					<input name="startDate" id="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" id="endDate" class="date readonly" readonly="readonly" type="text" value="<?php echo isset($_POST["endDate"])?$_POST["endDate"]:$today;?>">
				</td>
				<td>团号：<input id="groupnumefk"  type="text" size="30" value="" /></td>
				<td>客人姓名：<input id="cusnameefk"  type="text" size="30" value="" /></td>
				<td><a class="button" id="searchefkbutton" target="ajax" rel="fkwxz" onclick="searcheditfk()"><span>搜索</span></a></td>
				</tr>
				
				</table>
	

	<table class="table" width="100%" layoutH="255" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">日期</th>
				<th align="center">交给社</th>
				<th align="center">计调</th>
				<th align="center">客人姓名</th>
				<th align="center">应付</th>
				<th align="center">已付</th>
<!-- 				<th align="center">销售</th> -->
				<th align="center">欠付</th>
				<th align="center">审核状态</th>
				<th align="center">下账金额</th>
				<th align="center">确认下账</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
		 <?php 
			 $shuliangz=0;
			 $tianshuz=0;
			 $danjiaz=0;
			 $jinez=0;
			 $leijiz=0;
			 $qianfuz=0;
			 $yfuz=0;
			 $shuliang=0;
			 $tianshu=0;
			 $danjia=0;
			 $jine=0;
			 $leiji=0;
			 $allyshsql=mysqli_query($con, "select ysdd from t_ffsh ");
			 $allysh=mysqli_fetch_all($allyshsql,MYSQLI_ASSOC);
			 $allddid="0";
			 foreach ($allysh as $ysh){
			 	$allddid.=",".$ysh["ysdd"];
			 }
			 $yshdd=explode(",", $allddid);//所有已经审核过的订单
			 
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on t_groupmanage.teamNumber=t_reserveplan.groupNumber 
			     		where t_reserveplan.hotelName='".$getmsg["jgs"]."' and t_reserveplan.type='ly' and t_reserveplan.startDate between '".$firstday."' and '".$today."'" );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     
			     for($z=0;$z<count($resultarray);$z++){
			         $yifuzsql=mysqli_query($con, "select fee from t_hoteldebt where name=".$resultarray[$z]['hotelName']."  and
 groupnumber='".$resultarray[$z]["teamNumber"]."' and reserveplan=".$resultarray[$z]["id"]);
			         $yifuz=mysqli_fetch_all($yifuzsql,MYSQLI_ASSOC);
			         $yifujez=0;
			         for($yf=0;$yf<count($yifuz);$yf++){
			             $yifujez+=@$yifuz[$yf]["fee"];
			         }
			         $shuliangz+=$resultarray[$z]["number"];
			         $tianshuz+=$resultarray[$z]["dayNum"];
			         $danjiaz+=$resultarray[$z]["costPrice"];
			         $jinez+=$resultarray[$z]["hotelCommissionSum"];
			         $leijiz+=$resultarray[$z]["number"]*$resultarray[$z]["dayNum"];
			         $yfuz+=$yifujez;
			         $qianfuz+=($resultarray[$z]["hotelCommissionSum"]-$yifujez);
			         
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber  where t_reserveplan.hotelName='".$getmsg["jgs"]."'  and t_reserveplan.type='ly'
 and  t_reserveplan.startDate between '".$firstday."' and '".$today."' order by t_reserveplan.startDate desc  limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);

			 }else {
			     $sql="";
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         $sql.=" and t_reserveplan.startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_POST["groupnum"]!=""?" and t_groupmanage.teamNumber like '%".$_POST["groupnum"]."%'":"";
			     $sql.=$_POST["cusname"]!=""?" and t_groupmanage.guest like '%".$_POST["cusname"]."%'":"";
			     $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.hotelName='".$getmsg["jgs"]."' and t_reserveplan.type='ly'
 ".$sql." order by t_groupmanage.id" );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			         $yifuzsql=mysqli_query($con, "select fee from t_hoteldebt where name=".$resultarray[$z]['hotelName']."  and
 groupnumber='".$resultarray[$z]["teamNumber"]."' and reserveplan=".$resultarray[$z]["id"]);
			         $yifuz=mysqli_fetch_all($yifuzsql,MYSQLI_ASSOC);
			         $yifujez=0;
			         for($yf=0;$yf<count($yifuz);$yf++){
			             $yifujez+=@$yifuz[$yf]["fee"];
			         }
			         $shuliangz+=$resultarray[$z]["number"];
			         $tianshuz+=$resultarray[$z]["dayNum"];
			         $danjiaz+=$resultarray[$z]["costPrice"];
			         $jinez+=$resultarray[$z]["hotelCommissionSum"];
			         $leijiz+=$resultarray[$z]["number"]*$resultarray[$z]["dayNum"];
			         $yfuz+=$yifujez;
			         $qianfuz+=($resultarray[$z]["hotelCommissionSum"]-$yifujez);
			         
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.hotelName='".$getmsg["jgs"]."' and t_reserveplan.type='ly'   ".$sql." order by t_reserveplan.startDate desc limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			$yfu=0;
			$qianfu=0;$wfk=0;
			for($a=0;$a<count($resultnowarray);$a++){
			   $yifusql=mysqli_query($con, "select fee from t_hoteldebt where name=".$jddianid."  and
 groupnumber='".$resultnowarray[$a]["teamNumber"]."' and reserveplan=".$resultnowarray[$a]["id"]);
$yifu=mysqli_fetch_all($yifusql,MYSQLI_ASSOC);
$yifuje=0;
for($yf=0;$yf<count($yifu);$yf++){
	$yifuje+=@$yifu[$yf]["fee"];
}
 if($resultnowarray[$a]["hotelCommissionSum"]-$yifuje>0){
$wfk+=1;
			    ?>
			
			  <tr  >
			<td ><?php echo $wfk;?>
			</td><td ><?php echo $resultnowarray[$a]["teamNumber"];?>
            </td><td ><?php echo $resultnowarray[$a]["startDate"];?>
            </td><td ><?php 
			$jddianid=$resultnowarray[$a]['hotelName'];
			$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			$jddian=mysqli_fetch_array($jddiansql);
			echo $jddian["hotelname"];
			?>
            </td><td ><?php 
            $jdid=$resultnowarray[$a]['jd'];
            $jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
            $jd=mysqli_fetch_array($jdsql);
            echo $jd["username"];
            ?>
            </td>
            <td><?php echo $resultnowarray[$a]["id"];?></td>
            <td  style="word-break:break-all; word-wrap:break-all;width:250px;"><?php echo $resultnowarray[$a]["guestName"];?>
            </td><td ><?php echo $resultnowarray[$a]["hotelCommissionSum"];?>
            </td><td ><?php 
		
			echo $yifuje;
			?>
			</td><td ><?php 
			echo $resultnowarray[$a]["hotelCommissionSum"]-$yifuje;
			?><input type="hidden" id="qf<?php echo $a+1;?>" value="<?php 
			echo $resultnowarray[$a]["hotelCommissionSum"]-$yifuje;
			?>">
			</td>
			<td ><input type="text" name="fkmoney[]"  onchange="changemoney();" class="xzmoney"  style="width: 50px;" id="xz<?php echo $a+1;?>" value="0"/>
			</td><td  >
			<input type="checkbox" name="isfk[]" id="fkchecksh<?php echo $a+1;?>" onclick="isfkecheck(<?php echo $a+1;?>)" value="<?php echo $resultnowarray[$a]["id"];?>" />
</td></tr>
<?php			
}}
    ?>
		</tbody>
	</table>
	<script type="text/javascript">
<!--
function isfkecheck(id){
	if($("#fkchecksh"+id).is(':checked')){
		$("#xz"+id).val(parseInt($("#qf"+id).val()));
		lastmoney=parseInt($('#fklastmoney').html())-parseInt($('#xz'+id).val());
		if(lastmoney<0){
alert("余额不足！");
$("#fkchecksh"+id).attr("checked",false);
$("#xz"+id).val("0");
			}else{
				$('#fklastmoney').html(lastmoney);
				$('#fkhavingmoney').val(lastmoney);
				}
		
		}else{
			
			$('#fklastmoney').html(parseInt($('#fklastmoney').html())+parseInt($('#xz'+id).val()));
			$('#fkhavingmoney').val(parseInt($('#fklastmoney').html()));
			$("#xz"+id).val(0);
		}
}
function changemoney(){
	var total=0;
$(".xzmoney").each(function(i){
	var xzid=i+1
	if($(this).val()!=="0"&&$("#fkchecksh"+xzid).is(':checked')){
	total+=parseInt($(this).val());
	}else if($(this).val()!=="0"&&!$("#fkchecksh"+xzid).is(':checked')){
alert("请先选择！");
return false;
		}
});
fkyuee=parseInt($('#allmoney').val())-total;
$('#fklastmoney').html(fkyuee);
$('#fkhavingmoney').val(fkyuee);
}
//-->
</script>
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
			<span>条，共<?php echo $wfk; ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo $wfk; ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
			
</div>
			<div id="fkyxz">
				<table class="searchContent">
			<tr>
			<td class="dateRange">
					日期：
					<input name="startDate" id="startDatey" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" id="endDatey" class="date readonly" readonly="readonly" type="text" value="<?php echo isset($_POST["endDate"])?$_POST["endDate"]:$today;?>">
				</td>
				<td>团号：<input id="groupnumefky"  type="text" size="30" value="" /></td>
				<td>客人姓名：<input id="cusnameefky"  type="text" size="30" value="" /></td>
				<td><a class="button" id="searchefkbuttony" target="ajax" rel="fkyxz" onclick="searcheditfky()"><span>搜索</span></a></td>
				</tr>
				
				</table>
		

	<script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="255" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">日期</th>
				<th align="center">交给社</th>
				<th align="center">计调</th>
				<th align="center">客人姓名</th>
				<th align="center">应付</th>
				<th align="center">已付</th>
<!-- 				<th align="center">销售</th> -->
				<th align="center">欠付</th>
				<th align="center">审核状态</th>
				<th align="center">金额</th>
				<th align="center">取消</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
		 <?php 
		 $shuliangz=0;
		 $tianshuz=0;
		 $danjiaz=0;
		 $jinez=0;
		 $leijiz=0;
		 $qianfuz=0;
		 $yfuz=0;
		 $shuliang=0;
		 $tianshu=0;
		 $danjia=0;
		 $jine=0;
		 $leiji=0;
		 $allyshsql=mysqli_query($con, "select ysdd from t_ffsh ");
		 $allysh=mysqli_fetch_all($allyshsql,MYSQLI_ASSOC);
		 $allddid="0";
		 foreach ($allysh as $ysh){
		 	$allddid.=",".$ysh["ysdd"];
		 }
		 $yshdd=explode(",", $allddid);//所有已经审核过的订单
		 
		 if(@$_POST["search"]==null){
		 	$result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on t_groupmanage.teamNumber=t_reserveplan.groupNumber
			     		where t_reserveplan.hotelName='".$getmsg["jgs"]."' and t_reserveplan.type='ly' and t_reserveplan.startDate between '".$firstday."' and '".$today."'" );
		 	$resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
		 	//分页显示
		 
		 	for($z=0;$z<count($resultarray);$z++){
		 		$yifuzsql=mysqli_query($con, "select fee from t_hoteldebt where name=".$resultarray[$z]['hotelName']."  and
 groupnumber='".$resultarray[$z]["teamNumber"]."' and reserveplan=".$resultarray[$z]["id"]);
		 		$yifuz=mysqli_fetch_all($yifuzsql,MYSQLI_ASSOC);
		 		$yifujez=0;
		 		for($yf=0;$yf<count($yifuz);$yf++){
		 			$yifujez+=@$yifuz[$yf]["fee"];
		 		}
		 		$shuliangz+=$resultarray[$z]["number"];
		 		$tianshuz+=$resultarray[$z]["dayNum"];
		 		$danjiaz+=$resultarray[$z]["costPrice"];
		 		$jinez+=$resultarray[$z]["hotelCommissionSum"];
		 		$leijiz+=$resultarray[$z]["number"]*$resultarray[$z]["dayNum"];
		 		$yfuz+=$yifujez;
		 		$qianfuz+=($resultarray[$z]["hotelCommissionSum"]-$yifujez);
		 
		 	}
		 	$resultnum=count($resultarray);
		 	@$page=ceil($resultnum/$numPerPage);
		 	@$sr=($pageNum-1)*$numPerPage;
		 	$resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber  where t_reserveplan.hotelName='".$getmsg["jgs"]."' and t_reserveplan.type='ly'
 and  t_reserveplan.startDate between '".$firstday."' and '".$today."' order by t_reserveplan.startDate desc  limit ".$sr.",".$numPerPage  );
		 	$resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
// 		 	echo "select * from t_groupmanage right join t_reserveplan on
// 		 	t_groupmanage.teamNumber=t_reserveplan.groupNumber  where t_reserveplan.hotelName='".$getmsg["hotel"]."' and t_reserveplan.type='ly'
// 				    and  t_reserveplan.startDate between '".$firstday."' and '".$today."' order by t_reserveplan.startDate desc  limit ".$sr.",".$numPerPage;
		 }else {
		 	$sql="";
		 	if($_POST["startDate"]!=""){
		 		$startdate=$_POST["startDate"];
		 		$enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
		 		$sql.=" and t_reserveplan.startDate between '".$startdate."' and '".$enddate."'";
		 	}
		 	$sql.=$_POST["groupnum"]!=""?" and t_groupmanage.teamNumber like '%".$_POST["groupnum"]."%'":"";
		 	$sql.=$_POST["cusname"]!=""?" and t_groupmanage.guest like '%".$_POST["cusname"]."%'":"";
		 	$result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.hotelName='".$getmsg["jgs"]."' and t_reserveplan.type='ly'
 ".$sql." order by t_groupmanage.id" );
		 	// echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
		 	$resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
		 	//分页显示
		 	for($z=0;$z<count($resultarray);$z++){
		 		$yifuzsql=mysqli_query($con, "select fee from t_hoteldebt where name=".$resultarray[$z]['hotelName']."  and
 groupnumber='".$resultarray[$z]["teamNumber"]."' and reserveplan=".$resultarray[$z]["id"]);
		 		$yifuz=mysqli_fetch_all($yifuzsql,MYSQLI_ASSOC);
		 		$yifujez=0;
		 		for($yf=0;$yf<count($yifuz);$yf++){
		 			$yifujez+=@$yifuz[$yf]["fee"];
		 		}
		 		$shuliangz+=$resultarray[$z]["number"];
		 		$tianshuz+=$resultarray[$z]["dayNum"];
		 		$danjiaz+=$resultarray[$z]["costPrice"];
		 		$jinez+=$resultarray[$z]["hotelCommissionSum"];
		 		$leijiz+=$resultarray[$z]["number"]*$resultarray[$z]["dayNum"];
		 		$yfuz+=$yifujez;
		 		$qianfuz+=($resultarray[$z]["hotelCommissionSum"]-$yifujez);
		 
		 	}
		 	$resultnum=count($resultarray);
		 	@$page=ceil($resultnum/$numPerPage);
		 	@$sr=($pageNum-1)*$numPerPage;
		 	$resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.hotelName='".$getmsg["jgs"]."'  and t_reserveplan.type='ly'  ".$sql." order by t_reserveplan.startDate desc limit ".$sr.",".$numPerPage );
		 	$resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
		 }
		 	
		  
		 $yfu=0;
		 $qianfu=0;$yfk=0;
		 $yxzplan=explode(",", $getmsg["plan"]);
		 for($a=0;$a<count($resultnowarray);$a++){
		 	$yifusql=mysqli_query($con, "select fee from t_hoteldebt where name=".$jddianid."  and
 groupnumber='".$resultnowarray[$a]["teamNumber"]."' and reserveplan=".$resultnowarray[$a]["id"]);
		 	$yifu=mysqli_fetch_all($yifusql,MYSQLI_ASSOC);
		 	$yifuje=0;
		 	for($yf=0;$yf<count($yifu);$yf++){
		 		$yifuje+=@$yifu[$yf]["fee"];
		 	} 
 if($yifuje>0){
			  
			   $yfk+=1;
			    ?>
			
			  <tr  >
			<td ><?php echo $yfk;?>
			</td><td ><?php echo $resultnowarray[$a]["teamNumber"];?>
            </td><td ><?php echo $resultnowarray[$a]["startDate"];?>
            </td><td ><?php 
			$jddianid=$resultnowarray[$a]['hotelName'];
			$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			$jddian=mysqli_fetch_array($jddiansql);
			echo $jddian["hotelname"];
			?>
            </td><td ><?php 
            $jdid=$resultnowarray[$a]['jd'];
            $jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
            $jd=mysqli_fetch_array($jdsql);
            echo $jd["username"];
            ?>
            </td>
            <td><?php echo $resultnowarray[$a]["id"];?></td>
            <td  style="word-break:break-all; word-wrap:break-all;width:250px;"><?php echo $resultnowarray[$a]["guestName"];?>
            </td><td ><?php echo $resultnowarray[$a]["hotelCommissionSum"];?>
            </td><td ><?php 
		
			echo $yifuje;
			?><input type="hidden" id="yf<?php echo $a+1;?>" value="<?php 
			echo $yifuje;
			?>">
			</td><td ><?php 
			echo $resultnowarray[$a]["hotelCommissionSum"]-$yifuje;
			?>
			</td>
			<td ><input type="text" name="qxmoney[]"  onchange="changemoney();" class="qxmoney"  style="width: 50px;" id="qx<?php echo $a+1;?>" value="0"/>
			</td><td  >
			<input type="checkbox" name="isqx[]" id="qxchecksh<?php echo $a+1;?>" onclick="isqxecheck(<?php echo $a+1;?>)" value="<?php echo $resultnowarray[$a]["id"];?>" />
</td></tr>
<?php			
}
 }
    ?>
		</tbody>
	</table>
	<script type="text/javascript">
<!--
function isqxecheck(id){
	if($("#qxchecksh"+id).is(':checked')){
		$("#qx"+id).val(parseInt($('#yf'+id).val()));
		$('#fklastmoney').html(parseInt($('#fklastmoney').html())+parseInt($('#qx'+id).val()));
		$('#fkhavingmoney').val(parseInt($('#fklastmoney').html()));
		
		
		}else{
			lastmoney=parseInt($('#fklastmoney').html())-parseInt($('#qx'+id).val());
			if(lastmoney<0){
	alert("余额不足！");
	if(parseInt($('#fklastmoney').html())==0){
		 $("#qxchecksh"+id).attr("checked",false);
	}
	$("#xz"+id).val(parseInt($('#fklastmoney').html()));
	$('#fklastmoney').html(0);
	$('#fkhavingmoney').val(0);

				}else{
					$('#fklastmoney').html(lastmoney);
					$('#fkhavingmoney').val(lastmoney);
					}
		}
}
function changemoney(){
	var total=0;
$(".xzmoney").each(function(i){
	var xzid=i+1
	if($(this).val()!=="0"&&$("#fkchecksh"+xzid).is(':checked')){
	total+=parseInt($(this).val());
	}else if($(this).val()!=="0"&&!$("#fkchecksh"+xzid).is(':checked')){
alert("请先选择！");
return false;
		}
});
fkyuee=parseInt($('#allmoney').val())-total;
$('#fklastmoney').html(fkyuee);
$('#fkhavingmoney').val(fkyuee);
}
//-->
</script>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="">
		
				<option value="20" <?php if($numPerPage==20){echo "selected='selected'";}?>>20</option>
				<option value="50"<?php if($numPerPage==50){echo "selected='selected'";}?>>50</option>
				<option value="100"<?php if($numPerPage==100){echo "selected='selected'";}?>>100</option>
				<option value="150"<?php if($numPerPage==150){echo "selected='selected'";}?>>150</option>
				<option value="200"<?php if($numPerPage==200){echo "selected='selected'";}?>>200</option>
				<option value="250"<?php if($numPerPage==250){echo "selected='selected'";}?>>250</option>
			</select>
			<span>条，共<?php echo $yfk; ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo $yfk; ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
			</div>
		</div>

	<div class="formBar cwglbtn"  >
			<ul>
				<li ><div class="buttonActive" ><div class="buttonContent"><button type="submit" >保存</button></div></div></li>
				<li ><div class="buttonActive" ><div class="buttonContent" ><button class="close " >关闭</button></div></div></li>
			</ul>
		</div>
</form>