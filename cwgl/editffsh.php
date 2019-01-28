<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$today=date("Y-m-d");
$todaydate=date("Y-m");
$firstday =date("Y-m-01");
$lastday =date("Y-m-d",strtotime("$firstday +1 month -1 day"));
$id=$_GET["id"];
$getmsgsql=mysqli_query($con, "select * from t_ffsh where id=".$id);
$getmsg=mysqli_fetch_array($getmsgsql);
?>
<script type="text/javascript" src="ajax/js/main.js"></script>
<script type="text/javascript">
<!--
function newadd(){
	var hotelid=$("#jdian").val();
	var money=$("#money").val();
	var date=$("#date").val();
	$("#add").attr("href","ajax/sscontent.php?hotelid="+hotelid+"&money="+money+"&date="+date);
}
function searcheditsh(){
	var hotelid=$("#jdian").val();
	var startDateshe=$("input[name=startDateshe]").val();
	var endDateshe=$("input[name=endDateshe]").val();
	var groupnum=$("input[name=groupnum]").val();
	var cusname=$("input[name=cusname]").val();
// 	alert("ajax/skcontent.php?travelid="+hotelid+"&start="+startt+"&end="+endt+"&groupnum="+groupnum+"&cusname="+cusname);

	$("#searcheshebutton").attr("href","cwgl/editffsh.php?search=yes&id=<?php echo $id;?>&travelid="+hotelid+"&startDateshe="+startDateshe+"&endDateshe="+endDateshe+"&groupnum="+groupnum+"&cusname="+cusname);
}
function searcheditshy(){
	var hotelid=$("#jdian").val();
	var startDateshe=$("input[name=startDateshey]").val();
	var endDateshe=$("input[name=endDateshey]").val();
	var groupnum=$("input[name=groupnumy]").val();
	var cusname=$("input[name=cusnamey]").val();
// 	alert("ajax/skcontent.php?travelid="+hotelid+"&start="+startt+"&end="+endt+"&groupnum="+groupnum+"&cusname="+cusname);

	$("#searcheshebuttony").attr("href","cwgl/editffsh.php?search=yes&id=<?php echo $id;?>&travelid="+hotelid+"&startDateshe="+startDateshe+"&endDateshe="+endDateshe+"&groupnum="+groupnum+"&cusname="+cusname);
}
//-->
</script>
<style>
<!--

-->
</style>

<form method="post" id="editffshbox" action="db/addffsh.php?action=edit&id=<?php echo $id; ?>" onsubmit="return validateCallback(this, dialogAjaxDone) " class="pageForm required-validate" >
<div class="pageHeader">
<h2 class="contentTitle" style="text-align: center;">修改房费审核</h2>
		
	<div class="searchBar">
	
		<table class="searchContent" id="fftable"  cellspacing="0">
			<tr>
				<td >
					酒店:
				<input type="hidden" id="jdian" name="jdian555.id" value="<?php echo $getmsg["hotel"];
				$jddianid=$getmsg["hotel"];
				$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
				$jddian=mysqli_fetch_array($jddiansql);
				
				
				?>"/>
				<input type="text" readonly value="<?php echo $jddian["hotelname"];?>" />
				</td>
				<td >
					归档时间:
				<select name="shmonth" id="shmonth" >
				<option value="">------</option>
				<?php for($m=1;$m<13;$m++){?>
				<option value="<?php echo $m;?>" <?php if($getmsg["gddate"]==$m){echo "selected='selected'";}?>><?php echo $m;?>月</option>
				<?php }?>
				</select>
				</td>
				
				<td >
					金额:
					<input type="hidden" name="ehavingmoney" id="ehavingmoney" value="<?php echo $getmsg["mhaving"];?>">
				<input type="text"  name="money" onchange="$('#lastmoney').html($(this).val());$('#havingmoney').val($(this).val());" id="money" style="width:100px;" value="<?php echo $getmsg["money"];?>"/>余额：<span id="elastmoney"><?php echo $getmsg["mhaving"];?></span>
				</td></tr><tr>
				<td>日期:<input name="doDate" id="date" class="date readonly" readonly="readonly" type="text" value="<?php echo $getmsg["dodate"];?>"></td>
					<td >
					备注:
				<input type="text" name="remark" id="remark" style="width:100px;" value="<?php echo $getmsg["remark"];?>"/>
				</td>
			</tr>
		</table>
		
	</div>
<?php

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

