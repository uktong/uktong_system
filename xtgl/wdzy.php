<?php 
session_start();
require $_SESSION["ROOT"].'/db/db.php';
$getsql=mysqli_query($con, "select * from t_zygl ");
$msg=mysqli_fetch_array($getsql);
?>
<div style="display:block; overflow:hidden; padding:0 10px; line-height:21px;">
	
	<div class="tabs">
		
		<div class="tabsContent" layoutH="100">
			<div>
				<form method="post" action="db/zygl.php" class="pageForm required-validate" onsubmit="return validateCallback(this,navTabAjaxDone)">
					<div class="pageFormContent" layoutH="158">
						<div class="unit">
							<textarea class="editor" name="description" rows="40" cols="150">
							<?php echo htmlspecialchars_decode($msg["detext"]);?>
							</textarea>
						</div>
					
					</div>
					<div class="formBar">
						<ul>
							<li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
							<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
						</ul>
					</div>
				</form>
			</div>
			
			<div>

			</div>
			
		</div>
		<div class="tabsFooter">
			<div class="tabsFooterContent"></div>
		</div>
	</div>

</div>