<?php
session_start();

require $_SESSION["ROOT"].'/db/db.php';
$id=$_GET["id"];
$result=mysqli_query($con, "select * from t_groupmanage where id='".$id."'");
$arrayresult=mysqli_fetch_array($result);
if(isset($_POST["groupnum"])){
    $groupnum=$_POST["groupnum"];
    $paytype=$_POST["paytype"];
    $agent=$_POST["agent"];
    $paytime=$_POST["paytime"];
    $douser=$_POST["jd_id"];
    $zh=$_POST["zh_id"];
    $xz=$_POST["xz"];
    $remark=$_POST["remark"];
    $insertsql="insert into t_collectionunit(groupNumber,agent,payment,dater,payee,account,amount,remark) 
values('".$groupnum."','".$agent."','".$paytype."','".$paytime."','".$douser."','".$zh."','".$xz."','".$remark."')";
    mysqli_query($con, $insertsql);
    //扣除指定账号款项
    mysqli_query($con, "update t_account set money=money+".$xz." where id= ".$zh);
    mysqli_query($con, "insert into t_moneychange(accountid,km,min,dotime,douser,changetype)values('".$zh."',
'按团号收付款','".$xz."','".$paytime."','".$agent."','in')");
}
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

?>

<form id="pagerForm" method="post" action="cwgl/dotuanout.php?id=<?php echo $id; ?>">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>
<script type="text/javascript" src="ajax/js/main.js">
<!--

