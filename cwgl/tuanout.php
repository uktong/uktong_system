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
    $numPerPage=20;
    $pageNum=1;
}
require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));

?>
<script type="text/javascript" src="ajax/js/main.js"></script>
<form id="pagerForm" method="post" action="daiding/index.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="cwgl/tuanout.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				
				<td >
					单位:
				<input type="hidden" name="zts.id" value=""/>
				<input type="text" class="getzts" name="zts.zts" value="" suggestFields="zts"   lookupGroup="zts" />
				<a class="btnLook" style="float: right;" href="ajax/dh/zts.php" lookupGroup="zts">选择组团社</a>
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
				<th align="center">序号</th>
				<th align="center">单位</th>
				<th align="center">标志码</th>
				<th align="center">应付</th>
				<th align="center">已付</th>
				<th align="center">欠付</th>
				<th align="center">付款</th>
			
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"select * from t_travel" );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_travel order by id DESC limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			  
			 }else {
			     $sql="";
			     $sql.=$_POST["zts_id"]!=""?" and id='".$_POST["zts_id"]."'":"";
			     $result=mysqli_query($con,"select * from t_travel where 1=1 ".$sql );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_travel where 1=1 ".$sql." limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			    
			 
			for($a=0;$a<count($resultnowarray);$a++){
			  
			    //查询项目表
			    //获取团号
// 			    echo $resultnowarray[$a]['travel_name'];
			    $teamnumsql=mysqli_query($con, "select teamNumber from t_groupmanage where groupName='".$resultnowarray[$a]['id']."'");
			    $teamnum=mysqli_fetch_all($teamnumsql,MYSQLI_ASSOC);
			    //根据团号取付款表数据
			    //取应付
			    $yingfu=0;
			    $yifu=0;
			    $qianfu=0;
			    for($t=0;$t<count($teamnum);$t++){
    			    $_plansql=mysqli_query($con, "select * from t_reserveplan where groupNumber='".$teamnum[$t]['teamNumber']."'");
    			    $plan=mysqli_fetch_all($_plansql,MYSQLI_ASSOC);
        			    for($q=0;$q<count($plan);$q++){
        			        $yingfu+=$plan[$q]["sumPrice"];
        			    }
        			    $zmsql=mysqli_query($con, "select * from t_collectionunit where groupNumber='".$teamnum[$t]['teamNumber']."'");
    			    $zm=mysqli_fetch_all($zmsql,MYSQLI_ASSOC);
    			    //test
    			    
    			    
    			        for($w=0;$w<count($zm);$w++){
    			            $yifu+=$zm[$w]["amount"];
    			        }
    			    
    			    $qianfu=$yingfu-$yifu;
			    
			    }
			    ?>
<tr  >
			<td ><?php echo ($a+1);  ?>
			</td><td ><?php echo $resultnowarray[$a]['travel_name'];?>
            </td><td ><?php echo $resultnowarray[$a]['travel_code'];?>

			</td><td  ><?php echo $yingfu;?>
</td><td  ><?php echo $yifu; ?>
</td><td  ><?php echo $qianfu;?>

			</td><td  >
			<a href='cwgl/dotuanout.php?id=<?php echo $resultnowarray[$a]['id'];?>' class='show' id='' target='navtab' title='收款<?php echo $resultnowarray[$a]['id'];?>' style='color:blue;'>收款</a>
		</td>
		</tr>
		<?php 	}
 
    ?>
		</tbody>
	</table>
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