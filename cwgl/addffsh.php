<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';


require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$today= date("Y-m-d");
$todaydate=date("Y-m");
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
function newadd(){
	var hotelid=$("#jdian").val();
	var money=$("#money").val();
	var date=$("#date").val();
	$("#add").attr("href","ajax/sscontent.php?hotelid="+hotelid+"&money="+money+"&date="+date);
}

//-->
</script>
<style>
<!--

-->
</style>


<form method="post" action="db/addffsh.php?action=charu" onsubmit="return validateCallback(this, dialogAjaxDone) " class="pageForm required-validate" >
<div class="pageHeader">
<h2 class="contentTitle" style="text-align: center;">新增房费审核</h2>
		
	<div class="searchBar">
	
		<table class="searchContent" id="fftable"  cellspacing="0">
			<tr>
				<td >
					酒店:
				<input type="hidden" id="jdian" name="jdian555.id" value="<?php echo @$_POST["jdian555_id"];?>"/>
				<input type="text" class="getjdian555" oninput="getjdian(555);" name="jdian555.jdian555" value="<?php echo @$_POST["jdian555_jdian555"];?>" suggestFields="jdian555"   lookupGroup="jdian555" />
				<a class="btnLook" width="600" style="float: right; margin-right:30px;" href="ajax/dh/jdian.php?id=555" rel="ffjd" lookupGroup="jdian555">选择酒店</a>
				</td>
				<td >
					归档时间:
				<select name="shmonth" id="shmonth" >
				<option value="">------</option>
				<?php for($m=1;$m<13;$m++){?>
				<option value="<?php echo $m;?>"><?php echo $m;?>月</option>
				<?php }?>
				</select>
				</td>
				
				<td >
					金额:
					<input type="hidden" name="havingmoney" id="havingmoney" value="0">
				<input type="text" name="money" onchange="$('#lastmoney').html($(this).val());$('#havingmoney').val($(this).val());" id="money" style="width:100px;" value="<?php echo @$_POST["money"];?>"/>余额：<span id="lastmoney">0</span>
				</td></tr><tr>
				<td>日期:<input name="doDate" id="date" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$today;?>"></td>
					<td >
					备注:
				<input type="text" name="remark" id="remark" style="width:100px;" value="<?php echo @$_POST["remark"];?>"/>
				</td>
				<td><a class="button" id="add" target="ajax" rel="sscontent" onclick="newadd()"><span>添加</span></a></td>
			</tr>
		</table>
		
	</div></div>
	<div class="panelBar">
		<ul class="toolBar">
			<li>未审核账目</li>
		</ul>
	</div>
<table class="searchContent">
			<tr>
				
				
			<td class="dateRange">
					日期：
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value="<?php echo isset($_POST["endDate"])?$_POST["endDate"]:$today;?>">
				</td>
				<td>团号：<input name="groupnum"  type="text" size="30" value="<?php echo @$_POST["groupnum"];?>" /></td>
				<td>客人姓名：<input name="cusname"  type="text" size="30" value="<?php echo @$_POST["cusname"];?>" /></td>
				<td><button type="submit">搜索</button></td>
				</tr>
				</table>
	<input name="search"  type="hidden" size="30" value="yes"/>
	
	<div id="sscontent"></div>
			<div class="formBar cwglbtn"  >
			<ul>
				<li ><div class="buttonActive" ><div class="buttonContent"><button type="submit" >保存</button></div></div></li>
				<li ><div class="buttonActive" ><div class="buttonContent" ><button class="close " >关闭</button></div></div></li>
			</ul>
		</div>

			</form>

