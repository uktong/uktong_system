 <?php 
 session_start();
 require_once $_SESSION["ROOT"].'/other/check.php';
 require_once $_SESSION["ROOT"].'/db/db.php';
 date_default_timezone_set('prc');
 $hotel=$_GET["id"];
 
 ?>
 <script>

function getft(id){
	$.post("zyzx/ft.php",{id:id,hotel:<?php echo  $hotel;?>},function(data){
	$("#ft").html(data);	});
}
 </script>
 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->

 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="zyzx/jdft.php?action=edit&id=<?php echo  $hotel;?>" method="post"  enctype="multipart/form-data">

       <table cellpadding="0" border="0" cellspacing="0" class="edittable" >
            <tbody>
               <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;">酒店：
                         
                   
                   </td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left"  class="editcell" style="width:30%;">
                    
           <?php 
           $jddiansql=mysqli_query($con, "select hotelname from t_allhotel where id=".$hotel);
           $jddian=mysqli_fetch_array($jddiansql);
           echo $jddian["hotelname"];
           ?>
               </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                <tr>
                 <td align="right" class="editcellmessage" style="width:15%;"></td>
                   <td align="left" class="editcell" style="width:30%;">房间类型：
                         
                   
                   </td>
                     <td align="left" class="editcellverify" style="width:5%;"></td>
                    <td align="right"  class="editcellmessage" style="width:15%;"></td>
                     <td align="left"  class="editcell" style="width:30%;">
                    
                     <select class="ftbox" name="roomtype"  onchange="getft($(this).val());" >
		<option value="">------</option>
		<?php 
		$resultnow=mysqli_query($con,"select * from t_baseconfig where basenote=2 " );
		$resultnowarray=mysqli_fetch_all($resultnow,MYSQLI_ASSOC);
		for($a=0;$a<count($resultnowarray);$a++){
		?>
		<option value="<?php echo $resultnowarray[$a]["id"];?>"><?php echo $resultnowarray[$a]["basetype"];?></option>
<?php }?>
	</select>
               </td>
                    <td align="left"  class="editcellverify" style="width:5%;"></td>
                </tr>
                
                </tbody>
                <tbody id="ft"></tbody>
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