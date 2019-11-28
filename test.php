<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(-1);
	session_start();
	include 'connectdb.php';	
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$curr_date = date("Y-m-d");	
	$id = 9;
	$total = 10.95;	

	$sql = "INSERT INTO `Orders` (CustomerId, TotalPrice, Date)
			VALUES ($id, $total, '".$curr_date."')";
	$conn->query($sql);	
		
	echo $id . $curr_date . $total;	
?>	
