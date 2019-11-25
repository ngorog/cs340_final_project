<?php
	include '../../connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	session_start();

	if(isset($_POST['id']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['posid']) && isset($_POST['wage'])) {
		$eid = $conn->real_escape_string($_POST['id']);
		$fname = $conn->real_escape_string($_POST['fname']);
		$lname = $conn->real_escape_string($_POST['lname']);
		$posid = $conn->real_escape_string($_POST['posid']);
		$wage = $conn->real_escape_string($_POST['wage']);
		
		$sql = "UPDATE Employees
			SET FirstName = '".$fname."',
				LastName = '".$lname."',
				Wage = '".$wage."',
				EmpCategoryId = '".$ecid."'
			WHERE
				EmployeeId = '". $eid . "'";

		$conn->query($sql);
		echo 1;
	}

	else {
		echo 0;
	}
?>
