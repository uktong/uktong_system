<?php
require "../hzb/config.php";
require R.'hzb/inc/load.php';

$allqx=$db->select("t_travelpermission", "*", "1=1");

//62,1,1,1,0,3,1
$str="";
foreach ($allqx as $a){
    if (isset($_POST["state".$a["id"]])){
        $state=1;
    }else{
        $state=0;
    }
    if (isset($_POST["range".$a["id"]])){
        $range=$_POST["range".$a["id"]];
    }else{
        $range=99;//默认没有
    }
    if (isset($_POST["add".$a["id"]])){
        $add=1;
    }else{
        $add=0;
    }
    if (isset($_POST["edit".$a["id"]])){
        $edit=1;
    }else{
        $edit=0;
    }
    if (isset($_POST["del".$a["id"]])){
        $del=1;
    }else{
        $del=0;
    }
    if (isset($_POST["limit".$a["id"]])){
        $limit=1;
    }else{
        $limit=0;
    }
    $str.=$_POST["Jur".$a["id"]].",".$add.",".$edit.",".$del.",".$limit.",".$range.",".$state."|";
}

$newstr = substr($str,0,strlen($str)-1);
$data=array();
$data["Jurisdiction"]=$newstr;

if($db->update("ukt_jurisdiction", $data,"id=".$_GET["id"])){
    die('{ "statusCode":"200", "message":"编辑成功！", "navTabId":"qxgl", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
}