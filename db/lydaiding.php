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
    date_default_timezone_set('prc');
    require $_SESSION["ROOT"].'/db/db.php';
    //     $chengtuan=$_POST["chengtuan"];//成团
    if(@$_POST["chengtuan"]=="on"){
        $chengtuan=1;
    }else {
        $chengtuan=2;
    }
    $jd=$_POST["jd_id"];//计调
    //   $daiding=$_POST["daiding_id"];//待定项目
    $startDate=$_POST["startDate"];
    $zts=@$_POST["zts_id"];
    $wl=@$_POST["wl_id"];
    $krxx=$_POST["krxx"];
    $odertDate=$_POST["odertDate"];
    $remark=$_POST["remark"];
    $daiding=$_POST["daiding"];
    $peoplenum=$_POST["peoplenum"];
    $updatePeople=$_SESSION["user"];
    $searchnum=mysqli_query($con, "select teamNumber from t_groupmanage where   id=(select max(id) from t_groupmanage where hotelManage='".$daiding."' and startDate between '".date("Y-m-d ",time())."' and '".date("Y-m-d ",strtotime("+1 day"))."' )");
    $serach=mysqli_fetch_array($searchnum);
    if(count($serach)!=0){
        $renumarray=explode("-",$serach["teamNumber"]);
        (int)$renum=$renumarray[1];
    }else{
        $renum=0;
    }
    $thdate=str_replace("-","", $startDate);
    $teamNumber=$_SESSION["hotelcode"].substr($thdate, 2)."LYDD-".($renum+1);
    
        $sql="INSERT INTO t_groupmanage(
