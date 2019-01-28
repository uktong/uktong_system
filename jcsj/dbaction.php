<?php
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end
$action=@$_GET["action"];
$name=$_POST["basetype"];
if(!empty($_POST["basecode"])){
    $code=$_POST["basecode"];
}else{
    $code=pinyin_long($name);
}
$px=$_POST["px"];
$remark=$_POST["digest"];
$data=array();
$data["basetype"]=$name;
$data["basecode"]=$code;
$data["remark"]=$remark;
$data["px"]=$px;

switch ($action){
    case "add":
        $data["basenote"]=$_GET["km"];
        if ($db->insert("t_baseconfig",$data)){
            die('{ "statusCode":"200", "message":"添加成功！", "navTabId":"jcsjbox", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"", "confirmMsg":"" }');
        }else{
            die('{ "statusCode":"300", "message":"重复添加！", "navTabId":"jcsjbox", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"", "confirmMsg":"" }');
        }
        break;
   
    case "edit":
        if ($db->update("t_baseconfig",$data,"id=".$_GET["id"])){
            die('{ "statusCode":"200", "message":"修改成功！", "navTabId":"jcsjbox", "rel":"jcsjbox", "callbackType":"closeCurrent", "forwardUrl":"", "confirmMsg":"" }');
        }else{
            die('{ "statusCode":"300", "message":"修改失败！", "navTabId":"jcsjbox", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"", "confirmMsg":"" }');
        }
        break;
}
