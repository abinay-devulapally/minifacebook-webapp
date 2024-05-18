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
                $newname = htmlspecialchars($_REQUEST["newname"]);
                $newemail = htmlspecialchars($_REQUEST["newemail"]);
                $newphone = htmlspecialchars($_REQUEST["newphone"]);

                if (isset($newname) && isset($newemail)) {
                    // echo "Got new name:$newname and new email=$newemail";
                    if (changeprofile($newname, $newemail, $newphone)) {
                        echo "<br>Profile has been edited. Get back to <a href='index.php'>Home Page</a>";
                    } else {
                        echo "<br>Edit Profile change failed";
                    }
                } else {
                    echo "<br>Both name and email must be provided";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>