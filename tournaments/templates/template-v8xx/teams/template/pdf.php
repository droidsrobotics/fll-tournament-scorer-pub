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

  <title>PDF <?php echo $_GET["file"]; ?></title>

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
      <b>
        <?php echo $_GET["file"]; ?>
      </b>
    </section><br>
    <section>
      <div class="text-body" style="font-size: 12px;">


        <p style="font-size: 150%;">

          <object data="<?php echo $_GET["file"]; ?>" type="application/pdf" width="100%" height="100%">
            <p><a href="<?php echo $_GET["file"]; ?>">Download</a></p>
          </object>

          <br><br>
        <p>
          If you are having trouble viewing the file, click <a href="<?php echo $_GET["file"]; ?>">here</a> to download it.
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