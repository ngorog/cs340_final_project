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
	else{
		header("Location: index.php");
		exit();
	}

//define variables and initialize wtih empty values
$FirstName = $LastName = $EmpCategory = $Wage = $Username = $Password = "";
$FirstName_err = $LastName_err = $EmpCategory_err = $Wage_err = $Username_err = $Password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate First name
    $FirstName = trim($_POST["FirstName"]);
    if(empty($FirstName)){
        $FirstName_err= "Please enter the employees first name.";
    } elseif(!filter_var($FirstName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $FirstName_err= "Please enter a valid first name.";
    }

    // Validate Last Name
    $LastName = trim($_POST["LastName"]);
    if(empty($FirstName)){
        $LastName_err= "Please enter the employees last name.";
    } elseif(!filter_var($LastName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $LastName_err = "Please enter a valid last name.";
    }

    // Validate Employee Category
    $EmpCategory = $_POST["EmpCategory"];

	// Validate Wage
    $Wage = trim($_POST["Wage"]);
    if(empty($Wage)){
        $Wage_err = "Please enter a numerical number for the wage.";
	}
  
  	//Account Info	
	$Username= trim($_POST["Username"]);
    if(empty($Username)){
        $Username_err= "Please enter the employees username.";
	}
	 
	$Password = trim($_POST["Password"]);
    if(empty($FirstName)){
        $Password_err= "Please enter the employees password.";
	}
		
	//Make an account
	$sql = "SELECT AUTO_INCREMENT 
			FROM information_schema.TABLES
			WHERE TABLE_SCHEMA = 'cs340_dongrog' AND
			TABLE_NAME = 'Employees'";
	$result = $conn->query($sql);
	$sql_res = $result->fetch_assoc();
	$eid = $sql_res['AUTO_INCREMENT'];
	$result->close();

    // Check input errors before inserting in database
    if(empty($FirstName_err) && empty($LastName_err) && empty($EmpCategory_err) && empty($Wage_err) && empty($Username_err) && empty($Password_err)){
        // Prepare an insert statement employee
		$sql = "INSERT INTO `Employees` (FirstName, LastName, EmpCategoryId, Wage) 
					VALUES ('$FirstName', '$LastName', $EmpCategory, $Wage)";
		$conn->query($sql);
		
		// Prepare an insert statement for account login
		$sql = "INSERT INTO `Account` (Username, Password, EmployeeId)
					VALUES ('$Username', '$Password', $eid)";
		$conn->query($sql);
		header("Location: employees.php");
		exit();
	}
}
?>

<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Add Employee(s)</title>
        <link rel="stylesheet" href="index.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script type='text/javascript' src="jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>
        <!-- <script src="javascript/employees.js"></script> -->
    </head>
    <body>
		<?php include 'header.php' ?>
            <div class="container">
				<div class='d-flex justify-content-between p-3 my-3 text-dark-50 bg-white rounded shadow'>
	                <h4>Add New Employee</h4>
				</div>
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    						<div class="form-group <?php echo (!empty($FirstName_err)) ? 'has-error' : ''; ?>">
                                <label>First Name</label>
                                <input type="text" name="FirstName" class="form-control" value="<?php echo $FirstName; ?>">
                                <span class="help-block"><?php echo $FirstName_err;?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($LastName_err)) ? 'has-error' : ''; ?>">
                                <label>Last Name</label>
                                <input type="text" name="LastName" class="form-control" value="<?php echo $LastName; ?>">
                                <span class="help-block"><?php echo $LastName_err;?></span>
                            </div>
                            <div class='form group <?php echo (!empty($EmpCategory_err)) ? 'has-error' : ''; ?>'>
							    <label for="empcat">Employee Position</label>
	                            <select class='form-control' id='empcat' name='EmpCategory'>
								<?php
									$sql = "SELECT * FROM EmployeeCategories";
									$sql_get = $conn->query($sql);
	                                while($row = $sql_get->fetch_assoc()){
								?>
    	    	                		<option value='<?= $row['EmpCategoryId'] ?>'>
                			                  <?= $row['EmpCategory'] ?>
                                		</option>
								<?php
	                                }
								?>
                            	<select>
                            </div>

                            <div class="form-group <?php echo (!empty($Wage_err)) ? 'has-error' : ''; ?> mt-3">
                                <label>Wage</label>
								<input type='number' name="Wage" min='0.00' max='1000.00' step='0.01' class='form-control'/>
                                <span class="help-block"><?php echo $Wage_err;?></span>
                            </div>

							<div class="form-group <?php echo (!empty($Username_err)) ? 'has-error' : ''; ?>">
                                <label>Username</label>
                                <input type="text" name="Username" class="form-control" value="<?php echo $Username; ?>">
                                <span class="help-block"><?php echo $Username_err;?></span>
                            </div>

							<div class="form-group <?php echo (!empty($Password_err)) ? 'has-error' : ''; ?>">
                                <label>Password</label>
                                <input type="text" name="Password" class="form-control" value="<?php echo $Password; ?>">
                                <span class="help-block"><?php echo $Password_err;?></span>
                            </div>

                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
    </body>
    </html>
