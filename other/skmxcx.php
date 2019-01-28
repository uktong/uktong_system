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
			         $sql.=" and dater between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_GET["paytype"]!=""?" and payment='".$_GET["paytype"]."'":"";
			     $sql.=$_GET["zh_id"]!=""?" and account='".$_GET["zh_id"]."'":"";
			     $sql.=$_GET["zts_id"]!=""?" and agent='".$_GET["zts_id"]."'":"";
			     $sql.=$_GET["jd_id"]!=""?" and operator='".$_GET["jd_id"]."'":"";
			     $sql.=$_GET["wl_id"]!=""?" and payee='".$_GET["wl_id"]."'":"";
			     $sql.=$_GET["groupnum"]!=""?" and groupNumber like '%".$_GET["groupnum"]."%'":"";
			     $result=mysqli_query($con,"select * from t_collectionunit where 1=1 ".$sql );
			    //  echo "select * from t_collectionunit where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     for($z=0;$z<count($resultarray);$z++){
			         $jinez+=$resultarray[$z]["amount"];
			     }
			     $resultnum=count($resultarray);
			     $resultnow=mysqli_query($con,"select * from t_collectionunit where 1=1 ".$sql." order by id DESC " );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			for($a=0;$a<count($resultnowarray);$a++){
			    $teamnum=$resultnowarray[$a]['groupNumber'];
			    $gettravelidsql=mysqli_query($con, "select groupName from t_groupmanage where teamNumber='".$teamnum."'");
			    $gettravelid=mysqli_fetch_array($gettravelidsql);

			    $ztsid=$gettravelid['groupName'];
			    $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			    $zts=mysqli_fetch_array($ztssql); 
			    ?>
			    
			    <tr  >
			<td  align="center">
			<?php echo $a+1;?>
			</td>

			<td  align="center"><?php 
			echo $zts['travel_name'];
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
			$getpaysql=mysqli_query($con, "select * from t_paymenttype where id=".$resultnowarray[$a]["payment"]);
			$getpay=mysqli_fetch_array($getpaysql,MYSQLI_ASSOC);
			echo $getpay["paymentname"];
			?>
			</td>
			
			<td  align="center"><?php echo $resultnowarray[$a]["amount"];?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["dater"];?>
			</td>
			<td  align="center"><?php echo $resultnowarray[$a]["remark"];?>
			</td>
			
			</tr>
		<?php

		$jine+=$resultnowarray[$a]["amount"];

			}
		
    ?>
	    
			
			 <tr class="tfoot">
				<th align="center">总计：</th>
				<th align="center"></th>
				<th align="center"></th>

				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $jinez;?></th>
				<th align="center"></th>
				<th align="center"></th>
			</tr>
	    </tbody>