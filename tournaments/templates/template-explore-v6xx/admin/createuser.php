<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
$myfile = fopen('../tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
$tournament = trim(fgets($myfile));
fclose($myfile);

// if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"]!==$tournament || $_SESSION["role"] !== "Tournament Director"){
//     header("location: ../login.php");
//     exit;
// }

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"] !== $tournament) {
  header("location: ../login.php?auth=" . $_SERVER['REQUEST_URI']);
  exit;
}

if ($_SESSION["role"] !== "Tournament Director") {
  header("location: ../login.php?auth=denied");
  exit;
}
?>

<head>
  <link rel="stylesheet" type="text/css" href="../style.css">
  <link rel="stylesheet" type="text/css" href="../css/accordian.css">

  <link rel="stylesheet" href="../w3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>User Creator</title>

</head>

<body>
  <script>
    $(function() {
      $("#topbar").load("../../../topbar.php");
    });
  </script>
  <div id="topbar"></div><br>
  <div>
    <script>
      $(function() {
        $("#header").load("header.php");
      });
    </script>
    <div id="header"></div><br>
    <section style="padding: 5px 5px 5px 15px;">

      <h2>Invite Volunteer:</h2>
    </section><br>
    <section>
      <div class="text-body" style="font-size: 14px;">
        <?php

        // configuration
        $url = '';
        //$file = 'tournaments.txt';

        // check if form has been submitted
        if (isset($_POST['usr'])) {
          $txt = $_POST['role'];

          if (!file_exists('../userdata/' . $_POST['usr'])) {
            $myfile = fopen('../userdata/' . $_POST['usr'], "w");
            $txt = $_POST['role'];
            fwrite($myfile, $txt);
            fclose($myfile);
          } else {
            $user_pass = fopen("../userdata/" . $_POST['usr'], "r");
            $flag = 0;
            while (!feof($user_pass)) {
              $p = trim(fgets($user_pass));
              if ($_POST['role'] == $p) {
                $flag = 1;
              }
            }
            fclose($user_pass);

            if ($flag == 0) {
              $current = file_get_contents("../userdata/" . strtolower($_POST['usr']));
              $current .= "\n" . $_POST['role'];
              file_put_contents("../userdata/" . strtolower($_POST['usr']), $current);
            }
          }
          if (strpos($_SERVER['SERVER_NAME'], "virtualopeninvitational") !== false) {
            exec('printf "To: ' . $_POST['usr'] . '\nFrom: FLL Tutorials Tournament\nSubject: Virtual Open Invitational Tournament Invite\nWelcome to ' . $tournament . ' tournament. Your FLL tournament director has invited you to be a ' . $txt . '. Please create an account at tournament.virtualopeninvitational.org with your email address. You will then be able to log into the tournament from your account." | msmtp ' . $_POST['usr'] . '');
          } else {
            exec('printf "To: ' . $_POST['usr'] . '\nFrom: FLL Tutorials Tournament\nSubject: FLLTutorials Tournament Invite\nWelcome to ' . $tournament . ' tournament. Your FLL tournament director has invited you to be a ' . $txt . '. Please create an account at tournament.flltutorials.com with your email address. You will then be able to log into the tournament from your account." | msmtp ' . $_POST['usr'] . '');
          }

          //header(sprintf('Location: %s', $url));
          printf('<a href="%s">Add new user</a>.', htmlspecialchars($url));
          printf('<br><a href="../index.php">View Tournament Dashboard</a>.', htmlspecialchars($_GET['data']));
          exit();
        }

        // read the textfile

        //$text = file_get_contents($file);


        ?>
        <p style="font-size: 150%;">

          <!-- HTML form --><b>User Setup:
            <br>
            Tournament Director:</b> Create a user for the Tournament Director. This user will be able to access the Tournament Rubrics designed for your tournament and the Setup page.<br>
          <b>Judge:</b> Create one user per Judge. The judges will only be able to access only the Tournament Judging page.<br>
          <br>
          The volunteer will be sent an email invitation.
        <form action="" method="post">
          <b>Email:</b><input class="form-control" type="username" rows="20" cols="50" id="usr" name="usr" value="">
          <br>
          <b>Role:</b><select class="form-control" id="role" name="role">
            <option>Tournament Director</option>
            <option>Judge</option>
          </select>
          <br>
          <input class="btn btn-danger btn-lg" type="submit" />
          <input class="btn btn-danger btn-lg" type="reset" />
          <br>

          <br>
          <h6> Current users:</h6>
          <script>
            function deleteUser(user) {
              if (confirm("Are you sure you want to delete user " + user + "?")) {
                // window.location.href="createuser.php?delete="+user; 
                document.getElementById("userdel").value = user;
                document.getElementById("userdelform").submit();
              }
            }
          </script>
          <?php
          if (isset($_POST["userdel"])) {
            exec("rm ../userdata/" . $_POST["userdel"]);
            echo "<b style='color:red'>Deleted user " . $_POST["userdel"] . ".</b><br>";
          }
          ?>
          <style>
            table,
            td,
            th {
              border: 1px solid black;
            }

            table {
              width: 100%;
              border-collapse: collapse;
            }
          </style>
          <table>
            <tr style="background-color:yellow;color: black !important;">
              <td>User</td>
              <td>Role(s)</td>
              <td>Actions</td>
            </tr>
            <?php

            if ($handle = opendir('../userdata/' . $_GET["page"])) {
              //echo "<a href='backup.php?page=" . prev(end(explode("/", $_GET["page"]))) . "'><img width='50' src='http://archive.ev3lessons.com/folder.gif'>..</a><br>";

              while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != ".." && $entry != "index.html") {
                  // echo "./backup/".$_GET["page"]."/".$entry;
                  echo "<tr><td>" . $entry . "</td> <td>" . str_replace("\n", ", ", file_get_contents('../userdata/' . $entry)) . "</td><td> <input type='button' onclick='deleteUser(\"" . $entry . "\");' value='Delete'></td></tr>";
                }
              }

              closedir($handle);
            }
            ?>
          </table>
          </p>
        </form>
        <form action="" method="POST" id="userdelform">
          <input type="hidden" id="userdel" name="userdel">
        </form>
      </div>

    </section>
    <br>
    <script>
      $(function() {
        $("#footer").load("../footer.html");
      });
    </script>
    <div id="footer"></div>
  </div>
  <script src='js/accordian.js'></script>

</body>