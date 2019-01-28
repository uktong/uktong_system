//$(function(){
//	$('.dateRange').on('propertychange',$('#search'), function(){
//				alert($(this).val()); 
//			});
//});

	function delete_f(id){
		$.post("db/gsxx.php?type=ajax&action=delete",{"id":id},function(result){
			$("#"+id).hide();
		    alert("删除成功！");
		    
		  });
	}


	

