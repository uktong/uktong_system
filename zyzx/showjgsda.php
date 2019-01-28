 <?php 
 session_start();
 require_once $_SESSION["ROOT"].'/other/check.php';
 
 require_once $_SESSION["ROOT"].'/db/db.php';
 $id=$_GET["id"];
 $travelsql=mysqli_query($con, "select * from t_jgtravel where id=".$id);
 $travelmsg=mysqli_fetch_array($travelsql);
 ?>
 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->

       <table cellpadding="0" border="0" cellspacing="0" class="edittable" >
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">公司名称：</td>
                   <td align="left" class="editcell" style="width:30%;">
<?php echo $travelmsg["travel_name"];?>
</td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">助记码：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                     <?php echo $travelmsg["travel_code"];?></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
             
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">负 责 人 ：</td>
                   <td align="left" class="editcell" style="width:30%;"> <?php echo $travelmsg["travel_leader"];?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">手机号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"> <?php echo $travelmsg["travel_phone"];?></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">电话号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"> <?php echo $travelmsg["travel_tel"];?></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">传真号码：</td>
                   <td align="left" class="editcell" style="width:30%;"> <?php echo $travelmsg["travel_fax"];?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">邮政编码：</td>
                     <td align="left"  class="editcell" style="width:30%;"> <?php echo $travelmsg["travel_zipCode"];?></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">通讯地址：</td>
                   <td align="left" class="editcell" style="width:30%;"> <?php echo $travelmsg["travel_address"];?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">开 户 行 ：</td>
                     <td align="left"  class="editcell" style="width:30%;"> <?php echo $travelmsg["travel_bank"];?></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                   <td align="right" class="editcellmessage" style="width:15%;">开户名称：</td>
                   <td align="left" class="editcell" style="width:30%;"> <?php echo $travelmsg["travel_bankAccount"];?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">帐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：</td>
                     <td align="left"  class="editcell" style="width:30%;"> <?php echo $travelmsg["travel_bankNum"];?></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                   <td align="right" class="editcellmessage" style="width:15%;">城&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;市：</td>
                   <td align="left" class="editcell" style="width:30%;">
				 <?php echo $travelmsg["travel_city_id"];?>
				</td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">启用标志：</td>
                     <td align="left"  class="editcell"  colspan="5"><input id="chkUseChk" type="checkbox" name="chkUseChk" <?php echo $travelmsg['travel_isUse']!="off"?"checked":"";?>    /></td>
                </tr>
                <tr>
                    <td align="right" class="editcellmessage" style="width:15%;">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</td>
                    <td align="left" class="editcell" colspan="5">
                       <?php echo $travelmsg["travel_remark"];?>
                    </td>
                </tr>
                </tbody>  </table>
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
			</tr>
		</thead>
		<tbody class="lxrbox">
		<?php 
		$sql=mysqli_query($con, "select * from t_linkman where travel_id=".$travelmsg["id"]);
		$result=mysqli_fetch_all($sql,MYSQLI_ASSOC);
		foreach ($result as $a){
		?>
			  <tr>
			<td ><?php echo $a["name"];?>
            </td><td ><?php echo $a["phone"];?>
            </td><td ><?php echo $a["tel"];?>
            </td><td ><?php echo $a["fax"];?>
            </td><td ><?php echo $a["qq"];?>
            </td><td ><?php echo $a["department"];?>
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
         


</div>