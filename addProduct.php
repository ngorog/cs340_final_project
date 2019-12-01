<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);
	include 'connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	session_start();
	if(!$conn){
		die("Unable to connect to database " . mysql_error());
	}
	if(isset($_SESSION['AccountId'])){
		$ID = $_SESSION['AccountId'];
	}

	$pName = $pDesc = "";
	$pPrice = $check = $isFood = $isDrink = 0;

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$pName = $_POST["prodname"];
		$pDesc = $_POST["produdesc"];
		$pPrice = $_POST["prodprice"];
		$check = $_POST["foodCheck"];
		if ($check == "1"){
			$isFood = "1";
			$isDrink = "0";
		}
		else if ($check == "0"){
			$isFood = "0";
			$isDrink = "1";
		}
		$sql = "INSERT INTO `Product` (ProductName, Description, IsFood, IsDrink, Price) VALUES ('$pName', '$pDesc', '$isFood', '$isDrink', '$pPrice')";
		$conn->query($sql);
	}
	else{
	echo "<p>Insertion Failed <br/> Some Fields are Blank....!!</p>";
	}
	header("Location: menu.php");
	exit();
?>
