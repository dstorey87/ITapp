<?php
// EveOnlineCapitalProduction/html/includes/db.php

$servername = "db";  // Ensure this is correctly set to the database container name
$username = "eve_user";
$password = "your_password";  // Use your actual database password here
$dbname = "eve_online";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Logging function
function log_message($message) {
    $log_file = __DIR__ . '/../logs/log.txt';  // Ensure the logs folder is writable
    file_put_contents($log_file, date('[Y-m-d H:i:s] ') . $message . PHP_EOL, FILE_APPEND);
}
?>