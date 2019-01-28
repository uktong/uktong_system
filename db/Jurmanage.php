<?php
$action=@$_GET["action"];
switch ($action){
    case "edit":
        edit();
        break;
}
function edit(){
    //base start
    require "../hzb/config.php";
    require R.'hzb/inc/load.php';
    //base end
    
    
    $id=$_GET["id"];
    $checkname=$db->select("t_travelpermission","*","id=".$id);
    if(count($checkname)>0){
        if($db->update("t_travelpermission",$_POST,"id=".$id)){
            
            die('{ "statusCode":"200", "message":"修改成功！", "navTabId":"", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"", "confirmMsg":"" }');
        }else{
            die('{ "statusCode":"300", "message":"修改失败！", "navTabId":"", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
        }
    }else{
        die('{ "statusCode":"300", "message":"修改失败！无此账号", "navTabId":"", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
        
    }
    
}