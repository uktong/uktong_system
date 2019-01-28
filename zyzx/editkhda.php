 <?php 
 session_start();
 require_once $_SESSION["ROOT"].'/other/check.php';
 require_once $_SESSION["ROOT"].'/db/db.php';
 $id=$_GET["id"];
 $travelsql=mysqli_query($con, "select * from t_travel where id=".$id);
 $travelmsg=mysqli_fetch_array($travelsql);
 ?>
 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="zyzx/khda.php?action=edit&id=<?php echo $id;?>" method="post"  enctype="multipart/form-data">

       <table cellpadding="0" border="0" cellspacing="0" class="edittable" >
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">公司名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpName"class="required " value="<?php echo $travelmsg["travel_name"];?>"  id="txtCmpName" type="text" ltype="text" ligerui="{width:180}" validate="{required:true}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">助记码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpCode" type="text" value="<?php echo $travelmsg["travel_code"];?>"  id="txtCmpCode" ltype="text" ligerui="{width:160}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">联系人：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="linkpeople"  id="traveltype" value="<?php echo $travelmsg["linkpeople"];?>"  type="text" ltype="text" ligerui="{width:180}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left"  class="editcell" style="width:30%;">
                     </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">负 责 人 ：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpManager"  id="txtCmpManager" value="<?php echo $travelmsg["travel_leader"];?>"  type="text" ltype="text" ligerui="{width:180}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">手机号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpMobile" type="text" value="<?php echo $travelmsg["travel_phone"];?>"  id="txtCmpMobile" ltype="text" ligerui="{width:160}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">电话号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpTel" type="text" value="<?php echo $travelmsg["travel_tel"];?>"  id="txtCmpTel" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">传真号码：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpFax"  id="txtCmpFax" value="<?php echo $travelmsg["travel_fax"];?>"  type="text" ltype="text" ligerui="{width:160}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">邮政编码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpZip" type="text" value="<?php echo $travelmsg["travel_zipCode"];?>"  id="txtCmpZip" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">通讯地址：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpAddr"  id="txtCmpAddr" value="<?php echo $travelmsg["travel_address"];?>"  type="text" ltype="text" ligerui="{width:160}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">开 户 行 ：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpBank" type="text" value="<?php echo $travelmsg["travel_bank"];?>"  id="txtCmpBank" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                   <td align="right" class="editcellmessage" style="width:15%;">开户名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpAccount"  id="txtCmpAccount" value="<?php echo $travelmsg["travel_bankAccount"];?>"  type="text" ltype="text" ligerui="{width:160}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">帐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpAccountNo" type="text" id="txtCmpAccountNo" value="<?php echo $travelmsg["travel_bankNum"];?>"  ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                   <td align="right" class="editcellmessage" style="width:15%;">城&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;市：</td>
                   <td align="left" class="editcell" style="width:30%;">
				<input type="text"  name="txtcity" value="<?php echo $travelmsg["travel_city_id"];?>"  value="" />
				</div></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">启用标志：</td>
                     <td align="left"  class="editcell"  colspan="5"><input id="chkUseChk" type="checkbox" name="chkUseChk" <?php echo $travelmsg['travel_isUse']!="off"?"checked":"";?>   /></td>
                </tr>
                <tr>
                    <td align="right" class="editcellmessage" style="width:15%;">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</td>
                    <td align="left" class="editcell" colspan="5">
                      <textarea id="txtRemark" name="txtRemark" cols="100" rows="4" class="l-textarea" style="width:480px">  <?php echo $travelmsg["travel_remark"];?></textarea>
                    </td>
                </tr>
                </tbody>	</table>
                <div>联系人：</div>

	<table class="table" cellpadding="0" border="0" cellspacing="0" width="100%"   >
		<thead>
			<tr>
				<th align="center" style="width:10%;">姓名</th>
				<th align="center" style="width:20%;">手机</th>
				<th align="center" style="width:20%;">电话</th>
				<th align="center" style="width:20%;">传真</th>
				<th align="center" style="width:15%;">QQ</th>
				<th align="center" style="width:10%;">职务</th>
				<th align="center"style="width:5%;">操作</th>
			</tr>
		</thead>
		<tbody class="lxrbox">
		<?php 
		$_linkmansql=mysqli_query($con, "select * from t_linkman where travel_id=".$id);
		$linkman=mysqli_fetch_all($_linkmansql,MYSQLI_ASSOC);
		for ($l=0;$l<count($linkman);$l++){
		
		?>
			  <tr><input type="hidden" name="id[]" value="<?php echo $linkman[$l]["id"];?>" />
			<td ><input type='text' name='username[]' style='width:100%;'value="<?php echo $linkman[$l]["name"];?>" />
            </td><td ><input type='text' name='phone[]' style='width:100%;'value="<?php echo $linkman[$l]["phone"];?>"/>
            </td><td ><input type='text' name='tel[]' style='width:100%;'  value="<?php echo $linkman[$l]["tel"];?>"/>
            </td><td ><input type='text' name='fax[]' style='width:100%;' value="<?php echo $linkman[$l]["fax"];?>"/>
            </td><td ><input type='text' name='qq[]' style='width:100%;' value="<?php echo $linkman[$l]["qq"];?>" />
            </td><td ><input type='text' name='duty[]' style='width:100%;'value="<?php echo $linkman[$l]["department"];?>" />
			</td><td><a href="javascript:;" class="delete btnDel" onclick="alert('此行不能删除！');">删除</a>
			</td>
			</tr>
			<?php }?>
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
         
<script type="text/javascript">
function addlxr(){
	$(".lxrbox").append("<tr><td><input type='hidden' name='id[]' value=''/><input type='text' name='username[]' style='width:100%;' /></td><td ><input type='text' name='phone[]' style='width:100%;' /></td><td ><input type='text' name='tel[]' style='width:100%;'  /> </td><td ><input type='text' name='fax[]' style='width:100%;' /></td><td ><input type='text' name='qq[]' style='width:100%;'  /></td><td ><input type='text' name='duty[]' style='width:100%;' /></td><td ><a href='javascript:;' class='delete btnDel' onclick='$(this).parent().parent().remove();'>删除</a></td></tr>");
}


         </script>
<div class="formBar" >
			<ul>
			<li><div class="buttonActive"><div class="buttonContent"><button type="button" onclick="addlxr()">添加联系人</button></div></div></li>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
			</ul>
		</div>
 
  </form></div>