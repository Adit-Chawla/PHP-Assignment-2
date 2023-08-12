<?php
require_once 'db_config.php';

// Hash a sample password (replace this with actual password hashing)
$hashedPassword = password_hash('testpassword', PASSWORD_DEFAULT);

// SQL query to insert test user
$sql = "INSERT INTO assignment2 (fname, lname, email, username, password) VALUES ('test', 'user' , 'test@gmail.com', 'usertest', '$hashedPassword')";

if ($conn->query($sql) == TRUE) {
    echo "Test user inserted successfully";
} else {
    echo "Error inserting test user: " . $conn->error;
}

$conn->close();
?>
