<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="javascript.js"></script>
	<title>Inventory Tracking System</title>
    <!-- Open Sans font -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
</head>
<body>

<div id="wrapper-div">
	<h1>Inventory Tracking System</h1>

	<div id="navBar">
		<a href="index.php" class="navBar userTools current">Inventory List</a>
		<a href="request.php" class="navBar userTools">Request Items</a>
		<a href="restock.php" class="navBar userTools">Restock Items</a>

		<a href="change-log.php" class="navBar adminTools">Change Log</a>
		<a href="out-of-stock.php" class="navBar adminTools">Out of Stock</a>
		<a href="add-items.php" class="navBar adminTools">Add New Items</a>
	</div> <!-- navBar -->

	<div id="background-div">
		<h2>Inventory List</h2>

		<h3>*A red cell indicates an item is low in stock.</h3>

		<table class="inventoryTable lowInStock" id="inventoryTable">
			<thead>
				<tr>
					<th>Item Name</th>
					<th># In Stock</th>
					<th>Price per Unit</th>
				</tr>
			</thead>
			<tbody>
				<?php
					include('mysqli_connect.php');

					//Grabs everything from database that has a stock # that is greater than 0; everything at 0 goes to out-of-stock.php table
					$query = mysqli_query($db, "SELECT * FROM InventoryList WHERE numInStock > 0 ORDER BY itemName");

					if (!$query){
						echo "Could not grab query.";
					}

					else{
						//Displays data in table
						while($row = mysqli_fetch_assoc($query)){
							echo "<tr>";
								echo "<td>" . $row['itemName'] . "</td>";
								echo "<td>" . $row['numInStock'] . "</td>";
								echo "<td>" . "$" . $row['pricePerUnit'] . "</td>";
							echo "</tr>";
						}
					}
				?>
			</tbody>
		</table>
	</div> <!-- background-div -->
</div> <!-- wrapper-div -->

<?php mysqli_close($db); ?>

</body>
</html>