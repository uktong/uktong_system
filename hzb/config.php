<?php
date_default_timezone_set('prc');
header("Content-type: text/html; charset=utf-8");
//database
$dbhost="127.0.0.1";
$dbuser="root";
$dbpwd="root";
$dbchar="utf8";
$dbname="ukt";

//settings
$sitedoc="uktong_system";
$serverurl="localhost";
$link="http";//连接方式
$servername="优客通管理系统";
$version="V 0.1";
$copyrightyear="2019";
$copyrightname="UKTONG";
$copyrighttext="成都优客通科技有限责任公司";
$cookielife=time()+24*3600;
define("R", $_SERVER['DOCUMENT_ROOT']."/".$sitedoc."/");
$firstday = date("Y-m-01");
$today = date("Y-m-d");
$tomorrow = date("Y-m-d",strtotime("+1 day"));
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
$numPerPage=20;//默认每页显示30条数据
$pageNum=1;//默认打开为第一页
class url{
    public $serverurl;
    public $sitedoc;
    function __construct($a,$b){
        $this->serverurl=$a;
        $this->sitedoc=$b;
    }
    function to($url){
        header("location:http://".$this->serverurl."/".$this->sitedoc."/".$url);
    }
}
$url=new url($serverurl,$sitedoc);
