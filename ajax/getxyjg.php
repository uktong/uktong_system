<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$hotelid=$_POST["hotel"];
$roomtypeid=$_POST["room"];
$travleid=$_POST["travle"];
$livedate=$_POST["date"];
$cb=0;
$tk=0;
$cbsql=mysqli_query($con, "select price from t_roomprice where roomType='".$roomtypeid."' and
 hotelSchemeId=(select id from t_protocol where hotelName='".$hotelid."' and  '".$livedate."' between starttime and endtime )");
$hcb=mysqli_fetch_array($cbsql);
if(count($hcb)!=0){
    $cb=$hcb["price"];
}

//分割取出旅行社协议对应酒店
$forhotelsql=mysqli_query($con, "select forhotel from t_protocol where travelName='".$travleid."' and  '".$livedate."' between starttime and endtime ");
//将酒店分开
$forhotel=mysqli_fetch_array($forhotelsql);
if(count($forhotel)!=0){
    $hotel=explode(",",$forhotel["forhotel"]);
    if(in_array($hotelid, $hotel)){
        $tksql=mysqli_query($con, "select price from t_roomprice where roomType='".$roomtypeid."' and
 travelSchemeId=(select id from t_protocol where travelName='".$travleid."' and '".$livedate."' between starttime and endtime )");
        $ttk=mysqli_fetch_array($tksql);
        $tk=$ttk["price"];
    }else{
        
    }
    
}

 echo json_encode(array($cb,$tk));