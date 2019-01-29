<?php
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end

$jur=$base->getJur(md5($_COOKIE["username"]),"name",$_GET["J"]);
$J->type($jur, "del");


switch ($_GET["action"]){
    case "ddxm":
        $id=$_GET["id"];
        $arrayresult=$db->select("t_groupmanage","*","id='".$id."'")[0];
        
        if($J->type($jur, "limit")&&$arrayresult['jd']!=$_COOKIE["userid"]){//限制个人，不能删除其他人的
            $do=false;
        }elseif (!$J->type($jur, "del")){//删除的功能
            $do=false;
        }else{
            $do=true;
        }
        if (!$do){
            die('{ "statusCode":"300", "message":"删除失败！您无权删除该订单", "navTabId":"", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
        }else{
            $db->del("t_reserveplan","groupNumber='".$arrayresult["teamNumber"]."'");
            $db->del("t_otherplan","groupNumber='".$arrayresult["teamNumber"]."'");
            $db->del("t_groupmanage", "id='".$id."'");
            die('{ "statusCode":"200", "message":"删除成功！", "navTabId":"", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
            
        }
        break;
    case "jcsj":
        $id=$_GET["id"];
        if (!$J->type($jur, "del")){//删除的功能
            $do=false;
        }else{
            $do=true;
        }
        if (!$do){
            die('{ "statusCode":"300", "message":"删除失败！您无权删除", "navTabId":"jcsjbox", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
        }else{
            $db->del("t_baseconfig", "id='".$id."'");
            die('{ "statusCode":"200", "message":"删除成功！", "navTabId":"jcsjbox", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
            
        }
        break;
}