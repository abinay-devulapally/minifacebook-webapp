<?php
session_set_cookie_params(15 * 60, "/", "waph-team05.minifacebook.com", TRUE, TRUE);
session_start();
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
// if (isset($_SESSION['views']))
//     $_SESSION['views'] = $_SESSION['views'] + 1;
// else {
//     $_SESSION['views'] = 1;
// }
// echo "You have visited this page " . $_SESSION['views'] . " times";
?>
