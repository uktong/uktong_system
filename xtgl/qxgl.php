 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
<?php 
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end
require R.'hzb/class/Jurisdiction.class.php';


$user=$db->select("t_user","*","id=".$_GET["id"])[0];
$userqx=$db->select("ukt_jurisdiction","*","type='lxs' and userid=".$_GET["id"]);


?>
<div class="pageHeader">
	【<span>用户名：</span><?php echo $user["realName"]; ?> 
	<span>登录账号：</span><?php echo $user["username"]; ?> 
	<span>所属公司：</span><?php 
	$jddianid=$user["hotel"];
	$jddian=$base->getdata("company", $jddianid);
	echo $jddian["hotelname"];
	
	?> 
	<span>所属部门：</span> <?php 
	$deptid=$user["dept"];
	$dept=$base->getdata("department", $deptid);
	echo $dept["deptname"];
	
	?>】

</div>
<script type="text/javascript">
function setall(a){

if($(a).is(':checked')){

	$("."+$(a).attr("class")).prop("checked",true);
	$(".default"+$(a).attr("class")).prop("checked",true);
	
}else{
	
	$("."+$(a).attr("class")).prop("checked",false);
	$(".default"+$(a).attr("class")).prop("checked",false);
}
		
}
function setline(a){
	if($(a).is(':checked')){


		$(a).parent().parent().parent().find(".default"+$(a).attr("class")).prop("checked",true);
		
	}else{
		

		$(a).parent().parent().parent().find(".default"+$(a).attr("class")).prop("checked",false);
	}
}
function radioset(a){
	if($(a).is(':checked')){

		$("."+$(a).attr("class")).prop("checked",true);
		$(".default"+$(a).attr("class")).prop("checked",true);
		
	}else{
		
		$("."+$(a).attr("class")).prop("checked",false);
		$(".default"+$(a).attr("class")).prop("checked",false);
	}
}
function lineset(a){
	if($(a).is(':checked')){


		$(".default"+$(a).attr("class")).prop("checked",true);
		
	}else{
		

		$(".default"+$(a).attr("class")).prop("checked",false);
	}
}
</script>
 <form  onsubmit="return validateCallback(this,navTabAjaxDone);" class="pageForm" action="action/qxgl.php?id=<?php echo $userqx[0]["id"];?>" method="post"  enctype="multipart/form-data">

           <table class="table" width="100%" layoutH="108" style="word-break:break-all; word-wrap:break-all;" >
         
		<thead>
			<tr>
				<th align="center">序号</th>
				<th align="center">权限名称</th>
				<th align="center">权限范围</th>
				<th align="center">添加</th>
				<th align="center">修改</th>
				<th align="center">删除</th>
				<th align="center">限制个人</th>
				
			</tr>
		</thead>
		<tbody>
		<?php 
		$allqx=$db->select("t_travelpermission", "*", "1=1");
		$Jurobj=new Jurisdiction($allqx);
		$Jur=$Jurobj->Jresult($userqx[0]["Jurisdiction"]);
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

