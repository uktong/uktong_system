<?php 
session_start();
require_once $_SESSION["ROOT"].'/db/db.php';
$jddiancode=$_SESSION["hotelcode"];
$jddiansql=mysqli_query($con, "select hotelname,id from t_allhotel where hotelcode='".$jddiancode."'");
$jddian=mysqli_fetch_array($jddiansql);

?>
<script type="text/javascript" src="ajax/js/main.js">
<!--

//-->
</script>
<div class="pageContent">
	<form method="post" action="db/daiding.php?action=charu" class="pageForm required-validate" onsubmit="return validateCallback(this,navTabAjaxDone);">
		<div class="pageFormContent" layoutH="56" >
			<p>
				<label>团号：</label>
				系统自动生成
			
			</p>
			
				<p style="display: none;">
				<label>确认成团：</label>
				
				 <input type="checkbox" checked readonly name="chengtuan" />
			</p>
			<p>
				<label>对接人：</label>
				<input type="hidden" name="jd.id" value=""/>
				<input type="text" class="required getjd" name="jd.jd" value="" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" href="ajax/dh/jd.php" lookupGroup="jd">选择用户</a>
			</p>
			<p>
				<label>系统状态：</label>
				已成团	
			</p>
			<p style="display: none;">
				<label>代订项目：</label>
				<input type="text" class="required" name="daiding" value="代订酒店" readonly/>
				
			</p>
			<p>
				<label>发团日期：</label>
				<input type="text" name="startDate" value="<?php 
			date_default_timezone_set('prc');
			echo date("Y-m-d",time());?>" class="date" size="30" readonly /><a class="inputDateButton" href="javascript:;">选择</a>
			</p>
			<p>
			<label>散团日期：</label>
				<input type="text" name="endtDate" value="<?php echo date("Y-m-d",strtotime("+1 day"));?>" readonly class="date" size="30" /><a class="inputDateButton" href="javascript:;">选择</a>
			</p>
<!-- 			<p> -->
<!-- 				<label>组团社：</label> -->
<!-- 				<input type="hidden" name="zts.id" value="${zts.id}"/> -->
<!-- 				<input type="text" class="required getzts" name="zts.zts" value="" suggestFields="zts"   lookupGroup="zts" /> -->
<!-- 				<a class="btnLook" href="ajax/dh/zts.php" lookupGroup="zts">选择组团社</a> -->
<!-- 			</p> -->
<!-- 			<p> -->
<!-- 				<label>组团社团号：</label> -->
<!-- 				<input type="text" name="ztsth" size="30" /> -->
<!-- 			</p> -->
<!-- 			<p> -->
<!-- 				<label>联系人：</label> -->
<!-- 				<input type="hidden" name="lxr.id" value="${lxr.id}"/> -->
<!-- 				<input type="text"  class="getlxr" name="lxr.lxr" value="" suggestFields="lxr"  lookupGroup="lxr" /> -->
<!-- 				<a class="btnLook" href="ajax/dh/lxr.php" lookupGroup="lxr">选择联系人</a> -->
<!-- 			</p> -->
			<p>
				<label>人数：</label>
				<input type="text" name="peoplenum" size="30" />
			</p>
<!-- 			<p> -->
<!-- 				<label>外联：</label> -->
<!-- 				<input type="hidden" name="wl.id" value=""/> -->
<!-- 				<input type="text" class="getwl required"  name="wl.wl" value="" suggestFields="wl"  lookupGroup="wl" /> -->
<!-- 				<a class="btnLook" href="ajax/dh/wl.php" lookupGroup="wl">选择用户</a> -->
<!-- 			</p> -->
			<p>
				<label>备注：</label>
				<input type="text" class="longinput" name="remark" size="30"style="width: 50%;" />
			</p></br>
			<p>
				<label>预定时间：</label>
				<input type="text" name="odertDate" class="date" value="<?php echo date("Y-m-d");?>" readonly size="30" /><a class="inputDateButton" href="javascript:;">选择</a>
			</p>
			<div style="clear: both;">
			<label>客人：</label>
				<input type="text" name="krxx" id="krxx" class="longinput" size="30" style="width: 50%;"  />
			</div>
	
			<script type="text/javascript">

