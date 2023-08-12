<?php
require_once 'db_config.php';

// SQL query to create the user table
$sql = "CREATE TABLE assignment2 (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fname   VARCHAR(50) NOT NULL,
    lname   VARCHAR(50) NOT NULL,
    email   VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(512) NOT NULL
)";

if ($conn->query($sql) == TRUE) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
