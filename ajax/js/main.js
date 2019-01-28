$(function(){
	$(".getdata").bind('input propertychange', function() {
		$(this).attr("suggestUrl","ajax/xlk.php?name="+$(this).val()+"&type="+$(this).attr("data-type"));
		if($(this).val()==""){
			$(this).prev("input").val("");
		}
	});
	$(".default").click(function() {
		$(this).attr("href","ajax/dh/"+$(this).attr("lookupGroup")+".php");
	});
	

});
function getjdian(id){
	$(".getjdian"+id).attr("suggestUrl","ajax/xlk/jdian.php?id="+id+"&name="+$(".getjdian"+id).val());
}
function getjgs(id){
	$(".getlxs"+id).attr("suggestUrl","ajax/xlk/lxs.php?id="+id+"&name="+$(".getlxs"+id).val());
}