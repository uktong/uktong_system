<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$hotelid=$_POST["hotel"];//jiaogeishe
$roomtypeid=$_POST["room"];//xingcheng
$travleid=$_POST["travle"];//leixing
$livedate=$_POST["date"];
$cb=0;
$tk=0;
$cbsql=mysqli_query($con, "select price from t_roomprice where roomType='".$roomtypeid."' and
 travelSchemeId=(select id from t_protocol where jgs='".$hotelid."' and  '".$livedate."' between starttime and endtime )");
$hcb=mysqli_fetch_array($cbsql);
if(count($hcb)!=0){
    $cb=$hcb["price"];
}


echo json_encode(array($cb));