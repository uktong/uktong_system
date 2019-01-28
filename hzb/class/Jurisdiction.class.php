<?php
class Jurisdiction{
    

    public $Jname;//权限名字数组
    function __construct($a){
        $this->Jname=$a;
    }
    function recheckJur($val){
        switch ($val){
            case "0":
                return false;
                break;
            case "1":
                return true;
                break;
        }
    }
    function recheckRan($val){
        switch ($val){
            case "0":
                return "person";
                break;
            case "1":
                return "department";
                break;
            case "2":
                return "company";
                break;
            case "3":
                return "group";
                break;
        }
    }
    function getJurname($val){
        
        foreach ($this->Jname  as $j){
            if($j["id"]==$val){
                return $j["presName"];
            }
        }
    }
    function getJurcomment($val){
        
        foreach ($this->Jname  as $j){
            if($j["id"]==$val){
                return $j["comment"];
            }
        }
    }
    function getJururl($val){
        
        foreach ($this->Jname  as $j){
            if($j["id"]==$val){
                return $j["url"];
            }
        }
    }
    function getJursort($val){
        
        foreach ($this->Jname  as $j){
            if($j["id"]==$val){
                return $j["sort"];
            }
        }
    }
    function getJurlastid($val){
        
        foreach ($this->Jname  as $j){
            if($j["id"]==$val){
                return $j["lastid"];
            }
        }
    }
    function arraySort($arr, $keys, $type = 'asc') {
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v){
            $keysvalue[$k] = $v[$keys];
        }
        $type == 'asc' ? asort($keysvalue) : arsort($keysvalue);
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
    function Jresult($Jtxt){//返回权限结果
        $allJur=explode("|",$Jtxt);
        $Jurisdictionall=array();
        foreach ($allJur as $a){
            
            $Jurisdictionname=array();
            $Jurisdiction=array();
            $singleJur=explode(",",$a);
            $Jurisdiction["add"]=$this->recheckJur($singleJur[1]);
            $Jurisdiction["edit"]=$this->recheckJur($singleJur[2]);
            $Jurisdiction["del"]=$this->recheckJur($singleJur[3]);
            $Jurisdiction["limit"]=$this->recheckJur($singleJur[4]);
            $Jurisdiction["range"]=$this->recheckRan($singleJur[5]);
            
            $Jurisdictionname["id"]=$singleJur[0];
            $Jurisdictionname["lastid"]=$this->getJurlastid($singleJur[0]);
            $Jurisdictionname["comment"]=$this->getJurcomment($singleJur[0]);
            $Jurisdictionname["name"]=$this->getJurname($singleJur[0]);
            $Jurisdictionname["url"]=$this->getJururl($singleJur[0]);
            $Jurisdictionname["sort"]=$this->getJursort($singleJur[0]);
            $Jurisdictionname["content"]=$Jurisdiction;
            $Jurisdictionname["state"]=$singleJur[6];
            array_push($Jurisdictionall, $Jurisdictionname);
        }
        foreach ($Jurisdictionall as $key => $row)
        {
            $volume[$key]  = $row['sort'];
        }
        
        array_multisort($volume, SORT_ASC, $Jurisdictionall);
        return $Jurisdictionall;
    }

}