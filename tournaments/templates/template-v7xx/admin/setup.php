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
?>
<!DOCTYPE html>
<head>
  <link rel="stylesheet" type="text/css" href="../style.css">
  <link rel="stylesheet" type="text/css" href="../css/accordian.css">

  <link rel="stylesheet" href="../w3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>Setup Panel</title>

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

      <h2>Setup Panel
      </h2>
    </section><br>
    <section>
      <div class="text-body" style="font-size: 14px;">

        <!-- <i style="color: red;">* Required</i> -->

        <!--If you are using anything earlier please upgrade using the <script>
   function UrlExists(url)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
   }

document.write('<a href="/upgrade.php#'+textFileToArray('/' + window.location.href.split('/')[3] + '/tournament.txt')[0]+'">Upgrade Assistant</a><br>');

 </script>-->
        <!-- <h2>Configuration<i style="color: red;"> *</i></h2> -->
        <?php

        // configuration
        //$url = 'setup.php';
        $file = 'teams.txt';
        //echo "SEND EMAIL ".$_POST["sendemail"];

        // check if form has been submitted
        if (isset($_POST['text'])) {
          // save the text contents
          $file = str_replace("\r", "", $file);
          file_put_contents($file, trim($_POST['text']));
          file_put_contents("../backup/teams.txt", trim($_POST['text']));
          $textAr = explode("\n", $_POST['text']);
          foreach ($textAr as $line) {
            // processing here.
            $lineAr = explode(",", $line);
            $teamno = (int) explode(",", $line)[0];
            if (!file_exists("../teams/" . $teamno)) {
              exec("cp -pr ../teams/template ../teams/" . $teamno);
            } else {
              exec("cp -pr ../teams/template/* ../teams/" . $teamno . "/");
            }
            // if ($textAr[3] !== "None" || $textAr[3] !== "") {
            // file_put_contents("../teams/" . $teamno . "/sublink.txt", $lineAr[3]);
            // file_put_contents("../teams/" . $teamno . "/sublinkrbt.txt", $lineAr[4]);
            file_put_contents("../teams/" . $teamno . "/sublink.txt", "None");
            file_put_contents("../teams/" . $teamno . "/sublinkrbt.txt", "None");
            file_put_contents("../teams/" . $teamno . "/name.txt", $lineAr[1]);
            // }
            if ($_POST["sendemail"] == "on") {
              $teamuser = str_replace("\r", "", trim(explode(",", $line)[2]));
              if (!file_exists("../userdata/" . strtolower($teamuser))) {
                file_put_contents("../userdata/" . strtolower($teamuser), $teamno);
                if (strpos($_SERVER['SERVER_NAME'], "virtualopeninvitational") !== false) {
                  exec('printf "To: ' . $teamuser . '\nFrom: FLL Tutorials Tournament\nSubject: Virtual Open Invitational Tournament Invite\n\n\nWelcome to ' . $tournament . ' tournament. Your FLL tournament director has invited you as team ' . $teamno . '. Please create an account at https://tournament.virtualopeninvitational.org with your email address. You will then be able to log into the tournament from your account." | msmtp ' . $teamuser . '');
                } else {
                  exec('printf "To: ' . $teamuser . '\nFrom: FLL Tutorials Tournament\nSubject: FLLTutorials Tournament Invite\n\n\nWelcome to ' . $tournament . ' tournament. Your FLL tournament director has invited you as team ' . $teamno . '. Please create an account at https://tournament.flltutorials.com with your email address. You will then be able to log into the tournament from your account." | msmtp ' . $teamuser . '');
                }
              } else {

                $user_pass = fopen("../userdata/" . strtolower($teamuser), "r");
                $flag = 0;
                while (!feof($user_pass)) {
                  $p = trim(fgets($user_pass));
                  if ($teamno == $p) {
                    $flag = 1;
                  }
                }
                fclose($user_pass);

                if ($flag == 0) {
                  $current = file_get_contents("../userdata/" . strtolower($teamuser));
                  $current .= "\n" . $teamno;
                  file_put_contents("../userdata/" . strtolower($teamuser), $current);
                }
              }


              $teamuser = str_replace("\r", "", trim(explode(",", $line)[3]));
              if (!file_exists("../userdata/" . strtolower($teamuser))) {
                file_put_contents("../userdata/" . strtolower($teamuser), $teamno);
                if (strpos($_SERVER['SERVER_NAME'], "virtualopeninvitational") !== false) {
                  exec('printf "To: ' . $teamuser . '\nFrom: FLL Tutorials Tournament\nSubject: Virtual Open Invitational Tournament Invite\n\n\nWelcome to ' . $tournament . ' tournament. Your FLL tournament director has invited you as team ' . $teamno . '. Please create an account at https://tournament.virtualopeninvitational.org with your email address. You will then be able to log into the tournament from your account." | msmtp ' . $teamuser . '');
                } else {
                  exec('printf "To: ' . $teamuser . '\nFrom: FLL Tutorials Tournament\nSubject: FLLTutorials Tournament Invite\n\n\nWelcome to ' . $tournament . ' tournament. Your FLL tournament director has invited you as team ' . $teamno . '. Please create an account at https://tournament.flltutorials.com with your email address. You will then be able to log into the tournament from your account." | msmtp ' . $teamuser . '');
                }
              } else {

                $user_pass = fopen("../userdata/" . strtolower($teamuser), "r");
                $flag = 0;
                while (!feof($user_pass)) {
                  $p = trim(fgets($user_pass));
                  if ($teamno == $p) {
                    $flag = 1;
                  }
                }
                fclose($user_pass);

                if ($flag == 0) {
                  $current = file_get_contents("../userdata/" . strtolower($teamuser));
                  $current .= "\n" . $teamno;
                  file_put_contents("../userdata/" . strtolower($teamuser), $current);
                }
              }
            }
          }
          // redirect to form again
          //header(sprintf('Location: %s', $url));

          printf('<b style="color: red">Teams have been saved</b><br><!--<a href="">Return</a>.-->');

          echo "";
        }

        // read the textfile
        $text = file_get_contents($file);

        ?>

        <!-- HTML form -->
        <b>STEP 1: LIST OF TEAMS</b><br>
        <p>Instructions: Enter your list of teams attending this tournament. List the teams in the order you want them to appear on the scorer that the referees will use. Remember to hit the "Save" button after this step.</p>
        <br>
        <pre>Format: Team No.,Team Name,coach email,coach email 2,judging lane,robot game table</pre>
        <form action="" method="post">
          <textarea class="form-control" style="font-family:Consolas,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New, monospace;" placeholder="51,Not the Droids You Are Looking For,team@droidsrobotics.org,team@ev3lessons.com,1,1" rows="10" cols="50" id="text" name="text"><?php echo htmlspecialchars($text) ?></textarea><br>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="sendemail" checked>
            <label class="form-check-label" for="sendemail">
              Create team accounts
            </label>
          </div>
          <br>
          <input class="btn btn-danger" id="teams" value="Save Teams" type="submit" />
          <input class="btn btn-danger" type="reset" value="Cancel" />
        </form>
        <p>or.....</p><br>
        <div>
          <label for="input-file"><b>Upload CSV file with team data:</b></label><br>
          <input class="form-control" accept=".csv" type="file" id="input-file"><br><br>
          <p> File should be .csv with comma as the field delimeter. There should be no column headers. Format in Excel should be:</p>
          <pre style="font-family: monospace;overflow-x:auto;">
