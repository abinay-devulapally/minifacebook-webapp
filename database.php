<?php
try {
    $pdo = new PDO('sqlite:database/minifacebook.sqlite');
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to SQLite database successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function addnewuser($username, $name, $email, $phone, $password)
{
    global $mysqli;
    $sql_all_users = "INSERT INTO all_users (username, userType) VALUES (?, 'user');";
    $stmt_all_users = $mysqli->prepare($sql_all_users);
    if (!$stmt_all_users) {
        printf("SQL error: " . $mysqli->error);
        return FALSE;
    }
    $stmt_all_users->bind_param("s", $username);
    if (!$stmt_all_users->execute()) {
        printf("Execution error: " . $mysqli->error);
        return FALSE;
    }
    $prepared_sql = "INSERT INTO users (username, name, email, phone, password) VALUES (?, ?, ?, ?, md5(?));";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        printf("SQL error: " . $mysqli->error);
        return FALSE;
    }
    $stmt->bind_param("sssss", $username, $name, $email, $phone, $password);
    if ($stmt->execute()) {
        return TRUE;
    } else {
        printf("Execution error: " . $stmt->error);
        return FALSE;
    }
}

function addnewsuperuser($username, $name, $email, $phone, $password)
{
    global $mysqli;
    $sql_all_users = "INSERT INTO all_users (username, userType) VALUES (?, 'superuser');";
    $stmt_all_users = $mysqli->prepare($sql_all_users);
    if (!$stmt_all_users) {
        printf("SQL error: " . $mysqli->error);
        return FALSE;
    }
    $stmt_all_users->bind_param("s", $username);
    if (!$stmt_all_users->execute()) {
        printf("Execution error: " . $mysqli->error);
        return FALSE;
    }
    $prepared_sql = "INSERT INTO superusers (username, name, email, phone, password) VALUES (?, ?, ?, ?, md5(?));";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        printf("SQL error: " . $mysqli->error);
        return FALSE;
    }
    $stmt->bind_param("sssss", $username, $name, $email, $phone, $password);
    if ($stmt->execute()) {
        return TRUE;
    } else {
        printf("Execution error: " . $stmt->error);
        return FALSE;
    }
}

function checklogin_mysql($username, $password)
{
    global $pdo;

    // Execute the SQL query using prepared statements
    $prepared_sql = "SELECT * FROM users WHERE (username = :username OR email = :email) AND password = :password AND isActive = TRUE";
    $stmt = $pdo->prepare($prepared_sql);
    $stmt->execute(array(':username' => $username, ':email' => $username, ':password' => $password));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) == 1)
        return TRUE;
    return FALSE;
}


function check_login_superuser($username, $password)
{
    global $mysqli;
    $prepared_sql = "SELECT * FROM superusers WHERE username = ? AND password = MD5(?)";
    $stmt = $mysqli->prepare($prepared_sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        return TRUE;
    }
    return FALSE;
}

function changepassword($username, $password)
{
    global $mysqli;
    $userRole = $_SESSION['role'];
    $tableToUpdate = ($userRole === 'superuser') ? 'superusers' : 'users';

    // Prepare SQL statement to update the appropriate table
    $prepared_sql = "UPDATE $tableToUpdate SET password = md5(?) WHERE username = ?;";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        printf("SQL error: " . $mysqli->error);
        return FALSE;
    }

    $stmt->bind_param("ss", $password, $username);
    if ($stmt->execute()) {
        return TRUE;
    } else {
        printf("Error updating password: " . $stmt->error);
        return FALSE;
    }
}


function viewPosts()
{
    global $mysqli;
    $prepared_sql = "SELECT p.postID, p.title, p.content, p.postTime, au.username 
                     FROM posts p 
                     JOIN all_users au ON p.owner = au.username 
                     ORDER BY p.postTime DESC";
    $stmt = $mysqli->prepare($prepared_sql);

    if (!$stmt) {
        printf("SQL error: " . $mysqli->error);  // Use printf for better error handling
        return false;
    }

    if (!$stmt->execute()) {
        printf("Error executing query: " . $stmt->error);  // Use printf for better error handling
        return false;
    }

    $stmt->bind_result($postID, $title, $content, $postTime, $username);
    $posts = [];

    while ($stmt->fetch()) {
        $posts[] = [
            'postID' => $postID,
            'title' => htmlentities($title),
            'content' => htmlentities($content),
            'postTime' => $postTime,
            'username' => htmlentities($username)
        ];
    }

    $stmt->close();
    return $posts;
}


function postComment($postID, $username, $content)
{
    global $mysqli;
    $sql = "INSERT INTO comments (postID, username, content) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        printf("SQL error: " . $mysqli->error);
        return false;
    }
    $stmt->bind_param("sss", $postID, $username, $content);
    if ($stmt->execute()) {
        return true;
    } else {
        printf("Execute failed: " . $stmt->error);
        return false;
    }
    $stmt->close();
}


