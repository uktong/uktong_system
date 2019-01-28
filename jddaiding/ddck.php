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
    $numPerPage=20;
    $pageNum=1;
}


require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
$yestoday=date("Y-m-d",strtotime("  -1 day"));
?>
<script type="text/javascript" src="ajax/js/main.js"></script>
<script type="text/javascript" >
function test(){
	window.open("other/print.php?"+$("#jdyfcxform").serialize());
}

</script>
<form id="pagerForm" method="post" action="jddaiding/ddck.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" id="jdyfcxform" action="jddaiding/ddck.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
			<td class="dateRange">
					入住日期:
					<input name="startDate" class="date readonly" minDate="%y-%M-{%d-1}" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$yestoday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
				<td >
					对接人:
					<input type="hidden" name="jd.id" value="<?php echo @$_POST["jd_id"];?>"/>
				<input type="text" class="getjd" name="jd.jd" value="<?php echo @$_POST["jd_jd"];?>" readonly style="width:100px; " suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" href="ajax/dh/jd.php"style="float:right;margin-right:100px;"  lookupGroup="jd">选择用户</a>
				</td>
				<td >
					路早:
					<select  name="luzao" class="" style='width: 70%;' >
		<option value="">全部</option>
		<option value="0">正常早餐</option>
		<option value="1">路早</option>
	</select>
				</td>
<!-- 				<td > -->
<!-- 					酒店: -->

