<?php
//base start
require "../../hzb/config.php";
require R.'hzb/inc/load.php';
//base end
?>
<script type="text/javascript">
$(function(){

	$(".getcus").change(function(){
		$(this).parent().parent().parent().parent().parent().parent().find(".customer").val($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().find("#krxx").val());
		
		});
	$(".count").change(function(){
	var parent=$(this).parent().parent();
  	var thissingleprice=parent.find(".singleprice").val();
  	var thisdays=parent.find(".days").val();
  	var thisamount=parent.find(".amount").val();
  	var thissaleprice=parent.find(".saleprice").val();
  	
  	parent.find(".tatalprice").text(thissingleprice*thisdays*thisamount);
	parent.find(".tatalsaleprice").text(thissaleprice*thisdays*thisamount);
	var allprice=0;
	var allsaleprice=0;
	var allamount=0;
	parent.parent().parent().find('.tatalprice').each(function (){

		allprice+=parseFloat($(this).text());

		});
	parent.parent().parent().find('.allprice').text(allprice);
	parent.parent().parent().find('.tatalsaleprice').each(function (){

		allsaleprice+=parseFloat($(this).text());

		});
	parent.parent().parent().find('.allsaleprice').text(allsaleprice);

	parent.parent().parent().find('.amount').each(function (){

		allamount+=parseFloat($(this).val());

		});
	parent.parent().parent().find('.allamount').text(allamount);
	
		});
	

	
});

</script>
<select  name="items#index#.roomtype" class="combox getcus"  >
		<option value="">------</option>
	<?php 
	$fjtypere=$base->data("room");

	for($f=0;$f<count($fjtypere);$f++){
	?>
		
	<option value="<?php echo $fjtypere[$f]["id"];?>"><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select>