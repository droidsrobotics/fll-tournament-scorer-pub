<?php
	session_start();

// if (isset($_SESSION["username"]))
//     echo "Logged in as: ";


echo htmlspecialchars($_SESSION["username"] . "");;

if (!isset($_SESSION["username"])) {
    if (strpos(getcwd(), 'participants') !== false) {
        echo "<a  href='/login.php'>Login</a>";
    } else if (strpos(getcwd(), 'judges') !== false) {
        echo "<a  href='/login.php'>Login</a>";
    } else {
        echo "<a  href='/login.php'>Login</a>";
    }
} else {
    // if (trim($_SESSION["username"])!=="guest"){
    echo '; <a href="/logout.php"> Logout </a>';
}

?>