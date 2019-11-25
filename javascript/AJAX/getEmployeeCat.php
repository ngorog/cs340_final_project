<?php
	include '../../connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	$sql = "SELECT *
		FROM 'EmployeeCategories";

	$result = $conn->query($sql);
	$posList = array();
	while($row = $sql_get->fetch_assoc()) { //Make while($row = $sql_get->fetch_assoc) , append to PHP object and json_encode it
		$EmpCat = array('EmpCategory' => $row['EmpCategory'],
                    'EmpCategoryId' => $row['EmpCategoryId']);
		array_push($posList, $EmpCat);
	}

	$sql_get->close();
	$json_data = json_encode("hello");

	echo $json_data;
?>
