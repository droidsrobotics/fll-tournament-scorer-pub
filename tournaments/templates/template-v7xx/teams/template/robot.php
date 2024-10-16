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

if (!($_SESSION["role"] == "Tournament Director" || $_SESSION["role"] == "Referee" || $_SESSION["role"] == basename(dirname(__FILE__)))) {
    // header("location: ../");
    header("location: ../../login.php?auth=denied");

    exit;
}
date_default_timezone_set("UTC");



$override = false;
if (isset($_FILES["fileToUpload"])) {
    $override = true;

    date_default_timezone_set("UTC");
    $date =  date("Y-m-d-") . date("His");
    $target_dir = "uploads/";
    $target_file = $target_dir . $date . "_" . $_POST["label"] . "_" . basename($_FILES["fileToUpload"]["name"]);
    $target_file = str_replace("#","_", $target_file);
    $target_file = str_replace("?","_", $target_file);
    $bkp_file = '../../backup/submissions/team-' . basename(dirname(__FILE__)) . '-file-' . $date . "_" . $_POST["label"] . "_"  . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    // if (isset($_POST["submit"])) {
    //     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    //     if ($check !== false) {
    //         echo "File is an image - " . $check["mime"] . ".";
    //         $uploadOk = 1;
    //     } else {
    //         echo "File is not an image.";
    //         $uploadOk = 0;
    //     }
    // }

    // Check if file already exists
    // if (file_exists($target_file)) {
    //     echo "Sorry, file already exists.";
    //     $uploadOk = 0;
    // }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 1500000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    // if (
    //     $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    //     && $imageFileType != "gif"
    // ) {
    //     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //     $uploadOk = 0;
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
                // if (strpos($entry, ".mov") !==false || strpos($entry, ".MOV") !==false|| strpos($entry, ".m4v") !==false|| strpos($entry, ".mp4") !==false || strpos($entry, ".MP4")!==false) echo "<a href='video.php?file=uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
                // else if (strpos($entry, ".pdf") !==false || strpos($entry, ".PDF") !==false) echo "<a href='pdf.php?file=uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
                echo "<a target='_blank' href='preview.php?file=uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
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
    <title>Robot Game</title>
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

            <h2>Robot Game Submissions (Team No. <?php echo basename(dirname(__FILE__)); ?>)
            </h2>
            <?php
            echo '<b style="font-size: 100%;"><text>Team Name</text>: ';
                    echo trim(file_get_contents("name.txt"));
                    echo "</b><br>";
                    ?>

        </section><br>
        <section>
            <div class="text-body" style="font-size: 14px;">

                <!-- <a href="../"><img src="http://archive.ev3lessons.com/arrow.jpg"></a> -->
                <!-- <h1>Team Management</h1> -->

                <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> -->

                <body>


                    <p>For the robot game, you will need to generate a code that will be valid for 3 hours from your start time. In your video, you must show this code written on a piece of paper. All videos are timestamped so you must have submitted within the allocated 3 hours. After you record, please self-evaluate your robot runs using the links in the <a href='index.php'>Team Dashboard</a>. If you encounter technical difficulties, please contact your tournament director.</p>
                    <?php

                    if (isset($_POST["generate"])) {
                        // echo "hi";
                        $dateStart =  date("Y-m-d H:i:s") . " GMT";
                        $dateEnd =  date("Y-m-d H:i:s", strtotime('+3 hours')) . " GMT";
                        $dateNowComp =  date("YmdHis");
                        $dateEndComp =  date("YmdHis", strtotime('+3 hours'));
                        file_put_contents("startrobot.txt", $dateStart . "\n" . $dateNowComp);
                        file_put_contents("endrobot.txt", $dateEnd . "\n" . $dateEndComp);
                        $code = rand(100000, 999999);
                        file_put_contents("code.txt", $code);

                        // echo $dateStart . "<br>";
                        // echo $dateEnd . "<br>";
                        // echo $dateNowComp . "<br>";
                        // echo $dateEndComp . "<br>";
                    }
                    if (!file_exists("code.txt")) {
                        echo ' <p>No code has been generated yet.</p>
                            <form action="" method="POST">
                            <input type="hidden" value="generate" name="generate">
                            <input type="submit" value="Generate Code" class="btn btn-danger btn-lg">
                            </form>
                            <script>endtime=-1</script>
                            ';
                    } else {
                        $code = trim(file_get_contents("code.txt"));
                        echo "<b>Your robot game code is " . $code . ".<br>";
                        $file1 = fopen("startrobot.txt", "r");
                        echo "Your allocated time began at " . fgets($file1);
                        $file2 = fopen("endrobot.txt", "r");
                        echo "and will end at " . fgets($file2) . ".</b>";
                        $start = intval(fgets($file1), 10);
                        $end = intval(fgets($file2), 10);
                        $dateNowComp =  intval(date("YmdHis"), 10);
                        $remtime =  $end - $dateNowComp;
                        // echo $remtime;
                        echo "<script>endtime=" . $end . "</script>";
                        if ($remtime < 0) echo "<br><b style='color:red'>Time to submit has ended.</b><script>endtime=-1</script>";
                        else if ((!isset($_POST["submitcode"]) ||  $_POST["submitcode"] !== $code) && !$override) {
                            echo '<br><br><h6>When you are ready to upload, enter your robot game code listed above:</h6>
                            <form action="" method="POST">
                            <input class="form-control" type="number" value="' . $_POST["submitcode"] . '" name="submitcode">
                            <input type="submit" value="Confirm" class="btn btn-danger btn-lg">
                            </form>
                            ';
                            if (isset($_POST["submitcode"]) && $_POST["submitcode"] !== $code) {
                                echo "<b style='color:red'>Error: Code is incorrect.</b><br>";
                            }
                        } else {
                            $link = trim(file_get_contents("sublinkrbt.txt"));
                            if (!file_exists("../../admin/useuploader.txt")) {
                                echo "<h4><br>Please upload your Robot Game videos at <a target='_blank' href='" . $link . "'>here</a>.</h4>";
                            } else {
                                echo '
                                <form action="" id="myForm" name="frmupload" method="POST" enctype="multipart/form-data"><br><br>
                                <h4>Select Robot Game Videos to upload (max 1GB each):</h4>
                                <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
                                Label: <select class="form-control" name="label">
                                <!--<option value="RG_VERIFIED_VIDEO"></option>-->
                                <option value="RG1_VERIFIED_VIDEO">Robot Game Round 1 Video</option>
                                <option value="RG2_VERIFIED_VIDEO">Robot Game Round 2 Video</option>
                                <option value="RG3_VERIFIED_VIDEO">Robot Game Round 3 Video</option>
                                </select>
                                Note: if your files are larger than 1GB, please use a video transcoder such as <a href="https://handbrake.fr/">Handbrake</a>.<br>

                                ';
                                $useup = file_exists("../../admin/useuploader.txt");

                                if (!($_SESSION["role"] == "Judge" || $_SESSION["role"] == "Referee") && file_exists("../../admin/release3.txt") && $link == "None") {
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
                                echo '</form>';
                            }
                        }
                    }

                    ?><p><br>
                        <b id="date"></b>
                        <script>
                            function currTime() {
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

                                time = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds
                                timeComp = parseInt(year + month + day + hours + minutes + seconds);
                                if (endtime != -1 && endtime - timeComp < 0) {
                                    // console.log("time up")
                                    document.getElementById("date").innerHTML = "<b style='color:red'>Time to submit has ended.</b><br>The current time is " + time + " GMT.";
                                } else document.getElementById("date").innerHTML = "The current time is " + time + " GMT.";

                                // document.getElementById("date").innerHTML = time + " GMT";
                                console.log(timeComp);
                            }
                            setInterval(currTime, 1000);
                        </script>
                        <?php
                        if (file_exists("../../admin/useuploader.txt")) {
                            echo '<br><br><h4>Currently Uploaded files:</h4><div id="curr_uploads">';

                            if ($handle = opendir('./uploads')) {

                                $ct = 0;
                                while (false !== ($entry = readdir($handle))) {
                                    if ($entry != "." && $entry != ".." && $entry != "index.html") {
                                        $ct++;
                                        // if (strpos($entry, ".mov") !==false || strpos($entry, ".MOV") !==false|| strpos($entry, ".m4v") !==false|| strpos($entry, ".mp4") !==false || strpos($entry, ".MP4")!==false) echo "<a href='video.php?file=uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
                                        // else if (strpos($entry, ".pdf") !==false || strpos($entry, ".PDF") !==false) echo "<a href='pdf.php?file=uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
                                        echo "<a target='_blank' href='preview.php?file=uploads/" . $entry . "'><img style='background-color:white;margin-left:30px' width='50' src='../file.png'>$entry</a>";
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
    <script src='../../js/accordian.js'></script>

</body>