function getComments($postID)
{
    global $mysqli;
    // Updated SQL to join with all_users instead of just users
    $sql = "SELECT c.content, c.commentTime, au.username 
            FROM comments c 
            JOIN all_users au ON c.username = au.username 
            WHERE c.postID = ? 
            ORDER BY c.commentTime ASC";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        printf("SQL error: " . $mysqli->error); // Log error instead of displaying it
        return false;
    }
    $stmt->bind_param("s", $postID);
    if (!$stmt->execute()) {
        printf("Execute failed: " . $stmt->error);
        return false;
    }

    $comments = [];
    $stmt->bind_result($content, $commentTime, $username);
    while ($stmt->fetch()) {
        $comments[] = ['content' => $content, 'commentTime' => $commentTime, 'username' => $username];
    }
    $stmt->close();
    return $comments;
}



function createPost($owner, $title, $content)
{
    global $mysqli;
    $postID = uniqid('post_');

    $prepared_sql = "INSERT INTO posts (postID, title, content, postTime, owner) VALUES (?, ?, ?, NOW(), ?);";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        printf('Prepare failed: %s\n', $mysqli->error);
        return false;
    }
    $stmt->bind_param("ssss", $postID, $title, $content, $owner);
    if ($stmt->execute()) {
        return true;
    } else {
        printf('Execute failed: %s\n', $stmt->error);
        return false;
    }
    $stmt->close();
}

function getUserPosts($username)
{
    global $mysqli;
    $prepared_sql = "SELECT * FROM posts WHERE owner = ? ORDER BY postTime DESC";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        printf('Prepare failed: %s\n', $mysqli->error);
        return false;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = array();
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    $stmt->close();
    return $posts;
}

function getPostByID($postID)
{
    global $mysqli;
    $prepared_sql = "SELECT * FROM posts WHERE postID = ?";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        printf('Prepare failed: %s\n', $mysqli->error);
        return false;
    }
    $stmt->bind_param("s", $postID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        return false;
    }
    $post = $result->fetch_assoc();
    $stmt->close();
    return $post;
}

function editPost($postID, $title, $content)
{
    global $mysqli;
    $prepared_sql = "UPDATE posts SET title = ?, content = ? WHERE postID = ?";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        printf('Prepare failed: %s\n', $mysqli->error);
        return false;
    }
    $stmt->bind_param("sss", $title, $content, $postID);
    if ($stmt->execute()) {
        return true;
    } else {
        printf('Execute failed: %s\n', $stmt->error);
        return false;
    }
    $stmt->close();
}

function deletePost($postID)
{
    global $mysqli;
    $prepared_sql = "DELETE FROM posts WHERE postID = ?";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        printf('Prepare failed: %s\n', $mysqli->error);
        return false;
    }
    $stmt->bind_param("s", $postID);
    if ($stmt->execute()) {
        return true;
    } else {
        printf('Execute failed: %s\n', $stmt->error);
        return false;
    }
    $stmt->close();
}



function changeprofile($newname, $newemail, $newphone)
{
    global $mysqli;
    $currentusername = $_SESSION["username"];
    $currentuserrole = $_SESSION["role"];  // Assuming you store user role in session

    // Determine which table to update based on the user role
    $tableToUpdate = ($currentuserrole === "superuser") ? "superusers" : "users";

    $prepared_sql = "UPDATE $tableToUpdate SET name = ?, email = ?, phone = ? WHERE username = ?;";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        printf("SQL error: " . $mysqli->error);  // Use printf to log this information
        return FALSE;
    }
    $stmt->bind_param("ssss", $newname, $newemail, $newphone, $currentusername);
    if ($stmt->execute()) {
        return TRUE;
    } else {
        printf("Error updating record: " . $stmt->error);  // Log errors instead of displaying them
        return FALSE;
    }
}


function fetchUserData($username)
{
    global $mysqli;
    // Attempt to fetch user data from 'users' table first
    $prepared_sql = "SELECT name, email, phone FROM users WHERE username = ? LIMIT 1;";
    $stmt = $mysqli->prepare($prepared_sql);

    if (!$stmt) {
        printf("SQL error: " . $mysqli->error); // Log error to error log
        return FALSE;
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($name, $email, $phone);

    if ($stmt->fetch()) {
        $stmt->close();
        return [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];
    }
    $stmt->close();

    // If no data was found in 'users', check 'superusers'
    $prepared_sql = "SELECT name, email, phone FROM superusers WHERE username = ? LIMIT 1;";
    $stmt = $mysqli->prepare($prepared_sql);
    if (!$stmt) {
        printf("SQL error: " . $mysqli->error);
        return FALSE;
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($name, $email, $phone);

    if ($stmt->fetch()) {
        $stmt->close();
        return [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];
    } else {
        $stmt->close();
        printf("Error fetching user data: No such user found in either table.");
        return FALSE;
    }
}


?>
