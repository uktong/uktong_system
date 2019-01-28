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
	$numPerPage=100;
	$pageNum=1;
}


date_default_timezone_set('prc');
$today= date("Y-m-d");
$todaydate=date("Y-m");
$firstday = date("Y-01-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
$id=$_GET["id"];
$getmsgsql=mysqli_query($con, "select * from t_sktravel where id=".$id);
$getmsg=mysqli_fetch_array($getmsgsql);
?>
<script type="text/javascript" src="ajax/js/main.js">

</script>
<script type="text/javascript">
<!--
function searcheditsk(){
	var hotelid=$("#travelsk").val();
	var startDate=$("#startDateesk").val();
	var endDate=$("#endDateesk").val();
	var groupnum=$("#groupnumesk").val();
	var cusname=$("#cusnameesk").val();
	$("#searcheskbutton").attr("href","ajax/skwxz.php?id=<?php echo $id;?>&search=yes&travelid="+hotelid+"&startDate="+startDate+"&endDate="+endDate+"&groupnum="+groupnum+"&cusname="+cusname);
}

function searcheditsky(){
	var hotelid=$("#travelsk").val();
	var startDate=$("#startDateesky").val();
	var endDate=$("#endDateesky").val();
	var groupnum=$("#groupnumesky").val();
	var cusname=$("#cusnameesky").val();
	$("#searcheskbuttony").attr("href","ajax/skyxz.php?id=<?php echo $id;?>&search=yes&travelid="+hotelid+"&startDate="+startDate+"&endDate="+endDate+"&groupnum="+groupnum+"&cusname="+cusname);
}
//-->
</script>
<style>
<!--

-->
</style>


<form id="pagerForm" method="post" action="ajax/skcontent.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>
<div class="pageContent">
<form method="post" action="db/addadwsk.php?action=edit&id=<?php echo $id; ?>" onsubmit="return validateCallback(this, dialogAjaxDone) " class="pageForm required-validate" >
<div class="pageHeader">
<h2 class="contentTitle" style="text-align: center;">修改按单位收款</h2>
		
	<div class="searchBar">
	
		<table class="searchContent" id="fftable"  cellspacing="0">
			<tr>
				<td >
					旅行社:
				<input type="hidden" name="zts.id" id="travelsk" value="<?php echo @$getmsg["travel"];?>"/>
				<input type="text" class="getzts" name="zts.zts" value="<?php
				$ztsid=@$getmsg["travel"];
				$ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
				$zts=mysqli_fetch_array($ztssql);
				echo $zts['travel_name'];
				?>" readonly style="width:100px; " suggestFields="zts"  lookupGroup="zts" />
				<a class="btnLook" href="ajax/dh/zts.php"style="float:right;margin-right:100px;"  lookupGroup="zts">选择用户</a>
				</td><td>归档时间:
				<select name="gdmonth" id="gdmonth" >
				<option value="">------</option>
				<?php for($m=1;$m<13;$m++){?>
				<option value="<?php echo $m;?>" <?php echo @$getmsg["gddate"]==$m?"selected='selected'":"";?> ><?php echo $m;?>月</option>
				<?php }?>
				</select></td>
				<td >
					金额:
					<input type="hidden" name="havingmoney" id="skhavingmoney" value="<?php echo @$getmsg["mhaving"];?>">
				<input type="text" name="money" id="allmoney" onchange="$('#sklastmoney').html($(this).val());$('#skhavingmoney').val($(this).val());"  style="width:100px;" value="<?php echo @$getmsg["money"];?>"/>余额：<span id="sklastmoney"><?php echo @$getmsg["mhaving"];?></span>
				</td></tr>
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
		
	</div>
</div>
<?php



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
			<div id="skwxz">
<table class="searchContent">
			<tr>
			<td class="dateRange">
					日期：
					<input id="startDateesk" class="date readonly" readonly="readonly" type="text" value="<?php echo $firstday;?>">
					<span class="limit">-</span>
					<input id="endDateesk" class="date readonly" readonly="readonly" type="text" value="<?php echo $today;?>">
				</td>
				<td>团号：<input id="groupnumesk"  type="text" size="30" value="" /></td>
				<td>客人姓名：<input id="cusnameesk"  type="text" size="30" value="" /></td>
				<td><a class="button" id="searcheskbutton" target="ajax" rel="skwxz" onclick="searcheditsk()"><span>搜索</span></a></td>
				</tr>
				
				</table>

	<div ></div>

	<table class="table" width="100%" layoutH="155" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
			<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">日期</th>
				<th align="center">联系人</th>
				<th align="center">组团社</th>
				<th align="center">客人姓名</th>
				<th align="center">应收</th>
				<th align="center">已收</th>
<!-- 				<th align="center">销售</th> -->
				<th align="center">欠收</th>
				<th align="center">下账金额</th>
				<th align="center">确认下账</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
		 <?php 
		
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"
select a.*,sum(ifnull(b.sumPrice,0)) as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
and  b.startDate between '".$firstday."' and '".$today."' group by a.teamNumber" );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
// 		     echo "
// select a.*,sum(ifnull(b.sumPrice,0)) as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
// and b.sumPrice!= (select sum(ifnull(amount,0)) as nowin from t_collectionunit where groupNumber=b.groupNumber) and  b.startDate between '".$firstday."' and '".$today."' group by a.teamNumber" ;
// 			     for($z=0;$z<count($resultarray);$z++){
// 			     	$zmsql=mysqli_query($con, "select * from t_collectionunit where groupNumber='".$resultarray[$z]['teamNumber']."'");
// 			     	$zm=mysqli_fetch_all($zmsql,MYSQLI_ASSOC);
			     	 
			       
// 			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"
select a.*,sum(ifnull(b.sumPrice,0)) as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
and  b.startDate between '".$firstday."' and '".$today."' group by a.teamNumber
 order by a.startDate desc  limit ".$sr.",".$numPerPage  );
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
			     $result=mysqli_query($con,"select a.*,b.sumPrice as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
and b.sumPrice!= (select sum(amount) as nowin from t_collectionunit where groupNumber=b.groupNumber)
 ".$sql." order by a.id" );
// 			     echo "select a.*,b.sumPrice as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
// and b.sumPrice!= (select sum(amount) as nowin from t_collectionunit where groupNumber=b.groupNumber)
//  ".$sql." order by a.id";
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			        $zmsql=mysqli_query($con, "select * from t_collectionunit where groupNumber='".$resultarray[$z]['teamNumber']."'");
$zm=mysqli_fetch_all($zmsql,MYSQLI_ASSOC);

for($w=0;$w<count($zm);$w++){
	$yifu+=$zm[$w]["amount"];
	 
}
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select a.*,b.sumPrice as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
and b.sumPrice!= (select sum(amount) as nowin from t_collectionunit where groupNumber=b.groupNumber)  ".$sql." order by b.startDate desc limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			
			    
			$yfu=0;
			$qianfu=0;
			$countline=0;
			for($a=0;$a<count($resultnowarray);$a++){
			   $getyssql=mysqli_query($con, "select sum(sumPrice) as money from t_reserveplan where groupNumber='".$resultnowarray[$a]["teamNumber"]."'");
$ysre=mysqli_fetch_array($getyssql);
$getyishousql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where groupNumber='".$resultnowarray[$a]["teamNumber"]."'");
$yishoure=mysqli_fetch_array($getyishousql);

 if($ysre["money"]-$yishoure["money"]>0){
			   $countline+=1;
			    ?>
			
			  <tr  >
			  <td><?php echo $countline;?></td>
			<td ><?php echo $resultnowarray[$a]["teamNumber"];?>
            </td><td ><?php echo $resultnowarray[$a]["startDate"];?>
            </td><td ><?php 
            echo $resultnowarray[$a]["linkmanname"];
			?>
			 </td><td ><?php 
			 $ztsid=$resultnowarray[$a]['groupName'];
			 $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			 $zts=mysqli_fetch_array($ztssql);
			 echo $zts['travel_name'];
			 ?>
            <td  style="word-break:break-all; word-wrap:break-all;width:250px;"><?php echo $resultnowarray[$a]["guest"];?>
            </td><td ><?php 
            
            echo $resultnowarray[$a]["allin"];
            ?>
            </td><td ><?php 
			
           
            if($yishoure["money"]==null){
            	echo "0";
            }else {
            	echo $yishoure["money"];
            	
            }
			?>
			</td>
			
			<td ><?php echo $ysre["money"]-$yishoure["money"];
			?>
            <input type="hidden" id="qs<?php echo $a+1;?>" value="<?php 
			echo $ysre["money"]-$yishoure["money"];
			?>">
            </td><td ><input type="text" name="skmoney[]"  onchange="changemoney();" class="xzmoney"  style="width: 50px;" id="xz<?php echo $a+1;?>" value="0"/>
			</td><td  >
			<input type="checkbox" name="issk[]" id="skchecksh<?php echo $a+1;?>" onclick="isskecheck(<?php echo $a+1;?>)" value="<?php echo $resultnowarray[$a]["id"];?>" />
</td></tr>
<?php			

}}
    ?>
		</tbody>
	</table>
	<script type="text/javascript">
<!--
function isskecheck(id){
	if($("#skchecksh"+id).is(':checked')){
		$("#xz"+id).val(parseInt($("#qs"+id).val()));
		lastmoney=parseInt($('#sklastmoney').html())-parseInt($('#xz'+id).val());
		if(lastmoney<0){
alert("余额不足！");

if(parseInt($('#sklastmoney').html())==0){
	 $("#skchecksh"+id).attr("checked",false);
}
$("#xz"+id).val(parseInt($('#sklastmoney').html()));
$('#sklastmoney').html(0);
$('#skhavingmoney').val(0);

			}else{
				$('#sklastmoney').html(lastmoney);
				$('#skhavingmoney').val(lastmoney);
				}
		
		}else{
			$('#sklastmoney').html(parseInt($('#sklastmoney').html())+parseInt($('#xz'+id).val()));
			$('#skhavingmoney').val(parseInt($('#sklastmoney').html())+parseInt($('#xz'+id).val()));
			$("#xz"+id).val("0");
		}
}
function changemoney(){
	var total=0;
$(".xzmoney").each(function(i){
	var xzid=i+1
	if($(this).val()!=="0"&&$("#skchecksh"+xzid).is(':checked')){
	total+=parseInt($(this).val());
	}else if($(this).val()!=="0"&&!$("#skchecksh"+xzid).is(':checked')){
alert("请先选择！");
return false;
		}
});
fkyuee=parseInt($('#allmoney').val())-total;
$('#sklastmoney').html(fkyuee);
$('#skhavingmoney').val(fkyuee);
}
//-->
</script>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" >
		
				<option value="20" <?php if($numPerPage==20){echo "selected='selected'";}?>>20</option>
				<option value="50"<?php if($numPerPage==50){echo "selected='selected'";}?>>50</option>
				<option value="100"<?php if($numPerPage==100){echo "selected='selected'";}?>>100</option>
				<option value="150"<?php if($numPerPage==150){echo "selected='selected'";}?>>150</option>
				<option value="200"<?php if($numPerPage==200){echo "selected='selected'";}?>>200</option>
				<option value="250"<?php if($numPerPage==250){echo "selected='selected'";}?>>250</option>
			</select>
			<span>条，共<?php echo $countline; ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php $countline; ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
			
</div>
			<div id="skyxz">
				<table class="searchContent">
			<tr>
			<td class="dateRange">
					日期：
					<input id="startDateesky" class="date readonly" readonly="readonly" type="text" value="<?php echo $firstday;?>">
					<span class="limit">-</span>
					<input id="endDateesky" class="date readonly" readonly="readonly" type="text" value="<?php echo $today;?>">
				</td>
				<td>团号：<input id="groupnumesky"  type="text" size="30" value="" /></td>
				<td>客人姓名：<input id="cusnameesky"  type="text" size="30" value="" /></td>
				<td><a class="button" id="searcheskbuttony" target="ajax" rel="skyxz" onclick="searcheditsky()"><span>搜索</span></a></td>
				</tr>
				
				</table>
		
<table class="table" width="100%" layoutH="255" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
			<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">日期</th>
				<th align="center">联系人</th>
				<th align="center">组团社</th>
				<th align="center">客人姓名</th>
				<th align="center">应收</th>
				<th align="center">已收</th>
<!-- 				<th align="center">销售</th> -->
				<th align="center">欠收</th>
				<th align="center">金额</th>
				<th align="center">取消下账</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
		 <?php 
		
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"select a.*,sum(ifnull(b.sumPrice,0)) as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
and  b.startDate between '".$firstday."' and '".$today."' group by a.teamNumber" );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     
			     for($z=0;$z<count($resultarray);$z++){
			     	$zmsql=mysqli_query($con, "select * from t_collectionunit where groupNumber='".$resultarray[$z]['teamNumber']."'");
			     	$zm=mysqli_fetch_all($zmsql,MYSQLI_ASSOC);
			     	 
			       
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"
select a.*,sum(ifnull(b.sumPrice,0)) as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
and  b.startDate between '".$firstday."' and '".$today."' group by a.teamNumber
 order by a.startDate desc  limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }else {
			     $sql="";
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         $sql.=" and b.startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_POST["groupnum"]!=""?" and a.teamNumber like '%".$_POST["groupnum"]."%'":"";
			     $sql.=$_POST["cusname"]!=""?" and a.guest like '%".$_POST["cusname"]."%'":"";
			     $result=mysqli_query($con,"select a.*,sum(ifnull(b.sumPrice,0)) as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
 ".$sql." order by a.id" );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			        $zmsql=mysqli_query($con, "select * from t_collectionunit where groupNumber='".$resultarray[$z]['teamNumber']."'");
$zm=mysqli_fetch_all($zmsql,MYSQLI_ASSOC);

for($w=0;$w<count($zm);$w++){
	$yifu+=$zm[$w]["amount"];
	 
}
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     
			     $resultnow=mysqli_query($con,"select a.*,sum(ifnull(b.sumPrice,0)) as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
 ".$sql." order by b.startDate desc limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			
			    
			$yfu=0;
			$qianfu=0;
			$countlineq=0;
			for($a=0;$a<count($resultnowarray);$a++){
			   
$getyishousql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where groupNumber='".$resultnowarray[$a]["teamNumber"]."'");
$yishoure=mysqli_fetch_array($getyishousql);

 if($yishoure["money"]!=0){
			   $countlineq+=1;
			    ?>
			
			  <tr  >
			  <td><?php echo $countlineq;?></td>
			<td ><?php echo $resultnowarray[$a]["teamNumber"];?>
            </td><td ><?php echo $resultnowarray[$a]["startDate"];?>
            </td><td ><?php 
            echo $resultnowarray[$a]["linkmanname"];
			?>
			 </td><td ><?php 
			 $ztsid=$resultnowarray[$a]['groupName'];
			 $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			 $zts=mysqli_fetch_array($ztssql);
			 echo $zts['travel_name'];
			 ?>
            <td  style="word-break:break-all; word-wrap:break-all;width:250px;"><?php echo $resultnowarray[$a]["guest"];?>
            </td><td ><?php 
            
            echo $resultnowarray[$a]["allin"];
            ?>
            </td><td ><?php 
			
           
            if($yishoure["money"]==null){
            	echo "0";
            }else {
            	echo $yishoure["money"];
            }
			?>  <input type="hidden" id="qxys<?php echo $a+1;?>" value="<?php 
			echo $yishoure["money"];
			?>">
			</td>
			
			<td ><?php echo $resultnowarray[$a]["allin"]-$yishoure["money"];
			?>
          
            </td><td ><input type="text" name="qxskmoney[]"  onchange="changemoney();" class="xzmoney"  style="width: 50px;" id="qx<?php echo $a+1;?>" value="0"/>
			</td><td  >
			<input type="checkbox" name="isqxsk[]" id="qxskchecksh<?php echo $a+1;?>" onclick="isqxskecheck(<?php echo $a+1;?>)" value="<?php echo $resultnowarray[$a]["id"];?>" />
</td></tr>
<?php			
}
 }
    ?>
		</tbody>
	</table>
	<script type="text/javascript">
<!--function isqxskecheck(id){
	if($("#qxskchecksh"+id).is(':checked')){
		$("#qx"+id).val(parseInt($('#qxys'+id).val()));
		$('#sklastmoney').html(parseInt($('#sklastmoney').html())+parseInt($('#qx'+id).val()));
		$('#skhavingmoney').val(parseInt($('#sklastmoney').html()));
		
		
		}else{
			lastmoney=parseInt($('#sklastmoney').html())-parseInt($('#qx'+id).val());
			if(lastmoney<0){
	alert("余额不足！");
	
	if(parseInt($('#sklastmoney').html())==0){
		 $("#qxchecksh"+id).attr("checked",false);
	}
	$("#qx"+id).val(parseInt($('#sklastmoney').html()));
	$('#sklastmoney').html(0);
	$('#skhavingmoney').val(0);
		
				}else{
					$("#qx"+id).val("0");
					$('#sklastmoney').html(lastmoney);
					$('#skhavingmoney').val(lastmoney);
					}
		}
}
function changemoney(){
	var total=0;
$(".xzmoney").each(function(i){
	var xzid=i+1
	if($(this).val()!=="0"&&$("#skchecksh"+xzid).is(':checked')){
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
			<select class="combox" name="numPerPage" >
		
				<option value="20" <?php if($numPerPage==20){echo "selected='selected'";}?>>20</option>
				<option value="50"<?php if($numPerPage==50){echo "selected='selected'";}?>>50</option>
				<option value="100"<?php if($numPerPage==100){echo "selected='selected'";}?>>100</option>
				<option value="150"<?php if($numPerPage==150){echo "selected='selected'";}?>>150</option>
				<option value="200"<?php if($numPerPage==200){echo "selected='selected'";}?>>200</option>
				<option value="250"<?php if($numPerPage==250){echo "selected='selected'";}?>>250</option>
			</select>
			<span>条，共<?php echo $countlineq; ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo $countlineq; ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

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

</div>
