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
    require $_SESSION["ROOT"].'/db/db.php';
    $txtCmpName=$_POST["txtCmpName"];
    $txtCmpCode="";
    
    foreach (mbStrSplit($txtCmpName) as $code){
        $txtCmpCode.=getFirstCharter($code);
    }
    $traveltype=@$_POST["traveltype"];
    $linkpeople=$_POST["linkpeople"];
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
    $createpeople=$_SESSION["user"];
    if(@$_POST["chkUseChk"]!='on'){
        $chkUseChk="off";
    }else{
        $chkUseChk="on";
    }
    
    $txtRemark=$_POST["txtRemark"];
    $checkname= mysqli_query($con,"select  *from t_travel where travel_name='".$txtCmpName."'");
    if(mysqli_num_rows($checkname)<1){
        $sql="INSERT INTO t_travel(
travel_name,travel_code,travel_type_id,linkpeople,travel_leader,travel_phone,travel_tel,travel_fax,
travel_zipCode,travel_address,travel_bank,travel_bankAccount,travel_bankNum,travel_city_id,travel_isUse,travel_remark,creattime,createpeople
) VALUES
('".$txtCmpName."','".$txtCmpCode."','".$traveltype."','".$linkpeople."','".$txtCmpManager."','".$txtCmpMobile."','".$txtCmpTel."',
'".$txtCmpFax."','".$txtCmpZip."','".$txtCmpAddr."',
'".$txtCmpBank."','".$txtCmpAccount."','".$txtCmpAccountNo."','".$txtcity."','".$chkUseChk."','".$txtRemark."',now(),'".$createpeople."'
)";
        mysqli_query($con,$sql);
        $id = mysqli_insert_id($con);
      
        echo "<script>alert('添加成功！');
