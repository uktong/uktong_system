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
    $numPerPage=10;
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
	window.open("other/print.php?"+$("#skmxcxbox").serialize());
}

</script>
<form id="pagerForm" method="post" action="cxtj/skmxcx.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" id="skmxcxbox" action="cxtj/skmxcx.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				<td class="dateRange">
					按收款日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
				<td >
					收款方式:
					<select width="100%" name="paytype">
					<option  value="">----</option>
			<?php 
			$paysql=mysqli_query($con, "select * from t_paymenttype ");
			$pay=mysqli_fetch_all($paysql,MYSQLI_ASSOC);
			for($p=0;$p<count($pay);$p++){
			    
		
			?>
			<option  value="<?php echo $pay[$p]["id"];?>"><?php echo $pay[$p]["paymentname"];?></option>
			<?php 	}?>
			</select>
				</td>
				<td >
					收款账号:
					<input type="hidden" name="zh.id" value="<?php echo @$_POST["zh_id"];?>"/>
				<input type="text" readonly class=" getzh" name="zh.zh" value="<?php echo @$_POST["zh_zh"];?>" suggestFields="zh"  lookupGroup="zh" />
				<a class="btnLook" style="float: right;" href="ajax/dh/zh.php" lookupGroup="zh">选择用户</a>
				</td></tr><tr>
				<td >
					收款人:
					<input type="hidden" name="wl.id" value="<?php echo @$_POST["wl_id"];?>"/>
				<input type="text"  class=" getwl" name="wl.wl" value="<?php echo @$_POST["wl_wl"];?>" suggestFields="wl"  lookupGroup="wl" />
				<a class="btnLook" style="float: right;" href="ajax/dh/wl.php" lookupGroup="wl">选择用户</a>
				</td>
				<td >
					组团社:
				<input type="hidden" name="zts.id" value="<?php echo @$_POST["zts_id"];?>"/>
				<input type="text" class="getzts" name="zts.zts" value="<?php echo @$_POST["zts_zts"];?>" suggestFields="zts"   lookupGroup="zts" />
				<a class="btnLook" style="float: right;" href="ajax/dh/zts.php" lookupGroup="zts">选择组团社</a>
				</td>
				
				
				<td >
					计调:
					<input type="hidden" name="jd.id" value="<?php echo @$_POST["jd_id"];?>"/>
				<input type="text" class="getjd" name="jd.jd" value="<?php echo @$_POST["jd_jd"];?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jd.php" lookupGroup="jd">选择用户</a>
				</td>
				<td >
					团号:
					<input name="groupnum"  type="text" size="30" value="<?php echo @$_POST["groupnum"];?>" />
				</td>
				<td><button type="submit">搜索</button></td><td><button type="button" onclick="test()">打印</button></td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<input name="searchtype"  type="hidden" size="30" value="skmxcx"/>
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
				<th align="center">单位</th>
				<th align="center">账号</th>
				<th align="center">收款人</th>
				<th align="center">收款方式</th>
				<th align="center">收款金额</th>
				<th align="center">日期</th>
				<th align="center">备注</th>

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
			 $yfu=0;
			 $qianfu=0;
			 
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"select * from t_collectionunit where dater between '".$firstday."' and '".$lastday."'" );
			     //echo "select * from t_groupmanage where updateDate between '".$firstday."' and '".$firstday."'";
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			         $jinez+=$resultarray[$z]["amount"];
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_collectionunit where dater between '".$firstday."' and '".$lastday."' order by id DESC limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }else {
			     $sql="";
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         $sql.=" and dater between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_POST["paytype"]!=""?" and payment='".$_POST["paytype"]."'":"";
			     $sql.=$_POST["zh_id"]!=""?" and account='".$_POST["zh_id"]."'":"";
			     $sql.=$_POST["zts_id"]!=""?" and agent='".$_POST["zts_id"]."'":"";
			     $sql.=$_POST["jd_id"]!=""?" and operator='".$_POST["jd_id"]."'":"";
			     $sql.=$_POST["wl_id"]!=""?" and payee='".$_POST["wl_id"]."'":"";
			     $sql.=$_POST["groupnum"]!=""?" and groupNumber like '%".$_POST["groupnum"]."%'":"";
			     $result=mysqli_query($con,"select * from t_collectionunit where 1=1 ".$sql );
			    //  echo "select * from t_collectionunit where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			         $jinez+=$resultarray[$z]["amount"];
			     }
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_collectionunit where 1=1 ".$sql." order by id DESC limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			for($a=0;$a<count($resultnowarray);$a++){
			    $teamnum=$resultnowarray[$a]['groupNumber'];
			    $gettravelidsql=mysqli_query($con, "select groupName from t_groupmanage where teamNumber='".$teamnum."'");
			    $gettravelid=mysqli_fetch_array($gettravelidsql);

			    $ztsid=$gettravelid['groupName'];
			    $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			    $zts=mysqli_fetch_array($ztssql); 
			    ?>
			    
			    <tr  >
			<td  >
			<?php echo $a+1;?>
			</td>

			<td  ><?php 
			echo $zts['travel_name'];
			?>
			</td>
			<td  ><?php 
			$zhsql=mysqli_query($con, "select accountTitle from t_account where id=".$resultnowarray[$a]["account"]);
			$zh=mysqli_fetch_array($zhsql);
			echo $zh['accountTitle'];
			
			?>
			</td>
			
			
			<td  ><?php 
			$skrsql=mysqli_query($con, "select username from t_user where id=".$resultnowarray[$a]["payee"]);
			$skr=mysqli_fetch_array($skrsql);
			echo $skr['username'];
			?>
			
			<td  ><?php
			$getpaysql=mysqli_query($con, "select * from t_paymenttype where id=".$resultnowarray[$a]["payment"]);
			$getpay=mysqli_fetch_array($getpaysql,MYSQLI_ASSOC);
			echo $getpay["paymentname"];
			?>
			</td>
			
			<td  ><?php echo $resultnowarray[$a]["amount"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["dater"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["remark"];?>
			</td>
			
			</tr>
		<?php

		$jine+=$resultnowarray[$a]["amount"];

			}
		
    ?>
	    <tr class="tfoot">
				<th align="center">小计：</th>
				<th align="center"></th>
				<th align="center"></th>

				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $jine;?></th>
				<th align="center"></th>
				<th align="center"></th>
			</tr>
			
			 <tr class="tfoot">
				<th align="center">总计：</th>
				<th align="center"></th>
				<th align="center"></th>

				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $jinez;?></th>
				<th align="center"></th>
				<th align="center"></th>
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