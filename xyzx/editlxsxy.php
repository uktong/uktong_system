 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
<?php 
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
$id=$_GET["id"];
$xysql=mysqli_query($con,"select * from t_protocol where id=".$id );
$xy=mysqli_fetch_array($xysql);
?><script type="text/javascript">
function getjdian(id){
	$(".getjdian"+id).attr("suggestUrl","ajax/xlk/jdian.php?id="+id+"&name="+$(".getjdian"+id).val());
}
$(".combox").change(function(){
	$.post('xyzx/gethotel.php?lv='+$(this).val(),function(data){
		$("#datacontentlxs").html(data);
		});
	
	 
});
</script>
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="xyzx/lxsjg.php?action=edit&id=<?php echo $id;?>" method="post"  enctype="multipart/form-data">
                <table cellpadding="0" border="0" cellspacing="0" class="edittable">
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">协议名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="dealName"  class="required " value=" <?php echo $xy["dealName"];?>" id="dutyname" type="text" ltype="text" ligerui="{width:180}"  /></td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">协议旅行社：</td>
                     <td align="left"  class="editcell" style="width:30%;">
<!--                          <input name="hotelName" type="text" id="dutycode" ltype="text" ligerui="{width:160}" class="required "  /> -->
                         
                        <input type="hidden" name="zts.id" value="<?php echo $xy['travelName'];?>"/>
				<input type="text" class="required getzts" readonly name="zts.zts" value=" <?php 
                         $ztsid=$xy['travelName'];
                         $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
                         $zts=mysqli_fetch_array($ztssql);
                         echo $zts['travel_name'];
                        ?>" suggestFields="zts"   lookupGroup="zts" />
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">起始日期：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <input type="text" name="starttime" value=" <?php echo $xy["starttime"];?>" class="date" datefmt="yyyy-MM-dd" size="30" style="width: 152px;height:21px;" readonly /></td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">终止日期：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                         <input type="text" name="endtime" value=" <?php echo $xy["endtime"];?>" class="date" datefmt="yyyy-MM-dd" size="30" style="width: 152px;height:21px;" readonly />
                         
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
               <tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">酒店星级：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <select class="combox" name="hotellevel" ref="hotellevel" onchange="" >
		<option value="all">所有星级</option>
		<?php 
		$resultnow=mysqli_query($con,"select *  from t_baseconfig where basenote='4' " );
		$resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
		for($a=0;$a<count($resultnowarray);$a++){
		?>
		<option value="<?php echo $resultnowarray[$a]["id"];?>"><?php echo $resultnowarray[$a]["basetype"];?></option>
<?php }?>
	</select>
                   </td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right" id="hotelbox" colspan="3" class="editcellmessage" style="width:95%;">
                   <table class="table" width="100%"  style="word-break:break-all; word-wrap:break-all;">
		<thead>
					<tr>
				<th align="center" colspan="2">选择酒店</th>
			</tr>
		</thead>
		<tbody id="datacontentlxs" >
			
		</tbody>
	</table>
                    </td>
                   
                </tr>
                <tr>
                <?php 
                $fxsql=mysqli_query($con, "select * from t_baseconfig where basenote=2");
                $fx=mysqli_fetch_all($fxsql,MYSQLI_ASSOC);
                for($a=0;$a<count($fx);$a++){
                ?>
                 <td align="right" class="editcellmessage" style="width:15%;"><?php echo $fx[$a]["basetype"];?>：</td>
                   <td align="left" class="editcell" style="width:30%;">
                     <input name="fjtype[]" value="<?php echo $fx[$a]["id"];?>"   type="hidden"   />
                   <input name="fjprice[]"    type="text" value="<?php 
                   $jgsql=mysqli_query($con, "select price from t_roomprice where roomType='".$fx[$a]["id"]."' and travelSchemeId=".$id);
                   $jg=mysqli_fetch_array($jgsql);
                   echo $jg["price"];
                   ?>"  />元</td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left"  class="editcell" style="width:30%;">
                         
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
               <?php }?>
               
                 <tr>
                   <td align="right" class="editcellmessage" style="width:15%;">是否启用：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <input id="chkUseChk" type="checkbox" name="flag" <?php echo $xy["flag"]=="on"?"checked":" "; ?>  />
                   </td>
                    <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left" colspan="5"  class="editcell" style="width:30%;" >
                     </td>
                  </tr>
                  <tr>
                   <td align="right" class="editcellmessage" style="width:15%;">备注：</td>
                   <td align="left" class="editcell" colspan="4" style="width:30%;">
                   <textarea id="txtRemark" name="remark" cols="100" rows="4" class="l-textarea" style="width:480px"><?php echo $xy["remark"];?></textarea>

                   </td>
                    
                  </tr>
                </tbody>
         </table>

<style>
         .edittable tr td{
         	height:35px;
         }
         .formBar{
         	
         	bottom:0;
         }
         </style>
         

<div class="formBar" >
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="reset">清空重输</button></div></div></li>
			</ul>
		</div>
 
  </form></div>