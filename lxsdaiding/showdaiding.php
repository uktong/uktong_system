<?php
session_start();

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
	<form method="post" action="db/daiding.php?action=charu" class="pageForm required-validate" onsubmit="return navTabSearch(this);">
		<div class="pageFormContent" layoutH="56" >
			<p>
				<label>团号：</label>
				<?php echo $arrayresult['teamNumber'];?>
			
			</p>
			<p>
				<label>对接人：</label>
				<?php 
				$jdsql=mysqli_query($con, "select username from t_user where id=".$arrayresult['jd']);
				$jd=mysqli_fetch_array($jdsql);
				echo $jd['username'];
				?>
			</p>
			<p>
				<label>发团日期：</label>
				<?php echo $arrayresult['startDate'];?>
			</p>
			<p>
			<label>散团日期：</label>
			<?php echo $arrayresult['endDate'];?>
			</p>
			
	
	
			<div style="clear: both;">
				<div class="panelBar">
		<ul class="toolBar">
			<li><span>预定安排</span></li>
			
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
			<th align="center"   style="width:4%;">路早</th>
			<th align="center"  style="width:10.8%;">客人姓名</th>
			<th align="center"   style="width:8%;">操作员</th>
			<?php
			$yudingsql=mysqli_query($con, "select * from t_reserveplan where groupNumber='".$arrayresult['teamNumber']."'");
			$yudingline=mysqli_num_rows($yudingsql);
			$yuding=mysqli_fetch_all($yudingsql,MYSQLI_ASSOC);
			$alljine=0.00;
			    for($a=0;$a<count($yuding);$a++){
			?>
		<tr  class="tableline">
			<td>
			<?php echo $a+1;?>
			</td>
			<td  >
			<?php $hotelsql=mysqli_query($con, "select hotelname from t_allhotel where id=".$yuding[$a]['hotelName']);
			$hotel=mysqli_fetch_array($hotelsql);
			echo $hotel["hotelname"];
				?>
			</td>
			<td>
			<?php $fjsql=mysqli_query($con, "select roomType from t_roomprice where id=".$yuding[$a]['roomType']);
			$fjtype=mysqli_fetch_array($fjsql);
			echo $fjtype["roomType"];
				?>
			</td>
			<td >
			<?php echo $yuding[$a]['startDate']; ?>
			</td>
			<td >
			<?php echo $yuding[$a]['dayNum']; ?>
			</td>
			<td >
			<?php echo $yuding[$a]['costPrice']; ?>
			</td>
			<td >
			<?php echo $yuding[$a]['number']; ?>
			</td>
			<td >
			<?php echo $yuding[$a]['hotelCommissionSum']; ?>
			</td>
			<td>
			<?php 
			    echo $yuding[$a]['breakfast']!="1" ? "否":"是";
			    
			?>
			</td>
			<td>
			<?php 
			    echo $yuding[$a]['guestName'];
			    
			?>
			</td>
			<td >
			<?php 
			$caozuosql=mysqli_query($con, "select username from t_hoteluser where id=".$yuding[$a]['manageUser']);
			$caozuo=mysqli_fetch_array($caozuosql);
			echo $caozuo["username"];
			    
			?>
			</td>
			 </tr>
			<?php 
			$alljine+=$yuding[$a]['hotelCommissionSum'];
			    
			    }?>
		<tr style="background:#E0ECFF;height:20px;" id="newline">
			<th align="center"  style="width:3.8%;">合计</th>
			<th align="center"   style="width:10.3%;"> </th>
			<th align="center"  style="width:8%;"> </th>
			<th align="center"  style="width:7%;">  </th>
			<th align="center"   style="width:3%;"> </th>
			
			<th align="center"  style="width:4%;"></th>
			<th align="center"  style="width:4%;"> </th>
			<th align="center"  style="width:5%;" ><?php echo $alljine;?></th>
			<th align="center" style="width:4%;"> </th>
			<th align="center"  style="width:4%;"> </th>
			<th align="center"   style="width:4%;"> </th>
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
