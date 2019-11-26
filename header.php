<?php
	if (isset($_SESSION['AccountId'])) {
		$ID = $_SESSION['AccountId'];
	}
?>
<nav class="navbar navbar-dark bg-nav d-flex flex-column">
	<img src='img/logo.png' style='height: 250px' class='logo mx-auto'>
	<div>
		<a href='index.php'>
			<button class='btn btn-dark'>Home</button>
		</a>
		<a href='menu.php'>
			<button class='btn btn-dark'>View Menu</button>
		</a>
		
		<?php if(!isset($ID) && $_SESSION['page'] != 3): ?>
		<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">
			 View Cart 
		</button>
		<a href='checkout.php'>
			<button class='btn btn-dark'>Checkout</button>
		</a>
		<?php endif; ?>
		<?php if(isset($ID)): ?>
		<a href='customers.php'>
			<button class='btn btn-dark'>View Customers</button>
		</a>
		<a href='employees.php'>
			<button class='btn btn-dark'>View Employees</button>
		</a>
		<a href='orders.php'>
			<button class='btn btn-dark'>View Orders</button>
		</a>
		<a href='logout.php'>
			<button class='btn btn-dark'>Log Out</button>
		</a>
		<?php endif; ?>
	</div>
</nav>
