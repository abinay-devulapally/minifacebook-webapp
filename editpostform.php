<?php
require "database.php";
require "session_auth.php";
$rand = bin2hex(openssl_random_pseudo_bytes(16));
$_SESSION["nocsrftoken"] = $rand;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - MiniFacebook</title>
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
                <h2>Edit Post</h2>
                <?php
                $postID = $_GET['postID'];
                $post = getPostByID($postID);

                if (!$post) {
                    echo "<p>Post not found.</p>";
                } else {
                    ?>
                    <form method="post" action="editpost.php">
                        <input type="hidden" name="postID" value="<?php echo $postID; ?>">
                        <!-- Hidden input for CSRF token -->
                        <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>">
                        <label for="postTitle">Title:</label>
                        <input type="text" id="postTitle" name="postTitle"
                            value="<?php echo htmlentities($post['title']); ?>" required>
                        <br><br>
                        <label for="postContent">Content:</label>
                        <textarea id="postContent" name="postContent"
                            required><?php echo htmlentities($post['content']); ?></textarea>
                        <br><br>
                        <button class="button" type="submit" name="editPost">Save Changes</button>
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
