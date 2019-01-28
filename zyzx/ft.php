<?php 
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
date_default_timezone_set('prc');
$hotel=$_POST["hotel"];
$id=$_POST["id"];

?>
<tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo  date("Y-m-d");?></td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">可售：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                     <input type="text" name="had[]" value="<?php 
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d")."'"  );
                     
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +1 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +2 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +3 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +4 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +5 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +6 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +7 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +8 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +9 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +10 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +11 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +12 day"))."'"  );
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
                     $resultnow=mysqli_query($con,"select * from t_roomstate where roomtype = '".$id."' and hotel='".$hotel."' and date='".date("Y-m-d",strtotime(" +13 day"))."'"  );
                     $resultnowarray=mysqli_fetch_array($resultnow);
                     echo $resultnowarray["had"];
                     ?>"/></td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                  