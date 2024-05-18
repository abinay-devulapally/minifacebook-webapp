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
    <?php
    require "database.php";
    require "session_auth.php";
    if (isset($_POST['createPost'])) {
        $title = htmlspecialchars($_POST['postTitle']);
        $content = htmlspecialchars($_POST['postContent']);
        $username = $_SESSION['username']; // Assuming the username is stored in the session

        if (createPost($username, $title, $content)) {
            echo "<script>alert('Post created successfully!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Failed to create post. Please try again.');</script>";
        }
    } else {
        echo "Post not created";
    }
    ?>
</body>

</html>