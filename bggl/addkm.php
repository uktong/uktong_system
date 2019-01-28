<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';

$_km=$_GET["km"];
require_once $_SESSION["ROOT"].'/db/db.php';
$result=mysqli_query($con,"select * from t_subjectset where id=".$_km );
$resultarray=mysqli_fetch_array($result,MYSQLI_ASSOC);
?>





<div class="pageContent" >
<form  onsubmit="return navTabSearch(this);"  class="pageForm" action="bggl/kmsz.php?action=edit&id=<?php echo $_km;?>" method="post"  enctype="multipart/form-data">
 <table  class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
                     <tbody>
                        <tr>
                         <td  class="editcellmessage" style="width:13%;"> <b>上级菜单：</b></td>
                           <td  class="editcell" style="width:10%;">
                            <span id="labParent" style="color:Blue; float:left;" ><?php echo $resultarray["subjectName"]; ?></span>
                             </td>
                             <td  class="editcellverify" ></td>
                            
                        </tr>
                        <tr>
                         <td  class="editcellmessage" style="width:13%;">
                            科目名称<b>：</b>
                        </td>
                        <td  class="editcell" style="width:10%;">
                            <input name="txtcCode_Name" value="<?php echo $resultarray["subjectName"]; ?>" type="text" id="txtcCode_Name" ltype="text" ligerui="{width:160}" validate="{required:true}"/>
                        </td>
                          <td  class="editcellverify"><div class="l-verify-star">*</div></td>
                      </tr>
                        <tr>
                         <td  class="editcellmessage" style="width:13%;">
                            科目代码<b>：</b>
                        </td>
                        <td  class="editcell" >
                            <input name="txtcCode" type="text" value="<?php echo $resultarray["subjectNumber"]; ?>" id="txtcCode" ltype="text" ligerui="{width:160}"/>
                        </td>
                          <td  class="editcellverify" ></td>
                      </tr>
                      <tr>
                        <td  class="editcellmessage" style="width:13%;">
                            科目类型<b>：</b>
                        </td>
                         <td  class="editcellmessage">
                         <table  border="0">
	                       <tr>
		                        <td><input id="rbl_csign_0" type="radio" name="rbl_csign" value="0" <?php if($resultarray["subhectType"]=="0"){echo "checked";}?>  /><label for="rbl_csign_0">借</label></td>
		                        <td><input id="rbl_csign_1" name="rbl_csign" type="radio"  value="1"<?php if($resultarray["subhectType"]=="1"){echo "checked";}?> /><label for="rbl_csign_1">贷</label></td>
	                       </tr>
</table>
                        </td>
                        <td  class="editcellmessage"></td>
                      </tr>
                        <tr>
                            <td  class="editcellmessage" style="width:13%;">
                                排 序 号<b>：</b>
                            </td>
                            <td class="editcell">
                                <input name="txtOrderNum"  type="text" value="<?php echo $resultarray["rankNumber"]; ?>" id="txtOrderNum" ltype='spinner'  ligerui="{type:'int'}"  />
                            </td>
                             <td  class="editcellmessage"></td>
                        </tr>
                        <tr>
                          <td  class="editcellmessage" >启用标志<b>：</b></td>
                          <td align="left"  class="editcellmessage" >
                          <input id="chkUseChk" type="checkbox" name="chkUseChk" <?php if($resultarray["snableSign"]=="on"){echo "checked='checked'";}?>   /></td>
                          <td  class="editcellmessage"></td>
                        </tr>
                       <tr><td colspan="3"><div class="formBar"  >
			<ul style="float: left;">
			<li><div class="buttonActive"><div class="buttonContent"><a href="bggl/kmsz.php?action=delete&id=<?php echo $_km;?>" rel="kmsz" target="navTab" style="color:#15428B;">删除</a></div></div></li>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
			</ul>
		</div></td></tr>
                   </tbody>
                </table>
			
</form>
</div>