<!-- 				</td> -->
<!-- 				</tr>--><tr> 
				<td >
					房型:
						<select  name="fjtype111.id" class="getfjtype111>" style='width: 70%;' >
		<option value="">全部</option>
	<?php 
	$getfjtype=mysqli_query($con, "select * from t_baseconfig where basenote=2 order by px desc");
	$fjtypere=mysqli_fetch_all($getfjtype,MYSQLI_ASSOC);
	for($f=0;$f<count($fjtypere);$f++){
	?>
	<option value="<?php echo $fjtypere[$f]["id"];?>" <?php echo $fjtypere[$f]["id"]==@$_POST["fjtype111_id"]?"selected='selected'":"";?>><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select>
				</td>
				<td >
					团号:
					<input name="groupnum"  type="text" size="30" value="<?php echo @$_POST["groupnum"];?>" />
				</td>
				<td >
					客人姓名:
					<input name="cusname"  type="text" size="30" value="<?php echo @$_POST["cusname"];?>" />
				</td>
			
				<td><button type="submit">搜索</button></td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<input name="searchtype"  type="hidden" size="30" value="jdyfcx"/>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">

	</div>
	<table class="table" width="100%" layoutH="158" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">酒店</th>
				<th align="center">酒店状态</th>
				<th align="center">路早</th>
				<th align="center">对接人</th>
				<th align="center">日期</th>
				<th align="center">房型</th>
				<th align="center">客人姓名</th>
				<th align="center">数量</th>
				<th align="center">天数</th>
				<th align="center" >累计数</th>
				<th align="center">单价</th>
				<th align="center">应付</th>
<th align="center">已付</th>
<th align="center">欠付</th>
			</tr>
		</thead>
		<tbody>
			
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
			 $hotelcode=$_SESSION["hotelcode"];
			 $idsql=mysqli_query($con, "select id from t_allhotel where hotelcode='".$hotelcode."'");
			 $idre=mysqli_fetch_array($idsql);
			 
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.hotelName='".$idre["id"]."' and  t_reserveplan.startDate between '".$yestoday."' and '".$lastday."'" );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     
			     for($z=0;$z<count($resultarray);$z++){
			         $yifuzsql=mysqli_query($con, "select fee from t_hoteldebt where name=".$resultarray[$z]['hotelName']."  and
 groupnumber='".$resultarray[$z]["teamNumber"]."' and reserveplan=".$resultarray[$z]["id"]);
			         @$yifuz=mysqli_fetch_all($yifuzsql,MYSQLI_ASSOC);
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
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber  where t_reserveplan.hotelName='".$idre["id"]."' and t_reserveplan.startDate between '".$yestoday."' and '".$lastday."' order by t_reserveplan.startDate desc  limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }else {
			     $sql="";
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         $sql.=" and t_reserveplan.startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_POST["luzao"]!=""?" and breakfast='".$_POST["luzao"]."'":"";
			     $sql.=$_POST["jd_id"]!=""?" and t_groupmanage.jd='".$_POST["jd_id"]."'":"";
			     $sql.=$_POST["fjtype111_id"]!=""?" and t_reserveplan.roomType='".$_POST["fjtype111_id"]."'":"";
// 			     $sql.=$_POST["jdian111_id"]!=""?" and t_reserveplan.hotelName='".$_POST["jdian111_id"]."'":"";
			     $sql.=$_POST["groupnum"]!=""?" and t_groupmanage.teamNumber like '%".$_POST["groupnum"]."%'":"";
			     $sql.=$_POST["cusname"]!=""?" and t_groupmanage.guest like '%".$_POST["cusname"]."%'":"";
			     $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.hotelName='".$idre["id"]."'  ".$sql." order by t_groupmanage.id" );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
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
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.hotelName='".$idre["id"]."' ".$sql." order by t_reserveplan.startDate desc limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			
			    
			$yfu=0;
			$qianfu=0;
			for($a=0;$a<count($resultnowarray);$a++){
			   
			    ?>
			    
			    <tr  >
			<td  >
			<?php echo $a+1;?>
			</td>
			<td  >
			<?php echo $resultnowarray[$a]["teamNumber"];?>
			</td>
		
			<td>
			<?php 
			$jddianid=$resultnowarray[$a]['hotelName'];
			$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			$jddian=mysqli_fetch_array($jddiansql);
			
			echo $jddian['hotelname'];
			?>
			</td>
			<td>
			<?php 
			if($resultnowarray[$a]['lxsstatus']=="yes"){
			    
			    $orderstates="<span style='color:green;'>已确认</span>";
			}else{
			    $orderstates="<span style='color:red;'>未确认</span>";
			}
			echo $orderstates;
			?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["breakfast"]=="1"?"路早":"正常早餐";?>
			</td>
			<td  ><?php 
			$jdid=$resultnowarray[$a]["jd"];
			$jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
			$jd=mysqli_fetch_array($jdsql);
			echo $jd["username"];
			?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["startDate"];?>
			</td>
			<td  ><?php
			$fxid= $resultnowarray[$a]["roomType"];
			$fxsql=mysqli_query($con, "select basetype from t_baseconfig where id=".$fxid);
			$fx=mysqli_fetch_array($fxsql);
			echo $fx["basetype"];
			?>
			</td>
			<td  style='width:200px;word-wrap: break-word;'><?php echo $resultnowarray[$a]["guestName"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["number"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["dayNum"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["number"]*$resultnowarray[$a]["dayNum"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["costPrice"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["hotelCommissionSum"];?>
			</td>
			<td>
			<?php 
			$yifusql=mysqli_query($con, "select fee from t_hoteldebt where name=".$jddianid."  and
 groupnumber='".$resultnowarray[$a]["teamNumber"]."' and reserveplan=".$resultnowarray[$a]["id"]);
			@$yifu=mysqli_fetch_all($yifusql,MYSQLI_ASSOC);
			$yifuje=0;
			for($yf=0;$yf<count($yifu);$yf++){
			    $yifuje+=@$yifu[$yf]["fee"];
			}
			echo $yifuje;
			?>
			</td>
			<td>
			<?php 
			echo $resultnowarray[$a]["hotelCommissionSum"]-$yifuje;
			?>
			
			</td>
			</tr>
		<?php
		$shuliang+=$resultnowarray[$a]["number"];
		$tianshu+=$resultnowarray[$a]["dayNum"];
		$danjia+=$resultnowarray[$a]["costPrice"];
		$jine+=$resultnowarray[$a]["hotelCommissionSum"];
		$leiji+=$resultnowarray[$a]["number"]*$resultnowarray[$a]["dayNum"];
		$yfu+=$yifuje;
		$qianfu+=($resultnowarray[$a]["hotelCommissionSum"]-$yifuje);
			}
			
    ?>
	    <tr class="tfoot">
				<th align="center">小计：</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>

				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $shuliang;?></th>
				<th align="center"><?php echo $tianshu;?></th>
				<th align="center"><?php echo $leiji;?></th>
				<th align="center"><?php echo $danjia;?></th>
				<th align="center"><?php echo $jine;?></th>
				<th align="center"><?php echo $yfu;?></th>
				<th align="center"><?php echo $qianfu;?></th>
			</tr>
			
			 <tr class="tfoot">
				<th align="center">总计：</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>

				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $shuliangz;?></th>
				<th align="center"><?php echo $tianshuz;?></th>
				<th align="center"><?php echo $leijiz;?></th>
				<th align="center"><?php echo $danjiaz;?></th>
				<th align="center"><?php echo $jinez;?></th>
				<th align="center"><?php echo $yfuz;?></th>
				<th align="center"><?php echo $qianfuz;?></th>
			</tr>
	    </tbody>
	</table>
	<style>
	.tfoot{
		height:30px;
		line-height:30px;
		background-color:#eef3ff;
		
	}
	.tfoot:hover{
		background-color:#eef3ff;
	}
	</style>
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
			<span>条，共<?php echo count($resultarray); ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo count($resultarray); ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
</div>