<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));

$sumys=0;
$sumss=0;
$sumyf=0;
$sumsf=0;
$bgys=0;
$bgyf=0;
if(@$_POST["search"]==null){
   
    $shouldinsql=mysqli_query($con, "select teamNumber from t_groupmanage where updateDate between '".$firstday."' and '".$lastday."'");
    $shouldin=mysqli_fetch_all($shouldinsql,MYSQLI_ASSOC);
    $teamnumsql=mysqli_query($con, "select distinct groupNumber from t_collectionunit  ");
    $teamnum=mysqli_fetch_all($teamnumsql,MYSQLI_ASSOC);
    $teamnumoutsql=mysqli_query($con, "select  groupNumber from t_reserveplan");
    $teamnumout=mysqli_fetch_all($teamnumoutsql,MYSQLI_ASSOC);
    
    $shouldoutsql=mysqli_query($con, "select sum(hotelCommissionSum) as money from t_reserveplan");
    $shouldout=mysqli_fetch_array($shouldoutsql,MYSQLI_ASSOC);
    $sumyf=$shouldout["money"];
    // for($c=0;$c<count($teamnumout);$c++){
    $yfsql=mysqli_query($con, "select sum(fee) as money from t_hoteldebt ");
    @$yf=mysqli_fetch_array($yfsql);
    $sumsf=$yf["money"];
    // }
    $yfbumsql=mysqli_query($con, "select id from t_hoteldebt");
    @$yfbum=mysqli_fetch_all($yfbumsql,MYSQLI_ASSOC);
    //办公费用
    
    $bgyssql=mysqli_query($con, "select borrowMoney from t_officeaccount where borrowMoney!=0");
    $bgysresult=mysqli_fetch_all($bgyssql,MYSQLI_ASSOC);
    $bgyfsql=mysqli_query($con, "select loanMoney from t_officeaccount where loanMoney!=0");
    $bgyfresult=mysqli_fetch_all($bgyfsql,MYSQLI_ASSOC);
    
}else {
    $sql="";
    if($_POST["startDate"]!=""){
        $startdate=$_POST["startDate"];
        $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
        $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
        $sqlq=" and dater between '".$startdate."' and '".$enddate."'";
        $sqlw=" and createTime between '".$startdate."' and '".$enddate."'";
        $sqle=" and creattime between '".$startdate."' and '".$enddate."'";
    }
    
    // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
    $shouldinsql=mysqli_query($con, "select teamNumber from t_groupmanage where 1=1 ".$sql);
    $shouldin=mysqli_fetch_all($shouldinsql,MYSQLI_ASSOC);
    
    $teamnumsql=mysqli_query($con, "select distinct groupNumber from t_collectionunit  where 1=1 ".$sqlq);
    $teamnum=mysqli_fetch_all($teamnumsql,MYSQLI_ASSOC);
    $teamnumoutsql=mysqli_query($con, "select  groupNumber from t_reserveplan where 1=1 ".$sql);
    $teamnumout=mysqli_fetch_all($teamnumoutsql,MYSQLI_ASSOC);
    
    $shouldoutsql=mysqli_query($con, "select sum(hotelCommissionSum) as money from t_reserveplan where 1=1 ".$sql);
    $shouldout=mysqli_fetch_array($shouldoutsql,MYSQLI_ASSOC);
    $sumyf=$shouldout["money"];
    // for($c=0;$c<count($teamnumout);$c++){
    $yfsql=mysqli_query($con, "select sum(fee) as money from t_hoteldebt where 1=1 ".$sqlw);
    $yf=mysqli_fetch_array($yfsql);
    $sumsf=$yf["money"];
    // }
    $yfbumsql=mysqli_query($con, "select id from t_hoteldebt where 1=1 ".$sqlw);
    $yfbum=mysqli_fetch_all($yfbumsql,MYSQLI_ASSOC);
    //办公费用
    
    $bgyssql=mysqli_query($con, "select borrowMoney from t_officeaccount where borrowMoney!=0".$sqle);
    $bgysresult=mysqli_fetch_all($bgyssql,MYSQLI_ASSOC);
    $bgyfsql=mysqli_query($con, "select loanMoney from t_officeaccount where loanMoney!=0".$sqle);
    $bgyfresult=mysqli_fetch_all($bgyfsql,MYSQLI_ASSOC);
}
















for($a=0;$a<count($shouldin);$a++){
    $sumPricesql=mysqli_query($con, "select sum(sumPrice) as money from t_reserveplan where groupNumber='".$shouldin[$a]["teamNumber"]."'");
    $sumPrice=mysqli_fetch_array($sumPricesql);
    $sumys+=$sumPrice["money"];
}

