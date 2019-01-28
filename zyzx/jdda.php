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
    require $_SESSION["ROOT"].'/db/db.php';
    $txtCmpName=$_POST["txtCmpName"];
    $txtCmpCode="";
        foreach (mbStrSplit($txtCmpName) as $code){
            $txtCmpCode.=getFirstCharter($code);
        }
    $txtCmpManager=$_POST["txtCmpManager"];
    $txtCmpMobile=$_POST["txtCmpMobile"];
    $txtCmpTel=$_POST["txtCmpTel"];
    $txtCmpFax=$_POST["txtCmpFax"];
    $txtCmpZip=$_POST["txtCmpZip"];
    $txtCmpAddr=$_POST["txtCmpAddr"];
    $txtCmpBank=$_POST["txtCmpBank"];
    $txtCmpAccount=$_POST["txtCmpAccount"];
    $txtCmpAccountNo=$_POST["txtCmpAccountNo"];
    $txtcity=$_POST["txtcity"];
    $chkUseChk=$_POST["chkUseChk"];
    $txtRemark=$_POST["txtRemark"];
    $hoteltype=$_POST["hoteltype"];
    $hotellevel=$_POST["hotellevel"];
    $linkpeople=$_POST["linkpeople"];
    $createpeople=$_SESSION["user"];
    
    $checkname= mysqli_query($con,"select  *from t_allhotel where hotelname='".$txtCmpName."'");
    if(mysqli_num_rows($checkname)<1){
        $sql="INSERT INTO t_allhotel(
hotelname,hotelcode,hotelleader,hotelphone,hoteltel,hotelfax,hoteladdress,hotelzipCode,
hotelbank,hotelbankNum,hotelbankAccount,hotelremark,hotelcityid,hotelisUse,createtime,hotelproperty,hotellevelid,linkpeople,createpeople
) VALUES
('".$txtCmpName."','".$txtCmpCode."','".$txtCmpManager."','".$txtCmpMobile."','".$txtCmpTel."','".$txtCmpFax."','".$txtCmpAddr."','".$txtCmpZip."',
'".$txtCmpBank."','".$txtCmpAccountNo."','".$txtCmpAccount."','".$txtRemark."','".$txtcity."','".$chkUseChk."',now(),
'".$hoteltype."','".$hotellevel."','".$linkpeople."','".$createpeople."'
)";
       
        mysqli_query($con,$sql);
        mysqli_close($con);
        echo "<script>alert('添加成功！');
            
            
