<?php

class base{
    public $R;
    public $fileroot="cache/base/";
    public $Jurroot="cache/Jur/";
    function __construct($b){
        $this->R=$b;
    }
    
    function getdata($datatype,$data,$search="id"){
        $dataarray=json_decode(file_get_contents($this->R.$this->fileroot.$datatype.'.json'), true);
        foreach ($dataarray as $a){
            if($a[$search]==$data){
                return $a;
            }
        }
    }
    function data($datatype){
        $dataarray=json_decode(file_get_contents($this->R.$this->fileroot.$datatype.'.json'), true);
       
        return $dataarray;
         
    }
    function getJur($datatype,$data,$search="id"){
        $dataarray=json_decode(file_get_contents($this->R.$this->Jurroot.$datatype.'.json'), true);
        
        foreach ($dataarray as $a){
            foreach ($a["son"] as $s){
                if(md5($s[$data])==$search){
                    return $s;
                }
            }
            
        }
    }
}
