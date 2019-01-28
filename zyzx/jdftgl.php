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
$yestday = date("Y-m-d",strtotime("  -1 day"));
?>
<script type="text/javascript" src="ajax/js/main.js"></script>


<form id="pagerForm" method="post" action="zyzx/jdft.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="zyzx/jdft.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				
				
				<td >
					酒店:
			<input type="hidden" name="jdian333.id" value=""/>
				<input type="text" class="getjdian333" oninput="getjdian(333);" name="jdian333.jdian333" value="" suggestFields="jdian333"   lookupGroup="jdian333" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jdian.php?id=333" lookupGroup="jdian333">选择酒店</a>
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
				<th align="center"><?php echo  date("Y-m-d");?></th>
				<th align="center"><?php echo  date("Y-m-d",strtotime(" +1 day"));?></th>
				<th align="center"><?php echo  date("Y-m-d",strtotime(" +2 day"));?></th>
				<th align="center"><?php echo  date("Y-m-d",strtotime(" +3 day"));?></th>
				<th align="center"><?php echo  date("Y-m-d",strtotime(" +4 day"));?></th>
				<th align="center"><?php echo  date("Y-m-d",strtotime(" +5 day"));?></th>
				<th align="center" ><?php echo  date("Y-m-d",strtotime(" +6 day"));?></th>
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			
			     if(@$_POST["search"]==null){
			         $result=mysqli_query($con,"select distinct hotel from t_roomstate where date > '".$yestday."'" );
			         //echo "select * from t_groupmanage where updateDate between '".$firstday."' and '".$firstday."'";
			         $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			         //分页显示
			         $resultnum=count($resultarray);
			         @$page=ceil($resultnum/$numPerPage);
			         @$sr=($pageNum-1)*$numPerPage;
			         $resultnow=mysqli_query($con,"select distinct hotel from t_roomstate where date > '".$yestday."'  limit ".$sr.",".$numPerPage  );
			         $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			     }else {
			         $sql="";
			         
			         $sql.=$_POST["jdian333_id"]!=""?" and hotel = '".$_POST["jdian333_id"]."'":"";
			         $result=mysqli_query($con,"select distinct hotel from t_roomstate where date > '".$yestday."' ".$sql );
			         // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			         $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			         //分页显示
			         $resultnum=count($resultarray);
			         @$page=ceil($resultnum/$numPerPage);
			         @$sr=($pageNum-1)*$numPerPage;
			         $resultnow=mysqli_query($con,"select distinct hotel from t_roomstate where date > '".$yestday."' ".$sql." limit ".$sr.",".$numPerPage );
			         $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			     }
			for($a=0;$a<count($resultnowarray);$a++){
			    
			    
			    //查询项目表
			    
			    ?>
<tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php 
			$jddianid=$resultnowarray[$a]['hotel'];
			$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			$jddian=mysqli_fetch_array($jddiansql);
			echo $jddian["hotelname"];
			?>
            </td><td ><?php 
            $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid);
//             echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
            $datea=mysqli_fetch_all($datesqla,MYSQLI_ASSOC);
            for($b=0;$b<count($datea);$b++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$datea[$b]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                echo $roomtype["basetype"]."：".$datea[$b]["had"]."（可售）/".$datea[$b]["rhaving"]."（剩余）<br>";
            }
            if(count($datea)==0){
                echo "未查询到当日房态";
            }
   
         ?>
			</td><td  ><?php 
			$datesqlb=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +1 day"))."' and hotel=".$jddianid);
//             echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
			$dateb=mysqli_fetch_all($datesqlb,MYSQLI_ASSOC);
			for($c=0;$c<count($dateb);$c++){
			    $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$dateb[$c]["roomtype"]);
			    $roomtype=mysqli_fetch_array($roomtypesql);
			    echo $roomtype["basetype"]."：".$dateb[$c]["had"]."（可售）/".$dateb[$c]["rhaving"]."（剩余）<br>";
            }
            if(count($dateb)==0){
                echo "未查询到当日房态";
            }
         ?>
		
</td><td  >
<?php 
			$datesqlc=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +2 day"))."' and hotel=".$jddianid);
//             echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
			$datec=mysqli_fetch_all($datesqlc,MYSQLI_ASSOC);
			for($c=0;$c<count($datec);$c++){
			    $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$datec[$c]["roomtype"]);
			    $roomtype=mysqli_fetch_array($roomtypesql);
			    echo $roomtype["basetype"]."：".$datec[$c]["had"]."（可售）/".$datec[$c]["rhaving"]."（剩余）<br>";
            }
            if(count($datec)==0){
                echo "未查询到当日房态";
            }
         ?>

</td><td  >
<?php 
			$datesqld=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +3 day"))."' and hotel=".$jddianid);
//             echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
			$dated=mysqli_fetch_all($datesqld,MYSQLI_ASSOC);
			for($c=0;$c<count($dated);$c++){
			    $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$dated[$c]["roomtype"]);
			    $roomtype=mysqli_fetch_array($roomtypesql);
			    echo $roomtype["basetype"]."：".$dated[$c]["had"]."（可售）/".$dated[$c]["rhaving"]."（剩余）<br>";
            }
            if(count($dated)==0){
                echo "未查询到当日房态";
            }
         ?>
</td><td  >
<?php 
			$datesqle=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +4 day"))."' and hotel=".$jddianid);
//             echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
			$datee=mysqli_fetch_all($datesqle,MYSQLI_ASSOC);
			for($c=0;$c<count($datee);$c++){
			    $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$datee[$c]["roomtype"]);
			    $roomtype=mysqli_fetch_array($roomtypesql);
			    echo $roomtype["basetype"]."：".$datee[$c]["had"]."（可售）/".$datee[$c]["rhaving"]."（剩余）<br>";
            }
            if(count($datee)==0){
                echo "未查询到当日房态";
            }
         ?>

</td><td  >

<?php 
			$datesqlf=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +5 day"))."' and hotel=".$jddianid);
//             echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
			$datef=mysqli_fetch_all($datesqlf,MYSQLI_ASSOC);
			for($c=0;$c<count($datef);$c++){
			    $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$datef[$c]["roomtype"]);
			    $roomtype=mysqli_fetch_array($roomtypesql);
			    echo $roomtype["basetype"]."：".$datef[$c]["had"]."（可售）/".$datef[$c]["rhaving"]."（剩余）<br>";
            }
            if(count($datef)==0){
                echo "未查询到当日房态";
            }
         ?>
			</td><td  >
			<?php 
			$datesqlg=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +6 day"))."' and hotel=".$jddianid);
//             echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
			$dateg=mysqli_fetch_all($datesqlg,MYSQLI_ASSOC);
			for($c=0;$c<count($dateg);$c++){
			    $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$dateg[$c]["roomtype"]);
			    $roomtype=mysqli_fetch_array($roomtypesql);
			    echo $roomtype["basetype"]."：".$dateg[$c]["had"]."（可售）/".$dateg[$c]["rhaving"]."（剩余）<br>";
            }
            if(count($dateg)==0){
                echo "未查询到当日房态";
            }
         ?>
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