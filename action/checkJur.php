<?php
class checkJur{
    
    
    
    function type($jarr,$type){
        switch ($type){
            case "add":
                if(!$jarr["content"][$type]){
                    die("您无权访问该页面");
                }
                break;
            case "edit":
                if(!$jarr["content"][$type]){
                    die("您无权访问该页面");
                }
                break;
            case "range":
                return $jarr["content"][$type];
                break;
            case "limit":
                return $jarr["content"][$type];
                break;
            case "del":
                return $jarr["content"][$type];
                break;
                
        }
        
    }
    
}
$J=new checkJur();