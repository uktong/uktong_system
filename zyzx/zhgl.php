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
    case "zz":
        zz();
        break;
    case "tz":
        tz();
        break;
}
function charu(){
    require $_SESSION["ROOT"].'/db/db.php';
    $txtCmpName=$_POST["txtCmpName"];

    $txtCmpAccount=$_POST["txtCmpAccount"];
    $txtCmpAccountNo=$_POST["txtCmpAccountNo"];
    $money=$_POST["money"];
    $txtRemark=$_POST["txtRemark"];
    $createpeople=$_SESSION["user"];
    
        $sql="INSERT INTO t_account(
accountTitle,bankName,accountNumber,money,remark) VALUES
('".$txtCmpName."','".$txtCmpAccount."','".$txtCmpAccountNo."','".$money."','".$txtRemark."'
)";
        mysqli_query($con,$sql);
        mysqli_close($con);

}
function edit(){
    require $_SESSION["ROOT"].'/db/db.php';
    $txtCmpName=$_POST["txtCmpName"];
    
    $txtCmpAccount=$_POST["txtCmpAccount"];
    $txtCmpAccountNo=$_POST["txtCmpAccountNo"];
    $txtRemark=$_POST["txtRemark"];
    $createpeople=$_SESSION["user"];
    
    $sql="update t_account set
accountTitle='".$txtCmpName."',bankName='".$txtCmpAccount."',accountNumber='".$txtCmpAccountNo."',remark='".$txtRemark."' where id=".$_GET["id"];
    mysqli_query($con,$sql);
    mysqli_close($con);
}
function shanchu(){
    require $_SESSION["ROOT"].'/db/db.php';
    $id=$_GET["id"];
    mysqli_query($con, "delete from t_account where id=".$id);
    mysqli_close($con);
}
function zz(){
    require $_SESSION["ROOT"].'/db/db.php';
    $changeDate=$_POST["changeDate"];
    
    $guid=$_POST["guid"];
    $oguid=$_POST["guid"]=="in"?"out":"in";
    $changemoney=$_POST["changemoney"];
    $txtRemark=$_POST["txtRemark"];
    $account=$_POST["account"];
    $createpeople=$_SESSION["user"];
    $id=$_GET["id"];
    $inorout=$guid=="in"?"min":"mout";
    $oinorout=$guid=="in"?"mout":"min";
    $upordown=$guid=="in"?"+":"-";
    $oupordown=$guid=="in"?"-":"+";
    mysqli_query($con, "insert into t_moneychange(accountid,km,".$inorout.",dotime,douser,changetype,remark)values('".$id."',
'账户调账','".$changemoney."','".$changeDate."','".$createpeople."','".$guid."','".$txtRemark."')");
    mysqli_query($con, "insert into t_moneychange(accountid,km,".$oinorout.",dotime,douser,changetype,remark)values('".$account."',
'账户调账','".$changemoney."','".$changeDate."','".$createpeople."','".$oguid."','".$txtRemark."')");
    mysqli_query($con, "update t_account set money=money".$upordown.$changemoney." where id= ".$id);
    mysqli_query($con, "update t_account set money=money".$oupordown.$changemoney." where id= ".$account);
    mysqli_close($con);
}
function tz(){
    require $_SESSION["ROOT"].'/db/db.php';
    $changeDate=$_POST["changeDate"];
    
    $guid=$_POST["guid"];
    $changemoney=$_POST["changemoney"];
    $txtRemark=$_POST["txtRemark"];
    $createpeople=$_SESSION["user"];
    $id=$_GET["id"];
    $inorout=$guid=="in"?"min":"mout";
    $upordown=$guid=="in"?"+":"-";
    mysqli_query($con, "insert into t_moneychange(accountid,km,".$inorout.",dotime,douser,changetype,remark)values('".$id."',
'账户调账','".$changemoney."','".$changeDate."','".$createpeople."','".$guid."','".$txtRemark."')");
    mysqli_query($con, "update t_account set money=money".$upordown.$changemoney." where id= ".$id);
    mysqli_close($con);
}
?>

<form id="pagerForm" method="post" action="zyzx/zhgl.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>



<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="zyzx/addzhgl.php" target="dialog" mask="true" width="700" height="600"><span>添加</span></a></li>
			
	</ul>
	</div><script src="ajax/gsxx/gsxx.js"></script>
	<table class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">账户名称</th>
				<th align="center">银行名称</th>
				<th align="center">账号</th>
				<th align="center">金额</th>
				<th align="center">备注</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 
			require_once $_SESSION["ROOT"].'/db/db.php';
			$result=mysqli_query($con,"select * from t_account" );
			$resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			//分页显示
			$resultnum=count($resultarray);
			@$page=ceil($resultnum/$numPerPage);
			@$sr=($pageNum-1)*$numPerPage;
			@$er=$pageNum*$numPerPage;
			$resultnow=mysqli_query($con,"select * from t_account limit ".$sr.",".$er );
			$resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
			for($a=0;$a<count($resultnowarray);$a++){
			    
			    ?>
			  <tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php echo $resultnowarray[$a]['accountTitle'];?>
            </td><td ><?php echo $resultnowarray[$a]['bankName'];?>
            </td><td ><?php echo $resultnowarray[$a]['accountNumber'];?>
            </td><td ><?php echo $resultnowarray[$a]['money'];?>
            </td><td ><?php echo $resultnowarray[$a]['remark'];?>
			</td><td  >
			<a href='zyzx/showzhgl.php?id=<?php echo$resultnowarray[$a]['id'];?>' class='btnView' id=''target='dialog' mask='true' width='700' height='600' style='color:blue;'>查看</a>
			
			<a href='zyzx/editzhgl.php?id=<?php echo$resultnowarray[$a]['id'];?>' class='btnEdit' id=''target='dialog' mask='true' width='700' height='600' style='color:blue;'>修改</a>
			<a href='zyzx/zhgl.php?id=<?php echo$resultnowarray[$a]['id'];?>&action=delete' class='btnDel' id='' target="navTab" rel="zhgl" style='color:blue;'>删除</a>
			<a href='zyzx/zhtz.php?id=<?php echo$resultnowarray[$a]['id'];?>' target='dialog' mask='true' rel="zhtz" width="550" height="220" style='color:blue;'>调账</a>
			<a href='zyzx/zhzz.php?id=<?php echo$resultnowarray[$a]['id'];?>' target='dialog' mask='true' rel="zhzz" width="550" height="250" style='color:blue;'>转账</a>
</td></tr><?php			
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