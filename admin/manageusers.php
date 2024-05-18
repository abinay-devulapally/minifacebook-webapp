<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - MiniFacebook</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style-with-prefix.css">
    <style>
        body {
            font-family: 'Muli', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .main-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: auto;
            width: 80%;
            max-width: 600px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f0f0f0;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #5C67F2;
            color: white;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #4a54e1;
        }
        .disabled-btn {
            background-color: #cccccc;
        }
    </style>
</head>
<body class="view-main-body">
    <div class="main-container">
        <?php
        require "../database.php";
        require "session_suauth.php";
         
        if (!isset($_SESSION["role"]) || $_SESSION["role"] != "superuser") {
            echo "<p class='source'>Access Denied. This page is for superusers only.</p>";
            exit;
        }

        if (isset($_POST['toggleActive'], $_POST['username'])) {
            $newStatus = ($_POST['toggleActive'] === 'Enable') ? 1 : 0;
            $stmt = $mysqli->prepare("UPDATE users SET isActive = ? WHERE username = ?");
            $stmt->bind_param("is", $newStatus, $_POST['username']);
            $stmt->execute();
        }

        $result = $mysqli->query("SELECT username, isActive FROM users");
        if ($result) {
            echo "<table><tr><th>Username</th><th>Status</th><th>Action</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $statusText = $row['isActive'] ? 'Active' : 'Disabled';
                $toggleButtonText = $row['isActive'] ? 'Disable' : 'Enable';
                echo "<tr><td>{$row['username']}</td><td>{$statusText}</td>";
                echo "<td><form method='post'><input type='hidden' name='username' value='{$row['username']}'/>";
                echo "<input type='submit' class='btn' name='toggleActive' value='{$toggleButtonText}'/></form></td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Error fetching users: " . $mysqli->error . "</p>";
        }
        ?>
    </div>
</body>
</html>
