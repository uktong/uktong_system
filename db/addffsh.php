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
	$shmonth=$_POST["shmonth"];
	$money=$_POST["money"];
	$startDate=$_POST["doDate"];
	$remark=$_POST["remark"];
	$havingmoney=$_POST["havingmoney"];
	$ysdd="0";
	foreach ($_POST["issh"] as $reid){
		$ysdd.=",".$reid;
	}
	mysqli_query($con, "insert into t_ffsh(hotel,gddate,money,dodate,remark,mhaving,ysdd)values('".$hotel."','".$shmonth."',
'".$money."','".$startDate."','".$remark."','".$havingmoney."','".$ysdd."')");

	 
	mysqli_close($con);
echo '{ "statusCode":"200", "message":"添加成功", "navTabId":"ffsh", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"cwgl/ffsh.php", "confirmMsg":"" }';
	
}
function edit(){
	require $_SESSION["ROOT"].'/db/db.php';
	$id=$_GET["id"];
	$hotel=$_POST["jdian555_id"];
	$shmonth=$_POST["shmonth"];
	$money=$_POST["money"];
	$startDate=$_POST["doDate"];
	$remark=$_POST["remark"];
	$havingmoney=$_POST["ehavingmoney"];
	$ysdd="0";
	foreach ($_POST["issh"] as $reid){
		$ysdd.=",".$reid;
	}
	mysqli_query($con, "update t_ffsh  set hotel='".$hotel."',gddate='".$shmonth."',money='".$money."',dodate='".$startDate."',
			remark='".$remark."',mhaving='".$havingmoney."',ysdd='".$ysdd."' where id=".$id);
	
	
	mysqli_close($con);
echo '{ "statusCode":"200", "message":"修改成功", "navTabId":"ffsh", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"cwgl/ffsh.php", "confirmMsg":"" }';
	
}
