<?php
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end
$id=$_GET["id"];
$jur=$base->getJur(md5($_COOKIE["username"]),"name",$_GET["J"]);
$J->type($jur, "edit");

$arrayresult=$db->select("t_groupmanage","*","id='".$id."'")[0];
if ($J->type($jur, "limit")&&$arrayresult['jd']!=$_COOKIE["userid"]){
    die("您无权编辑该订单！");
}

$jd=$base->getdata("user", $arrayresult['jd']);
$wl=$base->getdata("user", $arrayresult['wl']);
$zts=$base->getdata("travel", $arrayresult['groupName']);
$plans=$db->select("t_reserveplan","*","groupNumber='".$arrayresult['teamNumber']."'");
$others=$db->select("t_otherplan", "*", "groupNumber='".$arrayresult['teamNumber']."'");

?>
<script type="text/javascript" src="ajax/js/main.js">
<!--

//-->
</script>
<div class="pageContent">
	<form method="post" action="jtgl/dbaction.php?action=edit&id=<?php echo $arrayresult['teamNumber']; ?>" class="pageForm required-validate" onsubmit="return validateCallback(this,navTabAjaxDone); ">
		<div class="pageFormContent" layoutH="76" >
			<p>
				<label>我社团号：</label>
				<?php echo $arrayresult['teamNumber'];?>
			</p> 
			<p>
				<label>计调：</label>
				<input type="hidden" name="jd.id" value="<?php echo $arrayresult['jd']; ?>"/>
				<input type="text" class="required getjd" name="jd.jd" value="<?php
				echo $jd['username'];
				?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" href="ajax/dh/jd.php" lookupGroup="jd">选择用户</a>
 
			</p>
			<p>
				<label>系统状态：</label>
				<?php  
				    echo "<span style='color:green;'>已成团</span>";
				?>
			</p>
			<p>
				<label>代订项目：</label>
				<input type="text" class="required" name="daiding" value="代订酒店" readonly/>
				
			</p>
			<p>
				<label>发团日期：</label>
				<input type="text" name="startDate" value="<?php echo $arrayresult['startDate'];?>" class="date" size="30" readonly /><a class="inputDateButton" href="javascript:;">选择</a>
				
			</p>
			<p>
			<label>散团日期：</label>
			
			<input type="text" name="endtDate" value="<?php echo $arrayresult['endDate'];?>" readonly class="date" size="30" /><a class="inputDateButton" href="javascript:;">选择</a>
			</p>
			<p>
				<label>组团社：</label>
				<input type="hidden" name="zts.id" id="gettravleedit" value="<?php echo @$arrayresult['groupName'];?>"/>
				<input type="text" class="required getzts" name="zts.zts" value="<?php 

				echo @$zts["travel_name"];
				?>" suggestFields="zts"   lookupGroup="zts" />
				<a class="btnLook" href="ajax/dh/zts.php" onclick="$('.lxsedit').val('');" lookupGroup="zts">选择组团社</a>
				
			</p>

			<p>
					<label>联系人：</label>
				<input type="hidden" name="lxr.id" class="lxsedit" id="lxrid" value="<?php echo $arrayresult['linkman'];?>"/>
				<input type="text"   name="lxr.lxr" class="lxsedit required"  onclick="checkzts()" onchange="$('#lxrid').val('');"  value="<?php 
				echo $arrayresult["linkmanname"];
				?>" suggestFields="lxr"  lookupGroup="lxr" />
				<a class="btnLook"  onclick="$(this).attr('href','ajax/dh/lxr.php?id='+$('#gettravleedit').val());"  rel="lxr" lookupGroup="lxr">选择联系人</a>
			
			</p>
			<p>
				<label>人数：</label>
				
					<input type="text"  name="peoplenum" value="<?php echo $arrayresult['guestnum'];?>" size="30" />
			</p>
	
	<p>
				<label>外联：</label>
				<input type="hidden" name="wl.id" value="<?php echo @$arrayresult['wl'];?>"/>
				<input type="text" class="getwl"   name="wl.wl" value="<?php 

				echo @$wl['username'];
				?>" suggestFields="wl"  lookupGroup="wl" />
				<a class="btnLook" href="ajax/dh/wl.php" lookupGroup="wl">选择用户</a>
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
			<p style="
    width: 780px;
			">
				<label>客人：</label>
				<input type="text" name="krxx" id="krxx" class="longinput" size="30" value="<?php 
				echo $arrayresult['guest'];
				?>" style="width: 600px;"  />
					</p>
			
				

			<div style="clear: both;">
			</div>
