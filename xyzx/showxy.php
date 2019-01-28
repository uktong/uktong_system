 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
<?php 
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
$id=$_GET["id"];
$xysql=mysqli_query($con,"select * from t_protocol where id=".$id );
$xy=mysqli_fetch_array($xysql);
?>
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="xyzx/cbcgxy.php?action=charu" method="post"  enctype="multipart/form-data">
                <table cellpadding="0" border="0" cellspacing="0" class="edittable">
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">协议名称：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <?php echo $xy["dealName"];?>
</td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">协议单位：</td>
                     <td align="left"  class="editcell" style="width:30%;">
<!--                          <input name="hotelName" type="text" id="dutycode" ltype="text" ligerui="{width:160}" class="required "  /> -->
                        <?php 
                        if($xy['hotelName']!=null){
                        $jddianid=$xy['hotelName'];
                        $jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$jddianid);
                        $jddian=mysqli_fetch_array($jddiansql);
                        echo $jddian["hotelname"];
}else{
    $ztsid=$xy['travelName'];
    $ztssql=mysqli_query($con, "select travel_name from t_travel where id=".$ztsid);
    $zts=mysqli_fetch_array($ztssql);
    echo $zts['travel_name'];
}
                        ?>
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">起始日期：</td>
                   <td align="left" class="editcell" style="width:30%;">
                 <?php echo $xy["starttime"];?></td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">终止日期：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                       <?php echo $xy["endtime"];?>
                         
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                 <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">发布人：</td>
                   <td align="left" class="editcell" style="width:30%;">
                 <?php
                 $isusersql=mysqli_query($con, "select realName from t_user where id=".$xy["issuer"]);
                 $isuser=mysqli_fetch_array($isusersql);
                 echo $isuser["realName"];
  ?></td>
                     <td align="left" class="editcellverify" style="width:5%;"><div class="l-verify-star"></div></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left"  class="editcell" style="width:30%;">
                         
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                 <?php 
                 $getpricesql=mysqli_query($con, "select * from t_roomprice where travelSchemeId=".$id);
                 $getprice=mysqli_fetch_all($getpricesql,MYSQLI_ASSOC);
                 for($p=0;$p<count($getprice);$p++){
                     ?>
                 
                
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"><?php 
                 $fxsql=mysqli_query($con, "select * from t_baseconfig where id=".$getprice[$p]["roomType"]);
                 $fx=mysqli_fetch_array($fxsql,MYSQLI_ASSOC);
                 
                 echo $fx["basetype"];?>：</td>
                   <td align="left" class="editcell" style="width:30%;">
          <?php echo $getprice[$p]["price"];?>元</td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left"  class="editcell" style="width:30%;">
                         
                    </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
               <?php }?>
                 <tr>
                   <td align="right" class="editcellmessage" style="width:15%;">是否启用：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <input id="chkUseChk" type="checkbox" name="flag" <?php echo $xy["flag"]=="on"?"checked":" "; ?>  />
                   </td>
                    <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left" colspan="5"  class="editcell" style="width:30%;" >
                     </td>
                  </tr>
                  <tr>
                   <td align="right" class="editcellmessage" style="width:15%;">备注：</td>
                   <td align="left" class="editcell" colspan="4" style="width:30%;">
                  <?php echo $xy["remark"];?>

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
				<li><div class="buttonActive"><div class="buttonContent"><button class="close">关闭</button></div></div></li>
			</ul>
		</div>
 
  </form></div>