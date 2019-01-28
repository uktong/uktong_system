<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">单位</th>
				<th align="center">账号</th>
				<th align="center">收款人</th>
				<th align="center">收款方式</th>
				<th align="center">收款金额</th>
				<th align="center">日期</th>
				<th align="center">备注</th>

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
			 $yfu=0;
			 $qianfu=0;
			
			     $sql="";
			     if($_GET["startDate"]!=""){
			         $startdate=$_GET["startDate"];
			         $enddate=$_GET["endDate"]!=""?$_GET["endDate"]:date("Y-m-d",time());
			         $sql.=" and createTime between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_GET["paytype"]!=""?" and payType='".$_GET["paytype"]."'":"";
			     $sql.=$_GET["zh_id"]!=""?" and account='".$_GET["zh_id"]."'":"";
			     $sql.=$_GET["jdian333_id"]!=""?" and name='".$_GET["jdian333_id"]."'":"";
			    // $sql.=$_POST["jd_id"]!=""?" and operator='".$_POST["jd_id"]."'":"";
			     $sql.=$_GET["wl_id"]!=""?" and payee='".$_GET["wl_id"]."'":"";
			     $sql.=$_GET["groupnum"]!=""?" and groupnumber like '%".$_GET["groupnum"]."%'":"";
			     $result=mysqli_query($con,"select * from t_hoteldebt  where 1=1 ".$sql." order by id" );
			     //echo "select * from t_hoteldebt  where 1=1 ".$sql." order by id";
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			         $jinez+=$resultarray[$z]["fee"];
			     }
			     $resultnum=count($resultarray);

			     $resultnow=mysqli_query($con,"select * from t_hoteldebt  where 1=1 ".$sql." order by id desc ");
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 
			 
			for($a=0;$a<count($resultnowarray);$a++){
			    $teamnum=$resultnowarray[$a]['groupnumber'];
			    $gettravelidsql=mysqli_query($con, "select groupName from t_groupmanage where teamNumber='".$teamnum."'");
			    $gettravelid=mysqli_fetch_array($gettravelidsql);


			    $jddianid=$resultnowarray[$a]['name'];
			    $jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			    $jddian=mysqli_fetch_array($jddiansql);
			    ?>
			    
			    <tr  >
			<td align="center" >
			<?php echo $a+1;?>
			</td>

			<td  align="center"><?php 
			echo $jddian['hotelname'];
			?>
			</td>
			<td  align="center"><?php 
			$zhsql=mysqli_query($con, "select accountTitle from t_account where id=".$resultnowarray[$a]["account"]);
			$zh=mysqli_fetch_array($zhsql);
			echo $zh['accountTitle'];
			
			?>
			</td>
			
			
			<td  align="center"><?php 
			$skrsql=mysqli_query($con, "select username from t_user where id=".$resultnowarray[$a]["payee"]);
			$skr=mysqli_fetch_array($skrsql);
			echo $skr['username'];
			?>
			
			<td  align="center"><?php
			$getpaysql=mysqli_query($con, "select * from t_paymenttype where id=".$resultnowarray[$a]["payType"]);
			$getpay=mysqli_fetch_array($getpaysql,MYSQLI_ASSOC);
			echo $getpay["paymentname"];
			?>
			</td>
			
			<td  align="center"><?php echo $resultnowarray[$a]["fee"];?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["createTime"];?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["remark"];?>
			</td>
			
			</tr>
		<?php

		$jine+=$resultnowarray[$a]["fee"];

			}
		
    ?>
	   
			
			 <tr class="tfoot">
				<th align="center">合计：</th>
				<th align="center"></th>
				<th align="center"></th>

				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $jinez;?></th>
				<th align="center"></th>
				<th align="center"></th>
			</tr>
	    </tbody>