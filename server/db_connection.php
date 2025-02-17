<?php
$servername = "localhost";
$username = "root";  // MySQL username (usually root)
$password = "";      // MySQL password (blank by default on XAMPP)
$dbname = "event_manager";  // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

