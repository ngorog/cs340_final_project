$(document).ready(function(){
	//Edit Personal Info
	$(".editMenu").click(function() {
		editMenu($(this));
	});
//	$("#cancelPInfo").on("click", cancelPEdits);
});


function editMenu(obj){
	var pid = $(obj).attr('value');
	$(".editMenu[value="+pid+"]").addClass("d-none");
	$("#saveCancel"+pid).removeClass("d-none");
	$.getJSON("javascript/AJAX/getMenuItemInfo.php", {ProductId: pid}, function(data){
		$("#collapser").attr('href', 'none'); //Disabled collapse
		$("#menuItem"+pid).replaceWith($('<form id='+pid+' class="my-3 p-3 bg-white rounded shadow-sm">' + $("#menuItem"+pid)[0].innerHTML + '</form>')); //Change to form for submit
		$("#namePrice"+pid).html(
			"<div class='row'>"+
				"<div class='col'>"+
					"<input id='editName' type='text' class='form-control' minlength='2' maxlength='45' value='"+data.ProductName+"'>"+
				"</div>"+
				"<div class='col'>"+
					"<input id='editPrice' type='number' min='0.00' max='1000.00' step='0.01' class='form-control' value='"+data.Price+"'>"+
				"</div>"+
			"</div>");
		$("#description"+pid).html("<textarea class='form-control' minlength='10' maxlength='500' id='editDescription'>"+data.Description+"</textarea>");
		//Add event listener to new form for submittal
		$("form").submit(function(e){
			e.preventDefault();
			confirmMenu($(this));		
		});
	});
}

function confirmMenu(obj){
	var pid = obj.attr('id');
	var newPrice = obj.find("#editPrice").val();
	var newName = obj.find("#editName").val();
	var newDesc = obj.find("#editDescription").val();

	var ItemInfo = {
		'id': pid,
		'price': newPrice,
		'name': newName,
		'desc': newDesc
	};
	
	$.post("javascript/AJAX/editMenuItem.php", ItemInfo, function(data){
		cancelMenu(ItemInfo);
	});

}

function cancelMenu(obj){
	//Show Edit Hide Save/Cancel
	$("#saveCancel"+obj.id).addClass("d-none");
	$(".editMenu[value="+obj.id+"]").removeClass("d-none");

	//Add back new values
	$("#"+obj.id).replaceWith($('<div id=menuItem'+obj.id+' class="my-3 p-3 bg-white rounded shadow-sm">' + $("#"+obj.id)[0].innerHTML + '</div>')); //Change to form for submit
	$("#namePrice"+obj.id).html(obj.name + ' - $' + obj.price);
	$("#description"+obj.id).html(obj.desc);
	$("#collapser").attr('href', '#collapse'+obj.id);
}
