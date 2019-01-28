 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
<?php 
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
$getmsgsql=mysqli_query($con, "select * from t_traveluser where id=".$_GET["id"]);
$getmsg=mysqli_fetch_array($getmsgsql);
?>
<script type="text/javascript" src="ajax/js/main.js"></script>
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="zhzx/jgszh.php?action=edit&id=<?php echo $_GET["id"]; ?>" method="post"  enctype="multipart/form-data">
                <table cellpadding="0" border="0" cellspacing="0" class="edittable">
            <tbody>
                <tr>
                     <td align="right" style="width:15%;"  >公司名称:</td>
                     <td align="left" style="width:44%;">
                     <input type="hidden" name="zts.id" value="<?php echo $getmsg["travel"];?>"/>
				<input type="text" class="getzts required" name="zts.zts" value="<?php 
				$ztsid=$getmsg["travel"];
				$ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
				$zts=mysqli_fetch_array($ztssql);
				echo $zts['travel_name'];
				?>" suggestFields="zts"   lookupGroup="zts" />
                     </td>
                           <td align="left" style="width:1%"></td>
                     <td align="right"   >启用标志:</td>
                    <td align="left" ><input id="chkUseChk" type="checkbox" name="chkUseChk" <?php echo $getmsg["status"]=="on"?"checked='checked'":"";?>    /></td>
                </tr>
                <tr>
                       <td align="right"  >登陆账号:</td>
                       <td align="left" ><div style="float:left">
                       <input name="txtUserAccount" class="required " value="<?php echo $getmsg["username"];?>"  id="txtUserAccount" type="text"  /></div></td>
                       <td align="left"></td>
                       <td align="right"  >用户密码:</td>
                       <td align="left" ><div style="float:left">
                       <input name="txtUserPwd" class="required " value="<?php echo $getmsg["password"];?>"  id="txtUserPwd" type="text"   /></div></td>

                </tr>
                <tr>
                    <td align="right"   >用户姓名:</td>
                    <td align="left"   ><div style="float:left"><input name="txtUserName" value="<?php echo $getmsg["realname"];?>" class="required " type="text" id="txtUserName" /></div>
                    </td>
                    <td align="left" ></td>
                    <td align="right"  >电话号码:</td>
                    <td align="left"   ><input name="txtUserTel" type="text" id="txtUserTel" value="<?php echo $getmsg["tel"];?>"/></td>

                </tr>
                <tr>
                   <td align="right"  >传真号码:</td>
                   <td align="left"  ><input name="txtUserFax"  id="txtUserFax" type="text" ltype="text" value="<?php echo $getmsg["fax"];?>"  /></td>
                   <td align="left" ></td>
                   <td align="right" >手机号码:</td>
                   <td align="left"  ><input name="txtUserMobile"  id="txtUserMobile" type="text" value="<?php echo $getmsg["phone"];?>"  /></td>

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