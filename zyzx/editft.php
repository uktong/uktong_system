 <?php 
 session_start();
 require_once $_SESSION["ROOT"].'/other/check.php';
 require_once $_SESSION["ROOT"].'/db/db.php';
 date_default_timezone_set('prc');
 $rt=$_GET["rt"];
 
 ?>
 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="zyzx/jdfthotel.php?action=edit&rt=<?php echo  $rt;?>" method="post"  enctype="multipart/form-data">

       <table cellpadding="0" border="0" cellspacing="0" class="edittable" >
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;">房间类型：
                         
                   
                   </td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left"  class="editcell" style="width:30%;">
                     <?php 
                     $roomtypesql=mysqli_query($con, "select basetype from t_baseconfig where id=".$rt);
                     $roomtype=mysqli_fetch_array($roomtypesql);
                     echo $roomtype["basetype"];
                     ?>
               </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d");?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                     <input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d")."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/>
                     </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                 <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +1 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +1 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                 <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +2 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +2 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                 <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +3 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +3 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +4 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +4 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +5 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +5 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +6 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +6 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +7 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +6 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +8 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +6 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +9 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +6 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +10 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +6 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +11 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +6 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +12 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +6 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d",strtotime(" +13 day"));?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;"><input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$rt."' and hotel='".$_SESSION["hotelid"]."' and date='".date("Y-m-d",strtotime(" +6 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

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