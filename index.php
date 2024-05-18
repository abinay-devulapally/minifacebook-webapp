<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniFacebook</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-with-prefix.css">
    <style>
        .main-container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 20px;
        }

        .blue-text {
            color: rgb(49, 49, 126);
            text-decoration: none;
        }

        .blue-text:hover {
            color: rgb(49, 49, 126);
            text-decoration: underline;
        }

        .post-title {
            color: #333333;
            font-weight: 700;
        }

        .post-content {
            color: #666666;
            margin-top: 10px;
        }

        .post-meta {
            color: #888888;
            font-size: 0.85em;
            margin-top: 5px;
            margin-bottom: 10px;
            text-align: right;
        }

        .edit-delete-links {
            margin-top: 10px;
        }

        .edit-delete-links a {
            margin-right: 10px;
        }

        /* Centering the posts */
        .posts-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .post {
            width: 100%;
            max-width: 600px;
            /* Adjust the max-width as needed */
            margin-bottom: 20px;
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
    
    <div class="main-container">
        <?php
        require "database.php";
        session_set_cookie_params(15 * 60, "/", "waph-team05.minifacebook.com", TRUE, TRUE);
        session_start();
        if (isset($_POST["username"]) and isset($_POST["password"])) {
            if (checklogin_mysql($_POST["username"], $_POST["password"])) {
                $_SESSION["authenticated"] = TRUE;
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
                $_SESSION["role"] = "user";
            } else {
                session_destroy();  
                echo "<script>alert('Invalid username/password or Your account is disabled');window.location='form.php';</script>";
                die();
            }
        }
        if (!isset($_SESSION["authenticated"]) or $_SESSION["authenticated"] != TRUE) {
            session_destroy();
            echo "<script>alert('You have not login, Please login first!');</script>";
            header("Refresh: 0; url=form.php");
            die();
        }
        if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
            session_destroy();
            echo "<script>alert('Session hijacking attack is detected! ');</script>";
            header("Refresh: 0; url=form.php");
            die();
        }

        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['postID'])) {
            $postID = $_GET['postID'];
            $result = deletePost($postID);
            if ($result) {
                echo "<script>alert('Post deleted successfully.');window.location='index.php';</script>";
            } else {
                echo "<script>alert('Failed to delete post.');window.location='index.php';</script>";
            }
        }
        ?>
        <div class="white-text">
            <h2> Welcome
                <?php echo htmlentities($_SESSION['username']); ?> !
            </h2>
            <div class="link-container">
                <a href="index.php" class="blue-text">Home</a> |
                <a href="viewprofile.php" class="blue-text">View Profile</a> |
                <a href="viewposts.php" class="blue-text">View Posts</a> |
                <a href="changepasswordform.php" class="blue-text">Change Password</a> |
                <a href="changeprofileform.php" class="blue-text">Edit Profile</a> |
                <a href="http://waph-team05.minifacebook.com:8080?username=<?php echo urlencode($_SESSION['username']); ?>" class="blue-text">Web Chat</a> |
                <a href="logout.php" class="blue-text">Logout</a>
            </div>
            <form method="post" action="createpost.php">
                <h3>Create a New Post</h3>

                <label for="postTitle">Title:</label>
                <input type="text" id="postTitle" name="postTitle" placeholder="Enter Title" required>
                <br><br>
                <label for="postContent">Content:</label>
                <textarea id="postContent" name="postContent" placeholder="Enter Content" required></textarea>
                <br><br>
                <button type="submit" name="createPost">Post</button>
            </form>
        </div>
        <h2 style="text-align: center; margin-bottom: 20px;">View Your Posts</h2>
        <div class="posts-container">
            <?php
            // Fetch and display the user's posts
            $userPosts = getUserPosts($_SESSION['username']);
            if ($userPosts) {
                foreach ($userPosts as $userPost) {
                    echo "<div class='post'>";
                    echo "<h3 class='post-title'>" . htmlentities($userPost['title']) . "</h3>";
                    echo "<p class='post-content'>" . nl2br(htmlentities($userPost['content'])) . "</p>";
                    echo "<div class='post-meta'>Posted on " . date("F j, Y, g:i a", strtotime($userPost['postTime'])) . "</div>";
                    // Add Edit and Delete options
                    echo "<div class='edit-delete-links'>";
                    echo "<a href='editpostform.php?postID=" . $userPost['postID'] . "' class='blue-text'>Edit</a>";
                    echo "<a href='index.php?action=delete&postID=" . $userPost['postID'] . "' class='blue-text' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
                    echo "</div>";
                    echo "</div><hr />";
                }
            } else {
                echo "<p>You haven't posted anything yet.</p>";
            }
            ?>
        </div>
    </div>

</body>

</html>
