<!DOCTYPE html>

<html>
<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
$myfile = fopen('../tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
$tournament = trim(fgets($myfile));
fclose($myfile);

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"] !== $tournament) {
    header("location: ../login.php?auth=" . $_SERVER['REQUEST_URI']);
    exit;
}

if ($_SESSION["role"] !== "Tournament Director") {
    header("location: ../login.php?auth=denied");
    exit;
}


if (isset($_POST["schedulePublish"])) {
    file_put_contents("schedule.html", $_POST["schedulePublish"]);
}
if (isset($_POST["updateTeams"])) {
    file_put_contents("teams.txt", $_POST["updateTeams"]);
}
if (isset($_POST["scheduleContent"])) {
    file_put_contents("schedule_save.html", $_POST["scheduleContent"]);
    echo "<script>alert('Saved')</script>";
}
if (isset($_POST["custom"])) {
    file_put_contents("schedule_save.html", $_POST["custom"]);
    file_put_contents("schedule.html", $_POST["custom"]);
    echo "<script>alert('Saved')</script>";
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Scheduler</title>
    <!-- Bootstrap core CSS -->
    <!-- Bootstrap theme -->
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../css/accordian.css">

    <link rel="stylesheet" href="../w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="scheduler/scheduler.css" rel="stylesheet">

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

            <h2>Scheduler
            </h2>
        </section><br>
        <section>
            <div class="text-body" style="font-size: 14px;">

                <!-- Fixed navbar -->
                <nav class="navbar navbar-inverse navbar-fixed-top">
                    <div class="container">
                        <div class="navbar-header">
                            <ul class="tab">
                                <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Teams')" id="defaultOpen">Teams</a></li>
                                <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Judging')">Judging</a></li>
                                <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Matches')">Matches</a></li>
                                <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Breaks')">Breaks</a></li>
                                <!-- <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Logos')">Logos</a></li> -->
                            </ul>
                        </div>
                    </div>
                </nav>
                <textarea style="display:none;" id="teamconfig"><?php echo file_get_contents("teams.txt"); ?></textarea>
                <!-- Team parameters -->
                <div id="Teams" class="tabcontent">
                    <h3>Teams</h3>
                    <table>
                        <tr>
                            <td><textarea id="teamNumBox" readonly> <?php
                                                                    $ct = 0;
                                                                    if ($file = fopen("teams.txt", "r")) {
                                                                        while (!feof($file)) {
                                                                            $ct++;
                                                                            $line = fgets($file);
                                                                            echo explode(",", $line)[0] . "\n";
                                                                            // echo explode(",", $line)[1];
                                                                            # do same stuff with the $line
                                                                        }
                                                                        fclose($file);
                                                                    }
                                                                    ?></textarea></td>
                            <td>
                                <textarea id="teamNameBox" readonly> <?php
                                                                        if ($file = fopen("teams.txt", "r")) {
                                                                            while (!feof($file)) {
                                                                                $line = fgets($file);
                                                                                // echo explode(",", $line)[0];
                                                                                echo explode(",", $line)[1] . "\n";
                                                                                # do same stuff with the $line
                                                                            }
                                                                            fclose($file);
                                                                        }
                                                                        ?></textarea>
                            </td>
                        </tr>
                        <tr>




                            <td>Number of teams:&nbsp;</td>
                            <td><input type=number readonly id="nTeams" value="<?php echo $ct; ?>" min=1 max=999></td>
                        </tr>
                        <tr>
                            <td>Min. travel (mins):</td>
                            <td><input type=number id="minTravel" value=10 min=1 max=999></td>
                        </tr>
                        <tr>

                            <td colspan=2>

                                <!-- <button class="btn btn-primary" type="button" class="btn" onclick="loadTeamModal()" data-toggle="modal" data-target="#teamModal">Edit team names</button> -->
                            </td>
                        </tr>
                    </table>


                </div>

                <!-- Team names Modal -->
                <div id="teamModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Team Names</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="saveModal()" class="btn btn-default" data-dismiss="modal">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Session parameters -->
                <div id="Judging" class="tabcontent">
                    <!-- <h3>Judging</h3> -->
                    <!-- <table class=roundtable>
                        <tr>
                            <td colspan=2>
                                <h3>All</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>Start time:</td>
                            <td><input id="judgeAStart" type=time value="10:00" step="900"></td>
                        </tr>
                        <tr>
                            <td>Must be done by</td>
                            <td><input id="judgeAEnd" type=time value="14:00" step="900"></td>
                        </tr>
                        <tr>
                            <td>Judging length (min):</td>
                            <td><input id="jALength" type=number min=0 max=1000 value=10></td>
                        </tr>
                        <tr>
                            <td>Buffer time (min):</td>
                            <td><input id="jABuffer" type=number min=0 max=1000 value=5></td>
                        </tr>
                        <tr>
                            <td>Number of judges:</td>
                            <td><input id="nAJudges" type=number min=0 max=1000 value=3></td>
                        </tr>
                        <tr>
                            <td colspan=2><button class="btn btn-info" onclick="judgesApplyAll()">Apply to all</button></td>
                        </tr>

                    </table> -->
                    <table class=roundtable>
                        <tr>
                            <td colspan=2>
                                <h3>Judging</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>Start time:</td>
                            <td><input id="judge1Start" type=time value="10:00" step="900"></td>
                        </tr>
                        <tr>
                            <td>Must be done by</td>
                            <td><input id="judge1End" type=time value="14:00" step="900"></td>
                        </tr>
                        <tr>
                            <td>Judging length (min):</td>
                            <td><input id="j1Length" type=number min=0 max=1000 value=30></td>
                        </tr>
                        <tr>
                            <td>Buffer time (min):</td>
                            <td><input id="j1Buffer" type=number min=0 max=1000 value=5></td>
                        </tr>
                        <tr>
                            <td>Number of judges:</td>
                            <td><input id="n1Judges" type=number min=0 max=1000 value=3></td>
                        </tr>
                        <tr>
                            <td colspan=2><button class="btn btn-primary" type="button" class="btn" onclick="loadLocationModal(1)" data-toggle="modal" data-target="#teamModal">Edit location names</button></td>
                        </tr>
                    </table>
                    <!-- <table class=roundtable>
        <tr><td colspan=2><h3>Core Values</h3></td></tr>
        <tr><td>Start time:</td><td><input id="judge2Start" type=time value="10:00" step="900"></td></tr>
        <tr><td>Must be done by</td><td><input id="judge2End" type=time value="14:00" step="900"></td></tr>
        <tr><td>Judging length (min):</td><td><input id="j2Length" type=number min=0 max=1000 value=10></td></tr>
        <tr><td>Buffer time (min):</td><td><input id="j2Buffer" type=number min=0 max=1000 value=5></td></tr>
        <tr><td>Number of judges:</td><td><input id="n2Judges" type=number min=0 max=1000 value=3></td></tr>
        <tr><td colspan=2><button type="button" class="btn" onclick="loadLocationModal(2)" data-toggle="modal" data-target="#teamModal">Edit location names</button></td></tr>
    </table>
    <table class=roundtable>
        <tr><td colspan=2><h3>Research Project</h3></td></tr>
        <tr><td>Start time:</td><td><input id="judge3Start" type=time value="10:00" step="900"></td></tr>
        <tr><td>Must be done by</td><td><input id="judge3End" type=time value="14:00" step="900"></td></tr>
        <tr><td>Judging length (min):</td><td><input id="j3Length" type=number min=0 max=1000 value=10></td></tr>
        <tr><td>Buffer time (min):</td><td><input id="j3Buffer" type=number min=0 max=1000 value=5></td></tr>
        <tr><td>Number of judges:</td><td><input id="n3Judges" type=number min=0 max=1000 value=3></td></tr>
        <tr><td colspan=2><button type="button" class="btn" onclick="loadLocationModal(3)" data-toggle="modal" data-target="#teamModal">Edit location names</button></td></tr>
    </table> -->
                </div>

                <div id="Matches" class="tabcontent">
                    <h3>Matches (forced serial)</h3>
                    <table class="roundTable">
                        <tr>
                            <td colspan=2>
                                <h3>All</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>Start time:</td>
                            <td><input id="matchAStart" type=time value="10:00" step="900"></td>
                        </tr>
                        <tr>
                            <td>Must be done by</td>
                            <td><input id="matchAEnd" type=time value="16:30" step="900"></td>
                        </tr>
                        <tr>
                            <td>Match length (min):</td>
                            <td><input id="mALength" type=number min=0 max=1000 value=5></td>
                        </tr>
                        <tr>
                            <td>Match buffer (min):</td>
                            <td><input id="mABuffer" type=number min=0 max=1000 value=5></td>
                        </tr>
                        <tr>
                            <td>Tables:</td>
                            <td><input id="nATables" type=number min=0 max=1000 value=4 step=2></td>
                        </tr>
                        <tr>
                            <td>Sim. Teams:</td>
                            <td><input id="nASims" type=number min=0 max=1000 value=2 step=2></td>
                        </tr>
                        <tr>
                            <td colspan=2><button class="btn btn-info" onclick="matchesApplyAll()">Apply to all</button></td>
                        </tr>
                    </table>
                    <table class="roundTable">
                        <tr>
                            <td colspan=2>
                                <h3>Round 1</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>Start time:</td>
                            <td><input id="match1Start" type=time value="10:00" step="900"></td>
                        </tr>
                        <tr>
                            <td>Must be done by</td>
                            <td><input id="match1End" type=time value="16:30" step="900"></td>
                        </tr>
                        <tr>
                            <td>Match length (min):</td>
                            <td><input id="m1Length" type=number min=0 max=1000 value=5></td>
                        </tr>
                        <tr>
                            <td>Match buffer (min):</td>
                            <td><input id="m1Buffer" type=number min=0 max=1000 value=5></td>
                        </tr>
                        <tr>
                            <td>Tables:</td>
                            <td><input id="n1Tables" type=number min=0 max=1000 value=4 step=2></td>
                        </tr>
                        <tr>
                            <td>Sim. Teams:</td>
                            <td><input id="n1Sims" type=number min=0 max=1000 value=2 step=2></td>
                        </tr>
                        <tr>
                            <td colspan=2><button type="button" class="btn btn-primary" onclick="loadLocationModal(4)" data-toggle="modal" data-target="#teamModal">Edit location names</button></td>
                        </tr>
                    </table>
                    <table class="roundTable">
                        <tr>
                            <td colspan=2>
                                <h3>Round 2</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>Start time:</td>
                            <td><input id="match2Start" type=time value="10:00" step="900"></td>
                        </tr>
                        <tr>
                            <td>Must be done by</td>
                            <td><input id="match2End" type=time value="16:30" step="900"></td>
                        </tr>
                        <tr>
                            <td>Match length (min):</td>
                            <td><input id="m2Length" type=number min=0 max=1000 value=4></td>
                        </tr>
                        <tr>
                            <td>Match buffer (min):</td>
                            <td><input id="m2Buffer" type=number min=0 max=1000 value=3></td>
                        </tr>
                        <tr>
                            <td>Tables:</td>
                            <td><input id="n2Tables" type=number min=0 max=1000 value=4 step=2></td>
                        </tr>
                        <tr>
                            <td>Sim. Teams:</td>
                            <td><input id="n2Sims" type=number min=0 max=1000 value=2 step=2></td>
                        </tr>
                        <tr>
                            <td colspan=2><button type="button" class="btn  btn-primary" onclick="loadLocationModal(5)" data-toggle="modal" data-target="#teamModal">Edit location names</button></td>
                        </tr>
                    </table>
                    <table class="roundTable">
                        <tr>
                            <td colspan=2>
                                <h3>Round 3</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>Start time:</td>
                            <td><input id="match3Start" type=time value="10:00" step="900"></td>
                        </tr>
                        <tr>
                            <td>Must be done by</td>
                            <td><input id="match3End" type=time value="17:00" step="900"></td>
                        </tr>
                        <tr>
                            <td>Match length (min):</td>
                            <td><input id="m3Length" type=number min=0 max=1000 value=4></td>
                        </tr>
                        <tr>
                            <td>Match buffer (min):</td>
                            <td><input id="m3Buffer" type=number min=0 max=1000 value=3></td>
                        </tr>
                        <tr>
                            <td>Tables:</td>
                            <td><input id="n3Tables" type=number min=0 max=1000 value=4 step=2></td>
                        </tr>
                        <tr>
                            <td>Sim. Teams:</td>
                            <td><input id="n3Sims" type=number min=0 max=1000 value=2 step=2></td>
                        </tr>
                        <tr>
                            <td colspan=2><button type="button" class="btn  btn-primary" onclick="loadLocationModal(6)" data-toggle="modal" data-target="#teamModal">Edit location names</button></td>
                        </tr>
                    </table>

                </div>

                <div id="Breaks" class="tabcontent">
                    <h3>Breaks</h3>
                    <table class='break'>
                        <tr>
                            <td style='padding:5px'><input id="breakname" type="text" value="Lunch">&nbsp;</td>
                            <td style='padding:5px'>Start time:&nbsp;</td>
                            <td style='padding:5px'><input id="breakStart" type=time value="12:00"></td>
                            <td style='padding:5px'>End time:&nbsp;</td>
                            <td style='padding:5px'><input id="breakEnd" type=time value="13:00"></td>
                        </tr>
                    </table>
                </div>
                <div id="Logos" class="tabcontent">
                    <h3>Logos</h3>
                    <table>
                        <tr>
                            <td style='padding:5px'><img id="majrimg" src="mqlogo.png" height="200" alt="Major sponsor">&nbsp;</td>
                            <td style='padding:5px'>
                                <label class="btn btn-default btn-file"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span><input id="majrfile" type="file" onchange="majorLogo()" style="display:none"></label>&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td style='padding:5px'><img id="gameimg" src="aalogo.jpg" height="200" alt="Game logo">&nbsp;</td>

                            <td style='padding:5px'>
                                <label class="btn btn-default btn-file"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span><input id="gamefile" type="file" onchange="gameLogo()" style="display:none"></label>&nbsp;
                            </td>
                        </tr>
                    </table>
                </div>


                <div class="container">
                    <div class="starter-template">
                        <div id="title" class="title"><?php echo $_SESSION["tournament"]; ?></div>
                        <!-- <button onclick="changeTitle()" class="btn-link">Change</button> -->

                        <h1>Schedule Generation</h1>
                        <div class="radio">
                            <label><input type="radio" value="random" class="form-control" name="method" checked>Random</label>
                            <!-- </div>
                        <div class="radio"> -->
                            <label><input type="radio" value="block" class="form-control" name="method">Block</label>
                        </div>
                        <p>Block scheduling is generally more likely to succeed and more consistent, but is less random.</p>
                        <br>
                        <br>
                        <button id="genBtn" class="btn btn-primary" onclick="generate()">Generate</button>
                        <p class="lead" id="words">Press the above button to attempt to generate a schedule using the given parameters.</p>
                        <button id="saveBtn" onclick="saveSchedule()" class="btn btn-success" style="display:inline">Save Schedule</button>

                        <button id="pdfBtn" onclick="pubSchedule()" class="btn btn-success" style="display:inline">Publish Schedule</button>
                        <!-- <div style="display:none;"> -->
                        <button id="pdfBtnD" onclick="updateTeams()" class="btn btn-success" style="display:inline">Update Team Configuration</button><br>
                        <?php
                        if (file_exists("schedule.html")) echo "<b style='color:red!important'>Schedule published under 'Schedule' tab</b>";
                        ?>
                        <!-- </div> -->
                        <form id="scheduleSave" action="" method="POST">
                            <input type="hidden" id="scheduleContent" name="scheduleContent">
                        </form>
                        <form id="schedulePub" action="" method="POST">
                            <input type="hidden" id="scheduleContent2" name="scheduleContent">
                            <input type="hidden" id="schedulePublish" name="schedulePublish">
                        </form>
                        <form id="scheduleUpdate" action="" method="POST">
                            <input type="hidden" id="scheduleContent3" name="scheduleContent">
                            <input type="hidden" id="schedulePublish2" name="schedulePublish">
                            <input type="hidden" id="updateTeams" name="updateTeams">
                        </form>
                        <script>
                            function saveSchedule() {
                                document.getElementById("scheduleContent").value = String(document.getElementById("results").innerHTML)
                                document.getElementById("scheduleSave").submit();
                            }

                            function pubSchedule() {
                                document.getElementById("scheduleContent2").value = String(document.getElementById("results").innerHTML)
                                document.getElementById("schedulePublish").value = String(document.getElementById("results").innerHTML)
                                document.getElementById("schedulePub").submit();
                            }

                            function updateTeams() {
                                rows = document.getElementById("indivSchedule").children[0].rows;
                                dict = {}
                                for (i = 1; i < rows.length; i++) {
                                    cols = document.getElementById("indivSchedule").children[0].rows[i].cells
                                    dict[cols[0].innerHTML] = [cols[4].innerHTML, cols[7].innerHTML, cols[10].innerHTML, cols[13].innerHTML]
                                }
                                console.log(dict)


                                document.getElementById("scheduleContent3").value = String(document.getElementById("results").innerHTML)
                                document.getElementById("schedulePublish2").value = String(document.getElementById("results").innerHTML)


                                teamconfig = document.getElementById("teamconfig").value.split("\n");
                                for (i = 0; i < teamconfig.length; i++) {
                                    teamconfig[i] = teamconfig[i].split(',');
                                    teamconfig[i][4] = dict[teamconfig[i][0]][0].split("Judging ")[1]
                                    teamconfig[i][5] = dict[teamconfig[i][0]][1].split("Table ")[1] + ";" + dict[teamconfig[i][0]][2].split("Table ")[1] + ";" + dict[teamconfig[i][0]][3].split("Table ")[1]
                                }

                                document.getElementById("updateTeams").value = teamconfig.join("\n");
                                document.getElementById("scheduleUpdate").submit();

                            }
                        </script>

                        <!-- <button id="pdfBtn" onclick="makePDFs(false)" class="btn btn-success" style="display:none">Make PDFs</button>
                        <button id="pdfBtnD" onclick="makePDFs(true)" class="btn btn-success" style="display:none">Download PDFs</button> -->
                    </div>
                </div>

                <div class="container">
                    <div class="starter-template" id="results"><?php echo file_get_contents("schedule_save.html"); ?></div>
                </div>
            </div>
            Scheduler modified from FIRST Australia's Scheduler.
            <br><br><br>
            <script src="tinymce/tinymce.min.js"></script>

            <h3>Custom Schedule</h3>
            <form action="" method="POST">
                <textarea id="myTextarea" name="custom" class="form-control" rows=20><?php echo file_get_contents("schedule_save.html"); ?></textarea>
                <input type="submit" value="Save/Publish" class="btn btn-primary">
                <script>
                    tinymce.init({
                        selector: '#myTextarea',
                        plugins: 'table | code',
                        menubar: 'file | edit | view | format | table | tools',
                        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol | code'
                    });
                </script>
            </form>
        </section>
        <br>
        <script>
            $(function() {
                $("#footer").load("../footer.html");
            });
        </script>
        <div id="footer"></div>
    </div>
    <script src='js/accordian.js'></script>

</body>
<style>
    .btn-info {
        display: none !important;
    }
</style>
<script src="scheduler/tabs.js" type="text/javascript"></script>
<script src="scheduler/pdf.js" type="text/javascript"></script>
<script src="scheduler/generator.js" type="text/javascript"></script>
<script src="scheduler/scheduler.js" type="text/javascript"></script>

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