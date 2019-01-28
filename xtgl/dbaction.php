<?php

$action=@$_GET["action"];
switch ($action){
    case "chaxun":
        chaxun();
        break;
    case "add":
        add();
        break;
    case "delete":
        shanchu();
        break;
    case "edit":
        edit();
        break;
}
function add(){
    //base start
    require "../hzb/config.php";
    require R.'hzb/inc/load.php';
    //base end
    
    $txtUserAccount=$_POST["txtUserAccount"];
    $txtUserPwd=$_POST["txtUserPwd"];
    $txtUserName=$_POST["txtUserName"];
    $txtUserCode=$_POST["txtUserCode"];
    $txtCmpTel=$_POST["txtCmpTel"];
    $txtCmpFax=$_POST["txtCmpFax"];
    $txtUserMobile=$_POST["txtUserMobile"];
    $txtUserQQ=$_POST["txtUserQQ"];
    $txtUserEmail=$_POST["txtUserEmail"];
    $txtGrid=$_POST["txtGrid"];
    $chkUseChk=$_POST["chkUseChk"];
    $dept=$_GET["dept"];
    $hotel=$_GET["hotel"];
    @$txtQryBeginDateLimit=$_POST["txtQryBeginDateLimit"];
    $data=array();
    $data["username"]=$txtUserAccount;
    $data["realName"]=$txtUserName;
    $data["password"]=$txtUserPwd;
    $data["userCode"]=$txtUserCode;
    $data["tel"]=$txtCmpTel;
    $data["fax"]=$txtCmpFax;
    $data["phone"]=$txtUserMobile;
    $data["QQ"]=$txtUserQQ;
    $data["Email"]=$txtUserEmail;
    $data["duty"]=$txtGrid;
    $data["limitDate"]=$txtQryBeginDateLimit;
    $data["isUser"]=$chkUseChk;
    $data["dept"]=$dept;
    $data["hotel"]=$hotel;
    
    $checkname=$db->select("t_user","*","username='".$txtUserAccount."'");
    if(count($checkname)<1){
        if($db->insert("t_user",$data)){
            $getuserid=$db->select("t_user","id","username='".$txtUserAccount."'");
            $allqx=$db->select("t_travelpermission", "*", "1=1");
          
            //62,1,1,1,0,3,1
            $str="";
            foreach ($allqx as $a){
                $str.=$a["id"].",0,0,0,0,99,0|";
            }
            
            $jur=array();
            $jur["type"]="lxs";
            $jur["userid"]=$getuserid[0]["id"];
            $jur["Jurisdiction"]=substr($str,0,strlen($str)-1);
            $db->insert("ukt_jurisdiction",$jur);
        die('{ "statusCode":"200", "message":"添加成功！", "navTabId":"jbsxBox", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"", "confirmMsg":"" }');
        }else{
            die('{ "statusCode":"300", "message":"添加失败！", "navTabId":"jbsxBox", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
        }
    }else{
        die('{ "statusCode":"300", "message":"添加失败！已存在相同账号", "navTabId":"jbsxBox", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
        
    }
}
function chaxun(){
    
}
function shanchu(){
    require $_SESSION["ROOT"].'/db/db.php';
    $id=$_POST["id"];
    $res= mysqli_query($con,"delete from t_hotel where id='".$id."'");
    if (mysqli_affected_rows($res)!=0){
        echo "成功！";
    }
}
function edit(){
    //base start
    require "../hzb/config.php";
    require R.'hzb/inc/load.php';
    //base end
    
    $txtUserAccount=$_POST["txtUserAccount"];
    $txtUserPwd=$_POST["txtUserPwd"];
    $txtUserName=$_POST["txtUserName"];
    $txtUserCode=$_POST["txtUserCode"];
    $txtCmpTel=$_POST["txtCmpTel"];
    $txtCmpFax=$_POST["txtCmpFax"];
    $txtUserMobile=$_POST["txtUserMobile"];
    $txtUserQQ=$_POST["txtUserQQ"];
    $txtUserEmail=$_POST["txtUserEmail"];
    $txtGrid=$_POST["txtGrid"];
    $chkUseChk=$_POST["chkUseChk"];
    @$txtQryBeginDateLimit=$_POST["txtQryBeginDateLimit"];
    $data=array();
    $data["username"]=$txtUserAccount;
    $data["realName"]=$txtUserName;
    $data["password"]=$txtUserPwd;
    $data["userCode"]=$txtUserCode;
    $data["tel"]=$txtCmpTel;
    $data["fax"]=$txtCmpFax;
    $data["phone"]=$txtUserMobile;
    $data["QQ"]=$txtUserQQ;
    $data["Email"]=$txtUserEmail;
    $data["duty"]=$txtGrid;
    $data["limitDate"]=$txtQryBeginDateLimit;
    $data["isUser"]=$chkUseChk;

    $id=$_GET["id"];
    $checkname=$db->select("t_user","*","id=".$id);
    if(count($checkname)>0){
        if($db->update("t_user",$data,"id=".$id)){
          
            die('{ "statusCode":"200", "message":"修改成功！", "navTabId":"jbsxBox", "rel":"", "callbackType":"closeCurrent", "forwardUrl":"", "confirmMsg":"" }');
        }else{
            die('{ "statusCode":"300", "message":"修改失败！", "navTabId":"jbsxBox", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
        }
    }else{
        die('{ "statusCode":"300", "message":"修改失败！无此账号", "navTabId":"jbsxBox", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
        
    }
    
}