 <?php 
 session_start();
 require_once $_SESSION["ROOT"].'/other/check.php';
 require_once $_SESSION["ROOT"].'/db/db.php';
 $id=$_GET["id"];
 $result=mysqli_query($con,"select * from t_hotel where id=".$id );
 $resultarray=mysqli_fetch_array($result,MYSQLI_ASSOC);
 
 ?>
 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->

       <table cellpadding="0" border="0" cellspacing="0" class="edittable" >
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">公司名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo $resultarray['hotelname'];?></td><td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">公司编码：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                     <?php echo $resultarray['hotelcode'];?></td>
                     <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">负 责 人 ：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <?php echo $resultarray['hotelleader'];?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">手机号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><?php echo $resultarray['hotelphone'];?></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">电话号码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><?php echo $resultarray['hoteltel'];?></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">传真号码：</td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo $resultarray['hotelfax'];?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">邮政编码：</td>
                     <td align="left"  class="editcell" style="width:30%;"><?php echo $resultarray['hotelzipCode'];?></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">通讯地址：</td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo $resultarray['hoteladdress'];?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">开 户 行 ：</td>
                     <td align="left"  class="editcell" style="width:30%;"><?php echo $resultarray['hotelbank'];?></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                   <td align="right" class="editcellmessage" style="width:15%;">开户名称：</td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo $resultarray['hotelbankNum'];?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">帐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：</td>
                     <td align="left"  class="editcell" style="width:30%;"><?php echo $resultarray['hotelbankAccount'];?></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                   <td align="right" class="editcellmessage" style="width:15%;">城&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;市：</td>
                   <td align="left" class="editcell" style="width:30%;">
				<?php echo $resultarray['hotelcityid'];?>
				</div></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                 
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">启用标志：</td>
                     <td align="left"  class="editcell"  colspan="5"><input id="chkUseChk" type="checkbox" name="chkUseChk" <?php echo $resultarray['hotelisUse']!="off"?"checked":"";?>  value="true" /></td>
                </tr>
                <tr>
                    <td align="right" class="editcellmessage" style="width:15%;">备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：</td>
                    <td align="left" class="editcell" colspan="5" style="width:480px">
                      <?php echo $resultarray['hotelremark'];?>
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
</div>