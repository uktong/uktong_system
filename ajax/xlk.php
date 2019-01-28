<?php
require "../hzb/config.php";
require R.'hzb/inc/load.php';

if(isset($_GET["name"])){
    $name=$_GET["name"];
}else {
    $name=$_POST["name"];
}
if($name!=""){
switch ($_GET["type"]){
    case "zts":
        $data=$db->select("t_travel", "id,travel_name as zts", "travel_code like '%".$name."%' or travel_name like '%".$name."%' limit 0,10");
        break;
    case "jd":
        $data=$db->select("t_user", "id,username as jd", "usercode like '%".$name."%' or username like '%".$name."%'  limit 0,10");
        break;
    case "wl":
        $data=$db->select("t_user", "id,username as wl", "usercode like '%".$name."%' or username like '%".$name."%'  limit 0,10");
        break;
    case "addhotel":

        $data=$db->select("t_allhotel", "id,hotelname as addhotel", "hotelcode like '%".$name."%' or hotelname like '%".$name."%'  limit 0,10");
        break;
    case "doing":
        $data=$db->select("t_user", "id,username as adddoing", "usercode like '%".$name."%' or username like '%".$name."%'  limit 0,10");
        break;
}
}
echo json_encode($data);
