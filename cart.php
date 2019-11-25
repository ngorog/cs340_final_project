<?php
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if(!empty($_GET["action"])) {
switch($_GET['action']){
	case "add":
		if(!empty($_POST["quantity"])) {
			$sql = $conn->query("SELECT * FROM Product WHERE ProductId='" . $_GET["code"] . "'");
			$row = $sql->fetch_assoc();
			$itemArray= array($row['ProductId']=>
							array('Name'=>$row['ProductName'],
							'Price'=>$row['Price'],
							'ProductId'=>$row['ProductId'],
							'quantity'=>$_POST['quantity']));
			if(!empty($_SESSION["menu_item"])) {
					if(in_array($row["ProductId"],array_keys($_SESSION["menu_item"]))) {
							foreach($_SESSION["menu_item"] as $k => $v) {
									if($row['ProductId'] == $k) {
											if(empty($_SESSION["menu_item"][$k]["quantity"])) {
													$_SESSION["menu_item"][$k]["quantity"] = 0;
											}
											$_SESSION["menu_item"][$k]["quantity"] += $_POST["quantity"];
									}
							}
					} else {
							$_SESSION["menu_item"] = array_merge($_SESSION["menu_item"],$itemArray);
					}
			} else {
					$_SESSION["menu_item"] = $itemArray;
			}
	}
	break;
	case "remove":
		if(!empty($_SESSION["menu_item"])) {
			foreach($_SESSION["menu_item"] as $k => $v) {
				if($_GET["code"] == $_SESSION['menu_item'][$k]['ProductId']){
					unset($_SESSION["menu_item"][$k]);
				}
				if(empty($_SESSION["menu_item"]))
					unset($_SESSION["menu_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["menu_item"]);
	break;
	
}
}

?>
