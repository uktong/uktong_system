<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$today= date("Y-m-d");
$todaydate=date("Y-m");
$firstday = date("Y-01-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
$id=$_GET["id"];
$getmsgsql=mysqli_query($con, "select * from t_sktravel where id=".$id);
$getmsg=mysqli_fetch_array($getmsgsql);
$numPerPage=100;
?>
<table class="searchContent">
			<tr>
			<td class="dateRange">
					日期：
					<input name="startDate" id="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_GET["startDate"])?$_GET["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" id="endDate" class="date readonly" readonly="readonly" type="text" value="<?php echo isset($_GET["endDate"])?$_GET["endDate"]:$today;?>">
				</td>
				<td>团号：<input id="groupnumefk"  type="text" size="30" value="<?php echo @$_GET["groupnum"];?>" /></td>
				<td>客人姓名：<input id="cusnameefk"  type="text" size="30" value="<?php echo @$_GET["cusname"];?>" /></td>
				<td><a class="button" id="searchefkbutton" target="ajax" rel="fkwxz" onclick="searcheditfk()"><span>搜索</span></a></td>
				</tr>
				
				</table>
	

	<table class="table" width="100%" layoutH="255" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">日期</th>
				<th align="center">酒店</th>
				<th align="center">计调</th>
				<th align="center">明细</th>
				<th align="center">客人姓名</th>
				<th align="center">应付</th>
				<th align="center">已付</th>
<!-- 				<th align="center">销售</th> -->
				<th align="center">欠付</th>
				<th align="center">审核状态</th>
				<th align="center">下账金额</th>
				<th align="center">确认下账</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
		 <?php 
			 $shuliangz=0;
			 $tianshuz=0;
			 $danjiaz=0;
			 $jinez=0;
			 $leijiz=0;
			 $qianfuz=0;
			 $yfuz=0;
			 $shuliang=0;
			 $tianshu=0;
			 $danjia=0;
			 $jine=0;
			 $leiji=0;
			 $allyshsql=mysqli_query($con, "select ysdd from t_ffsh ");
			 $allysh=mysqli_fetch_all($allyshsql,MYSQLI_ASSOC);
			 $allddid="0";
			 foreach ($allysh as $ysh){
			 	$allddid.=",".$ysh["ysdd"];
			 }
			 $yshdd=explode(",", $allddid);//所有已经审核过的订单
			 
			 if(@$_GET["search"]==null){
			 
			 }else {
			     $sql="";
			     if($_GET["startDate"]!=""){
			         $startdate=$_GET["startDate"];
			         $enddate=$_GET["endDate"]!=""?$_GET["endDate"]:date("Y-m-d",time());
			         $sql.=" and t_reserveplan.startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_GET["groupnum"]!=""?" and t_groupmanage.teamNumber like '%".$_GET["groupnum"]."%'":"";
			     $sql.=$_GET["cusname"]!=""?" and t_groupmanage.guest like '%".$_GET["cusname"]."%'":"";
			     $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.hotelName='".$_GET["travelid"]."' 
 ".$sql." order by t_groupmanage.id" );
				     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			         $yifuzsql=mysqli_query($con, "select fee from t_hoteldebt where name=".$resultarray[$z]['hotelName']."  and
 groupnumber='".$resultarray[$z]["teamNumber"]."' and reserveplan=".$resultarray[$z]["id"]);
			         $yifuz=mysqli_fetch_all($yifuzsql,MYSQLI_ASSOC);
			         $yifujez=0;
			         for($yf=0;$yf<count($yifuz);$yf++){
			             $yifujez+=@$yifuz[$yf]["fee"];
			         }
			         $shuliangz+=$resultarray[$z]["number"];
			         $tianshuz+=$resultarray[$z]["dayNum"];
			         $danjiaz+=$resultarray[$z]["costPrice"];
			         $jinez+=$resultarray[$z]["hotelCommissionSum"];
			         $leijiz+=$resultarray[$z]["number"]*$resultarray[$z]["dayNum"];
			         $yfuz+=$yifujez;
			         $qianfuz+=($resultarray[$z]["hotelCommissionSum"]-$yifujez);
			         
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/100);
			     @$sr=(1-1)*100;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.hotelName='".$_GET["travelid"]."'   ".$sql." order by t_reserveplan.startDate desc limit ".$sr.",100" );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			$yfu=0;
			$qianfu=0;$wfk=0;
			for($a=0;$a<count($resultnowarray);$a++){
			   $yifusql=mysqli_query($con, "select fee from t_hoteldebt where name=".$_GET["travelid"]."  and
 groupnumber='".$resultnowarray[$a]["teamNumber"]."' and reserveplan=".$resultnowarray[$a]["id"]);
$yifu=mysqli_fetch_all($yifusql,MYSQLI_ASSOC);
$yifuje=0;
for($yf=0;$yf<count($yifu);$yf++){
	$yifuje+=@$yifu[$yf]["fee"];
}
 if($resultnowarray[$a]["hotelCommissionSum"]-$yifuje>0){
$wfk+=1;
			    ?>
			
			  <tr  >
			<td ><?php echo $wfk;?>
			</td><td ><?php echo $resultnowarray[$a]["teamNumber"];?>
            </td><td ><?php echo $resultnowarray[$a]["startDate"];?>
            </td><td ><?php 
			$jddianid=$resultnowarray[$a]['hotelName'];
			$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			$jddian=mysqli_fetch_array($jddiansql);
			echo $jddian["hotelname"];
			?>
            </td><td ><?php 
            $jdid=$resultnowarray[$a]['jd'];
            $jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
            $jd=mysqli_fetch_array($jdsql);
            echo $jd["username"];
            ?>
            </td>
            <td><?php echo $resultnowarray[$a]["id"];?></td>
            <td  style="word-break:break-all; word-wrap:break-all;width:250px;"><?php echo $resultnowarray[$a]["guestName"];?>
            </td><td ><?php echo $resultnowarray[$a]["hotelCommissionSum"];?>
            </td><td ><?php 
		
			echo $yifuje;
			?>
			</td><td ><?php 
			echo $resultnowarray[$a]["hotelCommissionSum"]-$yifuje;
			?><input type="hidden" id="qf<?php echo $a+1;?>" value="<?php 
			echo $resultnowarray[$a]["hotelCommissionSum"]-$yifuje;
			?>">
			</td>
			
			<td ><?php if(in_array($resultnowarray[$a]["id"], $yshdd)){
				
			    
			    $orderstates="<span style='color:green;'>已审核</span>";
			}else{
			    $orderstates="<span style='color:red;'>未审核</span>";
			}
			echo $orderstates;
			?>
            
            </td><td ><input type="text" name="fkmoney[]"  onchange="changemoney();" class="xzmoney"  style="width: 50px;" id="xz<?php echo $a+1;?>" value="0"/>
			</td><td  >
			<input type="checkbox" name="isfk[]" id="fkchecksh<?php echo $a+1;?>" onclick="isfkecheck(<?php echo $a+1;?>)" value="<?php echo $resultnowarray[$a]["id"];?>" />
</td></tr>
<?php			
}
  }
    ?>
		</tbody>
	</table>
	<script type="text/javascript">
<!--
function isfkecheck(id){
	if($("#fkchecksh"+id).is(':checked')){
		$("#xz"+id).val(parseInt($("#qf"+id).val()));
		lastmoney=parseInt($('#fklastmoney').html())-parseInt($('#xz'+id).val());
		if(lastmoney<0){
alert("余额不足！");
$("#fkchecksh"+id).attr("checked",false);
$("#xz"+id).val("0");
			}else{
				$('#fklastmoney').html(lastmoney);
				$('#fkhavingmoney').val(lastmoney);
				}
		
		}else{
			$('#fklastmoney').html(parseInt($('#fklastmoney').html())+parseInt($('#xz'+id).val()));
			$('#fkhavingmoney').val(parseInt($('#fklastmoney').html()));
			$("#xz"+id).val(0);
		}
}
function changemoney(){
	var total=0;
$(".xzmoney").each(function(i){
	var xzid=i+1
	if($(this).val()!=="0"&&$("#fkchecksh"+xzid).is(':checked')){
	total+=parseInt($(this).val());
	}else if($(this).val()!=="0"&&!$("#fkchecksh"+xzid).is(':checked')){
alert("请先选择！");
return false;
		}
});
fkyuee=parseInt($('#allmoney').val())-total;
$('#fklastmoney').html(fkyuee);
$('#fkhavingmoney').val(fkyuee);
}
//-->
</script>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
		
				<option value="20" <?php if($numPerPage==20){echo "selected='selected'";}?>>20</option>
				<option value="50"<?php if($numPerPage==50){echo "selected='selected'";}?>>50</option>
				<option value="100"<?php if($numPerPage==100){echo "selected='selected'";}?>>100</option>
				<option value="150"<?php if($numPerPage==150){echo "selected='selected'";}?>>150</option>
				<option value="200"<?php if($numPerPage==200){echo "selected='selected'";}?>>200</option>
				<option value="250"<?php if($numPerPage==250){echo "selected='selected'";}?>>250</option>
			</select>
			<span>条，共<?php echo $wfk; ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo $wfk; ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
			