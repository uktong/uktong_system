<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require $_SESSION["ROOT"].'/db/db.php';
?>
<script type="text/javascript" src="ajax/js/main.js">
<!--

//-->
</script>
<div class="pageContent">
	<form method="post" action="db/lydaiding.php?action=charu" id="daidingform" onsubmit="return validateCallback(this,navTabAjaxDone); " class="pageForm required-validate" >
		<div class="pageFormContent nowrap" layoutH="76" >
			<p>
				<label>我社团号：</label>
				系统自动生成
			
			</p>
				<p>
				<label>确认成团：</label>
				
				 <input type="checkbox" checked readonly name="chengtuan" />
			</p>
			<p>
				<label>计调：</label>
				<input type="hidden" name="jd.id" value="<?php echo $_SESSION["userid"]; ?>"/>
				<input type="text" class="required getjd" name="jd.jd" value="<?php echo $_SESSION["user"]; ?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" href="ajax/dh/jd.php" lookupGroup="jd">选择用户</a>
			</p>
			<p>
				<label>代订项目：</label>
				<input type="text" class="required" name="daiding" value="代订旅游" readonly/>
				
			</p>
			<p>
				<label>客人类型：</label>
				<input type="hidden" name="zts.id" id="gettravleadd" value="8"/>
				<input type="text" class="required getzts" readonly name="zts.zts" value="散客" suggestFields="zts"   lookupGroup="zts" />
			</p>
			
			<p>
			<label>客人：</label>
				<input type="text" name="krxx" id="krxx" class="longinput required" size="30" style="width: 50%;"  />
				</p>
			<p>
				<label>人数：</label>
				<input type="text" name="peoplenum" size="30" />
			</p>
			<p>
				<label>发团日期：</label>
				<input type="text" name="startDate" value="<?php 
			date_default_timezone_set('prc');
			echo date("Y-m-d",time());?>" class="date" size="30" readonly /><a class="inputDateButton" href="javascript:;">选择</a>
			</p>
			
			
			<p>
				<label>外联：</label>
				<input type="hidden" name="wl.id" value="<?php echo $_SESSION["userid"]; ?>"/>
				<input type="text" class="getwl"  name="wl.wl" value="<?php echo $_SESSION["user"]; ?>" suggestFields="wl"  lookupGroup="wl" />
				<a class="btnLook" href="ajax/dh/wl.php" lookupGroup="wl">选择用户</a>
			</p>
				
			<p>
				<label>预定时间：</label>
				<input type="text" name="odertDate" class="date" value="<?php echo date("Y-m-d");?>" readonly size="30" /><a class="inputDateButton" href="javascript:;">选择</a>
			</p>
			<div style="clear: both;">
			<label>备注：</label>
				<input type="text" class="longinput" name="remark" size="30"style="width: 50%;" />
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
function getxcjg(line){
	var hotelid=$(".getlxsid"+line+":eq(0)").val();
	var roomtype=$(".getxctype"+line+" option:selected").val();
	var travleid=$("#gettravleadd").val();
	var livedate=$(".livedate"+line+":eq(0)").val();
 	$.post("ajax/getlyjg.php",{hotel:hotelid,room:roomtype,travle:travleid,date:livedate},function(data){
// 		$(".changecount"+line+":eq(1)").val("111");
var resdata=JSON.parse(data); 
$(".changecount"+line+":eq(1)").val(resdata[0]);
$("#countjine"+line).html(resdata[0]);
$("#jine"+line).val(resdata[0]);
// $(".changecount"+line+":eq(3)").val(resdata[1]);
// $("#counttuank"+line).html(resdata[1]);
// $("#tuank"+line).val(resdata[1]);
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
// 	    alert($(".getjdian1").val()); 
// 	$('.getjdian1').bind('input propertychange', function() {  
// 	    alert($(this).val());
// 	});  
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
			<th align="center"   style="width:10.3%;">旅游供应商</th>
			<th align="center"  style="width:10%;">行程名字（协议价格）</th>
			<th align="center"  style="width:8%;">开始日期</th>
			<th align="center"   style="width:3%;">天数</th>
			<th align="center"  style="width:4%;">单价</th>
			<th align="center"  style="width:4%;">人数</th>
			<th align="center"  style="width:4%;">金额</th>
			<th align="center"  style="width:5%;">团款</th>
			<th align="center" style="width:4%;">团款合计</th>
			<th align="center"  style="width:10.8%;">客人姓名</th>
			<th align="center"   style="width:8%;">操作员</th>
			<th align="center" style="width:3.8%;">操作</th></tr>
			<?php for($i=1;$i<21;$i++){
			
			?>
		<tr id="line<?php echo $i;?>" class="tableline">
			<td>
			<?php echo $i;?>
			</td>
			<td  >
			<input type='hidden' name='lxs<?php echo $i;?>.id' id='lxs<?php echo $i;?>' value=''   class="getlxsid<?php echo $i; ?>" />
				<input type='text' oninput="getjgs('<?php echo $i; ?>')" class="getlxs<?php echo $i; ?>"  name='lxs<?php echo $i;?>.lxs<?php echo $i;?>' value='' style='width: 70%;' suggestFields='lxs<?php echo $i;?>'  lookupGroup='lxs<?php echo $i;?>' />
				<a class='btnLook' href='ajax/dh/lxs.php?id=<?php echo $i;?>' lookupGroup='lxs<?php echo $i;?>' >选择预定旅行社名称</a>
			
			</td>
			<td>
				<select  name="xctype<?php echo $i;?>.id" class="getxctype<?php echo $i;?>" style='width: 70%;' >
		<option value="">------</option>
	<?php 
	$getfjtype=mysqli_query($con, "select * from t_baseconfig where basenote=13 order by px desc");
	$fjtypere=mysqli_fetch_all($getfjtype,MYSQLI_ASSOC);
	for($f=0;$f<count($fjtypere);$f++){
	?>
	<option value="<?php echo $fjtypere[$f]["id"];?>"><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select><a class="btnAttach " onclick="getxcjg(<?php echo $i;?>)" style='cursor:pointer ' ><span>获取协议价格</span></a>
			</td>
			<td >
			<input type='text'  name='liveinDate<?php echo $i;?>' value="<?php echo date("Y-m-d");?>" readonly class='date livedate<?php echo $i; ?>' size='30' style='width: 70%;' /><a class='inputDateButton' href='javascript:;'>选择</a>
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
			<td>
		<input type='text' name="tk<?php echo $i;?>" class='changecount<?php echo $i;?>' onchange="count(<?php echo $i;?>)" value="0" size='30'style='width: 100%;' />
			</td>
			<td >
			<input type='hidden' size='30' name="tuank<?php echo $i;?>" id="tuank<?php echo $i;?>" value="0"  style='width: 100%;'/>
			<span id="counttuank<?php echo $i;?>">0</span>
			</td>
			<td>
			<input type='text' size='30' class="krxm" name="cusname<?php echo $i;?>"  style='width: 100%;'/>
			
			</td>
			<td ><input type='hidden' name='douser<?php echo $i;?>.id' value='<?php echo $_SESSION["userid"]; ?>'/>
				<input type='text' oninput="getdouser('<?php echo $i; ?>')"  name='douser<?php echo $i;?>.douser<?php echo $i;?>' readonly value='<?php echo $_SESSION["user"]; ?>'style='width: 60%;' suggestFields='douser<?php echo $i;?>'  lookupGroup='douser<?php echo $i;?>' />
				<a class='btnLook' href="ajax/dh/douser.php?id=<?php echo $i;  ?>" lookupGroup='douser<?php echo $i;?>'>查找带回</a>
			</td>
			<td >
			<a onclick='deletethis(<?php echo $i;?>)' class="btnDel" style='cursor:pointer'>删除</a>
			 </td>
			 </tr>
			<?php }?>
		<tr style="background:#E0ECFF;height:20px;" id="newline">
			<th align="center"  style="width:3.8%;">合计</th>
			<th align="center"   style="width:10.3%;"> </th>
			<th align="center"  style="width:8%;"> </th>
			<th align="center"  style="width:7%;">  </th>
			<th align="center"   style="width:3%;"> </th>
			<th align="center"  style="width:4%;"> </th>
			<th align="center"  style="width:4%;"> </th>
			<th align="center"  style="width:4%;" id="alljine">0</th>
			<th align="center" style="width:4%;"> </th>
			<th align="center"  style="width:5%;" id="alltuank">0</th>
			<th align="center"  style="width:10.8%;"> </th>
			<th align="center"   style="width:8%;"> </th>
			<th align="center" style="width:3.8%;"> </th></tr>
		
			<tr>
				</table>
			
		
		</div>

		<div class="formBar cwglbtn">
			<ul>
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit" >保存</button></div></div></li>
				<li>
					<div class="buttonActive"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>
