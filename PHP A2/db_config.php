<?php
$servername = "127.0.0.1"; 
$username = "Adit200531948";
$password = "6ym96Kt8-R";
$dbname = "Adit200531948";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
