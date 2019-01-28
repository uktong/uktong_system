<?php
class  DB{
    public   $iP;
    public   $username;
    public   $psw;
    public   $charType;
    public  $selectDb;
    public  $con;
    function __construct($a,$b,$c,$d,$e){
        $this->iP=$a;
        $this->username=$b;
        $this->psw=$c;
        $this->charType=$d;
        $this->selectDb=$e;
    }
    /*连接mysql*/
    public function  link_mysql(){
        $con=mysqli_connect($this->iP,$this->username,$this->psw,$this->selectDb);
        mysqli_set_charset($con,$this->charType);
        $this->con=$con;
    }
    public   function insert($table,$data){
        $allkey='';
        $allval='';
        foreach($data as $key=>$val){
            $allkey.=$key.',';
            $allval.="'".$val."',";
        }
        $allkey=substr($allkey,0,strlen($allkey)-1);
        $allval=substr($allval,0,strlen($allval)-1);
        $sql="insert into ".$table."(".$allkey.")values(".$allval.") ";
        $result=mysqli_query($this->con,$sql);
        return $result;
    }
    public  function update($table,$data,$where){

        $alldata='';
        foreach($data as $key=>$val){
            $alldata.=$key."='".$val."',";
            
        }
        $alldata=substr($alldata,0,strlen($alldata)-1);
        $sql="update  ".$table." set ".$alldata." where ".$where;
        $result=mysqli_query($this->con,$sql);
        return $result;
    }
   public   function select($table,$data,$where){
        $sql="select   ".$data." from ".$table." where ".$where;
        $resorse=mysqli_query($this->con,$sql);
        $selectdata=mysqli_fetch_all($resorse,MYSQLI_ASSOC);
        return $selectdata;
    }
    public   function del($table,$where){
        $sql="delete  from ".$table." where ".$where;
        $result=mysqli_query($this->con,$sql);
        return $result;
    }
    public  function tabledata($pageNum,$numPerPage,$table,$data,$where,$count){
        $resultarraycount=$this->select($table, "count(".$count.") as num",  $where);
        $resultnum=$resultarraycount[0]["num"];
        $sr=($pageNum-1)*$numPerPage;
        $resultnowarray=$this->select($table, $data,  $where." limit ".$sr.",".$numPerPage );
        $data=array();
        $data["amount"]=$resultnum;
        $data["result"]=$resultnowarray;
        return $data;
    }
}
$db=new DB($dbhost,$dbuser,$dbpwd,$dbchar,$dbname);
$db->link_mysql();