$l=1;
		for ($a=0;$a<count($Jurlist);$a++){
		    
		?>
			<tr >
				<td align="center"><?php echo $l;?><input type="hidden" name="Jur<?php echo $Jurlist[$a]["id"];?>" value="<?php echo $Jurlist[$a]["id"];?>"></td>
				
				<td style="text-align: left;">
				<input type="checkbox" name="state<?php echo $Jurlist[$a]["id"];?>" class="group<?php echo $a;?>" <?php echo $Jurlist[$a]["state"]=="1"?"checked":"";?> onchange="setall(this)"><?php echo $Jurlist[$a]["comment"];?>
			
				</td>
				<td align="center">个人<input type="radio" name="range<?php echo $Jurlist[$a]["id"];?>" value="0" <?php echo $Jurlist[$a]["content"]["range"]=="person"?"checked":"";?> class="columnperson<?php echo $a;?> " onclick="radioset(this)"> 
				部门<input type="radio" class="columndepartment<?php echo $a;?>" onclick="radioset(this)" name="range<?php echo $Jurlist[$a]["id"];?>" value="1" <?php echo $Jurlist[$a]["content"]["range"]=="department"?"checked":"";?>>
				 公司<input type="radio" name="range<?php echo $Jurlist[$a]["id"];?>" value="2" class="columncompany<?php echo $a;?>" onclick="radioset(this)" <?php echo $Jurlist[$a]["content"]["range"]=="company"?"checked":"";?>> 
				 集团<input type="radio" name="range<?php echo $Jurlist[$a]["id"];?>" value="3" class="columngroup<?php echo $a;?>" onclick="radioset(this)" <?php echo $Jurlist[$a]["content"]["range"]=="group"?"checked":"";?>></td>
				<td align="center"><input type="checkbox" name="add<?php echo $Jurlist[$a]["id"];?>" class="lineadd<?php echo $a;?>" onclick="lineset(this)" <?php echo $Jurlist[$a]["content"]["add"]?"checked":"";?>/>添加</td>
				<td align="center"><input type="checkbox" name="edit<?php echo $Jurlist[$a]["id"];?>" class="lineedit<?php echo $a;?>" onclick="lineset(this)" <?php echo $Jurlist[$a]["content"]["edit"]?"checked":"";?>/>修改</td>
				<td align="center"><input type="checkbox" name="del<?php echo $Jurlist[$a]["id"];?>" class="linedel<?php echo $a;?>" onclick="lineset(this)" <?php echo $Jurlist[$a]["content"]["del"]?"checked":"";?>/>删除</td>
				<td align="center"><input type="checkbox" name="limit<?php echo $Jurlist[$a]["id"];?>" class="linelimit<?php echo $a;?>" onclick="lineset(this)" <?php echo $Jurlist[$a]["content"]["limit"]?"checked":"";?>/>限制个人</td>
			</tr>
			<?php 
			$l++;
			if(is_array($Jurlist[$a]["son"])){foreach ($Jurlist[$a]["son"] as $s){?>
			<tr >
				<td align="center"><?php echo $l;?><input type="hidden" name="Jur<?php echo $s["id"];?>" value="<?php echo $s["id"];?>"></td>
				
				<td style="text-align: left;padding-left:30px;"><input type="checkbox" name="state<?php echo $s["id"];?>" class="group<?php echo $a;?>" <?php echo $s["state"]=="1"?"checked":"";?> onchange="setline(this)"><?php echo $s["comment"];?>
			
				</td>
				<td align="center">个人<input type="radio" name="range<?php echo $s["id"];?>" value="0" class="defaultcolumnperson<?php echo $a;?>" <?php echo $s["content"]["range"]=="person"?"checked":"";?>> 
				部门<input type="radio" class="defaultcolumndepartment<?php echo $a;?>" name="range<?php echo $s["id"];?>" value="1" <?php echo $s["content"]["range"]=="department"?"checked":"";?>>
				 公司<input type="radio" name="range<?php echo $s["id"];?>" value="2" class="defaultcolumncompany<?php echo $a;?>" <?php echo $s["content"]["range"]=="company"?"checked":"";?>> 
				 集团<input type="radio"  name="range<?php echo $s["id"];?>" class="defaultgroup<?php echo $a;?> defaultcolumngroup<?php echo $a;?>" value="3" <?php echo $s["content"]["range"]=="group"?"checked":"";?>></td>
				<td align="center"><input type="checkbox" name="add<?php echo $s["id"];?>" class="defaultgroup<?php echo $a;?> defaultlineadd<?php echo $a;?>" <?php echo $s["content"]["add"]?"checked":"";?>/>添加</td>
				<td align="center"><input type="checkbox" name="edit<?php echo $s["id"];?>" class="defaultgroup<?php echo $a;?> defaultlineedit<?php echo $a;?>" <?php echo $s["content"]["edit"]?"checked":"";?>/>修改</td>
				<td align="center"><input type="checkbox" name="del<?php echo $s["id"];?>" class="defaultgroup<?php echo $a;?> defaultlinedel<?php echo $a;?>" <?php echo $s["content"]["del"]?"checked":"";?>/>删除</td>
				<td align="center"><input type="checkbox" name="limit<?php echo $s["id"];?>"class=" defaultlinelimit<?php echo $a;?>" <?php echo $s["content"]["limit"]?"checked":"";?>/>限制个人</td>
			</tr>
			<?php 
			$l++;
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
  
  
  
  
  