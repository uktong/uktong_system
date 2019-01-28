<?php
session_start();
require_once $_SESSION["ROOT"].'/other/check.php';
require_once $_SESSION["ROOT"].'/db/db.php';

?>

<div class="pageContent">

	<form method="post" action="ajax/dh/lxr.php" class="pageForm required-validate" onsubmit="return dwzSearch('lxr', 'dialog');">
		<div class="pageFormContent" layoutH="58">
<div class="unit">
				<label>姓名：</label>
				<input type="text" name="username" size="30"  />
			</div>
			<div class="unit">
				<label>手机：</label>
				<input type="text" name="phone" size="30"  />
			</div>
			<div class="unit">
				<label>电话：</label>
			<input type="text" name="tel" size="30"  /></div>
			<div class="unit">
				<label>传真：</label>
				<input type="text" name="fax" size="30"  />
			</div>
			<div class="unit">
				<label>qq：</label>
				<input type="text" name="qq" size="30"  />
			</div>
			<div class="unit">
				<label>职务：</label>
				<input type="text" name="duty" size="30"  />
			</div>
				<div class="unit">
			<div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div>
			</div>
			
		</div>
		
	</form>
	
</div>
