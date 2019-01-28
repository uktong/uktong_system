<?php
session_start();

require $_SESSION["ROOT"].'/db/db.php';
$id=$_GET["id"];
$result=mysqli_query($con, "select * from t_groupmanage where id='".$id."'");
$arrayresult=mysqli_fetch_array($result);
if(isset($_POST["unit"])){
    $remark=array();
    $order=array();
    $groupnum=array();
    $paytype=array();
    $hotelname=array();
    $paytime=array();
    $zh=array();
    $xz=array();
    $douser=array();
    $reserveplan=array();
    for($i=1;$i<21;$i++){
        if(isset($_POST["xz".$i])&&$_POST["xz".$i]!=""&&$_POST["xz".$i]!=0){
            array_push($groupnum,$_POST["groupnum".$i]);
            array_push($paytype,$_POST["paytype".$i]);
            array_push($hotelname,$_POST["hotelname".$i]);
            array_push($paytime,$_POST["paytime".$i]);
            array_push($zh,$_POST["zh".$i."_id"]);
            array_push($xz,$_POST["xz".$i]);
            array_push($remark,$_POST["remark".$i]);
            array_push($douser,$_POST["douser".$i."_id"]);
            array_push($reserveplan,$_POST["reserveplan".$i]);
        }
        
    }
    array_push($order,$remark);
    array_push($order,$groupnum);
    array_push($order,$paytype);
    array_push($order,$hotelname);
    array_push($order,$paytime);
    array_push($order,$zh);
    array_push($order,$xz);
    array_push($order,$remark);
    array_push($order,$douser);
    array_push($order,$reserveplan);
    $line=count($xz);
    for($q=0;$q<$line;$q++){
        mysqli_query($con, "insert into t_hoteldebt(fee,payee,remark,name,payType
,account,groupnumber,createTime,reserveplan) values ('".$order[6][$q]."','".$order[8][$q]."','".$order[0][$q]."','".$order[3][$q]."',
'".$order[2][$q]."','".$order[5][$q]."'
,'".$order[1][$q]."','".$order[4][$q]."','".$order[9][$q]."')");
        mysqli_query($con, "update t_account set money=money-".$order[6][$q]." where id= ".$order[5][$q]);
        mysqli_query($con, "insert into t_moneychange(accountid,km,mout,dotime,douser,changetype)values('".$order[5][$q]."','按团号收付款','".$order[6][$q]."','".$order[4][$q]."','".$order[8][$q]."','out')");
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

<form id="pagerForm" method="post" action="cwgl/dogroupout.php?id=<?php echo $id; ?>">
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
	<form method="post" action="cwgl/dogroupout.php?id=<?php echo $id; ?>" class="pageForm required-validate" onsubmit="return navTabSearch(this);">
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
<th align="center" >酒店</th>
			<th align="center" >总应付款</th>
			<th align="center" >剩余应付</th>
			<th align="center" >支付方式</th>
			<th align="center" >付款时间</th>
			<th align="center" >付款人</th>
			<th align="center" >付款账户</th>
			<th align="center" >下账</th>
			<th align="center" >备注</th>
			</tr>
		
		<?php 
			$_plansql=mysqli_query($con, "select * from t_reserveplan where groupNumber='".$arrayresult['teamNumber']."'");
			$plan=mysqli_fetch_all($_plansql,MYSQLI_ASSOC);
// 			$zmsql=mysqli_query($con, "select * from t_hoteldebt where groupNumber='".$arrayresult['teamNumber']."'");
// 			$zm=mysqli_fetch_all($zmsql,MYSQLI_ASSOC);
			
			$yifu=array();
			
			
			
			for($q=0;$q<count($plan);$q++){
			    $yingfu=0;
			    $yf=0;
			    $yifusql=mysqli_query($con, "select * from t_hoteldebt where groupNumber='".$arrayresult['teamNumber']."'and reserveplan='".$plan[$q]["id"]."' and name=".$plan[$q]["hotelName"]);
			    $yifure=mysqli_fetch_all($yifusql,MYSQLI_ASSOC);
			  //  echo "select * from t_hoteldebt where groupNumber='".$arrayresult['teamNumber']."'and reserveplan='".$arrayresult['id']."' and name=".$plan[$q]["hotelName"];
			    for($y=0;$y<count($yifure);$y++){
			        $yf+=$yifure[$y]["fee"];
			        
			}
			array_push($yifu, $yf);
 			//print_r($yifu);
			if(($plan[$q]["hotelCommissionSum"]-$yifu[$q])>0){
			
			?>
			<tr  class="tableline">
		<td><?php
		$jdiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$plan[$q]["hotelName"]);
		$jdian=mysqli_fetch_array($jdiansql);
		echo $jdian["hotelname"];
		?></td>
			<td  >
			<?php 
			echo $plan[$q]["hotelCommissionSum"];
			
			?>
			<input type="hidden" name="unit" value="<?php echo $arrayresult['teamNumber'];?>"/>
			<input type="hidden" name="groupnum<?php echo $q+1;?>" value="<?php echo $arrayresult['teamNumber'];?>"/>
			<input type="hidden" name="hotelname<?php echo $q+1;?>" value="<?php echo $plan[$q]["hotelName"];?>"/>
			<input type="hidden" name="reserveplan<?php echo $q+1;?>" value="<?php echo $plan[$q]["id"];?>"/>
			</td>
			<td>
			<?php 
			
			echo $plan[$q]["hotelCommissionSum"]-$yifu[$q];
			?>
			</td>
			
			<td >
			<select width="100%" name="paytype<?php echo $q+1;?>">
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
			<input type="text" name="paytime<?php echo $q+1;?>" value="<?php 
			date_default_timezone_set('prc');
			echo date("Y-m-d",time());?>" class="date" size="30" readonly /><a class="inputDateButton" href="javascript:;">选择</a>
			</td>
			<td >
			<input type='hidden' name='douser<?php echo $q+1;?>.id' value='<?php echo $_SESSION["userid"]; ?>'/>
				<input type='text' class="required"   name='douser<?php echo $q+1;?>.douser<?php echo $q+1;?>' readonly value='<?php echo $_SESSION["user"]; ?>'style='width: 80%;' suggestFields='douser<?php echo $q+1;?>'  lookupGroup='douser<?php echo $q+1;?>' />
				<a class='btnLook' href="ajax/dh/douser.php?id=<?php echo $q+1;  ?>" lookupGroup='douser<?php echo $q+1;?>'>查找带回</a>
			</td>
			<td >
			
				<input type='hidden' name='zh<?php echo $q+1;?>.id' value=''/>
				<input type='text'  class="required"  name='zh<?php echo $q+1;?>.zh<?php echo $q+1;?>' readonly value=''style='width: 80%;' suggestFields='zh<?php echo $q+1;?>'  lookupGroup='zh<?php echo $q+1;?>' />
				<a class='btnLook' href="ajax/dh/zhduo.php?id=<?php echo $q+1;  ?>" lookupGroup='zh<?php echo $q+1;?>'>查找带回</a>
			</td>

			<td >
			<input type="text" class="number" style="width: 100%"  value="<?php 
			echo $plan[$q]["hotelCommissionSum"]-$yifu[$q];
			?>" name="xz<?php echo $q+1;?>"/>
			</td>
		<td>
		<input type="text" name="remark<?php echo $q+1;?>" style="width: 100%" />
			</td>
			

			
			 </tr>
			 <?php 
			    }
			    }?>
		<tr style="background:#E0ECFF;height:20px;" id="newline">
		<td colspan="9" class="formBar" >
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
			<td colspan="9" class="formBar" >
			<div style="clear: both;">
			<span style="float: left;">已下账</span>
			
			</div>
			
			</td>
			</tr>
			<tr>
			<td colspan="9">
			<table class="table" width="100%"   style="word-break:break-all; word-wrap:break-all;">
			<tr style="background:#E0ECFF;height:20px;">
			<th align="center" >酒店</th>
			<th align="center" >支付方式</th>
			<th align="center" >付款时间</th>
			<th align="center" >付款人</th>
			<th align="center" >付款账户</th>
			<th align="center" >下账金额</th>
			<th align="center" >备注</th>
			</tr>
			<?php 
			$zmqsql=mysqli_query($con, "select * from t_hoteldebt where groupnumber='".$arrayresult['teamNumber']."'");
			$zmq=mysqli_fetch_all($zmqsql,MYSQLI_ASSOC);
			$resultnum=count($zmq);
			@$page=ceil($resultnum/$numPerPage);
			@$sr=($pageNum-1)*$numPerPage;
			$resultnow=mysqli_query($con,"select * from t_hoteldebt where groupnumber='".$arrayresult['teamNumber']."' limit ".$sr.",".$numPerPage );
			$zm=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);

for($z=0;$z<count($zm);$z++){
			?>
			<tr>
			<td>
			<?php 
			$jdianqsql=mysqli_query($con, "select hotelname from t_allhotel where id=".$zm[$z]["name"]);
			$jdianq=mysqli_fetch_array($jdianqsql);
			echo $jdianq["hotelname"];
			?>
			</td>
			<td >
			<?php 
			$getpaysql=mysqli_query($con, "select * from t_paymenttype where id=".$zm[$z]["payType"]);
			$getpay=mysqli_fetch_array($getpaysql,MYSQLI_ASSOC);
			echo $getpay["paymentname"];
			?>
		
			
			</td>
			<td >
			<?php echo $zm[$z]["createTime"];?>
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
			<?php echo $zm[$z]["fee"];?>
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
