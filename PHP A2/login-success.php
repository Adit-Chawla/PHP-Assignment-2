<?php
session_start();
require_once 'db_config.php';

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login Success</title>
</head>
<body>
    <h1>Welcome to the Restricted Area, <?php echo $username; ?>!</h1>
    <p>This is the content that is visible only to logged-in users.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
