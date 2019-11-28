<?php
	session_start();
	include 'connectdb.php';	
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
	if(!$conn){
		die("Unable to connect to database " . mysql_error());
	}
	
	if (isset($_SESSION['AccountId'])) {
		$ID = $_SESSION['AccountId'];
	}

	if(isset($_SESSION["menu_item"])){
		$total_quantity = 0;
		$total_price = 0;
	}
	
	$today = date("Y-m-d");
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
        <script type="text/javascript"> (function() { var css = document.createElement('link'); css.href = 'https://use.fontawesome.com/releases/v5.1.0/css/all.css'; css.rel = 'stylesheet'; css.type = 'text/css'; document.getElementsByTagName('head')[0].appendChild(css); })(); </script>
		<script src="javascript/menu.js"></script>
    </head>


    <body class='bg-light'>
		<?php include 'header.php' ?>
		<div class='container'>
			<div>
				<!-- Get User Info -->
				<?php
				$id = $_GET['id'];
				$sql = "SELECT * FROM Customers WHERE CustomerId = $id";
				$sql_get = $conn->query($sql);
				$row = $sql_get->fetch_assoc();
				?>
				<!-- CART INFORMATION -->
				<?php if(isset($_SESSION['menu_item'])) :?>
				<div> 
					<div class='p-3 my-3 text-dark-50 bg-white rounded shadow text-center'>
        		        <h4> Thank you for ordering <?= $row['FirstName'] ?>!</h4>
					</div>
				
				<?php else: ?>
				<div>
					<div class='p-3 my-3 text-dark-50 bg-white rounded shadow'>
        		        <h4 class='text-center'> Cart </h4>
					</div>
				<?php endif; ?>
					<!-- Cart Modal -->
					<table class='table'>
					<?php if(isset($_SESSION['menu_item'])) :?>
						<thead>
							<tr>
								<th>Name</th>
								<th>Quantity</th>
								<th>Price</th>
							</tr>
						</thead>
						<tbody>
						<?php
							if(isset($_SESSION["menu_item"])){
								foreach ($_SESSION["menu_item"] as $item){
									$item_price = $item["quantity"]*$item["Price"];
								?>
									<tr>
										<td><?php echo $item["Name"]; ?></td>
										<td><?php echo $item["quantity"]; ?></td>
										<td><?php echo "$ ".$item["Price"]; ?></td>
									</tr>
								<?php
									$total_quantity += $item["quantity"];
									$total_price += ($item["Price"]*$item["quantity"]);
								}
								unset($_SESSION['menu_item']);
							}
							?>
							<tr class='table-success'>
								<td class='font-weight-bold'>Total</td>
								<td class='font-weight-bold'><?= $total_quantity?></td>
								<td class='font-weight-bold'><?= "$".$total_price ?></td>
							</tr>
						</tbody>

						<?php else: ?>
							<h3 class='text-center'>You have no items in your cart</h3>
						<?php endif; ?>
					</table>
				</div>
			</div>
		</div>
        <!-- End Container --> 
    </body>
</html>