require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$today= date("Y-m-d");
$firstday = date("Y-01-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));

?>

<div class="tabs" currentIndex="0" eventType="click">
		<div class="tabsHeader">
			<div class="tabsHeaderContent">
				<ul>
					<li><a href="javascript:;"><span>未审核数据</span></a></li>
					<li><a href="javascript:;"><span>已审核数据</span></a></li>
				</ul>
			</div>
		</div>
				<div class="tabsContent" style="height:380px;">
			<div id="skwxz">
	<table class="searchContent">
			<tr>
				
				
			<td class="dateRange">
					日期：
					<input name="startDateshe" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_GET["startDateshe"])?@$_GET["startDateshe"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDateshe" class="date readonly" readonly="readonly" type="text" value="<?php
					 echo isset($_GET["endDateshe"])?@$_GET["endDateshe"]:$today;?>">
				</td>
				<td>团号：<input name="groupnum"  type="text" size="30" value="<?php echo @$_GET["groupnum"];?>" /></td>
				<td>客人姓名：<input name="cusname"  type="text" size="30" value="<?php echo @$_GET["cusname"];?>" /></td>
				<td><a class="button" id="searcheshebutton" target="dialog" rel="editffsh" onclick="searcheditsh()"><span>搜索</span></a></td>
				</tr>
				</table>
	<input name="search"  type="hidden" size="30" value="yes"/>
	<input name="searchtype"  type="hidden" size="30" value="jdyfcx"/>

	<script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="230" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">日期</th>
				<th align="center">酒店</th>
				<th align="center">计调</th>
				<th align="center">明细</th>
				<th align="center">客人姓名</th>
				<th align="center">应付</th>
				<th align="center">已付</th>
<!-- 				<th align="center">销售</th> -->
				<th align="center">欠付</th>
				
				<th align="center">审核金额</th>
				<th align="center">确认审核</th>
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
			 $ysh=explode(",", $getmsg["ysdd"]);//这条数据已审核
			 
			 $allyshsql=mysqli_query($con, "select ysdd from t_ffsh ");
			 $allysh=mysqli_fetch_all($allyshsql,MYSQLI_ASSOC);
			 $allddid="0";
			 foreach ($allysh as $ysh){
			 	$allddid.=",".$ysh["ysdd"];
			 }
			 $yshdd=explode(",", $allddid);//所有已经审核过的订单
			 
			 if(@$_GET["search"]==null){
			     $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on t_groupmanage.teamNumber=t_reserveplan.groupNumber 
			     		where t_reserveplan.hotelName='".$getmsg["hotel"]."' and t_reserveplan.startDate between '".$firstday."' and '".$today."'" );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     
			     for($z=0;$z<count($resultarray);$z++){
			         $yifuzsql=mysqli_query($con, "select fee from t_hoteldebt where name=".$resultarray[$z]['hotelName']."  and
 groupnumber='".$resultarray[$z]["teamNumber"]."' and reserveplan=".$resultarray[$z]["id"]);
			         @$yifuz=mysqli_fetch_all($yifuzsql,MYSQLI_ASSOC);
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
t_groupmanage.teamNumber=t_reserveplan.groupNumber  where t_reserveplan.hotelName='".$getmsg["hotel"]."' and  t_reserveplan.startDate between '".$firstday."' and '".$today."' order by t_reserveplan.startDate desc  limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }else {
			     $sql="";
			     if($_GET["startDateshe"]!=""){
			         $startdate=$_GET["startDateshe"];
			         $enddate=$_GET["endDateshe"]!=""?$_GET["endDateshe"]:date("Y-m-d",time());
			         $sql.=" and t_reserveplan.startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_GET["groupnum"]!=""?" and t_groupmanage.teamNumber like '%".$_GET["groupnum"]."%'":"";
			     $sql.=$_GET["cusname"]!=""?" and t_groupmanage.guest like '%".$_GET["cusname"]."%'":"";
			     $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.hotelName='".$getmsg["hotel"]."'  ".$sql." order by t_groupmanage.id" );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			         $yifuzsql=mysqli_query($con, "select fee from t_hoteldebt where name=".$resultarray[$z]['hotelName']."  and
 groupnumber='".$resultarray[$z]["teamNumber"]."' and reserveplan=".$resultarray[$z]["id"]);
			        @$yifuz=mysqli_fetch_all($yifuzsql,MYSQLI_ASSOC);
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
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.hotelName='".$getmsg["hotel"]."'  ".$sql." order by t_reserveplan.startDate desc limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			
			    
			$yfu=0;
			$qianfu=0;
			$countlinesh=0;
			for($a=0;$a<count($resultnowarray);$a++){
			   
if(!in_array($resultnowarray[$a]["id"], $yshdd)){
	$countlinesh+=1;
			   
			    ?>
			
			  <tr  >
			<td ><?php echo $countlinesh;?>
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
            $jd=@mysqli_fetch_array($jdsql);
            echo $jd["username"];
            ?>
            </td>
            <td><?php echo $resultnowarray[$a]["id"];?></td>
            <td  style="word-break:break-all; word-wrap:break-all;width:250px;"><?php echo $resultnowarray[$a]["guestName"];?>
            </td><td ><?php echo $resultnowarray[$a]["costPrice"];?>
            </td><td ><?php 
			$yifusql=mysqli_query($con, "select fee from t_hoteldebt where name=".$jddianid."  and
 groupnumber='".$resultnowarray[$a]["teamNumber"]."' and reserveplan=".$resultnowarray[$a]["id"]);
			@$yifu=mysqli_fetch_all($yifusql,MYSQLI_ASSOC);
			$yifuje=0;
			for($yf=0;$yf<count($yifu);$yf++){
			    $yifuje+=@$yifu[$yf]["fee"];
			}
			echo $yifuje;
			?>
            </td><td ><?php 
			echo $resultnowarray[$a]["costPrice"]-$yifuje;
			?>
            </td><td ><input type="text" name="shmoney[]" readonly  style="width: 50px;" id="xz<?php echo $a+1;?>" value="<?php echo $resultnowarray[$a]["costPrice"]-$yifuje; ?>"/>
			</td><td  >
			<input type="checkbox" name="issh[]" id="checksh<?php echo $a+1;?>"  onclick="isecheck(<?php echo $a+1;?>)" value="<?php echo $resultnowarray[$a]["id"];?>" />
</td></tr>
<?php			
}
 }
    ?>
    
		</tbody>
	</table>

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
			<span>条，共<?php echo $countlinesh; ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo $countlinesh; ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
	
</div>
			<div id="skyxz">
			<table class="searchContent">
			<tr>
				
				
			<td class="dateRange">
					日期：
					<input name="startDateshey" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_GET["startDateshe"])?@$_GET["startDateshe"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDateshey" class="date readonly" readonly="readonly" type="text" value="<?php
					 echo isset($_GET["endDateshe"])?@$_GET["endDateshe"]:$today;?>">
				</td>
				<td>团号：<input name="groupnumy"  type="text" size="30" value="<?php echo @$_GET["groupnum"];?>" /></td>
				<td>客人姓名：<input name="cusnamey"  type="text" size="30" value="<?php echo @$_GET["cusname"];?>" /></td>
				<td><a class="button" id="searcheshebuttony" target="dialog" rel="editffsh" onclick="searcheditshy()"><span>搜索</span></a></td>
				</tr>
				</table>
	<input name="search"  type="hidden" size="30" value="yes"/>
	<input name="searchtype"  type="hidden" size="30" value="jdyfcx"/>
			
			<table class="table" width="100%" layoutH="230" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">日期</th>
				<th align="center">酒店</th>
				<th align="center">计调</th>
				<th align="center">明细</th>
				<th align="center">客人姓名</th>
				<th align="center">应付</th>
				<th align="center">已付</th>
				<th align="center">欠付</th>
				<th align="center">审核金额</th>
				<th align="center">取消审核</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
		 <?php 
			
			    
			$yfu=0;
			$qianfu=0;
			$countlineysh=0;
			$thisyshdd=explode(",", $getmsg["ysdd"]);//已经审核过的订单
			for($a=0;$a<count($resultnowarray);$a++){
if(in_array($resultnowarray[$a]["id"], $thisyshdd)){
	$countlineysh+=1;
			   
			    ?>
			
			  <tr  >
			<td ><?php echo $countlineysh;?>
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
            $jd=@mysqli_fetch_array($jdsql);
            echo $jd["username"];
            ?>
            </td>
            <td><?php echo $resultnowarray[$a]["id"];?></td>
            <td  style="word-break:break-all; word-wrap:break-all;width:250px;"><?php echo $resultnowarray[$a]["guestName"];?>
            </td><td ><?php echo $resultnowarray[$a]["costPrice"];?>
            </td><td ><?php 
			$yifusql=mysqli_query($con, "select fee from t_hoteldebt where name=".$jddianid."  and
 groupnumber='".$resultnowarray[$a]["teamNumber"]."' and reserveplan=".$resultnowarray[$a]["id"]);
			@$yifu=mysqli_fetch_all($yifusql,MYSQLI_ASSOC);
			$yifuje=0;
			for($yf=0;$yf<count($yifu);$yf++){
			    $yifuje+=@$yifu[$yf]["fee"];
			}
			echo $yifuje;
			?>
            </td><td ><?php 
			echo $resultnowarray[$a]["costPrice"]-$yifuje;
			?>
            </td><td ><input type="text" name="shmoney[]" readonly  style="width: 50px;" id="xz<?php echo $a+1;?>" value="<?php echo $resultnowarray[$a]["costPrice"]-$yifuje; ?>"/>
			</td><td  >
			<input type="checkbox" name="issh[]" id="checksh<?php echo $a+1;?>" <?php if(in_array($resultnowarray[$a]["id"], $thisyshdd)){echo "checked='checked'";}?> onclick="isecheck(<?php echo $a+1;?>)" value="<?php echo $resultnowarray[$a]["id"];?>" />
</td></tr>
<?php			
}
 }
    ?>
    
		</tbody>
	</table>
	<script type="text/javascript">
<!--
function isecheck(id){
	if($("#checksh"+id).is(':checked')){
		lastmoney=parseInt($('#elastmoney').html())-parseInt($('#xz'+id).val());
		if(lastmoney<0){
alert("余额不足！");
$("#checksh"+id).attr("checked",false);
			}else{
				$('#elastmoney').html(lastmoney);
				$('#ehavingmoney').val(lastmoney);
				}
		
		}else{
			$('#elastmoney').html(parseInt($('#elastmoney').html())+parseInt($('#xz'+id).val()));
			$('#ehavingmoney').val(parseInt($('#elastmoney').html()));
		}
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
			<span>条，共<?php echo $countlineysh; ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo $countlineysh; ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

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

