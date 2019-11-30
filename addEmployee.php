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

//define variables and initialize wtih empty values
$FirstName = $LastName = $EmpCatagory = $Wage = "";
$FirstName_err = $LastName_err = $EmpCatagory_err = $Wage_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate First name
    $FirstName = trim($_POST["FirstName"]);
    if(empty($FirstName)){
        $sName_err = "Please enter the employees first name.";
    } elseif(!filter_var($FirstName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $sName_err = "Please enter a valid first name.";
    }

    // Validate Last Name
    $LastName = trim($_POST["LastName"]);
    if(empty($FirstName)){
        $LastName_err= "Please enter the employees last name.";
    } elseif(!filter_var($FirstName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $LastName_err = "Please enter a valid last name.";
    }

    // Validate Employee Catagory
    $EmpCatagory = trim($_POST["EmpCategory"]);
    if(empty($EmpCatagory)){
        $EmpCatagory_err = "Please select an employee catagory.";
    }

	// Validate Wage
    $Wage = trim($_POST["Wage"]);
    if(empty($Wage)){
        $Wage_err = "Please enter a numerical number for the wage.";
	}
    // Check input errors before inserting in database
    if(empty($FirstName_err) && empty($LastName_err) && empty($EmpCatagory_err) && empty($Wage_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO Employees (FirstName), LastName, EmpCategory, Wage) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isdi", $param_FirstName, $param_LastName, $param_EmpCatagory, $param_Wage);

            // Set parameters
			$param_FirstName = $FirstName;
            $param_LastName = $LastName;
            $param_EmpCatagory = $EmpCatagory;
            $param_Wage = $Wage;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: employees.php");
                exit();
            } else{
                echo "Duplicate record";
				$FirstName_err = "Enter a first name.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
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
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h2>Insert a new employee</h2>
                        </div>
                        <p>Please fill this form and submit to add a Employee record to the database.</p>
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
                            <!-- <div class="form-group <?php echo (!empty($EmpCatagory_err)) ? 'has-error' : ''; ?>">
                                <label>Employee Position</label>
                                <input type="text" name="EmpCatagory" class="form-control" value="<?php echo $EmpCatagory; ?>">
                                <span class="help-block"><?php echo $EmpCatagory_err;?></span>
                            </div> -->
                            <div>
                            <select>
                                while($row = $sql_get->fetch_assoc()){
                                <option>
                                  <?= $row['EmpCategory'] ?>
                                </option>
                                }
                            <select>
                            </div>
                            <div class="form-group <?php echo (!empty($Wage_err)) ? 'has-error' : ''; ?>">
                                <label>Wage</label>
                                <input type="text" name="Wage" class="form-control" value="<?php echo $Wage; ?>">
                                <span class="help-block"><?php echo $Wage_err;?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
