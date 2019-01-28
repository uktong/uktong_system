<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
$name=$_GET["name"];
$id=$_GET["id"];
if($name!=null){
    $resultnow=mysqli_query($con,"select id,travel_name as lxs".$id." from t_jgtravel where travel_code like '%".$name."%' or travel_name like '%".$name."%' limit 0,10" );
    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
    echo json_encode($resultnowarray);
}
?>
			   
			