<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <title>Tournament Scoring System</title>
</head>

<body>
    <div id="topbar">


        <?php
        if (strpos($_SERVER['SERVER_NAME'], "testing") !== false) {
            echo "<h2>Warning: This is a testing server. Go <a href='https://tournament.flltutorials.com'>here</a> for the correct server</h2>";
        }
        ?>
        <div class="topbar" id="myTopbar" style="width:100%; height:35px; background-color:#0A122A; top:0;align-items: center;">

            <i style="text-align:left; color:white; position: relative; margin:auto;padding-left: 3px;top: 1px;">Tournament</i>

            <div style="text-align:right; color:white; position: relative; margin:auto;padding-right: 3px;top:-20px;">
            </div>

        </div>



    </div><br>
    <div>

        <div id="header">

            <div class="topnav" id="myTopnav" style="width:100%">
                <a href="index.php">Home</a>
                <!--    <a href="welcome.php">Tournaments</a>-->

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


        </div>

        <br>
        <section>
            <div class="text-body">

                <h1>Welcome to FLLTutorials Tournament Scoring System
                    <script>
                        function textFileToArray(filename) {
                            var reader = (window.XMLHttpRequest != null) ?
                                new XMLHttpRequest() :
                                new ActiveXObject("Microsoft.XMLHTTP");
                            reader.open("GET", filename, false);
                            reader.send();
                            return reader.responseText.split(/\r\n|\n|\r/); //split(/(\r\n|\n)/g)
                        }
                    </script>
                </h1>
            </div>
        </section><br>
        <section>
            <div class="text-body" style="font-size: 20px;">

                <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $url = 'https://www.google.com/recaptcha/api/siteverify';
                    $data = array(
                        'secret' => 'XXXXXXXXXXXXXXXXX', //FILL IN
                        'response' => $_POST["g-recaptcha-response"]
                    );
                    $options = array(
                        'http' => array(
                            'method' => 'POST',
                            'content' => http_build_query($data)
                        )
                    );
                    $context  = stream_context_create($options);
                    $verify = file_get_contents($url, false, $context);
                    $captcha_success = json_decode($verify);
                    $bot = false;
                    if ($captcha_success->success == false) {
                        //echo "<p style='color:red;'>Failed: You are a bot.</p>";
                        $bot = true;
                        $confirm_password_err .= "<br>Failed: You are a bot.";
                    } else if ($captcha_success->success == true) {
                        //echo "<p>You are not not a bot!</p>";
                    }
                    $verify = false;
                    if ($bot !== false) echo  "<p style='color:red;'>Failed: You are a bot.</p>";
                    if ($bot == false) {

                        header("Location: welcome.php");
                        echo "<br><b style='color:red;'>You have been verified.</b><br>";
                    }
                }
                ?>

                <p style="font-size: 100%;">
                    To prevent abuse of the system, we ask that you verify that you are a human to continue.
                <form action="" method="POST">
                    <div class="g-recaptcha" data-sitekey="6Letju0ZAAAAAN25sDp8kjE8beap8W7c_Zls2HYa"></div>

                    <input type="hidden" value="verify" name="isbot">
                    <input value="Start/Access a Tournament" type="submit" class="btn btn-primary"><br>
                </form>
                </p>
                <p> Note: You will need to make an account to create/access a tournament.<br> <br> If you have any edits or would like to see features added, please <a href="mailto:team@ev3lessons.com">email</a>.
                    <br>
                    <br>
                    Supported browsers include: Google Chrome, Firefox, Safari, Chrome on Android, Safari on iOS.

                </p>
                <br>
            </div>
        </section>
        <br>
        <div id="footer">
            <div class="navbar">
                <center style="color:white;">
                    Copyright (C) 2021 Droids Robotics
                </center>
            </div>
        </div>
    </div>
</body>
