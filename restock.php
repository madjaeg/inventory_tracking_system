<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="javascript.js"></script>
	<title>Inventory Tracking System - Restock Items</title>
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
		<a href="restock.php" class="navBar userTools current">Restock Items</a>

		<a href="change-log.php" class="navBar adminTools">Change Log</a>
		<a href="out-of-stock.php" class="navBar adminTools">Out of Stock</a>
		<a href="add-items.php" class="navBar adminTools">Add New Items</a>
	</div> <!-- navBar -->

	<div id="background-div">
	<form action="restock-validate.php" method="post" id="restockForm">
		<h2>Restock Items</h2>
		<h3>Add items to the inventory list stock.</h3>

        <?php

        include('mysqli_connect.php');

        if ($_SESSION['form_error_text']){
        	echo "<div class='error'><i class='fa fa-exclamation-circle'></i> <strong>Error(s):</strong>" . $_SESSION['form_error_text'] . "</div>";
        }

        else if(isset($_SESSION['form_error_text'])){
            echo "<div class='success'><i class='fa fa-check-circle'></i> Your item has been restocked!</div>";
        }
        
        ?>

        <div id="btn-wrapper">
			<table class="mainTable" id="updateStockTable">
				<thead>
					<tr>
						<th>Your Name</th>
						<th>Item Name</th>
						<th># In Stock</th>
						<th>Adjustment</th>
						<th>Amount</th>
						<th>Event</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input type="text" name="name" id="name" class="<?php if ($_SESSION['name_errors']) {echo 'error-style';} ?> " value="<?php if ($_SESSION['name']) {echo $_SESSION['name'];} ?>" /></td>
						<td>
							<select name ="itemNameDropDown" id="itemNameDropDown" class="<?php if ($_SESSION['itemNameDropDown_errors']) {echo 'error-style';} ?>" >
								<option></option>
								<?php
									//Grabs all item names and ids from database; users CAN update items with stock num of 0
									$query = mysqli_query($db, "SELECT itemName, id FROM InventoryList ORDER BY itemName");

									if(!$query){
										echo "Could not grab query.";
									}

									else{
										//Displays item names as drop down options
										while($row = mysqli_fetch_assoc($query)){
											echo "<option value='" . $row['itemName'] . "'>" . $row['itemName'] . "</option>";
										}                                
									}
								?>
							</select>
						</td>
						<td><div class="numInStockCol" id="numInStockCol"><!-- grab-num-in-stock.php displays here --></div></td>
						<td>Add<!-- Adjustment option is add by default --></td>
						<td><input type="number" name="changeAmount" id="changeAmount" class="<?php if ($_SESSION['changeAmount_errors']) {echo 'error-style';} ?> " value="<?php if ($_SESSION['changeAmount']) {echo $_SESSION['changeAmount'];} ?>" /></td>
						<td>
							<select id="eventDropDown" name="eventDropDown" class="<?php if ($_SESSION['eventDropDown_errors']) {echo 'error-style';} ?>">
								<option><?php if ($_SESSION['eventDropDown']) {echo $_SESSION['eventDropDown'];} ?></option>
								<option>UG Recruitment</option>
								<option>MLIS Recruitment</option>
								<option>PHD Recruitment</option>
								<option>Alumni Relations/Events</option>
								<option>General School Business/Events</option>
								<option>Restocking</option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<input type="submit" value="Submit" class="btn" id="submitButton" onclick="return restockAppendURL();"/> <!-- restockAppendURL appends variables to URL to use on restock-validate.php -->
		</div> <!-- btn-wrapper -->
	</form>
	</div> <!-- background-div -->
</div> <!-- wrapper-div -->

<?php
mysqli_close($db);
//Clear out SESSIONS for the next request
session_destroy();
?>

</body>
</html>