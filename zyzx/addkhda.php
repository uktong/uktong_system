 <?php 
 session_start();
 require_once $_SESSION["ROOT"].'/other/check.php';
 if(@$_POST["numPerPage"]!=null){
     $numPerPage=$_POST["numPerPage"];
     //      $keywords=$_POST["keywords"];
     $pageNum=$_POST["pageNum"];
     //     $status=$_POST["status"];
     //     $orderField=$_POST["orderField"];
     
 }else{
     $numPerPage=5;
     $pageNum=1;
 }
 ?>
 <form id="pagerForm" method="post" action="zyzx/addkhda.php">
<!-- 	<input type="hidden" name="status" value="${param.status}"> -->
<!-- 	<input type="hidden" name="keywords" value="${param.keywords}" /> -->
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
<!-- 	<input type="hidden" name="orderField" value="${param.orderField}" /> -->
</form>
 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="zyzx/khda.php?action=charu" method="post"  enctype="multipart/form-data">

       <table cellpadding="0" border="0" cellspacing="0" class="edittable" >
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">旅行社名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpName"class="required "  id="txtCmpName" type="text" ltype="text" ligerui="{width:180}" validate="{required:true}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">助记码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpCode" type="text" id="txtCmpCode" ltype="text" ligerui="{width:160}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">联系人：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="linkpeople"  id="traveltype" type="text" ltype="text" ligerui="{width:180}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left"  class="editcell" style="width:30%;">
                     </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">负 责 人 ：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpManager"  id="txtCmpManager" type="text" ltype="text" ligerui="{width:180}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">手机号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpMobile" type="text" id="txtCmpMobile" ltype="text" ligerui="{width:160}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">电话号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpTel" type="text" id="txtCmpTel" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">传真号码：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpFax"  id="txtCmpFax" type="text" ltype="text" ligerui="{width:160}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">邮政编码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpZip" type="text" id="txtCmpZip" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">通讯地址：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpAddr"  id="txtCmpAddr" type="text" ltype="text" ligerui="{width:160}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">开 户 行 ：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpBank" type="text" id="txtCmpBank" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                   <td align="right" class="editcellmessage" style="width:15%;">开户名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><input name="txtCmpAccount"  id="txtCmpAccount" type="text" ltype="text" ligerui="{width:160}" /></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">帐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input name="txtCmpAccountNo" type="text" id="txtCmpAccountNo" ltype="text" ligerui="{width:180}" /></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                   <td align="right" class="editcellmessage" style="width:15%;">城&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;市：</td>
                   <td align="left" class="editcell" style="width:30%;">
				<input type="text"  name="txtcity" value="" />
				</div></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">启用标志：</td>
                     <td align="left"  class="editcell"  colspan="5"><input id="chkUseChk" type="checkbox" name="chkUseChk" checked="checked"   /></td>
                </tr>
                <tr>
                    <td align="right" class="editcellmessage" style="width:15%;">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</td>
                    <td align="left" class="editcell" colspan="5">
                      <textarea id="txtRemark" name="txtRemark" cols="100" rows="4" class="l-textarea" style="width:480px"></textarea>
                    </td>
                </tr>
                </tbody>
         </table>
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
			  <tr>
			<td ><input type='text' name='username[]' style='width:100%;' />
            </td><td ><input type='text' name='phone[]' style='width:100%;' />
            </td><td ><input type='text' name='tel[]' style='width:100%;'  />
            </td><td ><input type='text' name='fax[]' style='width:100%;' />
            </td><td ><input type='text' name='qq[]' style='width:100%;'  />
            </td><td ><input type='text' name='duty[]' style='width:100%;' />
			</td><td><a href="javascript:;" class="delete btnDel" onclick="alert('此行不能删除！');">删除</a>
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
         <script type="text/javascript">
function addlxr(){
	$(".lxrbox").append("<tr><td><input type='text' name='username[]' style='width:100%;' /></td><td ><input type='text' name='phone[]' style='width:100%;' /></td><td ><input type='text' name='tel[]' style='width:100%;'  /> </td><td ><input type='text' name='fax[]' style='width:100%;' /></td><td ><input type='text' name='qq[]' style='width:100%;'  /></td><td ><input type='text' name='duty[]' style='width:100%;' /></td><td ><a href='javascript:;' class='delete btnDel' onclick='$(this).parent().parent().remove();'>删除</a></td></tr>");
}


         </script>

<div class="formBar" >
			<ul>
			<li><div class="buttonActive"><div class="buttonContent"><button type="button" onclick="addlxr()">添加联系人</button></div></div></li>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
			</ul>
		</div>
 
  </form></div>