<?php
//base start
require "../../hzb/config.php";
require R.'hzb/inc/load.php';
//base end

if(isset($_POST["numPerPage"])){
    $numPerPage=$_POST["numPerPage"];
    $pageNum=$_POST["pageNum"];
}
if (isset($_GET["type"])&&$_GET["type"]=="add"){
    $back="addhotel";
}else{
    $back="hotel";
}
?>




<div class="pageHeader">
	<form onsubmit="return dwzSearch(this, 'dialog');" id="pagerForm" action="ajax/dh/hotel.php" method="post" >
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
	<table class="table" width="100%" layoutH="108" style="word-break:break-all; word-wrap:break-all;">
		<thead>
					<tr>
				<th align="center">序号</th>
				<th align="center">酒店名</th>
				<th align="center">负责人</th>
				<th align="center">手机</th>
				<th align="center">电话</th>
				<th align="center">传真</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody id="datacontent" >
		<?php 

			    $resultarray=$base->data("hotel");
			    if (isset($_POST["txtCmpName"])&&$_POST["txtCmpName"]!=""){
			        $resultarray=search($resultarray,$_POST["txtCmpName"]);
			    }
			    $resultnum=count($resultarray);
			    @$sr=($pageNum-1)*$numPerPage;
			    $resultnowarray=array_slice($resultarray,$sr,$numPerPage);
		
			for($a=0;$a<count($resultnowarray);$a++){
			    echo "<tr >
			<td >".($a+1)."
			</td>
<td >".$resultnowarray[$a]['hotelname']."
			</td><td >".$resultnowarray[$a]['hotelleader']."
			</td><td >".$resultnowarray[$a]['hotelphone']."
			</td><td  >".$resultnowarray[$a]['hoteltel']."
			</td><td >".$resultnowarray[$a]['hotelfax']."

			</td><td >";
			    ?>
			   
			<a class="btnSelect" href="javascript:$.bringBack({id:'<?php echo $resultnowarray[$a]['id'];?>', <?php echo $back;?>:'<?php echo $resultnowarray[$a]['hotelname'];?>'})" title="查找带回">选择</a></td>
	<?php }
 
    ?>
		</tbody>
	</table>
	

<?php require R.'temp/table/dialog_footer.php';?>
</div>