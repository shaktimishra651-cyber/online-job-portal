<?php
// ===== SESSION START (safe way) =====
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ===== DATABASE CONNECTION =====
$servername = "localhost";
$username   = "root";      // XAMPP default
$password   = "";          // XAMPP default
$database   = "jobportal"; // 👉 apna database name yahan likho

$conn = mysqli_connect($servername, $username, $password, $database);

// ===== CHECK CONNECTION =====
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>