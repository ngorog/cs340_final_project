<?php
if(isset($_SERVER['REQUEST_METHOD'])){
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$firstname = mysqli_real_escape_string($conn, $_POST['first_name']);
	$lastname = mysqli_real_escape_string($conn, $_POST['last_name']);
	$address = mysqli_real_escape_string($conn, $_POST['address']);
	$city = 'Salem';
	$state = 'Oregon';
	$zipcode = mysqli_real_escape_string($conn, $_POST['zipcode']);
	$phone = mysqli_real_escape_string($conn, $_POST['phone']);
	$total_price = 0;
	$date = date("Y-m-d");
	
	//Get next order id PK
	$sql = "SELECT AUTO_INCREMENT 
			FROM information_schema.TABLES
			WHERE TABLE_SCHEMA = 'cs340_dongrog' AND
			TABLE_NAME = 'Orders'";
	$result = $conn->query($sql);
	$sql_res = $result->fetch_assoc();
	$oid = $sql_res['AUTO_INCREMENT'];
	$result->close();

	//Get total price of order
	foreach ($_SESSION["menu_item"] as $item){
		$total_price += ($item["Price"]*$item["quantity"]);
	}

	//Check if customer already exists
	$sql = "SELECT CustomerId, COUNT(*) AS 'Rows'
			FROM Customers
			WHERE PhoneNumber = '".$phone."' AND Address = '".$address."' AND LastName = '".$lastname."' AND  FirstName = '".$firstname."'";
	$sql_get = $conn->query($sql);
	$row = $sql_get->fetch_assoc();
	$sql_get->close(); 

	if ($row['Rows'] == 0) { //Insert new customer and grab id	
		$sql = "SELECT AUTO_INCREMENT
			FROM information_schema.TABLES
			WHERE TABLE_SCHEMA = 'cs340_dongrog' AND
			TABLE_NAME = 'Customers'";
		$result = $conn->query($sql);
		$sql_res = $result->fetch_assoc();
		$id = $sql_res['AUTO_INCREMENT'];
		$result->close();

		$sql_update = "INSERT INTO `Customers` (FirstName, LastName, PhoneNumber, Address, Zipcode, City, State)
				VALUES ('$firstname', '$lastname', '$phone', '$address', $zipcode, '$city', '$state')";
		$conn->query($sql_update);	
			
		}
	else { //Grab customer id
		$id = $row['CustomerId'];
	}

	//Create order
	$sql = "INSERT INTO `Orders` (CustomerId, TotalPrice, Date)
			VALUES ($id, $total_price, '".$date."')";
	$conn->query($sql);
		
	//Create order list
	foreach ($_SESSION["menu_item"] as $item){
		for($i=0; $i<$item['quantity']; $i++){
			$pid = $item['ProductId'];
			$sql = "INSERT INTO `OrderList` (ProductId, OrderId) 
				VALUES ($pid, $oid)";
			$conn->query($sql);
		}
	}
	
	header('Location: orderconfirm.php?id='.$id);
}
}
?>
