<?php
session_start();
require $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
$yestoday=date("Y-m-d",strtotime("  -1 day"));
if($_SESSION["usertype"]=="lxs"){
    $sumsql=mysqli_query($con, "select count(id) as id from t_groupmanage where groupName='' and jd='".$_SESSION["userid"]."'");
}else if($_SESSION["usertype"]=="travel"){
    $jddiancode=$_SESSION["hotelcode"];
    $jddiansql=mysqli_query($con, "select id from t_travel where travel_code='".$jddiancode."'");
    $jddian=mysqli_fetch_array($jddiansql);
    $sumsql=mysqli_query($con, "select count(t_reserveplan.id) as id from t_groupmanage right join t_reserveplan on t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.lxsstatus is null and t_groupmanage.groupName='".$jddian['id']."'  and t_reserveplan.startDate between '".$yestoday."' and '".$lastday."'");
    
}else{
    $jddiancode=$_SESSION["hotelcode"];
    $jddiansql=mysqli_query($con, "select id from t_allhotel where hotelcode='".$jddiancode."'");
    $jddian=mysqli_fetch_array($jddiansql);
    $sumsql=mysqli_query($con, "select count(id) as id from t_reserveplan where  startDate between '".$yestoday."' and '".$lastday."' and planstatus is null and  hotelName='".$jddian["id"]."'");
}
$sum=mysqli_fetch_array($sumsql);
echo $sum["id"];