<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "sales_assistant";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Global Clean Function for Security
function clean($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}
?>