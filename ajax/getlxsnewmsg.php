<?php
session_start();
require $_SESSION["ROOT"].'/db/db.php';

    $sumsql=mysqli_query($con, "SELECT count(id) as id FROM t_groupmanage WHERE  teamNumber  NOT  IN  ( SELECT groupNumber FROM t_reserveplan)");
$sum=mysqli_fetch_array($sumsql);
echo $sum["id"];