 <div class="pageContent">
<!-- db/gsxx.php?type=ajax&action=charu -->
<?php 
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
$qxsql=mysqli_query($con, "select userlimit from t_traveluser where id=".$_GET["id"]);
$qx=mysqli_fetch_array($qxsql);
$allqx=explode(",", $qx["userlimit"]);
$show="checked";
$hide="";
$limitshow=$hide;
$limitedit=$hide;
$limitadd=$hide;
$limitchangepwd=$hide;
for($q=1;$q<count($allqx);$q++){
    if($allqx[$q]=="show"){
        $limitshow=$show;
    }
    if($allqx[$q]=="sure"){
        $limitedit=$show;
    }
    if($allqx[$q]=="new"){
        $limitadd=$show;
    }
    if($allqx[$q]=="updatepwd"){
        $limitchangepwd=$show;
    }
}
?>
 <form  onsubmit="return navTabSearch(this);" class="pageForm" action="zhzx/lxszh.php?action=qxgl&id=<?php echo $_GET["id"];?>" method="post"  enctype="multipart/form-data">
                <table cellpadding="0" border="0" cellspacing="0"  width="100%"class="edittable">
            <tbody>
                 <tr>
                     <td  align="center" >待定项目</td>
                     <td align="center" >
                
                     订单确认<input type="checkbox" name="qx[]" <?php echo $limitedit;?> value="sure">
                      临时订单<input type="checkbox" name="qx[]" <?php echo $limitadd;?> value="new">
                         订单查看<input type="checkbox" name="qx[]" <?php echo $limitshow;?> value="show">
                     </td>
                     
                </tr>
                
               <tr>
                     <td align="center"  >系统管理:</td>
                     <td align="center" >
                    密码修改<input type="checkbox" name="qx[]" <?php echo $limitchangepwd;?> value="updatepwd">
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
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
			</ul>
		</div>
 
  </form></div>