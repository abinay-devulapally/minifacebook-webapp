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

        .centered-text {
            color: white;
            /* Text color */
            text-align: center;
            /* Center text horizontally */
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="form-container">
            <h1 class="centered-text">Login into waph-05.minifacebook</h1>

            <div class="form-body">
                <h2 class="title">Log In</h2>

                <form action="index.php" method="POST" class="the-form">
                    <label for="username">Username</label>
                    <input type="username" name="username" id="username" placeholder="Enter your Username">

                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password">
                    <button class="button" type="submit">Login</button>
                </form>


            </div><!-- FORM BODY-->

            <div class="form-footer">
                <div>
                    <span>Don't have an account?</span> <a href="registrationform.php">Sign Up</a>
                </div>
            </div><!-- FORM FOOTER -->

        </div><!-- FORM CONTAINER -->
    </div>

</body>

</html>