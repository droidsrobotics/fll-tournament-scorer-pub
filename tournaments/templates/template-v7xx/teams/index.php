
<head>
<link rel="stylesheet" type="text/css" href="../style.css">
<link rel="stylesheet" type="text/css" href="../css/accordian.css">

<link rel="stylesheet" href="../w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<title>Teams</title>

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

  <h2>Team Management
</h2>
  </section><br><section> <div class="text-body" style="font-size: 14px;">


<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
$myfile = fopen('../tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
$tournament = trim(fgets($myfile));
fclose($myfile);

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"]!==$tournament){
    header("location: ../login.php?auth=".$_SERVER['REQUEST_URI']);
    exit;
}

if (is_numeric($_SESSION["role"])) {
  header("location: ".$_SESSION["role"]);
  exit;
}

?>
<style>
h1 {
    color:red;
    font-family:verdana;
    font-size:200%;
}
b  {
    color:green;
    font-family:arial;
    font-size:100%
}
p  {
    color:brown;
    font-family:arial;
    font-size:110%
}
</style>
<!-- <a href="../"><img src="http://archive.ev3lessons.com/arrow.jpg"></a> -->
<!-- <h1>Team Management</h1> -->

<?php
if (file_exists("../admin/teams.txt")) {
$file = fopen("../admin/teams.txt","r");

while(! feof($file))
  {
    $line = fgets($file);
    $teamno = (int) explode(",",$line)[0];
  echo "<a href='".$teamno."/index.php'><img src='http://archive.ev3lessons.com/folder.gif'>Team ".$teamno.": ".explode(",",$line)[1]."</a><br />";
  }

fclose($file);

} else {
  echo "<b style='color:red'>Error: teams list has not been created.</b>";
}

?>

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
