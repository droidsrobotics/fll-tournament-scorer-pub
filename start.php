<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php?auth=start.php");
  exit;
}

if (trim($_SESSION["username"])=="guest") header("Location: logout.php");
?>
<?php

function recurse_copy($src, $dst)
{
  $dir = opendir($src);
  @mkdir($dst);
  while (false !== ($file = readdir($dir))) {
    if (($file != '.') && ($file != '..')) {
      if (is_dir($src . '/' . $file)) {
        recurse_copy($src . '/' . $file, $dst . '/' . $file);
      } else {
        copy($src . '/' . $file, $dst . '/' . $file);
      }
    }
  }
  closedir($dir);
}

// configuration
$url = 'start.php';
$file = 'tournaments.txt';

// check if form has been submitted
if (isset($_POST['text'])) {
  /*    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])):
        //your site secret key
        $secret = 'INSERT SECRET KEY';
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success):*/
  $name = $_POST['text'];
  $nameenc = md5($_POST['text']);
  if (file_exists('tournaments/' . $nameenc) != 1) {
    exec('cp -r ' . $_POST['version'] . ' tournaments/' . $nameenc);
    // exec('cp -r ' . 'tournaments/templatebeta/ tournaments/' . $nameenc);
    // exec('cp -r ' . 'tournaments/backups/templatebeta/ tournaments/backups/' . $nameenc);
    // exec('cd tournaments/' . $nameenc . '; ln -s ' . '../backups/' . $nameenc .' backup; cd ../../');
    // recurse_copy('tournaments/template/', 'tournaments/' . $nameenc);
    //			mkdir($data . '/images', 0777);
    //			copy('template/', $nameenc);
    $tournname = fopen('tournaments/' . $nameenc . '/tournament.txt', "w") or die("Unable to open tournament!");
    fwrite($tournname, $name . "\n");
    fwrite($tournname, $_POST["region"] . "\n");
    fwrite($tournname, $_POST["date"] . "\n");
    fclose($tournname);
    $tourndirect = fopen('tournaments/' . $nameenc . '/userdata/' . htmlspecialchars($_SESSION["username"]), "w") or die("Unable to open user data!");
    fwrite($tourndirect, 'Tournament Director');
    fclose($tourndirect);
    echo 'success';
    header('Location: tournaments/' . $nameenc . '/login.php?data=' . $nameenc);
  } else {
    header('Location: tournaments/' . $nameenc . '/login.php');
  }

  /*        else:
            $errMsg = 'Robot verification failed, please try again.';
	    echo $errMsg;
        endif;
    else:
        $errMsg = 'Please click on the reCAPTCHA box.';
	echo $errMsg;
    endif;*/
}

// read the textfile

//$text = file_get_contents($file);


?>

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="css/accordian.css">

  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="w3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="/js/download.js"></script>

<script>
    language = "en"
</script>
<script src="/js/languages.js"></script>
<script src="/js/language-detector.js"></script>
  <title>Start</title>

</head>

<body>
  <script>
    $(function() {
      $("#topbar").load("topbar.php");
    });
  </script>
  <div id="topbar"></div><br>
  <div>
    <script>
      $(function() {
        $("#header").load("header.html");
      });
    </script>
    <div id="header"></div><br>
    <section style="padding: 5px 5px 5px 15px;">

      <h2>Start a Tournament</h2>
    </section><br>
    <section>
      <div class="text-body" style="font-size: 20px;">

        <p style="font-size: 150%;">
          <script src='https://www.google.com/recaptcha/api.js'></script>

          <!-- HTML form -->
        <form action="" method="post">
          <b>Tournament Name:</b><br>
          <input class="form-control" style="font-size:20px;max-width:500px; height:50px" type="text" rows="20" cols="50" id="text" name="text" value=""><br><br>
          <b>Region:</b><br>
          <input class="form-control" style="font-size:20px;max-width:500px; height:50px" type="text" rows="20" cols="50" id="region" name="region" value=""><br><br>
          <b>Competition Date:</b><br>
          <input class="form-control" style="font-size:20px;max-width:500px; height:50px" type="text" rows="20" cols="50" id="date" name="date" value=""><br>
          <br>

          <!--<div class="g-recaptcha" data-sitekey="6LcK4DEUAAAAAAUGO2pq__6V0K51-DwreZYdOB3f"></div>-->
          <b>Tournament Version:</b><br>
          <select class="form-control" style="font-size:20px;max-width:500px; height:50px" id="version" name="version">
            <option value="tournaments/templates/template-v8xx">FLL Challenge SUBMERGED</option>
            <option value="tournaments/templates/template-v7xx">FLL Challenge CARGO CONNECT</option>
            <option value="tournaments/templates/template-explore-v6xx">FLL Explore</option>
            <option value="tournaments/templates/template-v6xx">FLL Challenge RePlay</option>
          </select>
<br><br>
          <input id="sub" class="btn btn-danger" value="Create" type="submit" />
          <input type="reset" class="btn btn-danger" value="Clear" />


          <br>
          <i>To create a tournament using the beta channel, click <a href="startbeta.php">here</a>.</i>
          <!--
If your tournament ALREADY exists, you will be taken directly to the urls. If your tournament DOES NOT exist yet, you will be asked to create a password(s).-->
          </p>


        </form>
      </div>
    </section><br>

    <br>
    <script>
      $(function() {
        $("#footer").load("footer.html");
      });
    </script>
    <div id="footer"></div>
  </div>
  <script src='js/accordian.js'></script>
  <script src="/js/translate.js"></script>

</body>
