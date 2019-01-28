<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
$action=@$_GET["action"];
switch ($action){
    case "chaxun":
        chaxun();
        break;
    case "charu":
        charu();
        break;
    case "delete":
        shanchu();
        break;
    case "edit":
        edit();
        break;
}
function charu(){
    require $_SESSION["ROOT"].'/db/db.php';
    $deptname=$_POST["deptname"];
    $deptcode="";
    
    foreach (mbStrSplit($deptname) as $code){
        $deptcode.=getFirstCharter($code);
    }
    $chkUseChk=$_POST["chkUseChk"];
$hotel=$_GET['hotel'];
        $sql="INSERT INTO t_dept(
deptname,deptcode,state,hotel
) VALUES
('".$deptname."','".$deptcode."','".$chkUseChk."','".$hotel."'
)";
        mysqli_query($con,$sql);
        mysqli_close($con);
        echo "<script>alert('添加成功！');</script>";
        
    echo "<a href='xtgl/bmgl.php' target='navTab' id='reload' ><p>刷新</p></a>
        
    ";
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
    require $_SESSION["ROOT"].'/db/db.php';
    $txtCmpName=$_POST["txtCmpName"];
    $txtCmpCode=$_POST["txtCmpCode"];
    $txtCmpManager=$_POST["txtCmpManager"];
    $txtCmpMobile=$_POST["txtCmpMobile"];
    $txtCmpTel=$_POST["txtCmpTel"];
    $txtCmpFax=$_POST["txtCmpFax"];
    $txtCmpZip=$_POST["txtCmpZip"];
    $txtCmpAddr=$_POST["txtCmpAddr"];
    $txtCmpBank=$_POST["txtCmpBank"];
    $txtCmpAccount=$_POST["txtCmpAccount"];
    $txtCmpAccountNo=$_POST["txtCmpAccountNo"];
    $txtcity=$_POST["txtcity"];
    if($_POST["chkUseChk"]!='on'){
        $chkUseChk="off";
    }else{
        $chkUseChk="on";
    }
    
    $txtRemark=$_POST["txtRemark"];
    $id=$_POST["id"];
    $checkname= mysqli_query($con,"update  t_hotel set
hotelname='".$txtCmpName."',hotelcode='".$txtCmpCode."',hotelleader='".$txtCmpManager."',hotelphone='".$txtCmpMobile."',hoteltel='".$txtCmpTel."',
hotelfax='".$txtCmpFax."',hoteladdress='".$txtCmpAddr."',hotelzipCode='".$txtCmpZip."',
hotelbank='".$txtCmpBank."',hotelbankNum='".$txtCmpAccountNo."',hotelbankAccount='".$txtCmpAccount."',hotelremark='".$txtRemark."',
hotelcityid='".$txtcity."',hotelisUse='".$chkUseChk."',createtime='".$txtCmpName."'
 where id='".$id."'");
    
    echo "<a href='xtgl/gsxx.php' target='navTab' id='reload' ><p>刷新</p></a>
        
    ";
    
}