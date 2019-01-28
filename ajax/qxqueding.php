<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
$id=$_GET["id"];
$allid=explode(",", $id);
for($i=0;$i<count($allid);$i++)
{
    mysqli_query($con, "update t_reserveplan set planstatus='' where id=".$allid[$i]);
}

echo '{ "statusCode":"200", "message":"取消成功", "navTabId":"jddaidingxm", "rel":"", "callbackType":"forward", "forwardUrl":"jddaiding/index.php", "confirmMsg":"" }';
