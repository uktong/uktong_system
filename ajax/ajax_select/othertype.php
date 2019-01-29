<?php
//base start
require "../../hzb/config.php";
require R.'hzb/inc/load.php';
//base end
?>
<script type="text/javascript">
$(function(){

	$(".getothercus").change(function(){
		$(this).parent().parent().parent().parent().parent().parent().find(".planremark").val($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().find("#krxx").val());
		
		});
	$(".countother").change(function(){
	var parent=$(this).parent().parent();
  	var thissingleprice=parent.find(".singleprice").val();

  	var thisamount=parent.find(".amount").val();

  	
  	parent.find(".othertatalprice").text(thissingleprice*thisamount);

	var otherallprice=0;

	parent.parent().parent().parent().find('.othertatalprice').each(function (){

		otherallprice+=parseFloat($(this).text());

		});
	parent.parent().parent().parent().find('.otherallprice').text(otherallprice);
	});

	
});

</script>
<select  name="others#index#.type" class="combox getothercus"  >
		<option value="">------------------</option>
	<?php 
	$fjtypere=$db->select("t_baseconfig","*","basenote=14 order by px");

	for($f=0;$f<count($fjtypere);$f++){
	?>
		
	<option value="<?php echo $fjtypere[$f]["id"];?>"><?php echo $fjtypere[$f]["basetype"];?></option>
	<?php }?>
	</select>