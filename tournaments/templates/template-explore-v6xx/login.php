<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if ((!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) && $_GET["req"] != "temp") {
  header("location: ../../login.php?auth=" . $_SERVER['REQUEST_URI']);
  exit;
}
?>

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="css/accordian.css">

  <link rel="stylesheet" href="w3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>Login</title>

</head>

<body>
  <script>
    $(function() {
      $("#topbar").load("../../topbar.php");
    });
  </script>
  <div id="topbar"></div><br>
  <div>
    <script>
      $(function() {
        $("#header").load("header.php");
      });
    </script>
    <div id="header" <?php if ($_GET["header"]=="hide") echo 'style="display:none;"' ?>></div>
    <br>
    <section style="padding: 5px 5px 5px 15px;">

      <h2>Login:</h2>
    </section><br>
    <section>
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

          if ($_GET["auth"] == "denied") echo "<b style='color:red'>You do not have access to view this page. Please contact your tournament director if you think that this is a mistake.</b><br><br>";


          if (isset($_POST["tempcode"])) {
            if (trim(file_get_contents("userdata/accessCode.txt")) == trim($_POST["tempcode"])) {
              $_SESSION["loggedin"] = true;
              $_SESSION["role"] = "TEMP";
              $_SESSION["username"] = "guest";
              $_SESSION["tournament"] = $tournament;
              if (!isset($_GET["auth"])) header("location: index.php");
              if (isset($_GET["auth"]) && $_GET["auth"] !== "denied") header("Location: " . $_GET["auth"]);
            } else {
              echo "<b style='color:red!important'>Incorrect Code</b><br>";
            }
          }

          if ($_GET["req"] == "temp") {
            echo "
            <form action='' method='POST'>
              <b>Virtual Pit Access Code:</b>
              <input type='text' name='tempcode' class='form-control' style='max-width:300px;'>
              <input type='submit' value='Submit' class='btn btn-danger'>
            </form>
            <br>
            ";
            if ($_GET["header"]!=="hide") {
              if (!isset($_GET["auth"])) echo "Or login with a FLLTutorials Tournament account <a href='login.php'>here</a>.";
              else echo "<p>Or login with a FLLTutorials Tournament account <a href='login.php?auth=".$_GET["auth"]."'>here</a>.</p>";
            }

          } else {

            if (isset($_POST["role"])) {
              // echo "HERE";
              $_SESSION["role"] = $_POST["role"];
              $_SESSION["tournament"] = $tournament;
            }



            if (file_exists('userdata/' . strtolower($_SESSION["username"]))) {
              $myfile = fopen('userdata/' . strtolower($_SESSION["username"]), "r") or die("You are not registered for this tournament. Please contact your tournament director");
              //  $filerole = trim(fgets($myfile));
              //  fclose($myfile);

              $flag = 0;
              while (!feof($myfile)) {
                $filerole = trim(fgets($myfile));
                $flag = $flag + 1;
              }
              fclose($myfile);

              if (!isset($_POST["role"])) {
                if ($flag == 1) {
                  $_SESSION["role"] = $filerole;
                  $_SESSION["tournament"] = $tournament;
                  if (!is_numeric($filerole)) echo 'Welcome ' .  strtolower($_SESSION["username"]) . ' to tournament ' . $tournament . '. You have been registered as a ' . $filerole . '.';
                  else echo 'Welcome ' .  strtolower($_SESSION["username"]) . ' to tournament ' . $tournament . '. You have been registered as Team No. ' . $filerole . '.';
                  if (!isset($_GET["auth"])) header("location: index.php");
                  if (isset($_GET["auth"]) && $_GET["auth"] !== "denied") header("Location: " . $_GET["auth"]);
                } else {
                  $_SESSION["multirole"] = true;
                  echo "It appears that you are registered for multiple roles. Please select one to continue:<br>";
                  echo "
      <form action='' method='POST'>
      <select  class='form-control' name='role'>
      ";
                  $myfile = fopen('userdata/' . strtolower($_SESSION["username"]), "r") or die("You are not registered for this tournament. Please contact your tournament director if you think that this is a mistake.");
                  $flag = 0;
                  while (!feof($myfile)) {
                    $role = trim(fgets($myfile));
                    if (!is_numeric($role)) echo "<option>" . $role . "</option>";
                    else echo "<option value='" . $role . "'>Team No. " . $role . "</option>";
                  }
                  fclose($myfile);


                  echo "
      </select>
      <input class='btn btn-danger' type='submit' value='Login'>
      </form>

      ";
                }
              } else {
                $filerole = $_SESSION["role"];
                if (!is_numeric($filerole)) echo 'Welcome ' .  strtolower($_SESSION["username"]) . ' to tournament ' . $tournament . '. You have been registered as a ' . $filerole . '.';
                else echo 'Welcome ' .  strtolower($_SESSION["username"]) . ' to tournament ' . $tournament . '. You have been registered as Team No. ' . $filerole . '.';

                // echo "GET ".$_GET["auth"];
                if (isset($_GET["auth"]) && $_GET["auth"] !== "denied") header("Location: " . $_GET["auth"]);
                else if (!isset($_GET["auth"])) header("location: index.php");
              }
            } else {
              echo 'You are not registered for this tournament';
            }
          }
          ?>

          <br>
          <?php
          if ($_GET["header"]!=="hide") echo ' <a href="/welcome.php">Return to home</a>';
          ?>

        </p>
      </div>

    </section>
    <br>
    <script>
      $(function() {
        $("#footer").load("footer.html");
      });
    </script>
    <div id="footer"></div>
  </div>
  <script src='js/accordian.js'></script>

</body>