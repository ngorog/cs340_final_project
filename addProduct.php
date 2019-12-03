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
	$dir = "img/";
	$picTypes = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$pName = $conn->real_escape_string($_POST["prodname"]);
		$pDesc = $conn->real_escape_string($_POST["produdesc"]);
		$pPrice = $conn->real_escape_string($_POST["prodprice"]);
		$check = $conn->real_escape_string($_POST["foodCheck"]);

		$sql = "SELECT AUTO_INCREMENT
			FROM information_schema.TABLES
			WHERE TABLE_SCHEMA = 'cs340_dongrog' AND
			TABLE_NAME = 'Product'";
		$result = $conn->query($sql);
		$sql_res = $result->fetch_assoc();
		$pid = $sql_res['AUTO_INCREMENT'];
		$result->close();

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


		$errorinfo = $_FILES["myFile"]["error"];
		$filename = $_FILES["myFile"]["name"];
		$filesize = $_FILES["myFile"]["size"];
		$filetype = $_FILES["myFile"]["type"];

		$ext = ".jpg";
		$newname = $pid.$ext;
		$target = $dir.$newname;
		if (file_exists($target)) {
			unlink($target);
		}

		if ((in_array($filetype, $picTypes))  && $filesize < 3048576) {
			move_uploaded_file($_FILES['myFile']['tmp_name'], $target);
			chmod($target, 0775);
		}
		else {
			echo "Only jpegs/jpg/gif/png under 1MB";
			echo "<p>".$filename." not uploaded";
		}

	}
	else{
		echo "<p>Insertion Failed <br/> Some Fields are Blank....!!</p>";
	}
/*
	$jpgs = glob("$dir/*.*");
	sort($jpgs);
	echo "<h1> Files in ".$dir."  Directory <h1>";
	echo "<table>";
	foreach($jpgs as $jpg) {
		echo "<tr><td><a href='$dir/" . rawurlencode(substr($jpg, strlen($dir)+1)) . "' target='n'>" .
		htmlspecialchars(substr($jpg, strlen($dir)+1)) . "</a></td></tr>";
	}
	echo "</table>";
*/
	header("Location: menu.php");
	exit();
?>
