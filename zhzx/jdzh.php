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
if(isset($_POST["jdian222_id"])){
    $hotel=$_POST["jdian222_id"];
    $chkUseChk=$_POST["chkUseChk"];
    $txtUserAccount=$_POST["txtUserAccount"];
    $txtUserPwd=$_POST["txtUserPwd"];
    $txtUserName=$_POST["txtUserName"];
    $txtUserTel=$_POST["txtUserTel"];
    $txtUserFax=$_POST["txtUserFax"];
    $txtUserMobile=$_POST["txtUserMobile"];
    mysqli_query($con, "insert into t_hoteluser(realname,username,password,phone,tel,fax,hotel,status,creattime)values(
'".$txtUserName."','".$txtUserAccount."','".$txtUserPwd."','".$txtUserMobile."',
'".$txtUserTel."','".$txtUserFax."','".$hotel."','".$chkUseChk."',now()
)");

    echo mysqli_error($con);
}
    }
    if($_GET["action"]=="qxgl"){
    $allqx="null";
    foreach ($_POST["qx"] as $qx){
        $allqx.=",".$qx;
    }
    mysqli_query($con, "update t_hoteluser set userlimit='".$allqx."' where id=".$_GET["id"]);

}
if($_GET["action"]=="delete"){
    mysqli_query($con, "delete from t_hoteluser  where id=".$_GET["id"]);
    
}
if($_GET["action"]=="edit"){
    $hotel=$_POST["jdian222_id"];
    $chkUseChk=$_POST["chkUseChk"];
    $txtUserAccount=$_POST["txtUserAccount"];
    $txtUserPwd=$_POST["txtUserPwd"];
    $txtUserName=$_POST["txtUserName"];
    $txtUserTel=$_POST["txtUserTel"];
    $txtUserFax=$_POST["txtUserFax"];
    $txtUserMobile=$_POST["txtUserMobile"];
    mysqli_query($con, "update t_hoteluser  set realname='".$txtUserName."',username='".$txtUserAccount."',password='".$txtUserPwd."',
phone='".$txtUserMobile."',tel='".$txtUserTel."',fax='".$txtUserFax."',hotel='".$hotel."',status='".$chkUseChk."' where id=".$_GET["id"]);
    echo "<script>alert('修改成功！');</script>";
}
}
?>

<form id="pagerForm" method="post" action="zhzx/jdzh.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="zhzx/jdzh.php" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				<td>姓名：<input name="name" type="text"/></td>
				
				<td>账号：<input name="username" type="text"/></td>
				<td class="dateRange">
					公司名称:
					 <input type='hidden' name='jdian100.id' value=''/>
                         <input type='text' oninput="getjdian('100')" class="getjdian100" 
                         name='jdian100.jdian100' value=''  style='width: 80%;' suggestFields='jdian100'  lookupGroup='jdian100' />
					
				</td><script type="text/javascript">
function getjdian(id){
	$(".getjdian"+id).attr("suggestUrl","ajax/xlk/jdian.php?id="+id+"&name="+$(".getjdian"+id).val());
}
</script><input name="search"  type="hidden" size="30" value="yes"/>
				<td><div class="button"><div class="buttonContent"><button type="search">检索</button></div></div></td>
			</tr>
			
		</table>
		
			
		
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="zhzx/add.php" target="dialog" mask="true" rel="qwewq" title="添加酒店用户账号" width="670" height="220"><span>添加</span></a></li>
			
		</ul>
	</div><script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">姓名</th>
				<th align="center">登录账号</th>
				<th align="center">手机</th>
				<th align="center">电话</th>
				<th align="center">传真</th>
				<th align="center">所属公司</th>
				<th align="center">启用标志</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 
			if(@$_POST["search"]==null){
			    $result=mysqli_query($con,"select * from t_hoteluser" );
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_hoteluser limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}else {
			    $sql="";
			   
			    $sql.=$_POST["jdian100_id"]!=""?" and hotel='".$_POST["jdian100_id"]."'":"";
			    $sql.=$_POST["name"]!=""?" and realname like '%".$_POST["name"]."%'":"";
// 			    $sql.=$_POST["name"]!=""?" and updatePeople='".$_POST["name"]."'":"";
			    $sql.=$_POST["username"]!=""?" and username like '%".$_POST["username"]."%'":"";
			    $result=mysqli_query($con,"select * from t_hoteluser where 1=1 ".$sql );
			    // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_hoteluser where 1=1 ".$sql." limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}
			
			for($a=0;$a<count($resultnowarray);$a++){
	?>
	<tr>
	<td><?php echo $a+1;?></td>
	<td><?php echo $resultnowarray[$a]["realname"];?></td>
	<td><?php echo $resultnowarray[$a]["username"];?></td>
	<td><?php echo $resultnowarray[$a]["phone"];?></td>
	<td><?php echo $resultnowarray[$a]["tel"];?></td>
	<td><?php echo $resultnowarray[$a]["fax"];?></td>
	<td><?php 
	$jddianid=$resultnowarray[$a]['hotel'];
	$jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
	$jddian=mysqli_fetch_array($jddiansql);
	echo $jddian["hotelname"];
	?></td>
	<td><?php echo $resultnowarray[$a]["status"];?></td>
	<td><a href="zhzx/jdqx.php?id=<?php echo $resultnowarray[$a]["Id"];?>" target="dialog" mask="true" style="color:blue;">权限管理</a> 
	<a  href="zhzx/jdzh.php?action=delete&id=<?php echo $resultnowarray[$a]["Id"];?>" style="color:blue;" target="navTab" rel="jdzh" >删除</a>
	<a  href="zhzx/editjdzh.php?id=<?php echo $resultnowarray[$a]["Id"];?>" style="color:blue;" target="dialog" mask="true" rel="edotjdzh" >修改</a>
	</td>
	
	
	</tr>
	<?php 		}
 
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