</script>";
        
    }else{
        echo "<script>alert('已经存在相同旅行社！');</script>";
        
    }
    $username=$_POST["username"];
    $phone=$_POST["phone"];
    $tel=$_POST["tel"];
    $fax=$_POST["fax"];
    $qq=$_POST["qq"];
    $duty=$_POST["duty"];
    foreach ($username as $a=>$name){
        mysqli_query($con, "insert into t_linkman(name,tel,phone,fax,department,qq,travel_id)
values('".$username[$a]."','".$tel[$a]."','".$phone[$a]."','".$fax[$a]."','".$duty[$a]."','".$qq[$a]."','".$id."')");
   
    }
   
    mysqli_close($con);
}
function edit(){
    require $_SESSION["ROOT"].'/db/db.php';
    $txtCmpName=$_POST["txtCmpName"];
    $txtCmpCode="";
    
    foreach (mbStrSplit($txtCmpName) as $code){
        $txtCmpCode.=getFirstCharter($code);
    }
    
    
    $linkpeople=$_POST["linkpeople"];
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
    $createpeople=$_SESSION["user"];
    if(@$_POST["chkUseChk"]!='on'){
        $chkUseChk="off";
    }else{
        $chkUseChk="on";
    }
    
    $txtRemark=$_POST["txtRemark"];
    $id=$_GET["id"];
    $checkname= mysqli_query($con,"update  t_travel set 
        travel_name='".$txtCmpName."',travel_code='".$txtCmpCode."',linkpeople='".$linkpeople."',travel_leader='".$txtCmpManager."'
,travel_phone='".$txtCmpMobile."',travel_tel='".$txtCmpTel."',travel_fax='".$txtCmpFax."',
        travel_zipCode='".$txtCmpZip."',travel_address='".$txtCmpAddr."',travel_bank='".$txtCmpBank."',travel_bankAccount='".$txtCmpAccount."'
,travel_bankNum='".$txtCmpAccountNo."',travel_city_id='".$txtcity."',travel_isUse='".$chkUseChk."',travel_remark='".$txtRemark."' where id=
        ".$id);
    $linkid=$_POST["id"];
    $username=$_POST["username"];
    $phone=$_POST["phone"];
    $tel=$_POST["tel"];
    $fax=$_POST["fax"];
    $qq=$_POST["qq"];
    $duty=$_POST["duty"];
  
    foreach ($username as $a=>$name){
        if($linkid[$a]!=""){
            mysqli_query($con, "update t_linkman set name='".$username[$a]."',tel='".$tel[$a]."',phone='".$phone[$a]."',
fax='".$fax[$a]."',department='".$duty[$a]."',qq='".$qq[$a]."',travel_id='".$id."' where id=".$linkid[$a]);
        }else{
        mysqli_query($con, "insert into t_linkman(name,tel,phone,fax,department,qq,travel_id)
values('".$username[$a]."','".$tel[$a]."','".$phone[$a]."','".$fax[$a]."','".$duty[$a]."','".$qq[$a]."','".$id."')");
        
    }
    }
    echo "<script>alert('修改成功！');</script>";
}
function shanchu(){
    require $_SESSION["ROOT"].'/db/db.php';
    $id=$_GET["id"];
    mysqli_query($con, "delete from t_travel where id=".$id);
}
?>
<script type="text/javascript" src="ajax/js/main.js"></script>

<form id="pagerForm" method="post" action="zyzx/khda.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="zyzx/khda.php" method="post" >
	<div class="searchBar">
      <span>旅行社名称</span>
       <input type="hidden" name="zts.id" class="gettravle" value=""/>
				<input type="text" class="required getzts" name="zts.zts" value="" suggestFields="zts"   lookupGroup="zts" />
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
			<li><a class="add" href="zyzx/addkhda.php" target="dialog" mask="true" width="700" height="600"><span>添加</span></a></li>
		</ul>
	</div><script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">旅行社</th>
				<th align="center">负责人</th>
				<th align="center">手机</th>
				<th align="center">电话</th>
				<th align="center">传真</th>
				<th align="center">公司性质</th>
<!-- 				<th align="center">销售</th> -->
				<th align="center">所在城市</th>
				<th align="center">录入人</th>
				<th align="center">录入时间</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 
			if(@$_POST["search"]==null){
			    $result=mysqli_query($con,"select * from t_travel" );
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_travel  limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}else {
			    $sql="";
			    
			    $sql.=$_POST["zts_id"]!=""?" and id='".$_POST["zts_id"]."'":"";
			    $sql.=$_POST["txtCmpManagerMobile"]!=""?" and travel_phone like '%".$_POST["txtCmpManagerMobile"]."%'":"";
			    $sql.=$_POST["txtCmpTel"]!=""?" and travel_tel like '%".$_POST["txtCmpTel"]."%'":"";
			    $sql.=$_POST["txtCmpFax"]!=""?" and travel_fax like '%".$_POST["txtCmpFax"]."%'":"";
			    $sql.=$_POST["txtCmpManager"]!=""?" and travel_leader like '%".$_POST["txtCmpManager"]."%'":"";
			    $sql.=$_POST["UseChk"]!=""?" and travel_isUse='".$_POST["UseChk"]."'":"";
			    $result=mysqli_query($con,"select * from t_travel where 1=1 ".$sql );
			    // echo "select * from t_groupmanage where 1=1 ".$sql.isset($_POST["zts_id"]);
			    //echo $sql;
			    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			    //分页显示
			    $resultnum=count($resultarray);
			    @$page=ceil($resultnum/$numPerPage);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnow=mysqli_query($con,"select * from t_travel where 1=1 ".$sql." limit ".$sr.",".$numPerPage );
			    $resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			}
			
			for($a=0;$a<count($resultnowarray);$a++){
			    
			?>
			  <tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php echo $resultnowarray[$a]['travel_name'];?>
            </td><td ><?php echo $resultnowarray[$a]['travel_leader'];?>
            </td><td ><?php echo $resultnowarray[$a]['travel_phone'];?>
            </td><td ><?php echo $resultnowarray[$a]['travel_tel'];?>
            </td><td ><?php echo $resultnowarray[$a]['travel_fax'];?>
            </td><td ><?php echo $resultnowarray[$a]['travel_type_id'];?>
            </td><td ><?php echo $resultnowarray[$a]['travel_city_id'];?>
            </td><td ><?php echo $resultnowarray[$a]['createpeople'];?>
            </td><td ><?php echo $resultnowarray[$a]['creattime'];?>
			</td><td  >
			<a href='zyzx/showkhda.php?id=<?php echo$resultnowarray[$a]['id'];?>' class='btnView' id=''target='dialog' mask='true' width='700' height='600' style='color:blue;'>查看</a>
			<a href='zyzx/editkhda.php?id=<?php echo$resultnowarray[$a]['id'];?>' class='btnEdit' id=''target='dialog' mask='true' width='700' height='600' style='color:blue;'>修改</a>
			<a href='zyzx/khda.php?id=<?php echo$resultnowarray[$a]['id'];?>&action=delete' class='btnDel' id='' target="navTab" rel="khda" style='color:blue;'>删除</a>
</td></tr>
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