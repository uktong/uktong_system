<?php 
session_start();
require_once $_SESSION["ROOT"].'/db/db.php';
$jddiancode=$_SESSION["hotelcode"];
$jddiansql=mysqli_query($con, "select id from t_travel where travel_code='".$jddiancode."'");
$jddian=mysqli_fetch_array($jddiansql);

?>
<script type="text/javascript" src="ajax/js/main.js">
<!--

//-->
</script>
<div class="pageContent">
	<form method="post" action="db/daiding.php?action=charu" class="pageForm required-validate" onsubmit="return validateCallback(this,navTabAjaxDone);">
		<div class="pageFormContent" layoutH="96" >
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
				<label>首晚入住日期：</label>
				<input type="text" name="startDate" value="<?php 
			date_default_timezone_set('prc');
			echo date("Y-m-d",time());?>" class="date" size="30" readonly /><a class="inputDateButton" href="javascript:;">选择</a>
			</p>
			<p>
			<label>离店日期：</label>
				<input type="text" name="endtDate" value="<?php echo date("Y-m-d",strtotime("+1 day"));?>" readonly class="date" size="30" /><a class="inputDateButton" href="javascript:;">选择</a>
			</p>
			<input type="hidden" name="zts.id" value="<?php 
			echo $jddian['id'];
			?>"/>
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
var line=0;
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
				<div class="panelBar" style="display:none;">
		<ul class="toolBar" >
			<li><a class="add" href="javascript:line=line+1;showtable(line);" ><span>添加预定安排</span></a></li>
			
		</ul>
	</div>
			</div>
			
			
		
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
