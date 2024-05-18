<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniFacebook</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-with-prefix.css">
    <style>
        .srouce {
            text-align: center;
            color: #ffffff;
            padding: 10px;
        }
    </style>
</head>

<body class="view-main-body">
    <div class="main-container">
        <div class="form-container">

            <div class="form-body">
                <?php
                require "database.php";
                require "session_auth.php";
                $token = $_POST["nocsrftoken"];
                if (!isset($token) or ($token !== $_SESSION["nocsrftoken"])) {
                    echo "CSRF Attack is detected";
                    die();
                }
                $username = $_SESSION["username"];
                $password = htmlspecialchars($_REQUEST["newpassword"]);
                if (isset($username) and isset($password)) {
                    // echo "Debug> changepassword.php got username=$username;newpassword=$password";
                    if (changepassword($username, $password)) {
                        echo "<br>Password has been changed. Please <a href='logout.php'>logout</a> and login again to change your password.";
                    } else {
                        echo "<br>Password change failed";
                    }
                } else {
                    echo "<br>No username/password provided";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>