team no. |  team name  |    coach/team email        | coach/team email 2    |  Judging Lane |  Robot Game Table     <== Do not include this row
-----------------------------------------------------------------------------------------------------------------
1        |   sample    |    user@example.com        |  user2@example.com    |      1        |       1;3;4
51       |   droids    |    team@droidsrobotics.org |  team@ev3lessons.com  |      2        |         1
</pre>
          <!-- Note: If you want to use the built-in submission system, write None as the submission link. -->
          <!-- Primary Submission link   | Robot Game Submission link
-------------------------------------------------------
 https://drive.google.com  |  https://drive.google.com

 None                      |  https://drive.google.com -->

          <p> Export as CSV (comma delimited) to work in this system.</p>
          <br><b>  Warning: by submitting, an email invitation will be sent to all listed coach emails. To avoid this, uncheck the "Create team accounts" box BEFORE saving or selecting a file to upload.
          </b>
        </div>

        <script>
          document.getElementById('input-file')
            .addEventListener('change', getFile)

          function getFile(event) {
            const input = event.target
            if ('files' in input && input.files.length > 0) {
              placeFileContent(
                document.getElementById('text'),
                input.files[0])
              document.getElementById('teams').click()

            }
          }

          function placeFileContent(target, file) {
            readFileContent(file).then(content => {
              target.value = content
              n = 0;
              while (n != 500) {
                document.getElementById('text').value = document.getElementById('text').value.replace(',', ',');
                n = n + 1
              }
            }).catch(error => console.log(error))
          }

          function readFileContent(file) {
            const reader = new FileReader()
            return new Promise((resolve, reject) => {
              reader.onload = event => resolve(event.target.result)
              reader.onerror = error => reject(error)
              reader.readAsText(file)
            })
          }
        </script>
        <br><br>
        <b>Enable Team Submissions</b><br>
        <p> You can enable the team portal to allow required competition submissions. Teams will be able to create an account using the email listed above to access this competition's submission portal. Teams will be able to submit a links to a Judging Video, 3 Robot Game Videos, and Other Materials. They will also have access to a self-evaluation robot game scorer. Note: You cannot disable this once enabled.<br></p>
        <?php

        // configuration
        //$url = 'setup.php';
        $fileREL3 = 'release3.txt';

        // check if form has been submitted
        if (isset($_POST['release3'])) {
          // save the text contents
          $fileR3 = str_replace("\r", "", $fileREL3);
          file_put_contents($fileR3, "null");
          echo "<b style='color: red'>Enabled submissions<br></b>";
        }

        if (file_exists('release3.txt')) {
          echo "<b style='color: red'>Enabled submissions</b>";
        }

        // read the textfile
        $text = file_get_contents($file);

        ?>
        <br>
        <form action="" method="post">
          <input type="hidden" name="release3" id="release3">
          <input class="btn btn-danger" id="teams3" value="Enable Submissions" type="submit" />
        </form>

        <?php

        // configuration
        //$url = 'setup.php';
        $fileREL3 = 'release3.txt';

        // check if form has been submitted
        if (isset($_POST['releaseD3'])) {
          // save the text contents
          unlink($fileREL3);
          echo "<b style='color: red'>Disabled submissions<br></b>";
        }
        // read the textfile

        ?>
        <br>
        <form action="" method="post">
          <input type="hidden" name="releaseD3" id="releaseD3">
          <input class="btn btn-danger" id="teamsD3" value="Disable Submissions" type="submit" />
        </form>


        <br><br>

        <b>Release Rubrics/Scores to Teams</b><br>
        <p> Instructions: This cannot be undone. Once you release rubrics/scores, teams will be able to view them by logging into this tournament. Each team must have created an account using the email you listed for them above.<br></p>
        <?php

        // configuration
        //$url = 'setup.php';
        $fileREL = 'release.txt';

        // check if form has been submitted
        if (isset($_POST['release'])) {
          // save the text contents
          $fileR = str_replace("\r", "", $fileREL);
          file_put_contents($fileR, "null");
          echo "<b style='color: red'>Released Rubrics<br></b>";
        }

        if (file_exists('release.txt')) {
          echo "<b style='color: red'>Released Rubrics</b>";
        }

        // read the textfile
        $text = file_get_contents($file);

        ?>
        <form action="" method="post">
          <input type="hidden" name="release" id="release">
          <input class="btn btn-danger" id="teams" value="Release Rubrics" type="submit" />
        </form>
        <br>
        <?php

        // configuration
        //$url = 'setup.php';
        $fileREL2 = 'release2.txt';

        // check if form has been submitted
        if (isset($_POST['release2'])) {
          // save the text contents
          $fileR = str_replace("\r", "", $fileREL2);
          file_put_contents($fileR, "null");
          echo "<b style='color: red'>Released Scores<br></b>";
        }

        if (file_exists('release2.txt')) {
          echo "<b style='color: red'>Released Scores</b>";
        }

        // read the textfile
        $text = file_get_contents($file);

        ?>
        <form action="" method="post">
          <input type="hidden" name="release2" id="release2">
          <input class="btn btn-danger" id="teams2" value="Release Robot Scores" type="submit" />
        </form>


        <br>
        <br>


        <br><b>STEP 2 (OPTIONAL): SETUP ACCOUNTS FOR VOLUNTEERS & MANAGE USERS</b><br>
        <p> You can have an alternate user(s) for the judges and referees. Use the <button class="btn btn-danger" onclick="window.location.href = 'createuser.php?data=' + window.location.href.split('/')[3]">User Manager</button> to add user(s) or manage existing ones.</p>
        <!-- <br>
        <br> -->
        <br><b>STEP 3 (OPTIONAL): GENERATE SCHEDULE</b><br>
        <p>Use the <a href="scheduler.php" class="btn btn-danger">Scheduler</a> to generate your event's schedule.</p>
        <br>
        <br>
        <b>STEP 4 (OPTIONAL): VIRTUAL TEAM PITS</b><br>
        <p>Instructions: Enter the following data</p>
        <br>
        <pre>Format: Team No.,Team Name,Team Image,Image Map</pre>
        <?php
        if (isset($_POST["pitinfo"])) {
          file_put_contents("pitinfo.txt", trim($_POST["pitinfo"]));
          echo "<b style='color:red!important'>Saved</b><br>";
        }
        $pitinfo = file_get_contents("pitinfo.txt");
        ?>
        <form action="" method="post">
          <textarea class="form-control" style="font-family:Consolas,Monaco,Lucida Console,Liberation Mono,DejaVu Sans Mono,Bitstream Vera Sans Mono,Courier New, monospace;" placeholder="51,Not the Droids You Are Looking For,http://example.com/image.jpg,<area ...>" rows="10" cols="50" id="pitinfo" name="pitinfo"><?php echo htmlspecialchars($pitinfo) ?></textarea><br>
          <br>
          <input class="btn btn-danger" id="savepits" value="Save" type="submit" />
          <input class="btn btn-danger" type="reset" value="Cancel" />
        </form>
        <!-- <p>or.....</p><br> -->
        <div>
          <!-- <label for="input-file2"><b>Upload CSV file with data:</b></label><br>
          <input class="form-control" accept=".csv" type="file" id="input-file2"><br><br> -->
          <p> Data file should be .csv with comma as the field delimeter. There should be no column headers. Format in Excel should be:</p>
          <pre style="font-family: monospace;overflow-x:auto;">
