<?php
//This function determines an absolute URL and redirects the user there.
function redirect_user ($page = 'index.php') {
	//Start defining the URL
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

	//Remove any trailing slashes
	$url = rtrim($url, '/\\');

	//Add the page
	$url .= '/' . $page;

	//Redirect the user
	header("Location: $url");
	exit(); //quit the script
} //End of redirect_user() function