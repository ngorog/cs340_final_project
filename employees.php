<?php
	include 'connectdb.php';	
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	session_start();
	if(!$conn){
		die("Unable to connect to database " . mysql_error());
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
           <div class='d-flex justify-content-between p-3 my-3 text-dark-50 bg-white rounded shadow'>
                <h4> Lucky Dragon Employee Information </h4>
           </div>

			<!-- Menu Items -->
			
			<!-- SQL Query -->
			
			
			<div class='table'>
					<div class='row'>
						<div class='col'>First Name</div>
						<div class='col'>Last Name</div>
						<div class='col'>Position Name</div>
						<div class='col'>Payrate</div>
						<!--If Manager/Owner -->
					</div>
				<?php
					$sql = "SELECT *
							FROM Employees E
							LEFT JOIN EmployeeCategories EC ON E.EmpCategoryId = EC.EmpCategoryId
							ORDER BY E.EmpCategoryId ASC";
					$sql_get = $conn->query($sql);
					while($row = $sql_get->fetch_assoc()){
				?>
				
				<form method="post" action="employees.php?action=add&code=<?= $row['EmployeeId'] ?>">
				<div class='row'>
					
					<form method="post" action="employees.php?action=add&code=<?= $row['EmployeeId'] ?>">
					<div id='FirstName<?= $row['EmployeeId']?>' class='col'>
						<?= $row['FirstName']?>
					</div>
	
					<div id='LastName<?= $row['EmployeeId']?>' class='col'>
						<?= $row['LastName']?>
					</div>

					<div id='EmpCat<?= $row['EmployeeId']?>' class='col'>
						<?= $row['EmpCategory']?>
					</div>

					<div id='Wage<?= $row['EmployeeId']?>' class='col'>
						<?= $row['Wage']; ?>
					</div>
				<!--If Manager/Owner -->
					<div id='rowbutton'>
						<button class='editEmployees btn btn-info btn-sm' type='button' value='<?= $row['EmployeeId'] ?>'>Edit</button>
						<span id='saveCancel<?= $row['EmployeeId'] ?>' class='d-none'>						
							<button class='editCancel<?= $row['EmployeeId']?> btn btn-secondary btn-sm' type='button' value='<?= $row['EmployeeId'] ?>'>Cancel</button>
							<button class='editSave<?= $row['EmployeeId']?> btn btn-success btn-sm' type='submit' value='<?= $row['EmployeeId']?>'>Save</button>
						</span>
					</div>
				</div>
				</form>
				<?php
				}
				$sql_get->close();
			?>
			</div>
        </div>
        <!-- End Container -->
    </body>
</html>
