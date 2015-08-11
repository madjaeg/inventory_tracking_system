<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="javascript.js"></script>
	<title>Inventory Tracking System - Add New Items</title>
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
		<a href="out-of-stock.php" class="navBar adminTools">Out of Stock</a>
		<a href="add-items.php" class="navBar adminTools current">Add New Items</a>
	</div> <!-- navBar -->

	<div id="background-div">
	<form action="add-validate.php" method="post" id="addItemsForm">
		<h2>Add New Items</h2>
		<h3>Add a new item to the inventory list.</h3>

        <?php

        include('mysqli_connect.php');

        if ($_SESSION['form_error_text']){
        	echo "<div class='error'><i class='fa fa-exclamation-circle'></i> Error(s):" . $_SESSION['form_error_text'] . "</div>";
        }

        else if(isset($_SESSION['form_error_text'])){
            echo "<div class='success'><i class='fa fa-check-circle'></i> Your item has been added!</div>";
        }

        ?>

        <div id="btn-wrapper">
			<table class="mainTable" id="addItemsTable">
				<thead>
					<tr>
						<th>Your Name</th>
						<th>Item Name</th>
						<th># In Stock</th>
						<th>Price per Unit</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input type="text" name="name" id="name" class="<?php if ($_SESSION['name_errors']) {echo 'error-style';} ?> " value="<?php if ($_SESSION['name']) {echo $_SESSION['name'];} ?>" /></td>
						<td><input type="text" name="itemName" id="itemName" class="<?php if ( ($_SESSION['itemName_errors']) || ($_SESSION['itemNameExists_errors']) ) {echo 'error-style';} ?> " value="<?php if ($_SESSION['itemName']) {echo $_SESSION['itemName'];} ?>" /></td>
						<td><input type="number" name="numInStock" id="numInStock" class="<?php if ($_SESSION['numInStock_errors']) {echo 'error-style';} ?> " value="<?php if ($_SESSION['numInStock']) {echo $_SESSION['numInStock'];} ?>" /></td>
						<td>$<input type="text" name="pricePerUnit" id="pricePerUnit" class="<?php if ($_SESSION['pricePerUnit_errors']) {echo 'error-style';} ?> " value="<?php if ($_SESSION['pricePerUnit']) {echo $_SESSION['pricePerUnit'];} ?>" /></td>
					</tr>
				</tbody>
			</table>
			<input type="submit" value="Submit" class="btn" id="submitButton" onclick="return addItemsAppendURL();"/>
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