<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page - MiniFacebook</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-with-prefix.css">
    <style>
        body {
            font-family: 'Muli', sans-serif;
            background: #e9e9e9;
            margin: 0;
            padding: 20px;
        }

        .post-container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 20px;
            text-align: left;
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

        .comments-section {
            background: #f8f8f8;
            border-left: 3px solid #c6c6c6;
            padding: 10px 20px;
            margin: 20px 0;
        }

        .comment {
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 0;
        }

        .comment:last-child {
            border-bottom: none;
        }

        .comment-meta {
            color: #a0a0a0;
            font-size: 0.85em;
        }

        .comment-content {
            color: #333;
            margin-top: 5px;
        }

        .comment-form textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-top: 10px;
            resize: vertical;
        }

        .comment-form button {
            background-color: #5a5a5a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 10px;
            cursor: pointer;
        }

        .comment-form button:hover {
            background-color: #484848;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        hr {
            border: none;
            height: 1px;
            background-color: #ccc;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="view-main-body-light">

    <div class="post-container">
        <?php
        require "database.php";
        require "session_auth.php";
        $posts = viewPosts();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletePost'], $_POST['postID']) && $_SESSION['role'] === 'superuser') {
            $postID = $_POST['postID'];
            $deleteResult = deletePost($postID);
            if ($deleteResult) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $_SESSION['message'] = "The post could not be deleted by the admin.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }
        if (isset($_SESSION['message'])) {
            echo "<p class='error-message'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }


        // Logic for posting a comment
        // if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitComment'], $_POST['postID'], $_POST['commentContent'])) {
        //     $postID = $_POST['postID'];
        //     $content = $_POST['commentContent'];
        //     $username = $_SESSION['username']; // Make sure the user is logged in
        //     if (!empty($content)) {
        //         postComment($postID, $username, $content);
        //     }
        // }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitComment'], $_POST['postID'], $_POST['commentContent'])) {
            if (isset($_SESSION['username']) && ($_SESSION['role'] === 'user' || $_SESSION['role'] === 'superuser')) {
                $postID = $_POST['postID'];
                $username = $_SESSION['username'];
                $content = htmlspecialchars($_POST['commentContent']);

                if (!empty($content)) {
                    if (postComment($postID, $username, $content)) {
                        echo "Comment posted successfully!";
                    } else {
                        echo "Failed to post comment.";
                    }
                } else {
                    echo "Comment content cannot be empty.";
                }
            } else {
                echo "You must be logged in to post comments.";
            }
        }
        ?>

        <h1>Recent Posts</h1>
        <?php if ($posts && count($posts) > 0): ?>
            <ul>
                <?php foreach ($posts as $post): ?>
                    <li>
                        <h2 class="post-title"><?php echo htmlentities($post['title']); ?></h2>
                        <div class="post-content"><?php echo nl2br(htmlentities($post['content'])); ?></div>
                        <div class="post-meta">Posted by: <?php echo htmlentities($post['username']); ?> on
                            <?php echo date("F j, Y, g:i a", strtotime($post['postTime'])); ?>
                        </div>

                        <?php if ($_SESSION['role'] === 'superuser'): ?>
                            <!-- Superuser Delete Button -->
                            <form method="post" action="" style="display: inline;">
                                <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>">
                                <button type="submit" name="deletePost">Delete Post</button>
                            </form>
                        <?php endif; ?>

                        <!-- Display comments -->
                        <div class="comments-section">
                            <?php
                            $comments = getComments($post['postID']);
                            if (!empty($comments)) {
                                foreach ($comments as $comment) {
                                    echo '<div class="comment">';
                                    echo '<div class="comment-meta">' . htmlentities($comment['username']) . ' commented at ' . date("F j, Y, g:i a", strtotime($comment['commentTime'])) . ':</div>';
                                    echo '<div class="comment-content">' . nl2br(htmlentities($comment['content'])) . '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p class="no-comments">No comments yet.</p>';
                            }
                            ?>
                        </div>

                        <!-- Comment form -->
                        <div class="comment-form">
                            <form method="post" action="">
                                <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>">
                                <textarea name="commentContent" required placeholder="Write a comment..."></textarea>
                                <button type="submit" name="submitComment">Comment</button>
                            </form>
                        </div>

                    </li>
                    <hr>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No posts available or an error occurred.</p>
        <?php endif; ?>
    </div>

</body>

</html>