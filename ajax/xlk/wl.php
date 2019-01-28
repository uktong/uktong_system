<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
$name=$_GET["name"];
if($name!=null){
    $resultnow=mysqli_query($con,"select id,username as wl from t_user where usercode like '%".$name."%' or username like '%".$name."%' limit 0,10" );
    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
    echo json_encode($resultnowarray);
}
?>
			   
			