<?php
ob_start();
session_start();
include('redirect_functions.inc.php');
?>

<!DOCTYPE html>
<body>

<?php

include('mysqli_connect.php');

$errorText = "";

//If name is empty or contains not only letters
if ( ($_POST['name'] == "") || !(ctype_alpha($_POST['name'])) ){
	$_SESSION['name_errors'] = true;
	$errorText .= "<br/> - Invalid name";
}

//Makes form sticky if any errors
if ($errorText){
	//Set variables
	$name = $_POST['name'];
	$changeAmount = $_POST['changeAmount'];
	$eventDropDown = $_POST['eventDropDown'];

	//Display variables back on request.php to make form sticky
	$_SESSION['name'] = $name;
	$_SESSION['changeAmount'] = $changeAmount;
	$_SESSION['eventDropDown'] = $eventDropDown;
}

else{
	//Set variables for query
	$action = $_GET['action'];
	$name = $_GET['name'];
	$currentItem = $_GET['itemName'];
	$currentNumInStock = $_GET['currentNumInStockURL'];
	$amount = $_POST['changeAmount'];
	$updatedNumInStock = $_GET['currentNumInStockURL'] - $_POST['changeAmount'];
	$event = $_GET['event'];
	$date = date('m/d/y h:i:sa');
	
	//Updates inventory list
	$sql = mysqli_query($db, "UPDATE InventoryList SET numInStock='$updatedNumInStock' WHERE itemName='$currentItem'");
	//Updates change log
	$sql2 = mysqli_query($db, "INSERT INTO ChangeLog (action, name, itemName, numInStock, amount, updatedNumInStock, event, date_time) VALUES ('$action', '$name', '$currentItem', '$currentNumInStock', '$amount', '$updatedNumInStock', '$event', '$date')");
}

$_SESSION['form_error_text'] = $errorText;
redirect_user('out-of-stock.php');

mysqli_close($db);

?>

</body>
</html>