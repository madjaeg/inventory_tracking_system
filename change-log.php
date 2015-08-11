<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="javascript.js"></script>
	<title>Inventory Tracking System - Change Log</title>
    <!-- Open Sans font -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
</head>
<body>

<?php
	include('mysqli_connect.php');

	//Number of blog posts to show per page
	$display = 20;

	//Determine how many pages there are
	if (isset($_GET['p']) && is_numeric($_GET['p'])) {
		$pages = $_GET['p'];
	}
	else{
		$q = "SELECT COUNT(id) FROM ChangeLog";
		$r = @mysqli_query($db, $q);
		$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
		$records = $row[0];

		//Calculate number of pages
		if($records > $display){
			$pages = ceil ($records/$display);
		}
		else{
			$pages = 1;
		}
	}

	//Determine where in the database to start returning results
	if (isset($_GET['s']) && is_numeric($_GET['s'])){
		$start = $_GET['s'];
	}
	else{
		$start = 0;
	}

	//Default sort is date_time
	$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'date_time';

	//Determine sorting order
	switch ($sort) {
		default:
			$order_by = 'date_time DESC';
			$sort = 'date_time';
			break;
	}
?>

<div id="wrapper-div">
	<h1>Inventory Tracking System</h1>

	<div id="navBar">
		<a href="index.php" class="navBar userTools">Inventory List</a>
		<a href="request.php" class="navBar userTools">Request Items</a>
		<a href="restock.php" class="navBar userTools">Restock Items</a>

		<a href="change-log.php" class="navBar adminTools current">Change Log</a>
		<a href="out-of-stock.php" class="navBar adminTools">Out of Stock</a>
		<a href="add-items.php" class="navBar adminTools">Add New Items</a>
	</div> <!-- navBar -->

	<div id="background-div">
		<h2>Change Log</h2>
		<h3>Log of all inventory list updates.</h3>

		<div id="btn-wrapper">
			<table class="mainTable" id="updateStockTable">
				<thead>
					<tr>
						<th>Action</th>
						<th>Name</th>
						<th>Item Name</th>
						<th># In Stock</th>
						<th>Amount</th>
						<th>Updated # In Stock</th>
						<th>Event</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//Grabs everything from change log table
						$query = mysqli_query($db, "SELECT id, action, name, itemName, numInStock, amount, updatedNumInStock, event, date_time FROM ChangeLog ORDER BY $order_by LIMIT $start, $display");

						if (!$query){
							echo "Could not grab query.";
						}

						else{
							//Displays everything in a table
							while($row = mysqli_fetch_assoc($query)){
								echo "<tr>";
								echo "<td>" . $row['action'] . "</td>";
								echo "<td>" . $row['name'] . "</td>";
								echo "<td>" . $row['itemName'] . "</td>";
								echo "<td>" . $row['numInStock'] . "</td>";
								echo "<td>" . $row['amount'] . "</td>";
								echo "<td>" . $row['updatedNumInStock'] . "</td>";
								echo "<td>" . $row['event'] . "</td>";
								echo "<td>" . $row['date_time'] . "</td>";
								echo "</tr>";
							}                                
						}
					?>
				</tbody>
			</table>
		</div><!-- btn-wrapper -->

		<div class="pageination">
			<?php
				//Makes the links to other pages, if necessary
				if ($pages > 1) {

					echo '<br /><p>';
					$current_page = ($start/$display) + 1;

					//If it's not the first page, make a Previous button
					if ($current_page != 1) {
						echo '<a href="change-log.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '" class="link pageination-link">&lsaquo; Previous</a> ';
					}

					//Make all the numbered pages
					for ($i = 1; $i <= $pages; $i++){
						if ($i != $current_page){
							echo '<a href="change-log.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . "<a class='link'>" . $i . "</a>" . ' </a>';
						} else{
							echo $i . ' ';
						}
					}//End of for loop

					//If it's not the last page, make a next button
					if($current_page != $pages){
						echo '<a href="change-log.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '" class="link pageination-link"> Next &rsaquo;</a>';
					}

					echo '</p>';
				}//End of pageination if statement
			?>
		</div> <!-- pageination -->
	</div> <!-- background-div -->
</div> <!-- wrapper-div -->

</body>
</html>