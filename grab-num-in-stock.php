<?php
	//Connection include
	include('mysqli_connect.php');

	$receivedString = null;

	if ($_GET["item"] != ""){
		//Set var equal to currently selected drop down item
		$receivedString = $_GET["item"];
	}

	if($receivedString != null){
		//Grabs the number in stock of the selected item
		$query = mysqli_query($db, "SELECT numInStock FROM InventoryList WHERE itemName = '$receivedString'");

		if (!$query){
			echo "Could not find query. ReceivedString = $receivedString";
		}

		//Displays the number in stock of the currently selected item to the # In Stock column on request.php and restock.php
		while($row = mysqli_fetch_assoc($query)){
			echo $row['numInStock'];
		}
	}
?>