<?php
case "add":
if(!empty($_POST["quantity"])) {
	$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
	$itemArray = array($productByCode[0]["code"]=>
			array('name'=>$productByCode[0]["name"], 
			'code'=>$productByCode[0]["code"], 
			'quantity'=>$_POST["quantity"], 
			'price'=>$productByCode[0]["price"], 
			'image'=>$productByCode[0]["image"]));
	if(!empty($_SESSION["cart_item"])) {
		if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
			foreach($_SESSION["cart_item"] as $k => $v) {
				if($productByCode[0]["code"] == $k) {
					if(empty($_SESSION["cart_item"][$k]["quantity"])) {
						$_SESSION["cart_item"][$k]["quantity"] = 0;
					}
					$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
				}
			}
		} else {
			$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
		}
	} else {
		$_SESSION["cart_item"] = $itemArray;
	}
}
break;






include 'connectdb.php';	
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$product_array = $conn->query("SELECT * FROM Product ORDER BY ProductId ASC");
$row = $product_array->fetch_assoc();
foreach($row as $key=>$value){
	echo $value;
}

if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
				?>
				<div class="product-item">
				<form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
					<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
					<div class="product-tile-footer">
					<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
					<div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
					<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
				</form>
				</div>
				<?php
		}
}
?>


					