<hr style="border:1px solid #8db2e3;"/>
			<script type="text/javascript">



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


	</script>
	
	
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
						<?php
						
						$alljine=0.00;
						$alltuank=0.00;
						
						for ($a=0;$a<count($plans);$a++){?>
							<tr class="unitBox"><td>
							<input type="hidden" name="items<?php echo $a;?>.id" value="<?php echo $plans[$a]["id"];?>">
							<input type="hidden" name="items<?php echo $a;?>.hotel.id" value="<?php echo $plans[$a]["hotelName"];?>"><input type="text" name="items<?php echo $a;?>.hotel.addhotel" 
							autocomplete="off" lookupgroup="items<?php echo $a;?>.hotel" suggesturl="ajax/xlk.php?type=addhotel" value="<?php 
							$hotel=$base->getdata("hotel", $plans[$a]['hotelName']);
							echo $hotel["hotelname"];
							?>" suggestfields="addhotel" postfield="name" lookuppk="id" 
							class="required textInput valid"><a class="btnLook" href="ajax/dh/hotel.php?type=add" lookupgroup="items<?php echo $a;?>.hotel" 
							autocomplete="off" suggesturl="ajax/xlk.php?type=addhotel" suggestfields="addhotel" postfield="name" lookuppk="id" 
							title="查找带回">查找带回</a></td>
							<td><div class="combox"><div id="combox_4675941" class="select">
							<select  name="items<?php echo $a;?>.roomtype" class="combox getcus"  >
			<option value="">------</option>
	<?php 
	$fjtypere=$base->data("room");

	for($f=0;$f<count($fjtypere);$f++){
	?>

	<option value="<?php echo $fjtypere[$f]["id"];?>" <?php echo $plans[$a]["roomType"]==$fjtypere[$f]["id"]?"selected='selected'":"";?>><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select></div></div></td><td><input type="text" name="items<?php echo $a;?>.livedate" value="<?php echo $plans[$a]["startDate"];?>" class="date  textInput" datefmt="yyyy-MM-dd" >
	<a class="inputDateButton" href="javascript:void(0)">选择</a></td><td><input type="text" name="items<?php echo $a;?>.days" value="<?php echo $plans[$a]["dayNum"];?>" size="12" class="digits textInput days count"></td>
	<td><input type="text" name="items<?php echo $a;?>.singleprice" value="<?php echo $plans[$a]["costPrice"];?>" size="12" class="number textInput singleprice count"></td>
	<td><input type="text" name="items<?php echo $a;?>.amount" value="<?php echo $plans[$a]["number"];?>" size="12" class="digits textInput amount count"></td>
	<td><span  class="tatalprice"><?php echo $plans[$a]["hotelCommissionSum"];?></span></td>
	<td><input type="text" name="items<?php echo $a;?>.saleprice" value="<?php echo $plans[$a]["groupPrice"];?>" size="12" class="textInput number saleprice count"></td><td>
	<span   class="tatalsaleprice"><?php echo $plans[$a]["sumPrice"];?></span></td><td>
<div class="combox"><div id="combox_3219145" class="select"><select name="items<?php echo $a;?>.breakfast" class="combox" style="display: none;">
		

	<option value="0" <?php  echo $plans[$a]['breakfast']!="0" ? "":"selected"; ?>>否</option>
	<option value="1" <?php  echo $plans[$a]['breakfast']!="1" ? "":"selected"; ?>>是</option>
	
	</select></div></div></td><td><input type="text" name="items<?php echo $a;?>.customer" value="<?php echo $plans[$a]["guestName"];?>" class="required textInput customer"></td><td><a href="javascript:void(0)" class="btnDel ">删除</a></td></tr>
	<?php 
				
	$alljine+=$plans[$a]['hotelCommissionSum'];
	$alltuank+=$plans[$a]['sumPrice'];
				
				}?>
	
						</tbody>
						<tfoot>
						<tr>
								<td ></td>
								<td ></td>
								<td ></td>
								<td ></td>
								<td ></td>
								<td ></td>
								<td class="allprice"><?php echo $alljine;?></td>
								<td ></td>
								<td class="allsaleprice"><?php echo $alltuank;?></td>
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
						<?php 
						$fjtypere=$db->select("t_baseconfig","*","basenote=14 order by px");
						$otherscount=0;
						for($a=0;$a<count($others);$a++){?>
													<tr class="unitBox"><td>
<div class="combox">
<div id="combox_337960" class="select">
<input type="hidden" name="others<?php echo $a;?>.id" value="<?php echo $others[$a]["id"];?>">
<select name="others<?php echo $a;?>.type" class="combox getothercus" style="display: none;">
		<option value="">------------------</option>
	<?php 

	for($f=0;$f<count($fjtypere);$f++){
	?>
		
	<option value="<?php echo $fjtypere[$f]["id"];?>" <?php echo $fjtypere[$f]["id"]==$others[$a]["type"]?"selected":"";?> ><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
		</select></div></div></td>
		<td><input type="text" name="others<?php echo $a;?>.money" value="<?php echo $others[$a]["money"];?>" size="12" class="number singleprice countother textInput"></td>
		<td><input type="text" name="others<?php echo $a;?>.amount" value="<?php echo $others[$a]["amount"];?>" size="12" class="number amount countother textInput"></td>
		<td><span class=" othertatalprice"><?php echo $others[$a]["summoney"];?></span></td>
		<td><input type="text" name="others<?php echo $a;?>.remark" value="<?php echo $others[$a]["remark"];?>" size="12" class="required planremark textInput"></td>
		<td><a href="javascript:void(0)" class="btnDel">删除</a></td>
		</tr>
		
		<?php
		$otherscount+=$others[$a]["summoney"];
						}?>
						</tbody>
						<tfoot>
<tr>
								<td ></td>
								<td ></td>
								<td ></td>
								<td class="otherallprice"><?php echo $otherscount;?></td>
								<td ></td>
								<td ></td>
							
							</tr>
						</tfoot>
					</table>
	
	

		</div>

		<div class="formBar">
			<ul>
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
			
				<li><div class='buttonActive'><div class='buttonContent'><button type='submit' >保存</button></div></div></li>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close">关闭</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>
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
	$(".getothercus").change(function(){
		$(".planremark").val($("#krxx").val());
		
		});
	$(".countother").change(function(){
	var parent=$(this).parent().parent();
  	var thissingleprice=parent.find(".singleprice").val();

  	var thisamount=parent.find(".amount").val();

  	
  	parent.find(".othertatalprice").text(thissingleprice*thisamount);

	var otherallprice=0;

	parent.parent().parent().parent().find('.othertatalprice').each(function (){

		otherallprice+=parseFloat($(this).text());

		});
	parent.parent().parent().parent().find('.otherallprice').text(otherallprice);
	});
	
});
</script>