for($b=0;$b<count($teamnum);$b++){
    $shishousql=mysqli_query($con, "select sum(amount) as money from t_collectionunit where groupNumber='".$teamnum[$b]["groupNumber"]."'");
    $shishou=mysqli_fetch_array($shishousql);
    $sumss+=$shishou["money"];
}


for($bg=0;$bg<count($bgysresult);$bg++){
    $bgys+=$bgysresult[$bg]["borrowMoney"];
}

for($bg=0;$bg<count($bgyfresult);$bg++){
    $bgyf+=$bgyfresult[$bg]["loanMoney"];
}
?>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="cwgl/countcw.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				<td class="dateRange">
					按日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<div class="subBar">
			<ul>
				<li><div class="button"><div class="buttonContent"><button type="reset">重置</button></div></div></li>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">

	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center" ></th>
				<th align="center" >项目名称</th>
				<th align="center" >
				
				<table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td colspan="2">应收/应付</td></tr>
				<tr><td align="center">笔数</td> <td align="center">金额</td></tr>
				</table></th>
				<th align="center"  >
				<table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;">
				<tr><td colspan="2">实收/实付</td></tr>
				<tr><td align="center">笔数</td> <td align="center">金额</td></tr>
				</table></th>
				<th align="center">未收/未付</th>
			</tr>

				
				

		</thead>
		<tbody>
			
			 <?php 
			  
			    ?>
<tr  >
			<td rowspan="2">收入
			</td><td >团款
</td><td  ><table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td align="center"><?php echo count($shouldin);?></td> <td align="center"><?php echo $sumys;?></td></tr>
				</table>
</td><td  ><table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td align="center"><?php echo count($teamnum);?></td> <td align="center"><?php echo $sumss;?></td></tr>
				</table>
</td><td  ><?php echo $sumss-$sumys;?>
</td>
		<?php 	
 
    ?></tr>
    <tr>
			<td >办公费用
</td><td  ><table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td align="center"><?php echo count($bgysresult);?></td> <td align="center"><?php echo $bgys;?></td></tr>
				</table>
</td><td  ><table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td align="center"><?php echo count($bgysresult);?></td> <td align="center"><?php echo $bgys;?></td></tr>
				</table>
</td><td  >0
</td>
		</tr>
    <tr>
				<th align="center" >小计：</th>
				<th align="center" ></th>
				<th align="center" >
				
				<table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td align="center"></td> <td align="center"><?php echo $sumys+$bgys;?></td></tr>
				</table></th>
				<th align="center"  >
				<table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;">
				<tr><td align="center"></td> <td align="center"><?php echo $sumss+$bgys;?></td></tr>
				</table></th>
				<th align="center"><?php echo $sumss-$sumys;?></th>
			</tr>
			
			<tr> <td colspan="5">&nbsp;</td></tr>
			<tr  >
			<td rowspan="2">支出
			</td><td >房费
</td><td  ><table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td align="center"><?php echo count($teamnumout);?></td> <td align="center"><?php echo $sumyf;?></td></tr>
				</table>
</td><td  ><table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td align="center"><?php echo count($yfbum);?></td> <td align="center"><?php echo $sumsf;?></td></tr>
				</table>
</td><td  ><?php echo $sumyf-$sumsf;?>
</td>
		</tr>
		<tr  >
			<td >办公费用
</td><td  ><table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td align="center"><?php echo count($bgyfresult);?></td> <td align="center"><?php echo $bgyf;?></td></tr>
				</table>
</td><td  ><table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td align="center"><?php echo count($bgyfresult);?></td> <td align="center"><?php echo $bgyf;?></td></tr>
				</table>
</td><td  >0
</td>
		</tr>
    <tr>
				<th align="center" >小计：</th>
				<th align="center" ></th>
				<th align="center" >
				
				<table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td align="center"></td> <td align="center"><?php echo $sumyf+$bgyf;?></td></tr>
				</table></th>
				<th align="center"  >
				<table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;">
				<tr><td align="center"></td> <td align="center"><?php echo $sumsf+$bgyf;?></td></tr>
				</table></th>
				<th align="center"><?php echo $sumyf-$sumsf;?></th>
			</tr>
			<tr>
				<th align="center" >总计：</th>
				<th align="center" ></th>
				<th align="center" >
				
				<table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;" >
				<tr><td align="center"></td> <td align="center"><?php echo $sumys+$bgys-$sumyf-$bgyf;?></td></tr>
				</table></th>
				<th align="center"  >
				<table class="table" width="100%" style="word-break:break-all; word-wrap:break-all;">
				<tr><td align="center"></td> <td align="center"><?php echo $sumss+$bgys-$sumsf-$bgyf;?></td></tr>
				</table></th>
				<th align="center"><?php echo $sumss-$sumys-$sumyf+$sumsf;?></th>
			</tr>
		</tbody>
		
	</table>
		
</div>