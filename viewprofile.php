<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page - MiniFacebook</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-with-prefix.css">
    <style>
        body {
            font-family: 'Muli', sans-serif;
            background-color: #e9e9e9;
            margin: 0;
            padding: 20px;
        }

        .profile-container {
            text-align: center;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin: auto;
            max-width: 600px;
        }

        .profile-container h1 {
            margin-bottom: 20px;
            color: #333333;
        }

        .profile-container p {
            margin-bottom: 10px;
            color: #666666;
        }

        .blue-text {
            color: rgb(49, 49, 126);
            text-decoration: none;
        }

        .blue-text:hover {
            color: rgb(49, 49, 126);
            text-decoration: underline;
        }

        .link-container {
            margin-top: 20px;
        }

        .link-container a {
            margin: 0 10px;
            color: #666666;
            text-decoration: none;
        }

        .link-container a:hover {
            color: rgb(49, 49, 126);
            text-decoration: underline;
        }
    </style>
</head>

<body class="view-main-body-light">

    <div class="profile-container">
        <?php
        require "database.php";
        require "session_auth.php";
        $userData = fetchUserData($_SESSION["username"]);
        ?>
        <h1>Profile Page</h1>
        <p>Welcome, <?php echo htmlentities($userData['name']); ?>!</p>
        <p>Email: <?php echo htmlentities($userData['email']); ?></p>
        <p>Phone: <?php echo htmlentities($userData['phone']); ?></p>

        <div class="link-container">
            <a href="index.php" class="blue-text">Home</a>
            <a href="changepasswordform.php" class="blue-text">Change Password</a>
            <a href="changeprofileform.php" class="blue-text">Edit Profile</a>
            <a href="logout.php" class="blue-text">Logout</a>
        </div>
    </div>

</body>

</html>