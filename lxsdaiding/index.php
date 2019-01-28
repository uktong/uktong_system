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
$yestoday=date("Y-m-d",strtotime("  -1 day"));

?>
<form id="pagerForm" method="post" action="lxsdaiding/daiding.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>
<script type="text/javascript" src="ajax/js/main.js"></script>
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
	  $("#sureall").attr("href","ajax/lxsqueding.php?id="+allcheck);
}
function getallcheckqx(){
	for (var i = 0; i < allpro.length; i++) {
    		  if (allpro[i].checked==true) {
    		  allcheck+=","+allpro[i].value;
    
    		  }
		  }
	  $("#quxiaoall").attr("href","ajax/lxsqxqueding.php?id="+allcheck);
}
function test(){
	window.open("other/print.php?"+$("#lxsddqr").serialize());
}
</script>
<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" id="lxsddqr" action="lxsdaiding/index.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
			<td class="dateRange">
					入住日期:
					<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$yestoday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value=" <?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
				<td >
					计调:
					<input type="hidden" name="jd.id" value="<?php echo @$_POST["jd_id"];?>"/>
				<input type="text" class="getjd" name="jd.jd" value="<?php echo @$_POST["jd_jd"];?>" suggestFields="jd"  lookupGroup="jd" />
				</td>
				
				<td >
					联系人:
					<input name="linkman"  type="text" size="30" value="<?php echo @$_POST["linkman"];?>" />
				</td>
				<td >
						酒店:
				<input type="hidden" name="jdian222.id" value="<?php echo @$_POST["jdian222_id"];?>"/>
				<input type="text" class="getjdian222" oninput="getjdian(222);" name="jdian222.jdian222" value="<?php echo @$_POST["jdian222_jdian222"];?>" suggestFields="jdian222"   lookupGroup="jdian222" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jdian.php?id=222" lookupGroup="jdian222">选择酒店</a>
				</td>
				</tr><tr>
				<td >
					房型:
				<select  name="fjtype111.id" class="getfjtype111>"  style='width: 70%;' >
		<option value=""></option>
	<?php 
	$getfjtype=mysqli_query($con, "select * from t_baseconfig where basenote=2 order by px desc");
	$fjtypere=mysqli_fetch_all($getfjtype,MYSQLI_ASSOC);
	for($f=0;$f<count($fjtypere);$f++){
	?>
	<option value="<?php echo $fjtypere[$f]["id"];?>" <?php echo $fjtypere[$f]["id"]==@$_POST["fjtype111_id"]?"selected='selected'":"";?>><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select></td>
				<td >
					团号:
					<input name="groupnum"  type="text" size="30" value="<?php echo @$_POST["groupnum"];?>" />
				</td>
				<td >
					客人姓名:
					<input name="cusname"  type="text" size="30" value="<?php echo @$_POST["cusname"];?>" />
				</td>
				
				<td><button type="submit">搜索</button></td><td><a  onclick="getallcheck()" id="sureall" class="buttonActive" target="ajaxTodo" ><span>确定</span></a></td>
			<td><a  onclick="getallcheckqx()" id="quxiaoall" class="buttonActive" target="ajaxTodo" ><span>取消</span></a></td>
			<td><button type="button" onclick="test()">打印</button></td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<input name="searchtype"  type="hidden" size="30" value="lxsddqr"/>
	</div>
	</form>
</div>
<div class="pageContent">

	<table class="table" width="100%" layoutH="168" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">团号</th>
				<th align="center">酒店</th>
				<th align="center">路早</th>
				<th align="center">计调	</th>
				<th align="center">日期</th>
				<th align="center">房型</th>
				<th align="center">数量</th>
				<th align="center">客人信息</th>
				<th align="center" >订单状态</th>
				<th align="center" >全选<input type="checkbox" onclick="checkedall()" id="sure"></th>
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 $hotelcode=$_SESSION["hotelcode"];
			 $idsql=mysqli_query($con, "select id from t_travel where travel_code='".$hotelcode."' ");
			 $idre=mysqli_fetch_array($idsql);
			
			 if(@$_POST["search"]==null){
			     if(isset($_GET["msg"])){
			         
			         $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_reserveplan.lxsstatus is null and t_groupmanage.groupName='".$idre['id']."' and t_groupmanage.hotelManage='代订酒店' and t_reserveplan.startDate between '".$yestoday."' and '".$lastday."'" );
			         $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			         //分页显示
			         
			         
			         $resultnum=count($resultarray);
			         @$page=ceil($resultnum/$numPerPage);
			         @$sr=($pageNum-1)*$numPerPage;
			         $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber  where t_groupmanage.groupName='".$idre['id']."' and t_groupmanage.hotelManage='代订酒店' and t_reserveplan.lxsstatus is null and t_reserveplan.startDate between '".$yestoday."' and '".$lastday."' order by t_groupmanage.id  limit ".$sr.",".$numPerPage  );
			         $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			     }else{
			         $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on t_groupmanage.teamNumber=t_reserveplan.groupNumber where   t_groupmanage.groupName='".$idre['id']."' and t_groupmanage.hotelManage='代订酒店' and t_reserveplan.startDate between '".$yestoday."' and '".$lastday."'" );
			         $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			         //分页显示
			         
			         
			         $resultnum=count($resultarray);
			         @$page=ceil($resultnum/$numPerPage);
			         @$sr=($pageNum-1)*$numPerPage;
			         $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber  where t_groupmanage.groupName='".$idre['id']."' and t_groupmanage.hotelManage='代订酒店' and t_reserveplan.startDate between '".$yestoday."' and '".$lastday."' order by t_groupmanage.id  limit ".$sr.",".$numPerPage  );
			         $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			     }
			     
			 }else {
			     $sql="";
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         $sql.=" and t_reserveplan.startDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_POST["jdian222_id"]!=""?" and t_reserveplan.hotelName='".$_POST["jdian222_id"]."'":"";
			     $sql.=$_POST["jd_id"]!=""?" and t_groupmanage.jd='".$_POST["jd_id"]."'":"";
			     $sql.=$_POST["fjtype111_id"]!=""?" and t_reserveplan.roomType='".$_POST["fjtype111_id"]."'":"";
			     $sql.=$_POST["groupnum"]!=""?" and t_groupmanage.teamNumber like '%".$_POST["groupnum"]."%'":"";
			     $sql.=$_POST["cusname"]!=""?" and t_groupmanage.guest like '%".$_POST["cusname"]."%'":"";
			     $sql.=$_POST["linkman"]!=""?" and t_groupmanage.linkmanname like '%".$_POST["linkman"]."%'":"";
			     $result=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where  t_groupmanage.groupName='".$idre['id']."' and t_groupmanage.hotelManage='代订酒店'  ".$sql." order by t_groupmanage.id" );
			     // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			     $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			     //分页显示
			   
			     $resultnum=count($resultarray);
			     @$page=ceil($resultnum/$numPerPage);
			     @$sr=($pageNum-1)*$numPerPage;
			     $resultnow=mysqli_query($con,"select * from t_groupmanage right join t_reserveplan on
t_groupmanage.teamNumber=t_reserveplan.groupNumber where t_groupmanage.groupName='".$idre['id']."' and t_groupmanage.hotelManage='代订酒店'  ".$sql." order by t_groupmanage.id limit ".$sr.",".$numPerPage );
			     $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			 }

			    
			   
			
			for($a=0;$a<count($resultnowarray);$a++){
			   
			    $jdid=$resultnowarray[$a]['jd'];
			    $jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
			    $jd=mysqli_fetch_array($jdsql);
			    $jddianid=$resultnowarray[$a]['hotelName'];
			    $jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
			    $jddian=mysqli_fetch_array($jddiansql);
			    
			    
			    ?>
			    
			    <tr  >
			<td  >
			<?php echo $a+1;?>
			</td>
			<td  >
			<?php echo $resultnowarray[$a]["teamNumber"];?>
			</td>
			<td  ><?php 
			echo $jddian["hotelname"];
			?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["breakfast"]=="1"?"路早":"正常早餐";?>
			</td>
			<td  ><?php 
			$jdid=$resultnowarray[$a]["jd"];
			$jdsql=mysqli_query($con, "select username from t_user where id=".$jdid);
			$jd=mysqli_fetch_array($jdsql);
			echo $jd["username"];
			?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["startDate"];?>
			</td>
			<td  ><?php
			$fxid= $resultnowarray[$a]["roomType"];
			$fxsql=mysqli_query($con, "select basetype from t_baseconfig where id=".$fxid);
			$fx=mysqli_fetch_array($fxsql);
			echo $fx["basetype"];
			?>
			</td>
			<td  ><?php echo $resultnowarray[$a]["number"];?>
			</td>
			<td  style="word-break:break-all; word-wrap:break-all;width:300px;"><?php echo $resultnowarray[$a]["guestName"];?>
			</td>
			
		<td  ><?php 
			if($resultnowarray[$a]['lxsstatus']=="yes"){
			    
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
		<?php
			}
 
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