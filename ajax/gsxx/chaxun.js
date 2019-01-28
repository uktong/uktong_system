$(function(){
	$.post("db/gsxx.php?type=ajax&action=chaxun",function(result){
		
	    $("#datacontent").html(result);
	  });
});
