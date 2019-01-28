<tbody>
                    <tr>
				<th align="center">序号</th>
				<th align="center">组团社</th>
				<th align="center">本期应收</th>
				<th align="center" >本期已收</th>
				<th align="center">本期欠收</th>
				<th align="center">总欠收</th>
			</tr>
                    
                <?php 
			 
			     $sql="";
			         $startdate=$_GET["startDate"];
			         $enddate=$_GET["endDate"]!=""?$_GET["endDate"]:date("Y-m-d",time());
			         $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
			     $sql.=$_GET["zts_id"]!=""?" and groupName='".$_GET["zts_id"]."'":"";
			     $sql.=$_GET["jd_id"]!=""?" and jd='".$_GET["jd_id"]."'":"";
			     $sql.=$_GET["wl_id"]!=""?" and wl='".$_GET["wl_id"]."'":"";
			     $sql.=$_GET["groupnum"]!=""?" and teamNumber like '%".$_GET["groupnum"]."%'":"";
			    
			     $resultnow=mysqli_query($con,"select distinct groupName from t_groupmanage where 1=1 ".$sql." order by id DESC  " );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 
			 
			 
			 
			    
			     $xjys=0;
			     $xjysshou=0;
			     $xjqs=0;
			     $xjzqs=0;
			for($a=0;$a<count($resultnowarray);$a++){
			    ?>
			    <tr  >
			<td  align="center">
			<?php echo $a+1;?>
			</td>
			<td  align="center"><?php 
			$ztsid=$resultnowarray[$a]['groupName'];
			$ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			@$zts=mysqli_fetch_array($ztssql); 
			echo $zts['travel_name'];
			?>
			</td>

			<td  align="center"><?php 
			$getgroupNumbersql=mysqli_query($con, "select teamNumber from t_groupmanage where groupName=".$ztsid);
			@$getgroupNumber=mysqli_fetch_all($getgroupNumbersql,MYSQLI_ASSOC);
			$ys=0;
			for($gn=0;$gn<count($getgroupNumber);$gn++){
			    $yssql=mysqli_query($con, "select sum(sumPrice) as money from t_reserveplan where groupNumber='".$getgroupNumber[$gn]["teamNumber"]."'");
			$ysje=mysqli_fetch_array($yssql);
			$ys+= $ysje["money"];
			}
			echo $ys;
			?>
			</td>
			<td  align="center">
			<?php 
			$yshou=0;
			for($gn=0;$gn<count($getgroupNumber);$gn++){
			    $yssql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where groupNumber='".$getgroupNumber[$gn]["teamNumber"]."'");
			$yshouje=mysqli_fetch_array($yssql);
			$yshou+= $yshouje["money"];
			}
			echo $yshou;
			?>
			</td>
			<td  align="center">
			<?php 
			
			echo $ys-$yshou;
			?>
			</td>
		<td  align="center">
		<?php 
			echo $ys-$yshou;
			?>
			</td>
			</tr>
		<?php
		$xjys+=$ys;
		$xjysshou+=$yshou;
		$xjqs+=($ys-$yshou);
		$xjzqs+=($ys-$yshou);
			}
 
    ?>
           <tr class="tfoot">
				<th align="center">合计：</th>
				<th align="center"></th>
				<th align="center"><?php echo $xjys;?></th>
				<th align="center"><?php echo $xjysshou;?></th>
				<th align="center"><?php echo $xjqs;?></th>
				<th align="center"><?php echo $xjzqs;?></th>


			</tr>
                  
   </tbody>