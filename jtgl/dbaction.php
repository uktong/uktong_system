<?php
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end
$action=@$_GET["action"];
if(@$_POST["chengtuan"]=="on"){
    $chengtuan=1;
}else {
    $chengtuan=2;
}
$jd=$_POST["jd_id"];//计调
$insert=array();
$insert["orderStatus"]=$chengtuan;
$insert["startDate"]=$_POST["startDate"];
$insert["guestnum"]=$_POST["peoplenum"];
$insert["endDate"]=$_POST["endtDate"];
$insert["groupName"]=$_POST["zts_id"];
$insert["manageUser"]=$_COOKIE["username"];
$insert["jd"]=$_POST["jd_id"];
$insert["guest"]=$_POST["krxx"];
$insert["remark"]=$_POST["remark"];
$insert["wl"]=$_POST["wl_id"];
$insert["updatePeople"]=$_COOKIE["username"];
$insert["linkmanname"]=$_POST["lxr_lxr"];
$insert["hotelManage"]=$_POST["daiding"];
$insert["linkman"]=$_POST["lxr_id"];

switch ($action){
    case "add":
        $insert["unicode"]=$_POST["unicode"];
        if (count($db->select("t_groupmanage","*","unicode='".$_POST["unicode"]."' "))>0){
            die('{ "statusCode":"300", "message":"重复添加！", "navTabId":"ddxm", "rel":"", "callbackType":"forward", "forwardUrl":"jtgl/index.php", "confirmMsg":"" }');
        }
        $serach=$db->select("t_groupmanage","teamNumber","hotelManage='".$_POST["daiding"]."' and  startDate = '".$_POST["startDate"]."'");
        if(count($serach)!=0){
            $numarray=array();
            for($s=0;$s<count($serach);$s++){
                $renumarray=explode("-", $serach[$s]["teamNumber"]);
                (int)$renumall=$renumarray[1];
                array_push($numarray, $renumall);
            }
            (int)$renum=max($numarray);
        }else{
            $renum=0;
        }
        $thdate=str_replace("-","", $_POST["startDate"]);
        $teamNumber=$_COOKIE["hotelcode"].substr($thdate, 2)."DD-".($renum+1);
        $insert["reserveDate"]=date("Y-m-d");
        $insert["teamNumber"]=$teamNumber;
        $insert["enteringDate"]=date("Y-m-d H:i:s");
        $insert["updateDate"]=date("Y-m-d H:i:s");
        if($db->insert("t_groupmanage",$insert)){
            $id=$db->select("t_groupmanage","id","teamNumber='".$teamNumber."'")[0];
            for($i=0;$i<30;$i++){
                if (!empty($_POST["items".$i."_hotel_id"])&&!empty($_POST["items".$i."_roomtype"])){
                    $singleplay=array();
                    $singleplay["hotelName"]=$_POST["items".$i."_hotel_id"];
                    $singleplay["roomType"]=$_POST["items".$i."_roomtype"];
                    $singleplay["startDate"]=$_POST["items".$i."_livedate"];
                    $singleplay["dayNum"]=$_POST["items".$i."_days"];
                    $singleplay["costPrice"]=$_POST["items".$i."_singleprice"];
                    $singleplay["number"]=$_POST["items".$i."_amount"];
                    $singleplay["hotelCommissionSum"]=$singleplay["dayNum"]*$singleplay["costPrice"]*$singleplay["number"];
                    $singleplay["groupPrice"]=$_POST["items".$i."_saleprice"];
                    $singleplay["sumPrice"]=$singleplay["dayNum"]*$singleplay["groupPrice"]*$singleplay["number"];
                    $singleplay["breakfast"]=$_POST["items".$i."_breakfast"];
                    $singleplay["guestName"]=$_POST["items".$i."_customer"];
                    $singleplay["manageUser"]=$_COOKIE["userid"];
                    $singleplay["groupNumber"]=$teamNumber;
                    $db->insert("t_reserveplan",$singleplay);
                }
                if (!empty($_POST["others".$i."_type"])){
                    if($_POST["others".$i."_money"]!="0"){
                        $singleplay=array();
                        $singleplay["type"]=$_POST["others".$i."_type"];
                        $singleplay["money"]=$_POST["others".$i."_money"];
                        $singleplay["amount"]=$_POST["others".$i."_amount"];
                        $singleplay["summoney"]=$_POST["others".$i."_amount"]*$_POST["others".$i."_money"];
                        $singleplay["remark"]=$_POST["others".$i."_remark"];
                        $singleplay["manageUser"]=$_COOKIE["userid"];
                        $singleplay["groupNumber"]=$teamNumber;
                        $db->insert("t_otherplan",$singleplay);
                    }
                    
                }
            }
            die('{ "statusCode":"200", "message":"添加成功！", "navTabId":"ddxm", "rel":"editddxm", "callbackType":"forward", "forwardUrl":"jtgl/editorder.php?id='.$id["id"].'&J='.$_GET["J"].'", "confirmMsg":"" }');
        }
        break;
    case "edit":
        $teamNumber=$_GET["id"];
        if($db->update("t_groupmanage",$insert,"teamNumber='".$teamNumber."'")){
            $oldplans=$db->select("t_reserveplan", "id", "groupNumber='".$teamNumber."'");
            $newplans=array();
            $oldotherplans=$db->select("t_otherplan", "id", "groupNumber='".$teamNumber."'");
            $newotherlans=array();
            for($i=0;$i<30;$i++){//固定查询30条
                    if (!empty($_POST["items".$i."_hotel_id"])&&!empty($_POST["items".$i."_roomtype"])){
                        $singleplay=array();
                        $singleplay["hotelName"]=$_POST["items".$i."_hotel_id"];
                        $singleplay["roomType"]=$_POST["items".$i."_roomtype"];
                        $singleplay["startDate"]=$_POST["items".$i."_livedate"];
                        $singleplay["dayNum"]=$_POST["items".$i."_days"];
                        $singleplay["costPrice"]=$_POST["items".$i."_singleprice"];
                        $singleplay["number"]=$_POST["items".$i."_amount"];
                        $singleplay["hotelCommissionSum"]=$singleplay["dayNum"]*$singleplay["costPrice"]*$singleplay["number"];
                        $singleplay["groupPrice"]=$_POST["items".$i."_saleprice"];
                        $singleplay["sumPrice"]=$singleplay["dayNum"]*$singleplay["groupPrice"]*$singleplay["number"];
                        $singleplay["breakfast"]=$_POST["items".$i."_breakfast"];
                        $singleplay["guestName"]=$_POST["items".$i."_customer"];
                            if(empty($_POST["items".$i."_id"])){//检查是否存在该plan
                            $singleplay["manageUser"]=$_COOKIE["userid"];
                            $singleplay["groupNumber"]=$teamNumber;
                            $db->insert("t_reserveplan",$singleplay);
                            }else{//如果存在则修改
                                $ls=array();
                                $ls["id"]=$_POST["items".$i."_id"];
                                $db->update("t_reserveplan",$singleplay,"id='".$ls["id"]."'");
                                array_push($newplans, $ls);
                            }
                    }
                    if (!empty($_POST["others".$i."_type"])){
                        if($_POST["others".$i."_money"]!="0"){
                            $singleplay=array();
                            $singleplay["type"]=$_POST["others".$i."_type"];
                            $singleplay["money"]=$_POST["others".$i."_money"];
                            $singleplay["amount"]=$_POST["others".$i."_amount"];
                            $singleplay["summoney"]=$_POST["others".$i."_amount"]*$_POST["others".$i."_money"];
                            $singleplay["remark"]=$_POST["others".$i."_remark"];
                                if(empty($_POST["others".$i."_id"])){//检查是否存在该plan
                                $singleplay["manageUser"]=$_COOKIE["userid"];
                                $singleplay["groupNumber"]=$teamNumber;
                                $db->insert("t_otherplan",$singleplay);
                                }else{//如果存在则修改
                                    $ls=array();
                                    $ls["id"]=$_POST["others".$i."_id"];
                                    $db->update("t_otherplan",$singleplay,"id='".$ls["id"]."'");
                                    array_push($newotherlans, $ls);
                                }
                        }
                        
                    }
               
            }
            $whiledelplans=array_diff_assoc2_deep($oldplans,$newplans);
            $whiledelotherplans=array_diff_assoc2_deep($oldotherplans,$newotherlans);
            //删除 已被删除的plans
            foreach ($whiledelplans as $d1){
                $db->del("t_reserveplan", "id='".$d1["id"]."'");
            }
            foreach ($whiledelotherplans as $d2){
                $db->del("t_otherplan", "id='".$d2["id"]."'");
            }
            die('{ "statusCode":"200", "message":"保存成功！", "navTabId":"editddxm", "rel":"", "callbackType":"", "forwardUrl":"", "confirmMsg":"" }');
        }
        break;
}
