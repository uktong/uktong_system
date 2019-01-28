<?php
session_start();
date_default_timezone_set('prc');
require $_SESSION["ROOT"].'/db/db.php';
$id=$_GET["id"];
$result=mysqli_query($con, "select * from t_groupmanage where teamNumber='".$id."'");
$arrayresult=mysqli_fetch_array($result);

?>
<script type="text/javascript" src="ajax/js/main.js">
<!--

//-->
</script>
<div class="pageContent">
	<form method="post" action="db/daiding.php?action=edit&id=<?php echo $arrayresult['teamNumber']; ?>" class="pageForm required-validate" onsubmit="return validateCallback(this,navTabAjaxDone); ">
		<div class="pageFormContent" layoutH="96" >
			<p>
				<label>我社团号：</label>
				<?php echo $arrayresult['teamNumber'];?>
			</p> 
			<p>
				<label>对接人：</label>
				<input type="hidden" name="jd.id" value="<?php echo $arrayresult['jd']; ?>"/>
				<input type="text" class="required getjd" name="jd.jd" value="<?php
				$jdsql=mysqli_query($con, "select username from t_user where id=".$arrayresult['jd']);
				$jd=mysqli_fetch_array($jdsql);
				echo $jd['username'];
				?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" href="ajax/dh/jd.php" lookupGroup="jd">选择用户</a>
 
			</p>
			<p>
				<label>系统状态：</label>
				    <span style='color:green;'>已成团</span>
			</p>
<!-- 			<p> -->
<!-- 				<label>代订项目：</label> -->
<!-- 				代订酒店 -->
				
<!-- 			</p> -->
			<p>
				<label>发团日期：</label>
				<input type="text" name="startDate" value="<?php echo $arrayresult['startDate'];?>" class="date" size="30" readonly /><a class="inputDateButton" href="javascript:;">选择</a>
				
			</p>
			<p>
			<label>散团日期：</label>
			
			<input type="text" name="endtDate" value="<?php echo $arrayresult['endDate'];?>" readonly class="date" size="30" /><a class="inputDateButton" href="javascript:;">选择</a>
			</p>
			<p>
				<label>人数：</label>
				
					<input type="text"  name="peoplenum" value="<?php echo $arrayresult['guestnum'];?>" size="30" />
			</p>
			<p>
				
				<label>备注：</label>
				<input type="text" class="longinput" name="remark" value="<?php 
				echo $arrayresult['remark'];
				?>" size="30"style="width: 50%;" />
			</p>
			<p>
				<label>预定时间：</label>
				<?php 
				echo $arrayresult['enteringDate'];
				?>
			</p>
			
			
				
		
		
			<div style="clear: both;">
			<label>客人：</label>
				<input type="text" name="krxx" id="krxx" class="longinput" size="30" value="<?php 
				echo $arrayresult['guest'];
				?>" style="width: 50%;"  />
			
			</div>
			<?php 
			$yudingsql=mysqli_query($con, "select * from t_reserveplan where groupNumber='".$arrayresult['teamNumber']."'");
			$yudingline=mysqli_num_rows($yudingsql);
			$yuding=mysqli_fetch_all($yudingsql,MYSQLI_ASSOC);
			?>
			<script type="text/javascript">
			$(".tablelineedit").hide();
			var line=0;
			$(".tablelineedit").slice(0,0).show();
			function showtable(line){

				$(".tablelineedit").slice(0,line).show();
			}
			function deletethis(line){
			$("#lineedit"+line).remove();
				
			}
function deletethis(line){
$("#lineedit"+line).remove();
	
}
function counte(id){
	var jine=parseFloat($(".changecounte"+id+":eq(0)").val())*parseFloat($(".changecounte"+id+":eq(1)").val())*parseFloat($(".changecounte"+id+":eq(2)").val());
	$("#countjinee"+id).html(jine);
	$("#jinee"+id).val(jine);
	var tuank=parseFloat($(".changecounte"+id+":eq(0)").val())*parseFloat($(".changecounte"+id+":eq(2)").val())*parseFloat($(".changecounte"+id+":eq(3)").val());
	$("#counttuanke"+id).html(tuank);
	$("#tuanke"+id).val(tuank);
	var alljine=0;
	var alltuank=0;
	
	for(i=1;i<21;i++){
	alljine += parseFloat($("#jinee"+i).val());
	alltuank += parseFloat($("#tuanke"+i).val());
		}
	$("#alljine").html(alljine);
	$("#alltuank").html(alltuank);
}
function getxyjg(line){
	var hotelid=$(".getjdide"+line+":eq(0)").val();
	var roomtype=$(".getfjtypee"+line+" option:selected").val();
	var travleid=$("#gettravleedit").val();
	var livedate=$(".livedatee"+line+":eq(0)").val();
 	$.post("ajax/getxyjg.php",{hotel:hotelid,room:roomtype,travle:travleid,date:livedate},function(data){
// 		$(".changecount"+line+":eq(1)").val("111");
var resdata=JSON.parse(data); 

$(".changecounte"+line+":eq(1)").val(resdata[0]);
$("#countjinee"+line).html(resdata[0]);
$("#jinee"+line).val(resdata[0]);
$(".changecounte"+line+":eq(3)").val(resdata[1]);
$("#counttuanke"+line).html(resdata[1]);
$("#tuanke"+line).val(resdata[1]);
var alljine=0;
var alltuank=0;

for(i=1;i<21;i++){
alljine += parseFloat($("#jinee"+i).val());
alltuank += parseFloat($("#tuanke"+i).val());
	}
$("#alljine").html(alljine);
$("#alltuank").html(alltuank);
		});
}
function checkzts(){
	if($('#gettravleedit').val()==""){
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
		

				<script type="text/javascript">

	</script>
		</div>

		<div class="formBar">
			<ul>
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close">关闭</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>
</div>