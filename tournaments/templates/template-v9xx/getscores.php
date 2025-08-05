<?php
$handle = fopen("admin/teams.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        $teamno = explode(",", $line)[0];
        for ($c = 1; $c <= 3; $c++) {
            $file = "teams/" . $teamno . "/pubScores/" . $c . ".txt";
            //echo $file . "<br>";
            if (file_exists($file)) {
                $contents = trim(file_get_contents($file));
                echo $contents . "\n";
            } else {
                echo "\n";
            }
        }
    }

    fclose($handle);
    echo "''";
} else {
    // error opening the file.
}
?>