teamNumber,orderStatus,startDate,manageUser,jd,hotelManage,groupName,
guest,remark,reserveDate,wl,updateDate,updatePeople,enteringDate,guestnum
) VALUES
('".$teamNumber."','".$chengtuan."','".$startDate."','".$updatePeople."','".$jd."','".$daiding."','".$zts."','".$krxx."'
,'".$remark."','".$odertDate."','".$wl."',now(),'".$updatePeople."',now(),'".$peoplenum."'
)";
        
    mysqli_query($con,$sql);
    $manageid=mysqli_insert_id($con);
    echo mysqli_error($con);
    $order=array();
    $jdian=array();
    $fjtype=array();
    $liveinDate=array();
    $tianshu=array();
    $danjia=array();
    $shuliang=array();
    $jine=array();
    $tuank=array();
    $tk=array();
    $luzao=array();
    $cusname=array();
    $douser=array();
    for($i=1;$i<21;$i++){
        if(isset($_POST["lxs".$i."_id"])&&isset($_POST["xctype".$i."_id"])&&$_POST["lxs".$i."_id"]!=""&&$_POST["xctype".$i."_id"]!=""){
            array_push($jdian,$_POST["lxs".$i."_id"]);
            array_push($fjtype,$_POST["xctype".$i."_id"]);
            array_push($liveinDate,$_POST["liveinDate".$i]);
            array_push($tianshu,$_POST["tianshu".$i]);
            array_push($danjia,$_POST["danjia".$i]);
            array_push($shuliang,$_POST["shuliang".$i]);
            array_push($jine,$_POST["jine".$i]);
            array_push($tk,$_POST["tk".$i]);
            array_push($tuank,$_POST["tuank".$i]);
            if(@$_POST["luzao".$i]=="on"){
                $luz=1;
            }else {
                $luz=0;
            }
            array_push($luzao,$luz);
            array_push($cusname,$_POST["cusname".$i]);
            array_push($douser,$_POST["douser".$i."_id"]);
        }
        
    }
    array_push($order,$jdian);
    array_push($order,$fjtype);
    array_push($order,$liveinDate);
    array_push($order,$tianshu);
    array_push($order,$danjia);
    array_push($order,$shuliang);
    array_push($order,$jine);
    array_push($order,$tk);
    array_push($order,$tuank);
    array_push($order,$luzao);
    array_push($order,$cusname);
    array_push($order,$douser);
    
    $line=count($jdian);
    for($q=0;$q<$line;$q++){
        mysqli_query($con, "insert into t_reserveplan(hotelName,roomType,startDate,dayNum,costPrice,number
,hotelCommissionSum,groupPrice,sumPrice,breakfast,guestName,manageUser,groupNumber,type) values ('".$order[0][$q]."','".$order[1][$q]."','".$order[2][$q]."','".$order[3][$q]."','".$order[4][$q]."','".$order[5][$q]."'
,'".$order[6][$q]."','".$order[7][$q]."','".$order[8][$q]."','".$order[9][$q]."','".$order[10][$q]."','".$order[11][$q]."','".$teamNumber."','ly')");
    }
    
    mysqli_close($con);
    if($_SESSION["usertype"]!="lxs"){
        echo '{ "statusCode":"200", "message":"添加成功", "navTabId":"daidingxm", "rel":"", "callbackType":"forward", "forwardUrl":"jddaiding/editdaiding.php?id='.$teamNumber.'", "confirmMsg":"" }';
    }else{
        echo '{ "statusCode":"200", "message":"添加成功", "navTabId":"daidingxm", "rel":"", "callbackType":"forward", "forwardUrl":"daiding/editly.php?id='.$manageid.'", "confirmMsg":"" }';
        
    }
    //     echo "<script>alert('添加成功！');</script>";
}
function chaxun(){
    
}
function shanchu(){
    require $_SESSION["ROOT"].'/db/db.php';
    $id=$_GET["id"];
    //查询是否下账
    $getnumsql=mysqli_query($con, "select teamNumber from  t_groupmanage where id=".$id);
    $getnum=mysqli_fetch_array($getnumsql);
    $number=$getnum["teamNumber"];
    $yifusql=mysqli_query($con, "select fee from t_hoteldebt where groupnumber='".$number."'");
    $yifu=mysqli_fetch_all($yifusql,MYSQLI_ASSOC);
    $yifuje=0;
    for($yf=0;$yf<count($yifu);$yf++){
        $yifuje+=@$yifu[$yf]["fee"];
    }
    
    $getyishousql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where groupNumber='".$number."'");
    $yishoure=mysqli_fetch_array($getyishousql);
    
    if($yishoure["money"]!=0||$yifuje!=0){
        
        echo '{ "statusCode":"300", "message":"删除失败！订单存在已下账数据！", "navTabId":"lydd", "rel":"", "callbackType":"forward", "forwardUrl":"daiding/lydd.php", "confirmMsg":"" }';
    }else{
        $res= mysqli_query($con,"delete from t_groupmanage where id='".$id."'");
        if (mysqli_affected_rows($con)!=0){
            echo '{ "statusCode":"200", "message":"删除成功", "navTabId":"lydd", "rel":"", "callbackType":"forward", "forwardUrl":"daiding/lydd.php", "confirmMsg":"" }';
            
        }
    }
}
function edit(){
    date_default_timezone_set('prc');
    require $_SESSION["ROOT"].'/db/db.php';
    //     $chengtuan=$_POST["chengtuan"];//成团
    $teamNumber=$_GET['id'];
    $jd=$_POST["jd_id"];//计调
    //   $daiding=$_POST["daiding_id"];//待定项目
    $startDate=$_POST["startDate"];
    $zts=@$_POST["zts_id"];
    $ztsth=@$_POST["ztsth"];
    $lxr=@$_POST["lxr_id"];
    $lxrname=@$_POST["lxr_lxr"];
    $wl=@$_POST["wl_id"];
    $krxx=$_POST["krxx"];
    //     $odertDate=$_POST["odertDate"];
    $remark=$_POST["remark"];
    $updatePeople=$_SESSION["user"];
    if($lxr==""){
        mysqli_query($con, "insert into t_linkman(name,travel_id)
values('".$lxrname."','".$zts."')");
        $linknameid=mysqli_insert_id($con);
        $sql="update t_groupmanage set
startDate='".$startDate."',jd='".$jd."',updateDate=now(),groupNumber='".$ztsth."',groupName='".$zts."',jd='".$jd."'
,guest='".$krxx."',linkman='".$linknameid."',remark='".$remark."',wl='".$wl."',updateDate=now()
,updatePeople='".$updatePeople."',linkmanname='".$lxrname."'
where teamNumber='".$teamNumber."'";
        //     echo $sql;
    }else{
        $sql="update t_groupmanage set
startDate='".$startDate."',jd='".$jd."',updateDate=now(),groupNumber='".$ztsth."',groupName='".$zts."',jd='".$jd."'
,guest='".$krxx."',linkman='".$lxr."',remark='".$remark."',wl='".$wl."',updateDate=now()
,updatePeople='".$updatePeople."',linkmanname='".$lxrname."'
where teamNumber='".$teamNumber."'";
    }
    mysqli_query($con,$sql);
    echo mysqli_error($con);
    $order=array();
    $jdian=array();
    $fjtype=array();
    $liveinDate=array();
    $tianshu=array();
    $danjia=array();
    $shuliang=array();
    $jine=array();
    $tuank=array();
    $tk=array();
    $luzao=array();
    $cusname=array();
    $douser=array();
    for($i=1;$i<21;$i++){
        if(isset($_POST["lxs".$i."_id"])&&isset($_POST["xctype".$i."_id"])&&$_POST["lxs".$i."_id"]!=""&&$_POST["xctype".$i."_id"]!=""){
            array_push($jdian,$_POST["lxs".$i."_id"]);
            array_push($fjtype,$_POST["xctype".$i."_id"]);
            array_push($liveinDate,$_POST["liveinDate".$i]);
            array_push($tianshu,$_POST["tianshu".$i]);
            array_push($danjia,$_POST["danjia".$i]);
            array_push($shuliang,$_POST["shuliang".$i]);
            array_push($jine,$_POST["jine".$i]);
            array_push($tk,@$_POST["tk".$i]);
            array_push($tuank,@$_POST["tuank".$i]);
            if(@$_POST["luzao".$i]=="on"){
                $luz=1;
            }else {
                $luz=0;
            }
            array_push($luzao,$luz);
            array_push($cusname,$_POST["cusname".$i]);
            array_push($douser,$_POST["douser".$i."_id"]);
        }
        
    }
    array_push($order,$jdian);
    array_push($order,$fjtype);
    array_push($order,$liveinDate);
    array_push($order,$tianshu);
    array_push($order,$danjia);
    array_push($order,$shuliang);
    array_push($order,$jine);
    array_push($order,$tk);
    array_push($order,$tuank);
    array_push($order,$luzao);
    array_push($order,$cusname);
    array_push($order,$douser);
    
    $line=count($jdian);
    $getmsgsql=mysqli_query($con, "select hotelName,startDate,number,roomType from t_reserveplan where groupNumber='".$teamNumber."'");
    $getmsg=mysqli_fetch_all($getmsgsql,MYSQLI_ASSOC);
    mysqli_query($con,"delete from t_reserveplan where groupNumber='".$teamNumber."'");
    for($q=0;$q<$line;$q++){
        mysqli_query($con, "insert into t_reserveplan(hotelName,roomType,startDate,dayNum,costPrice,number
,hotelCommissionSum,groupPrice,sumPrice,breakfast,guestName,manageUser,groupNumber,type) values ('".$order[0][$q]."','".$order[1][$q]."','".$order[2][$q]."','".$order[3][$q]."','".$order[4][$q]."','".$order[5][$q]."'
,'".$order[6][$q]."','".$order[7][$q]."','".$order[8][$q]."','".$order[9][$q]."','".$order[10][$q]."','".$order[11][$q]."','".$teamNumber."','ly')");
        
        for($g=0;$g<count($getmsg);$g++){
            $num=0;
            if($getmsg[$g]["roomType"]==$order[1][$q]&&$getmsg[$g]["startDate"]=$order[2][$q]&&$getmsg[$g]["hotelName"]=$order[0][$q]){
                $num+=$getmsg[$g]["number"];
            }
        }
        
    }
    //     print_r($order);
    echo mysqli_error($con);
    mysqli_close($con);
    
    if($_SESSION["usertype"]!="lxs"){
        echo '{ "statusCode":"200", "message":"成功", "navTabId":"daidingxm", "rel":"", "callbackType":"forward", "forwardUrl":"jddaiding/index.php", "confirmMsg":"" }';
    }else{
        echo '{ "statusCode":"200", "message":"成功", "navTabId":"lydd", "rel":"", "callbackType":"forward", "forwardUrl":"daiding/lydd.php", "confirmMsg":"" }';
        
    }
    
} 