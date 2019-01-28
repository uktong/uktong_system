<?php
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end

if(isset($_POST["numPerPage"])){
    $numPerPage=$_POST["numPerPage"];
    $pageNum=$_POST["pageNum"];
}
$kmid=$_GET["km"];
?>

<form id="pagerForm" method="post" onsubmit="return divSearch(this, 'jcsjbox');" action="jcsj/jcsjlr.php?km=<?php echo $kmid; ?>">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
</form>


<div class="pageContent">
<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="jcsj/addjcsj.php?id=<?php echo $kmid."&J=".$_GET["J"];?>" target="dialog" mask="true" title="录入基础数据" width="600" height="230"><span>添加</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="108" style="word-break:break-all; word-wrap:break-all;">
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">项目</th>
				<th align="center">项目编码</th>
				<th align="center">备注</th>
				<th align="center">操作</th>
			</tr>
		</thead>
		<tbody>
			
			 <?php 
			 
			 
			     
			     $result=$db->tabledata($pageNum,$numPerPage,"t_baseconfig","*","basenote=".$kmid." order by px DESC","id");
			     $resultnum=$result["amount"];
			     $resultnowarray=$result["result"];
			
			for($a=0;$a<count($resultnowarray);$a++){
			   
			    
			    //查询项目表
			   
			    ?>
<tr  >
			<td ><?php echo ($a+1);?>
			</td><td ><?php echo $resultnowarray[$a]['basetype'];?>
            </td><td ><?php 

            echo $resultnowarray[$a]["basecode"];
            ?>
			</td><td  ><?php echo $resultnowarray[$a]['remark'];?>
			</td><td  >
			<a href='jcsj/editjcsj.php?id=<?php echo $resultnowarray[$a]['id']."&J=".$_GET["J"];?>' mask="true" class='show' id='' target='dialog' width="600" height="230" title='修改信息' style='color:blue;'>编辑</a> 
			<a href='db/delete.php?id=<?php echo $resultnowarray[$a]['id']."&J=".$_GET["J"];?>&action=jcsj' title='确定要删除吗?' target='ajaxTodo'  style='color:blue;'>删除</a>
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
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value},'jcsjbox')">
		
				<option value="20" <?php if($numPerPage==20){echo "selected='selected'";}?>>20</option>
				<option value="50"<?php if($numPerPage==50){echo "selected='selected'";}?>>50</option>
				<option value="100"<?php if($numPerPage==100){echo "selected='selected'";}?>>100</option>
				<option value="150"<?php if($numPerPage==150){echo "selected='selected'";}?>>150</option>
				<option value="200"<?php if($numPerPage==200){echo "selected='selected'";}?>>200</option>
				<option value="250"<?php if($numPerPage==250){echo "selected='selected'";}?>>250</option>
			</select>
			<span>条，共<?php echo $resultnum; ?>条</span>
		</div>

		<div class="pagination" targetType="jcsjbox" totalCount="<?php echo $resultnum; ?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>

	</div>
</div>