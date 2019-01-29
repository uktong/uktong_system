
<input type="hidden" name="zts.id" value="<?php
echo  isset($_POST["zts_id"])?$_POST["zts_id"]:'';?>"/>
<input type="text" class="getdata textInput" data-type="zts" name="zts.zts" value="<?php
echo  isset($_POST["zts_zts"])?$_POST["zts_zts"]:'';?>" suggestFields="zts"   lookupGroup="zts" />
<a class="btnLook default" style="float: right;"  lookupGroup="zts">选择组团社</a>