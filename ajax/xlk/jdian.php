<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
$id=$_GET["id"];
$name=$_GET["name"];
if($name!=null){
$resultnow=mysqli_query($con,"select id,hotelname as jdian".$id." from t_allhotel where hotelcode like '%".$name."%' or hotelname like '%".$name."%' limit 0,10" );
$resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
echo json_encode($resultnowarray);
}
?>
			   
			