 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
<?php 
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end
require R.'hzb/class/Jurisdiction.class.php';




?>

<script type="text/javascript">

</script>
 <form  onsubmit="return validateCallback(this,navTabAjaxDone);" class="pageForm" action="action/sqgl.php" method="post"  enctype="multipart/form-data">

           <table class="table" width="800" layoutH="78" style="word-break:break-all; word-wrap:break-all;" >
         
		<thead>
			<tr>
				<th align="center">权限ID</th>
				<th align="center">权限名称</th>
				<th align="center">权限编码</th>
				<th align="center">url</th>
				<th align="center">排序</th>
				<th align="center">操作</th>
				
			</tr>
		</thead>
		<tbody>
		<?php 
		$allqx=$db->select("t_travelpermission", "*", "1=1 order by sort");
		$Jurobj=new Jurisdiction($allqx);
		$str="";
		foreach ($allqx as $a){
		    $str.=$a["id"].",0,0,0,0,99,0|";
		}
		$Jur=$Jurobj->Jresult(substr($str,0,strlen($str)-1));
		$Jurlist=array();
		foreach ($Jur as $a){
		    if ($a["lastid"]==0){
		        $oneJur=$a;
		        $son=array();
		        foreach ($Jur as $b){
		            if($b["lastid"]==$a["id"]){
		                array_push($son, $b);
		                $oneJur["son"]=$son;
		            }
		        }
		        array_push($Jurlist, $oneJur);
		    }
		}

		for ($a=0;$a<count($Jurlist);$a++){
		    
		?>
			<tr >
				<td align="center"><?php echo $Jurlist[$a]["id"];?></td>
				
				<td style="text-align: left;">
				<?php echo $Jurlist[$a]["comment"];?>
			
				</td>
				<td align="center"><?php echo $Jurlist[$a]["name"];?></td>
				<td align="center"><?php echo $Jurlist[$a]["url"];?></td>
				<td align="center"><?php echo $Jurlist[$a]["sort"];?></td>
				<td align="center">
				<a  href="xtgl/editqx.php?id=<?php echo $Jurlist[$a]["id"];?>" style="color:blue;" target="dialog" mask="true" width="660" height="292"rel="editqx" >修改</a></td>
				</tr>
			<?php 
			if(is_array($Jurlist[$a]["son"])){foreach ($Jurlist[$a]["son"] as $s){?>
			<tr >
				<td align="center"><?php echo $s["id"];?></td>
				<td style="text-align: left;padding-left:30px;">
				<?php echo $s["comment"];?>
			
				</td>
				<td align="center"><?php echo $s["name"];?></td>
				<td align="center"><?php echo $s["url"];?></td>
				<td align="center"><?php echo $s["sort"];?></td>
				<td align="center">
<a  href="xtgl/editqx.php?id=<?php echo $s["id"];?>" style="color:blue;" target="dialog" mask="true" width="660" height="292"rel="editqx" >修改</a></td>
			</tr>
			<?php 
			}
			}
		
		}?>
		</tbody>
	</table>


         

<div class="formBar" >
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
			</ul>
		</div>
 
  </form></div>
  
  
  
  
  