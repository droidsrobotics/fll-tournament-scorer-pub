<?php
session_start();
 set_time_limit(0); # This program needs to run forever. 
 $filename = end(explode("/",$_SERVER[REQUEST_URI]));
//  while (true) {
        // echo $filename;
        // echo "hello";
        // echo basename(dirname(__DIR__))."\n";
if (isset($_SESSION['loggedin']) && ($_SESSION["role"] == "Tournament Director" || $_SESSION["role"] == "Judge" || $_SESSION["role"] == "Referee" || $_SESSION["role"] == basename(dirname(__DIR__)))) {
        readfile($filename);
} else {
        echo "Permission Denied\n";
}
// }
?>