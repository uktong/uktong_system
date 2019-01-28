 <?php 
 //base start
 require "../hzb/config.php";
 require R.'hzb/inc/load.php';
 //base end
 
 $basenote=$_GET["id"];
 $jur=$base->getJur(md5($_COOKIE["username"]),"name",$_GET["J"]);
 $J->type($jur, "add");
 ?>
 <div class="pageContent">
 <form  onsubmit="return validateCallback(this,dialogAjaxDone);" class="pageForm" action="jcsj/dbaction.php?km=<?php echo $basenote;?>&action=add" method="post"  enctype="multipart/form-data">

       <table cellpadding="0" border="0" cellspacing="0" class="edittable" >
            <tbody>

                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">项目名称：</td>
                     <td align="left"  class="editcell" style="width:30%;">
				 <input type="text" class="requred" name="basetype"  value=""/>
                     </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">项目编码：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <input type="text" name="basecode" class="requred" size="30" style="width: 152px;height:21px;"/></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
            <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">排序：</td>
                     <td align="left"  class="editcell" style="width:30%;">
				 <input type="text" class="requred" name="px"  value="0"/>
                     </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;">
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 
                
                <tr>
                    <td align="right" class="editcellmessage" style="width:15%;">摘&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;要：</td>
                    <td align="left" class="editcell" colspan="5">
                      <textarea id="txtRemark" name="digest" cols="100" rows="4" class="l-textarea" style="width:480px"></textarea>
                    </td>
                </tr>
                </tbody>
         </table>

<div class="formBar" >
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit" >保存</button></div></div></li>
			</ul>
		</div>
 
  </form></div>