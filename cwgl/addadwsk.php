<?php
//base start
require "../hzb/config.php";
require R.'hzb/inc/load.php';
//base end
//check add
$jur=$base->getJur(md5($_COOKIE["username"]),"name",$_GET["J"]);
$J->type($jur, "add");
?>
<script type="text/javascript" src="ajax/js/main.js"></script>

<div class="pageContent">
<form method="post" action="db/addadwsk.php?action=charu"  onsubmit="return validateCallback(this, dialogAjaxDone) " class="pageForm required-validate" >

<div class="pageHeader">
<h2 class="contentTitle" style="text-align: center;">新增按单位收款</h2>
		
	<div class="searchBar">
	
		<table class="searchContent cwsearch" id="fftable"   cellspacing="0">
			<tr>
				<td >
					旅行社：
				<input type="hidden" name="zts.id" id="travelsk" value="<?php echo @$_POST["zts_id"];?>"/>
				<input type="text" class="getzts required"  name="zts.zts" value="<?php echo @$_POST["zts_zts"];?>" style="width:100px; " suggestFields="zts"  lookupGroup="zts" />
				<a class="btnLook" href="ajax/dh/zts.php"style="float:right;margin-right:100px;"  lookupGroup="zts">选择用户</a>
				</td><td>	归档时间:
				<select name="gdmonth" id="gdmonthfk">
				<option value="">------</option>
				<?php for($m=1;$m<13;$m++){?>
				<option value="<?php echo $m;?>" <?php if($m==date("m")){echo "selected='selected'";}?>><?php echo $m;?>月</option>
				<?php }?>
				</select></td>
				<td >
					金额：
					<input type="hidden" name="havingmoney" id="skhavingmoney" value="0">
				<input type="text" name="money"  id="allmoney" onchange="$('#sklastmoney').html($(this).val());$('#havingmoney').val($(this).val());"  style="width:100px;" value="0"/>余额：<span id="sklastmoney">0</span>
				</td></tr>

	<tr> 
				<td >
					方式：
					<select   name="paytype" >
			<option value="">------</option>
			<?php $getpaytype=mysqli_query($con, "select * from t_baseconfig where basenote=5 ");
			$getpay=mysqli_fetch_all($getpaytype, MYSQLI_ASSOC);
			foreach ($getpay as $pay){
			?>
			<option <?php 
			if(isset($_POST["paytype"])&&$_POST["paytype"]==$pay["id"]){
			    echo "selected='selected'";
			}
			?> value="<?php echo $pay["id"];?>"><?php echo $pay["basetype"];?></option>
			<?php }?>
			</select>
				</td><td>日期：<input name="doDate" class="date readonly" readonly="readonly" type="text" value="<?php
					echo  isset($_POST["startDate"])?$_POST["startDate"]:$today;?>"></td>
				<td >
					发票金额：
					<input name="invoice"  type="text" size="30" style="width:150px;" value="<?php echo @$_POST["invoice"];?>" />
				</td>
				</tr><tr>
				<td >
					账户：
					<select   name="account" id="account"  onchange="getyue()">
			<option value="">------</option>
			<?php $getpaytype=mysqli_query($con, "select * from t_account ");
			$getpay=mysqli_fetch_all($getpaytype, MYSQLI_ASSOC);
			foreach ($getpay as $pay){
			?>
			<option <?php 
			if(isset($_POST["paytype"])&&$_POST["paytype"]==$pay["id"]){
			    echo "selected='selected'";
			}
			?> value="<?php echo $pay["id"];?>"><?php echo $pay["accountTitle"];?>-<?php echo $pay["bankName"];?>-<?php echo $pay["accountNumber"];?></option>
			
			<?php }?>
			</select><span id="yue" style="color:red;"></span>
				</td>
			
				<td>收款人：<?php require R.'temp/search/user.php';?></td>
				
			<td >
					备注：
				<input type="text" name="remark" id="remark" style="width:150px;" value="<?php echo @$_POST["remark"];?>"/>
				</td>
			</tr>
		</table>
		
	</div></div>



	
	


	
	<div class="formBar cwglbtn"  >
			<ul>
				<li ><div class="buttonActive" ><div class="buttonContent"><button type="submit" >保存</button></div></div></li>
				<li ><div class="buttonActive" ><div class="buttonContent" ><button class="close " >关闭</button></div></div></li>
			</ul>
		</div>
		</form>
		
</div>