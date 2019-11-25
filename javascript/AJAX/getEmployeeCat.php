<?php
	include '../../connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	$sql = "SELECT * FROM EmployeeCategories";

	$result = $conn->query($sql);
	$posList = array();
	while($row = $result->fetch_assoc()) { 
		$EmpCat = array('EmpCategory' => $row['EmpCategory'],
                    'EmpCategoryId' => $row['EmpCategoryId']);
		array_push($posList, $EmpCat);
	}
	$result->close();
	if(!$posList)
		$json_data = json_encode("hello");
	else
		$json_data = json_encode($posList);

	echo $json_data;
?>
