<?php
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
require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));


?>
<thead>
<tr>
<th align="center">序号</th>
<th align="center">团号</th>
<th align="center">组团社</th>
<th align="center">人数</th>
<th align="center">路早</th>
<th align="center">计调	</th>
<th align="center">日期</th>
<th align="center">房型</th>
<th align="center">客人信息</th>
<th align="center" >订单状态</th>
</tr>
</thead>
<tbody>

<?php
$hotelcode=$_SESSION["hotelcode"];
$idsql=mysqli_query($con, "select id from t_travel where travel_code='".$hotelcode."' ");
$idre=mysqli_fetch_array($idsql);

if(@$_POST["search"]==null){
    $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on t_groupmanage.teamNumber=t_reserveplan.groupNumber where   t_groupmanage.groupName='".$idre['id']."' and t_groupmanage.hotelManage='代订酒店' and t_reserveplan.startDate between '".$firstday."' and '".$lastday."'" );
    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
    //分页显示
    
    
    $resultnum=count($resultarray);
    @$page=ceil($resultnum/$numPerPage);
    @$sr=($pageNum-1)*$numPerPage;
    $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber  where t_groupmanage.groupName='".$idre['id']."' and t_groupmanage.hotelManage='代订酒店' and t_reserveplan.startDate between '".$firstday."' and '".$lastday."' order by t_groupmanage.id  limit ".$sr.",".$numPerPage  );
    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
}else {
    $sql="";
    if($_POST["startDate"]!=""){
        $startdate=$_POST["startDate"];
        $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
        $sql.=" and t_reserveplan.startDate between '".$startdate."' and '".$enddate."'";
    }
    $sql.=$_POST["jd_id"]!=""?" and t_groupmanage.jd='".$_POST["jd_id"]."'":"";
    $sql.=$_POST["fjtype111_id"]!=""?" and t_reserveplan.roomType='".$_POST["fjtype111_id"]."'":"";
    $sql.=$_POST["groupnum"]!=""?" and t_groupmanage.teamNumber like '%".$_POST["groupnum"]."%'":"";
    $sql.=$_POST["cusname"]!=""?" and t_groupmanage.guest like '%".$_POST["cusname"]."%'":"";
    $sql.=$_POST["linkman"]!=""?" and t_groupmanage.linkmanname like '%".$_POST["linkman"]."%'":"";
    $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where  t_groupmanage.groupName='".$idre['id']."' and t_groupmanage.hotelManage='代订酒店'  ".$sql." order by t_groupmanage.id" );
    // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
    //分页显示
    
    $resultnum=count($resultarray);
    @$page=ceil($resultnum/$numPerPage);
    @$sr=($pageNum-1)*$numPerPage;
    $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_groupmanage.groupName='".$idre['id']."' and t_groupmanage.hotelManage='代订酒店'  ".$sql." order by t_groupmanage.id limit ".$sr.",".$numPerPage );
    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
}




for($a=0;$a<count($resultnowarray);$a++){
    
    $jdid=$resultnowarray[$a]['jd'];
    $jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
    $jd=mysqli_fetch_array($jdsql);
    $ztsid=$resultnowarray[$a]['groupName'];
    $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
    @$zts=mysqli_fetch_array($ztssql);
    ?>
			    
			    <tr  >
			<td  >
			<?php echo $a+1;?>
			</td>
			<td  >
			<?php echo $resultnowarray[$a]["teamNumber"];?>
			</td>
			<td  ><?php 
			echo $zts['travel_name'];
			?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["number"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["breakfast"]=="1"?"路早":"正常早餐";?>
			</td>
			<td  ><?php 
			$jdid=$resultnowarray[$a]["jd"];
			$jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
			$jd=mysqli_fetch_array($jdsql);
			echo $jd["username"];
			?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["startDate"];?>
			</td>
			<td  ><?php
			$fxid= $resultnowarray[$a]["roomType"];
			$fxsql=mysqli_query($con, "select basetype from t_baseconfig where id=".$fxid);
			$fx=mysqli_fetch_array($fxsql);
			echo $fx["basetype"];
			?>
			</td>
			<td  style="word-break:break-all; word-wrap:break-all;width:300px;"><?php echo $resultnowarray[$a]["guestName"];?>
			</td>
			
		<td  ><?php 
			if($resultnowarray[$a]['lxsstatus']=="yes"){
			    
			    $orderstates="<span style='color:green;'>已确认</span>";
			}else{
			    $orderstates="<span style='color:red;'>未确认</span>";
			}
			echo $orderstates;
			?>
</td>

			</tr>
		<?php
			}
 
    ?>
	   
	    </tbody>