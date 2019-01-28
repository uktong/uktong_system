 <?php 
 session_start();
 require_once $_SESSION["ROOT"].'/other/check.php';
 ?>
 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="db/gsxx.php?type=ajax&action=charu" method="post"  enctype="multipart/form-data">

       <table cellpadding="0" border="0" cellspacing="0" class="edittable" >
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">公司名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpName"class="required "  id="txtCmpName" type="text" ltype="text" ligerui="{width:180}" validate="{required:true}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">公司编码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpCode" type="text" id="txtCmpCode" ltype="text" ligerui="{width:160}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">负 责 人 ：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpManager"  id="txtCmpManager" type="text" ltype="text" ligerui="{width:180}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">手机号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpMobile" type="text" id="txtCmpMobile" ltype="text" ligerui="{width:160}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">电话号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpTel" type="text" id="txtCmpTel" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">传真号码：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpFax"  id="txtCmpFax" type="text" ltype="text" ligerui="{width:160}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">邮政编码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpZip" type="text" id="txtCmpZip" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">通讯地址：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpAddr"  id="txtCmpAddr" type="text" ltype="text" ligerui="{width:160}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">开 户 行 ：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpBank" type="text" id="txtCmpBank" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                   <td align="right" class="editcellmessage" style="width:15%;">开户名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpAccount"  id="txtCmpAccount" type="text" ltype="text" ligerui="{width:160}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">帐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpAccountNo" type="text" id="txtCmpAccountNo" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                   <td align="right" class="editcellmessage" style="width:15%;">城&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;市：</td>
                   <td align="left" class="editcell" style="width:30%;">
				<input type="text"  name="txtcity" value="" />
				</div></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">启用标志：</td>
                     <td align="left"  class="editcell"  colspan="5"><input id="chkUseChk" type="checkbox" name="chkUseChk" checked="checked"   /></td>
                </tr>
                <tr>
                    <td align="right" class="editcellmessage" style="width:15%;">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</td>
                    <td align="left" class="editcell" colspan="5">
                      <textarea id="txtRemark" name="txtRemark" cols="100" rows="4" class="l-textarea" style="width:480px"></textarea>
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