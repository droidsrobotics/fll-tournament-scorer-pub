<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
$myfile = fopen('../../tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
$tournament = trim(fgets($myfile));
fclose($myfile);

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"]!==$tournament){
    header("location: ../../login.php");
    exit;
}

if (!($_SESSION["role"] == "Tournament Director" || $_SESSION["role"] == "Judge" || $_SESSION["role"] == "Referee" || $_SESSION["role"] == basename(dirname(__FILE__)))) {
    header("location: ../");
    exit;
}

?>


<head>
<link rel="stylesheet" type="text/css" href="../../style.css">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="../../css/accordian.css">

<link rel="stylesheet" href="../../w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<title>Teams</title>
 
</head>
<body><script>
        $(function() {
            $("#topbar").load("../../../../topbar.php");
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

  <h2>Team Management (Team No. <?php echo basename(dirname(__FILE__)); ?>)
</h2>
  </section><br><section> <div class="text-body" style="font-size: 14px;">

<!-- <a href="../"><img src="http://archive.ev3lessons.com/arrow.jpg"></a> -->
<!-- <h1>Team Management</h1> -->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> -->
<body>

<?php

// configuration
//$url = 'setup.php';
$file = 'data.txt';

// check if form has been submitted
if (isset($_POST['judge']))
{
    // save the text contents
    // $file = str_replace("\r", "", $file);
    // file_put_contents($file, $_POST['text']);

    $file = fopen('judge.txt', "w") or die("<br><b>Failed</b><br>");
    fwrite($file, $_POST["judge"]);
    fclose($file);
    $file = fopen('robot1.txt', "w") or die("<br><b>Failed</b><br>");
    fwrite($file, $_POST["robot1"]);
    fclose($file);
    $file = fopen('robot2.txt', "w") or die("<br><b>Failed</b><br>");
    fwrite($file, $_POST["robot2"]);
    fclose($file);
    $file = fopen('robot3.txt', "w") or die("<br><b>Failed</b><br>");
    fwrite($file, $_POST["robot3"]);
    fclose($file);
    $file = fopen('other.txt', "w") or die("<br><b>Failed</b><br>");
    fwrite($file, $_POST["other"]);
    fclose($file);

    // exec("firefox --screenshot ./out1.jpg " . $_POST["judge"]);
    // exec("firefox --screenshot ./out2.jpg ".$_POST["robot1"]);
    // exec("firefox --screenshot ./out3.jpg ".$_POST["robot2"]);
    // exec("firefox --screenshot ./out4.jpg ".$_POST["robot3"]);
    // exec("firefox --screenshot ./out5.jpg ".$_POST["other"]);
    // exec("convert -compress jpeg out*.jpg submission.pdf");

    // redirect to form again
    //header(sprintf('Location: %s', $url));

// printf('<h3><b style="color: red">Saved; <a target="_blank" href="submission.pdf">Preview Submission PDF</a></b></h3>.');
 
echo "";
}

// read the textfile
// $text = file_get_contents($file);

$file = fopen("judge.txt","r");
// read the textfile 
$judge = trim(fgets($file));
fclose($file);

$file = fopen("robot1.txt","r");
// read the textfile 
$robot1 = trim(fgets($file));
fclose($file);

$file = fopen("robot2.txt","r");
// read the textfile 
$robot2 = trim(fgets($file));
fclose($file);

$file = fopen("robot3.txt","r");
// read the textfile 
$robot3 = trim(fgets($file));
fclose($file);

$file = fopen("other.txt","r");
// read the textfile 
$other = trim(fgets($file));
fclose($file);

?>

<!-- HTML form -->
<b>Upload data</b><br>
Instructions: Use this textbox to put link to any submissions needed. For example, if this is an online tournament, link to required videos by your tournament director
<form action="" method="post">
<br>
Link to Judging Video: <input  class="form-control" type="text" id="judge" name="judge" value="<?php echo htmlspecialchars($judge); ?>">

<br>

Link to Robot Game Round 1 Video: <input class="form-control" type="text" id="robot1" name="robot1" value="<?php echo htmlspecialchars($robot1); ?>">
<br>


Link to Robot Game Round 2 Video: <input class="form-control" type="text" id="robot2" name="robot2" value="<?php echo htmlspecialchars($robot2); ?>">
<br>

Link to Robot Game Round 3 Video: <input class="form-control" type="text" id="robot3" name="robot3" value="<?php echo htmlspecialchars($robot3); ?>">
<br>

Link to Other Materials: <input class="form-control" type="text" id="other" name="other" value="<?php echo htmlspecialchars($other); ?>">

<br>

      <!-- <textarea rows="20" cols="50" id="text" name="text"><?php echo htmlspecialchars($text) ?></textarea><br> -->
      <?php
      if (!($_SESSION["role"] == "Judge" || $_SESSION["role"] == "Referee")) { 
        echo '<input id="teams" value="Submit" class="btn btn-danger btn-lg" type="submit"/>';
      }
      ?>
</form>
<br>
<br><h3>Self Evaluation Scores:</h3>

<?php
$teamno = basename(dirname(__FILE__));
        echo "<a href='../../scorer/indexSE.php?round=1&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>Edit Robot Game Round 1 Score</a><br />";
        echo "<a href='../../scorer/indexSE.php?round=2&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>Edit Robot Game Round 2 Score</a><br />";
        echo "<a href='../../scorer/indexSE.php?round=3&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>Edit Robot Game Round 3 Score</a><br />";

if ($_SESSION["role"] == "Tournament Director" || $_SESSION["role"] == "Judge" || $_SESSION["role"] == "Referee") {
    echo "<br><h3>Edit Final Scores:</h3>";

    $teamno = basename(dirname(__FILE__));
        echo "<a href='../../scorer/index.php?round=1&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>Edit Robot Game Round 1 Score</a><br />";
        echo "<a href='../../scorer/index.php?round=2&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>Edit Robot Game Round 2 Score</a><br />";
        echo "<a href='../../scorer/index.php?round=3&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>Edit Robot Game Round 3 Score</a><br />";

        echo "<a href='../../rubrics/project.php?round=1&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>Edit Innovation Project Judging Rubric</a><br />";
        echo "<a href='../../rubrics/robot.php?round=1&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>Edit Robot Design Judging Rubric</a><br />";
        echo "<a href='../../rubrics/corevalues.php?round=1&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>Edit Core Values Judging Rubric</a><br />";

} 

echo "<br><h3>View Released Scores:</h3>";
$teamno = basename(dirname(__FILE__));
if (file_exists("../../admin/release2.txt")) {
    if (file_exists("robotScores/1.txt")) {
        echo "<a href='../../scorer/indexRO.php?round=1&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>View Robot Game Round 1 Score</a><br />";
    }
    if (file_exists("robotScores/2.txt")) {
        echo "<a href='../../scorer/indexRO.php?round=2&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>View Robot Game Round 2 Score</a><br />";
    }
    if (file_exists("robotScores/3.txt")) {
        echo "<a href='../../scorer/indexRO.php?round=3&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>View Robot Game Round 3 Score</a><br />";
    }
}
if (file_exists("../../admin/release.txt")) {
    if (file_exists("robotScores/rb-rp.txt")) {
        echo "<a href='../../rubrics/projectRO.php?round=1&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>View Innovation Project Judging Rubric</a><br />";
    }
    if (file_exists("robotScores/rb-rd.txt")) {
        echo "<a href='../../rubrics/robotRO.php?round=1&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>View Robot Design Judging Rubric</a><br />";
    }
    if (file_exists("robotScores/rb-cv.txt")) {
        echo "<a href='../../rubrics/corevaluesRO.php?round=1&team=".$teamno."'><img src='http://archive.ev3lessons.com/folder.gif'>View Core Values Judging Rubric</a><br />";
    }
}
?>
</body>

</div>

</section>
<br>
    <script> 
    $(function(){
      $("#footer").load("../../footer.html"); 
    });
    </script>
     <div id="footer"></div>
  </div>
<script src='../../js/accordian.js'></script>

</body>
