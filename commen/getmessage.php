<?php
//订单状态
if($resultnowarray[$a]['orderStatus']!=2){
    
    $orderstates="<span style='color:green;'>确认</span>";
}else{
    $orderstates="<span style='color:red;'>未确认</span>";
}
//获取酒店名字
$jddianid=$resultnowarray[$a]['hotelName'];
$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
$jddian=mysqli_fetch_array($jddiansql);
echo $jddian["hotelname"];
//获取用户
$isusersql=mysqli_query($con, "select realName from t_user where id=".$resultnowarray[$a]['issuer']);
$isuser=mysqli_fetch_array($isusersql);
echo $isuser["realName"];
//组团社
$ztsid=$resultnowarray[$a]['groupName'];
$ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
$zts=mysqli_fetch_array($ztssql); 
echo $zts['travel_name'];
//计调
$jdid=$resultnowarray[$a]['jd'];
$jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
$jd=mysqli_fetch_array($jdsql);
echo $jd["username"];
//房型
$fxid= $resultnowarray[$a]["roomType"];
$fxsql=mysqli_query($con, "select roomType from t_roomprice where id=".$fxid);
$fx=mysqli_fetch_array($fxsql);
echo $fx["roomType"];
//酒店用房数量
$jdshuliangsql=mysqli_query($con, "select sum(number) as shuliang from t_reserveplan where hotelName=".$jddianid);
$jdshuliang=mysqli_fetch_array($jdshuliangsql);
echo $jdshuliang["shuliang"];
//总应付酒店款项
$yingfusql=mysqli_query($con, "select sum(hotelCommissionSum) as yingfu from t_reserveplan where hotelName=".$jddianid);
$yingfu=mysqli_fetch_array($yingfusql);

echo $yingfu["yingfu"];
//总已付酒店款项
$yifusql=mysqli_query($con, "select sum(fee) as yifu from t_hoteldebt where name=".$jddianid);
$yifu=mysqli_fetch_array($yifusql);

echo $yifu["yifu"];
//反查旅行社id
$teamnum=$resultnowarray[$a]['groupNumber'];
$gettravelidsql=mysqli_query($con, "select groupName from t_groupmanage where teamNumber='".$teamnum."'");
$gettravelid=mysqli_fetch_array($gettravelidsql);
//收款方式
$getpaysql=mysqli_query($con, "select * from t_paymenttype where id=".$zm[$z]["payment"]);
$getpay=mysqli_fetch_array($getpaysql,MYSQLI_ASSOC);
echo $getpay["paymentname"];
//收款人
$skrsql=mysqli_query($con, "select username from t_user where id=".$zm[$z]["payee"]);
$skr=mysqli_fetch_array($skrsql);
echo $skr['username'];
//收款账号
$zhsql=mysqli_query($con, "select accountTitle from t_account where id=".$zm[$z]["account"]);
$zh=mysqli_fetch_array($zhsql);
echo $zh['accountTitle'];
//根据编码获取酒店id
$hotelcode=$_SESSION["hotelcode"];
$idsql=mysqli_query($con, "select id from t_allhotel where hotelcode='".$hotelcode."'");
$idre=mysqli_fetch_array($idsql);
//支付方式
$getpaysql=mysqli_query($con, "select * from  t_baseconfig where basenote=5 and id=".$zm[$z]["payment"]);
			$getpay=mysqli_fetch_array($getpaysql,MYSQLI_ASSOC);
			echo $getpay["basetype"];
?>
//checkbox
<input id="chkUseChk" type="checkbox" name="flag" <?php echo $xy["flag"]=="on"?"checked":" "; ?>  />
//路早
<?php echo $resultnowarray[$a]["breakfast"]=="1"?"路早":"正常早餐";?>
//支付方式
<select width="100%" name="paytype">
			<?php 
			$paysql=mysqli_query($con, "select * from t_baseconfig where basenote=5 ");
			$pay=mysqli_fetch_all($paysql,MYSQLI_ASSOC);
			for($p=0;$p<count($pay);$p++){
			    
		
			?>
			<option  value="<?php echo $pay[$p]["id"];?>"><?php echo $pay[$p]["basetype"];?></option>
			<?php 	}?>
			</select>