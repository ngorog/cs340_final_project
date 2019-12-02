<?php
	include 'connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	session_start();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(-1);
	if(isset($_POST['del_btn']) and is_numeric($_POST['del_btn'])){
		$del = $_POST['del_btn'];
		$sql = "DELETE FROM Product WHERE ProductId = $del";
		$conn->query($sql);
		header("location: menu.php");
		exit();
	} 
?>
