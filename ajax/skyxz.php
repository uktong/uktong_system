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
$pageNum=1;
?>
<table class="searchContent">
			<tr>
			<td class="dateRange">
					日期：
					<input id="startDateesky" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_GET["startDate"])?$_GET["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input id="endDateesky" class="date readonly" readonly="readonly" type="text" value="<?php echo isset($_GET["endDate"])?$_GET["endDate"]:$today;?>">
				</td>
				<td>团号：<input id="groupnumesky"  type="text" size="30" value="<?php echo @$_GET["groupnum"];?>" /></td>
				<td>客人姓名：<input id="cusnameesky"  type="text" size="30" value="<?php echo @$_GET["cusname"];?>" /></td>
				<td><a class="button" id="searcheskbuttony" target="ajax" rel="skyxz" onclick="searcheditsky()"><span>搜索</span></a></td>
				</tr>
				
				</table>

	<div ></div>

	<table class="table" width="100%" layoutH="255" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
			<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">日期</th>
				<th align="center">联系人</th>
				<th align="center">组团社</th>
				<th align="center">客人姓名</th>
				<th align="center">应收</th>
				<th align="center">已收</th>
<!-- 				<th align="center">销售</th> -->
				<th align="center">欠收</th>
				<th align="center">金额</th>
				<th align="center">取消下账</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
		 <?php 
		
			 if(@$_GET["search"]==null){
			     $result=mysqli_query($con,"select * from t_groupmanage 
			     		where groupName='".$getmsg["travel"]."' and  startDate between '".$firstday."' and '".$lastday."'" );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     
			     for($z=0;$z<count($resultarray);$z++){
			     	$zmsql=mysqli_query($con, "select * from t_collectionunit where groupNumber='".$resultarray[$z]['teamNumber']."'");
			     	$zm=mysqli_fetch_all($zmsql,MYSQLI_ASSOC);
			     	 
			       
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage  where groupName='".$getmsg["travel"]."' 
			     		and startDate between '".$firstday."' and '".$lastday."' order by startDate desc  limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }else {
			     $sql="";
			     if($_GET["startDate"]!=""){
			         $startdate=$_GET["startDate"];
			         $enddate=$_GET["endDate"]!=""?$_GET["endDate"]:date("Y-m-d",time());
			         $sql.=" and b.startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_GET["groupnum"]!=""?" and a.teamNumber like '%".$_GET["groupnum"]."%'":"";
			     $sql.=$_GET["cusname"]!=""?" and a.guest like '%".$_GET["cusname"]."%'":"";
			     $result=mysqli_query($con,"select a.*,sum(ifnull(b.sumPrice,0)) as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
 ".$sql." order by a.id" );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     $yifu=0;
			     for($z=0;$z<count($resultarray);$z++){
			         $zmsql=mysqli_query($con, "select * from t_collectionunit where groupNumber='".$resultarray[$z]['teamNumber']."'");
			         $zm=mysqli_fetch_all($zmsql,MYSQLI_ASSOC);
			         
			         for($w=0;$w<count($zm);$w++){
			             $yifu+=$zm[$w]["amount"];
			             
			         }
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     
			     $resultnow=mysqli_query($con,"select a.*,sum(ifnull(b.sumPrice,0)) as allin  from t_groupmanage as a right join t_reserveplan as b on a.teamNumber=b.groupNumber where a.groupName='".$getmsg["travel"]."' and b.groupNumber=a.teamNumber
 ".$sql." order by b.startDate desc limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			 
			 
			 $yfu=0;
			 $qianfu=0;
			 $countlineq=0;
			 for($a=0;$a<count($resultnowarray);$a++){
			     
			     $getyishousql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where groupNumber='".$resultnowarray[$a]["teamNumber"]."'");
			     $yishoure=mysqli_fetch_array($getyishousql);
			     
			     if($yishoure["money"]!=0){
			         $countlineq+=1;
			         ?>
			
			  <tr  >
			  <td><?php echo $countlineq;?></td>
			<td ><?php echo $resultnowarray[$a]["teamNumber"];?>
            </td><td ><?php echo $resultnowarray[$a]["startDate"];?>
            </td><td ><?php 
            echo $resultnowarray[$a]["linkmanname"];
			?>
			 </td><td ><?php 
			 $ztsid=$resultnowarray[$a]['groupName'];
			 $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			 $zts=mysqli_fetch_array($ztssql);
			 echo $zts['travel_name'];
			 ?>
            <td  style="word-break:break-all; word-wrap:break-all;width:250px;"><?php echo $resultnowarray[$a]["guest"];?>
            </td><td ><?php 
            
            echo $resultnowarray[$a]["allin"];
            ?>
            </td><td ><?php 
			
           
            if($yishoure["money"]==null){
            	echo "0";
            }else {
            	echo $yishoure["money"];
            }
			?>  <input type="hidden" id="qxys<?php echo $a+1;?>" value="<?php 
			echo $yishoure["money"];
			?>">
			</td>
			
			<td ><?php echo $resultnowarray[$a]["allin"]-$yishoure["money"];
			?>
          
            </td><td ><input type="text" name="qxskmoney[]"  onchange="changemoney();" class="xzmoney"  style="width: 50px;" id="qx<?php echo $a+1;?>" value="0"/>
			</td><td  >
			<input type="checkbox" name="isqxsk[]" id="qxskchecksh<?php echo $a+1;?>" onclick="isqxskecheck(<?php echo $a+1;?>)" value="<?php echo $resultnowarray[$a]["id"];?>" />
</td></tr>
<?php			
}
 }
    ?>
		</tbody>
	</table>
	<script type="text/javascript">
<!--function isqxskecheck(id){
	if($("#qxskchecksh"+id).is(':checked')){
		$("#qx"+id).val(parseInt($('#qxys'+id).val()));
		$('#sklastmoney').html(parseInt($('#sklastmoney').html())+parseInt($('#qx'+id).val()));
		$('#skhavingmoney').val(parseInt($('#sklastmoney').html()));
		
		
		}else{
			lastmoney=parseInt($('#sklastmoney').html())-parseInt($('#qx'+id).val());
			if(lastmoney<0){
	alert("余额不足！");
	$("#qxchecksh"+id).attr("checked",false);
	$("#qx"+id).val("0");
				}else{
					$("#qx"+id).val("0");
					$('#sklastmoney').html(lastmoney);
					$('#skhavingmoney').val(lastmoney);
					}
		}
}
function changemoney(){
	var total=0;
$(".xzmoney").each(function(i){
	var xzid=i+1
	if($(this).val()!=="0"&&$("#skchecksh"+xzid).is(':checked')){
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
			<select class="combox" name="numPerPage" >
		
				<option value="20" <?php if($numPerPage==20){echo "selected='selected'";}?>>20</option>
				<option value="50"<?php if($numPerPage==50){echo "selected='selected'";}?>>50</option>
				<option value="100"<?php if($numPerPage==100){echo "selected='selected'";}?>>100</option>
				<option value="150"<?php if($numPerPage==150){echo "selected='selected'";}?>>150</option>
				<option value="200"<?php if($numPerPage==200){echo "selected='selected'";}?>>200</option>
				<option value="250"<?php if($numPerPage==250){echo "selected='selected'";}?>>250</option>
			</select>
			<span>条，共<?php echo $countlineq; ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo $countlineq; ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>