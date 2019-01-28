<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">我社团号</th>
				<th align="center">组团社</th>
				<th align="center">首晚入住日期</th>
				<th align="center">客人</th>
				<th align="center">联系人</th>
				<th align="center">录单人</th>
				<th align="center">明细</th>
				<th align="center">应收</th>
				<th align="center">已收</th>
				<th align="center" >欠收</th>


			</tr>
		</thead>
		<tbody>
<?php


$yingshouz=0;
$yishouz=0;

    $sql="";
    
        $startdate=$_GET["startDate"];
        $enddate=$_GET["endDate"]!=""?$_GET["endDate"]:date("Y-m-d",time());
        $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
        $sql.=$_GET["zts_id"]!=""?" and groupName='".$_GET["zts_id"]."'":"";
        $sql.=$_GET["jd_id"]!=""?" and jd='".$_GET["jd_id"]."'":"";
        
        $sql.=$_GET["groupnum"]!=""?" and teamNumber like '%".$_GET["groupnum"]."%'":"";
        $sql.=@$_GET["cusname"]!=""?" and guest like '%".@$_GET["cusname"]."%'":"";
        $sql.=@$_GET["linkman"]!=""?" and linkmanname like '%".@$_GET["linkman"]."%'":"";
        $sql.=@$_GET["id"]!=""?" and groupName='".@$_GET["id"]."'":"";
//         echo $sql;
//         echo "select * from t_groupmanage  where 1=1 ".$sql." order by id desc";
    $result=mysqli_query($con,"select * from t_groupmanage  where 1=1 ".$sql." order by id desc" );
    // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);

    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
    //分页显示
    for($z=0;$z<count($resultarray);$z++){
        $yingshouzsql=mysqli_query($con, "select sum(sumPrice) as money from  t_reserveplan where groupNumber='".$resultarray[$z]["teamNumber"]."'");
        $yingshouzre=mysqli_fetch_array($yingshouzsql);
        $yingshouz+=$yingshouzre["money"];
    }


for($a=0;$a<count($resultarray);$a++){
    
    $yingshou=0;
    $yishou=0;
    $ztsid=$resultarray[$a]['groupName'];
    $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
    $zts=mysqli_fetch_array($ztssql);
    ?>
			    
			    <tr  >
			<td  align="center">
			<?php echo $a+1;?>
			</td>
			<td  align="center">
			<?php echo $resultarray[$a]["teamNumber"];?>
			</td>
			<td  align="center"><?php 
			echo $zts['travel_name'];
			?>
			</td>
			<td  align="center"><?php echo $resultarray[$a]["startDate"];?>
			</td>
			<td  align="center">
			<?php echo $resultarray[$a]["guest"];?>
			</td>
			<td  align="center"><?php echo $resultarray[$a]["linkmanname"];?>
			</td>
			<td  align="center">

			<?php echo $resultarray[$a]["manageUser"];?>
			</td>
			<td  align="center"><?php 
			$mxsql=mysqli_query($con, "select * from t_reserveplan where groupNumber='".$resultarray[$a]["teamNumber"]."'");
			$mxresult=mysqli_fetch_all($mxsql,MYSQLI_ASSOC);
			for($mx=0;$mx<count($mxresult);$mx++){
			    $jddianid=$mxresult[$mx]["hotelName"];
			    $jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			    $jddian=mysqli_fetch_array($jddiansql);
			    echo $jddian["hotelname"]." &nbsp;";
			    $fxid= $mxresult[$mx]["roomType"];
			    
			    $fxsql=mysqli_query($con, "select basetype from t_baseconfig where id=".$fxid);
			    $fx=mysqli_fetch_array($fxsql);
			    echo $fx["basetype"]." ";
			    echo $mxresult[$mx]["startDate"]." ";
			    echo $mxresult[$mx]["groupPrice"]."*".$mxresult[$mx]["number"]."*".$mxresult[$mx]["dayNum"]."=".$mxresult[$mx]["sumPrice"]."<br>";
			    $yingshou+=$mxresult[$mx]["sumPrice"];
			}
			?>
			</td>
			<td  align="center"><?php echo $yingshou;?>
			</td>
			<td  align="center"><?php 
			$yishousql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where groupNumber='".$resultarray[$a]["teamNumber"]."'");
			$yishoure=mysqli_fetch_array($yishousql);
			$yishou+=$yishoure["money"];
			echo $yishou;
			$yishouz+=$yishou;
			?>
			</td>
			<td  align="center"><?php echo $yingshou-$yishou;?>
			</td>
			
			</tr>
		<?php
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
				<th align="center"><?php echo $yingshouz;?></th>
				<th align="center"><?php echo $yishouz;?></th>
			<th align="center"><?php echo $yingshouz-$yishouz;?></th>
			</tr></tbody>