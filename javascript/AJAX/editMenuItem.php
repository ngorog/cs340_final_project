<?php
	include '../../connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	session_start();

	if(isset($_POST['id']) && isset($_POST['price']) && isset($_POST['name']) && isset($_POST['desc'])){
		$pid = $conn->real_escape_string($_POST['id']);
		$name = $conn->real_escape_string($_POST['name']);
		$price = $conn->real_escape_string($_POST['price']);
		$desc = $conn->real_escape_string($_POST['desc']);
		
		$sql = "UPDATE Product
					SET ProductName   ='".$name."',
						Price         ='".$price."',
						Description   ='".$desc."'
					WHERE
						ProductId = '". $pid . "'";
		$conn->query($sql);
		echo 1;
	}
	else{
		echo 0;
	}
?>
