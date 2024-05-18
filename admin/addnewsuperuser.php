<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniFacebook</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style-with-prefix.css">
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
                require "../database.php";
                $username = $_POST["username"];
                $name = $_POST["name"];
                $email = $_POST["email"];
                $phone = $_POST["phone"];
                $password = $_POST["password"];
                if (isset($username) and isset($password)) {
                    // echo "Debug> got username=$username;password=$password";
                    if (addnewsuperuser($username, $name, $email, $phone, $password)) {
                        echo "<br>Registration Successfull. Please <a href='../logout.php'>logout</a> and login again to with new username.";
                    } else {
                        echo "Registration Failed!";
                    }
                } else {
                    echo "No username/password provided";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
