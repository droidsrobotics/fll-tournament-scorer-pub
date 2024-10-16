<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="/js/download.js"></script>

    <script>
        language = "en"
    </script>
    <script src="/js/languages.js"></script>
    <script src="/js/language-detector.js"></script>
    <title>Login</title>
</head>

<body>
     <script>
        $(function() {
            $("#topbar").load("topbar.php");
        });
    </script>
    <div id="topbar"></div>
     <br>
    <div>

        <script>
            $(function() {
                $("#header").load("header.html");
            });
        </script>
        <div id="header" ></div>

        <br>
        <section>
            <div class="text-body">

                <h1>Login
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
                                                // if (!isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'],"virtualopeninvitational")==false && strpos($_SERVER['HTTP_REFERER'],"flltutorials")==false) header("Location: /index.php?source=welcomeVOI.php");
                // Initialize the session
                session_start();
                //  echo $_GET["auth"];
                // Check if the user is already logged in, if yes then redirect him to welcome page
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                    if (isset($_GET["auth"]) && $_GET["auth"] !== "denied") header("location: " . $_GET["auth"]);
                    else header("location: welcome.php");
                    exit;
                }

                // Include config file
                require_once "config.php";

                // Define variables and initialize with empty values
                $username = $password = "";
                $username_err = $password_err = "";

                // Processing form data when form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // Check if username is empty
                    if (empty(trim($_POST["username"]))) {
                        $username_err = "Please enter username.";
                    } else {
                        $username = trim($_POST["username"]);
                    }

                    // Check if password is empty
                    if (empty(trim($_POST["password"]))) {
                        $password_err = "Please enter your password.";
                    } else {
                        $password = trim($_POST["password"]);
                    }

                    // Validate credentials
                    if (empty($username_err) && empty($password_err)) {

                        // Prepare a select statement
                        $sql = "SELECT id, username, password FROM users WHERE username = ?";
                        echo "The password you entered was not valid.";

                        if ($stmt = mysqli_prepare($link, $sql)) {

                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "s", $param_username);

                            // Set parameters
                            $param_username = $username;

                            // Attempt to execute the prepared statement
                            if (mysqli_stmt_execute($stmt)) {
                                // Store result
                                mysqli_stmt_store_result($stmt);

                                // Check if username exists, if yes then verify password
                                if (mysqli_stmt_num_rows($stmt) == 1) {
                                    // Bind result variables
                                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                                    if (mysqli_stmt_fetch($stmt)) {
                                        if (password_verify($password, $hashed_password)) {
                                            // Password is correct, so start a new session
                                            session_set_cookie_params(36000,"/");

                                            session_start();

                                            // Store data in session variables
                                            $_SESSION["loggedin"] = true;
                                            $_SESSION["id"] = $id;
                                            $_SESSION["username"] = $username;

                                            // Redirect user to welcome page

                                            if (isset($_GET["auth"]) && $_GET["auth"] !== "denied") header("location: " . $_GET["auth"]);
                                            else header("location: welcome.php");

                                            // echo "here";
                                            // echo $_GET["auth"];
                                        } else {
                                            // Display an error message if password is not valid
                                            $password_err = "The password you entered was not valid.";
                                            echo "The password you entered was not valid.";
                                        }
                                    }
                                } else {
                                    // Display an error message if username doesn't exist
                                    $username_err = "No account found with that username.";
                                }
                            } else {
                                echo "Oops! Something went wrong. Please try again later.";
                            }

                            // Close statement
                            mysqli_stmt_close($stmt);
                        }
                    }

                    // Close connection
                    mysqli_close($link);
                }
                ?>

                <!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

</head> -->
                <!-- <body> -->
                <style type="text/css">
                    /* body{ font: 14px sans-serif; } */
                    .wrapper {
                        max-width: 500px
                    }
                </style>
                <div class="wrapper">
                    <!-- <h2>Login</h2> -->
                    <p>Please fill in your credentials to login.</p>
                    <form action="" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Login">
                        </div>
                        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
                        <p>Forgot your password? <a href="reset-password.php">Reset Password</a>.</p>
                    </form>
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
    <script src="/js/translate.js"></script>

</body>