$(".tableline").hide();
var line=4;
$(".tableline").slice(0,4).show();
function showtable(line){

	$(".tableline").slice(0,line).show();
}
function deletethis(line){
$("#line"+line).remove();
	
}
function count(id){
	var jine=parseFloat($(".changecount"+id+":eq(0)").val())*parseFloat($(".changecount"+id+":eq(1)").val())*parseFloat($(".changecount"+id+":eq(2)").val());
	$("#countjine"+id).html(jine);
	$("#jine"+id).val(jine);
	var tuank=parseFloat($(".changecount"+id+":eq(0)").val())*parseFloat($(".changecount"+id+":eq(2)").val())*parseFloat($(".changecount"+id+":eq(3)").val());
	$("#counttuank"+id).html(tuank);
	$("#tuank"+id).val(tuank);
	var alljine=0;
	var alltuank=0;
	
	for(i=1;i<21;i++){
	alljine += parseFloat($("#jine"+i).val());
	alltuank += parseFloat($("#tuank"+i).val());
		}
	$("#alljine").html(alljine);
	$("#alltuank").html(alltuank);
}

function getxyjg(line){
	var hotelid=$(".getjdid"+line+":eq(0)").val();
	var roomtype=$(".getfjtype"+line+" option:selected").val();
	var travleid=$("#gettravleadd").val();
	var livedate=$(".livedate"+line+":eq(0)").val();
 	$.post("ajax/getxyjg.php",{hotel:hotelid,room:roomtype,travle:travleid,date:livedate},function(data){
// 		$(".changecount"+line+":eq(1)").val("111");
var resdata=JSON.parse(data); 

$(".changecount"+line+":eq(1)").val(resdata[0]);
$("#countjine"+line).html(resdata[0]);
$("#jine"+line).val(resdata[0]);
$(".changecount"+line+":eq(3)").val(resdata[1]);
$("#counttuank"+line).html(resdata[1]);
$("#tuank"+line).val(resdata[1]);
var alljine=0;
var alltuank=0;

for(i=1;i<21;i++){
alljine += parseFloat($("#jine"+i).val());
alltuank += parseFloat($("#tuank"+i).val());
 	}
$("#alljine").html(alljine);
$("#alltuank").html(alltuank);
 		});
}
function checkzts(){
	if($('#gettravleadd').val()==""){
		alert("请选择组团社！");
	}
	
	}

$(function(){
//    alert($(".getjdian1").val()); 
//$('.getjdian1').bind('input propertychange', function() {  
//    alert($(this).val());
//});  
$("#krxx").change(function(){
$(".krxm").val($("#krxx").val());
});


});
	


	</script>
			<div style="clear: both;">
				<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="javascript:line=line+1;showtable(line);" ><span>添加预定安排</span></a></li>
			
		</ul>
	</div>
			</div>
			<table class="table" width="100%" layoutH="138"  style="word-break:break-all; word-wrap:break-all;">
