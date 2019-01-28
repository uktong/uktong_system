 <div class="pageContent">

<?php 
require "../hzb/config.php";
require R.'hzb/inc/load.php';

$getmsg=$db->select("t_user","*","id=".$_GET["id"])[0];
?>
 <form  onsubmit="return validateCallback(this,dialogAjaxDone);" class="pageForm" action="xtgl/dbaction.php?action=edit&id=<?php echo $_GET["id"]; ?>" method="post"  enctype="multipart/form-data">
              <table cellpadding="0" border="0" cellspacing="0" class="edittable">
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">用户帐号：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtUserAccount"  id="txtUserAccount" type="text" ltype="text" ligerui="{width:180}" value="<?php echo $getmsg["username"];?>" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">登录密码：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                         <input name="txtUserPwd" type="text" id="txtUserPwd" ltype="text" ligerui="{width:160}" value="<?php echo $getmsg["password"];?>" />
                         <div id="ErrPwd"><span style="color:red">密码须为6到20位字母+数字</span></div>
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">用户姓名：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtUserName" class="required "   id="txtUserName" type="text" ltype="text" ligerui="{width:180}" value="<?php echo $getmsg["realName"];?>" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">用户代码:</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtUserCode" type="text" id="txtUserCode" ltype="text" value="<?php echo $getmsg["userCode"];?>" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">电话号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpTel" type="text" id="txtCmpTel" ltype="text" value="<?php echo $getmsg["tel"];?>" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">传真号码：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpFax"  id="txtCmpFax" type="text" ltype="text" value="<?php echo $getmsg["fax"];?>"/></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">手机号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtUserMobile" type="text" id="txtUserMobile" ltype="text" value="<?php echo $getmsg["phone"];?>" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">QQ：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtUserQQ"  id="txtUserQQ" type="text" ltype="text" value="<?php echo $getmsg["QQ"];?>" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>

                   <td align="right" class="editcellmessage" style="width:15%;">Email：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtUserEmail"  id="txtUserEmail" type="text" ltype="text" value="<?php echo $getmsg["Email"];?>" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>

                    <td align="right"  class="editcellmessage" style="width:15%;">职    务：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                    <input type="text" id="txtGrid" name="txtGrid" value="<?php echo $getmsg["duty"];?>"/>
                     </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                   <td align="right" class="editcellmessage" style="width:15%;">是否启用：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <input id="chkUseChk" type="checkbox" name="chkUseChk" checked="checked" <?php echo $getmsg["isUser"]=="on"?"checked='checked'":"";?>  />
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
			</ul>
		</div>
 
  </form></div>