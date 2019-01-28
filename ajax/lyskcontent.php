<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
if(@$_POST["numPerPage"]!=null){
    $numPerPage=$_POST["numPerPage"];
    //      $keywords=$_POST["keywords"];
    $pageNum=$_POST["pageNum"];
    //     $status=$_POST["status"];
    //     $orderField=$_POST["orderField"];
    
}else{
    $numPerPage=100;
    $pageNum=1;
}
date_default_timezone_set('prc');
$today= date("Y-m-d");
$firstday = date("Y-01-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
$travel=@$_GET["travelid"];

require_once $_SESSION["ROOT"].'/db/db.php';
?>
<table class="table" width="100%" layoutH="285" id="" style="word-break:break-all; word-wrap:break-all;">

		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">日期</th>
				<th align="center">交给社</th>
				<th align="center">客人姓名</th>
				<th align="center">应收</th>
				<th align="center">已收</th>
				<th align="center">欠收</th>
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
			 $yingfu=0;
			 $yifu=0;
			 $qianfu=0;
// 			 $allyshsql=mysqli_query($con, "select ysdd from t_ffsh ");
// 			 $allysh=mysqli_fetch_all($allyshsql,MYSQLI_ASSOC);
// 			 $allddid="0";
// 			 foreach ($allysh as $ysh){
// 			 	$allddid.=",".$ysh["ysdd"];
// 			 }
// 			 $yshdd=explode(",", $allddid);//所有已经审核过的订单
			 if(@$_GET["search"]==null){
			     $result=mysqli_query($con,"select * from t_groupmanage 
			     		where hotelManage='代订旅游' and groupName='".$travel."' and  startDate between '".$firstday."' and '".$today."'" );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     
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
			     $resultnow=mysqli_query($con,"select * from t_groupmanage  where  hotelManage='代订旅游' and groupName='".$travel."' 
			     		and startDate between '".$firstday."' and '".$today."' order by startDate desc  limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }else {
			     $sql="";
			     if($_GET["startDate"]!=""){
			         $startdate=$_GET["startDate"];
			         $enddate=$_GET["endDate"]!=""?$_GET["endDate"]:date("Y-m-d",time());
			         $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_GET["groupnum"]!=""?" and teamNumber like '%".$_GET["groupnum"]."%'":"";
			     $sql.=$_GET["cusname"]!=""?" and linkmanname like '%".$_GET["cusname"]."%'":"";
			     $result=mysqli_query($con,"select * from t_groupmanage  where  hotelManage='代订旅游' and groupName='".$travel."'
 ".$sql." order by id" );

			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
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
			     $resultnow=mysqli_query($con,"select * from t_groupmanage 
 where  hotelManage='代订旅游' and groupName='".$travel."' ".$sql." order by startDate desc limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			
			    
			$yfu=0;
			$qianfu=0;
			$countlinew=0;
			for($a=0;$a<count($resultnowarray);$a++){
			   $getyishousql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where groupNumber='".$resultnowarray[$a]["teamNumber"]."'");

			   $yishoure=mysqli_fetch_array($getyishousql);
$getyssql=mysqli_query($con, "select sum(sumPrice) as money from t_reserveplan where groupNumber='".$resultnowarray[$a]["teamNumber"]."'");
$ysre=mysqli_fetch_array($getyssql);
if($ysre["money"]-$yishoure["money"]>0){
			   $countlinew+=1;
			    ?>
			
			  <tr  >
			<td ><?php echo $countlinew;?>
			</td><td ><?php echo $resultnowarray[$a]["teamNumber"];?>
            </td><td ><?php echo $resultnowarray[$a]["startDate"];?>
            </td><td ><?php 
			 $ztsid=$resultnowarray[$a]['groupName'];
			 $ztssql=mysqli_query($con, "select travel_name from t_jgtravel where id=".$ztsid);
			 $zts=mysqli_fetch_array($ztssql);
			 echo $zts['travel_name'];
			 ?></td>
            <td  style="word-break:break-all; word-wrap:break-all;width:250px;"><?php echo $resultnowarray[$a]["guest"];?>
            </td><td ><?php 
       
            echo $ysre["money"];
            ?>
            </td><td ><?php 
			
           
            if($yishoure["money"]==null){
            	echo "0";
            }else {
            	echo $yishoure["money"];
            }
			?>
			</td>
			
			<td ><?php echo $ysre["money"]-$yishoure["money"];
			?>
            <input type="hidden" id="qs<?php echo $a+1;?>" value="<?php 
			echo $ysre["money"]-$yishoure["money"];
			?>">
            </td><td ><input type="text" name="skmoney[]"  onchange="changemoney();" class="xzmoney"  style="width: 50px;" id="xz<?php echo $a+1;?>" value="0"/>
			</td><td  >
			<input type="checkbox" name="issk[]" id="skchecksh<?php echo $a+1;?>" onclick="isskecheck(<?php echo $a+1;?>)" value="<?php echo $resultnowarray[$a]["id"];?>" />
</td></tr>
<?php			
}
 }
    ?>
		</tbody>
	</table>
	
	<script type="text/javascript">
<!--
function isskecheck(id){
	if($("#skchecksh"+id).is(':checked')){
		$("#xz"+id).val(parseInt($("#qs"+id).val()));
		lastmoney=parseInt($('#sklastmoney').html())-parseInt($('#xz'+id).val());
		if(lastmoney<0){
alert("余额不足！");
if(parseInt($('#sklastmoney').html())==0){
	 $("#skchecksh"+id).attr("checked",false);
}
$("#xz"+id).val(parseInt($('#sklastmoney').html()));
$('#sklastmoney').html(0);
$('#skhavingmoney').val(0);

			}else{
				$('#sklastmoney').html(lastmoney);
				$('#skhavingmoney').val(lastmoney);
				}
		
		}else{
			$('#sklastmoney').html(parseInt($('#sklastmoney').html())+parseInt($('#xz'+id).val()));
			$('#skhavingmoney').val(parseInt($('#sklastmoney').html())+parseInt($('#xz'+id).val()));
		}
}
function changemoney(){
	var total=0;
$(".xzmoney").each(function(i){
	var xzid=i+1
	if($(this).val()!=="0"&&$("#skchecksh"+xzid).is(':checked')){
	total+=parseInt($(this).val());
	}else if($(this).val()!=="0"&&!$("#skchecksh"+xzid).is(':checked')){
alert("请先选择！");
$(this).val("0");
return false;
		}
});
fkyuee=parseInt($('#allmoney').val())-total;
$('#sklastmoney').html(fkyuee);
$('#skhavingmoney').val(fkyuee);
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
			<span>条，共<?php echo $countlinew; ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo $countlinew; ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>