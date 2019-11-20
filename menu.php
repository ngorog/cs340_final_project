<?php
	include 'connectdb.php';	
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	if(!$conn){
		die("Unable to connect to database " . mysql_error());
	}
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
            <!-- Header --> 
           <div class='d-flex justify-content-between p-3 my-3 text-dark-50 bg-white rounded shadow'>
                <h4> Menu </h4>
                <button class='btn btn-success'>Filter</button>                      
           </div>

			<!-- Menu Items -->

			<!-- SQL Query -->
			<?php
				$sql = "SELECT *
						FROM Product";
				$sql_get = $conn->query($sql);
				while($row = $sql_get->fetch_assoc()){
				?>
				
				<div class='my-3 p-3 bg-white rounded shadow-sm'>
					<div class='d-flex justify-content-between border-bottom border-gray pb-2'>
						<a data-toggle='collapse' href='#collapse<?= $row['ProductId']?>' role='button' aria-expanded="false" aria-controls='collapse<?= $row['ProductId']?>'>
							<h5 id="name<?= $row['ProductId'] ?>" class='d-inline'><?= $row['ProductName'] ?></h5>
							<h5 id="divider" class='d-inline'>   - $</h5>
							<h5 id="price<?= $row['ProductId'] ?>" class='d-inline'><?= $row['Price']; ?></h5>
						</a>
						<button class='editMenu btn btn-info btn-sm' type='button' value='<?= $row['ProductId'] ?>'>Edit</button>
					</div>
					<div class='mt-2 collapse show' id='collapse<?= $row['ProductId']?>'>
						<div class='row'>
							<div class='col-8'>
								<p>
									<?= $row['Description']; ?>
								</p>
							</div>
							<div class='col-4'>
								<img src="img/<?= $row['ProductId'].'.jpg'?>" style="max-width: 250px" class="rounded">
							</div> 
						</div>
					</div>
				</div>
				<?php
				}
				$sql_get->close();
			?>
        </div>
        <!-- End Container --> 
    </body>
</html>
