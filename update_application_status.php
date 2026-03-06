<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    die("Invalid Request");
}

$application_id = intval($_GET['id']);
$status = strtolower($_GET['status']);

$allowed_status = ['accepted', 'rejected', 'pending'];

if (!in_array($status, $allowed_status)) {
    die("Invalid Status");
}

/* Update status */
$sql = "UPDATE applications 
        SET status = '$status' 
        WHERE id = $application_id";

if ($conn->query($sql)) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "Something went wrong";
}