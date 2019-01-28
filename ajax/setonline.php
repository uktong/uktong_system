<?php
session_start();
require $_SESSION["ROOT"].'/db/db.php';
$id=$_SESSION["userid"] ;
$type=$_SESSION['usertype'];
date_default_timezone_set('prc');
$checkonlinesql=mysqli_query($con, "select * from online where userid='".$id."' and usertype='".$type."'");
if(mysqli_num_rows($checkonlinesql)>0){
    mysqli_query($con, "update online set lasttime=now() where userid='".$id."' and usertype='".$type."'");
}else if($type!=null){
    mysqli_query($con, "insert into online(userid,usertype,lasttime)values('".$id."','".$type."',now())");
}
$checktime=date('Y-m-d H:i:s',strtotime("-5 minute"));
$countsql=mysqli_query($con, "select id from online where lasttime>'".$checktime."'");
echo mysqli_num_rows($countsql);