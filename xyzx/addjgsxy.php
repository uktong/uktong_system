 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
<?php 
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';


?><script type="text/javascript">
function getjdian(id){
	$(".getjdian"+id).attr("suggestUrl","ajax/xlk/jdian.php?id="+id+"&name="+$(".getjdian"+id).val());
}
$(".combox").change(function(){
	$.post('xyzx/gethotel.php?lv='+$(this).val(),function(data){
		$("#datacontentadd").html(data);
		});
	
	 
});
</script>
<script type="text/javascript" src="ajax/js/main.js"></script>
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="xyzx/jgsjg.php?action=charu" method="post"  enctype="multipart/form-data">
                <table cellpadding="0" border="0" cellspacing="0" class="edittable">
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">协议名称：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <input name="dealName"  class="required "  id="dutyname" type="text" ltype="text" ligerui="{width:180}"  /></td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">协议交给社：</td>
                     <td align="left"  class="editcell" style="width:30%;">
<!--                          <input name="hotelName" type="text" id="dutycode" ltype="text" ligerui="{width:160}" class="required "  /> -->
                         <input type="hidden" name="zts.id" value=""/>
				<input type="text" class="required getjgs" name="zts.zts" value="" suggestFields="zts"   lookupGroup="zts" />
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">起始日期：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <input type="text" name="starttime" value="<?php 
			date_default_timezone_set('prc');
			echo date("Y-m-d",time());?>" class="date" datefmt="yyyy-MM-dd" size="30" style="width: 152px;height:21px;" readonly /></td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">终止日期：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                         <input type="text" name="endtime" value="<?php 
			date_default_timezone_set('prc');
			echo date("Y-m-d",time());?>" class="date" datefmt="yyyy-MM-dd" size="30" style="width: 152px;height:21px;" readonly />
                         
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>

                <?php 
               
                $fxsql=mysqli_query($con, "select * from t_baseconfig where basenote=13");
                $fx=mysqli_fetch_all($fxsql,MYSQLI_ASSOC);
                for($a=0;$a<count($fx);$a++){
                ?>
                 <tr> 
                 <td align="right" class="editcellmessage" style="width:15%;"><?php echo $fx[$a]["basetype"];?>：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <input name="fjtype[]" value="<?php echo $fx[$a]["id"];?>"   type="hidden"   />
                   <input name="fjprice[]"    type="text"   />元</td>
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
                   <input id="chkUseChk" type="checkbox" name="flag" checked="checked"  />
                   </td>
                    <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left" colspan="5"  class="editcell" style="width:30%;" >
                     </td>
                  </tr>
                  <tr>
                   <td align="right" class="editcellmessage" style="width:15%;">备注：</td>
                   <td align="left" class="editcell" colspan="4" style="width:30%;">
                   <textarea id="txtRemark" name="remark" cols="100" rows="4" class="l-textarea" style="width:480px"></textarea>

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