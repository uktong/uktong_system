<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
$sql=mysqli_query($con, "select * from t_account where id=".$_GET["id"]);
$msg=mysqli_fetch_array($sql);
date_default_timezone_set('prc');
?>
 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="zyzx/zhgl.php?action=zz&id=<?php echo $_GET["id"]; ?>" method="post"  enctype="multipart/form-data">

       <table cellpadding="0" border="0" cellspacing="0" class="edittable" >
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">账号名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpName" readonly  value="<?php echo $msg["accountTitle"];?>" id="txtCmpName" type="text" ltype="text" ligerui="{width:180}" validate="{required:true}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    

                   <td align="right" class="editcellmessage" style="width:15%;">日期：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="changeDate" class="date readonly" readonly="readonly" type="text" value="<?php
                   echo  date("Y-m-d")?>"></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">财务方向：</td>
                     <td align="left"  class="editcell" style="width:30%;"><select class="combox" name="guid" style="float:right;" ref="guid"  >
			<option value="in">转进</option>
		<option value="out">转出</option>
	</select></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                   <td align="right" class="editcellmessage" style="width:15%;">调账金额：</td>
                   <td align="left" class="editcell" style="width:30%;">
				<input type="text"  class="requred" name="changemoney" value="" />
				</td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                  <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">账号：</td>
                     <td align="left"  class="editcell" style="width:30%;"><select class="combox requred" name="account" style="float:right;" ref="guid"  >
		<?php 
		$result=mysqli_query($con,"select * from t_account" );
		$resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
		for($a=0;$a<count($resultarray);$a++){
		?>
		<option value="<?php echo $resultarray[$a]["id"];?>"><?php echo $resultarray[$a]["accountTitle"];?></option>
		<?php }?>
	</select></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
<td align="right" class="editcellmessage" style="width:15%;">余额：</td>
                   <td align="left" class="editcell" style="width:30%;">
				<input type="text"  name="money" readonly value="<?php echo $msg["money"];?>" />
				</td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
               
                <tr>
                    <td align="right" class="editcellmessage" style="width:15%;">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</td>
                    <td align="left" class="editcell" colspan="5">
                      <textarea id="txtRemark" name="txtRemark" cols="5" rows="4" class="l-textarea" style="width:450px">
                      </textarea>
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