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
		<div class="pageFormContent" layoutH="56" >
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
			<p>
				<label>客人：</label>
				<input type="text" name="krxx" id="krxx" class="longinput" size="30" value="<?php 
				echo $arrayresult['guest'];
				?>" style="width: 50%;"  />
					</p>
			
				
		
		
			<div style="clear: both;">
				<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="javascript:line=line+1;showtable(line);" ><span>添加预定安排</span></a></li>
			
		</ul>
	</div>
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
			<th align="center"   style="width:4%;">路早</th>
			<th align="center"  style="width:10.8%;">客人姓名</th>
			<th align="center"   style="width:8%;">操作员</th>
			<th align="center" style="width:3.8%;">操作</th></tr>
			<?php
		
			$alljine=0.00;
			$alltuank=0.00;
			    for($a=0;$a<count($yuding);$a++){
			?>
		<tr id="lineedit<?php echo $a;?>" class="tableline">
			<td>
			<?php echo $a+1;?>
			</td>
			<td><input type="hidden"/>
			<input type='hidden' name='jdian<?php echo $a+1;?>.id' class="getjdide<?php echo $a+1; ?>" value='<?php echo $yuding[$a]['hotelName'];?>'/>
				<input type='text' oninput="getjdian('<?php echo $a+1; ?>')" class="getjdian<?php echo $a+1; ?>"
				 name='jdian<?php echo $a+1;?>.jdian<?php echo $a+1;?>' value='<?php 
				 $hotelsql=mysqli_query($con, "select hotelname from t_allhotel where id=".$yuding[$a]['hotelName']);
			$hotel=mysqli_fetch_array($hotelsql);
			echo $hotel["hotelname"];
			?>' style='width: 70%;' suggestFields='jdian<?php echo $a+1;?>' readonly  lookupGroup='jdian<?php echo $a+1;?>' />
			
			</td>
			<td>
			
				<select  name="fjtype<?php echo $a+1;?>.id" class="getfjtypee<?php echo $a+1;?>" style='width: 70%;'>
		<option value=""></option>
	<?php 
	$getfjtype=mysqli_query($con, "select * from t_baseconfig where basenote=2 order by px desc");
	$fjtypere=mysqli_fetch_all($getfjtype,MYSQLI_ASSOC);
	for($f=0;$f<count($fjtypere);$f++){
	?>
	<option value="<?php echo $fjtypere[$f]["id"];?>" <?php echo $yuding[$a]["roomType"]==$fjtypere[$f]["id"]?"selected='selected'":"";?>><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select>
			</td>
			<td >
			<input type='text' name='liveinDate<?php echo $a+1;?>' value="<?php echo $yuding[$a]['startDate'];?>"
			 readonly class='date livedatee<?php echo $a+1;?>' size='30' style='width: 70%;' /><a class='inputDateButton' href='javascript:;'>选择</a>
			</td>
			<td >
			<input type='text' value="<?php echo $yuding[$a]['dayNum']; ?>" name="tianshu<?php echo $a+1;?>" onchange="counte(<?php echo $a+1;?>)"  class='changecounte<?php echo $a+1;?>' size='30'style='width: 100%;' />
			</td>
			<td >
			<input type='text' name="danjia<?php echo $a+1;?>" class='changecounte<?php echo $a+1;?>' onchange="counte(<?php echo $a+1;?>)"  value="<?php echo $yuding[$a]['costPrice']; ?>" size='30'style='width: 100%;' />
			
			
			</td>
			<td >
			<input type='text' name="shuliang<?php echo $a+1;?>" class='changecounte<?php echo $a+1;?>' onchange="counte(<?php echo $a+1;?>)"  value="<?php echo $yuding[$a]['number']; ?>" size='30'style='width: 100%;' />
			
			
			</td>
			<td >
			<input type='hidden' size='30' name="jine<?php echo $a+1;?>" id="jinee<?php echo $a+1;?>" value="<?php echo $yuding[$a]['hotelCommissionSum']; ?>"  style='width: 100%;'/>
			<span id="countjinee<?php echo $a+1;?>"><?php echo $yuding[$a]['hotelCommissionSum']; ?></span>
			
			</td>
			<td>
			<input type='checkbox' <?php 
			    echo $yuding[$a]['breakfast']!="1" ? "":"checked";
			    
			?> name="luzao<?php echo $a+1;?>" />
			</td>
			<td>
			<input type='text' size='30' name="cusname<?php echo $a+1;?>" value="<?php 
			    echo $yuding[$a]['guestName'];
			    
			?>"  style='width: 100%;'/>
			
			</td>
			<td ><input type='hidden' name='douser<?php echo $a+1;?>.id' value='<?php
			if(strpos($arrayresult['teamNumber'], $_SESSION["hotelcode"])){
			    $dosql=mysqli_query($con, "select username from t_hoteluser where id=".$arrayresult['jd']);
			    
			}else{
			    $dosql=mysqli_query($con, "select username from t_user where id=".$arrayresult['jd']);
			}
			
			echo $yuding[$a]['manageUser']; ?>'/>
				<input type='text' oninput="getdouser('<?php echo $a+1; ?>')"  name='douser<?php echo $a+1;?>.douser<?php echo $a+1;?>'
				 readonly value='<?php 
				 $do=mysqli_fetch_array($dosql);
				 echo $do['username'];?>'style='width: 70%; ' readonly suggestFields='douser<?php echo $a+1;?>' 
				  lookupGroup='douser<?php echo $a+1;?>' />
			</td>
<td >
			<a onclick='deletethis(<?php echo $a+1;?>)' class="btnDel" style='cursor:pointer'>删除</a>
			 </td>
			
			 </tr>
			<?php 
			$alljine+=$yuding[$a]['hotelCommissionSum'];
			$alltuank+=$yuding[$a]['sumPrice'];
			    }?>
			    <?php for($i=count($yuding)+1;$i<21;$i++){
			
			?>
		<tr id="lineedit<?php echo $i;?>" class="tablelineedit">
			<td>
			<?php echo $i;?>
			</td>
			<td  >
			<input type='hidden' name='jdian<?php echo $i;?>.id' value='' class="getjdide<?php echo $i; ?>" />
				<input type='text' oninput="getjdian('<?php echo $i; ?>')" class="getjdian<?php echo $i; ?>" readonly  name='jdian<?php echo $i;?>.jdian<?php echo $i;?>' value='' style='width: 70%;' suggestFields='jdian<?php echo $i;?>'  lookupGroup='jdian<?php echo $i;?>' />
			
			</td>
			<td>
			<select  name="fjtype<?php echo $i;?>.id" class="getfjtypee<?php echo $i;?>" style='width: 70%;'>
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
			<input type='text' name='liveinDate<?php echo $i;?>' value="<?php echo date("Y-m-d");?>" readonly class='date livedatee<?php echo $i;?>' size='30' style='width: 70%;' /><a class='inputDateButton' href='javascript:;'>选择</a>
			</td>
			<td >
			<input type='text' value="1" name="tianshu<?php echo $i;?>" onchange="counte(<?php echo $i;?>)"  class='changecounte<?php echo $i;?>' size='30'style='width: 100%;' />
			</td>
			<td >
			<input type='text' name="danjia<?php echo $i;?>" class='changecounte<?php echo $i;?>' onchange="counte(<?php echo $i;?>)"  value="0" size='30'style='width: 100%;' />
			</td>
			<td >
			<input type='text' name="shuliang<?php echo $i;?>" class='changecounte<?php echo $i;?>' onchange="counte(<?php echo $i;?>)"  value="1" size='30'style='width: 100%;' />
			</td>
			<td >
			<input type='hidden' size='30' name="jine<?php echo $i;?>" id="jinee<?php echo $i;?>" value="0"  style='width: 100%;'/>
			<span id="countjinee<?php echo $i;?>">0</span>
			</td>
			<td>
	
			<td>
			<input type='checkbox' name="luzao<?php echo $i;?>" />
			</td>
			<td>
			<input type='text' size='30' class="krxm" name="cusname<?php echo $i;?>" value="<?php 
				echo $arrayresult['guest'];
				?>"  style='width: 100%;'/>
			
			</td>
			<td ><input type='hidden' name='douser<?php echo $i;?>.id' value='<?php echo $_SESSION["userid"]; ?>'/>
				<input type='text' oninput="getdouser('<?php echo $i; ?>')" readonly  name='douser<?php echo $i;?>.douser<?php echo $i;?>' readonly value='<?php echo $_SESSION["user"]; ?>'style='width: 70%;' suggestFields='douser<?php echo $i;?>'  lookupGroup='douser<?php echo $i;?>' />
			</td>
			<td >
			<a onclick='deletethis(<?php echo $i;?>)' class="btnDel" style='cursor:pointer'>删除</a>
			 </td>
			 </tr>
			<?php }?>
		<tr style="background:#E0ECFF;height:20px;" id="newline">
		
			</tr>
		<tr style="background:#E0ECFF;height:20px;" id="newline">
			<th align="center"  style="width:3.8%;">合计</th>
			<th align="center"   style="width:10.3%;"> </th>
			<th align="center"  style="width:8%;"> </th>
			<th align="center"  style="width:7%;">  </th>
			<th align="center"   style="width:3%;"> </th>
			<th align="center"  style="width:4%;"> </th>
			<th align="center"  style="width:4%;"> </th>
			<th align="center"  style="width:4%;" id="alljine"><?php echo $alljine;?></th>
			<th align="center"   style="width:4%;"> </th>
			<th align="center"  style="width:10.8%;"> </th>
			<th align="center"   style="width:8%;"> </th>
			<th align="center"   style="width:8%;"> </th>
</tr>
		
			<tr>
		
				</table>

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