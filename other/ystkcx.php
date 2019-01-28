<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">我社团号</th>
				<th align="center">组团社</th>
				<th align="center">路早</th>
				<th align="center">计调	</th>
				<th align="center">日期</th>
				<th align="center">房型</th>
				<th align="center">客人姓名</th>
				<th align="center">数量</th>
				<th align="center">天数</th>
				<th align="center" >累计数</th>
				<th align="center">单价</th>
				<th align="center">金额</th>

			</tr>
		</thead>
		<tbody>
<?php

$shuliangz=0;
$tianshuz=0;
$danjiaz=0;
$jinez=0;
$leijiz=0;
    $sql="";
        $startdate=$_GET["startDate"];
        $enddate=$_GET["endDate"]!=""?$_GET["endDate"]:date("Y-m-d",time());
        $sql.=" and t_reserveplan.startDate between '".$startdate."' and '".$enddate."'";
        $sql.=$_GET["zts_id"]!=""?" and t_groupmanage.groupName='".$_GET["zts_id"]."'":"";
        $sql.=$_GET["jd_id"]!=""?" and t_groupmanage.jd='".$_GET["jd_id"]."'":"";
        $sql.=@$_GET["fjtype111_id"]!=""?" and t_reserveplan.roomType='".@$_GET["fjtype111_id"]."'":"";
        $sql.=@$_GET["jdian111_id"]!=""?" and t_reserveplan.hotelName='".@$_GET["jdian111_id"]."'":"";
        $sql.=$_GET["groupnum"]!=""?" and t_groupmanage.teamNumber like '%".$_GET["groupnum"]."%'":"";
        $sql.=@$_GET["cusname"]!=""?" and t_groupmanage.guest like '%".@$_GET["cusname"]."%'":"";
        $sql.=@$_GET["linkman"]!=""?" and t_groupmanage.linkmanname like '%".@$_GET["linkman"]."%'":"";
        $sql.=@$_GET["id"]!=""?" and t_groupmanage.groupName='".@$_GET["id"]."'":"";
//         echo $sql;
    $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where 1=1 ".$sql." order by t_groupmanage.id" );
    // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);

    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
    //分页显示
    for($z=0;$z<count($resultarray);$z++){
        $shuliangz+=$resultarray[$z]["number"];
        $tianshuz+=$resultarray[$z]["dayNum"];
        $danjiaz+=$resultarray[$z]["groupPrice"];
        $jinez+=$resultarray[$z]["sumPrice"];
        $leijiz+=$resultarray[$z]["number"]*$resultarray[$z]["dayNum"];
    }
    $resultnum=count($resultarray);
    $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where 1=1 ".$sql." order by t_groupmanage.id" );
    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);


$shuliang=0;
$tianshu=0;
$danjia=0;
$jine=0;
$leiji=0;

for($a=0;$a<count($resultnowarray);$a++){
    
    $jdid=$resultnowarray[$a]['jd'];
    $jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
    $jd=mysqli_fetch_array($jdsql);
    $ztsid=$resultnowarray[$a]['groupName'];
    $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
    @$zts=mysqli_fetch_array($ztssql);
    ?>
			    
			    <tr  >
			<td  align="center">
			<?php echo $a+1;?>
			</td>
			<td  align="center">
			<?php echo $resultnowarray[$a]["teamNumber"];?>
			</td>
			<td  align="center"><?php 
			echo $zts['travel_name'];
			?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["breakfast"]=="1"?"路早":"正常早餐";?>
			</td>
			<td  align="center"><?php 
			$jdid=$resultnowarray[$a]["jd"];
			$jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
			$jd=mysqli_fetch_array($jdsql);
			echo $jd["username"];
			?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["startDate"];?>
			</td>
			<td  align="center"><?php
			$fxid= $resultnowarray[$a]["roomType"];
			$fxsql=mysqli_query($con, "select basetype from t_baseconfig where id=".$fxid);
			$fx=mysqli_fetch_array($fxsql);
			echo $fx["basetype"];
			?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["guestName"];?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["number"];?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["dayNum"];?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["number"]*$resultnowarray[$a]["dayNum"];?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["groupPrice"];?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["sumPrice"];?>
			</td>
			</tr>
		<?php
		$shuliang+=$resultnowarray[$a]["number"];
		$tianshu+=$resultnowarray[$a]["dayNum"];
		$danjia+=$resultnowarray[$a]["groupPrice"];
		$jine+=$resultnowarray[$a]["sumPrice"];
		$leiji+=$resultnowarray[$a]["number"]*$resultnowarray[$a]["dayNum"];
			}
 
    ?>
	 
			 <tr class="tfoot">
				<th align="center">总计：</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $shuliangz;?></th>
				<th align="center"><?php echo $tianshuz;?></th>
				<th align="center"><?php echo $leijiz;?></th>
				<th align="center"><?php echo $danjiaz;?></th>
				<th align="center"><?php echo $jinez;?></th>
			</tr></tbody>