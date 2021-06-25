<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
$myfile = fopen('tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
$tournament = trim(fgets($myfile));
fclose($myfile);

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"] !== $tournament) {
    header("location: login.php?auth=" . $_SERVER['REQUEST_URI']);
    exit;
}

if ($_SESSION["role"] !== "Tournament Director") {
    header("location: login.php?auth=denied");
    exit;
}
?>
<style>
    h1 {
        color: red;
        font-family: verdana;
        font-size: 200%;
    }

    b {
        color: green;
        font-family: arial;
        font-size: 100%
    }

    p {
        color: brown;
        font-family: arial;
        font-size: 110%
    }
</style>

<a href="admin/setup.php"><img src="http://archive.ev3lessons.com/web/EV3lessons-EV3Trainer-v1/advanced/back_arrow.jpg"></a>
<h1>Backup Files:</h1>
<p>
    <script>
        function download(data, filename, type) {
            var file = new Blob([data], {
                type: type
            });
            if (window.navigator.msSaveOrOpenBlob) // IE10+
                window.navigator.msSaveOrOpenBlob(file, filename);
            else { // Others
                var a = document.createElement("a"),
                    url = URL.createObjectURL(file);
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                setTimeout(function() {
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                }, 0);
            }
        }
    </script>

    <?php
    if (strpos($_GET["page"], "..") !== false) die("Error");
    if (is_dir('./backup/' . $_GET["page"]) && $handle = opendir('./backup/' . $_GET["page"])) {
        echo "<a href='backup.php?page=" . prev(end(explode("/", $_GET["page"]))) . "'><img width='50' src='http://archive.ev3lessons.com/folder.gif'>..</a><br>";

        while (false !== ($entry = readdir($handle))) {

            if ($entry != "." && $entry != "..") {
                // echo "./backup/".$_GET["page"]."/".$entry;
                if (is_dir("./backup/" . $_GET["page"] . "/" . $entry)) {
                    echo "<a href='backup.php?page=" . $_GET["page"] . "/" . $entry . "'><img width='50' src='http://archive.ev3lessons.com/folder.gif'>$entry</a><br>";
                } else {
                    echo "<a target='_blank' href='backup.php?page=" . $_GET["page"] . "/" . $entry . "'><img width='50' src='file.png'>$entry</a><br>";
                }
            }
        }

        closedir($handle);
    } else {
        header('Location: backup/' . $_GET["page"]);

        // $contents = file_get_contents('./backup/'.$_GET["page"]);
        // $fname = end(explode("/",$_GET["page"]));
        // echo $fname;
        // echo "here ".'./backup/'.$_GET["page"];
        //     echo "          <pre style='overflow-x: auto;font-family: monospace;'>
        // Contents:" . $contents."</pre>";
        // $contents = str_replace("\n","\\\n",$contents);
        //     echo "<button onclick='download(\"".$contents."\", \"".$fname."\", \"txt\");'>Download</button>";
    }
    ?>
</p>
