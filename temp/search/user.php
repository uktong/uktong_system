<input type="hidden" name="jd.id" value="<?php
					echo  isset($_POST["jd_id"])?$_POST["jd_id"]:'';?>"/>
				<input type="text" class="getdata textInput" data-type="jd" name="jd.jd" value="<?php
					echo  isset($_POST["jd_jd"])?$_POST["jd_jd"]:'';?>" suggestFields="jd"  lookupGroup="jd" />
				<a class="btnLook default" style="float: right;"  lookupGroup="jd">选择用户</a>