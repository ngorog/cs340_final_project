$(document).ready(function(){
	//Edit Personal Info
	$(".editMenu").click(function() {
		console.log($(this));
		editMenu($(this));
	});
//	$("#pInfoTable").on("keypress", ".editP", function(e){
//		if(e.key == "Enter")
//			confirmPEdits();
//	})
//	$("#confirmPInfo").on("click", confirmPEdits);
//	$("#cancelPInfo").on("click", cancelPEdits);
});


function editMenu(obj){
	var pid = $(obj).attr('value');
	$.getJSON("javascript/AJAX/getMenuItemInfo.php", {ProductId: pid}, function(data){
		console.log(data);
		$("#name"+pid).html("<input class='form-control d-inline' type='text' id='editName'"+pid+" placeholder='"+data.ProductName+"'></input>");
		$("#price"+pid).html("<input class='form-control d-inline' type='text' id='editPrice'"+pid+" placeholder='$"+data.Price+"'></input>");
	});


}

function confirmMenu(){

}

function cancelMenu(){

}
