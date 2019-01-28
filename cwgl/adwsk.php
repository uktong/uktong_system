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

$action=@$_GET["action"];
switch ($action){
    case "chaxun":
        chaxun();
        break;
    case "charu":
        charu();
        break;
    case "delete":
        shanchu();
        break;
    case "edit":
        edit();
        break;
}
function charu(){

    
    mysqli_close($con);
}
function edit(){

}
function shanchu(){
    require $_SESSION["ROOT"].'/db/db.php';
    $id=$_GET["id"];
    mysqli_query($con, "delete from t_sktravel where id=".$id);
}
?>
<script type="text/javascript" src="ajax/js/main.js"></script>

<form id="pagerForm" method="post" action="cwgl/adwsk.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>


<div class="pageHeader">
		<form onsubmit="return navTabSearch(this);" id="jdyfcxform" action="cwgl/adwsk.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
			<td class="dateRange">
					收款日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
				<td >
					组团社:
					<input type="hidden" name="zts.id" value="<?php echo @$_POST["zts_id"];?>"/>
				<input type="text" class="getzts" name="zts.zts" value="<?php echo @$_POST["zts_zts"];?>" readonly style="width:100px; " suggestFields="zts"  lookupGroup="zts" />
				<a class="btnLook" href="ajax/dh/zts.php"style="float:right;margin-right:100px;"  lookupGroup="zts">选择用户</a>
				
				</td>
				<td >
					收款人:
				<input type="text" name="dopeople" style="width:100px;" value="<?php echo @$_POST["dopeople"];?>"/>
				</td>
<!-- 				<td > -->
<!-- 					酒店: -->

<!-- 				</td> -->
<!-- 				</tr>--><tr> 
				
				<td >
					收款账户:
					<input name="account"  type="text" size="30" style="width:150px;" value="<?php echo @$_POST["account"];?>" />
				</td>
				<td>归档时间:
				<select name="gdmonth" id="gdmonth" >
				<option value="">------</option>
				<?php for($m=1;$m<13;$m++){?>
				<option value="<?php echo $m;?>" <?php echo @$_POST["gdmonth"]==$m?"selected='selected'":"";?> ><?php echo $m;?>月</option>
				<?php }?>
				</select></td>
				<td >
					备注:
					<input name="remark"  type="text" size="30" style="width:150px;" value="<?php echo @$_POST["remark"];?>" />
				</td>
			
				<td><button type="submit">搜索</button></td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<input name="searchtype"  type="hidden" size="30" value="jdyfcx"/>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="cwgl/addadwsk.php" target="dialog" max="true" mask="true" rel="addadwsk"><span>添加</span></a></li>
		</ul>
	</div><script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">旅行社</th>
				<th align="center">日期</th>
				<th align="center">归档时间</th> 
				<th align="center">方式</th>
				<th align="center">发票金额</th>
				<th align="center">金额</th>
				<th align="center">下账金额</th>
<!-- 				<th align="center">销售</th> -->
				<th align="center">余额</th>
				<th align="center">操作人</th>
				<th align="center">备注</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 
			$xje=0;
			$xzje=0;
			$xye=0;
			$zje=0;
			$zzje=0;
			$zye=0;
			if(@$_POST["search"]==null){
			    $result=mysqli_query($con,"select * from t_sktravel where travel is not null and dodate between '".$firstday."' and '".$lastday."' ");
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    for($z=0;$z<count($resultarray);$z++){
			        $zje+=$resultarray[$z]['money'];
			        $zzje+=$resultarray[$z]['money']-$resultarray[$z]['mhaving'];
			        $zye+=$resultarray[$z]['mhaving'];
			    }
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_sktravel where travel is not null and dodate between '".$firstday."' and '".$lastday."'  limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			    
			}else {
			    $sql="";
			    $startdate=$_POST["startDate"];
			    $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			    $sql.=" and dodate between '".$startdate."' and '".$enddate."'";
			    $sql.=$_POST["zts_id"]!=""?" and travel='".$_POST["zts_id"]."'":"";
			    $sql.=$_POST["gdmonth"]!=""?" and gddate='".$_POST["gdmonth"]."'":"";
			    $sql.=$_POST["dopeople"]!=""?" and dopeoplename like '%".$_POST["dopeople"]."%'":"";
			    $sql.=$_POST["account"]!=""?" and accountname like '%".$_POST["account"]."%'":"";
			    $sql.=$_POST["remark"]!=""?" and remark like '%".$_POST["remark"]."%'":"";
			    $result=mysqli_query($con,"select * from t_sktravel where travel is not null  ".$sql );
			    // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			    //echo $sql;
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_sktravel where travel is not null  ".$sql." limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}
			
			for($a=0;$a<count($resultnowarray);$a++){
			    $xje+=$resultnowarray[$a]['money'];
			    $xzje+=$resultnowarray[$a]['money']-$resultnowarray[$a]['mhaving'];
			    $xye+=$resultnowarray[$a]['mhaving'];
			?>
			  <tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php 
			
			$ztsid=$resultnowarray[$a]['travel'];
			$ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
			$zts=mysqli_fetch_array($ztssql);
			echo $zts['travel_name'];
			?>
            </td><td ><?php echo $resultnowarray[$a]['dodate'];?>
            </td><td ><?php echo $resultnowarray[$a]['gddate'];?>月
            </td><td ><?php 

            $getpaysql=mysqli_query($con, "select * from t_baseconfig where basenote=5 and id=".$resultnowarray[$a]['paytype']);
            @$getpay=mysqli_fetch_array($getpaysql,MYSQLI_ASSOC);
            echo @$getpay["basetype"];
            ?>
            </td><td ><?php echo $resultnowarray[$a]['invoice'];?>
            </td><td ><?php echo $resultnowarray[$a]['money'];?>
            </td><td ><?php echo $resultnowarray[$a]['money']-$resultnowarray[$a]['mhaving'];?>
            </td><td ><?php echo $resultnowarray[$a]['mhaving'];?>
            </td><td ><?php 
            $jdid=$resultnowarray[$a]['dopeople'];
            $jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
            $jd=mysqli_fetch_array($jdsql);
            echo $jd["username"];
            ?>
            </td><td  style="word-break:break-all; word-wrap:break-all; width:300px;"><?php echo $resultnowarray[$a]['remark'];?>
			</td><td  >
			<a href='cwgl/editadwsk.php?id=<?php echo$resultnowarray[$a]['id'];?>' class='btnEdit' id='' target="dialog" max="true" mask="true" rel="editadwsk" style='color:blue;'>修改</a>
</td></tr>
<?php			
}
 
    ?>
    <tr >
				<th align="center">小计</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th> 
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $xje;?></th>
				<th align="center"><?php echo $xzje;?></th>
				<th align="center"><?php echo $xye;?></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
			</tr>
			 <tr>
				<th align="center">总计</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th> 
				<th align="center"></th>
				<th align="center"></th>
			<th align="center"><?php echo $zje;?></th>
				<th align="center"><?php echo $zzje;?></th>
				<th align="center"><?php echo $zye;?></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
			</tr>
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