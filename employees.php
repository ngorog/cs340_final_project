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

					 <div class="page-header clearfix">
							 <a href="addEmployee.php" class="btn btn-success pull-right">Add New Employee</a>
					 </div>
					 <!--
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
							  Add Employee(s)
							</button>

\							<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLongTitle">Add Employee(s)</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">


											<form method="post"	action="employees.php?action=add&code=<?= $row['FirstName'] ?>">
												<div class="form-group">
												<label for="empfirstname">First Name</label>
												<input type="firstname" class="form-control" id="empfirstname" placeholder="First Name">
												</div>

												<div class="form-group">
												<label for="emplastname">Last Name</label>
												<input type="lastname" class="form-control" id="emplastname" placeholder="Last Name">
												</div>

												<div class="form-group">
													<label for="empPosition"> Employee Position </label>

													<select>
													  <option value="owner">Owner</option>
													  <option value="manager">Manager</option>
													  <option value="cook">Cook</option>
													  <option value="janitor">Janitor</option>
														<option value="waiter">Waiter</option>
														<option value="cashier">Cashier</option>
														<option value="busser">Busser</option>
														<option value="dishwasher">Dish Washer</option>
														<option value="host">Host</option>
														<option value="bartender">Bartender</option>
													</select>
												</div>

												<div class="form-group">
												<label for="empPayrate">Pay Rate</label>
												<input type="payrate" class="form-control" id="empPayrate" placeholder="$0.00 - do not include $">
												</div>

											</form>



							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							        <button type="button" class="btn btn-primary">Submit</button>
							      </div>
							    </div>
							  </div>
							</div>

			-->



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
							<button class='editEmployees btn btn-info btn-sm' type='button' value='<?= $row['EmployeeId'] ?>'>Edit</button>
							<span id='saveCancel<?= $row['EmployeeId'] ?>' class='d-none'>
								<button class='editCancel btn btn-secondary btn-sm' type='button' value='<?= $row['EmployeeId'] ?>'>Cancel</button>
								<button class='editSave btn btn-success btn-sm' type='submit' value='<?= $row['EmployeeId']?>'>Save</button>
							</span>
							<a href='deleteEmployee.php?id=<?= $row['EmployeeId'] ?>'>
								<button class='ml-2 btn btn-danger fas fa-trash'></button>
							</a>
						</td>
					</tr>
				<?php
				}
				$sql_get->close();
			?>
			</table>
        </div>
        <!-- End Container -->
    </body>
</html>
