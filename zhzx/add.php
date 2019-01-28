 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
<?php 
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';

?>
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="zhzx/jdzh.php?action=charu" method="post"  enctype="multipart/form-data">
                <table cellpadding="0" border="0" cellspacing="0" class="edittable">
            <tbody>
                <tr>
                     <td align="right" style="width:15%;"  >公司名称:</td>
                     <td align="left" style="width:44%;">
                     <input type="hidden" name="jdian222.id" value=""/>
				<input type="text" class="required  getjdian222" oninput="getjdian('222')" style="float: left;" name="jdian222.jdian222" value="" suggestFields="jdian222"  lookupGroup="jdian222" />
				<a class="btnLook" style="float: left;" href="ajax/dh/jdian.php?id=222" lookupGroup="jdian222">选择酒店</a>
				<script type="text/javascript">
function getjdian(id){
	$(".getjdian"+id).attr("suggestUrl","ajax/xlk/jdian.php?id="+id+"&name="+$(".getjdian"+id).val());
}
</script>
                     </td>
                      <td align="left" style="width:1%"></td>
                     <td align="right"   >启用标志:</td>
                    <td align="left" ><input id="chkUseChk" type="checkbox" name="chkUseChk" checked="checked"   /></td>
                </tr>
                <tr>
                       <td align="right"  >登陆账号:</td>
                       <td align="left" ><div style="float:left">
                       <input name="txtUserAccount" class="required "  id="txtUserAccount" type="text"  /></div></td>
                       <td align="left"></td>
                       <td align="right"  >用户密码:</td>
                       <td align="left" ><div style="float:left">
                       <input name="txtUserPwd" class="required "  id="txtUserPwd" type="text"   /></div></td>

                </tr>
                <tr>
                    <td align="right"   >用户姓名:</td>
                    <td align="left"   ><div style="float:left"><input name="txtUserName" class="required " type="text" id="txtUserName" /></div>
                    </td>
                    <td align="left" ></td>
                    <td align="right"  >电话号码:</td>
                    <td align="left"   ><input name="txtUserTel" type="text" id="txtUserTel" /></td>

                </tr>
                <tr>
                   <td align="right"  >传真号码:</td>
                   <td align="left"  ><input name="txtUserFax"  id="txtUserFax" type="text" ltype="text"  /></td>
                   <td align="left" ></td>
                   <td align="right" >手机号码:</td>
                   <td align="left"  ><input name="txtUserMobile"  id="txtUserMobile" type="text"  /></td>

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