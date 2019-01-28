<?php
session_start();

require $_SESSION["ROOT"].'/db/db.php';
$id=$_GET["id"];
$result=mysqli_query($con, "select * from t_travel where id='".$id."'");
$arrayresult=mysqli_fetch_array($result);
// if(isset($_POST["groupnum"])){
//     $groupnum=$_POST["groupnum"];
//     $paytype=$_POST["paytype"];
//     $agent=$_POST["agent"];
//     $paytime=$_POST["paytime"];
//     $douser=$_POST["jd_id"];
//     $zh=$_POST["zh_id"];
//     $xz=$_POST["xz"];
//     $remark=$_POST["remark"];
//     $insertsql="insert into t_collectionunit(groupNumber,agent,payment,dater,payee,account,amount,remark)
// values('".$groupnum."','".$agent."','".$paytype."','".$paytime."','".$douser."','".$zh."','".$xz."','".$remark."')";
//     mysqli_query($con, $insertsql);
//     mysqli_query($con, "update t_account set money=money+".$xz." where id= ".$zh);
//     mysqli_query($con, "insert into t_moneychange(accountid,km,min,dotime,douser,changetype)values('".$zh."',
// '按单位收付款','".$xz."','".$paytime."','".$agent."','in')");
// }



if(isset($_POST["unit"])){
    $remark=array();
    $order=array();
    $groupnum=array();
    $paytype=array();
    $agent=array();
    $paytime=array();
    $zh=array();
    $xz=array();
    $douser=array();
//     $reserveplan=array();
    for($i=1;$i<21;$i++){
        if(isset($_POST["xz".$i])&&$_POST["xz".$i]!=""&&$_POST["xz".$i]!=0){
            array_push($groupnum,$_POST["groupnum".$i]);
            array_push($paytype,$_POST["paytype".$i]);
            array_push($agent,$_POST["agent".$i]);
            array_push($paytime,$_POST["paytime".$i]);
            array_push($zh,$_POST["zh".$i."_id"]);
            array_push($xz,$_POST["xz".$i]);
            array_push($remark,$_POST["remark".$i]);
            array_push($douser,$_POST["douser".$i."_id"]);
//             array_push($reserveplan,$_POST["reserveplan".$i]);
        }
        
    }
    array_push($order,$remark);
    array_push($order,$groupnum);
    array_push($order,$paytype);
    array_push($order,$agent);
    array_push($order,$paytime);
    array_push($order,$zh);
    array_push($order,$xz);
    array_push($order,$remark);
    array_push($order,$douser);
//     array_push($order,$reserveplan);
    $line=count($xz);
    for($q=0;$q<$line;$q++){
        mysqli_query($con, "insert into t_collectionunit(groupNumber,agent,payment,dater,payee,account,amount,remark)
 values ('".$order[1][$q]."','".$order[3][$q]."','".$order[2][$q]."','".$order[4][$q]."',
'".$order[8][$q]."','".$order[5][$q]."'
,'".$order[6][$q]."','".$order[7][$q]."')");
        mysqli_query($con, "update t_account set money=money+".$order[6][$q]." where id= ".$order[5][$q]);
        mysqli_query($con, "insert into t_moneychange(accountid,km,min,dotime,douser,changetype)values
('".$order[5][$q]."','按团号收付款','".$order[6][$q]."','".$order[4][$q]."','".$order[8][$q]."','in')");
        //         echo "insert into t_moneychange(accountid,km,mout,dotime,douser,changetype)values('".$order[5][$q]."','按团号收付款','".$order[6][$q]."','".$order[4][$q]."','".$order[8][$q]."','out')";
    }
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
	<form method="post" action="cwgl/dotuanout.php?id=<?php echo $id; ?>" class="pageForm required-validate" onsubmit="return navTabSearch(this);">
		<div class="pageFormContent" layoutH="56" >
			
			<p>
				<label>组团社：</label>
				<?php 
				echo $arrayresult["travel_name"];
				?>
			</p>


		
			<div style="clear: both;">
			<span style="float: left;">未下账</span>
			
			</div>
			<table class="table" width="100%" layoutH="138"  style="word-break:break-all; word-wrap:break-all;">
<tr style="background:#E0ECFF;height:20px;">
<th align="center" >序号</th>
<th align="center" >团号</th>
			<th align="center" >总应收</th>
			<th align="center" >剩余应收</th>
			<th align="center" >支付方式</th>
			<th align="center" >收款时间</th>
			<th align="center" >收款人</th>
			<th align="center" >收款账户</th>
			<th align="center" >下账</th>
			<th align="center" >备注</th>
			</tr>
			<?php 
			$teamnumsql=mysqli_query($con, "select teamNumber from t_groupmanage where groupName='".$id."'");
			$teamnum=mysqli_fetch_all($teamnumsql,MYSQLI_ASSOC);
			
			for($t=0;$t<count($teamnum);$t++){
			    $yingfu=0;
			    $yifu=0;
			    $qianfu=0;
			    $_plansql=mysqli_query($con, "select * from t_reserveplan where groupNumber='".$teamnum[$t]['teamNumber']."'");
			    $plan=mysqli_fetch_all($_plansql,MYSQLI_ASSOC);
			    for($q=0;$q<count($plan);$q++){
			        $yingfu+=$plan[$q]["sumPrice"];
			    }
			    $zmsql=mysqli_query($con, "select * from t_collectionunit where groupNumber='".$teamnum[$t]['teamNumber']."'");
			    $zm=mysqli_fetch_all($zmsql,MYSQLI_ASSOC);
			    
			        for($w=0;$w<count($zm);$w++){
			            $yifu+=$zm[$w]["amount"];
			        
			    }
			    $qianfu=$yingfu-$yifu;
			    
			    if($qianfu>0){
			    
			
			?>
		<tr  class="tableline">
		<td><?php echo $t+1;?></td>
		<td><?php echo $teamnum[$t]['teamNumber'];?></td>
			<td  >
			<?php 
			echo $yingfu;
			?>
			<input type="hidden" name="unit" value="1"/>
			<input type="hidden" name="agent<?php echo $t+1;?>" value="<?php echo $id;?>"/>
			<input type="hidden" name="groupnum<?php echo $t+1;?>" value="<?php echo $teamnum[$t]['teamNumber'];?>"/>
			</td>
			<td>
			<?php 
			echo $qianfu;
			?>
			</td>
			
			<td >
			<select width="100%" name="paytype<?php echo $t+1;?>">
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
		<input type="text" name="paytime<?php echo $t+1;?>" value="<?php 
			date_default_timezone_set('prc');
			echo date("Y-m-d",time());?>" class="date" size="30" readonly /><a class="inputDateButton" href="javascript:;">选择</a>
			</td>
			<td >
			
			<input type='hidden' name='douser<?php echo $t+1;?>.id' value='<?php echo $_SESSION["userid"]; ?>'/>
				<input type='text' class="required"   name='douser<?php echo $t+1;?>.douser<?php echo $t+1;?>' readonly value='<?php echo $_SESSION["user"]; ?>'style='width: 80%;' suggestFields='douser<?php echo $t+1;?>'  lookupGroup='douser<?php echo $t+1;?>' />
				<a class='btnLook' href="ajax/dh/douser.php?id=<?php echo $t+1;  ?>" lookupGroup='douser<?php echo $t+1;?>'>查找带回</a>
			</td>
			<td >
			<input type='hidden' name='zh<?php echo $t+1;?>.id' value=''/>
				<input type='text'  class="required"  name='zh<?php echo $t+1;?>.zh<?php echo $t+1;?>' readonly value=''style='width: 80%;' suggestFields='zh<?php echo $t+1;?>'  lookupGroup='zh<?php echo $t+1;?>' />
				<a class='btnLook' href="ajax/dh/zhduo.php?id=<?php echo $t+1;  ?>" lookupGroup='zh<?php echo $t+1;?>'>查找带回</a>
			</td>

			<td >
			<input type="text" class="number" style="width: 100%" value="<?php 
			echo $qianfu;
			?>"  name="xz<?php echo $t+1;?>"/>
			</td>
		<td>
		<input type="text" name="remark<?php echo $t+1;?>" style="width: 100%" />
			</td>
			

			
			 </tr>
			 <?php }}?>
		<tr style="background:#E0ECFF;height:20px;" id="newline">
		<td colspan="10" class="formBar" >
		<ul >
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
				<li></li>
				<li>
				<div class="buttonActive" ><div class="buttonContent"><button type="submit" style="float: ringht;">确认下账</button></div></div>
				</li>
			</ul>
		
		</td>
			</tr>
			<tr>
			<td colspan="10" class="formBar" >
			<div style="clear: both;">
			<span style="float: left;">已下账</span>
			
			</div>
			
			</td>
			</tr>
			<tr>
			<td colspan="10">
			<table class="table" width="100%"   style="word-break:break-all; word-wrap:break-all;">
			<tr style="background:#E0ECFF;height:20px;">
			<th align="center" >序号</th>
<th align="center" >团号</th>
			<th align="center" >支付方式</th>
			<th align="center" >收款时间</th>
			<th align="center" >收款人</th>
			<th align="center" >收款账户</th>
			<th align="center" >下账</th>
			<th align="center" >备注</th>
			</tr>
			<?php 

			$zmqsql=mysqli_query($con, "select * from t_collectionunit where agent='".$id."'");
			$zmq=mysqli_fetch_all($zmqsql,MYSQLI_ASSOC);
			$resultnum=count($zmq);
			@$page=ceil($resultnum/$numPerPage);
			@$sr=($pageNum-1)*$numPerPage;
			$resultnow=mysqli_query($con,"select * from t_collectionunit where agent='".$id."' limit ".$sr.",".$numPerPage );
			$zm=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
for($z=0;$z<count($zm);$z++){
			?>
			<tr>
				<td><?php echo $z+1;?></td>
		<td><?php echo $zm[$z]['groupNumber'];?></td>
			<td >
			<?php 
			$getpaysql=mysqli_query($con, "select * from t_paymenttype where id=".$zm[$z]["payment"]);
			$getpay=mysqli_fetch_array($getpaysql,MYSQLI_ASSOC);
			echo $getpay["paymentname"];
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
