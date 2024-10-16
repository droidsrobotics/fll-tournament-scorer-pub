<?php

//TESTS
session_start();

// Store data in session variables

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with INSERT PASSWORD password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'INSERT PASSWORD');
define('DB_NAME', 'tournament');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}



?>
