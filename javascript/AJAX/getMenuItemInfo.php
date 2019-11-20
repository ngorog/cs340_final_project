<?php
	include '../../connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	session_start();

	if(isset($_GET['ProductId'])){
		$pid = $_GET['ProductId'];
		$sql = "SELECT P.`ProductName`, P.`Price`, P.`Description`
				FROM `Product` P
				WHERE P.`ProductId` =".$pid;
		$sql_get = $conn->query($sql);
		$row = $sql_get->fetch_assoc();
		$sql_get->close();
		$json_data = json_encode($row);

		echo $json_data;
	}
?>
