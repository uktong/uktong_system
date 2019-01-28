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
    $numPerPage=50;
    $pageNum=1;
}

require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$today= date("Y-m-d");
$firstday = date("Y-01-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
$action=@$_GET["action"];
switch ($action){
    case "chaxun":
        chaxun();
        break;
    case "charu":
        charu();
        break;
    case "delete":
        shanchu();
        break;
    case "edit":
        edit();
        break;
}
function charu(){
    
    
    mysqli_close($con);
}
function edit(){
    
}
function shanchu(){
    require $_SESSION["ROOT"].'/db/db.php';
    $id=$_GET["id"];
    mysqli_query($con, "delete from t_sktravel where id=".$id);
}

?>
<script type="text/javascript" src="ajax/js/main.js"></script>
<script type="text/javascript">
<!--
function getyue(){
	$.post("ajax/getyue.php",{accountid:$('#account').val()},function(data){
$('#yue').html("余额："+data);
		});
}

function sknewadd(){
	var hotelid=$("#travelsk").val();

	$("#addsk").attr("href","ajax/lyskcontent.php?travelid="+hotelid);
}
function searchthis(){
	var hotelid=$("#travelsk").val();
	var startDate=$("#startDate").val();
	var endDate=$("#endDate").val();
	var groupnum=$("#groupnum").val();
	var cusname=$("#cusname").val();
	$("#searchbutton").attr("href","ajax/skcontent.php?search=yes&travelid="+hotelid+"&startDate="+startDate+"&endDate="+endDate+"&groupnum="+groupnum+"&cusname="+cusname);
}
//-->
</script>
<form id="pagerForm" method="post" action="ajax/lyskcontent.php">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
</form>
<div class="pageContent">
<form method="post" action="db/addlysk.php?action=charu" onsubmit="return validateCallback(this, dialogAjaxDone) " class="pageForm required-validate" >

<div class="pageHeader">
<h2 class="contentTitle" style="text-align: center;">新增旅游收款</h2>
		
	<div class="searchBar">
	
		<table class="searchContent" id="fftable"  cellspacing="0">
			<tr>
				<td >
					客人:
				<input type="hidden" name="zts.id" id="travelsk" value="8"/>
				<input type="text" class="getjgs required" readonly value="散客"  name="zts.zts" value="<?php echo @$_POST["zts_zts"];?>" style="width:100px; " suggestFields="zts"  lookupGroup="zts" />
				</td><td>	归档时间:
				<select name="gdmonth" id="gdmonthfk">
				<option value="">------</option>
				<?php for($m=1;$m<13;$m++){?>
				<option value="<?php echo $m;?>" <?php if($m==date("m")){echo "selected='selected'";}?>><?php echo $m;?>月</option>
				<?php }?>
				</select></td>
				<td >
					金额:
					<input type="hidden" name="havingmoney" id="skhavingmoney" value="0">
				<input type="text" name="money" class="required" id="allmoney" onchange="$('#sklastmoney').html($(this).val());$('#havingmoney').val($(this).val());"  style="width:100px;" value="<?php echo @$_POST["money"];?>"/>余额：<span id="sklastmoney">0</span>
				</td></tr>
<!-- 				<td > -->
<!-- 					酒店: -->

<!-- 				</td> -->
	<tr> 
				<td >
					方式:
					<select   name="paytype" >
			<option value="">------</option>
			<?php $getpaytype=mysqli_query($con, "select * from t_baseconfig where basenote=5 ");
			$getpay=mysqli_fetch_all($getpaytype, MYSQLI_ASSOC);
			foreach ($getpay as $pay){
			?>
			<option <?php 
			if(isset($_POST["paytype"])&&$_POST["paytype"]==$pay["id"]){
			    echo "selected='selected'";
			}
			?> value="<?php echo $pay["id"];?>"><?php echo $pay["basetype"];?></option>
			<?php }?>
			</select>
				</td><td>日期：<input name="doDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$today;?>"></td>
				<td >
					发票金额:
					<input name="invoice"  type="text" size="30" style="width:150px;" value="<?php echo @$_POST["invoice"];?>" />
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
			<option <?php 
			if(isset($_POST["paytype"])&&$_POST["paytype"]==$pay["id"]){
			    echo "selected='selected'";
			}
			?> value="<?php echo $pay["id"];?>"><?php echo $pay["accountTitle"];?>-<?php echo $pay["bankName"];?>-<?php echo $pay["accountNumber"];?></option>
			
			<?php }?>
			</select>
				</td>
			
				<td><span id="yue" style="color:red;"></span></td><td>收款人:<input type="hidden" name="jd.id" value="<?php echo $_SESSION["userid"]; ?>"/>
				<input type="text" class=" getjd"  name="jd.jd" value="<?php echo $_SESSION["user"]; ?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jd.php"  rel="ffyh" lookupGroup="jd">选择用户</a></td>
				
			<td >
					备注:
				<input type="text" name="remark" id="remark" style="width:150px;" value="<?php echo @$_POST["remark"];?>"/>
				</td><td><a class="button" id="addsk" target="ajax" rel="addlyskbox" onclick="sknewadd()"><span>添加</span></a></td>
			</tr>
		</table>
		
	</div></div>



	<div class="panelBar">
		<ul class="toolBar">
			<li>未下账数据</li>
		</ul>
	</div>
<!-- <form onsubmit="return divSearch(this, 'skcontent')"  rel="sscontent" action="ajax/skcontent.php?hotelid=<?php echo $hotel;?>" method="post" >  -->	
	<table class="searchContent">
			<tr>
				
				
			<td class="dateRange">
					日期：
					<input id="startDate"  class="date readonly" readonly="readonly" type="text"  value="<?php
					echo $firstday;?>">
					<span class="limit">-</span>
					<input id="endDate" class="date readonly" readonly="readonly" type="text" value="<?php echo $today;?>">
				</td>
				<td>团号：<input id="groupnum"  type="text" size="30" value="" /></td>
				<td>客人姓名：<input id="cusname"  type="text" size="30" value="" /></td>
				<td><a class="button" id="searchbutton" target="ajax" rel="addlyskbox" onclick="searchthis()"><span>搜索</span></a></td>
				</tr>
				</table>
	<input name="search"  type="hidden" size="30" value="yes"/>
		<input name="searchtype"  type="hidden" size="30" value="jdyfcx"/>
<!-- 	</form> -->


	<script src="ajax/gsxx/gsxx.js"></script>
	<div id="addlyskbox"></div>
	


	
	<div class="formBar cwglbtn"  >
			<ul>
				<li ><div class="buttonActive" ><div class="buttonContent"><button type="submit" >保存</button></div></div></li>
				<li ><div class="buttonActive" ><div class="buttonContent" ><button class="close " >关闭</button></div></div></li>
			</ul>
		</div>
		</form>
		
</div>