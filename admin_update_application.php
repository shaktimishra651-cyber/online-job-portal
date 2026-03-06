<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) ||
    ($_SESSION['role'] != 'employer' && $_SESSION['role'] != 'admin')) {
    die("Access denied");
}

if (!isset($_GET['id'], $_GET['status'])) {
    die("Invalid request");
}

$app_id = (int)$_GET['id'];
$status = $_GET['status'];

if(!in_array($status, ['pending','accepted','rejected'])){
    die("Invalid status value");
}

$stmt = $conn->prepare("UPDATE applications SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $app_id);
$stmt->execute();

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;