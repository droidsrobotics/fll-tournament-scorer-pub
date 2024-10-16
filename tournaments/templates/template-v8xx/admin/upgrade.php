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
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"]!==$tournament ){
  header("location: ../login.php?auth=".$_SERVER['REQUEST_URI']);
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

<title>Tournament Upgrade Assistant</title>

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
      $("#header").load("header.php");
    });
    </script>
     <div id="header"></div><br>
  <section style="padding: 5px 5px 5px 15px;">

  <h2>Tournament Upgrade Assistant
</h2>
  </section><br><section> <div class="text-body" style="font-size: 18px;">

 <!--If you are using anything earlier please upgrade using the <script>
   function UrlExists(url)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
   }

document.write('<a href="/upgrade.php#'+textFileToArray('/' + window.location.href.split('/')[3] + '/tournament.txt')[0]+'">Upgrade Assistant</a><br>');

 </script>-->
<p>
<?php

// configuration
//$url = 'setup.php';

// check if form has been submitted
if (isset($_POST['text']))
{
  $log = exec('cp -rfv ../../template/* ../ &> upgrade.log');
printf('<b style="color: red">Finished upgrading tournament</b><br><!--<a href="">Return</a>.-->');

echo "";
}

// read the textfile

$latest = trim(file_get_contents("../../template/version.txt"));
$current = trim(file_get_contents("../version.txt"));

// echo intval($latest) ."<br>";
// echo intval($current) ."<br>";

echo "You are running tournament scorer v".$current.". The latest version is v".$latest.".<br>";
if (intval($latest)-intval($current) < 1 && intval($latest)-intval($current) >= 0) {
  echo "You can safely upgrade your tournament.<br>";
} else {
  echo "<b style='color:red'>Warning: You cannot safely upgrade your tournament.</b><br>";
}
?>
</p>
<!-- HTML form -->

<form action="" method="post">
      <input type="hidden" name="text" value="upgrade"><br>
      <input class="btn btn-danger" id="teams" value="Upgrade" type="submit"/>
</form>

  <br>
<pre style="font-family:'Lucida Console', monospace">
<!-- Last Upgrade Log: -->
<?php
echo file_get_contents("upgrade.log");
?>
</pre>
<pre style="font-family:'Lucida Console', monospace">
Changelog:
<?php
echo file_get_contents("../../template/changelog.txt");
?>
</pre>
<!--
<br><br><br><br>
<br><b>DELETE TOURNAMENT</b><br>
<button onclick="window.location.href = '/delete.php?data=' + window.location.href.split('/')[3]">Delete This Tournament</button>
-->
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
