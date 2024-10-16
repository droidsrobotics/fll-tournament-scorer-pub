<?php
// Initialize the session
session_start();

// // Check if the user is logged in, if not then redirect him to login page
// $myfile = fopen('tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
// $tournament = trim(fgets($myfile));
// fclose($myfile);

// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"] !== $tournament) {
//   // header("location: ../../login.php");
//   header("location: login.php?auth=" . $_SERVER['REQUEST_URI']);

//   exit;
// }

date_default_timezone_set("UTC");

?>

<head>
  <link rel="stylesheet" type="text/css" href="../../style.css">
  <link rel="stylesheet" href="../../w3.css">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title><?php echo $_GET["file"]; ?></title>

</head>

<body>
  <script>
    $(function() {
      $("#topbar").load("../../../../topbar.php");
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
      <h2>Team No. <?php echo basename(dirname(__FILE__)); ?>
      </h2>
      <?php
      echo '<b style="font-size: 100%;"><text>Team Name</text>: ';
      echo trim(file_get_contents("name.txt"));
      echo "</b><br>";
      ?>
      <b>
        <?php echo $_GET["file"]; ?>
      </b>
    </section><br>
    <section>
      <div class="text-body" style="font-size: 12px;">


        <p style="font-size: 150%;">

          <?php
          $entry = $_GET["file"];

          if (strpos($entry, ".mov") !== false || strpos($entry, ".MOV") !== false || strpos($entry, ".m4v") !== false || strpos($entry, ".mp4") !== false || strpos($entry, ".MP4") !== false) {
            echo '
            <video controls="controls" width="100%" height="600" name="' . $_GET["file"] . '">
  <source src="' . $_GET["file"] . '">
</video>
            ';
          } else if (strpos($entry, ".pdf") !== false || strpos($entry, ".PDF") !== false) {
            echo '
          <object data="' . $_GET["file"] . '" type="application/pdf" width="100%" height="100%">
          </object>
          ';
          } else if (strpos($entry, ".png") !== false || strpos($entry, ".PNG") !== false || strpos($entry, ".jpg") !== false || strpos($entry, ".JPG") !== false) {
            echo '
          <img src="' . $_GET["file"] . '" width="100%">
          ';
          }
          ?>
          <br><br>
        <p>
          Not all files can be previewed in a browser. If you are having trouble viewing the file, click <a href="<?php echo $_GET["file"]; ?>">here</a> to download it. You may need a program like VLC to view some video formats.
        </p>
        <br>
        </p>
      </div>

    </section>
    <br>
    <script>
      $(function() {
        $("#footer").load("../../footer.html");
      });
    </script>
    <div id="footer"></div>
  </div>
  <script src='js/accordian.js'></script>

</body>