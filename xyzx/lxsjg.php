<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
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

if(isset($_GET["action"])){
    if($_GET["action"]=="charu"){
        $dealName=$_POST["dealName"];
        $travelName=$_POST["zts_id"];
        if($travelName!=""){
        $starttime=$_POST["starttime"];
        $endtime=$_POST["endtime"];
//         $standardRoom=$_POST["standardRoom"];
//         $twinBed=$_POST["twinBed"];
//         $singleRoom=$_POST["singleRoom"];
//         $triple=$_POST["triple"];
        $remark=$_POST["remark"];
        $flag=$_POST["flag"];
        $user=$_SESSION["userid"];
        $hid="0";
        foreach ($_POST["hotelid"] as $id){
            $hid.=",".$id;
        }
        mysqli_query($con, "insert into t_protocol(dealName,travelName,starttime,endtime,remark,flag,issuer,forhotel)
values('".$dealName."','".$travelName."','".$starttime."','".$endtime."','".$remark."','".$flag."','".$user."','".$hid."')
        
");
        $id=mysqli_insert_id($con);
        foreach ($_POST["fjtype"] as $a=>$b){
            //echo $b.$_POST["fjprice"][$a];
            if($_POST["fjprice"][$a]!=0){
                mysqli_query($con, "insert into t_roomprice(roomType,price,travelSchemeId)values('".$b."','".$_POST["fjprice"][$a]."','".$id."')");
            }
            
        }
        }else{
            echo "<script>alert('请选择旅行社！');</script>";
        }
    }
    if($_GET["action"]=="edit"){
        $dealName=$_POST["dealName"];
        $starttime=$_POST["starttime"];
        $endtime=$_POST["endtime"];
        
        $remark=$_POST["remark"];
        $flag=$_POST["flag"];
        $user=$_SESSION["userid"];
        $hid="0";
        foreach ($_POST["hotelid"] as $id){
            $hid.=",".$id;
        }
        $id=$_GET["id"];
        mysqli_query($con, "update  t_protocol set dealName='".$dealName."',starttime='".$starttime."'
,endtime='".$endtime."',remark='".$remark."',flag='".$flag."',issuer='".$user."',forhotel='".$hid."' where id=".$id);
        foreach ($_POST["fjtype"] as $a=>$b){
            //echo $b.$_POST["fjprice"][$a];
            if($_POST["fjprice"][$a]!=0){
                //查询是否有该数据
                $isinsql=mysqli_query($con, "select * from  t_roomprice  where roomType='".$b."' and travelSchemeId='".$id."'");
                if(mysqli_num_rows($isinsql)<1){
                    mysqli_query($con, "insert into t_roomprice(roomType,price,travelSchemeId)values('".$b."','".$_POST["fjprice"][$a]."','".$id."')");
                    
                }else{
                    mysqli_query($con, "update  t_roomprice set price='".$_POST["fjprice"][$a]."' where roomType='".$b."' and travelSchemeId='".$id."'");
                    
                }
                
            }
            
        }
        
    }
    if($_GET["action"]=="delete"){
        $id=$_GET["id"];
        mysqli_query($con, "delete from t_protocol where id=".$id);
        echo "<script>alert('删除成功！');</script>";
    }
}
date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
?>
<script type="text/javascript" src="ajax/js/main.js"></script>
<form id="pagerForm" method="post" action="xyzx/lxsjg.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="xyzx/lxsjg.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				<td >
					单位:
				<input type="hidden" name="zts.id" value=""/>
				<input type="text" class="getzts" name="zts.zts" value="" suggestFields="zts"   lookupGroup="zts" />
				<a class="btnLook" style="float: right;" href="ajax/dh/zts.php" lookupGroup="zts">选择组团社</a>
				</td>
				<td >
					协议名称:
					<input name="dealName"  type="text" size="30" value="" />
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
			<li><a class="add" href="xyzx/addlxsxy.php" target="navTab" rel="addxy"  title="添加协议" width="576" height="544"> <span>添加</span></a></li>
<!-- 			<li class="line">line</li> -->
<!-- 			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li> -->
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">协议名称</th>
				<th align="center">协议单位</th>
				<th align="center">应用酒店</th>
				<th align="center">日期范围</th>
				<th align="center">发布人</th>
				<th align="center">明细</th>
				<th align="center" >备注</th>
				<th align="center">标志</th>
				<th align="center">操作</th>

			
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 if(@$_POST["search"]==null){
			     $result=mysqli_query($con,"select * from t_protocol where travelName is not null" );
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_protocol where travelName is not null order by id DESC limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }else{
			     
			     $sql="";
			     $sql.=$_POST["zts_id"]!=""?" and travelName='".$_POST["zts_id"]."'":"";
			     // $sql.=$_POST["jd_id"]!=""?" and operator='".$_POST["jd_id"]."'":"";
			     $sql.=$_POST["dealName"]!=""?" and dealName like '%".$_POST["dealName"]."%'":"";
			     $result=mysqli_query($con,"select * from t_protocol  where travelName is not null ".$sql." order by id" );
			     //echo "select * from t_hoteldebt  where 1=1 ".$sql." order by id";
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);

			     //分页显示
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_protocol where travelName is not null ".$sql." order by id DESC limit ".$sr.",".$numPerPage  );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }
			
			for($a=0;$a<count($resultnowarray);$a++){
			    if($resultnowarray[$a]['flag']=="on"){
			        
			        $orderstates="<span style='color:green;'>启用</span>";
			    }else{
			        $orderstates="<span style='color:red;'>未启用</span>";
			    }
			    
			    //查询项目表
			  
			
			    $ztsid=$resultnowarray[$a]['travelName'];
			    $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			    $zts=mysqli_fetch_array($ztssql);
			   
			    ?>
<tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php echo $resultnowarray[$a]['dealName'];?>
            </td><td ><?php  echo $zts['travel_name'];?>
            </td><td  ><?php 
            $jdstr=$resultnowarray[$a]['forhotel'];
            $jd=explode(",", $jdstr);

            foreach ($jd as $h){
                $jddianid=$h;
                $jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
                $jddian=mysqli_fetch_array($jddiansql);
                echo $jddian["hotelname"]." ";
            }
            ?>
			</td><td  ><?php echo $resultnowarray[$a]['starttime']."至".$resultnowarray[$a]['endtime'];?>
			</td><td  ><?php 
			$isusersql=mysqli_query($con, "select realName from t_user where id=".$resultnowarray[$a]['issuer']);
			$isuser=mysqli_fetch_array($isusersql);
			echo $isuser["realName"];
			?>
			</td><td  ><?php
			$pricesql=mysqli_query($con, "select * from t_roomprice where travelSchemeId='".$resultnowarray[$a]['id']."' ");
			$price=mysqli_fetch_all($pricesql,MYSQLI_ASSOC);
// 			foreach ($price as $)

for($cost=0;$cost<count($price);$cost++){
    $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$price[$cost]["roomType"]);
    $roomtype=mysqli_fetch_array($roomtypesql);
    echo $roomtype["basetype"]."：".$price[$cost]["price"]."元<br>";
}
			?>
			</td><td  ><?php echo $resultnowarray[$a]['remark'];?>
</td><td  ><?php echo $orderstates;?>
			</td><td  >
			<a href='xyzx/showxy.php?id=<?php echo $resultnowarray[$a]['id'];?>' class='show' id='' mask="true" rel="showlxsxy" target='dialog' title='查看协议<?php echo $resultnowarray[$a]['id'];?>' style='color:blue;'>查看</a>
		<a href='xyzx/editlxsxy.php?id=<?php echo $resultnowarray[$a]['id'];?>' class='show' id='' mask="true" rel="editlxsxy" width="610" target='dialog' title='编辑协议<?php echo $resultnowarray[$a]['id'];?>' style='color:blue;'>编辑</a>
						<a href='xyzx/lxsjg.php?id=<?php echo $resultnowarray[$a]['id'];?>&action=delete' class='show' id='' target="navTab" rel="lxsjg" title='编辑协议<?php echo $resultnowarray[$a]['id'];?>' style='color:blue;'>删除</a>
			</td></tr>
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