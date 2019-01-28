<?php
if(empty($_COOKIE["username"])){
    header("Location:".R."login.php");
}
//base start
require R.'hzb/class/db.class.php';

require R.'hzb/class/getbase.class.php';
$base=new base(R);
require R.'hzb/function/baseaction.php';
//base end

require R.'action/checkJur.php';