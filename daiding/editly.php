<?php
session_start();
date_default_timezone_set('prc');
require $_SESSION["ROOT"].'/db/db.php';
$id=$_GET["id"];
$result=mysqli_query($con, "select * from t_groupmanage where id='".$id."'");
$arrayresult=mysqli_fetch_array($result);

?>
<script type="text/javascript" src="ajax/js/main.js">
<!--

//-->
</script>
<div class="pageContent">
	<form method="post" action="db/lydaiding.php?action=edit&id=<?php echo $arrayresult['teamNumber']; ?>" class="pageForm required-validate" onsubmit="return validateCallback(this,navTabAjaxDone); ">
		<div class="pageFormContent" layoutH="56" >
			<p>
				<label>我社团号：</label>
				<?php echo $arrayresult['teamNumber'];?>
			</p> 
			<p>
				<label>计调：</label>
				<input type="hidden" name="jd.id" value="<?php echo $arrayresult['jd']; ?>"/>
				<input type="text" class="required getjd" name="jd.jd" value="<?php
				$jdsql=mysqli_query($con, "select username from t_user where id=".$arrayresult['jd']);
				$jd=mysqli_fetch_array($jdsql);
				echo $jd['username'];
				?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" href="ajax/dh/jd.php" lookupGroup="jd">选择用户</a>
 
			</p>
			<p>
				<label>代订项目：</label>
				代订旅游
				
			</p>
			<p>
				<label>发团日期：</label>
				<input type="text" name="startDate" value="<?php echo $arrayresult['startDate'];?>" class="date" size="30" readonly /><a class="inputDateButton" href="javascript:;">选择</a>
				
			</p>
			<p >
				<label>客人：</label>
				<input type="text" name="krxx" id="krxx" style="width: 50%;"  class="longinput" size="30" value="<?php 
				echo $arrayresult['guest'];
				?>"  />
					</p>
					<p >
				<label>人数：</label>
				<input type="text" name="peoplenum" size="30" value="<?php 
				echo $arrayresult['guestnum'];
				?>" />
					</p>
			<p>
				<label>客人类型：</label>
				<input type="hidden" name="zts.id" id="gettravleedit" value="<?php echo @$arrayresult['groupName'];?>"/>
				<input type="text" class="required getzts" readonly name="zts.zts" value="<?php 
				$ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$arrayresult['groupName']);
				@$zts=mysqli_fetch_array($ztssql); 
				echo @$zts["travel_name"];
				?>" suggestFields="zts"   lookupGroup="zts" />
				
			</p>
	
	<p>
				<label>外联：</label>
				<input type="hidden" name="wl.id" value="<?php echo @$arrayresult['wl'];?>"/>
				<input type="text" class="getwl" readonly  name="wl.wl" value="<?php 
				$wlsql=mysqli_query($con, "select username from t_user where id=".$arrayresult['wl']);
				@$wl=mysqli_fetch_array($wlsql);
				echo @$wl['username'];
				?>" suggestFields="wl"  lookupGroup="wl" />
				<a class="btnLook" href="ajax/dh/wl.php" lookupGroup="wl">选择用户</a>
			</p>
			<p>
				<label>预定时间：</label>
				<?php 
				echo $arrayresult['enteringDate'];
				?>
			</p>
			<p>
				
				<label>备注：</label>
				<input type="text" class="longinput" name="remark" value="<?php 
				echo $arrayresult['remark'];
				?>" size="30"style="width: 50%;" />
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
			
			<input type='hidden' name='lxs<?php echo $a+1;?>.id' value='<?php echo $yuding[$a]['hotelName'];?>'  class="getlxsid<?php echo $a+1; ?>" />
				<input type='text' oninput="getjgs('<?php echo $a+1; ?>')" class="getlxs<?php echo $a+1; ?>"  name='lxs<?php echo $a+1;?>.lxs<?php echo $a+1;?>' value='<?php 
				 $hotelsql=mysqli_query($con, "select travel_name from t_jgtravel where id=".$yuding[$a]['hotelName']);
			$hotel=mysqli_fetch_array($hotelsql);
			echo $hotel["travel_name"];
			?>' style='width: 70%;' suggestFields='lxs<?php echo $a+1;?>'  lookupGroup='lxs<?php echo $a+1;?>' />
				<a class='btnLook' href='ajax/dh/lxs.php?id=<?php echo $a+1;?>' lookupGroup='lxs<?php echo $a+1;?>' >选择预定旅行社名称</a>
			
			</td>
			<td>
			
	
			
			<select  name="xctype<?php echo $a+1;?>.id" class="getxctype<?php echo $a+1;?>" style='width: 70%;' >
		<option value="">------</option>
	<?php 
	$getfjtype=mysqli_query($con, "select * from t_baseconfig where basenote=13 order by px desc");
	$fjtypere=mysqli_fetch_all($getfjtype,MYSQLI_ASSOC);
	for($f=0;$f<count($fjtypere);$f++){
	?>
	<option value="<?php echo $fjtypere[$f]["id"];?>" <?php echo $yuding[$a]["roomType"]==$fjtypere[$f]["id"]?"selected='selected'":"";?>><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select><a class="btnAttach " onclick="getxcjg(<?php echo $a+1;?>)" style='cursor:pointer ' ><span>获取协议价格</span></a>
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
		<input type='text' name="tk<?php echo $a+1;?>" class='changecounte<?php echo $a+1;?>' onchange="counte(<?php echo $a+1;?>)"
		 value="<?php echo $yuding[$a]['groupPrice']; ?>" size='30'style='width: 100%;' />
			</td>
			<td >
			<input type='hidden' size='30' name="tuank<?php echo $a+1;?>" id="tuanke<?php echo $a+1;?>" value="<?php echo $yuding[$a]['sumPrice']; ?>"  style='width: 100%;'/>
			<span id="counttuanke<?php echo $a+1;?>"><?php echo $yuding[$a]['sumPrice']; ?></span>
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
				 echo $do['username'];?>'style='width: 60%;' suggestFields='douser<?php echo $a+1;?>' 
				  lookupGroup='douser<?php echo $a+1;?>' />
				<a class='btnLook' href="ajax/dh/douser.php?id=<?php echo $a+1;  ?>" lookupGroup='douser<?php echo $a+1;?>'>查找带回</a>
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
			<th align="center" style="width:4%;"> </th>
			<th align="center"  style="width:5%;" id="alltuank"><?php echo $alltuank;?></th>
			<th align="center"  style="width:10.8%;"> </th>
			<th align="center"   style="width:8%;"> </th>
			<th align="center" style="width:3.8%;"> </th></tr>
		
</tr>
		
			<tr>
		
				</table>

				<script type="text/javascript">

	</script>
		</div>

		<div class="formBar">
			<ul>
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
			<?php 
				$id=$_GET["id"];
				//查询是否下账
				$getnumsql=mysqli_query($con, "select teamNumber from  t_groupmanage where id=".$id);
				$getnum=mysqli_fetch_array($getnumsql);
				$number=$getnum["teamNumber"];
				$yifusql=mysqli_query($con, "select fee from t_hoteldebt where groupnumber='".$number."'");
				$yifu=mysqli_fetch_all($yifusql,MYSQLI_ASSOC);
				$yifuje=0;
				for($yf=0;$yf<count($yifu);$yf++){
				    $yifuje+=@$yifu[$yf]["fee"];
				}
				
				$getyishousql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where groupNumber='".$number."'");
				$yishoure=mysqli_fetch_array($getyishousql);
				
				if($yishoure["money"]!=0||$yifuje!=0){
				    
				}else{
				    echo "<li><div class='buttonActive'><div class='buttonContent'><button type='submit' >保存</button></div></div></li>";    
				}
				
				?>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close">关闭</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>
</div>