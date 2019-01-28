<?php 
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';
$usertype= $_SESSION["usertype"];
$id=$_SESSION["userid"];
$name=$_SESSION["user"];
if(isset($_GET["action"])){
    $oldpwd=$_POST["oldPassword"];
    $newpwd=$_POST["newPassword"];
    switch ($usertype){
        case "lxs":
            $table="t_user";
            break;
        case "hotel":
            $table="t_hoteluser";
            break;
        case "travel":
            $table="t_traveluser";
            break;
    }
    $checksql=mysqli_query($con, "select * from ".$table." where username='".$name."' and password='".$oldpwd."'");
    echo "seelct * from ".$table." where username='".$name."' and password='".$oldpwd."'";
    if(@mysqli_num_rows($checksql)!=0){
        mysqli_query($con, "update ".$table." set  password='".$newpwd."' where id=".$id);
        echo "<script>alert('修改成功，请重新登录！');window.location.replace('login.php');</script>";
    }else{
        
        echo "<script>alert('密码错误，请重新输入！');</script>";
    }
}
?>

<div class="pageContent">

	<form method="post" action="xtgl/changepwd.php?action=change" class="pageForm required-validate" onsubmit="return navTabSearch(this)">
		<div class="pageFormContent" layoutH="58">
<div class="unit">
				<label>用户名：</label>
				<?php echo $name;?>
			</div>
			<div class="unit">
				<label>旧密码：</label>
				<input type="password" name="oldPassword" size="30" minlength="6" maxlength="20" class="required" />
			</div>
			<div class="unit">
				<label>新密码：</label>
				<input type="password" id="cp_newPassword" name="newPassword" size="30" minlength="6" maxlength="20" class="required alphanumeric"/>
			</div>
			<div class="unit">
				<label>重复输入新密码：</label>
				<input type="password" name="rnewPassword" size="30" equalTo="#cp_newPassword" class="required alphanumeric"/>
			</div>
				<div class="unit">
			<div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div>
			</div>
			
		</div>
		
	</form>
	
</div>
