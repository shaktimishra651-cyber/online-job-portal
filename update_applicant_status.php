<?php
session_start();
require_once "db.php";

// Only employer
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer'){
    header("Location: login.php");
    exit;
}

if(isset($_GET['id']) && isset($_GET['status'])){
    $app_id = intval($_GET['id']);
    $status = $_GET['status'];

    // Ensure applicant belongs to employer's job
    $check = $conn->query("
        SELECT a.*, a.job_id 
        FROM applications a 
        JOIN jobs j ON a.job_id=j.id 
        WHERE a.id=$app_id AND j.employer_id=".$_SESSION['user_id']
    );
    if($check->num_rows==0){
        die("Permission denied.");
    }

    $job_id = $check->fetch_assoc()['job_id'];

    $sql = "UPDATE applications SET status='$status' WHERE id=$app_id";
    if(mysqli_query($conn, $sql)){
        header("Location: view_applicants.php?job_id=$job_id");
        exit;
    } else {
        die("Error: ".mysqli_error($conn));
    }
}
?>