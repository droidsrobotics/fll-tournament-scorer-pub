<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
$myfile = fopen('tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
$tournament = trim(fgets($myfile));
fclose($myfile);

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"] !== $tournament) {
  // header("location: ../../login.php");
  header("location: login.php?auth=" . $_SERVER['REQUEST_URI']);

  exit;
}

date_default_timezone_set("UTC");

?>

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>Dashboard</title>

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
    <div id="header"></div><br>
    <section style="padding: 5px 5px 5px 15px;">

      <h2>
        <script>
          function textFileToArray(filename) {
            var reader = (window.XMLHttpRequest != null) ?
              new XMLHttpRequest() :
              new ActiveXObject("Microsoft.XMLHTTP");
            reader.open("GET", filename, false);
            reader.send();
            return reader.responseText.split(/\r\n|\n|\r/); //split(/(\r\n|\n)/g)
          }
          document.write(textFileToArray('tournament.txt')[0]);
        </script>

        Tournament Dashboard
      </h2>
    </section><br>
    <section>
      <div class="text-body" style="font-size: 12px;">
        <p style="font-size: 150%;">
          <?php
          if ($_SESSION["multirole"]) {
            echo '<a href="login.php">Switch Roles </a><br><br>';
          }
          ?>


          <?php
          if ($_SESSION["role"] == "Tournament Director") {
            echo '
            <b>Tournament director:</b> Fill out the teams list in the
          <a href="admin/setup.php">Tournament Director Setup Panel</a>.
          <br><br>
          ';
          }
          if (is_numeric($_SESSION["role"]) || $_SESSION["role"] == "Tournament Director") {
            echo '<b>Team coach:</b> You can submit necessary information (as per your tournament director\'s instruction) in the <a href="teams/">Team management</a> page.<br><br>
          ';
          }
        

          if ($_SESSION["role"] == "Judge" || $_SESSION["role"] == "Tournament Director") {
            echo '
          <b>Judge:</b> You can judge teams using the digitized FLL Explore rubrics at <a href="rubrics/loadrb.php">Rubric Manager</a> Select the team and the core area you wish to judge.
          <br>
          <br>
          ';
          } ?>


          <!-- <a href="timer.html">Full screen 2:30 Timer</a><br><br> -->



          <!--
  <b>STEP 4:</b> If at any point, the Head Referee needs to make an
  adjustment to the scores because a scoring error is discovered, the
  Head Referee can access the Score Editor page.

  <script>
    document.write('<a href="login.php?data=edit">Score Editor for Head Referee</a><br>');
  </script>-->
          <br>
          <br>
          <!--<script>
      document.write('<a href="recovery.php?data='+window.location.hash.substring(1)+'">Password Recovery</a><br>');
</script>-->
          <br>
          <br>
          <script>
            function textFileToArray(filename) {
              var reader = (window.XMLHttpRequest != null) ?
                new XMLHttpRequest() :
                new ActiveXObject("Microsoft.XMLHTTP");
              reader.open("GET", filename, false);
              reader.send();
              return reader.responseText.split(/\r\n|\n|\r/); //split(/(\r\n|\n)/g)
            }
          </script>


          <a href="../../welcome.php">Exit Tournament</a><br><br>


          <br>
          You are running Tournament Scorer v<script>
            document.write(textFileToArray('version.txt')[0]);
          </script>

          <!--
. If you are using anything earlier (created tournament before 9:00 PM 10/18/15) some links may be broken/inaccessable please use the <script>
   function UrlExists(url)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
   }
 if (UrlExists(dir + '/version.txt') != true) {
   if (UrlExists(dir + '/tournament.txt') != true) {
      document.write('<a href="/upgrade.php#'+decodeURIComponent(window.location.hash.substring(1))+'">Upgrade Assistant</a><br>');
   } else {
document.write('<a href="/upgrade.php#'+textFileToArray(window.location.hash.substring(1) + '/tournament.txt')+'">Upgrade Assistant</a><br>');
   }} else {document.write('upgrade link (moved to Tournament Director Setup Panel).')}
 </script>
-->
          <br>
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
