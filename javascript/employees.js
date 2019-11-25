$(document).ready(function(){
	//Edit Personal Info
	//$(".editMenu").click(function() {
	$(this).on('click', '.editEmployees', function() {
		editEmployees($(this));
	});
});


function editEmployees(obj){
	var eid = $(obj).attr('value');
	
	$(".editEmployee[value="+eid+"]").addClass("d-none");
	$("#saveCancel"+eid).removeClass("d-none");
	$.getJSON("javascript/AJAX/getEmployeeInfo.php", {EmployeeId: eid}, function(data){
		$("#FirstName"+eid).html("<input id='editFName' type='text' class='form-control' minlength='2' maxlength='45' value='"+data.FirstName+"'>");
		$("#LastName"+eid).html("<input id='editLName' type='text' class='form-control' minlength='2' maxlength='45' value='"+data.LastName+"'>");
		$.getJSON("javascript/AJAX/getEmployeeCat.php", function(data){
			var select = "<select class='form-control'>";
			$(data).each(function(index) {
				select += "<option value="+data[index]['EmpCategoryId']+">"+data[index]['EmpCategory']+"</option>";
			});
			select += "</select>";
			$("#EmpCat"+eid).html(select);
		});
		$("#Wage"+eid).html("<input id='editWage' type='number' min='0.00' max='1000.00' step='0.01' class='form-control'  value='"+data.Wage+"'>");
	
		//Add event listener to new form for submittal
		$("#"+eid).submit(function(e){
			e.preventDefault();
			confirmEmployees($(this));		
		});
		$(".editCancel").on("click", function() {
			cancelEmployees({id:eid});
		});
	});		
	
}

function confirmEmployees(obj) {
	
	var eid = obj.attr('id');
	var newFname = obj.find("#editFName").val();
	var newLname = obj.find("#editLName").val();
	var newEcid = obj.find("#editEmpCat").val();
	var newWage = obj.find("#editWage").val();

	var EmployeeInfo = {
		'id': eid,
		'fname': newFname,
		'lname': newLname,
		'ecid': newEcid,
		'wage': newWage
	};

	$.post("javascript/AJAX/editEmployee.php", EmployeeInfo, function(data) {
		cancelEmployee(EmployeeInfo);
	});
}

function cancelEmployees(obj) {
	var id = obj.id

	$("#saveCancel"+id).addClass("d-none");
	$(".editEmployees[value="+id+"]").removeClass("d-none");

	$.getJSON("javascript/AJAX/getEmployeeInfo.php", {EmployeeId: obj.id}, function(data) {
		$("#FirstName"+id).html(data.FirstName);
		$("#LastName"+id).html(data.LastName);
		$("#EmpCat"+id).html(data.EmpCategory);
		$("#Wage"+id).html(data.Wage);
	});
}
