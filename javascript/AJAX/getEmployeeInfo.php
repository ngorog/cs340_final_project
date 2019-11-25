<?php
	include '../../connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	session_start();

	if(isset($_GET['EmployeeId'])) {
		$eid = $_GET['EmployeeId'];
		$sql = "SELECT E.`FirstName`, E.`LastName`, E.`Wage`, EC.`EmpCategory`
			FROM `Employees` E
			LEFT JOIN `EmployeeCategories` EC ON E.`EmpCategoryId` = EC.`EmpCategoryId`
			WHERE E.`EmployeeId` = ".$eid;
		$sql_get = $conn->query($sql);
		$row = $sql_get->fetch_assoc();
		$sql_get->close();
		$json_data = json_encode($row);

		echo $json_data;
	}
?>
