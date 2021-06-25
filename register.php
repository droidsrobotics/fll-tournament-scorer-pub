<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Register</title>
    <style type="text/css">
        /* body{ font: 14px sans-serif; } */
        .wrapper {
            max-width: 700px
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
     <script>
        $(function() {
            $("#topbar").load("topbar.php");
        });
    </script>
    <div id="topbar"></div><br>
    <div>

        <script>
            $(function() {
                $("#header").load("header.html");
            });
        </script>
        <div id="header"></div>

        <br>
        <section>
            <div class="text-body">

                <h1>Register
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

                <!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>

</head> -->

                <body>
                    <div class="wrapper">
                        <!-- <h2>Sign Up</h2> -->
                        <p>Please fill this form to create an account.</p>

                        <?php
                        if (!isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'],"virtualopeninvitational")==false && strpos($_SERVER['HTTP_REFERER'],"flltutorials")==false) header("Location: /index.php?source=welcomeVOI.php");
                        // Include config file
                        require_once "config.php";

                        // Define variables and initialize with empty values
                        $username = $password = $confirm_password = "";
                        $username_err = $password_err = $confirm_password_err = "";

                        // echo $_POST["username"];
                        //
                        $verify = false;
                        $confirmed = false;

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $url = 'https://www.google.com/recaptcha/api/siteverify';
                            $data = array(
                                'secret' => 'XXXXXXXXXXXXXXXXXx', // FILL IN
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
                                if (!isset($_POST["password"]) && isset($_POST["username"]) && !isset($_POST["verify"])) {
                                    $verify = true;
                                    $teamuser = $_POST["username"];
                                    $code = rand(100000, 999999);
                                    session_start();
                                    $_SESSION["code"] = $code;
                                    $_SESSION["email"] = $_POST["username"];
                                    exec('printf "To: ' . $teamuser . '\nFrom: noreply@ev3lessons.com\nSubject: FLLTutorials Tournament Scoring System\nWelcome. Your verification code is ' . $code . '." | msmtp ' . $teamuser . '');
                                    echo "<br><b style='color:red;'>You have been emailed a verification code. Please enter it below.</b><br>";
                                }

                                if (!isset($_POST["password"]) && isset($_POST["username"]) && isset($_POST["verify"])) {
                                    session_start();
                                    if ($_POST["verify"] == $_SESSION["code"]) {
                                        $confirmed = true;
                                        $verify = false;
                                    } else {
                                        $verify_err = "Incorrect verification code";
                                        $verify = true;
                                    }
                                }

                                if (isset($_SESSION["email"]) && $_SESSION["email"] !== $_POST["username"]) die("Error - tampering with the username field has been detected");
                                // Processing form data when form is submitted
                                // Validate username
                                if (isset($_POST["password"]) && isset($_POST["username"])) {
                                    $verify = false;
                                    $confirmed = true;

                                    if (empty(trim($_POST["username"]))) {
                                        $username_err = "Please enter a username.";
                                    } else {
                                        // Prepare a select statement
                                        $sql = "SELECT id FROM users WHERE username = ?";

                                        if ($stmt = mysqli_prepare($link, $sql)) {
                                            // Bind variables to the prepared statement as parameters
                                            mysqli_stmt_bind_param($stmt, "s", $param_username);

                                            // Set parameters
                                            $param_username = trim($_POST["username"]);

                                            // $param_username = trim($_POST["username"]);

                                            // Attempt to execute the prepared statement
                                            if (mysqli_stmt_execute($stmt)) {
                                                /* store result */
                                                mysqli_stmt_store_result($stmt);

                                                if (mysqli_stmt_num_rows($stmt) == 1) {
                                                    // echo $username;

                                                    $username_err = "This username is already taken.";
                                                } else {
                                                    $username = trim($_POST["username"]);
                                                    // $username = trim($_SESSION["email"]);
                                                }
                                            } else {
                                                echo "Oops! Something went wrong. Please try again later.";
                                            }

                                            // Close statement
                                            mysqli_stmt_close($stmt);
                                        }

                                        // Validate password
                                        if (isset($_POST["password"])) {
                                            if (empty(trim($_POST["password"]))) {
                                                $password_err = "Please enter a password.";
                                            } elseif (strlen(trim($_POST["password"])) < 6) {
                                                $password_err = "Password must have at least 6 characters.";
                                            } else {
                                                $password = trim($_POST["password"]);
                                            }

                                            // Validate confirm password
                                            if (empty(trim($_POST["confirm_password"]))) {
                                                $confirm_password_err = "Please confirm password.";
                                            } else {
                                                $confirm_password = trim($_POST["confirm_password"]);
                                                if (empty($password_err) && ($password != $confirm_password)) {
                                                    $confirm_password_err = "Password did not match.";
                                                }
                                            }
                                        }



                                        // Check input errors before inserting in database
                                        if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
                                            // Prepare an insert statement
                                            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

                                            if ($stmt = mysqli_prepare($link, $sql)) {
                                                // Bind variables to the prepared statement as parameters
                                                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

                                                // Set parameters
                                                $param_username = $username;
                                                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                                                // Attempt to execute the prepared statement
                                                if (mysqli_stmt_execute($stmt)) {
                                                    // Redirect to login page
                                                    header("location: login.php");
                                                } else {
                                                    echo "Something went wrong. Please try again later.";
                                                }

                                                // Close statement
                                                mysqli_stmt_close($stmt);
                                            }
                                        }

                                        // Close connection
                                        mysqli_close($link);
                                    }
                                }
                            }
                        }
                        ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                <label>Email</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $_SESSION["email"]; ?>" <?php if (isset($_SESSION["email"])) echo 'readonly'; ?>>
                                <span class="help-block"><?php echo $username_err; ?></span>
                            </div>

                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                <?php
                                if ($confirmed)
                                    echo '
                    <label>Password (note: passwords must be at least 6 characters long)</label>
                    <input type="password" name="password" class="form-control" value="">
                    <span class="help-block">' . $password_err . ' </span>
                ';

                                if ($verify)
                                    echo '
                    <label>Verification Code</label>
                    <input type="text" name="verify" class="form-control" value="">
                    <span class="help-block">' . $verify_err . ' </span>
                ';
                                ?>
                            </div>
                            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                <?php
                                if ($confirmed)
                                    echo '
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="">
                    <span class="help-block">' . $confirm_password_err . '</span>
                ';
                                ?>
                            </div>


                            <div class="g-recaptcha" data-sitekey="6Letju0ZAAAAAN25sDp8kjE8beap8W7c_Zls2HYa"></div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <input type="reset" class="btn btn-danger" value="Reset">
                            </div>
                            <p>Already have an account? <a href="login.php">Login here</a>.</p>
                        </form>
                        <!-- <b>If you are having trouble registering, you can use the <a href="registerold.php">old site</a>.</b> -->
                    </div>
                    <!-- </body>

</html> -->
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
</body>
