<?php 
session_start();
require_once $_SESSION["ROOT"].'/db/db.php';
			$lv=$_GET["lv"];
			if($lv=="all"){
			    $result=mysqli_query($con,"select * from t_allhotel ");
			}else{
			$result=mysqli_query($con,"select * from t_allhotel where hotellevelid=".$lv );
			}
			$resultarray=mysqli_fetch_all($result,MYSQLI_ASSOC);
			//分页显示
			$resultnum=count($resultarray);

			for($a=0;$a<$resultnum;$a++){
			 
			    ?>
			  <tr>
			  <td align="center"><input name="hotelid[]" value="<?php echo $resultarray[$a]["id"]?>" type="checkbox"></td>
			  <td align="center"><?php echo $resultarray[$a]["hotelname"]?></td>
			  </tr> 
	<?php }
 
    ?>
