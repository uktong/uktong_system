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
// echo date("Y-m-d",strtotime("  +0 day"));
if(isset($_GET["action"])){
    if($_GET["action"]=="charu"){
//         print_r($_POST["had"]);
        $roomt=$_POST["roomtype"];
        $checkhadsql=mysqli_query($con, "select * from t_roomstate where hotel='".$_SESSION['hotelid']."' and roomtype='".$roomt."'");
//         echo "select * from t_roomstate where hotel='".$_SESSION['hotelid']."' and roomtype='".$roomt."'";
        $checkhad=mysqli_fetch_all($checkhadsql, MYSQLI_ASSOC);
        $sql="";
        if(count($checkhad)==0){
        foreach ($_POST["had"] as $a=>$had){
            $date=date("Y-m-d",strtotime("  +".$a." day"));
           // echo $had!=""?date("Y-m-d",strtotime("  +".$a." day"))." jiage".$had:"";
            if($had!=""){
                $sql.=",( '".$_SESSION['hotelid']."','".$date."','".$had."',0,now(),'".$_SESSION['userid']."','".$roomt."')";
            }
            
        }
        if($sql!=""){
            $sqli=substr($sql,1);
            mysqli_query($con, "insert into t_roomstate(hotel,date,had,rhaving,updatedate,updateuser,roomtype)values ".$sqli);
        }
       
        echo "<script>alert('添加成功！请继续操作！');</script>";
        }else {
            echo "<script>alert('已存在相同类型房态！请直接修改');</script>";
        }
    }
    
    if($_GET["action"]=="edit"){
        $rt=$_GET["rt"];
        $sql="";
        foreach ($_POST["had"] as $a=>$had){
            $date=date("Y-m-d",strtotime("  +".$a." day"));
            // echo $had!=""?date("Y-m-d",strtotime("  +".$a." day"))." jiage".$had:"";
            $ifhad=mysqli_query($con, "select * from t_roomstate where roomtype='".$rt."' and date='".$date."' and hotel=".$_SESSION["hotelid"]);
            $hadroom=mysqli_fetch_array($ifhad);
           if(mysqli_num_rows($ifhad)!=0){
               mysqli_query($con, "update t_roomstate set had='".$had."' where roomtype='".$rt."' and date='".$date."' and hotel=".$_SESSION["hotelid"]);
               
           }else{
         
                if($had!=""){
                    $sql.=",('".$_SESSION['hotelid']."','".$date."','".$had."',0,now(),'".$_SESSION['userid']."','".$rt."')";
                }
        }
        if($sql!=""){
            $sqli=substr($sql,1);
            mysqli_query($con, "insert into t_roomstate(hotel,date,had,rhaving,updatedate,updateuser,roomtype)values ".$sqli);
        }
        
        }
        echo "<script>alert('修改成功！请继续操作！');</script>";
    }
}
?>
<script type="text/javascript" src="ajax/js/main.js"></script>


<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="zyzx/addft.php?hotel=<?php echo $_SESSION["hotelid"];?>" target="dialog" width="340" height="620" rel="addft" mask="true"><span>添加</span></a></li>
<!-- 			<li class="line">line</li> -->
<!-- 			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li> -->
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">房间类型</th>
				<th align="center"><?php echo  date("Y-m-d");?></th>
				<th align="center"><?php echo  date("Y-m-d",strtotime(" +1 day"));?></th>
				<th align="center"><?php echo  date("Y-m-d",strtotime(" +2 day"));?></th>
				<th align="center"><?php echo  date("Y-m-d",strtotime(" +3 day"));?></th>
				<th align="center"><?php echo  date("Y-m-d",strtotime(" +4 day"));?></th>
				<th align="center"><?php echo  date("Y-m-d",strtotime(" +5 day"));?></th>
				<th align="center" ><?php echo  date("Y-m-d",strtotime(" +6 day"));?></th>
				<th align="center" ><?php echo  date("Y-m-d",strtotime(" +7 day"));?></th>
				<th align="center" ><?php echo  date("Y-m-d",strtotime(" +8 day"));?></th>
				<th align="center" ><?php echo  date("Y-m-d",strtotime(" +9 day"));?></th>
				<th align="center" ><?php echo  date("Y-m-d",strtotime(" +10 day"));?></th>
				<th align="center" ><?php echo  date("Y-m-d",strtotime(" +11 day"));?></th>
				<th align="center" ><?php echo  date("Y-m-d",strtotime(" +12 day"));?></th>
				<th align="center" ><?php echo  date("Y-m-d",strtotime(" +13 day"));?></th>
			<th align="center">操作</th>
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			         $resultnow=mysqli_query($con,"select distinct roomtype from t_roomstate where hotel=".$_SESSION["hotelid"]  );
			         $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			for($a=0;$a<count($resultnowarray);$a++){
			    
			    
			    //查询项目表
			    
			    ?>
<tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php 
			$roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$resultnowarray[$a]["roomtype"]);
			$roomtype=mysqli_fetch_array($roomtypesql);
			echo $roomtype["basetype"];
			?>
           
           </td><td  ><?php 
			
			$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d")."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
			$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
			echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";
         ?>
			</td><td  ><?php 
			
			$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +1 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
			$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
			echo count($date)==0?"无当日房态":$date["had"]-$date["rhaving"]."（剩余）<br>";
         ?>
		
</td><td  >
<?php 
$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +2 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";       ?>

</td><td  >
<?php 
$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +3 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";
         ?>
</td><td  >
<?php 
$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +4 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";         ?>

</td><td  >

<?php 
$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +5 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";         ?>
			</td><td  >
			<?php 
			$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +6 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
			$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
			echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";         ?>
		</td>
		<td  >
			<?php 
			$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +7 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
			$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
			echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";         ?>
		</td>
		<td  >
			<?php 
			$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +8 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
			$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
			echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";         ?>
		</td>
		<td  >
			<?php 
			$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +9 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
			$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
			echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";         ?>
		</td>
		<td  >
			<?php 
			$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +10 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
			$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
			echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";         ?>
		</td>
		<td  >
			<?php 
			$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +11 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
			$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
			echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";         ?>
		</td>
		<td  >
			<?php 
			$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +12 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
			$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
			echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";         ?>
		</td>
		<td  >
			<?php 
			$datesql=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +13 day"))."' and roomtype='".$resultnowarray[$a]["roomtype"]."' and hotel=".$_SESSION["hotelid"]);
			$date=mysqli_fetch_array($datesql,MYSQLI_ASSOC);
			echo count($date)==0?"无当日房态":($date["had"]-$date["rhaving"])."（剩余）<br>";         ?>
		</td>
		<td><a class="btnEdit"  href="zyzx/editft.php?rt=<?php echo $resultnowarray[$a]["roomtype"];?>" target="dialog" width="340" height="620" rel="editft" mask="true"><span>修改</span></a></td>
		
		</tr>
		<?php 	}
 
    ?>
		</tbody>
	</table>
	
</div>