//-->
</script>
<div class="pageContent">
	<form method="post" action="cwgl/dotuanin.php?id=<?php echo $id; ?>" class="pageForm required-validate" onsubmit="return navTabSearch(this);">
		<div class="pageFormContent" layoutH="56" >
			<p>
				<label>我社团号：</label>
				<?php echo $arrayresult['teamNumber'];?>
			</p> 
			<p>
				<label>计调：</label>
				<?php
				$jdsql=mysqli_query($con, "select username from t_user where id=".$arrayresult['jd']);
				$jd=mysqli_fetch_array($jdsql);
				echo $jd['username'];
				?>
			</p>
			<p>
				<label>系统状态：</label>
				<?php 
				    echo "<span style='color:green;'>已成团</span>";
				?>
			</p>
			<p>
				<label>代订项目：</label>
				代订酒店
				
			</p>
			<p>
				<label>发团日期：</label>
				<?php echo $arrayresult['startDate'];?>
			</p>
			<p>
			<label>散团日期：</label>
			<?php echo $arrayresult['endDate'];?>
			</p>
			<p>
				<label>组团社：</label>
				<?php 
				$ztssql=mysqli_query($con, "select travel_name,id from t_travel where id=".$arrayresult['groupName']);
				$zts=mysqli_fetch_array($ztssql); 
				echo $zts["travel_name"];
				?>
			</p>
			<p>
				<label>组团社团号：</label>
				<?php echo $arrayresult['groupNumber'];?>
			</p>
			<p>
				<label>联系人：</label>
				<?php 
				$lxrsql=mysqli_query($con, "select name from t_linkman where id=".$arrayresult['linkman']);
				$lxr=mysqli_fetch_array($lxrsql);
				echo $lxr["name"];
				?>
			</p>
			<p>
				<label>人数：</label>
				<?php echo $arrayresult['guestnum'];?>
			</p>
	
	<p>
				<label>外联：</label>
				<?php 
				$wlsql=mysqli_query($con, "select username from t_user where id=".$arrayresult['wl']);
				$wl=@mysqli_fetch_array($wlsql);
				echo $wl['username'];
				?>
			</p>
			<p>
				<label>客人：</label>
				<?php 
				echo $arrayresult['guest'];
				?>
			</p>
			<p>
				<label>预定时间：</label>
				<?php 
				echo $arrayresult['enteringDate'];
				?>
			</p>
			<p>
				<label>备注：</label>
				<?php 
				echo $arrayresult['remark'];
				?>
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
			<th align="center" >总应收</th>
			<th align="center" >剩余应收</th>
			<th align="center" >支付方式</th>
			<th align="center" >收款时间</th>
			<th align="center" >收款人</th>
			<th align="center" >收款账户</th>
			<th align="center" >下账</th>
			<th align="center" >备注</th>
			</tr>
		<tr  class="tableline">
			<td  >
			<?php 
			$_plansql=mysqli_query($con, "select * from t_reserveplan where groupNumber='".$arrayresult['teamNumber']."'");
			$plan=mysqli_fetch_all($_plansql,MYSQLI_ASSOC);
			$zmsql=mysqli_query($con, "select * from t_collectionunit where groupNumber='".$arrayresult['teamNumber']."'");
			$zm=mysqli_fetch_all($zmsql,MYSQLI_ASSOC);
			$yifu=0;
			if(count($zm)==0){
			    $yifu=0;
			}else{
			    for($w=0;$w<count($zm);$w++){
			        $yifu+=$zm[$w]["amount"];
			    }
			}
			$shuliang=0;
			$tianshu=0;
			$yingfu=0;
			
			
			for($q=0;$q<count($plan);$q++){
			    $shuliang+=$plan[$q]["number"];
			    $tianshu+=$plan[$q]["dayNum"];
			    $yingfu+=$plan[$q]["sumPrice"];
			}
			echo $yingfu;
			$qianfu=$yingfu-$yifu;
			?>
			<input type="hidden" name="agent" value="<?php echo $zts["id"];?>"/>
			<input type="hidden" name="groupnum" value="<?php echo $arrayresult['teamNumber'];?>"/>
			</td>
			<td>
			<?php 
			echo $qianfu;
			?>
			</td>
			
			<td >
			<select width="100%" name="paytype">
			<?php 
			$paysql=mysqli_query($con, "select * from t_baseconfig where basenote=5 ");
			$pay=mysqli_fetch_all($paysql,MYSQLI_ASSOC);
			for($p=0;$p<count($pay);$p++){
			    
		
			?>
			<option  value="<?php echo $pay[$p]["id"];?>"><?php echo $pay[$p]["basetype"];?></option>
			<?php 	}?>
			</select>
			
			</td>
			<td >
			<input type="text" name="paytime" value="<?php 
			date_default_timezone_set('prc');
			echo date("Y-m-d",time());?>" class="date" size="30" readonly /><a class="inputDateButton" href="javascript:;">选择</a>
			</td>
			<td >
			
			<input type="hidden" name="jd.id" value="<?php echo $_SESSION["userid"]; ?>"/>
				<input type="text"  class="required getjd" name="jd.jd" value="<?php echo $_SESSION["user"]; ?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" href="ajax/dh/jd.php" lookupGroup="jd">选择用户</a>
			</td>
			<td >
			<input type="hidden" name="zh.id" value=""/>
				<input type="text" readonly class="required getzh" name="zh.zh" value="" suggestFields="zh"  lookupGroup="zh" />
				<a class="btnLook" href="ajax/dh/zh.php" lookupGroup="zh">选择用户</a>
			</td>

			<td >
			<input type="text" class="number" style="width: 100%"  value="<?php 
			echo $qianfu;
			?>" name="xz"/>
			</td>
		<td>
		<input type="text" name="remark" style="width: 100%" />
			</td>
			

			
			 </tr>
		<tr style="background:#E0ECFF;height:20px;" id="newline">
		<td colspan="8" class="formBar" >
		<ul >
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
				<li></li>
				<li>
				<div class="buttonActive" ><div class="buttonContent"><button type="submit" style="float: ringht;">保存</button></div></div>
				</li>
			</ul>
		
		</td>
			</tr>
			<tr>
			<td colspan="8" class="formBar" >
			<div style="clear: both;">
			<span style="float: left;">已下账</span>
			
			</div>
			
			</td>
			</tr>
			<tr>
			<td colspan="8">
			<table class="table" width="100%"   style="word-break:break-all; word-wrap:break-all;">
			<tr style="background:#E0ECFF;height:20px;">
			<th align="center" >支付方式</th>
			<th align="center" >收款时间</th>
			<th align="center" >收款人</th>
			<th align="center" >收款账户</th>
			<th align="center" >下账</th>
			<th align="center" >备注</th>
			</tr>
			<?php 
			$zmqsql=mysqli_query($con, "select * from t_collectionunit where groupNumber='".$arrayresult['teamNumber']."'");
			$zmq=mysqli_fetch_all($zmqsql,MYSQLI_ASSOC);
			$resultnum=count($zmq);
			@$page=ceil($resultnum/$numPerPage);
			@$sr=($pageNum-1)*$numPerPage;
			$resultnow=mysqli_query($con,"select * from t_collectionunit where groupNumber='".$arrayresult['teamNumber']."' limit ".$sr.",".$numPerPage );
			$zm=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);

for($z=0;$z<count($zm);$z++){
			?>
			<tr>
			<td >
			<?php 
			$getpaysql=mysqli_query($con, "select * from  t_baseconfig where basenote=5 and id=".$zm[$z]["payment"]);
			$getpay=mysqli_fetch_array($getpaysql,MYSQLI_ASSOC);
			echo $getpay["basetype"];
			?>
		
			
			</td>
			<td >
			<?php echo $zm[$z]["dater"];?>
			</td>
			<td >
			
			<?php
			$skrsql=mysqli_query($con, "select username from t_user where id=".$zm[$z]["payee"]);
			$skr=mysqli_fetch_array($skrsql);
			echo $skr['username'];
			?>
			</td>
			<td >
			<?php
			$zhsql=mysqli_query($con, "select accountTitle from t_account where id=".$zm[$z]["account"]);
			$zh=mysqli_fetch_array($zhsql);
			echo $zh['accountTitle'];
			?>
			</td>

			<td >
			<?php echo $zm[$z]["amount"];?>
			</td>
		<td>
		<?php echo $zm[$z]["remark"];?>
			</td>
			</tr>
			<?php }?>
			</table>
			</td>
			
			</tr>
				</table>

				<script type="text/javascript">

	</script>
		</div>

		
	</form>
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
			<span>条，共<?php echo count($zm); ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo count($zm); ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
</div>
