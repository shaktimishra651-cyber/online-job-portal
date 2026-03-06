<?php
session_start();
require_once "db.php";

// Security check: Only admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

if(isset($_GET['id']) && isset($_GET['status'])) {
    $job_id = intval($_GET['id']);
    $status = $_GET['status'];

    // Convert status to 0/1 for is_fake column
    if($status == 'fake'){
        $is_fake = 1;
    } else {
        $is_fake = 0;
    }

    $sql = "UPDATE jobs SET is_fake=$is_fake WHERE id=$job_id";
    if(mysqli_query($conn, $sql)){
        header("Location: admin_view_jobs.php");
        exit;
    } else {
        echo "Error updating job: ".mysqli_error($conn);
    }
}
?>