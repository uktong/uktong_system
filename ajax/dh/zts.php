<?php
//base start
require "../../hzb/config.php";
require R.'hzb/inc/load.php';
//base end


if(isset($_POST["numPerPage"])){
    $numPerPage=$_POST["numPerPage"];
    $pageNum=$_POST["pageNum"];
}
?>



<div class="pageHeader">
	<form onsubmit="return dwzSearch(this, 'dialog');" id="pagerForm"  action="ajax/dh/zts.php" method="post" >
		<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
	<div class="searchBar">
      <span>关键字</span>

        <input id="txtCmpName" name="txtCmpName" type="text" value="<?php
					echo  isset($_POST["txtCmpName"])?$_POST["txtCmpName"]:'';?>"/>
<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="search">检索</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<table class="table" width="100%" layoutH="100" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">公司名</th>
				<th align="center">助记码</th>
				<th align="center">负责人</th>
				<th align="center">手机</th>
				<th align="center">电话</th>
				<th align="center">传真</th>
				<th align="center">录入人</th>
				<th align="center">录入时间</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
			<?php 

			    $resultarray=$base->data("travel");
			    if (isset($_POST["txtCmpName"])&&$_POST["txtCmpName"]!=""){
			        $resultarray=search($resultarray,$_POST["txtCmpName"]);
			    }
			    $resultnum=count($resultarray);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnowarray=array_slice($resultarray,$sr,$numPerPage);
			for($a=0;$a<count($resultnowarray);$a++){
			    
			?>
			  <tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php echo $resultnowarray[$a]['travel_name'];?>
			</td><td ><?php echo $resultnowarray[$a]['travel_code'];?>
            </td><td ><?php echo $resultnowarray[$a]['travel_leader'];?>
            </td><td ><?php echo $resultnowarray[$a]['travel_phone'];?>
            </td><td ><?php echo $resultnowarray[$a]['travel_tel'];?>
            </td><td ><?php echo $resultnowarray[$a]['travel_fax'];?>
            </td><td ><?php echo $resultnowarray[$a]['createpeople'];?>
            </td><td ><?php echo $resultnowarray[$a]['creattime'];?>
			</td><td >
			<a class="btnSelect" href="javascript:$.bringBack({id:'<?php echo $resultnowarray[$a]['id'];?>', zts:'<?php echo $resultnowarray[$a]['travel_name'];?>'})" title="选择">选择</a></td>
<?php			
}
    ?>
		</tbody>
	</table>

<?php require R.'temp/table/dialog_footer.php';?>
</div>