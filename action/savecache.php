<?php

//存储最新user
$userfile = fopen(R."cache/base/user.json", "w") or die("Unable to open file!");
$usertxt = json_encode($db->select("t_user", "*", "1=1"));
fwrite($userfile, $usertxt);
fclose($userfile);
//存储最新组团社
$travelfile = fopen(R."cache/base/travel.json", "w") or die("Unable to open file!");
$traveltxt = json_encode($db->select("t_travel", "*", "1=1"));
fwrite($travelfile, $traveltxt);
fclose($travelfile);
//存储最新公司信息
$travelfile = fopen(R."cache/base/company.json", "w") or die("Unable to open file!");
$traveltxt = json_encode($db->select("t_hotel", "*", "1=1"));
fwrite($travelfile, $traveltxt);
fclose($travelfile);
//存储最新部门
$travelfile = fopen(R."cache/base/department.json", "w") or die("Unable to open file!");
$traveltxt = json_encode($db->select("t_dept", "*", "1=1"));
fwrite($travelfile, $traveltxt);
fclose($travelfile);
//存储最新酒店信息
$travelfile = fopen(R."cache/base/hotel.json", "w") or die("Unable to open file!");
$traveltxt = json_encode($db->select("t_allhotel", "*", "1=1"));
fwrite($travelfile, $traveltxt);
fclose($travelfile);
//存储最新房型信息
$travelfile = fopen(R."cache/base/room.json", "w") or die("Unable to open file!");
$traveltxt = json_encode($db->select("t_baseconfig", "*", "basenote=2 order by px "));
fwrite($travelfile, $traveltxt);
fclose($travelfile);
////存储用户自身信息
$travelfile = fopen(R."cache/base/".md5($username).".json", "w") or die("Unable to open file!");
$traveltxt = json_encode($db->select(" t_hotel as b left join t_dept as c on c.hotel=b.hotelcode left join t_user as a  on a.hotel=b.id ","*,a.id as userid,b.id as hotelid,c.id as deptid","a.id=".$usermsg[0]["id"]));
fwrite($travelfile, $traveltxt);
fclose($travelfile);