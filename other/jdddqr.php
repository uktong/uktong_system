<?php 
require_once $_SESSION["ROOT"].'/other/check.php';
if(@$_POST["numPerPage"]!=null){
    $numPerPage=$_POST["numPerPage"];
//      $keywords=$_POST["keywords"];
    $pageNum=$_POST["pageNum"];
//     $status=$_POST["status"];
//     $orderField=$_POST["orderField"];
    
}else{
    $numPerPage=20;
    $pageNum=1;
}

date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));

require_once $_SESSION["ROOT"].'/db/db.php';
$hotelcode=$_SESSION["hotelcode"];
$idsql=mysqli_query($con, "select id from t_allhotel where hotelcode='".$hotelcode."' ");
$idre=mysqli_fetch_array($idsql);
if(@$_POST["search"]==null){
    $result=mysqli_query($con,"select * from t_reserveplan where  startDate between '".$firstday."' and '".$lastday."' and  hotelName='".$idre["id"]."'" );
    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
    //分页显示
    $resultnum=count($resultarray);
    @$page=ceil($resultnum/$numPerPage);
    @$sr=($pageNum-1)*$numPerPage;
    @$er=$pageNum*$numPerPage;
    $resultnow=mysqli_query($con,"select * from t_reserveplan where  startDate between '".$firstday."' and '".$lastday."' and  hotelName='".$idre["id"]."' order by startDate DESC limit ".$sr.",".$er  );
    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
}else {
    $sql="";
    if($_POST["startDate"]!=""){
        $startdate=$_POST["startDate"];
        $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
        $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
    }
    // 			     $sql.=$_POST["zts_id"]!=""?" and groupName='".$_POST["zts_id"]."'":"";
    $sql.=$_POST["jd_id"]!=""?" and manageUser='".$_POST["jd_id"]."'":"";
    if($_POST["planstatus"]!="全部"){
    $sql.=$_POST["planstatus"]!="yes"?"and planstatus is null":" and planstatus='yes'";
    }
    $sql.=$_POST["krxm"]!=""?" and guestName like '%".$_POST["krxm"]."%'":"";
    $sql.=$_POST["groupnum"]!=""?" and groupNumber like '%".$_POST["groupnum"]."%'":"";
    $result=mysqli_query($con,"select * from t_reserveplan where   hotelName='".$idre["id"]."' ".$sql );
    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
    
    //分页显示
    $resultnum=count($resultarray);
    @$page=ceil($resultnum/$numPerPage);
    @$sr=($pageNum-1)*$numPerPage;
    $resultnow=mysqli_query($con,"select * from t_reserveplan where   hotelName='".$idre["id"]."' ".$sql." order by startDate DESC limit ".$sr.",".$numPerPage );
    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
}
$qxsql=mysqli_query($con, "select userlimit from t_hoteluser where id=".$_SESSION["userid"]);
$qx=mysqli_fetch_array($qxsql);
$allqx=explode(",", $qx["userlimit"]);
$show="style='display:block;color:blue;'";
$hide="style='display:none;color:blue;'";
$limitsure=$hide;
$limitedit=$hide;
$limitadd="style='display:none;'";
for($q=1;$q<count($allqx);$q++){
   
    if($allqx[$q]=="edit"){
        $limitedit=$show;
    }
    if($allqx[$q]=="new"){
        $limitadd="style='display:block;'";
    }
    
}
?>
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">酒店</th>
				<th align="center">路早</th>
				<th align="center">入住日期</th>
				<th align="center">对接人</th>
				<th align="center">房间类型</th>
				<th align="center">数量</th>
				<th align="center">天数</th>
				<th align="center">累计</th>
				<th align="center" >客人信息</th>
				<th align="center" >订单状态</th>
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 
			for($a=0;$a<count($resultnowarray);$a++){
			    if($resultnowarray[$a]['planstatus']!=null){
			        
			        $orderstates="<span style='color:green;'>确认</span>";
			    }else{
			        $orderstates="<span style='color:red;'>未确认</span>";
			        $limitsure=$show;
			    }
			    $gettimesql=mysqli_query($con, "select enteringDate,groupName from t_groupmanage where teamNumber='".$resultnowarray[$a]['groupNumber']."'");
			    $gettime=mysqli_fetch_array($gettimesql);
// 			    echo "select enteringDate,groupName from t_groupmanage where teamNumber='".$resultnowarray[$a]['groupNumber']."'";
// 			    if(strtotime(date('Y-m-d H:i:s'))-strtotime($gettime['enteringDate'])<86400){
// 			        if($gettime['groupName']=""&&strstr($resultnowarray[$a]['groupNumber'], $_SESSION["hotelcode"])!=null){
// 			            $limitedit=$show;
// 			        }else{
// 			            $limitedit=$hide;
// 			        }
			      
// 			    }else{
// 			        $limitedit=$hide;
// 			    }
// 			    echo "zts:".$gettime['groupName']."<br>cunzaima :",strpos($resultnowarray[$a]['groupNumber'], $_SESSION["hotelcode"]);
			    ?>
			   <tr  >
			<td ><?php echo $a+1;?>
			</td><td ><?php echo $resultnowarray[$a]['groupNumber'];?>
            </td><td ><?php 
			$jddianid=$resultnowarray[$a]['hotelName'];
			$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			$jddian=mysqli_fetch_array($jddiansql);
			echo $jddian["hotelname"];
			?>
			</td><td ><?php echo $resultnowarray[$a]["breakfast"]=="1"?"路早":"正常早餐";?>
			</td><td  ><?php echo $resultnowarray[$a]["startDate"];?>
			</td><td  ><?php 
			$jdid=$resultnowarray[$a]["manageUser"];
			$jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
			$jd=mysqli_fetch_array($jdsql);
			echo $jd["username"];
			?>
			</td><td ><?php
			$fxid= $resultnowarray[$a]["roomType"];
			$fxsql=mysqli_query($con, "select basetype from t_baseconfig where id=".$fxid);
			$fx=mysqli_fetch_array($fxsql);
			echo $fx["basetype"];
			?>
</td><td ><?php echo $resultnowarray[$a]["number"];?>
</td><td ><?php echo $resultnowarray[$a]["dayNum"];?>
</td><td ><?php echo $resultnowarray[$a]["number"]*$resultnowarray[$a]["dayNum"];?>
			</td><td  style='width:200px;word-wrap: break-word;'><?php echo $resultnowarray[$a]["guestName"];?>
			</td><td  ><?php 
			if($resultnowarray[$a]['planstatus']=="yes"){
			    
			    $orderstates="<span style='color:green;'>已确认</span>";
			}else{
			    $orderstates="<span style='color:red;'>未确认</span>";
			}
			echo $orderstates;
			?>
</td>


</tr>
		<?php }
 
    ?>

		</tbody>