<tr style="background:#E0ECFF;height:20px;">
			<th align="center"  style="width:3.8%;">序号</th>
			<th align="center"   style="width:10.3%;">酒店名称</th>
			<th align="center"  style="width:8%;">房间类型</th>
			<th align="center"  style="width:7%;">入住日期</th>
			<th align="center"   style="width:3%;">天数</th>
			<th align="center"  style="width:4%;">单价</th>
			<th align="center"  style="width:4%;">数量</th>
			<th align="center"  style="width:4%;">金额</th>
			<th align="center" style="display: none;" style="width:5%;">团款</th>
			<th align="center" style="display: none;" style="width:4%;">团款合计</th>
			<th align="center"   style="width:4%;">路早</th>
			<th align="center"  style="width:10.8%;">客人姓名</th>
			<th align="center"   style="width:8%;">操作员</th>
			<th align="center" style="width:3.8%;">删除</th></tr>
			<?php for($i=1;$i<21;$i++){
			
			?>
		<tr id="line<?php echo $i;?>" class="tableline">
			<td>
			<?php echo $i;?>
			</td>
			<td  >
			<input type='hidden' name='jdian<?php echo $i;?>.id' value='<?php echo  $jddian["id"];?>'/>
				<input type='text' oninput="getjdian('<?php echo $i; ?>')" 
				class="getjdian<?php echo $i; ?>" readonly name='jdian<?php echo $i;?>.jdian<?php echo $i;?>' value='<?php echo $jddian["hotelname"];?>' style='width: 70%;' suggestFields='jdian<?php echo $i;?>'  lookupGroup='jdian<?php echo $i;?>' />
				
			
			</td>
			<td>
				<select  name="fjtype<?php echo $i;?>.id" class="getfjtype<?php echo $i;?>" style='width: 70%;' >
		<option value=""></option>
	<?php 
	$getfjtype=mysqli_query($con, "select * from t_baseconfig where basenote=2 order by px desc");
	$fjtypere=mysqli_fetch_all($getfjtype,MYSQLI_ASSOC);
	for($f=0;$f<count($fjtypere);$f++){
	?>
	<option value="<?php echo $fjtypere[$f]["id"];?>"><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select></td>
			<td >
			<input type='text' name='liveinDate<?php echo $i;?>' value="<?php echo date("Y-m-d");?>" readonly class='date' size='30' style='width: 80%;' /><a class='inputDateButton' href='javascript:;'>选择</a>
			</td>
			<td >
			<input type='text' value="1" name="tianshu<?php echo $i;?>" onchange="count(<?php echo $i;?>)"  class='changecount<?php echo $i;?>' size='30'style='width: 100%;' />
			</td>
			<td >
			<input type='text' name="danjia<?php echo $i;?>" class='changecount<?php echo $i;?>' onchange="count(<?php echo $i;?>)"  value="0" size='30'style='width: 100%;' />
			</td>
			<td >
			<input type='text' name="shuliang<?php echo $i;?>" class='changecount<?php echo $i;?>' onchange="count(<?php echo $i;?>)"  value="1" size='30'style='width: 100%;' />
			</td>
			<td >
			<input type='hidden' size='30' name="jine<?php echo $i;?>" id="jine<?php echo $i;?>" value="0"  style='width: 100%;'/>
			<span id="countjine<?php echo $i;?>">0</span>
			</td>
			<td style="display: none;">
		<input type='text'  name="tk<?php echo $i;?>" class='changecount<?php echo $i;?>' onchange="count(<?php echo $i;?>)" value="0" size='30'style='width: 100%;' />
			</td>
			<td style="display: none;">
			<input type='hidden' size='30' name="tuank<?php echo $i;?>" id="tuank<?php echo $i;?>" value="0"  style='width: 100%;'/>
			<span id="counttuank<?php echo $i;?>">0</span>
			</td>
			<td>
			<input type='checkbox' name="luzao<?php echo $i;?>" />
			</td>
			<td>
			<input type='text' size='30' class="krxm" name="cusname<?php echo $i;?>"  style='width: 100%;'/>
			
			</td>
			<td ><input type='hidden' name='douser<?php echo $i;?>.id' value='<?php echo $_SESSION["userid"]; ?>'/>
				<input type='text' oninput="getdouser('<?php echo $i; ?>')"  name='douser<?php echo $i;?>.douser<?php echo $i;?>' readonly value='<?php echo $_SESSION["user"]; ?>'style='width: 70%;' suggestFields='douser<?php echo $i;?>'  lookupGroup='douser<?php echo $i;?>' />
				<a class='btnLook' style="display: none;" href="ajax/dh/douser.php?id=<?php echo $i;  ?>" lookupGroup='douser<?php echo $i;?>'>查找带回</a>
			</td>
			<td >
			<a onclick='deletethis(<?php echo $i;?>)' style='cursor:pointer'>删除</a>
			 </td>
			 </tr>
			<?php }?>
		<tr style="background:#E0ECFF;height:20px;" id="newline">
			<th align="center"  style="width:3.8%;">合计</th>
			<th align="center"   style="width:10.3%;"> </th>
			<th align="center"  style="width:8%;"> </th>
			<th align="center"  style="width:7%;">  </th>
			<th align="center"    style="width:3%;"> </th>
			<th align="center"  style="width:4%;"> </th>
			<th align="center"  style="width:4%;"> </th>
			<th align="center"  style="width:4%;" id="alljine">0</th>
			<th align="center" style="display: none;" style="width:4%;"> </th>
			<th align="center" style="display: none;" style="width:5%;" id="alltuank">0</th>
			<th align="center"   style="width:4%;"> </th>
			<th align="center"  style="width:10.8%;"> </th>
			<th align="center"   style="width:8%;"> </th>
			<th align="center" style="width:3.8%;"> </th></tr>
		
			<tr>
				</table>
			
		
		</div>

		<div class="formBar">
			<ul>
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>
