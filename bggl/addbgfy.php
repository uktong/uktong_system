 <?php 
 session_start();
 require_once $_SESSION["ROOT"].'/other/check.php';
 require_once $_SESSION["ROOT"].'/db/db.php';
 ?>
 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="bggl/bgfylr.php" method="post"  enctype="multipart/form-data">

       <table cellpadding="0" border="0" cellspacing="0" class="edittable" >
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">会计期间：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <input type="text" name="handleDate" value="<?php 
			date_default_timezone_set('prc');
			echo date("Y-m",time());?>" class="date" datefmt="yyyy-MM" size="30" style="width: 152px;height:21px;" readonly /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">记账部门：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="bm" value="<?php 
                     $hotelcode= $_SESSION["hotelcode"];
                     $hotelsql=mysqli_query($con, "select hotelname from t_hotel where hotelcode='".$hotelcode."'");
                     $hotelname=mysqli_fetch_array($hotelsql);
                     $deptsql=mysqli_query($con, "select deptname,id from t_dept where hotel='".$hotelcode."'");
                     $dept=mysqli_fetch_array($deptsql);
                     echo $hotelname["hotelname"]."-".$dept["deptname"];
                     ?>" type="text" id="txtCmpCode" readonly ltype="text" ligerui="{width:160}" />
                     <input name="bmid" value="<?php echo $dept["id"];?>" type="hidden"/>
                     </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">记账类型 ：</td>
      <td><input id="rbl_csign_0" type="radio" name="rbl_csign" value="0" checked  /><label for="rbl_csign_0">借（收）</label>
		                        <input id="rbl_csign_1" name="rbl_csign" type="radio"  value="1" /><label for="rbl_csign_1">贷（支）</label></td>
	                     <td align="left" class="editcellverify" style="width:5%;"></td>  
                    <td align="right"  class="editcellmessage" style="width:15%;">所属科目：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                     <select name="subjectType_id" style="width: 152px;height:21px;">
                     <?php $kmsql=mysqli_query($con, "select id,subjectName from t_subjectset");
                     $km=mysqli_fetch_all($kmsql,MYSQLI_ASSOC);
                     for($a=0;$a<count($km);$a++){
                     ?>
                     <option value="<?php echo $km[$a]["id"];?>"><?php echo $km[$a]["subjectName"];?></option>
                   <?php }?>
                     </select>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">借 (收)方：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="borrowMoney" type="text" id="txtCmpTel" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">贷 (支)方：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="loanMoney"  id="txtCmpFax" type="text" ltype="text" ligerui="{width:160}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr><input name="insert"  type="hidden" size="30" value="yes"/>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">经 办  人：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                     <input type="hidden" name="operator" value="<?php echo $_SESSION["userid"]; ?>"/>
				 <input type="text"  value="<?php echo $_SESSION["user"]; ?>"/>
                     </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">经办日期：</td>
                   <td align="left" class="editcell" style="width:30%;"><input type="text" name="creattime" value="<?php 
			date_default_timezone_set('prc');
			echo date("Y-m-d",time());?>" class="date" size="30" style="width: 152px;height:21px;" readonly /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
           
                 
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">记账账户：</td>
                     <td align="left"  class="editcell"  colspan="5">
                      <select name="acount" style="width: 152px;height:21px;">
                     <?php $accountsql=mysqli_query($con, "select id,accountTitle from t_account");
                     $account=mysqli_fetch_all($accountsql,MYSQLI_ASSOC);
                     for($a=0;$a<count($account);$a++){
                     ?>
                     <option value="<?php echo $account[$a]["id"];?>"><?php echo $account[$a]["accountTitle"];?></option>
                   <?php }?>
                     </select>
                     
                     </td>
                </tr>
                <tr>
                    <td align="right" class="editcellmessage" style="width:15%;">摘&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;要：</td>
                    <td align="left" class="editcell" colspan="5">
                      <textarea id="txtRemark" name="digest" cols="100" rows="4" class="l-textarea" style="width:480px"></textarea>
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
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit" >保存</button></div></div></li>
			</ul>
		</div>
 
  </form></div>