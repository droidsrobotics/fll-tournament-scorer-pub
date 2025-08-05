<!DOCTYPE html>

<html>
<?php
// Initialize the session
session_start();

if (file_exists("userdata/accessCode.txt")) {
	// Check if the user is logged in, if not then redirect him to login page
	$myfile = fopen('tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
	$tournament = trim(fgets($myfile));
	fclose($myfile);

	if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"] !== $tournament) {
		// header("location: ../../login.php");
		header("location: login.php?req=temp&header=" . $_GET["header"] . "&auth=" . $_SERVER['REQUEST_URI']);
		exit;
	}
}
date_default_timezone_set("UTC");

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Schedule</title>
    <!-- Bootstrap core CSS -->
    <!-- Bootstrap theme -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/accordian.css">

    <link rel="stylesheet" href="../w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="admin/scheduler/scheduler.css" rel="stylesheet">

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

            <h2>Schedule
            </h2>
        </section><br>
        <section>
            <div class="text-body" style="font-size: 14px;">

                <!-- Fixed navbar -->
                
                <div class="container">
                    <div class="starter-template" id="results"><?php echo file_get_contents("admin/schedule.html"); ?></div>
                </div>
                <style>
                    .btn-info {
                        display: none !important;
                    }
                </style>
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

<script src="admin/scheduler/tabs.js" type="text/javascript"></script>
<script src="admin/scheduler/pdf.js" type="text/javascript"></script>
<script src="admin/scheduler/generator.js" type="text/javascript"></script>
<script src="admin/scheduler/scheduler.js" type="text/javascript"></script>

<script>
    document.getElementById("teamNameBox").value = document.getElementById("teamNameBox").value.trim()
    document.getElementById("teamNumBox").value = document.getElementById("teamNumBox").value.trim()
    var names = $("#teamNameBox").val().split("\n");
    for (var i = 0; i < names.length; i++) {
        TEAMNAMES.setName(i, names[i]);
    }
    var nums = $("#teamNumBox").val().split("\n");
    for (var i = 0; i < nums.length; i++) {
        TEAMNAMES.setNum(i, nums[i]);
    }
</script>
<!-- JQUERY -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
<script src="http://pdfmake.org/build/pdfmake.min.js"></script>
<script src="http://pdfmake.org/build/vfs_fonts.js"></script>

</html>