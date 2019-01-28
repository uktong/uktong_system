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
	
	$travel=$_POST["zts_id"];
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
	if(is_array($_POST["skmoney"])){
	foreach ($_POST["skmoney"] as $a=>$skmoney){
		if($skmoney==0)continue;
		$arr[]=$skmoney;
	}
	}
	if(is_array($_POST["issk"])){
	foreach ($_POST["issk"] as $a=>$reid){
// 		$ysdd.=",".$reid;fkmoney
// 		echo $_POST["fkmoney"][$a]."+".$reid;
		$gnumsql=mysqli_query($con, "select teamNumber from t_groupmanage where id=".$reid);
		$gnumre=mysqli_fetch_array($gnumsql);
// 		echo "select groupNumber from t_groupmanage where id=".$reid." ceshi ".$gnumre["groupNumber"];
		$plan.=",".$reid;
		
		mysqli_query($con, "insert into t_collectionunit(groupNumber,agent,payment,dater,payee,account,amount)
				 values ('".$gnumre["teamNumber"]."','".$travel."','".$paytype."','".$startDate."',
'".$payuser."','".$account."'
,'".$arr[$a]."')");

		mysqli_query($con, "update t_account set money=money+".$arr[$a]." where id= ".$account);
		mysqli_query($con, "insert into t_moneychange(accountid,km,mout,dotime,douser,changetype)values('".$account."','按单位收付款','".$arr[$a]."','".$startDate."','".$payuser."','in')");
		
	}
	}
	mysqli_query($con, "insert into t_sktravel(travel,dodate,paytype,invoice,money,dopeople,dopeoplename,account,remark,mhaving,plan,gddate)values(
			'".$travel."','".$startDate."',
'".$paytype."','".$invoice."','".$money."','".$payuser."','".$payusername."',
		'".$account."','".$remark."','".$havingmoney."','".$plan."','".$gdmonth."')");

	 
	mysqli_close($con);
echo '{ "statusCode":"200", "message":"添加成功", "navTabId":"dwsk", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"cwgl/adwsk.php", "confirmMsg":"" }';
	
}
function edit(){
	require $_SESSION["ROOT"].'/db/db.php';
	$id=$_GET["id"];
	$travel=$_POST["zts_id"];
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
	$arr=array();
	if(is_array($_POST["skmoney"])){
	foreach ($_POST["skmoney"] as $a=>$skmoney){
		if($skmoney==0)continue;
		$arr[]=$skmoney;
	}
	}
	//修改下账信息
		mysqli_query($con, "update t_sktravel  set travel='".$travel."',money='".$money."',dodate='".$startDate."',
				remark='".$remark."',mhaving='".$havingmoney."',dopeople='".$payuser."',
						paytype='".$paytype."',invoice='".$invoice."',account='".$account."',dopeoplename='".$payusername."',gddate='".$gdmonth."' where id=".$id);
//添加新下账信息
	if(is_array(@$_POST["issk"])){
		foreach (@$_POST["issk"] as $a=>$reid){
			$gnumsql=mysqli_query($con, "select teamNumber from t_groupmanage where id=".$reid);
			$gnumre=mysqli_fetch_array($gnumsql);
			@$plan.=",".$reid;
			// 		mysqli_query($con, "insert into t_hoteldebt(fee,reserveplan) values ('".$_POST["fkmoney"][$a]."','".$reid."')");
			
		
			mysqli_query($con, "insert into t_collectionunit(groupNumber,agent,payment,dater,payee,account,amount)
				 values ('".$gnumre["teamNumber"]."','".$travel."','".$paytype."','".$startDate."',
'".$payuser."','".$account."'
,'".$arr[$a]."')");
			mysqli_query($con, "update t_account set money=money+".$arr[$a]." where id= ".$account);
			mysqli_query($con, "insert into t_moneychange(accountid,km,mout,dotime,douser,changetype)values('".$account."','按单位收付款','".$arr[$a]."','".$startDate."','".$payuser."','in')");
			
		}
	}
		//取消已下帐，删除下账信息
	@$qxarr=array();
	if(is_array(@$_POST["qxskmoney"])){
	foreach ($_POST["qxskmoney"] as $a=>$qxmoney){
		if($qxmoney==0)continue;
		$qxarr[]=$qxmoney;
	}
	}
	if(is_array(@$_POST["isqxsk"])){	
	foreach (@$_POST["isqxsk"] as $a=>$reid){
		$gnumsql=mysqli_query($con, "select teamNumber from t_groupmanage where id=".$reid);
		$gnumre=mysqli_fetch_array($gnumsql);
		mysqli_query($con, "delete from t_collectionunit where groupNumber='".$gnumre["teamNumber"]."' and amount='".$qxarr[$a]."'");
		mysqli_query($con, "update t_account set money=money-".$qxarr[$a]." where id= ".$account);
		mysqli_query($con, "insert into t_moneychange(accountid,km,mout,dotime,douser,changetype)values('".$account."','按单位收付款-取消','".$qxarr[$a]."','".$startDate."','".$payuser."','out')");
			
	}
	}
	
	mysqli_close($con);
echo '{ "statusCode":"200", "message":"修改成功", "navTabId":"dwsk", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"cwgl/adwsk.php", "confirmMsg":"" }';
	
}
