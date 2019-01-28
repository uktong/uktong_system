<?php
require "../hzb/config.php";
require R.'hzb/class/db.class.php';
$username=$_POST["username"];
$password=$_POST["password"];
$code=$_POST["code"];

if(md5($code)!=$_COOKIE["verification"]){
    echo <<<alert

<script>alert("验证码错误！请重新输入！");
history.go(-1);
</script>

alert;
}else{
        $usermsg=$db->select("t_user as a left join t_hotel as b on a.hotel=b.id", "a.id,b.hotelcode", "a.username='".$username."' and a.password='".$password."'");
        $hotelmsg=$db->select("t_hoteluser as a left join t_allhotel as b on a.hotel=b.id", "b.hotelcode,a.id,b.id as hotelid", "a.username='".$username."' and a.password='".$password."'");
        $travelmsg=$db->select("t_traveluser as a left join t_travel as b on a.travel=b.id", "b.travel_code,a.id,b.id as travelid", "a.username='".$username."' and a.password='".$password."'");
        if(count($usermsg)!=0){
            setcookie("usertype", "lxs", $cookielife, "/");
            setcookie("hotelcode", $usermsg[0]["hotelcode"], $cookielife, "/");
            setcookie("userid", $usermsg[0]["id"], $cookielife, "/");
            setcookie("username", $username, $cookielife, "/");
            require 'savecache.php';
            $url->to("index.php");
        }else if(count($hotelmsg)!=0){
            setcookie("usertype", "hotel", $cookielife, "/");
            setcookie("hotelcode", $usermsg[0]["hotelcode"], $cookielife, "/");
            setcookie("userid", $usermsg[0]["id"], $cookielife, "/");
            setcookie("hotelid", $usermsg[0]["hotelid"], $cookielife, "/");
            setcookie("username", $username, $cookielife, "/");
            $url->to("index.php");
        }else if(count($travelmsg)!=0){
            setcookie("usertype", "travel", $cookielife, "/");
            setcookie("hotelcode", $usermsg[0]["hotelcode"], $cookielife, "/");
            setcookie("userid", $usermsg[0]["id"], $cookielife, "/");
            setcookie("hotelid", $usermsg[0]["travelid"], $cookielife, "/");
            setcookie("username", $username, $cookielife, "/");
            $url->to("index.php");
        }else{
        echo <<<alert
        
            <script>alert("账号或密码错误，请重新输入！");
            history.go(-1);
            </script>
            
alert;
    }
}
