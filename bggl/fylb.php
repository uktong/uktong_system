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
<form id="pagerForm" method="post" onsubmit="return divSearch(this, 'bgfybox');" action="bggl/fylb.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="cwgl/tuanin.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				
				<td class="dateRange">
					时间选择:<input type="text" name="creattime" value="<?php 
			date_default_timezone_set('prc');
			echo date("Y-m",time());?>" class="date" datefmt="yyyy-MM" size="30" style="width: 152px;height:21px;" readonly /><button type="submit">检索</button>
				</td>
			</tr>
		</table>
	</div>
	</form>
</div>
<div class="pageContent">
<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="bggl/addbgfy.php" target="dialog" mask="true" title="录入办公费用" width="600" height="310"><span>添加</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">经办日期</th>
				<th align="center">科目</th>
				<th align="center">摘要</th>
				<th align="center">借（收）方金额</th>
				<th align="center">贷（支）方金额</th>
				<th align="center">经办人</th>
				<th align="center">操作日期</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 $kmid=$_GET["km"];
			 $result=mysqli_query($con,"select * from t_officeaccount where subjectType_id=".$kmid );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_officeaccount where subjectType_id=".$kmid." order by id DESC limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
		
			$jie=0;
			$dai=0;
			$jieh=0;
			$daih=0;
			for($h=0;$h<count($resultarray);$h++){
			    $jieh+=$resultarray[$h]['borrowMoney'];
			    $daih+=$resultarray[$h]['loanMoney'];
			}
			
			for($a=0;$a<count($resultnowarray);$a++){
			   
			    
			    //查询项目表
			   
			    ?>
<tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php echo $resultnowarray[$a]['handleDate'];?>
            </td><td ><?php 
            $kmsql=mysqli_query($con, "select subjectName from t_subjectset where id=".$resultnowarray[$a]['subjectType_id']);
            $km=mysqli_fetch_array($kmsql);
            echo $km["subjectName"];
            ?>
			</td><td  ><?php echo $resultnowarray[$a]['digest'];?>
			</td><td  ><?php echo $resultnowarray[$a]['borrowMoney'];?>
			</td><td  ><?php echo $resultnowarray[$a]['loanMoney'];?>
</td><td  ><?php 
$operatorsql=mysqli_query($con, "select realName from t_user where id=".$resultnowarray[$a]['operator']);
$operator=mysqli_fetch_array($operatorsql);
echo $operator["realName"];
?>
</td><td  ><?php echo $resultnowarray[$a]['creattime'];?>
			</td><td  >
			<a href='bggl/showbgfy.php?id=<?php echo $resultnowarray[$a]['id'];?>' class='show' id='' target='dialog' title='查看信息' style='color:blue;'>查看</a>
		<?php 	
		$jie+=$resultnowarray[$a]['borrowMoney'];
		$dai+=$resultnowarray[$a]['loanMoney'];
			}
 
    ?>

   
    <tr class="tfoot">
				<th align="center">小计：</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $jie;?></th>
				<th align="center"><?php echo $dai;?></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
			</tr>
			
			<tr class="tfoot">
				<th align="center">合计：</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $jieh;?></th>
				<th align="center"><?php echo $daih;?></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
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
	}
	</style>
		<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value},'bgfybox')">
		
				<option value="20" <?php if($numPerPage==20){echo "selected='selected'";}?>>20</option>
				<option value="50"<?php if($numPerPage==50){echo "selected='selected'";}?>>50</option>
				<option value="100"<?php if($numPerPage==100){echo "selected='selected'";}?>>100</option>
				<option value="150"<?php if($numPerPage==150){echo "selected='selected'";}?>>150</option>
				<option value="200"<?php if($numPerPage==200){echo "selected='selected'";}?>>200</option>
				<option value="250"<?php if($numPerPage==250){echo "selected='selected'";}?>>250</option>
			</select>
			<span>条，共<?php echo count($resultarray); ?>条</span>
		</div>

		<div class="pagination" targetType="bgfybox" totalCount="<?php echo count($resultarray); ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
</div>