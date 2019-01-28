<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
?>
<style type="text/css">
	ul.rightTools {float:right; display:block;}
	ul.rightTools li{float:left; display:block; margin-left:5px}
</style>

<div class="pageContent" style="padding:5px">
	<div class="tabs">
		<div class="tabsContent">
			<div>
	
				<div layoutH="146" style="float:left; display:block; overflow:auto; width:240px; border:solid 1px #CCC; line-height:21px; background:#fff">
				    <ul class="tree treeFolder">
				  	
				    
								
						<li><a href="javascript:;">基础数据分类</a>
						<?php   require_once $_SESSION["ROOT"].'/db/db.php';
						if(isset($_POST["txtcCode_Name"])){
						    if ($_GET["action"]=="charu"){
						        $txtcCode_Name=$_POST["txtcCode_Name"];
						        $txtcCode="";
						            foreach (mbStrSplit($txtcCode_Name) as $code){
						                $txtcCode.=getFirstCharter($code);
						            }
						        $rbl_csign=$_POST["rbl_csign"];
						        $txtOrderNum=$_POST["txtOrderNum"];
						        $chkUseChk=$_POST["chkUseChk"];
						        mysqli_query($con, "insert into t_subjectset(subjectName,subjectNumber,rankNumber,snableSign,subhectType)
values('".$txtcCode_Name."','".$txtcCode."','".$txtOrderNum."','".$chkUseChk."','".$rbl_csign."')");
						    }
						    if ($_GET["action"]=="edit"){
						        $id=$_GET["id"];
						        $txtcCode_Name=$_POST["txtcCode_Name"];
						        $txtcCode="";
						            foreach (mbStrSplit($txtcCode_Name) as $code){
						                $txtcCode.=getFirstCharter($code);
						            }
						        $rbl_csign=$_POST["rbl_csign"];
						        $txtOrderNum=$_POST["txtOrderNum"];
						        $chkUseChk=$_POST["chkUseChk"];
				
						        mysqli_query($con, "update t_subjectset set subjectName='".$txtcCode_Name."',subjectNumber='".$txtcCode."'
,rankNumber='".$txtOrderNum."',snableSign='".$chkUseChk."',subhectType='".$rbl_csign."' where id=".$id);
						    }
						}
						if(@$_GET["action"]=="delete"){
						    $id=$_GET["id"];
						    mysqli_query($con, "delete from t_subjectset where id=".$id);
						}
				    $result=mysqli_query($con,"select subjectName,id from t_subjectset" );
				    $resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
				    for($a=0;$a<count($resultarray);$a++){ ?>
							<ul><li>
						<a href="bggl/addkm.php?km=<?php echo $resultarray[$a]["id"]; ?>" target="ajax" rel="addkmbox">
						<?php echo $resultarray[$a]["subjectName"]; ?></a>
						</li>
							</ul>
							<?php }?>
						</li>
						
				     </ul>
				</div>
				
				<div id="addkmbox" class="unitBox" style="margin-left:246px;">
					<!--#include virtual="list1.html" -->
					
<div class="pageContent" >
<?php 


?>
<form  onsubmit="return navTabSearch(this);"  class="pageForm" action="bggl/kmsz.php?action=charu" method="post"  enctype="multipart/form-data">
 <table  class="table" width="100%" layoutH="138" style="word-break:break-all; word-wrap:break-all;">
                     <tbody>
                        <tr>
                         <td  class="editcellmessage" style="width:13%;"> <b>上级菜单：</b></td>
                           <td  class="editcell" style="width:10%;">
                            <span id="labParent" style="color:Blue;"></span>
                             </td>
                             <td  class="editcellverify" ></td>
                            
                        </tr>
                        <tr>
                         <td  class="editcellmessage" style="width:13%;">
                            科目名称<b>：</b>
                        </td>
                        <td  class="editcell" style="width:10%;">
                            <input name="txtcCode_Name" type="text" id="txtcCode_Name" class="required" ltype="text" ligerui="{width:160}" validate="{required:true}"/>
                        </td>
                          <td  class="editcellverify"></td>
                      </tr>
                        <tr>
                         <td  class="editcellmessage" style="width:13%;">
                            科目代码<b>：</b>
                        </td>
                        <td  class="editcell" >
                            <input name="txtcCode" type="text" id="txtcCode" ltype="text" ligerui="{width:160}"/>
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
		                        <td><input id="rbl_csign_0" type="radio" name="rbl_csign" value="0"  /><label for="rbl_csign_0">借</label></td>
		                        <td><input id="rbl_csign_1" name="rbl_csign" type="radio"  value="1" /><label for="rbl_csign_1">贷</label></td>
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
                                <input name="txtOrderNum"  type="text" value="0" id="txtOrderNum" ltype='spinner'  ligerui="{type:'int'}"  />
                            </td>
                             <td  class="editcellmessage"></td>
                        </tr>
                        <tr>
                          <td  class="editcellmessage" >启用标志<b>：</b></td>
                          <td align="left"  class="editcellmessage" >
                          <input id="chkUseChk" type="checkbox" name="chkUseChk" checked="checked"   /></td>
                          <td  class="editcellmessage"></td>
                        </tr>
                       <tr><td colspan="3"><div class="formBar"  >
			<ul style="float: left;">
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">添加</button></div></div></li>
			</ul>
		</div></td></tr>
                   </tbody>
                </table>
			
</form>
</div>
				</div>
	
			</div>
		</div>
		<div class="tabsFooter">
			<div class="tabsFooterContent"></div>
		</div>
	</div>
	
</div>


	

