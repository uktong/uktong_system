 <div class="pageContent">

<?php 
require "../hzb/config.php";
require R.'hzb/inc/load.php';

$getmsg=$db->select("t_travelpermission","*","id=".$_GET["id"])[0];
?>
 <form  onsubmit="return validateCallback(this,dialogAjaxDone);" class="pageForm" action="db/Jurmanage.php?action=edit&id=<?php echo $_GET["id"]; ?>" method="post"  enctype="multipart/form-data">
              <table cellpadding="0" border="0" cellspacing="0" class="edittable">
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">权限ID：</td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo $getmsg["id"];?></td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">权限名称：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                         <input name="comment" type="text"  value="<?php echo $getmsg["comment"];?>" />
                        
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">权限编码：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="presName"  value="<?php echo $getmsg["presName"];?>" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">URL：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="url"value="<?php echo $getmsg["url"];?>" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">上级权限ID：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="lastid" value="<?php echo $getmsg["lastid"];?>" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">排序：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="sort"  value="<?php echo $getmsg["sort"];?>"/><div id="ErrPwd"><span style="color:red">越小越靠前</span></div></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
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