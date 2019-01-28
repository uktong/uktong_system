<?php
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end




$id=$_GET["id"];

$arrayresult=$db->select("t_groupmanage","*","id='".$id."'");
$jd=$base->getdata("user", $arrayresult[0]['jd']);
$zts=$base->getdata("travel", $arrayresult[0]['groupName']);
?>
<script type="text/javascript" src="ajax/js/main.js">
<!--

//-->
</script>
<div class="pageContent">
	<form method="post" action="db/daiding.php?action=charu" class="pageForm required-validate" onsubmit="return navTabSearch(this);">
		<div class="pageFormContent" layoutH="76" >
			<p>
				<label>我社团号：</label>
				<?php echo $arrayresult[0]['teamNumber'];?>
			
			</p>
			<p>
				<label>计调：</label>
				<?php 

				echo $jd['username'];
				?>
			</p>
			<p>
				<label>系统状态：</label>
				<?php  if($arrayresult[0]['orderStatus']=="1"){
				    echo "<span style='color:green;'>已成团</span>";
				}else{
				    echo "<span style='color:red;'>未成团</span>";
				}?>
			</p>
			<p>
				<label>代订项目：</label>
				代订酒店
				
			</p>
			<p>
				<label>发团日期：</label>
				<?php echo $arrayresult[0]['startDate'];?>
			</p>

			<p>
				<label>组团社：</label>
				<?php 

				echo $zts["travel_name"];
				?>
			</p>

			<p>
				<label>联系人：</label>
				<?php 

				echo $arrayresult[0]['linkmanname'];
				?>
			</p>
			<p >
				<label>备注：</label>
				<?php 
				echo $arrayresult[0]['remark'];
				?>
				
					</p>
					
			<p style="width: 600px;overflow:auto;">
				<label>客人：</label>
				<?php 
				echo $arrayresult[0]['guest'];
				?>
				
					</p>
	
	<div style="clear: both;">

			</div>
			<div class="panelBar">
		【预定安排】
	</div>
			
			<table class="table" width="100%"  style="word-break:break-all; word-wrap:break-all;">
<tr style="background:#E0ECFF;height:20px;">

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
			<?php

			$yuding=$db->select("t_reserveplan", "*", "groupNumber='".$arrayresult[0]['teamNumber']."'");
			$alljine=0.00;
			foreach($yuding as $a){
			?>
		<tr  class="tableline">

			<td  >
			<?php 
			$hotel=$base->getdata("hotel", $a['hotelName']);
			echo $hotel["hotelname"];
				?>
			</td>
			<td>
			<?php 
			$fjtype=$base->getdata("room", $a['roomType']);
			echo $fjtype["basetype"];
				?>
			</td>
			<td >
			<?php echo $a['startDate']; ?>
			</td>
			<td >
			<?php echo $a['dayNum']; ?>
			</td>
			<td >
			<?php echo $a['costPrice']; ?>
			</td>
			<td >
			<?php echo $a['number']; ?>
			</td>
			<td >
			<?php echo $a['hotelCommissionSum']; ?>
			</td>
			<td>
			<?php 
			echo $a['breakfast']!="1" ? "否":"是";
			    
			?>
			</td>
			<td>
			<?php 
			echo $a['guestName'];
			    
			?>
			</td>
			<td >
			<?php 
			
			$douser=$base->getdata("user", $a['manageUser']);
			echo $douser["username"];
			?>
			</td>
			 </tr>
			<?php 
			$alljine+=$a['hotelCommissionSum'];
			    
			    }?>
		<tr style="background:#E0ECFF;height:20px;" id="newline">
			<th align="center"  style="width:3.8%;">合计</th>
			<th align="center"   style="width:10.3%;"> </th>
			<th align="center"  style="width:8%;"> </th>
			<th align="center"  style="width:7%;">  </th>
			<th align="center"  style="width:4%;"></th>
			<th align="center"  style="width:4%;"> </th>
			<th align="center"  style="width:5%;" ><?php echo $alljine;?></th>
			<th align="center" style="width:4%;"> </th>
			<th align="center"  style="width:4%;"> </th>
			<th align="center"   style="width:3%;"> </th>
		
			</tr>
		
			<tr>
				</table>
<div class="panelBar">
		【其他支出】
	</div>
		<table class="table" width="100%"  style="word-break:break-all; word-wrap:break-all;">
<tr style="background:#E0ECFF;height:20px;">
			<th align="center" >类别</th>
			<th align="center" >单价</th>
			<th align="center"  >数量</th>
			<th align="center" >金额</th>
			<th align="center"  >备注</th>
			<th align="center" >操作员</th>
			<?php

			$yuding=$db->select("t_otherplan", "*", "groupNumber='".$arrayresult[0]['teamNumber']."'");
			$alljine=0.00;
			$othertype=$db->select("t_baseconfig","*","basenote=14 order by px");
			foreach($yuding as $a){
			?>
		<tr  class="tableline">

			<td  >
			<?php 
			foreach ($othertype as $o){
			    if($o["id"]==$a["type"]){
			        echo $o["basetype"];
			    }
			}
				?>
			</td>
			<td>
			<?php 

			echo $a["money"];
				?>
			</td>
			<td >
			<?php echo $a['amount']; ?>
			</td>
			<td >
			<?php echo $a['summoney']; ?>
			</td>
			<td >
			<?php echo $a['remark']; ?>
			</td>
			
			<td >
			<?php 
			$douser=$base->getdata("user", $a['manageUser']);
			echo $douser["username"];

			    
			?>
			</td>
			 </tr>
			<?php 
			$alljine+=$a['summoney'];
			    
			    }?>
		<tr style="background:#E0ECFF;height:20px;" >
			<th align="center" >合计</th>
			<th align="center" > </th>
			<th align="center" > </th>

			<th align="center"   ><?php echo $alljine;?></th>
			<th align="center"> </th>
			<th align="center" > </th>

		
			</tr>
		
			<tr>
				</table>
		</div>

		<div class="formBar">
			<ul>
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close">关闭</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>
