<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../login.php");
    exit;
}
?>

<head>
<link rel="stylesheet" type="text/css" href="styleOld.css">
<link rel="stylesheet" type="text/css" href="css/accordian.css">

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<title>Login</title>

</head>
<body><script>
        $(function() {
            $("#topbar").load("../../topbar.php");
        });
    </script>
    <div id="topbar"></div><br>
  <div style="max-width: 1024px;margin:0 auto;">
    <script>
    $(function(){
      $("#header").load("header.html");
    });
    </script>
     <div id="header"></div>
     <br>
  <section style="padding: 5px 5px 5px 15px;">

  <h2>Login:</h2>
</section><br><section>
<div class="text-body" style="font-size: 20px;">

<p style="font-size: 100%;">

<!-- HTML form -->

<?php

// configuration
//$file = 'tournaments.txt';

// check if form has been submitted



$myfile = fopen('tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
$tournament = trim(fgets($myfile));
fclose($myfile);

if (isset($_POST["role"])) {
  // echo "HERE";
  $_SESSION["role"] = $_POST["role"];
  $_SESSION["tournament"] = $tournament;
}

if (file_exists('userdata/'. $_SESSION["username"])) {
   $myfile = fopen('userdata/'. $_SESSION["username"], "r") or die("You are not registered for this tournament. Please contact your tournament director");
  //  $filerole = trim(fgets($myfile));
  //  fclose($myfile);

  $flag = 0;
  while(!feof($myfile)) 
  {
      $filerole = trim(fgets($myfile));
      $flag = $flag + 1;
  }
  fclose($myfile);

   if (!isset($_POST["role"])) {
    if ($flag == 1) {
      $_SESSION["role"] = $filerole;
      $_SESSION["tournament"] = $tournament;
      if (!is_numeric($filerole)) echo 'Welcome ' .  $_SESSION["username"] . ' to tournament ' . $tournament . '. You have been registered as a ' . $filerole . '.';
      else echo 'Welcome ' .  $_SESSION["username"] . ' to tournament ' . $tournament . '. You have been registered as Team No. ' . $filerole . '.';

    } else {
      echo "It appears that you are registered for multiple roles. Please select one to continue:<br>";
      echo "
      <form action='' method='POST'>
      <select name='role'>
      ";
      $myfile = fopen('userdata/'. $_SESSION["username"], "r") or die("You are not registered for this tournament. Please contact your tournament director if you think that this is a mistake.");
      $flag = 0;
      while(!feof($myfile)) 
      {
          $role = trim(fgets($myfile));
          if (!is_numeric($role)) echo "<option>".$role."</option>";
          else echo "<option value='".$role."'>Team No. ".$role."</option>";
      }
      fclose($myfile);
    
        
      echo "
      </select>
      <input type='submit' value='Login'>
      </form>
      
      ";
    }
   } else {
    $filerole = $_SESSION["role"];
    if (!is_numeric($filerole)) echo 'Welcome ' .  $_SESSION["username"] . ' to tournament ' . $tournament . '. You have been registered as a ' . $filerole . '.';
    else echo 'Welcome ' .  $_SESSION["username"] . ' to tournament ' . $tournament . '. You have been registered as Team No. ' . $filerole . '.';


  }
   
} else {
   echo 'You are not registered for this tournament';
}

?>

<br>
<a href="index.php">Return to home</a>

</p>
</div>

</section>
<br>
    <script>
    $(function(){
      $("#footer").load("footer.html");
    });
    </script>
     <div id="footer"></div>
  </div>
<script src='js/accordian.js'></script>

</body>
