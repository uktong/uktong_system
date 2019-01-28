<?php
require "hzb/config.php";

setcookie("user", "", time()-3600);
setcookie("usertype", "", time()-3600);
setcookie("hotelcode", "", time()-3600);
setcookie("userid", "", time()-3600);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $servername.$version;?>-登录</title>
<link href="themes/css/login.css" rel="stylesheet" type="text/css" />

</head>

<body >
	<div id="login">
		<div id="login_header">
			<h1 class="login_logo">
				<!-- <a href="http://demo.dwzjs.com"><img src="themes/default/images/login_logo.gif" /></a> -->
			</h1>
			<div class="login_headerContent">
				<div class="navList">
					<ul>
						
					</ul>
				</div>
				
			</div>
		</div>
		<div id="login_content">
			<div class="loginForm">
			<br><br><br><br><br><br><br>
				<form action="action/login.php" method="post" >
					<p>
						<label>用户名：</label>
						<input type="text" name="username"  id="username" size="20" class="login_input" />
					</p><br>
					<p>
						<label>密码：</label>
						<input type="password" name="password" id="password" size="20" class="login_input" />
					</p><br>
					<p>
						<label>验证码：</label>
						<input class="code" name="code" id="code" type="text" size="5" />
						<span>
						<img  title="点击获取" src="" id="codeimg" align="absbottom" onclick="this.src='code.php?'+Math.random();"  width="75" height="24"></img></span>
					</p>
					<br>
					<br><br><br>
					<br>
					<br>
					<br>
					<br>
					<div class="login_bar">
						<input class="sub" type="submit"  value=" " />
					</div>
				</form>
			</div>
			<div class="login_banner"><img src="themes/default/images/login.png" style="width:630px;" /></div>
			<script type="text/javascript">
window.onload=function(){
    codeimg=document.getElementById("codeimg");
    codeimg.src="code.php?"+Math.random();

}
</script>
		</div>
		<div id="login_footer">
			Copyright &copy; 2019 uktong. All Rights Reserved.
		</div>
	</div>
</body>
</html>