<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">发团</th>
				<th align="center">散团</th>
				<th align="center">预定日期</th>
				<th align="center">代定项目</th>
				<th align="center">计调	</th>
				
				<th align="center">组团社</th>
				<th align="center" width="120">备注</th>

				<th align="center">总收入</th>
				<th align="center">总成本</th>
				<th align="center">毛利</th>
				<th align="center">毛利率</th>
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 

			 $shouru=0;
			 $chengben=0;
			 $maoli=0;
			 $shouruz=0;
			 $chengbenz=0;
			 $maoliz=0;
			 
			     $sql="";
			     if($_GET["startDate"]!=""){
			         $startdate=$_GET["startDate"];
			         $enddate=$_GET["endDate"]!=""?$_GET["endDate"]:date("Y-m-d",time());
			         $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_GET["zts_id"]!=""?" and groupName='".$_GET["zts_id"]."'":"";
			     //$sql.=$_POST["jdian222_id"]!=""?" and hotelName='".$_POST["jdian222_id"]."'":"";
			     $sql.=$_GET["jd_id"]!=""?" and jd='".$_GET["jd_id"]."'":"";
			     $sql.=$_GET["groupnum"]!=""?" and teamNumber like '%".$_GET["groupnum"]."%'":"";
			     $result=mysqli_query($con,"select * from t_groupmanage  where 1=1 ".$sql );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     
			     for($z=0;$z<count($resultarray);$z++){
			         $allmoneysqlz=mysqli_query($con, "select * from t_reserveplan where groupNumber='".$resultarray[$z]["teamNumber"]."'");
			         $allmoneyz=mysqli_fetch_all($allmoneysqlz,MYSQLI_ASSOC);
			         $zsr=0;
			         $zcb=0;
			         for($am=0;$am<count($allmoneyz);$am++){
			             $zsr+=$allmoneyz[$am]["sumPrice"];
			             $zcb+=$allmoneyz[$am]["hotelCommissionSum"];
			         }
			         $shouruz+=$zsr;
			         $chengbenz+=$zcb;
			         $maoliz=$shouruz-$chengbenz;
			     }
			     $resultnum=count($resultarray);
			     $resultnow=mysqli_query($con,"select * from t_groupmanage  where 1=1 ".$sql." order by id DESC ");
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 
			 
			
			for($a=0;$a<count($resultnowarray);$a++){
			   
			    $jdid=$resultnowarray[$a]['jd'];
			    $jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
			    $jd=mysqli_fetch_array($jdsql);
			    $ztsid=$resultnowarray[$a]['groupName'];
			    $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			    $zts=mysqli_fetch_array($ztssql); 
			    ?>
<tr  >
			<td align="center"><?php echo $a+1;?>
			</td>
			<td align="center"><?php echo $resultnowarray[$a]["teamNumber"];?>
			</td>
			<td align="center"><?php echo $resultnowarray[$a]["startDate"];?>
			</td>
			<td align="center"><?php echo $resultnowarray[$a]["endDate"];?>
			</td>
			<td align="center"><?php echo $resultnowarray[$a]["reserveDate"];?>
			</td>
			<td align="center">	
代订酒店
			</td>
			<td align="center"><?php echo $jd["username"];?>
			</td>
			<td align="center"><?php echo $zts["travel_name"];?>
			</td>
			<td align="center"><?php echo $resultnowarray[$a]["remark"];?>
			</td>
			<td align="center"><?php 
			$allmoneysql=mysqli_query($con, "select * from t_reserveplan where groupNumber='".$resultnowarray[$a]["teamNumber"]."'");
			$allmoney=mysqli_fetch_all($allmoneysql,MYSQLI_ASSOC);
			$sr=0;
			$cb=0;
			for($am=0;$am<count($allmoney);$am++){
			    $sr+=$allmoney[$am]["sumPrice"];
			    $cb+=$allmoney[$am]["hotelCommissionSum"];
			}
			echo $sr;
			?>
			</td>
			<td align="center"><?php echo $cb;?>
			</td>
			<td align="center"><?php echo $sr-$cb;?>
			</td>
			<td align="center"><?php 
			echo $sr!=0?sprintf("%.2f", floatval(($sr-$cb)/$sr)*100):"0";
		?>%
			</td>
		
			</tr>
		
		<?php 	
			$shouru+=$sr;
			$chengben+=$cb;
			$maoli+=$sr-$cb;;
			
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
				<th align="center"><?php echo $shouruz;?></th>
				<th align="center"><?php echo $chengbenz;?></th>
				<th align="center"><?php echo $maoliz;?></th>
				<th align="center"></th>


			</tr>