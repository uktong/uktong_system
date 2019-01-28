 <?php 
 session_start();
 require_once $_SESSION["ROOT"].'/other/check.php';
 require_once $_SESSION["ROOT"].'/db/db.php';
 $id=$_GET["id"];
 $bgfysql=mysqli_query($con, "select* from t_officeaccount where id=".$id);
 $bgfy=mysqli_fetch_array($bgfysql);
 ?>
 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="bggl/bgfylr.php" method="post"  enctype="multipart/form-data">

       <table cellpadding="0" border="0" cellspacing="0" class="edittable" >
            <tbody>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">会计期间：</td>
                   <td align="left" class="editcell" style="width:30%;">
                  <?php echo $bgfy["handleDate"];?>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;">记账部门：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                     <?php 
                     $deptsql=mysqli_query($con, "select deptname,hotel from t_dept where id='".$bgfy["bm"]."'");
                     $dept=mysqli_fetch_array($deptsql);
                     $hotelsql=mysqli_query($con, "select hotelname from t_hotel where hotelcode='".$dept["hotel"]."'");
                     $hotelname=mysqli_fetch_array($hotelsql);
                     
                     echo $hotelname["hotelname"]."-".$dept["deptname"];
                     ?>
                    
                     </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;">记账类型 ：</td>
      <td>
<?php 
echo $bgfy["tallyType_id"]==0?"借 (收)":"贷 (支)";
?>
</td>
	                     <td align="left" class="editcellverify" style="width:5%;"></td>  
                    <td align="right"  class="editcellmessage" style="width:15%;">所属科目：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                     <?php $kmsql=mysqli_query($con, "select id,subjectName from t_subjectset where id=".$bgfy["subjectType_id"]);
                     $km=mysqli_fetch_array($kmsql,MYSQLI_ASSOC);
                     echo $km["subjectName"];
                     ?>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">借 (收)方：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                     <?php echo $bgfy["borrowMoney"];?>元</td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">贷 (支)方：</td>
                   <td align="left" class="editcell" style="width:30%;"><?php echo $bgfy["loanMoney"];?>元</td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">经 办  人：</td>
                     <td align="left"  class="editcell" style="width:30%;">
                     <?php $personsql=mysqli_query($con, "select realName from t_user where id=".$bgfy["operator"]);
                     $person=mysqli_fetch_array($personsql);
                     echo $person["realName"];
                     ?>
                     </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>

                 <td align="right" class="editcellmessage" style="width:15%;">经办日期：</td>
                   <td align="left" class="editcell" style="width:30%;">
                   <?php echo $bgfy["creattime"];?>
                   </td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                </tr>
           
                 
                <tr>
                    <td align="right"  class="editcellmessage" style="width:15%;">记账账户：</td>
                     <td align="left"  class="editcell"  colspan="5">
                      <?php 
                      $accountsql=mysqli_query($con, "select accountTitle from t_account where id=".$bgfy["acount"]);
                      $account=mysqli_fetch_array($accountsql);
                      
                      
                      echo $account["accountTitle"];?>
                     
                     </td>
                </tr>
                <tr>
                    <td align="right" class="editcellmessage" style="width:15%;">摘&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;要：</td>
                    <td align="left" class="editcell" colspan="5">
                      <?php echo $bgfy["digest"];?>
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
         


 
  </form></div>