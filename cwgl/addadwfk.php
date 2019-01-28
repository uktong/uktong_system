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
    mysqli_query($con, "delete from t_travel where id=".$id);
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

function fknewadd(){
	var hotelid=$("#jdianfk").val();
	var gdmonth=$("#gdmonthfk option:selected").val();
	$("#addfk").attr("href","ajax/fkcontent.php?hotelid="+hotelid+"&gdmonth="+gdmonth);
}
function searchthis(){
	var hotelid=$("#jdianfk").val();
	var startDate=$("#sdatefk").val();
	var endDate=$("#edatefk").val();
	var groupnum=$("#groupnumfk").val();
	var cusname=$("#cusnamefk").val();
	var gdmonth=$("#gdmonthfk option:selected").val();
	$("#searchbutton").attr("href","ajax/fkcontent.php?search=yes&hotelid="+hotelid+"&startDate="+startDate+"&endDate="+endDate+"&groupnum="+groupnum+"&cusname="+cusname+"&gdmonth="+gdmonth);
}
//-->
</script>

<div class="pageContent">
<form method="post" action="db/addadwfk.php?action=charu" onsubmit="return validateCallback(this, dialogAjaxDone) " class="pageForm required-validate" >

<div class="pageHeader">
<h2 class="contentTitle" style="text-align: center;">新增按单位付款</h2>
		
	<div class="searchBar">
	
		<table class="searchContent" id="fftable"  cellspacing="0">
			<tr>
				<td >
					酒店:
				<input type="hidden" id="jdianfk" name="jdian555.id" value="<?php echo @$_POST["jdian555_id"];?>"/>
				<input type="text" class="getjdian555" oninput="getjdian(555);" name="jdian555.jdian555" value="<?php echo @$_POST["jdian555_jdian555"];?>" suggestFields="jdian555"   lookupGroup="jdian555" />
				<a class="btnLook" width="600" style="float: right; margin-right:30px;" href="ajax/dh/jdian.php?id=555" rel="ffjd" lookupGroup="jdian555">选择酒店</a>
				</td><td>	归档时间:
				<select name="gdmonth" id="gdmonthfk">
				<option value="">------</option>
				<?php for($m=1;$m<13;$m++){?>
				<option value="<?php echo $m;?>" <?php if($m==date("m")){echo "selected='selected'";}?>><?php echo $m;?>月</option>
				<?php }?>
				</select></td>
				<td >
					金额:
					<input type="hidden" name="havingmoney" id="fkhavingmoney" value="0">
				<input type="text" name="money" id="allmoney" onchange="$('#fklastmoney').html($(this).val());$('#fkhavingmoney').val($(this).val());"  style="width:100px;" value="<?php echo @$_POST["money"];?>"/>余额：<span id="fklastmoney">0</span>
				</td></tr>
<tr> 
				<td >
					方式:
					<select   name="paytype">
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
				</td>
				<td>日期：<input name="doDate" class="date readonly" readonly="readonly" type="text" value="<?php
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
			
				<td><span id="yue" style="color:red;"></span></td><td>付款人:<input type="hidden" name="jd.id" value="<?php echo $_SESSION["userid"]; ?>"/>
				<input type="text" class=" getjd"  name="jd.jd" value="<?php echo $_SESSION["user"]; ?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jd.php"  rel="ffyh" lookupGroup="jd">选择用户</a></td>
				
			<td >
					备注:
				<input type="text" name="remark" id="remark" style="width:150px;" value="<?php echo @$_POST["remark"];?>"/>
				</td>
				<td><a class="button" id="addfk" target="ajax" rel="fkcontent" onclick="fknewadd()"><span>添加</span></a></td>
			</tr>
		</table>
		
	</div></div>
	
<div class="panelBar">
		<ul class="toolBar">
			<li>未下账数据</li>
		</ul>
	</div>
	<table class="searchContent">
			<tr>
				
				
			<td class="dateRange">
					日期：
					<input name="startDate" id="sdatefk" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" id="edatefk" class="date readonly" readonly="readonly" type="text" value="<?php echo isset($_POST["endDate"])?$_POST["endDate"]:$today;?>">
				</td>
				<td>团号：<input  id="groupnumfk"  type="text" size="30" value="<?php echo @$_POST["groupnum"];?>" /></td>
				<td>客人姓名：<input  id="cusnamefk"   type="text" size="30" value="<?php echo @$_POST["cusname"];?>" /></td>
				<td><a class="button" id="searchbutton" target="ajax" rel="fkcontent" onclick="searchthis()"><span>搜索</span></a></td>
				
				</tr>
				</table>
	
	<div id="fkcontent"></div>
		<div class="formBar cwglbtn"  >
			<ul>
				<li ><div class="buttonActive" ><div class="buttonContent"><button type="submit" >保存</button></div></div></li>
				<li ><div class="buttonActive" ><div class="buttonContent" ><button class="close " >关闭</button></div></div></li>
			</ul>
		</div>
		</form>
		
</div>