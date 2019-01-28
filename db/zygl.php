<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';

    require $_SESSION["ROOT"].'/db/db.php';
    $description=htmlspecialchars($_POST["description"]);
mysqli_query($con, "update t_zygl set detext='".$description."' where Id=1");
 echo '{ "statusCode":"200", "message":"添加成功", "navTabId":"", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }';