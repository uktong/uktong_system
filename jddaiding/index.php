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

date_default_timezone_set('prc');
$firstday = date("Y-m-01");
$lastday = date("Y-m-d",strtotime("$firstday +1 month -1 day"));
$yestoday=date("Y-m-d",strtotime("  -1 day"));

require_once $_SESSION["ROOT"].'/db/db.php';
$hotelcode=$_SESSION["hotelcode"];
$idsql=mysqli_query($con, "select id from t_allhotel where hotelcode='".$hotelcode."' ");
$idre=mysqli_fetch_array($idsql);
if(@$_POST["search"]==null){
    if(isset($_GET["msg"])){
        $result=mysqli_query($con,"select * from t_reserveplan where  startDate between '".$yestoday."' and '".$lastday."' and  hotelName='".$idre["id"]."'" );
        $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
        //分页显示
        $resultnum=count($resultarray);
        @$page=ceil($resultnum/$numPerPage);
        @$sr=($pageNum-1)*$numPerPage;
        @$er=$pageNum*$numPerPage;
        $resultnow=mysqli_query($con,"select * from t_reserveplan where  startDate between '".$yestoday."' and '".$lastday."' and  hotelName='".$idre["id"]."' order by startDate DESC limit ".$sr.",".$numPerPage  );
        $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
    }else{
        $result=mysqli_query($con,"select * from t_reserveplan where  startDate between '".$yestoday."' and '".$lastday."' and  hotelName='".$idre["id"]."'" );
        $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
        //分页显示
        $resultnum=count($resultarray);
        @$page=ceil($resultnum/$numPerPage);
        @$sr=($pageNum-1)*$numPerPage;
        @$er=$pageNum*$numPerPage;
        $resultnow=mysqli_query($con,"select * from t_reserveplan where  startDate between '".$yestoday."' and '".$lastday."' and  hotelName='".$idre["id"]."' order by startDate DESC limit ".$sr.",".$numPerPage  );
        $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
    }
   
}else {
    $sql="";
    if($_POST["startDate"]!=""){
        $startdate=$_POST["startDate"];
        $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
        $sql.=" and startDate between '".$startdate."' and '".$enddate."'";
    }
    // 			     $sql.=$_POST["zts_id"]!=""?" and groupName='".$_POST["zts_id"]."'":"";
    $sql.=$_POST["jd_id"]!=""?" and manageUser='".$_POST["jd_id"]."'":"";
    if($_POST["planstatus"]!="全部"){
    $sql.=$_POST["planstatus"]!="yes"?"and planstatus is null":" and planstatus='yes'";
    }
    $sql.=$_POST["luzao"]!=""?" and breakfast='".$_POST["luzao"]."'":"";
    $sql.=$_POST["fjtype111_id"]!=""?" and roomType='".$_POST["fjtype111_id"]."'":"";
    $sql.=$_POST["krxm"]!=""?" and guestName like '%".$_POST["krxm"]."%'":"";
    $sql.=$_POST["groupnum"]!=""?" and groupNumber like '%".$_POST["groupnum"]."%'":"";
    $result=mysqli_query($con,"select * from t_reserveplan where   hotelName='".$idre["id"]."' ".$sql );
    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
    
    //分页显示
    $resultnum=count($resultarray);
    @$page=ceil($resultnum/$numPerPage);
    @$sr=($pageNum-1)*$numPerPage;
    $resultnow=mysqli_query($con,"select * from t_reserveplan where   hotelName='".$idre["id"]."' ".$sql." order by startDate DESC limit ".$sr.",".$numPerPage );
    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
}
$qxsql=mysqli_query($con, "select userlimit from t_hoteluser where id=".$_SESSION["userid"]);
$qx=mysqli_fetch_array($qxsql);
$allqx=explode(",", $qx["userlimit"]);
$show="style='display:block;color:blue;'";
$hide="style='display:none;color:blue;'";
$limitsure=$hide;
$limitedit=$hide;
$limitadd="style='display:none;'";
for($q=1;$q<count($allqx);$q++){
   
    if($allqx[$q]=="edit"){
        $limitedit=$show;
    }
    if($allqx[$q]=="new"){
        $limitadd="style='display:block;'";
    }
    
}
?>
<form id="pagerForm" method="post" action="jddaiding/index.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>
<script>

var allpro = document.getElementsByName("queding");
//全选方法
function checkedall() {
 //获取全选按钮
var all = document.getElementById("sure");
//全选按钮被选中时，遍历所有按钮
 if (all.checked) {
  for (var i = 0; i < allpro.length; i++) {
  if (allpro[i].type=="checkbox") {
  allpro[i].checked=true;

  }
  }
  //全选按钮未被选中时
 }else{
  for (var i = 0; i < allpro.length; i++) {
  if (allpro[i].type=="checkbox") {
  allpro[i].checked=false;
  }
  }
 }
}
allcheck="0";
function getallcheck(){
	for (var i = 0; i < allpro.length; i++) {
    		  if (allpro[i].checked==true) {
    		  allcheck+=","+allpro[i].value;
    
    		  }
		  }
	  $("#sureall").attr("href","ajax/queding.php?id="+allcheck);
}
function getallcheckqx(){
	for (var i = 0; i < allpro.length; i++) {
    		  if (allpro[i].checked==true) {
    		  allcheck+=","+allpro[i].value;
    
    		  }
		  }
	  $("#quxiaoall").attr("href","ajax/qxqueding.php?id="+allcheck);
}
function test(){
	window.open("other/print.php?"+$("#jdddqr").serialize());
}
</script>
<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" id="jdddqr" action="jddaiding/index.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				
				<td class="dateRange">
					按入住日期:
						<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
						echo  isset($_POST["startDate"])?$_POST["startDate"]:$yestoday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value="<?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>

				<td >
					对接人:
					<input type="hidden" name="jd.id" value="<?php echo isset($_POST["jd_id"])?$_POST["jd_id"]:"";?>"/>
				<input type="text" class="getjd" name="jd.jd" value="<?php echo isset($_POST["jd_jd"])?$_POST["jd_jd"]:"";?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jd.php" lookupGroup="jd">选择用户</a>
				</td>
				
					<td >
					房型:
						<select  name="fjtype111.id" class="getfjtype111" style='width: 70%;' >
		<option value="">全部</option>
	<?php 
	$getfjtype=mysqli_query($con, "select * from t_baseconfig where basenote=2 order by px desc");
	$fjtypere=mysqli_fetch_all($getfjtype,MYSQLI_ASSOC);
	for($f=0;$f<count($fjtypere);$f++){
	?>
	<option value="<?php echo $fjtypere[$f]["id"];?>" <?php echo $fjtypere[$f]["id"]==@$_POST["fjtype111_id"]?"selected='selected'":"";?>><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select>
				</td>
				<td >
					路早:
					<select  name="luzao" class="" style='width: 70%;' >
		<option value="">全部</option>
		<option value="0">正常早餐</option>
		<option value="1">路早</option>
	</select>
				</td>
			</tr>
			<tr>
			<td >
					团号:
					<input name="groupnum"  type="text" size="30" value="<?php echo isset($_POST["groupnum"])?$_POST["groupnum"]:"";?>" />
				</td>
			<td><span>确认状态：</span><select   name="planstatus">
			<option >全部</option>
			<option <?php 
			if(isset($_POST["planstatus"])&&$_POST["planstatus"]=="no"){
			    echo "selected='selected'";
			}
			?> value="no">未确认</option>
			<option <?php 
			if(isset($_POST["planstatus"])&&$_POST["planstatus"]=="yes"){
			    echo "selected='selected'";
			}
			?> value="yes">已确认</option>
			</select></td>
			<td >
					客人姓名:
					<input name="krxm"  type="text" size="30" value="<?php echo isset($_POST["krxm"])?$_POST["krxm"]:"";?>" />
				</td><td><button type="submit">检索</button></td><td><a  onclick="getallcheck()" id="sureall" class="buttonActive" target="ajaxTodo" ><span>确定</span></a></td>
			<td><a  onclick="getallcheckqx()" id="quxiaoall" class="buttonActive" target="ajaxTodo" ><span>取消</span></a></td>
			<td><button type="button" onclick="test()">打印</button></td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<input name="searchtype"  type="hidden" size="30" value="jdddqr"/>
	</div>
	</form>
</div>
<div class="pageContent">

	<table class="table" width="100%" layoutH="158" style="word-break:break-all; word-wrap:break-all; ">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">酒店</th>
				<th align="center">路早</th>
				<th align="center">入住日期</th>
				<th align="center">对接人</th>
				<th align="center">房间类型</th>
				<th align="center">数量</th>
				<th align="center">天数</th>
				<th align="center">累计</th>
				<th align="center" >客人信息</th>
				<th align="center" >订单状态</th>
				<th align="center" >全选<input type="checkbox" onclick="checkedall()" id="sure"></th>
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 
			for($a=0;$a<count($resultnowarray);$a++){
			    if($resultnowarray[$a]['planstatus']!=null){
			        
			        $orderstates="<span style='color:green;'>确认</span>";
			    }else{
			        $orderstates="<span style='color:red;'>未确认</span>";
			        $limitsure=$show;
			    }
			    $gettimesql=mysqli_query($con, "select enteringDate,groupName from t_groupmanage where teamNumber='".$resultnowarray[$a]['groupNumber']."'");
			    $gettime=mysqli_fetch_array($gettimesql);
// 			    echo "select enteringDate,groupName from t_groupmanage where teamNumber='".$resultnowarray[$a]['groupNumber']."'";
// 			    if(strtotime(date('Y-m-d H:i:s'))-strtotime($gettime['enteringDate'])<86400){
// 			        if($gettime['groupName']=""&&strstr($resultnowarray[$a]['groupNumber'], $_SESSION["hotelcode"])!=null){
// 			            $limitedit=$show;
// 			        }else{
// 			            $limitedit=$hide;
// 			        }
			      
// 			    }else{
// 			        $limitedit=$hide;
// 			    }
// 			    echo "zts:".$gettime['groupName']."<br>cunzaima :",strpos($resultnowarray[$a]['groupNumber'], $_SESSION["hotelcode"]);
			    ?>
			   <tr  >
			<td ><?php echo $a+1;?>
			</td><td ><?php echo $resultnowarray[$a]['groupNumber'];?>
            </td><td ><?php 
            $jddianid=$resultnowarray[$a]['hotelName'];
            $jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
            $jddian=mysqli_fetch_array($jddiansql);
            
            echo $jddian['hotelname'];
			?>
			</td><td ><?php echo $resultnowarray[$a]["breakfast"]=="1"?"路早":"正常早餐";?>
			</td><td  ><?php echo $resultnowarray[$a]["startDate"];?>
			</td><td  ><?php 
			$jdid=$resultnowarray[$a]["manageUser"];
			$jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
			$jd=mysqli_fetch_array($jdsql);
			echo $jd["username"];
			?>
			</td><td ><?php
			$fxid= $resultnowarray[$a]["roomType"];
			$fxsql=mysqli_query($con, "select basetype from t_baseconfig where id=".$fxid);
			$fx=mysqli_fetch_array($fxsql);
			echo $fx["basetype"];
			?>
</td><td ><?php echo $resultnowarray[$a]["number"];?>
</td><td ><?php echo $resultnowarray[$a]["dayNum"];?>
</td><td ><?php echo $resultnowarray[$a]["number"]*$resultnowarray[$a]["dayNum"];?>
			</td><td  style='width:200px;word-wrap: break-word;'><?php echo $resultnowarray[$a]["guestName"];?>
			</td><td  ><?php 
			if($resultnowarray[$a]['planstatus']=="yes"){
			    
			    $orderstates="<span style='color:green;'>已确认</span>";
			}else{
			    $orderstates="<span style='color:red;'>未确认</span>";
			}
			echo $orderstates;
			?>
</td>
<td>
<input type="checkbox" name="queding" value="<?php echo $resultnowarray[$a]["id"];?>"  />
</td>

</tr>
		<?php }
 
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