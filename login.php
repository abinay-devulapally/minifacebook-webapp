<?php
require "database.php";
session_set_cookie_params(15 * 60, "/", "worf.replit.dev", TRUE, TRUE);
session_start();
if (isset($_POST["username"]) && isset($_POST["password"])) {
    // Debug echo statement to display username and password
    echo "Debug: Username - " . $_POST["username"] . ", Password - " . $_POST["password"] . "<br>";


    if (checklogin_mysql($_POST["username"], $_POST["password"])) {
        $_SESSION["authenticated"] = TRUE;
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
        $_SESSION["role"] = "user";
    } else {
        session_destroy();  
        echo "<script>alert('Invalid username/password or Your account is disabled');window.location='index.php';</script>";
        die();
    }
}

// Check if user is authenticated
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== TRUE) {
    session_destroy();
    echo "<script>alert('You have not logged in. Please log in first!');</script>";
    echo "<script>window.location='index.php';</script>";
    die();
}

// Check for session hijacking
if ($_SESSION["browser"] !== $_SERVER["HTTP_USER_AGENT"]) {
    session_destroy();
    echo "<script>alert('Session hijacking attack is detected!');</script>";
    echo "<script>window.location='index.php';</script>";
    die();
}

// Function to delete a post (replace with your actual function)
// function deletePost($postID) {
//     // Implement deletion logic here
//     return true; // Return true on success, false on failure
// }

// Delete post action
// if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['postID'])) {
//     $postID = $_GET['postID'];
//     $result = deletePost($postID);
//     if ($result) {
//         echo "<script>alert('Post deleted successfully.');</script>";
//     } else {
//         echo "<script>alert('Failed to delete post.');</script>";
//     }
// }
// 
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
        .main-container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 20px;
        }

        /* Additional CSS styles here */
    </style>
</head>

<body class="view-main-body-light">

    <div class="main-container">
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
            // Fetch and display the user's posts (replace with your actual function)
            // function getUserPosts($username) {
            //     // Implement fetching logic here
            //     return []; // Return an array of posts
            // }

            // $userPosts = getUserPosts($_SESSION['username']);
            // if ($userPosts) {
            //     foreach ($userPosts as $userPost) {
            //         echo "<div class='post'>";
            //         echo "<h3 class='post-title'>" . htmlentities($userPost['title']) . "</h3>";
            //         echo "<p class='post-content'>" . nl2br(htmlentities($userPost['content'])) . "</p>";
            //         echo "<div class='post-meta'>Posted on " . date("F j, Y, g:i a", strtotime($userPost['postTime'])) . "</div>";
            //         // Add Edit and Delete options
            //         echo "<div class='edit-delete-links'>";
            //         echo "<a href='editpostform.php?postID=" . $userPost['postID'] . "' class='blue-text'>Edit</a>";
            //         echo "<a href='login.php?action=delete&postID=" . $userPost['postID'] . "' class='blue-text' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
            //         echo "</div>";
            //         echo "</div><hr />";
            //     }
            // } else {
            //     echo "<p>You haven't posted anything yet.</p>";
            // }
            ?>
        </div>
    </div>

</body>

</html>
