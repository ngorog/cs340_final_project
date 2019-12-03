$(document).ready(function(){
	//Edit Personal Info
	//$(".editMenu").click(function() {
	$(this).on('click', '.editMenu', function() {
		console.log('test');
		editMenu($(this));
	});
});


function editMenu(obj){
	var pid = $(obj).attr('value');
	$(".editMenu[value="+pid+"]").addClass("d-none");
	$(".delMenu").addClass("d-none");
	$("#saveCancel"+pid).removeClass("d-none");

	$.getJSON("javascript/AJAX/getMenuItemInfo.php", {ProductId: pid}, function(data){
		$("#collapser"+pid).attr('href', 'none'); //Disabled collapse
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
		$("#"+pid).submit(function(e){
			e.preventDefault();
			confirmMenu($(this));		
		});
		$(".editCancel").on("click", function() {
			cancelMenu({id:pid});
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
	var id = obj.id
	//Show Edit Hide Save/Cancel
	$("#saveCancel"+id).addClass("d-none");
	$(".delMenu").removeClass("d-none");
	$(".editMenu[value="+id+"]").removeClass("d-none");


	$.getJSON("javascript/AJAX/getMenuItemInfo.php", {ProductId: obj.id}, function(data){	
		//Add back new values
		$("#"+id).replaceWith($('<div id=menuItem'+id+' class="my-3 p-3 bg-white rounded shadow-sm">' + $("#"+id)[0].innerHTML + '</div>')); //Change to form for submit
		$("#namePrice"+id).html(data.ProductName + ' - $' + data.Price);
		$("#description"+id).html(data.Description);
		$("#collapser"+id).attr('href', '#collapse'+id);
	});
}
