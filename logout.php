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
                session_start();
                session_destroy();
                ?>
                <p> You are Logout! </p>
                <a href="index.html">Login Again</a>
            </div>
        </div>
    </div>
</body>

</html>