<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
if(@$_POST["numPerPage"]!=null){
    $numPerPage=$_POST["numPerPage"];
    //      $keywords=$_POST["keywords"];
    $pageNum=$_POST["pageNum"];
    //     $status=$_POST["status"];
    //     $orderField=$_POST["orderField"];
    
}else{
    $numPerPage=50;
    $pageNum=1;
}

require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
?>
<script type="text/javascript" src="ajax/js/main.js"></script>
<form id="pagerForm" method="post" action=cxtj/mrsztj.php>
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="cxtj/mrsztj.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				<td class="dateRange">
					日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
				<td><button type="submit">搜索</button></td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">

	</div>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">日期</th>
				<th align="center">收入</th>
				<th align="center" >支出</th>
				<th align="center">本期结余</th>

			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"
select distinct dater from t_collectionunit where dater between '".$firstday."' and '".$lastday."'
union
 select distinct createTime from t_hoteldebt where createTime between '".$firstday."' and '".$lastday."'
union
 select distinct creattime from t_officeaccount where creattime between '".$firstday."' and '".$lastday."'
 order by dater 
" );
			     //echo "select * from t_groupmanage where updateDate between '".$firstday."' and '".$firstday."'";
			     @$resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			    
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"
select distinct dater from t_collectionunit where dater between '".$firstday."' and '".$lastday."'
union
 select distinct createTime from t_hoteldebt where createTime between '".$firstday."' and '".$lastday."'
union
 select distinct creattime from t_officeaccount where creattime between '".$firstday."' and '".$lastday."'
 order by dater 
 limit ".$sr.",".$numPerPage  );
			    @ $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			     
			     $qqsr=0;
			     $qqsrsql=mysqli_query($con, "
select sum(a.money) as money from (select sum(fee) as money from t_hoteldebt where createTime<'".$firstday."'
 union select sum(borrowMoney) from t_officeaccount where creattime<'".$firstday."') as a
");
			     $qqzc=0;
			     $qqzcsql=mysqli_query($con, "
select sum(a.money) as money from (select sum(amount) as money from t_collectionunit where dater<'".$firstday."'
 union select sum(loanMoney) from t_officeaccount where creattime<'".$firstday."') as a
");
			     
			 }else {
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         
			     }

			     $result=mysqli_query($con,"
select distinct dater from t_collectionunit where dater between '".$startdate."' and '".$enddate."'
union
 select distinct createTime from t_hoteldebt where createTime between '".$startdate."' and '".$enddate."'
union
 select distinct creattime from t_officeaccount where creattime between '".$startdate."' and '".$enddate."'
 " );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     
			    
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"
select distinct dater from t_collectionunit where dater between '".$startdate."' and '".$enddate."'
union
 select distinct createTime from t_hoteldebt where createTime between '".$startdate."' and '".$enddate."'
union
 select distinct creattime from t_officeaccount where creattime between '".$startdate."' and '".$enddate."'
 order by dater  limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			     
			     $qqsr=0;
			     $qqsrsql=mysqli_query($con, "
select sum(a.money) as money from (select sum(fee) as money from t_hoteldebt where createTime<'".$startdate."'
 union select sum(borrowMoney) from t_officeaccount where creattime<'".$enddate."') as a
");
			     $qqzc=0;
			     $qqzcsql=mysqli_query($con, "
select sum(a.money) as money from (select sum(amount) as money from t_collectionunit where dater<'".$startdate."'
 union select sum(loanMoney) from t_officeaccount where creattime<'".$enddate."') as a
");
			     
			 }

			     $xjsr=0;
			     $xjzc=0;
			     $xjjy=0;
			     
			     
		     
			    @$qqsrje=mysqli_fetch_array($qqsrsql);
			     $qqsr+= $qqsrje["money"];
			    
			     
			     

			     
			     $qqzcje=mysqli_fetch_array($qqzcsql);
			     $qqzc+= $qqzcje["money"];
			     
			     
			     ?>
			     <tr>
				<td align="center">1</td>
			<td align="center">前期结转</td>
<td align="center"><?php  echo $qqsr;?></td>
<td align="center"><?php  echo  $qqzc;?></td>
<td align="center"><?php echo $qqsr-$qqzc;?></td>
			</tr>
			     
			     <?php
			for($a=0;$a<count($resultnowarray);$a++){
			    ?>
			    <tr  >
			<td  >
			<?php echo $a+2;?>
			</td>
			<td  ><?php 
			echo $resultnowarray[$a]['dater'];
			?>
			</td>

			<td  ><?php 
			$sr=0;
			$srsql=mysqli_query($con, "
select sum(a.money) as money from (select sum(fee) as money from t_hoteldebt where createTime='".$resultnowarray[$a]['dater']."'
 union select sum(borrowMoney) from t_officeaccount where creattime='".$resultnowarray[$a]['dater']."') as a 
");
		
			$srje=mysqli_fetch_array($srsql);
			$sr+= $srje["money"];
			echo $sr;
			?>
			</td>
			<td  >
			<?php 
			$zc=0;
			$zcsql=mysqli_query($con, "
select sum(a.money) as money from (select sum(amount) as money from t_collectionunit where dater='".$resultnowarray[$a]['dater']."'
 union select sum(loanMoney) from t_officeaccount where creattime='".$resultnowarray[$a]['dater']."') as a 
");
		
			$zcje=mysqli_fetch_array($zcsql);
			$zc+= $zcje["money"];
			echo $zc;
			?>
			</td>
			<td  >
			<?php 
			echo $sr-$zc;
			?>
			</td>

			</tr>
		<?php
		$xjsr+=$sr;
		$xjzc+=$zc;
		$xjjy+=$sr-$zc;
		
			}
 
    ?>
	    <tr class="tfoot">
				<th align="center"></th>
				<th align="center"></th>
<th align="center"><?php echo $xjsr+$qqsr;?></th>
<th align="center"><?php echo $xjzc+$qqzc;?></th>
<th align="center"><?php echo $xjjy+$qqsr-$qqzc;?></th>


			</tr>

	    </tbody>
	</table>
	<style>
	.tfoot{
		height:30px;
		line-height:30px;
		background-color:#eef3ff;
		
	}
	.tfoot:hover{
		background-color:#eef3ff;
	}</style>
		<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
		
				<option value="20" <?php if($numPerPage==20){echo "selected='selected'";}?>>20</option>
				<option value="50"<?php if($numPerPage==50){echo "selected='selected'";}?>>50</option>
				<option value="100"<?php if($numPerPage==100){echo "selected='selected'";}?>>100</option>
				<option value="150"<?php if($numPerPage==150){echo "selected='selected'";}?>>150</option>
				<option value="200"<?php if($numPerPage==200){echo "selected='selected'";}?>>200</option>
				<option value="250"<?php if($numPerPage==250){echo "selected='selected'";}?>>250</option>
			</select>
			<span>条，共<?php echo count($resultarray); ?>条</span>
		</div>

		<div class="pagination" targetType="navTab" totalCount="<?php echo count($resultarray); ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
</div>