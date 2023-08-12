<?php
session_start();
require_once 'db_config.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"];

    if ($action == "signup") {
        // Validate input, hash password, and insert into database
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (!empty($fname) && !empty($lname) && !empty($email) && !empty($username) && !empty($password)) {
            $checkUsernameSql = "SELECT * FROM assignment2 WHERE username = ?";
            $stmtCheck = $conn->prepare($checkUsernameSql);
            $stmtCheck->bind_param("s", $username);
            $stmtCheck->execute();
            $checkResult = $stmtCheck->get_result();

            if ($checkResult->num_rows > 0) {
                $error_message = "Username already exists. Please choose a different username.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert user into the database
                $sql = "INSERT INTO assignment2 (fname, lname, email, username, password) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $fname, $lname, $email, $username, $hashedPassword);

                if ($stmt->execute()) {
                    $error_message = "Sign-up successful! You can now log in.";
                } else {
                    $error_message = "Error signing up. Please try again.";
                }
            }
        } else {
            $error_message = "All fields are required.";
        }
    } elseif ($action == "signin") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM assignment2 WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            // Verify the provided password with the stored hashed password
            if (password_verify($password, $row['password'])) {
                // Set session variables and redirect to login-success.php
                $_SESSION["username"] = $username;
                header("Location: login-success.php");
                exit();
            } else {
                $error_message = "Invalid username or password. Please try again.";
            }
        } else {
            $error_message = "Invalid username or password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Sign In / Sign Up</title>
</head>
<body>
    <h2>Sign In</h2>
    <form action="login.php" method="post">
        <input type="hidden" name="action" value="signin">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="action" value="signin">Sign In</button>
        <?php if (!empty($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
    </form>

    <h2>Sign Up</h2>
    <form action="login.php" method="post">
        <input type="hidden" name="action" value="signup">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required>
        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="new_username">Username:</label>
        <input type="text" id="new_username" name="username" required>
        <label for="new_password">Password:</label>
        <input type="password" id="new_password" name="password" required>
        <button type="submit" name="action" value="signup">Sign Up</button>
    </form>
</body>
</html>
