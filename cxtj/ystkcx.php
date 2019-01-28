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
?>
<script type="text/javascript" src="ajax/js/main.js"></script>
<script type="text/javascript" >
function test(){
	window.open("other/print.php?"+$("#searchform").serialize());
}

</script>
<form id="pagerForm" method="post" action="cxtj/ystkcx.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="cxtj/ystkcx.php" id="searchform" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
			<td class="dateRange">
					入住日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
				<td >
					计调:
					<input type="hidden" name="jd.id" value="<?php echo @$_POST["jd_id"];?>"/>
				<input type="text" class="getjd" name="jd.jd" value="<?php echo @$_POST["jd_jd"];?>" suggestFields="jd"  lookupGroup="jd" />
				</td>
				<td >
					酒店:
				<input type="hidden" name="jdian111.id" value="<?php echo @$_POST["jdian111_id"];?>"/>
				<input type="text" class="getjdian111" oninput="getjdian(111);" name="jdian111.jdian111" value="<?php echo @$_POST["jdian111_jdian111"];?>" suggestFields="jdian111"   lookupGroup="jdian111" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jdian.php?id=111" lookupGroup="jdian111">选择酒店</a>
				</td>
				<td >
					联系人:
					<input name="linkman"  type="text" size="30" value="<?php echo @$_POST["linkman"];?>" />
				</td>
				</tr><tr>
				<td >
					房型:
				<input type="hidden" name="fjtype111.id" value="<?php echo @$_POST["fjtype111_id"];?>"/>
				<input type="text"  name="fjtype111.fjtype111" value="<?php echo @$_POST["fjtype111_fjtype111"];?>" suggestFields="fjtype111" suggestUrl="ajax/xlk/fjtype.php?id=111" readonly lookupGroup="fjtype111" />
				</td>
				<td >
					团号:
					<input name="groupnum"  type="text" size="30" value="<?php echo @$_POST["groupnum"];?>" />
				</td>
				<td >
					客人姓名:
					<input name="cusname"  type="text" size="30" value="<?php echo @$_POST["cusname"];?>" />
				</td>
				<td >
					组团社:
				<input type="hidden" name="zts.id" value="<?php echo @$_POST["zts_id"];?>"/>
				<input type="text" class="getzts" name="zts.zts" value="<?php echo @$_POST["zts_zts"];?>" suggestFields="zts"   lookupGroup="zts" />
				<a class="btnLook" style="float: right;" href="ajax/dh/zts.php" lookupGroup="zts">选择组团社</a>
				</td>
				<td><button type="submit">搜索</button></td><td><button type="button" onclick="test()">打印</button></td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<input name="searchtype"  type="hidden" size="30" value="ystkcx"/>
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
				<th align="center">我社团号</th>
				<th align="center">组团社</th>
				<th align="center">人数</th>
				<th align="center">路早</th>
				<th align="center">计调	</th>
				<th align="center">日期</th>
				<th align="center">房型</th>
				<th align="center">客人姓名</th>
				<th align="center">数量</th>
				<th align="center">天数</th>
				<th align="center" >累计数</th>
				<th align="center">单价</th>
				<th align="center">金额</th>

			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 
			 $shuliangz=0;
			 $tianshuz=0;
			 $danjiaz=0;
			 $jinez=0;
			 $leijiz=0;
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_groupmanage.hotelManage='代订酒店' and t_reserveplan.startDate between '".$firstday."' and '".$lastday."'" );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			 
			     for($z=0;$z<count($resultarray);$z++){
			         $shuliangz+=$resultarray[$z]["number"];
			         $tianshuz+=$resultarray[$z]["dayNum"];
			         $danjiaz+=$resultarray[$z]["groupPrice"];
			         $jinez+=$resultarray[$z]["sumPrice"];
			         $leijiz+=$resultarray[$z]["number"]*$resultarray[$z]["dayNum"];
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber  where t_groupmanage.hotelManage='代订酒店' and t_reserveplan.startDate between '".$firstday."' and '".$lastday."' order by t_groupmanage.id  limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }else {
			     $sql="";
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         $sql.=" and t_reserveplan.startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_POST["zts_id"]!=""?" and t_groupmanage.groupName='".$_POST["zts_id"]."'":"";
			     $sql.=$_POST["jd_id"]!=""?" and t_groupmanage.jd='".$_POST["jd_id"]."'":"";
			     $sql.=$_POST["fjtype111_id"]!=""?" and t_reserveplan.roomType='".$_POST["fjtype111_id"]."'":"";
			     $sql.=$_POST["jdian111_id"]!=""?" and t_reserveplan.hotelName='".$_POST["jdian111_id"]."'":"";
			     $sql.=$_POST["groupnum"]!=""?" and t_groupmanage.teamNumber like '%".$_POST["groupnum"]."%'":"";
			     $sql.=$_POST["cusname"]!=""?" and t_groupmanage.guest like '%".$_POST["cusname"]."%'":"";
			     $sql.=$_POST["linkman"]!=""?" and t_groupmanage.linkmanname like '%".$_POST["linkman"]."%'":"";
			     $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_groupmanage.hotelManage='代订酒店'  ".$sql." order by t_groupmanage.id" );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			         $shuliangz+=$resultarray[$z]["number"];
			         $tianshuz+=$resultarray[$z]["dayNum"];
			         $danjiaz+=$resultarray[$z]["groupPrice"];
			         $jinez+=$resultarray[$z]["sumPrice"];
			         $leijiz+=$resultarray[$z]["number"]*$resultarray[$z]["dayNum"];
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_groupmanage.hotelManage='代订酒店'  ".$sql." order by t_groupmanage.id limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }

			    
			     $shuliang=0;
			     $tianshu=0;
			     $danjia=0;
			     $jine=0;
			     $leiji=0;
			
			for($a=0;$a<count($resultnowarray);$a++){
			   
			    $jdid=$resultnowarray[$a]['jd'];
			    $jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
			    $jd=mysqli_fetch_array($jdsql);
			    $ztsid=$resultnowarray[$a]['groupName'];
			    $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			    @$zts=mysqli_fetch_array($ztssql); 
			    ?>
			    
			    <tr  >
			<td  >
			<?php echo $a+1;?>
			</td>
			<td  >
			<?php echo $resultnowarray[$a]["teamNumber"];?>
			</td>
			<td  ><?php 
			echo $zts['travel_name'];
			?>
			</td>
		
			<td  ><?php echo $resultnowarray[$a]["number"];?>
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
			<td  style="word-break:break-all; word-wrap:break-all;width:300px;"><?php echo $resultnowarray[$a]["guestName"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["number"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["dayNum"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["number"]*$resultnowarray[$a]["dayNum"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["groupPrice"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["sumPrice"];?>
			</td>
			</tr>
		<?php
		$shuliang+=$resultnowarray[$a]["number"];
		$tianshu+=$resultnowarray[$a]["dayNum"];
		$danjia+=$resultnowarray[$a]["groupPrice"];
		$jine+=$resultnowarray[$a]["sumPrice"];
		$leiji+=$resultnowarray[$a]["number"]*$resultnowarray[$a]["dayNum"];
			}
 
    ?>
	    <tr class="tfoot">
				<th align="center">小计：</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th><th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $shuliang;?></th>
				<th align="center"><?php echo $tianshu;?></th>
				<th align="center"><?php echo $leiji;?></th>
				<th align="center"><?php echo $danjia;?></th>
				<th align="center"><?php echo $jine;?></th>
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