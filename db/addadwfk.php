<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';

$action=@$_GET["action"];
switch ($action){
	case "chaxun":
		chaxun();
		break;
	case "charu":
		charu();
		break;
	case "delete":
		shanchu();
		break;
	case "edit":
		edit();
		break;
}
function charu(){
	require $_SESSION["ROOT"].'/db/db.php';
	
	$hotel=$_POST["jdian555_id"];
	$paytype=$_POST["paytype"];
	$money=$_POST["money"];
	$startDate=$_POST["doDate"];
	$remark=$_POST["remark"];
	$havingmoney=$_POST["havingmoney"];
	$invoice=$_POST["invoice"];
	$account=$_POST["account"];
	$payuser=$_POST["jd_id"];
	$payusername=$_POST["jd_jd"];
	$gdmonth=$_POST["gdmonth"];
	$plan="0";
	$arr=array();
	if(is_array($_POST["fkmoney"])){
	    foreach ($_POST["fkmoney"] as $a=>$fkmoney){
	        if($fkmoney==0)continue;
	        $arr[]=$fkmoney;
	    }
	}
	if(is_array($_POST["isfk"])){
	    foreach ($_POST["isfk"] as $a=>$reid){
	        // 		$ysdd.=",".$reid;fkmoney
	        // 		echo $_POST["fkmoney"][$a]."+".$reid;
	        $gnumsql=mysqli_query($con, "select groupNumber from t_reserveplan where id=".$reid);
	        $gnumre=mysqli_fetch_array($gnumsql);
	        $plan.=",".$reid;
	        // 		mysqli_query($con, "insert into t_hoteldebt(fee,reserveplan) values ('".$_POST["fkmoney"][$a]."','".$reid."')");
	        
	        mysqli_query($con, "insert into t_hoteldebt(fee,payee,name,payType
,account,groupnumber,createTime,reserveplan) values ('".$arr[$a]."','".$payuser."','".$hotel."','".$paytype."',
'".$account."','".$gnumre["groupNumber"]."'
,'".$startDate."','".$reid."')");
	        mysqli_query($con, "update t_account set money=money-".$arr[$a]." where id= ".$account);
	        mysqli_query($con, "insert into t_moneychange(accountid,km,mout,dotime,douser,changetype)values('".$account."','按单位收付款','".$arr[$a]."','".$startDate."','".$payuser."','out')");
	        
	    }
	}
	
	mysqli_query($con, "insert into t_sktravel(hotel,dodate,paytype,invoice,money,dopeople,dopeoplename,account,
			remark,mhaving,plan,gddate)values(
			'".$hotel."','".$startDate."',
'".$paytype."','".$invoice."','".$money."','".$payuser."','".$payusername."',
		'".$account."','".$remark."','".$havingmoney."','".$plan."','".$gdmonth."')");
	$manageid=mysqli_insert_id($con);
	 
	mysqli_close($con);
echo '{ "statusCode":"200", "message":"添加成功", "navTabId":"dwfk", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"cwgl/adwfk.php", "confirmMsg":"" }';
	     
}
function edit(){
	require $_SESSION["ROOT"].'/db/db.php';
	$id=$_GET["id"];
$hotel=$_POST["jdian555_id"];
	$paytype=$_POST["paytype"];
	$money=$_POST["money"];
	$startDate=$_POST["doDate"];
	$remark=$_POST["remark"];
	$havingmoney=$_POST["havingmoney"];
	$invoice=$_POST["invoice"];
	$account=$_POST["account"];
	$payuser=$_POST["jd_id"];
	$payusername=$_POST["jd_jd"];
	$arr=array();
	if(is_array(@$_POST["fkmoney"])){
	foreach ($_POST["fkmoney"] as $a=>$fkmoney){
		if($fkmoney==0)continue;
		$arr[]=$fkmoney;
	}
	}
	//修改下账信息
		mysqli_query($con, "update t_sktravel  set hotel='".$hotel."',money='".$money."',dodate='".$startDate."',
				remark='".$remark."',mhaving='".$havingmoney."',dopeople='".$payuser."',
						paytype='".$paytype."',invoice='".$invoice."',account='".$account."',dopeoplename='".$payusername."' where id=".$id);
//添加新下账信息
	if(is_array(@$_POST["isfk"])){
		foreach (@$_POST["isfk"] as $a=>$reid){
			$gnumsql=mysqli_query($con, "select groupNumber from t_reserveplan where id=".$reid);
			$gnumre=mysqli_fetch_array($gnumsql);
			@$plan.=",".$reid;
			// 		mysqli_query($con, "insert into t_hoteldebt(fee,reserveplan) values ('".$_POST["fkmoney"][$a]."','".$reid."')");
			
			mysqli_query($con, "insert into t_hoteldebt(fee,payee,name,payType
,account,groupnumber,createTime,reserveplan) values ('".$arr[$a]."','".$payuser."','".$hotel."','".$paytype."',
'".$account."','".$gnumre["groupNumber"]."'
,'".$startDate."','".$reid."')");
			mysqli_query($con, "update t_account set money=money-".$arr[$a]." where id= ".$account);
			mysqli_query($con, "insert into t_moneychange(accountid,km,mout,dotime,douser,changetype)values('".$account."','按单位收付款','".$arr[$a]."','".$startDate."','".$payuser."','out')");
			
		}
	}
		//取消已下帐，删除下账信息
	$qxarr=array();
	if(is_array(@$_POST["qxmoney"])){
	foreach (@$_POST["qxmoney"] as $a=>$qxmoney){
		if($qxmoney==0)continue;
		$qxarr[]=$qxmoney;
	}
	}
	if(is_array(@$_POST["isqx"])){	
	foreach (@$_POST["isqx"] as $a=>$reid){
		mysqli_query($con, "delete from t_hoteldebt where reserveplan='".$reid."' and fee='".$qxarr[$a]."'");
		mysqli_query($con, "update t_account set money=money+".$qxarr[$a]." where id= ".$account);
		mysqli_query($con, "insert into t_moneychange(accountid,km,mout,dotime,douser,changetype)values('".$account."','按单位收付款-取消','".$qxarr[$a]."','".$startDate."','".$payuser."','out')");
			
	}
	}
	
	mysqli_close($con);
echo '{ "statusCode":"200", "message":"修改成功", "navTabId":"dwfk", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"cwgl/adwfk.php", "confirmMsg":"" }';
	
}
