	<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">我社团号</th>
				<th align="center">组团社</th>
				<th align="center">人数</th>
				<th align="center">酒店</th>
				<th align="center">酒店状态</th>
				<th align="center">路早</th>
				<th align="center">计调</th>
				<th align="center">日期</th>
				<th align="center">房型</th>
				<th align="center" style="width:300px;">客人姓名</th>
				<th align="center">数量</th>
				<th align="center">天数</th>
				<th align="center" >累计数</th>
				<th align="center">单价</th>
				<th align="center">应付</th>
<th align="center">已付</th>
<th align="center">欠付</th>
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 $shuliangz=0;
			 $tianshuz=0;
			 $danjiaz=0;
			 $jinez=0;
			 $leijiz=0;
			 $qianfuz=0;
			 $yfuz=0;
			 $shuliang=0;
			 $tianshu=0;
			 $danjia=0;
			 $jine=0;
			 $leiji=0;
		
			     $sql="";
			         $startdate=$_GET["startDate"];
			         $enddate=$_GET["endDate"]!=""?$_GET["endDate"]:date("Y-m-d",time());
			         $sql.=" and t_reserveplan.startDate between '".$startdate."' and '".$enddate."'";
			         $sql.=@$_GET["zts_id"]!=""?" and t_groupmanage.groupName='".@$_GET["zts_id"]."'":"";
			         $sql.=@$_GET["jd_id"]!=""?" and t_groupmanage.jd='".@$_GET["jd_id"]."'":"";
			         $sql.=@$_GET["fjtype111_id"]!=""?" and t_reserveplan.roomType='".@$_GET["fjtype111_id"]."'":"";
			         $sql.=@$_GET["jdian111_id"]!=""?" and t_reserveplan.hotelName='".@$_GET["jdian111_id"]."'":"";
			         $sql.=@$_GET["groupnum"]!=""?" and t_groupmanage.teamNumber like '%".@$_GET["groupnum"]."%'":"";
			         $sql.=@$_GET["cusname"]!=""?" and t_groupmanage.guest like '%".@$_GET["cusname"]."%'":"";
			         $sql.=@$_GET["id"]!=""?" and t_reserveplan.hotelName='".@$_GET["id"]."'":"";

			     $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where 1=1 ".$sql." order by t_groupmanage.id" );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			         $yifuzsql=mysqli_query($con, "select fee from t_hoteldebt where name=".$resultarray[$z]['hotelName']."  and
 groupnumber='".$resultarray[$z]["teamNumber"]."' and reserveplan=".$resultarray[$z]["id"]);
			         @$yifuz=mysqli_fetch_all($yifuzsql,MYSQLI_ASSOC);
			         $yifujez=0;
			         for($yf=0;$yf<count($yifuz);$yf++){
			             $yifujez+=@$yifuz[$yf]["fee"];
			         }
			         $shuliangz+=$resultarray[$z]["number"];
			         $tianshuz+=$resultarray[$z]["dayNum"];
			         $danjiaz+=$resultarray[$z]["costPrice"];
			         $jinez+=$resultarray[$z]["hotelCommissionSum"];
			         $leijiz+=$resultarray[$z]["number"]*$resultarray[$z]["dayNum"];
			         $yfuz+=$yifujez;
			         $qianfuz+=($resultarray[$z]["hotelCommissionSum"]-$yifujez);
			         
			     }
			     $resultnum=count($resultarray);
			     $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where 1=1 ".$sql." order by t_groupmanage.id " );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			
			    
			$yfu=0;
			$qianfu=0;
			for($a=0;$a<count($resultnowarray);$a++){
			   

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
			<td>
			<?php 
			$jddianid=$resultnowarray[$a]['hotelName'];
			$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			$jddian=mysqli_fetch_array($jddiansql);
			echo $jddian["hotelname"];
			?>
			</td>
			<td>
			<?php 
			if($resultnowarray[$a]['orderstates']=="yes"){
			    
			    $orderstates="<span style='color:green;'>已确认</span>";
			}else{
			    $orderstates="<span style='color:red;'>未确认</span>";
			}
			echo $orderstates;
			?>
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
			<td  ><?php echo $resultnowarray[$a]["guestName"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["number"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["dayNum"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["number"]*$resultnowarray[$a]["dayNum"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["costPrice"];?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["hotelCommissionSum"];?>
			</td>
			<td>
			<?php 
			$yifusql=mysqli_query($con, "select fee from t_hoteldebt where name=".$jddianid."  and
 groupnumber='".$resultnowarray[$a]["teamNumber"]."'and createTime between '".$startdate."' and '".$enddate."' and reserveplan=".$resultnowarray[$a]["id"]);
			@$yifu=mysqli_fetch_all($yifusql,MYSQLI_ASSOC);
			$yifuje=0;
			for($yf=0;$yf<count($yifu);$yf++){
			    $yifuje+=@$yifu[$yf]["fee"];
			}
			echo $yifuje;
			?>
			</td>
			<td>
			<?php 
			echo $resultnowarray[$a]["hotelCommissionSum"]-$yifuje;
			?>
			
			</td>
			</tr>
		<?php
		$shuliang+=$resultnowarray[$a]["number"];
		$tianshu+=$resultnowarray[$a]["dayNum"];
		$danjia+=$resultnowarray[$a]["costPrice"];
		$jine+=$resultnowarray[$a]["hotelCommissionSum"];
		$leiji+=$resultnowarray[$a]["number"]*$resultnowarray[$a]["dayNum"];
		$yfu+=$yifuje;
		$qianfu+=($resultnowarray[$a]["hotelCommissionSum"]-$yifuje);
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
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $shuliangz;?></th>
				<th align="center"><?php echo $tianshuz;?></th>
				<th align="center"><?php echo $leijiz;?></th>
				<th align="center"><?php echo $danjiaz;?></th>
				<th align="center"><?php echo $jinez;?></th>
				<th align="center"><?php echo $yfuz;?></th>
				<th align="center"><?php echo $qianfuz;?></th>
			</tr>
	    </tbody>