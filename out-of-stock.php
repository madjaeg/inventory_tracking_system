<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="javascript.js"></script>
	<title>Inventory Tracking System - Out of Stock</title>
    <!-- Open Sans font -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>

<div id="wrapper-div">
	<h1>Inventory Tracking System</h1>

	<div id="navBar">
		<a href="index.php" class="navBar userTools">Inventory List</a>
		<a href="request.php" class="navBar userTools">Request Items</a>
		<a href="restock.php" class="navBar userTools">Restock Items</a>

		<a href="change-log.php" class="navBar adminTools">Change Log</a>
		<a href="out-of-stock.php" class="navBar adminTools current">Out of Stock</a>
		<a href="add-items.php" class="navBar adminTools">Add New Items</a>
	</div> <!--navBar -->

	<div id="background-div">
		<h2>Out of Stock</h2>
		<h3>Remove an item from the inventory list.</h3>

        <?php

        include('mysqli_connect.php');

		//Delete query
		if(isset($_GET['id'])){
			$querydel = "DELETE FROM InventoryList WHERE id='".$_GET['id']. "'";
			$resultdel = mysqli_query($db, $querydel);
			echo mysql_error();

			$action = "Deleting Item";
			$name = $_GET['name'];
			$itemName = $_GET['itemName'];
			$numInStock = "0";
			$amount = "-";
			$updatedNumInStock = "-";
			$event = "-";

			//Makes entry on change-log.php table
			$sql2 = mysqli_query($db, "INSERT INTO ChangeLog (action, name, itemName, numInStock, amount, updatedNumInStock, event, date_time) VALUES ('$action', '$name', '$itemName', '$numInStock', '$amount', '$updatedNumInStock', '$event', NOW())");

			if($resultdel){
				echo "<div class='success'><i class='fa fa-check-circle'></i> Your item has been removed.</div>";
			}
		}

        ?>

        <div id="btn-wrapper">
			<table class="mainTable" id="outOfStockTable">
				<thead>
					<tr>
						<th>Your Name</th>
						<th>Item Name</th>
						<th># In Stock</th>
						<th>Price per Unit</th>
						<th>Delete?</th>
					</tr>
				</thead>
				<tbody>
					<?php

					include('mysqli_connect.php');

					//Grabs everything from database that has a stock number of 0 (only allowed to remove items from inventory if they have no more stock)
					$query = mysqli_query($db, "SELECT * FROM InventoryList WHERE numInStock = 0 ORDER BY itemName");

					if(!$query){
						echo "Could not grab query.";
					}

					else{
						//Display out of stock items in a table
						while($row = mysqli_fetch_assoc($query)){
							echo "<tr>";
							echo"<form method='get' id='outOfStockForm' action='out-of-stock.php'/>";
							echo "<td><input type='text' name='name' id='name' required/></td>";
							echo "<td id='itemNameCol'>" . $row['itemName'] . "</td>";
							echo "<td>" . $row['numInStock'] . "</td>";
							echo "<td>" . "$" . $row['pricePerUnit'] . "</td>";
							echo "<input type='hidden' name='id' id='id' value='" . $row['id'] . "'/>";
							echo "<input type='hidden' name='itemName' id='itemName' value='" . $row['itemName'] . "'/>";
							echo "<td><input type='submit' value='Delete' class='btn deleteBtn' id='submitButton'></td>";
							echo "</form>";
							echo "</tr>";
						}                                
					}

					?>
				</tbody>
			</table>
		</div> <!-- btn-wrapper -->
	</div> <!-- background-div -->
</div> <!-- wrapper-div -->

<?php
mysqli_close($db);
//Clear out SESSIONS for the next request
session_destroy();
?>

</body>
</html>