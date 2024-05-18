<?php
require "session_auth.php";
$rand = bin2hex(openssl_random_pseudo_bytes(16));
$_SESSION["nocsrftoken"] = $rand;
?>
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
                <h2 class="title">Change Password</h2>

                <form action="changepassword.php" method="POST" class="the-form">
                    <h2 style="color: white;">Welcome
                        <?php echo '<span style="color: white;">' . htmlentities($_SESSION["username"]) . '</span>'; ?>
                    </h2>

                    <!-- Hidden input for CSRF token -->
                    <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>">

                    <label for="password">New Password</label>
                    <input type="password" name="newpassword" id="password" placeholder="Enter your New Password">
                    <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />
                    <button class="button" type="submit">Change Password</button>

                </form>
            </div>
        </div>
    </div>
</body>

</html>