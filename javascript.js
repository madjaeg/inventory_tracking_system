$(document).ready(function(){
	//Grabs number in stock from grab-num-in-stock.php for request.php and restock.php
	$.get( "grab-num-in-stock.php", function( data ) {
  		$( ".result" ).html( data );
	});

	//Changes color of cell on index.php if # in stock is low
	$(".lowInStock td").each(function(){
	    var val = parseInt(this.innerHTML);
	    if (val <= 50) {
	        this.style.backgroundColor = "#D4595B";
	    }
	});
});

//Grabs variables and appends URL for add-items-form.php
function addItemsAppendURL(){
	//Grabs text in name div
	var name = document.getElementById("name").value;
	//Grab content from item name text box
	var itemName = document.getElementById('itemName').value;
	//Grab content from # In Stock text box
	var numInStock = document.getElementById('numInStock').value;
	//Grab content from price per unit text box
	var pricePerUnit = document.getElementById('pricePerUnit').value;
	//Action being displayed
	var action = "Adding New Item";
	//Grabs the id of the form on add-items.php
	addItemsForm = document.getElementById("addItemsForm");
	//Using the URL from add-items-form.php, appends the URL to pass variables
	appendURL = addItemsForm.action + "?name=" + name + "&itemName=" + itemName + "&numInStock=" + numInStock + "&pricePerUnit=" + pricePerUnit + "&action=" + action;
	addItemsForm.action = appendURL;
};

//Grabs # In Stock from grab-num-in-stock.php and displays on # In Stock column on request.php and restock.php
$(function(){
	$('#itemNameDropDown').change(function(){
		var SelectedItem = $(this).val();
		//Sending the selected item value to the php file as JSON
		//Assuming that the php file is setup to consume $_GET variables
		$.get('grab-num-in-stock.php', {"item": SelectedItem})
		.done(function(returnedData){
		//Assuming just a string is returned right now
			$('.numInStockCol').text(returnedData);
		});
	});
});

//Grabs variables and appends URL for request.php
function requestAppendURL(){
	//Grabs text in name div
	var name = document.getElementById("name").value;
	//Grabs selected item name on itemNameDropDown
	var itemNameDropDown = document.getElementById("itemNameDropDown");
	var selectedItem = itemNameDropDown.options[itemNameDropDown.selectedIndex].text;
	//Grabs the number in stock from # In Stock column
	var numInStock = document.getElementById("numInStockCol").innerHTML;
	var numInStock = parseInt(numInStock); 
	//Grabs selected value from eventDropDown
	var eventDropDown = document.getElementById("eventDropDown");
	var selectedEvent = eventDropDown.options[eventDropDown.selectedIndex].value;
	//Action being displayed
	var action = "Requesting Item";
	//Grabs the id of the form on request.php
	requestForm = document.getElementById("requestForm");
	//Using the URL from request.php and restock.php, appends the URL to pass variables
	appendURL = requestForm.action + "?currentNumInStockURL=" + numInStock + "&itemName=" + selectedItem + "&name=" + name + "&event=" + selectedEvent + "&action=" + action;
	requestForm.action = appendURL;
};

//Grabs variables and appends URL for restock.php
function restockAppendURL(){
	//Grabs text in name div
	var name = document.getElementById("name").value;
	//Grabs selected item name on itemNameDropDown
	var itemNameDropDown = document.getElementById("itemNameDropDown");
	var selectedItem = itemNameDropDown.options[itemNameDropDown.selectedIndex].text;
	//Grabs the number in stock from # In Stock column
	var numInStock = document.getElementById("numInStockCol").innerHTML;
	var numInStock = parseInt(numInStock); 
	//Grabs selected value from eventDropDown
	var eventDropDown = document.getElementById("eventDropDown");
	var selectedEvent = eventDropDown.options[eventDropDown.selectedIndex].value;
	//Action being displayed
	var action = "Restocking Item";
	//Grabs the id of the form on request.php
	restockForm = document.getElementById("restockForm");
	//Using the URL from request.php and restock.php, appends the URL to pass variables
	appendURL = restockForm.action + "?currentNumInStockURL=" + numInStock + "&itemName=" + selectedItem + "&name=" + name + "&event=" + selectedEvent + "&action=" + action;
	restockForm.action = appendURL;
};