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

<body>
    <div class="main-container">
        <div class="form-container">

            <div class="form-body">
                <h2 class="title">Register Superuser</h2>
                <form action="addnewsuperuser.php" method="POST" class="the-form">
                    <label for="username">Username</label>
                    <input type="username" name="username" id="username" placeholder="Enter your Username">
                    <label for="name">Name</label>
                    <input type="username" name="name" id="username" placeholder="Enter your Name">
                    <label for="Email">Email</label>
                    <input type="username" name="email" id="username" required pattern=" ^[\w.-]+@[\w-]+(.[\w-]+)*$"
                        title="Please enter a valid email" placeholder="Your email address"
                        onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');" />
                    <label for="Phone">Phone</label>
                    <input type="username" name="phone" placeholder="Your Phone Number" required pattern="[0-9]{10}"
                        title="Please enter a valid 10-digit phone number"
                        onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');" />
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
                        placeholder="Your password"
                        title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"
                        onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); this.form.repassword.pattern = this.value;" />
                    <label for="password">Confirm Password</label>
                    <input type="password" name="repassword" class="text_field" placeholder="Retype your password"
                        required title="Password does not match"
                        onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');" />
                    <button class="button" type="submit">Sign Up</button>
                    <div class="form-footer">
                        <div>
                            <span>Already have account?</span> <a href="index.php">Login Here</a>
                        </div>
                    </div><!-- FORM FOOTER -->
                </form>
            </div>
        </div>
    </div>
</body>

</html>
