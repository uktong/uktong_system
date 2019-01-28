<?php
session_start();
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
    $txtCmpCode=$_POST["txtCmpCode"];
    $traveltype=$_POST["traveltype"];
    $linkpeople=$_POST["linkpeople"];
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
    $createpeople=$_SESSION["user"];
    if($_POST["chkUseChk"]!='on'){
        $chkUseChk="off";
    }else{
        $chkUseChk="on";
    }
    
    $txtRemark=$_POST["txtRemark"];
    $checkname= mysqli_query($con,"select  *from t_travel where travel_name='".$txtCmpName."'");
    if(mysqli_num_rows($checkname)<1){
        $sql="INSERT INTO t_travel(
travel_name,travel_code,travel_type_id,linkpeople,travel_leader,travel_phone,travel_tel,travel_fax,
travel_zipCode,travel_address,travel_bank,travel_bankAccount,travel_bankNum,travel_city_id,travel_isUse,travel_remark,creattime,createpeople
) VALUES
('".$txtCmpName."','".$txtCmpCode."','".$traveltype."','".$linkpeople."','".$txtCmpManager."','".$txtCmpMobile."','".$txtCmpTel."',
'".$txtCmpFax."','".$txtCmpZip."','".$txtCmpAddr."',
'".$txtCmpBank."','".$txtCmpAccount."','".$txtCmpAccountNo."','".$txtcity."','".$chkUseChk."','".$txtRemark."',now(),'".$createpeople."'
)";
        mysqli_query($con,$sql);
        mysqli_close($con);
        echo "<script>alert('添加成功！');
            
            
</script>";
        
    }else{
        echo "<script>alert('已经存在相同旅行社！');</script>";
        
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
    $txtCmpCode=$_POST["txtCmpCode"];
    $traveltype=$_POST["traveltype"];
    $linkpeople=$_POST["linkpeople"];
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