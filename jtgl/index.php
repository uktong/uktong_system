<?php 
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end

//getpageJur

$jur=$base->getJur(md5($_COOKIE["username"]),"name",$_GET["J"]);
$usermsg=$base->data(md5($_COOKIE["username"]))[0];

if(isset($_POST["numPerPage"])){
    $numPerPage=$_POST["numPerPage"];
    $pageNum=$_POST["pageNum"];
}

?>
<script type="text/javascript" src="ajax/js/main.js">
</script>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" id="pagerForm" action="<?php echo $jur["url"]."?J=".$_GET["J"]; ?>" method="post" >
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
				
				<td class="dateRange">
					按录单日期:
						<input name="startDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$firstday;?>">
					<span class="limit">-</span>
					<input name="endDate" class="date readonly" readonly="readonly" type="text" value="<?php echo isset($_POST["endDate"])?$_POST["endDate"]:$lastday;?>">
				</td>
				<td >
					组团社:
				<?php require R.'temp/search/zts.php';?>
				</td>
				<td >
					计调:
				<?php require R.'temp/search/user.php';?>
				</td>
				<td >
					团号:
					<input name="groupnum"  type="text"  class="textInput" size="30" value="<?php
					echo  isset($_POST["groupnum"])?$_POST["groupnum"]:'';?>" />
				</td>
				<td><div class="buttonActive"><div class="buttonContent"><button type="submit">搜索</button></div></div></td>
			</tr>
		</table>
		<input name="search"  type="hidden" size="30" value="yes"/>
		<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
		
	</div>
	</form>
</div>
<div class="pageContent">

	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="jtgl/add.php<?php echo "?J=".$_GET["J"];?>" target="navTab" rel="add"><span>添加</span></a></li>
		</ul>
	</div>

	<table class="table" width="100%" layoutH="128" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">我社团号</th>
				<th align="center">发团日期</th>
				<th align="center">代定项目</th>
				<th align="center">计调</th>
				<th align="center">录单时间</th>
				<th align="center">组团社</th>
				<th align="center" width="300">客人</th>
				<th align="center">最后修改时间</th>
				<th align="center">最后修改人</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody>
			 <?php 
			 $sql="";
			 if(isset($_POST["search"])){
			    
			     if($_POST["startDate"]!=""){
			         $startdate=$_POST["startDate"];
			         $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			         $sql.=" and enteringDate between '".$startdate."' and '".$enddate."'";
			     }
			     $sql.=$_POST["zts_id"]!=""?" and groupName='".$_POST["zts_id"]."'":"";
			     if($J->type($jur, "range")=="person"){
			         $sql.=" and a.jd='".$_COOKIE["userid"]."'";
			     }else{
			         $sql.=$_POST["jd_id"]!=""?" and jd='".$_POST["jd_id"]."'":"";
			     }
			      if($J->type($jur, "range")=="department"){
			         $sql.=" and b.dept='".$usermsg["deptid"]."'";
			     }else if($J->type($jur, "range")=="company"){
			         $sql.=" and b.hotel='".$usermsg["hotelid"]."'";
			     }
			     $sql.=$_POST["groupnum"]!=""?" and teamNumber like '%".$_POST["groupnum"]."%'":"";
			 }else{
			     $sql.=" and a.enteringDate between '".$firstday."' and '".$lastday."'";
			     //权限范围
			     if($J->type($jur, "range")=="person"){
			         $sql.=" and a.jd='".$_COOKIE["userid"]."'";
			     }else if($J->type($jur, "range")=="department"){
			         $sql.=" and b.dept='".$usermsg["deptid"]."'";
			     }else if($J->type($jur, "range")=="company"){
			         $sql.=" and b.hotel='".$usermsg["hotelid"]."'";
			     }
			     //
			 }
			     $result=$db->tabledata($pageNum,$numPerPage,"t_groupmanage as a right join t_user as b on a.jd=b.id ","*,a.id as id","a.hotelManage='代订酒店' ".$sql." order by a.enteringDate desc","a.id");
			     $resultnum=$result["amount"];
			     $resultnowarray=$result["result"];
			for($a=0;$a<count($resultnowarray);$a++){
			    if($resultnowarray[$a]['orderstates']=="yes"){
			        
			        $orderstates="<span style='color:green;'>确认</span>";
			    }else{
			        $orderstates="<span style='color:red;'>未确认</span>";
			    }
			  
			    $jd=$base->getdata("user", $resultnowarray[$a]['jd']);
			    $zts=$base->getdata("travel", $resultnowarray[$a]['groupName']);
			        echo "<tr  >
			<td >".($a+1)."
			</td><td >".$resultnowarray[$a]['teamNumber']."
            </td><td >".$resultnowarray[$a]['startDate']."
			</td><td  >".$resultnowarray[$a]['hotelManage']."
			</td><td  >".$jd['username']."
			</td><td  >".$resultnowarray[$a]['enteringDate']."
			</td><td  >".$zts['travel_name']."
			</td><td >".$resultnowarray[$a]['guest']."
</td><td >".$resultnowarray[$a]['updateDate']."
</td><td >".$resultnowarray[$a]['updatePeople']."
			</td><td  >";
			        
			        echo "
<a href='jtgl/showorder.php?id=".$resultnowarray[$a]['id']."' class='edit' target='navtab' title='查看".$resultnowarray[$a]['id']."'  style='color:blue;'>查看</a>

<a href='jtgl/editorder.php?id=".$resultnowarray[$a]['id']."&J=".$_GET["J"]."' class='edit' target='navtab' title='修改".$resultnowarray[$a]['id']."' rel='editddxm'  style='color:blue;'>编辑</a>
<a style='color:blue;' href='db/delete.php?action=ddxm&id=".$resultnowarray[$a]['id']."&J=".$_GET["J"]."' title='确定要删除吗?' target='ajaxTodo'     >删除</a>
</td></tr>";
			        }
			    
			
 
    ?>
		</tbody>
	</table>
<?php require R.'temp/table/default_footer.php';?>
</div>