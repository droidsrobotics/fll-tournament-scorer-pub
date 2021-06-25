<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'XXXXXX'); // FILL IN
define('DB_USERNAME', 'XXXXX'); // FILL IN
define('DB_PASSWORD', 'XXXXX'); // FILL IN
define('DB_NAME', 'XXXXX'); // FILL IN
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
   die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