</script>";
        
    }else{
        echo "<script>alert('已经存在相同酒店！');</script>";
        
    }
}
function chaxun(){
    
}
function shanchu(){
    require $_SESSION["ROOT"].'/db/db.php';
    $id=$_POST["id"];
    $res= mysqli_query($con,"delete from t_hotel where id='".$id."'");
    if (mysqli_affected_rows($res)!=0){
        echo "成功！";
    }
}
function edit(){
    require $_SESSION["ROOT"].'/db/db.php';
    $txtCmpName=$_POST["txtCmpName"];
    $txtCmpCode="";
    
        foreach (mbStrSplit($txtCmpName) as $code){
            $txtCmpCode.=getFirstCharter($code);
        }
    
    $txtCmpManager=$_POST["txtCmpManager"];
    $txtCmpMobile=$_POST["txtCmpMobile"];
    $txtCmpTel=$_POST["txtCmpTel"];
    $txtCmpFax=$_POST["txtCmpFax"];
    $txtCmpZip=$_POST["txtCmpZip"];
    $txtCmpAddr=$_POST["txtCmpAddr"];
    $txtCmpBank=$_POST["txtCmpBank"];
    $txtCmpAccount=$_POST["txtCmpAccount"];
    $txtCmpAccountNo=$_POST["txtCmpAccountNo"];
    $txtcity=$_POST["txtcity"];
    $hotellevel=$_POST["hotellevel"];
    if($_POST["chkUseChk"]!='on'){
        $chkUseChk="off";
    }else{
        $chkUseChk="on";
    }
    
    $txtRemark=$_POST["txtRemark"];
    $id=$_POST["id"];
    $checkname= mysqli_query($con,"update  t_allhotel set
hotelname='".$txtCmpName."',hotelcode='".$txtCmpCode."',hotelleader='".$txtCmpManager."',hotelphone='".$txtCmpMobile."',hoteltel='".$txtCmpTel."',
hotelfax='".$txtCmpFax."',hoteladdress='".$txtCmpAddr."',hotelzipCode='".$txtCmpZip."',
hotelbank='".$txtCmpBank."',hotelbankNum='".$txtCmpAccountNo."',hotelbankAccount='".$txtCmpAccount."',hotelremark='".$txtRemark."',
hotelcityid='".$txtcity."',hotelisUse='".$chkUseChk."',hotellevelid='".$hotellevel."'
 where id='".$id."'");
echo "<script>alert('修改成功！');</script>";
}
?>

<form id="pagerForm" method="post" action="zyzx/jdda.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="zyzx/jdda.php" method="post" >
	<div class="searchBar">
      <span>酒店名称</span>
        <input type="hidden" name="jdian111.id" value=""/>
				<input type="text" class="getjdian111" oninput="getjdian(111);" name="jdian111.jdian111" value="" suggestFields="jdian111"   lookupGroup="jdian111" />
				<a class="btnLook" style="float: right;" href="ajax/dh/jdian.php?id=111" lookupGroup="jdian111">选择酒店</a>
            <span>手机</span>
            <input name="txtCmpManagerMobile" type="text" ligerui="{width:80}"  /><br/>
            <span>电话</span>
            <input name="txtCmpTel" type="text" ligerui="{width:80}"  />
            <span>传真</span>
            <input name="txtCmpFax" type="text" ligerui="{width:80}"  />
            <span>负责人</span>
            <input name="txtCmpManager" type="text" ligerui="{width:80}"  />
      <span> 状态</span>
      <select id="dropUseChk" name="UseChk">
      <option value="on" >启用</option>
      <option value="off">停用</option>
      <option value="">全部</option>
      </select>
      <input name="search"  type="hidden" size="30" value="yes"/>
<button type="search">检索</button>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="zyzx/addjdda.php" target="dialog" mask="true" width="700" height="600"><span>添加</span></a></li>
			
		</ul>
	</div><script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
					<tr>
				<th align="center">序号</th>
				<th align="center">酒店编码</th>
				<th align="center">酒店名</th>
				<th align="center">负责人</th>
				<th align="center">手机</th>
				<th align="center">电话</th>
				<th align="center">传真</th>
				<th align="center">公司性质</th>
				<th align="center">级别</th>
				<th align="center">所在城市</th>
				<th align="center">录入人</th>
				<th align="center">录入时间</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 
			if(@$_POST["search"]==null){
			    $result=mysqli_query($con,"select * from t_allhotel" );
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_allhotel  limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}else {
			    $sql="";
			    
			    $sql.=$_POST["jdian111_id"]!=""?" and id= '".$_POST["jdian111_id"]."'":"";
			    $sql.=$_POST["txtCmpManagerMobile"]!=""?" and hotelphone like '%".$_POST["txtCmpManagerMobile"]."%'":"";
			    $sql.=$_POST["txtCmpTel"]!=""?" and hoteltel like '%".$_POST["txtCmpTel"]."%'":"";
			    $sql.=$_POST["txtCmpFax"]!=""?" and hotelfax like '%".$_POST["txtCmpFax"]."%'":"";
			    $sql.=$_POST["txtCmpManager"]!=""?" and hotelleader like '%".$_POST["txtCmpManager"]."%'":"";
			    $sql.=$_POST["UseChk"]!=""?" and hotelisUse='".$_POST["UseChk"]."'":"";
			    $result=mysqli_query($con,"select * from t_allhotel where 1=1 ".$sql );
			    // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			    //echo $sql;
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_allhotel where 1=1 ".$sql." limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}
			for($a=0;$a<count($resultnowarray);$a++){
			    $getlv=mysqli_query($con, "select basetype  from t_baseconfig where id=".$resultnowarray[$a]['hotellevelid']);
			    $lv=mysqli_fetch_array($getlv);
			    echo "<tr >
			<td >".($a+1)."
			</td><td >
			".$resultnowarray[$a]['hotelcode']."</td>
<td >".$resultnowarray[$a]['hotelname']."
			</td><td >".$resultnowarray[$a]['hotelleader']."
			</td><td >".$resultnowarray[$a]['hotelphone']."
			</td><td  >".$resultnowarray[$a]['hoteltel']."
			</td><td >".$resultnowarray[$a]['hotelfax']."
</td><td >".$resultnowarray[$a]['hotelproperty']."
</td><td >".$lv["basetype"]."
			</td><td >".$resultnowarray[$a]['hotelcityid']."
</td><td >".$resultnowarray[$a]['createpeople']."
			</td><td >".$resultnowarray[$a]['createtime']."
			</td><td >
			<a href='zyzx/editjdda.php?id=".$resultnowarray[$a]['id']."' class='btnView' id=''target='dialog' mask='true' width='700' height='600' style='color:blue;'>查看</a>
 <a href='zyzx/jdda.php?id=".$resultnowarray[$a]['id']."&action=delete' class='btnDel' id='' target='navTab' rel='jdda' style='color:blue;'    >删除</a> 
<a href='zyzx/editjdda.php?id=".$resultnowarray[$a]['id']."' class='btnEdit' id=''target='dialog' mask='true' width='700' height='600' style='color:blue;'>修改</a></td></tr>";
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