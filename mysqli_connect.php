<?php

//Create connection
DEFINE ('DB_HOST', 'localhost'); //Database server -- Typically "localhost"
DEFINE ('DB_USER', 'username'); //Database User Name
DEFINE ('DB_PASSWORD', 'password'); //Database User Password
DEFINE ('DB_NAME', 'database_name'); //Database Name

//Check connection
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to SOIS MySQL server with error: ' . mysqli_connect_error());

?>