<?php
	session_start();
	require 'connectdb.php';
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	function alert($msg) {
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}	
	if (isset($_SESSION['AccountId'])) {
		header("Location: ./index.php");
	}
	if (isset($_POST['login'])) {
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$pw = mysqli_real_escape_string($conn, $_POST['pw']);
		
		$query = "SELECT AccountId FROM Account
				  WHERE Username = '".$username."' AND Password = '".$pw."'";
		
		$result = mysqli_query($conn, $query);
		if (!$result) {
			die("Login failed, please try again");
		}
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$_SESSION['AccountId'] = $row['AccountId'];
			header("Location: ./index.php");
		}
		else {
			alert("Invalid combinations" . $username . $pw);
		}
	}
?> 

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lucky Dragon</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="index.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>

    </head>


    <body class='bg-light'>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <nav class="navbar navbar-dark bg-nav d-flex justify-content-center">
            <img src='img/logo.png' style='height: 250px' class='logo'>
        </nav>

        <div class='container'>
			<div class='row mt-3'>
				<div class='col text-center'>
					<h2 class='mb-3'>Welcome to Lucky Dragon 
						<?php if($_SESSION['AccountId']){
								$sql = "SELECT E.FirstName
										FROM Account A
										LEFT JOIN Employees E ON A.EmployeeId = E.EmployeeId
										WHERE A.AccountId =".$_SESSION['AccountId'].";";
								$sql_get = $conn->query($sql);
								$row = $sql_get->fetch_assoc();
								echo $row['FirstName'];
								$sql_get->close();
							}
						?>!
					</h2>
					<?php if(!$_SESSION['AccountId']) :?>
	                	<button class='btn btn-success btn-lg' type='button' data-toggle="modal" data-target="#exampleModal">Login as Manager/Owner</button>
					<?php else :?>
						<a href='menu.php'>
		                	<button class='btn btn-success btn-lg' type='button'>Continue as Manager/Owner</button>
						</a>
					<?php endif ;?>
					<a href='menu.php'>
						<button class='btn btn-primary btn-lg'>Order as Customer</button>
					</a>
				</div>
       		</div>
        </div>
        <!-- End Container -->
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Employee Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action = "" method = "post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="username" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="pw" name="pw" placeholder="Password">
                        </div>
                		<div class="modal-footer">
	                   		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		               		<button type="submit" class="btn btn-success" name="login" value="login">Login</button>
						</div>
					</form>
                </div>					
						
                </div>
            </div>
        </div>
    </body>
</html>                          
