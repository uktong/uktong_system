<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
$accountid=$_POST["accountid"];
$yuesql=mysqli_query($con, "select money from t_account where id=".$accountid);
$yuere=mysqli_fetch_array($yuesql);
echo $yuere["money"];