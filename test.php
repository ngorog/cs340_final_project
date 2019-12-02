<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

$dir = "img";
$picTypes = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$errorinfo = $_FILES["myFile"]["error"];
	$filename = $_FILES["myFile"]["name"];
	$filesize = $_FILES["myFile"]["size"];
	$filetype = $_FILES["myFile"]["type"];
	echo "<p> Type ".$filetype."<p>";
	if (file_exists("$dir/"."51.jpg")) {
		unlink("$dir/"."51.jpg");
	}
	if ((in_array($filetype, $picTypes))  && $filesize < 3048576) {
		move_uploaded_file($_FILES['myFile']['tmp_name'], "$dir/" . '51.jpg');
		chmod("$dir/" . '51.jpg', 0775);
		echo "<p>New file ".$dir."  ".'51.jpg';
	} else {
		echo "Only jpegs/jpg/gif/png under 1MB";
		echo "<p>".$filename." not uploaded";
	}
}

$jpgs = glob("$dir/*.*");
sort($jpgs);
echo "<h1> Files in ".$dir."  Directory <h1>";
echo "<table>";
foreach($jpgs as $jpg) {
	echo "<tr><td><a href='$dir/" . rawurlencode(substr($jpg, strlen($dir)+1)) . "' target='n'>" .
	htmlspecialchars(substr($jpg, strlen($dir)+1)) . "</a></td></tr>";
}
echo "</table>";
?>

<!DOCTYPE html>
<!-- upload3.html -->
<html>
	<head> 
		<title>File Upload 3</title>
	</head>
	<body>
		<h2>File Upload 3 </h2>
		<h3> File is placed in local directory and then the contents of the directory are displayed</h3>
		<form action="test.php" method="post" enctype="multipart/form-data">
			Select image to upload:<input type="file" name="myFile" id="myFile">
			<input type="submit" value="Upload Image" name="submit">
		</form>
	</body>
</html>
