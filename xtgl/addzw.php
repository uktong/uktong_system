 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
<?php 
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';

?>
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="db/zw.php?action=charu" method="post"  enctype="multipart/form-data">
                <table cellpadding="0" border="0" cellspacing="0" class="edittable">
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">职务名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="dutyname"  class="required "  id="dutyname" type="text" ltype="text" ligerui="{width:180}"  /></td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">职务编码：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                         <input name="dutycode" type="text" id="dutycode" ltype="text" ligerui="{width:160}" class="required "  />
                         
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                
                 <tr>
                   <td align="right" class="editcellmessage" style="width:15%;">是否启用：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <input id="chkUseChk" type="checkbox" name="chkUseChk" checked="checked"  />
                   </td>
                    <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left" colspan="5"  class="editcell" style="width:30%;" >
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