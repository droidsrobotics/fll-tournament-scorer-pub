<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
$myfile = fopen('../../tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
$tournament = trim(fgets($myfile));
fclose($myfile);

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"] !== $tournament) {
    // header("location: ../../login.php");
    header("location: ../../login.php?auth=" . $_SERVER['REQUEST_URI']);

    exit;
}

if (!($_SESSION["role"] == "Tournament Director" || $_SESSION["role"] == "Judge" || $_SESSION["role"] == "Referee" || $_SESSION["role"] == basename(dirname(__FILE__)))) {
    // header("location: ../");
    header("location: ../../login.php?auth=denied");

    exit;
}
date_default_timezone_set("UTC");
$date =  date("Y-m-d-") . date("His");

?>
<?php
if (isset($_FILES["fileToUpload"])) {
    date_default_timezone_set("UTC");
    $date =  date("Y-m-d-") . date("His");

    $target_dir = "uploads/";
    $target_file = $target_dir . $date . "_" . $_POST["label"] . "_" . basename($_FILES["fileToUpload"]["name"]);
    $target_file = str_replace("#", "_", $target_file);
    $target_file = str_replace("?", "_", $target_file);
    $bkp_file = '../../backup/submissions/team-' . basename(dirname(__FILE__)) . '-file-' . $date . "_" . $_POST["label"] . "_" . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    // if (isset($_POST["submit"])) {
    // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    // if ($check !== false) {
    // echo "File is an image - " . $check["mime"] . ".";
    // $uploadOk = 1;
    // } else {
    // echo "File is not an image.";
    // $uploadOk = 0;
    // }
    // }

    // Check if file already exists
    // if (file_exists($target_file)) {
    // echo "Sorry, file already exists.";
    // $uploadOk = 0;
    // }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 600000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    // if (
    // $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    // && $imageFileType != "gif"
    // ) {
    // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    // $uploadOk = 0;
    // }

    if ($imageFileType == "php") $uploadOk = 0;
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<br><b style='color:red'>Your file was not uploaded.</b>";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // copy($target_file, $bkp_file);
            echo "<br><b style='color:red'>The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.</b><br>";
        } else {
            echo "<br><b style='color:red'>Sorry, there was an error uploading your file.</b><br>";
        }
    }
    echo "__ENDMSG__";
    if ($handle = opendir('./uploads')) {

        $ct = 0;
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && $entry != "index.html") {
                $ct++;
                if (strpos($entry, ".mov") !==false || strpos($entry, ".MOV") !==false|| strpos($entry, ".m4v") !==false|| strpos($entry, ".mp4") !==false || strpos($entry, ".MP4")!==false) echo "<a href='video.php?file=uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
                else if (strpos($entry, ".pdf") !==false || strpos($entry, ".PDF") !==false) echo "<a href='pdf.php?file=uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
                else echo "<a target='_blank' href='uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
                if ($_SESSION["role"] == "Tournament Director") echo " <input type='button' onclick='deleteFile(\"uploads/" . $entry . "\");' value='Delete'>";
                echo "<br>";
            }
        }
        if ($ct == 0) echo "<p>None</p>";



        closedir($handle);
    }
    
    die("");
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <link rel="stylesheet" type="text/css" href="../../css/accordian.css">

    <link rel="stylesheet" href="../../w3.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
    <script src="upload_progress.js"></script>

    <title>Teams</title>
    <style>
        .progress {
            display: none;
            position: relative;
            width: 400px;
            border: 1px solid #ddd;
            padding: 1px;
            border-radius: 3px;
        }

        .bar {
            background-color: #B4F5B4;
            width: 0%;
            height: 30px;
            border-radius: 3px;
        }

        .percent {
            position: absolute;
            display: inline-block;
            top: 3px;
            left: 48%;
        }
    </style>
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

            <h2>Team Management (Team No. <?php echo basename(dirname(__FILE__)); ?>)
            </h2>
        </section><br>
        <section>
            <div class="text-body" style="font-size: 14px;">

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
                    if (isset($_POST['judge'])) {
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


                        $file = fopen('../../backup/submissions/team-' . basename(dirname(__FILE__)) . '-links-' . $_POST["date"] . '.txt', "w") or die("<br><b>Failed</b><br>");
                        fwrite($file, "\n");
                        fwrite($file, $_POST["judge"]);
                        fwrite($file, "\n");
                        fwrite($file, $_POST["robot1"]);
                        fwrite($file, "\n");
                        fwrite($file, $_POST["robot2"]);
                        fwrite($file, "\n");
                        fwrite($file, $_POST["robot3"]);
                        fwrite($file, "\n");
                        fwrite($file, $_POST["other"]);
                        fwrite($file, "\n");
                        fwrite($file, $_POST["date"]);

                        fclose($file);



                        // exec("firefox --screenshot ./out1.jpg " . $_POST["judge"]);
                        // exec("firefox --screenshot ./out2.jpg ".$_POST["robot1"]);
                        // exec("firefox --screenshot ./out3.jpg ".$_POST["robot2"]);
                        // exec("firefox --screenshot ./out4.jpg ".$_POST["robot3"]);
                        // exec("firefox --screenshot ./out5.jpg ".$_POST["other"]);
                        // exec("convert -compress jpeg out*.jpg submission.pdf");

                        // redirect to form again
                        //header(sprintf('Location: %s', $url));

                        printf('<h3><b style="color: red">Saved; </b></h3>.');
                        // printf('<h3><b style="color: red">Saved; <a target="_blank" href="submission.pdf">Preview Submission PDF</a></b></h3>.');

                        echo "";
                    }

                    // read the textfile
                    // $text = file_get_contents($file);

                    $file = fopen("judge.txt", "r");
                    // read the textfile
                    $judge = trim(fgets($file));
                    fclose($file);

                    $file = fopen("robot1.txt", "r");
                    // read the textfile
                    $robot1 = trim(fgets($file));
                    fclose($file);

                    $file = fopen("robot2.txt", "r");
                    // read the textfile
                    $robot2 = trim(fgets($file));
                    fclose($file);

                    $file = fopen("robot3.txt", "r");
                    // read the textfile
                    $robot3 = trim(fgets($file));
                    fclose($file);

                    $file = fopen("other.txt", "r");
                    // read the textfile
                    $other = trim(fgets($file));
                    fclose($file);

                    if ($_SESSION["role"] == "Tournament Director" || is_numeric($_SESSION["role"]))
                        echo '<h3>Submission Links</h3>';

                    ?>

                    <!-- HTML form -->
                    <!-- Instructions: Use this link or text boxes to submit any materials needed for your competition. -->
                    <form action="" method="post" id="myForm" name="frmupload" enctype="multipart/form-data" style="margin-left:30px">

                        <?php


                        $sublink = trim(file_get_contents("sublink.txt"));
                        // $sublink = "None";

                        if (file_exists("../../admin/release3.txt")) {
                            // if (file_exists("../../admin/release3.txt")) {
                            if ($sublink == "None" || $sublink == "") {
                                if (!file_exists("../../admin/useuploader.txt")) {

                                    echo '

                                    <br>
                                    Link to Judging Video: <input  class="form-control" type="text" id="judge" name="judge" value=" ' . htmlspecialchars($judge) . ' ">

                           <br>

                                    Link to Other Materials: <input class="form-control" type="text" id="other" name="other" value="' . htmlspecialchars($other) . '">


                                    <input type="hidden" name="date" id="date">
                                    ';
                                } else if (!($_SESSION["role"] == "Judge" || $_SESSION["role"] == "Referee")) {
                                    echo '<br><h6>
                                    Upload Judging Videos and Required Materials (max 600mb each):</h6>
                                    <input class="form-control" type="file" name="fileToUpload" id="fileToUpload"><br>
                                    <b>Label:</b> <select class="form-control" name="label">
                                    <option value=""></option>
                                    <option value="TEAM_POSTER">Team Poster</option>
                                    <option value="TEAM_PHOTO">Team Photograph</option>
                                    <option value="TEAM_CODE">Team Code</option>
                                    <option value="ENG_NOTEBOOK">Engineering Notebook</option>
                                    <option value="PRESENTATION_VIDEO">Team Presentation</option>
                                    <option value="INTRO_VIDEO">Team Introduction</option>
                                    <option value="MODEL_VIDEO">Model Video</option>
                                    <option value="SHOWCASE_VIDEO">Showcase Video</option>
                                    <option value="OTHER">Other</option>
                                    </select><p>
                                    Note: if your files are larger than 600mb, please use a video compressor such as <a href="https://handbrake.fr/">Handbrake</a> and/or a PDF Converter/Compressor such as <a href="https://www.adobe.com/acrobat/online/compress-pdf.html">Adobe Acrobat Online</a>.
                                        </p>';
                                    // echo "<h4>Your link to submit is <a href='" . $sublink . "'>" . $sublink . "</a></h4>";
                                }
                            } else {
                                // echo "<h4>Please submit the necessary files below:<br>";
                                // echo "<iframe src='".$sublink."/'></iframe>";
                                echo "<h4>Your link to submit Judging Videos and Required Materials is <a target='_blank' href='" . $sublink . "'>here</a>.</h4>";
                                // if (trim(file_get_contents("sublinkrbt.txt")) !== "None") {
                                // echo "<h4>When you are ready to submit Robot Game videos, click <a href='robot.php'>here</a>.</h4>";
                                // }
                                if ($_SESSION["role"] == "Judge" || $_SESSION["role"] == "Referee" || $_SESSION["role"] == "Tournament Director") echo "<h6>Your link to submit Robot Game Videos is <a target='_blank' href='" . file_get_contents("sublinkrbt.txt") . "'>here</a>.</h6>";
                            }
                        }
                        ?>
                        <br>

                        <!-- <textarea rows="20" cols="50" id="text" name="text"><?php echo htmlspecialchars($text) ?></textarea><br> -->
                        <?php
                        $useup = file_exists("../../admin/useuploader.txt");

                        // echo trim($sublink) . "HERE";
                        if (!($_SESSION["role"] == "Judge" || $_SESSION["role"] == "Referee") && file_exists("../../admin/release3.txt") && $sublink == "None") {
                            echo '<input id="teams" value="Submit" ';
                            if ($useup) echo 'onclick="upload_image();"';
                            echo ' class="btn btn-danger btn-md" type="submit"/>';
                        }

                        if ($useup) {
                            echo "
                                    <div id='progress_div' style='display:none;'>
                                    <b>Progress: </b><b id='percent'>0%</b><b> </b>
                                    <progress id='bar' value='0' max='100'> </progress>
                                    </div>
        <div id='output_image'></div>
                                    ";
                        }
                        ?>
                    </form>
                    <form action="" method="POST" id="userdelform">
                        <input type="hidden" id="userdel" name="userdel">
                    </form>


                    <script>
                        function deleteFile(user) {
                            if (confirm("Are you sure you want to delete " + user + "?")) {
                                // window.location.href="createuser.php?delete="+user; 
                                document.getElementById("userdel").value = user;
                                document.getElementById("userdelform").submit();
                            }
                        }
                    </script>
                    <?php
                    /*
                            if (file_exists("../../admin/release3.txt")) {
                                if ((is_numeric($_SESSION["role"])) || ($_SESSION["role"]=="Tournament Director")) {
                                    echo "
                                    <br><br><h5 style='margin-left:30px'>If you are submitting a \"live\" run for VOI, click <a href='robot.php'>here</a> when you want to start your 3-hour window to record and upload your videos.</h5>
                                    ";
                                } else {
                                    if (file_exists('code.txt')) echo "<h4>Robot game code is ".file_get_contents('code.txt')."</h4>";
                                    else echo "<h4>No robot game code generated</h4>";
                                }
                            }
                            */
                            if (file_exists("../../admin/useuploader.txt")) {
                                if (isset($_POST["userdel"])) {
                                    // exec("rm " . $_POST["userdel"]);
                                    unlink($_POST["userdel"]);
                                    echo "<b style='color:red'>Deleted file " . $_POST["userdel"] . ".</b><br>";
                                }
                                echo '<br><br><h3>Currently Uploaded files:</h3> <div id="curr_uploads">';
        
                                if ($handle = opendir('./uploads')) {

                                    $ct = 0;
                                    while (false !== ($entry = readdir($handle))) {
                                        if ($entry != "." && $entry != ".." && $entry != "index.html") {
                                            $ct++;
                                            if (strpos($entry, ".mov") !==false || strpos($entry, ".MOV") !==false|| strpos($entry, ".m4v") !==false|| strpos($entry, ".mp4") !==false || strpos($entry, ".MP4")!==false) echo "<a href='video.php?file=uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
                                            else if (strpos($entry, ".pdf") !==false || strpos($entry, ".PDF") !==false) echo "<a href='pdf.php?file=uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
                                            else echo "<a target='_blank' href='uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
                                            if ($_SESSION["role"] == "Tournament Director") echo " <input type='button' onclick='deleteFile(\"uploads/" . $entry . "\");' value='Delete'>";
                                            echo "<br>";
                                        }
                                    }
                                    if ($ct == 0) echo "<p>None</p>";
        
        
        
                                    closedir($handle);
                                }
                                echo "</div>";
                            }
                    ?>



                    <br>
                    <br>
                    <!-- <h3>Self-Evaluate Your Robot Game Performance:</h3> -->

                    <?php
                    $teamno = basename(dirname(__FILE__));
                    // if (file_exists("../../admin/release3.txt")) {

                    //     echo "<a href='../../scorer/indexSE.php?round=1&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/score-icon.png'>Submit Robot Game Round 1 Score</a><br />";
                    //     echo "<a href='../../scorer/indexSE.php?round=2&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/score-icon.png'>Submit Robot Game Round 2 Score</a><br />";
                    //     echo "<a href='../../scorer/indexSE.php?round=3&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/score-icon.png'>Submit Robot Game Round 3 Score</a><br />";
                    // }
                    if ($_SESSION["role"] == "Tournament Director" || $_SESSION["role"] == "Judge" || $_SESSION["role"] == "Referee") {
                        echo "<br><h3>Edit Final Scores:</h3>";

                        $teamno = basename(dirname(__FILE__));
                        // echo "<a href='../../scorer/index.php?round=1&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/score-icon.png'>Edit Robot Game Round 1 Score</a><br />";
                        // echo "<a href='../../scorer/index.php?round=2&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/score-icon.png'>Edit Robot Game Round 2 Score</a><br />";
                        // echo "<a href='../../scorer/index.php?round=3&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/score-icon.png'>Edit Robot Game Round 3 Score</a><br />";

                        echo "<a href='../../rubrics/rubric.php?round=1&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/rubric-icon.png'>Edit Rubric</a><br />";
                        // echo "<a href='../../rubrics/robot.php?round=1&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/rubric-icon.png'>Edit Robot Design Judging Rubric</a><br />";
                        // echo "<a href='../../rubrics/corevalues.php?round=1&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/rubric-icon.png'>Edit Core Values Judging Rubric</a><br />";
                    }

                    echo "<br><h3>View Released Rubrics:</h3>";
                    $teamno = basename(dirname(__FILE__));
                    // if (file_exists("../../admin/release2.txt")) {
                    //     if (file_exists("robotScores/1.txt")) {
                    //         echo "<a href='../../scorer/indexRO.php?round=1&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/score-icon.png'>View Robot Game Round 1 Score</a><br />";
                    //     }
                    //     if (file_exists("robotScores/2.txt")) {
                    //         echo "<a href='../../scorer/indexRO.php?round=2&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/score-icon.png'>View Robot Game Round 2 Score</a><br />";
                    //     }
                    //     if (file_exists("robotScores/3.txt")) {
                    //         echo "<a href='../../scorer/indexRO.php?round=3&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/score-icon.png'>View Robot Game Round 3 Score</a><br />";
                    //     }
                    // }
                    if (file_exists("../../admin/release.txt")) {
                        if (file_exists("robotScores/rb-cv.txt")) {
                            echo "<a href='../../rubrics/rubricRO.php?round=1&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/rubric-icon.png'>View Rubric</a><br />";
                        }
                        // if (file_exists("robotScores/rb-rd.txt")) {
                        //     echo "<a href='../../rubrics/robotRO.php?round=1&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/rubric-icon.png'>View Robot Design Judging Rubric</a><br />";
                        // }
                        // if (file_exists("robotScores/rb-cv.txt")) {
                        //     echo "<a href='../../rubrics/corevaluesRO.php?round=1&team=" . $teamno . "'><img style='height:50px; margin-left:30px; margin-right:4px; margin-top: 4px; margin-bottom: 4px;' src='http://tournament.virtualopeninvitational.org/images/rubric-icon.png'>View Core Values Judging Rubric</a><br />";
                        // }
                    }
                    ?>
                </body>

            </div>
            <script>
                year = (new Date()).getUTCFullYear()
                month = ((new Date()).getUTCMonth() + 1).toLocaleString('en-US', {
                    minimumIntegerDigits: 2,
                    useGrouping: false
                })
                day = ((new Date()).getUTCDate()).toLocaleString('en-US', {
                    minimumIntegerDigits: 2,
                    useGrouping: false
                })

                hours = ((new Date()).getUTCHours()).toLocaleString('en-US', {
                    minimumIntegerDigits: 2,
                    useGrouping: false
                })
                minutes = ((new Date()).getUTCMinutes()).toLocaleString('en-US', {
                    minimumIntegerDigits: 2,
                    useGrouping: false
                })
                seconds = ((new Date()).getUTCSeconds()).toLocaleString('en-US', {
                    minimumIntegerDigits: 2,
                    useGrouping: false
                })

                time = year + "-" + month + "-" + day + "_" + hours + minutes + seconds

                document.getElementById("date").value = time;
            </script>
        </section>
        <br>
        <script>
            $(function() {
                $("#footer").load("../../footer.html");
            });
        </script>
        <div id="footer"></div>
    </div>
    <script src='../../js/accordian.js'></script>

</body>