<?php 
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end
//check add
$jur=$base->getJur(md5($_COOKIE["username"]),"name",$_GET["J"]);
$J->type($jur, "add");
?>
<script type="text/javascript" src="ajax/js/main.js">


</script>

<div class="pageContent">
	<form method="post" action="jtgl/dbaction.php?action=add&J=<?php echo $_GET["J"];?>" id="daidingform" onsubmit="return validateCallback(this,navTabAjaxDone); " class="pageForm required-validate" >
		<div class="pageFormContent nowrap" layoutH="86" >
			<p>
				<label>我社团号：</label>
				系统自动生成
			<input type="hidden"  name="unicode" value="<?php echo md5(date("YmdHis"));?>" />
			</p>
				<p>
				<label>确认成团：</label>
				
				 <input type="checkbox" checked readonly name="chengtuan" />
			</p>
			<p>
				<label>计调：</label>
			
				<input type="hidden" name="jd.id" value="<?php
				echo  $_COOKIE["userid"];?>"/>
				<input type="text" class="getdata" data-type="jd" name="jd.jd" value="<?php
				echo  $_COOKIE["username"];?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook default"   lookupGroup="jd">选择用户</a>
			</p>
			<p>
				<label>系统状态：</label>
				已成团	
			</p>
			<p>
				<label>代订项目：</label>
				<input type="text" class="required" name="daiding" value="代订酒店" readonly/>
				
			</p>
			<p>
				<label>发团（首晚）日期：</label>
				<input type="text" name="startDate" value="<?php 
			echo $today;?>" class="date" size="30" readonly /><a class="inputDateButton" href="javascript:;">选择</a>
			</p>
			
				<input type="hidden" name="endtDate" value="2099-12-31" readonly class="date" size="30" />
			
			<p>
				<label>组团社：</label>
				<input type="hidden" name="zts.id" id="gettravleadd" value=""/>
				<input type="text" class="required getdata" data-type="zts" name="zts.zts" value="" suggestFields="zts"   lookupGroup="zts" />
				<a class="btnLook default" href="ajax/dh/zts.php" onclick="$('.lxs').val('');" lookupGroup="zts">选择组团社</a>
			</p>

			<p>
				<label>联系人：</label>
				<input type="hidden" name="lxr.id" class="lxs" value=""/>
				<input type="text"    name="lxr.lxr" class="lxs required"  onclick="checkzts()" id="lxrname" value="" suggestFields="lxr"  lookupGroup="lxr" />
				<a class="btnLook default"  onclick="$(this).attr('href','ajax/dh/lxr.php?id='+$('#gettravleadd').val());"  rel="lxr" lookupGroup="lxr">选择联系人</a>
			</p>
			<p>
				<label>人数：</label>
				<input type="text" name="peoplenum" size="30" />
			</p>
			<p>
				<label>外联：</label>
				<input type="hidden" name="wl.id" value="<?php echo $_COOKIE["userid"]; ?>"/>
				<input type="text" class="getdata" data-type="wl"  name="wl.wl" value="<?php echo $_COOKIE["username"]; ?>" suggestFields="wl"  lookupGroup="wl" />
				<a class="btnLook default" href="ajax/dh/wl.php" lookupGroup="wl">选择用户</a>
			</p>
			<p>
				<label>备注：</label>
				<input type="text" class="longinput" name="remark" size="30"style="width: 50%;" />
			</p><br >
			
			<div style="clear: both;">
			<label style="margin-top:5px;">客人：</label>
				<input type="text" name="krxx" id="krxx" class="longinput" size="30" style="width: 50%;margin-top:5px;"  />
			</div>
				<br />
	<br /><hr style="border:1px solid #8db2e3;"/>
			<script type="text/javascript">

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



	</script>
			<div style="clear: both;">
			
			</div>
			<table class="list nowrap itemDetail" addButton="添加预定安排" width="100%">
						<thead>
							<tr>
							<th type="lookup" name="items#index#.hotel.addhotel" lookupGroup="items#index#.hotel" lookupUrl="ajax/dh/hotel.php?type=add" 
							suggestUrl="ajax/xlk.php?type=addhotel" suggestFields="addhotel" postField="name"   fieldClass="required ">酒店名称</th>
								<th type="enum" name="items#index#.roomtype" enumUrl="ajax/ajax_select/roomtype.php" >房型</th>
								<th type="date" name="items#index#.livedate" defaultVal="<?php echo $today;?>" >入住日期</th>
								<th type="text" name="items#index#.days" defaultVal="1"  fieldClass="digits days count">天数</th>
								<th type="text" name="items#index#.singleprice" defaultVal="0" fieldClass="number singleprice count">单价</th>
								<th type="text" name="items#index#.amount" defaultVal="1"  fieldClass="digits amount count">数量</th>
								<th type="span"  defaultVal="0" fieldClass="tatalprice">金额</th>
								<th type="text" name="items#index#.saleprice" defaultVal="0"  fieldClass="number saleprice count">团款</th>
								<th type="span"  defaultVal="0" fieldClass="tatalsaleprice" >总团款</th>
								<th type="enum" name="items#index#.breakfast" enumUrl="ajax/ajax_select/breakfast.php" >路早</th>
								<th type="text" name="items#index#.customer"   defaultVal="" fieldClass="required customer">客人姓名</th>

							<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							<tr class="unitBox"><td><input type="hidden" name="items0.hotel.id"><input type="text" name="items0.hotel.addhotel" 
							autocomplete="off" lookupgroup="items0.hotel" suggesturl="ajax/xlk.php?type=addhotel" suggestfields="addhotel" postfield="name" lookuppk="id" 
							class="required textInput valid"><a class="btnLook" href="ajax/dh/hotel.php?type=add" lookupgroup="items0.hotel" 
							autocomplete="off" suggesturl="ajax/xlk.php?type=addhotel" suggestfields="addhotel" postfield="name" lookuppk="id" 
							title="查找带回">查找带回</a></td>
							<td><div class="combox"><div id="combox_4675941" class="select">
							<select  name="items0.roomtype" class="combox getcus"  >
			<option value="">------</option>
	<?php 
	$fjtypere=$base->data("room");

	for($f=0;$f<count($fjtypere);$f++){
	?>

	<option value="<?php echo $fjtypere[$f]["id"];?>"><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select></div></div></td><td><input type="text" name="items0.livedate" value="<?php echo $today;?>" class="date  textInput" datefmt="yyyy-MM-dd" >
	<a class="inputDateButton" href="javascript:void(0)">选择</a></td><td><input type="text" name="items0.days" value="1" size="12" class="digits textInput days count"></td>
	<td><input type="text" name="items0.singleprice" value="0" size="12" class="number textInput singleprice count"></td>
	<td><input type="text" name="items0.amount" value="1" size="12" class="digits textInput amount count"></td>
	<td><span  class="tatalprice">0</span></td>
	<td><input type="text" name="items0.saleprice" value="0" size="12" class="textInput number saleprice count"></td><td><span   class="tatalsaleprice">0</span></td><td>
<div class="combox"><div id="combox_3219145" class="select"><select name="items0.breakfast" class="combox" style="display: none;">
		

	<option value="0">否</option>
	<option value="1">是</option>
	
	</select></div></div></td><td><input type="text" name="items0.customer" value="" class="required textInput customer"></td><td></td></tr>
	
	
	<tr class="unitBox"><td><input type="hidden" name="items1.hotel.id"><input type="text" name="items1.hotel.addhotel" 
							autocomplete="off" lookupgroup="items1.hotel" suggesturl="ajax/xlk.php?type=addhotel" suggestfields="addhotel" postfield="name" lookuppk="id" 
							class="required textInput valid"><a class="btnLook" href="ajax/dh/hotel.php?type=add" lookupgroup="items1.hotel" 
							autocomplete="off" suggesturl="ajax/xlk.php?type=addhotel" suggestfields="addhotel" postfield="name" lookuppk="id" 
							title="查找带回">查找带回</a></td>
							<td><div class="combox"><div id="combox_4675941" class="select">
							<select  name="items1.roomtype" class="combox getcus"  >
			<option value="">------</option>
	<?php 
	$fjtypere=$base->data("room");

	for($f=0;$f<count($fjtypere);$f++){
	?>

	<option value="<?php echo $fjtypere[$f]["id"];?>"><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select></div></div></td><td><input type="text" name="items1.livedate" value="<?php echo $today;?>" class="date  textInput" datefmt="yyyy-MM-dd" >
	<a class="inputDateButton" href="javascript:void(0)">选择</a></td><td><input type="text" name="items1.days" value="1" size="12" class="digits textInput days count"></td>
	<td><input type="text" name="items1.singleprice" value="0" size="12" class="number textInput singleprice count"></td>
	<td><input type="text" name="items1.amount" value="1" size="12" class="digits textInput amount count"></td>
	<td><span  class="tatalprice">0</span></td>
	<td><input type="text" name="items1.saleprice" value="0" size="12" class="textInput number saleprice count"></td><td><span   class="tatalsaleprice">0</span></td><td>
<div class="combox"><div id="combox_3219145" class="select"><select name="items1.breakfast" class="combox" style="display: none;">
		

	<option value="0">否</option>
	<option value="1">是</option>
	
	</select></div></div></td><td><input type="text" name="items1.customer" value="" class="required textInput customer"></td><td><a href="javascript:void(0)" class="btnDel ">删除</a></td></tr>
						</tbody>
						<tfoot>
						<tr>
								<td ></td>
								<td ></td>
								<td ></td>
								<td ></td>
								<td ></td>
								<td ></td>
								<td class="allprice">0</td>
								<td ></td>
								<td class="allsaleprice">0</td>
								<td ></td>
								<td ></td>
								<td ></td>
							
							</tr>
						</tfoot>
					</table>
			
			<table class="list nowrap itemDetail" addButton="添加其他支出" width="100%">
						<thead>
							<tr>
							<th type="enum" name="others#index#.type" enumUrl="ajax/ajax_select/othertype.php">类别</th>
								
								<th type="text" name="others#index#.money" defaultVal="0" fieldClass="number singleprice countother">单价</th>
								<th type="text" name="others#index#.amount" defaultVal="1"  fieldClass="number amount countother">数量</th>
								<th type="span"  defaultVal="0" fieldClass="othertatalprice">金额</th>
								<th type="text" name="others#index#.remark"   defaultVal="" fieldClass="required planremark">备注</th>

							<th type="del" width="60">操作</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
						<tfoot>
						<tr>
								<td ></td>
								<td ></td>
								<td ></td>
							
								<td class="otherallprice">0</td>
								<td ></td>
							
								<td ></td>
							
							</tr>
						</tfoot>
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
<script>
$(function(){

	$(".getcus").change(function(){
		$(".customer").val($("#krxx").val());
		
		});
	$(".count").change(function(){
	var parent=$(this).parent().parent();
  	var thissingleprice=parent.find(".singleprice").val();
  	var thisdays=parent.find(".days").val();
  	var thisamount=parent.find(".amount").val();
  	var thissaleprice=parent.find(".saleprice").val();
  	
  	parent.find(".tatalprice").text(thissingleprice*thisdays*thisamount);
	parent.find(".tatalsaleprice").text(thissaleprice*thisdays*thisamount);
	var allprice=0;
	var allsaleprice=0;
	parent.parent().parent().find('.tatalprice').each(function (){

		allprice+=parseFloat($(this).text());

		});
	parent.parent().parent().find('.allprice').text(allprice);
	parent.parent().parent().find('.tatalsaleprice').each(function (){

		allsaleprice+=parseFloat($(this).text());

		});
	parent.parent().parent().find('.allsaleprice').text(allsaleprice);
		});

	//
	
	
});
</script>