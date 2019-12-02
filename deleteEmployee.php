<?php
	session_start();
	include 'connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if(!$conn){
		die("Unable to connect to database " . mysql_error());
	}
	
	if(isset($_POST["id"]) && !empty($_POST["id"])){
		$id = $_POST['id'];
		$sql = "DELETE FROM Employees WHERE EmployeeId = $id";
		$conn->query($sql);	
		header("location: employees.php");
		exit();
	} 
?>

<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Menu</title>
        <link rel="stylesheet" href="index.css">
		<script type='text/javascript' src="jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<script src="javascript/menu.js"></script>
    </head>


    <body class='bg-light'>
		<?php include 'header.php'?>
		<div class="container">
			<h1>Delete Record</h1>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="alert alert-danger fade in">
					<input class='d-none' name="id" value="<?php echo trim($_GET["id"]); ?>"/>
					<p>Are you sure you want to delete this record?</p><br>
						<input type="submit" value="Yes" class="btn btn-danger">
						<a href="employees.php" class="btn btn-default">No</a>
				</div>
			</form>
		</div>
    </body>
</html>
