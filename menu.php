<?php
	session_start();
//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(-1);
	include 'connectdb.php';
	include 'cart.php';
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

	$_SESSION['page'] = 1;
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
		<?php include 'header.php'?>

        <div class='container'>
            <!-- Header -->
           <div class='d-flex justify-content-between p-3 my-3 text-dark-50 bg-white rounded shadow'>
                <h4> Menu </h4>
								<div class="dropdown">
  								<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    								Filter
  								</button>
  								<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
										<form method="post"	action="menu.php?action=add&code=<?= $row['ProductId'] ?>">
    									<button class="dropdown-item" type="submit" name="foods_btn">Foods</button>
    									<button class="dropdown-item" type="submit" name="drinks_btn">Drinks</button>
										</form>
  								</div>
								</div>
           </div>
					 
			<!-- Populate Menu Items -->
			<?php
				if(isset($_POST['foods_btn'])){
					$sql = "SELECT * FROM Foods";
				}
				elseif (isset($_POST['drinks_btn'])){
					$sql = "SELECT * FROM Drinks";
				}
				else {
					$sql = "SELECT * FROM Product";
				}
				$sql_get = $conn->query($sql);
				while($row = $sql_get->fetch_assoc()){
				?>
				<form method="post"	action="menu.php?action=add&code=<?= $row['ProductId'] ?>">
				<div id='menuItem<?= $row['ProductId'] ?>' class='my-3 p-3 bg-white rounded shadow-sm'>
					<div class='d-flex justify-content-between border-bottom border-gray pb-2'>
						<a id='collapser<?= $row['ProductId'] ?>' data-toggle='collapse' href='#collapse<?= $row['ProductId']?>' role='button' aria-expanded="false" aria-controls='collapse<?= $row['ProductId']?>'>
							<h5 id="namePrice<?= $row['ProductId'] ?>" class='d-inline'><?= $row['ProductName'] . " - $" . $row['Price']; ?></h5>
						</a>

						<!-- If Employee Logged in, allow edit -->
						<?php if(isset($ID)) :?>
							<button class='editMenu btn btn-info btn-sm' type='button' value='<?= $row['ProductId'] ?>'>Edit</button>
							<span id='saveCancel<?= $row['ProductId'] ?>' class='d-none'>
								<button class='editCancel btn btn-secondary btn-sm' type='button' value='<?= $row['ProductId'] ?>'>Cancel</button>
								<button class='editSave btn btn-success btn-sm' type='submit' value='<?= $row['ProductId']?>'>Save</button>
							</span>
						<?php endif; ?>

						<!-- If Not Logged in, allow add to cart -->
						<?php if(!isset($ID)) :?>
							<div class="cart-action d-flex">
								<input class='form-control' id='editPrice' type='number' name='quantity' min='1' max='20' step='1' value='1' />
								<button class='btn btn-success fas fa-shopping-cart ml-2' type='submit' value='<?= $row['ProductId'] ?>'></button>
							</div>
						<?php endif; ?>
					</div>
					<div class='mt-2 collapse show' id='collapse<?= $row['ProductId']?>'>
						<div class='row'>
							<div class='col-8'>
								<p id='description<?= $row['ProductId']?>'>
									<?= $row['Description']; ?>
								</p>
							</div>
							<div class='col-4'>
								<img src="img/<?= $row['ProductId'].'.jpg'?>" style="max-width: 250px" class="rounded">
							</div>
						</div>
					</div>
				</div>
				</form>
				<?php
				}
				$sql_get->close();
			?>

			<!-- Cart Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Your Cart</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<!--CART STUFF -->
							<table class='table'>
							<?php if(isset($_SESSION['menu_item'])) :?>
								<thead>
									<tr>
										<th>Name</th>
										<th>Quantity</th>
										<th>Price</th>
										<th>Remove</th>
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
											<td>
												<a href='menu.php?action=remove&code=<?= $item['ProductId'] ?>'>
													<button class='btn btn-danger fas fa-trash text-center' type='submit' value='<?= $item['ProductId'] ?>'></button>
												</a>
											</td>
										</tr>
									<?php
										$total_quantity += $item["quantity"];
										$total_price += ($item["Price"]*$item["quantity"]);
									}
								}
							?>
								<tr class='table-success'>
									<td class='font-weight-bold'>Total</td>
									<td class='font-weight-bold'><?= $total_quantity?></td>
									<td class='font-weight-bold'><?= "$".$total_price ?></td>
									<td>
										<a class='text-center' type='submit' href='menu.php?action=empty'>
										<button class='btn btn-danger text-center' type='submit' href='menu.php?action=empty'>Clear Cart</button>
									</td>
								</tr>
								</tbody>
							<?php else: ?>
								<h3 class='text-center'>You have no items in your cart</h3>
							<?php endif; ?>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<?php if(isset($_SESSION['menu_item'])) :?>
							<a href='checkout.php'>
								<button type="button" class="btn btn-success">Checkout</button>
							</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!-- End Container -->
    </body>
</html>
