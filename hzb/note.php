<?php
//检查权限
$jur=$base->getJur(md5($_COOKIE["username"]),"name",$_GET["J"]);
$J->type($jur, "add");
$jur=$base->getJur(md5($_COOKIE["username"]),"name",$_GET["J"]);
$J->type($jur, "edit");
$jur=$base->getJur(md5($_COOKIE["username"]),"name",$_GET["J"]);
$J->type($jur, "del");
$jur=$base->getJur(md5($_COOKIE["username"]),"name",$_GET["J"]);
if($J->type($jur, "limit")){
    
}
$jur=$base->getJur(md5($_COOKIE["username"]),"name",$_GET["J"]);
$J->type($jur, "range");


//读取用户信息
$usermsg=$base->data(md5($_COOKIE["username"]))[0];

//查询数据表格
$result=$db->tabledata($pageNum,$numPerPage," ","","","a.id");
$resultnum=$result["amount"];
$resultnowarray=$result["result"];
?>
<?php require R.'temp/search/zts.php';?>
<?php require R.'temp/search/user.php';?>