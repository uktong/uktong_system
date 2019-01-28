<?php
session_start();

$type=@$_GET["type"];
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
    $txtCmpName=$_POST["txtCmpName"];
    $txtCmpCode="";
    if($_POST["txtCmpCode"]==""){
        foreach (mbStrSplit($txtCmpName) as $code){
            $txtCmpCode.=getFirstCharter($code);
        }
    }
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
    $chkUseChk=$_POST["chkUseChk"];
    $txtRemark=$_POST["txtRemark"];
    $hoteltype=$_POST["hoteltype"];
    $hotellevel=$_POST["hotellevel"];
    $linkpeople=$_POST["linkpeople"];
    $createpeople=$_SESSION["user"];
    
    $checkname= mysqli_query($con,"select  *from t_allhotel where hotelname='".$txtCmpName."'");
    if(mysqli_num_rows($checkname)<1){
        $sql="INSERT INTO t_allhotel(
hotelname,hotelcode,hotelleader,hotelphone,hoteltel,hotelfax,hoteladdress,hotelzipCode,
hotelbank,hotelbankNum,hotelbankAccount,hotelremark,hotelcityid,hotelisUse,createtime,hotelproperty,hotellevelid,linkpeople,createpeople
) VALUES
('".$txtCmpName."','".$txtCmpCode."','".$txtCmpManager."','".$txtCmpMobile."','".$txtCmpTel."','".$txtCmpFax."','".$txtCmpAddr."','".$txtCmpZip."',
'".$txtCmpBank."','".$txtCmpAccountNo."','".$txtCmpAccount."','".$txtRemark."','".$txtcity."','".$chkUseChk."',now(),
'".$hoteltype."','".$hotellevel."','".$linkpeople."','".$createpeople."'
)";
        mysqli_query($con,$sql);
        mysqli_close($con);
        echo "<script>alert('添加成功！');
            
            
</script>";
        
    }else{
        echo "<script>alert('已经存在相同酒店！');</script>";
        
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
    require $_SESSION["ROOT"].'/db/db.php';
    $txtCmpName=$_POST["txtCmpName"];
    $txtCmpCode="";
    if($_POST["txtCmpCode"]==""){
        foreach (mbStrSplit($txtCmpName) as $code){
            $txtCmpCode.=getFirstCharter($code);
        }
    }
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
    
    
}