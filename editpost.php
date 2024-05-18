<?php
require "database.php";
require "session_auth.php";
$token = $_POST["nocsrftoken"];
if (!isset($token) or ($token !== $_SESSION["nocsrftoken"])) {
    echo "CSRF Attack is detected";
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editPost'])) {
    $postID = $_POST['postID'];
    $title = htmlspecialchars($_POST['postTitle']);
    $content = htmlspecialchars($_POST['postContent']);

    // Call the editPost function to update the post in the database
    if (editPost($postID, $title, $content)) {
        echo "<script>alert('Post updated successfully!');window.location='index.php';</script>";
    } else {
        echo "<script>alert('Failed to update post. Please try again.');window.location='editpostform.php?postID=$postID';</script>";
    }
} else {
    echo "<script>alert('Invalid request.');window.location='index.php';</script>";
}
?>