<div class="topnav" id="myTopnav" style="width:100%">
<?php
session_start();
         $role = $_SESSION["role"];
$basedir = "../";
echo '<a href="'.$basedir.'index.php" data-ajax="false">Home</a>';
if ($role == "Tournament Director") echo ' <a data-ajax="false" href="'.$basedir.'admin/setup.php">Setup</a>';
if ($role == "Tournament Director" || $role == "Referee")  echo '<a data-ajax="false" href="'.$basedir.'scorer/loadscorer.php">Score Manager</a>';
echo '<a data-ajax="false" href="'.$basedir.'readscores.html">Scoreboard</a>';
       if ($role == "Tournament Director" || $role == "Judge")  echo '<a data-ajax="false" href="'.$basedir.'rubrics/loadrb.php">Rubric Manager</a>';
if ($role == "Tournament Director" || is_numeric($role)) echo ' <a data-ajax="false" href="'.$basedir.'teams/index.php">Team Management</a>';
echo ' <a data-ajax="false" href="'.$basedir.'virtualPits.php">Virtual Pits</a>';

if ($role !== "Judge") echo ' <a data-ajax="false" href="'.$basedir.'timer.html">Timer</a>';
echo ' <a data-ajax="false" href="'.$basedir.'schedule.php">Schedule</a>';

?>

  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>
<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>
