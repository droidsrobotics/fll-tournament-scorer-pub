<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
$myfile = fopen('../tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
$tournament = trim(fgets($myfile));
fclose($myfile);

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"]!==$tournament || $_SESSION["role"] !== "Tournament Director"){
    header("location: ../login.php");
    exit;
}
?>
<head>
<link rel="stylesheet" type="text/css" href="../style.css">
<link rel="stylesheet" type="text/css" href="../css/accordian.css">

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="../w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<title>User Creator</title>

</head>
<body><script>
        $(function() {
            $("#topbar").load("../../../topbar.php");
        });
    </script>
    <div id="topbar"></div><br>
  <div >
   <script>
    $(function(){
      $("#header").load("header.html");
    });
    </script>
     <div id="header"></div><br>
  <section style="padding: 5px 5px 5px 15px;">

  <h2>Invite Volunteer:</h2>
</section><br><section>
<div class="text-body" style="font-size: 14px;">
<?php

// configuration
$url = '';
//$file = 'tournaments.txt';

// check if form has been submitted
if (isset($_POST['usr']))
{
  $txt = $_POST['role'];

  if (!file_exists('../userdata/'. $_POST['usr'])) {
    $myfile = fopen('../userdata/'. $_POST['usr'], "w");
      $txt = $_POST['role'];
    fwrite($myfile, $txt);
    fclose($myfile);
  } else {
    $user_pass = fopen("../userdata/" . $_POST['usr'], "r");
    $flag = 0;
    while(!feof($user_pass)) 
    {
        $p = trim(fgets($user_pass));
        if($_POST['role'] == $p)
        {
            $flag = 1;
        }
    }
    fclose($user_pass);

    if ($flag == 0) {
      $current = file_get_contents("../userdata/" . $_POST['usr']);
      $current .= "\n". $_POST['role'];
      file_put_contents("../userdata/" . $_POST['usr'], $current);
    }
  }
  exec('printf "To: '.$_POST['usr'].'\nFrom: noreply@ev3lessons.com\nSubject: Invitation for FLL Challenge Tournament Scoring System\nWelcome to '.$tournament.' tournament. Your FLL Challenge tournament director has invited you to be a '.$txt.'. Please create an account at tournament.flltutorials.com with your email address. You will then be able to log into the tournament from your account." | msmtp '.$_POST['usr'].'');

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
Tournament Director:</b> Create a user for the Tournament Director. This user will be able to access the Tournament Scorer designed for your tournament and the Setup page.<br>
<b>Judge:</b> Create one user per Judge. The judges will only be able to access only the Tournament Judging page.<br>
<b>Referee:</b> Create one user per Referee. The referees will only be able to access only the Tournament Scorer page.<br>
<form action="" method="post">
<b>Email:</b><input class="form-control" type="username" rows="20" cols="50" id="usr" name="usr" value="">
<br>
<b>Role:</b><select class="form-control" id="role" name="role">
  <option>Tournament Director</option>
  <option>Judge</option>
  <option>Referee</option>
  </select>
<br>
<input class="btn btn-danger btn-lg" type="submit" />
<input class="btn btn-danger btn-lg" type="reset" />
<br>


</p>

</form>
</div>

</section>
<br>
    <script>
    $(function(){
      $("#footer").load("../footer.html");
    });
    </script>
     <div id="footer"></div>
  </div>
<script src='js/accordian.js'></script>

</body>
