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
			<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
	<input name="search"  type="hidden" size="30" value="yes"/>
	<div class="searchBar">
	
		<table class="searchContent">
			<tr>
				
				
			<td class="dateRange">
					收款日期:
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
					收款人:
<?php require R.'temp/search/user.php';?>
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
			
				<td><div class="buttonActive"><div class="buttonContent"><button type="submit">搜索</button></div></div></td>
			</tr>
		</table>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="cwgl/addadwsk.php<?php echo "?J=".$_GET["J"];?>" target="dialog" max="true" mask="true" rel="addadwsk"><span>添加</span></a></li>
		</ul>
</div>
	<table class="table" width="100%" layoutH="158" style="word-break:break-all; word-wrap:break-all;">
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
			$xje=0.00;

			$xye=0.00;
			    $sql="";
			if(isset($_POST["search"])){
			    
			    if($_POST["startDate"]!=""){
			        $startdate=$_POST["startDate"];
			        $enddate=$_POST["endDate"]!=""?$_POST["endDate"]:date("Y-m-d",time());
			        $sql.=" and dodate between '".$startdate."' and '".$enddate."'";
			    }
			    $sql.=$_POST["zts_id"]!=""?" and travel='".$_POST["zts_id"]."'":"";
			    $sql.=$_POST["gdmonth"]!=""?" and gddate='".$_POST["gdmonth"]."'":"";
			    $sql.=$_POST["remark"]!=""?" and remark like '%".$_POST["remark"]."%'":"";
			    if($J->type($jur, "range")=="person"){
			        $sql.=" and a.dopeople='".$_COOKIE["userid"]."'";
			    }else{
			        $sql.=$_POST["jd_id"]!=""?" and dopeople='".$_POST["jd_id"]."'":"";
			    }
			    if($J->type($jur, "range")=="department"){
			        $sql.=" and b.dept='".$usermsg["deptid"]."'";
			    }else if($J->type($jur, "range")=="company"){
			        $sql.=" and b.hotel='".$usermsg["hotelid"]."'";
			    }
			    //$sql.=$_POST["groupnum"]!=""?" and teamNumber like '%".$_POST["groupnum"]."%'":"";
			}else{
			    $sql.=" and a.dodate between '".$firstday."' and '".$lastday."'";
			    //权限范围
			    if($J->type($jur, "range")=="person"){
			        $sql.=" and a.dopeople='".$_COOKIE["userid"]."'";
			    }else if($J->type($jur, "range")=="department"){
			        $sql.=" and b.dept='".$usermsg["deptid"]."'";
			    }else if($J->type($jur, "range")=="company"){
			        $sql.=" and b.hotel='".$usermsg["hotelid"]."'";
			    }
			    //
			}
			$table="t_sktravel as a right join t_user as b on a.dopeople=b.id ";
			$data="*,a.id as id";
			$where="travel is not null ".$sql." order by a.dodate desc";
			$result=$db->tabledata($pageNum,$numPerPage,$table,$data,$where,"a.id");
			//合计
    			$data="sum(a.money) as money,sum(a.mhaving) as mhaving";
    			$countall=$db->select($table, $data, $where)[0];
    			$allmoney=$countall["money"];
    			$allpayedmoney=$countall["mhaving"];
    			
			$resultnum=$result["amount"];
			$resultnowarray=$result["result"];
			$allpaytype=$db->select("t_baseconfig","*","1=1");
			for($a=0;$a<count($resultnowarray);$a++){
			    $xje+=$resultnowarray[$a]['money'];
			    $xye+=$resultnowarray[$a]['mhaving'];
			    
			    $jd=$base->getdata("user", $resultnowarray[$a]['dopeople']);
			    $zts=$base->getdata("travel", $resultnowarray[$a]['travel']);
			?>
			  <tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php 
			echo $zts['travel_name'];
			?>
            </td><td ><?php echo $resultnowarray[$a]['dodate'];?>
            </td><td ><?php echo $resultnowarray[$a]['gddate'];?>月
            </td><td ><?php 
            foreach ($allpaytype as $p){
                if($p["id"]==$resultnowarray[$a]['paytype']){
                    echo $p["basetype"];
                }
            }
            ?>
            </td><td ><?php echo $resultnowarray[$a]['invoice'];?>
            </td><td ><?php echo $resultnowarray[$a]['money'];?>
            </td><td ><?php echo $resultnowarray[$a]['money']-$resultnowarray[$a]['mhaving'];?>
            </td><td ><?php echo $resultnowarray[$a]['mhaving'];?>
            </td><td ><?php 
            echo $jd["username"];
            ?>
            </td><td  style="word-break:break-all; word-wrap:break-all; width:300px;"><?php echo $resultnowarray[$a]['remark'];?>
			</td><td  >
			<a href='cwgl/editadwsk.php?id=<?php echo$resultnowarray[$a]['id'];?>' class='btnEdit' id='' target="dialog" max="true" mask="true" rel="editadwsk" style='color:blue;'>修改</a>
</td></tr>
<?php			
}
 
    ?>
    	
   			 <tr class="tfoot">
				<th align="center">小计</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th> 
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $xje;?></th>
				<th align="center"><?php echo $xje-$xye;?></th>
				<th align="center"><?php echo $xye;?></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
			</tr>
			 <tr class="tfoot">
				<th align="center">总计</th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th> 
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"><?php echo $allmoney;?></th>
				<th align="center"><?php echo $allmoney-$allpayedmoney;?></th>
				<th align="center"><?php echo $allpayedmoney;?></th>
				<th align="center"></th>
				<th align="center"></th>
				<th align="center"></th>
			</tr>
		</tbody>
    	
	</table>
	
<?php require R.'temp/table/default_footer.php';?>
</div>