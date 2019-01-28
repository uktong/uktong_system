 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
<?php 
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
$hotel=$_GET["hotel"];
require_once $_SESSION["ROOT"].'/db/db.php';
$result=mysqli_query($con,"select * from t_user where hotel='".$hotel."'" );
$resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
for($b=0;$b<count($resultarray);$b++){
    $hotel= $resultarray[$b]['hotel'];
}
?>
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="db/bm.php?action=charu&hotel=<?php echo $hotel;?>" method="post"  enctype="multipart/form-data">
                <table cellpadding="0" border="0" cellspacing="0" class="edittable">
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">部门名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="deptname"  class="required "  id="deptname" type="text" ltype="text" ligerui="{width:180}"  /></td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">部门编码：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                         <input name="deptcode" type="text" id="deptcode" ltype="text" ligerui="{width:160}" class="required "  />
                         
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