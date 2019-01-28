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
if(isset($_GET["action"])){
    if($_GET["action"]=="charu"){
        //         print_r($_POST["had"]);
        $roomt=$_POST["roomtype"];
        $hotel=$_POST["jdian134_id"];
        $checkhadsql=mysqli_query($con, "select * from t_roomstate where hotel='".$hotel."' and roomtype='".$roomt."'");
//         echo "select * from t_roomstate where hotel='".$hotel."' and roomtype='".$roomt."'";
        $checkhad=mysqli_fetch_all($checkhadsql, MYSQLI_ASSOC);
        $sql="";
        if(count($checkhad)==0){
            foreach ($_POST["had"] as $a=>$had){
                $date=date("Y-m-d",strtotime("  +".$a." day"));
                // echo $had!=""?date("Y-m-d",strtotime("  +".$a." day"))." jiage".$had:"";
                if($had!=""){
                    $sql.=",( '".$hotel."','".$date."','".$had."',0,now(),'".$_SESSION['userid']."','".$roomt."')";
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
        $rt=$_POST["roomtype"];
        $id=$_GET["id"];
        $sql="";
        foreach ($_POST["had"] as $a=>$had){
            $date=date("Y-m-d",strtotime("  +".$a." day"));
            // echo $had!=""?date("Y-m-d",strtotime("  +".$a." day"))." jiage".$had:"";
            $ifhad=mysqli_query($con, "select * from t_roomstate where roomtype='".$rt."' and date='".$date."' and hotel=".$id);
            $hadroom=mysqli_fetch_array($ifhad);
            if(mysqli_num_rows($ifhad)!=0){
//                 if($hadroom["had"]==0){
                    
//                 }else{
                mysqli_query($con, "update t_roomstate set had='".$had."' where roomtype='".$rt."' and date='".$date."' and hotel=".$id);
//                 }
            }else{
            
                    if($had!=""){
                        $sql.=",('".$id."','".$date."','".$had."',0,now(),'".$_SESSION['userid']."','".$rt."')";
                    }
            }
        }
        if($sql!=""){
            $sqli=substr($sql,1);
            mysqli_query($con, "insert into t_roomstate(hotel,date,had,rhaving,updatedate,updateuser,roomtype)values ".$sqli);
        }
        echo "<script>alert('修改成功！请继续操作！');</script>";
    }
}
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
<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="zyzx/addallft.php" target="dialog" width="340" height="650" rel="addallft" mask="true"><span>添加</span></a></li>
<!-- 			<li class="line">line</li> -->
<!-- 			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li> -->
		</ul>
	</div>
	<table class="table" width="180%" layoutH="158" style="word-break:break-all; word-wrap:break-all; ">
		<thead>
			<tr>
				<th align="center" style="width:30px;">序号</th>
				<th align="center" style="width:120px;" >单位</th>
				<th align="center" ><?php echo  date("Y-m-d");?></th>
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
			</tr>
		</thead>
		<tbody >
			
			 <?php 
			
			     if(@$_POST["search"]==null){
			         $result=mysqli_query($con,"select distinct hotel from t_roomstate" );
// 			         echo "select distinct hotel from t_roomstate where date > '".$yestday."'";
			         $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			         //分页显示
			         $resultnum=count($resultarray);
			         @$page=ceil($resultnum/$numPerPage);
			         @$sr=($pageNum-1)*$numPerPage;
			         $resultnow=mysqli_query($con,"select distinct hotel from t_roomstate   limit ".$sr.",".$numPerPage  );
			         $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			     }else {
			         $sql="";
			         
			         $sql.=$_POST["jdian333_id"]!=""?" and hotel = '".$_POST["jdian333_id"]."'":"";
			         $result=mysqli_query($con,"select distinct hotel from t_roomstate where 1=1 ".$sql );
			         // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			         $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			         //分页显示
			         $resultnum=count($resultarray);
			         @$page=ceil($resultnum/$numPerPage);
			         @$sr=($pageNum-1)*$numPerPage;
			         $resultnow=mysqli_query($con,"select distinct hotel from t_roomstate where 1=1 ".$sql." limit ".$sr.",".$numPerPage );
			         $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			     }
			     
			for($a=0;$a<count($resultnowarray);$a++){
			    
			    
			    //查询项目表
			    
			    ?>
<tr  >
			<td ><?php echo ($a+1);?>
			</td><td >
			<a   href="zyzx/editjdft.php?id=<?php echo $resultnowarray[$a]['hotel'];?>" target="dialog" width="340" 
			height="650" rel="editft" mask="true" style="color:blue;width:100%;height:100%; margin:auto;" title="修改房态">
		
			<?php 
			$jddianid=$resultnowarray[$a]['hotel'];
			$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			$jddian=mysqli_fetch_array($jddiansql);
			echo $jddian["hotelname"];
			$rmtysql=mysqli_query($con, "select distinct roomtype from t_roomstate where hotel=".$jddianid);
			$rmty=mysqli_fetch_all($rmtysql,MYSQLI_ASSOC);
			?>
			</a>
            </td><td ><?php 
            
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                    $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d")."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
                   
              
            } 
            
         ?>
			</td><td  ><?php 
            
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +1 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
                   
              
            } 
            
         ?>
		
</td><td  >
<?php 
            
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +2 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
                   
              
            } 
            
         ?>

</td><td  >
<?php 
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +3 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
            } 
         ?>
</td><td  >
<?php 
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +4 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
            } 
         ?>

</td><td  >

<?php 
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +5 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
            } 
         ?>
			</td><td  >
		<?php 
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +6 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
            } 
         ?>
		</td>
		<td  >

<?php 
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +7 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
            } 
         ?>
			</td><td  >
		<?php 
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +8 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
            } 
         ?>
		</td>
		<td  >
<?php 
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +9 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
            } 
         ?>
			</td><td  >
		<?php 
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +10 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
            } 
         ?>
		</td>
		<td  >
<?php 
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +11 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
            } 
         ?>
			</td><td  >
	<?php 
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +12 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
            } 
         ?>
		</td>
		<td  >
<?php 
            for($r=0;$r<count($rmty);$r++){
                $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rmty[$r]["roomtype"]);
                $roomtype=mysqli_fetch_array($roomtypesql);
                $datesqla=mysqli_query($con, "select * from t_roomstate where date='".date("Y-m-d",strtotime(" +13 day"))."' and roomtype='".$rmty[$r]["roomtype"]."'  and hotel=".$jddianid);
                    //              echo "select * from t_roomstate where date='".date("Y-m-d")."' and hotel=".$jddianid;
                    $datea=mysqli_fetch_array($datesqla);
                    if(count($datea)==0){
                        echo $roomtype["basetype"]."：<span style='color:red;'>未查询到当日房态</span><br>";
                    }else{
                        echo $roomtype["basetype"]."：<span style='color:green;'>".($datea["had"]-$datea["rhaving"])."（剩余）</span><br>";
                    }
            } 
         ?>
			</td>
		</tr>
		<?php  	}
		mysqli_close($con);
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