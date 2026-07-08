<?php
// config/connection.php

// Database configuration
$db_host = '127.0.0.1';
$db_name = '4digisol_db';
$db_user = 'root'; // Change this to your database username
$db_pass = ''; // Change this to your database password

// Create MySQLi connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8mb4");

// Optional: Set error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Make connection available globally
$GLOBALS['conn'] = $conn;

// Uncomment the line below to test connection
// echo "Connected successfully";
?>