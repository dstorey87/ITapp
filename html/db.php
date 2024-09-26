<?php
$servername = "db"; // Use the service name defined in docker-compose.yml
$username = "eve_user";
$password = "your_password";
$dbname = "eve_online";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