team no. |  team name  |    Image URL                     | Image Map       |    <== Do not include this row
-----------------------------------------------------------------------------
1        |   sample    |    http://example.com/image.jpg  |  < area ....>    |  
</pre>

          <!-- Note: If you want to use the built-in submission system, write None as the submission link. -->
          <!-- Primary Submission link   | Robot Game Submission link
-------------------------------------------------------
 https://drive.google.com  |  https://drive.google.com

 None                      |  https://drive.google.com -->

          <p> Export as CSV (comma delimited) and copy/paste the CSV contents into the above textbox. Remember to open the CSV in a text editor (e.g. Notepad) not Excel to copy.</p>
        </div>

        <script>
          document.getElementById('input-file2')
            .addEventListener('change', getFile2)

          function getFile2(event) {
            const input = event.target
            if ('files' in input && input.files.length > 0) {
              placeFileContent(
                document.getElementById('pitinfo'),
                input.files[0])
              document.getElementById('savepits').click()

            }
          }
        </script>
        <?php
        if (isset($_POST["tempcode"])) {
          file_put_contents("../userdata/accessCode.txt", trim($_POST["tempcode"]));
          if ($_POST["tempcode"]=="") unlink("../userdata/accessCode.txt");
          echo "<b style='color:red!important'>Saved</b><br>";

        }
        $tempcode = file_get_contents("../userdata/accessCode.txt");
        ?>
        <form action="" method="POST">
          <b>Access Code for Pits and Schedule (leave blank for public)</b>
          <input type="text" name="tempcode" class="form-control" value="<?php echo $tempcode; ?>">
          <input class="btn btn-danger" value="Save" type="submit" />
        </form>

        <!-- <br><br><br><b>STEP 4: RETURN TO MAIN PAGE</b><br>
        <p> Now that you have filled in your teams and number of rounds, your referees are ready to score! <br><button onclick="window.location.href = '../'">Back to main page</button></p> -->
        <br>
        <br><b>
          Tournament backup link:
          <?php
          if (file_exists("../backup/dropbox.txt")) echo "<a href='" . file_get_contents("../backup/dropbox.txt") . "'>" . file_get_contents("../backup/dropbox.txt") . "</a>";
          else echo "<a href='../backup.php'>../backup/</a>";
          ?></b>
        <br>
        <br><b style='font-size:16px;color:red;'>
          <?php
          $latest = trim(file_get_contents("../../template/version.txt"));
          $current = trim(file_get_contents("../version.txt"));

          // echo intval($latest) ."<br>";
          // echo intval($current) ."<br>";

          echo "You are running tournament scorer v" . $current . ". The latest version is v" . $latest . ".<br>";
          ?>
          To upgrade, click <a href='upgrade.php'>here</a>.</b>
        <!--
<br><br><br><br>
<br><b>DELETE TOURNAMENT</b><br>
<button onclick="window.location.href = '/delete.php?data=' + window.location.href.split('/')[3]">Delete This Tournament</button>
-->
      </div>

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