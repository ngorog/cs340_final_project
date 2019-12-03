<?php
	include 'connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	session_start();
	if(!$conn){
		die("Unable to connect to database " . mysql_error());
	}

	if(isset($_SESSION['AccountId'])){
		$ID = $_SESSION['AccountId'];
	}
	else{
		header("Location: index.php");
		exit();
	}
?>

<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Employee Information</title>
        <link rel="stylesheet" href="index.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script type='text/javascript' src="jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>
        <script src="javascript/employees.js"></script>
    </head>


    <body class='bg-light'>
		<?php include 'header.php' ?>
        <div class='container'>
            <!-- Header -->
           <div class='p-3 my-3 text-dark-50 bg-white rounded shadow'>
                <h4 class='text-center'> Lucky Dragon Employee Information </h4>
           </div>

			<!-- Menu Items -->

			<!-- SQL Query -->
			<table class='table'>
				<thead class='thead-dark'>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Position Name</th>
						<th>Payrate</th>
						<!--If Manager/Owner -->
						<th></th>
					</tr>
			<?php
				$sql = "SELECT EC.EmpCategory
						FROM Account A
						JOIN Employees E ON A.EmployeeId = E.EmployeeId
						JOIN EmployeeCategories EC on E.EmpCategoryId = EC.EmpCategoryId
						WHERE A.AccountId = $ID";
				$sql_get = $conn->query($sql);
				$status = $sql_get->fetch_assoc();
				$sql_get->close();	


				$sql = "SELECT *
						FROM Employees E
						LEFT JOIN EmployeeCategories EC ON E.EmpCategoryId = EC.EmpCategoryId
						ORDER BY E.EmpCategoryId ASC";
				$sql_get = $conn->query($sql);
				while($row = $sql_get->fetch_assoc()){
				?>
					<tr id ='Employee<?= $row['EmployeeId'] ?>'>
						<td id='FirstName<?= $row['EmployeeId']?>'>
							<?= $row['FirstName']?>
						</td>

						<td id='LastName<?= $row['EmployeeId']?>'>
							<?= $row['LastName']?>
						</td>

						<td id='EmpCat<?= $row['EmployeeId']?>'>
							<?= $row['EmpCategory']?>
						</td>

						<td id='Wage<?= $row['EmployeeId']?>'>
							<?= $row['Wage']; ?>
						</td>
						<!--If Manager/Owner -->
						<td>
							<?php if($status['EmpCategory'] == 'Manager' || $status['EmpCategory'] == 'Owner') :?>
								<div class="d-flex page-header clearfix justify-content-center mb-3">
									<a href='updateEmp.php?id=<?= $row['EmployeeId'] ?>'>
										<button class='ml-2 btn btn-info'>Edit</button>
									</a>
									<a href='deleteEmployee.php?id=<?= $row['EmployeeId'] ?>'>
										<button class='ml-2 btn btn-danger fas fa-trash'></button>
									</a>
								</div>
							<?php endif; ?>
						</td>
					</tr>
				<?php
				}
				$sql_get->close();
			?>
			</table>
        </div>
			<?php if($status['EmpCategory'] == 'Manager' || $status['EmpCategory'] == 'Owner') :?>
					<div class="d-flex page-header clearfix justify-content-center mb-3">
							 <a href="addEmployee.php" class="btn btn-success pull-right">Add New Employee</a>
					 </div>
			<?php endif; ?>
        <!-- End Container -->
    </body>
</html>
