<?php
	include '../../connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	session_start();

	$ecid = $conn->real_escape_string($_POST['ecid']);

	$sql = "UPDATE EmployeeCategories
		SET EmpCategoryId = '".$ecid."'
		WHERE EmpCategoryId = '". $ecid . "'";

	$conn->query($sql);
	echo 1;
}
