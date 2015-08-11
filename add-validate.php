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

//If itemName is empty
if ( ($_POST['itemName'] == "") ){
	$_SESSION['itemName_errors'] = true;
	$errorText .= "<br/> - Invalid item name";
}

//Grabs all item names from the database
$check = mysqli_query($db, "SELECT itemName FROM InventoryList");

if(!$check){
	echo "Could not grab query.";
}

else{
	$flag = false;

	while($row = mysqli_fetch_assoc($check)){
		//Check to see if the item name exists in the database
		if($_POST['itemName'] == $row['itemName']){
		 	$flag = true;
		 	break;
		}
	}

	//If itemName exists in the database
	if($flag){
		$_SESSION['itemNameExists_errors'] = true;
		$errorText .= "<br/> - Item name already exists in the inventory list";
	}
}

//If numInStock is empty, contains not only numbers, or is less than or equal to 0
if ( ($_POST['numInStock'] == "") || (ctype_alpha($_POST['numInStock'])) || ($_POST['numInStock'] <= 0) ){
	$_SESSION['numInStock_errors'] = true;
	$errorText .= "<br/> - # In Stock cannot be less than or equal to 0";
}

//If pricePerUnit is empty, contains not only numbers, or is less than or equal to 0
if ( ($_POST['pricePerUnit'] == "") || (ctype_alpha($_POST['pricePerUnit'])) || ($_POST['pricePerUnit'] <= 0) ){
	$_SESSION['pricePerUnit_errors'] = true;
	$errorText .= "<br/> - Price per Unit cannot be less than or equal to 0";
}

//Makes form sticky if any errors
if ($errorText){
	//Set variables
	$name = $_POST['name'];
	$itemName = $_POST['itemName'];
	$numInStock = $_POST['numInStock'];
	$pricePerUnit = $_POST['pricePerUnit'];

	//Display variables back on add-items.php to make form sticky
	$_SESSION['name'] = $name;
	$_SESSION['itemName'] = $itemName;
	$_SESSION['numInStock'] = $numInStock;
	$_SESSION['pricePerUnit'] = $pricePerUnit;
}

else{
	//Variables for database
	$action = $_GET['action'];
	$name = $_GET['name'];
	$itemName = $_GET['itemName'];
	$numInStock = $_GET['numInStock'];
	$pricePerUnit = $_GET['pricePerUnit'];
	
	//Insert item into inventory list
	$sql = mysqli_query($db, "INSERT INTO InventoryList (itemName, numInStock, pricePerUnit) VALUES ('$itemName', '$numInStock', '$pricePerUnit')");
	//Updates change log
	$sql2 = mysqli_query($db, "INSERT INTO ChangeLog (action, name, itemName, numInStock, amount, updatedNumInStock, event, date_time) VALUES ('$action', '$name', '$itemName', '$numInStock', '-', '-', '-', NOW())");
}

$_SESSION['form_error_text'] = $errorText;
redirect_user('add-items.php');

mysqli_close($db);

?>

</body>
</html>