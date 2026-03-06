<?php
session_start();
require_once "db.php";

// 🔐 User login check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user'){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 🔎 Job ID validate
if(!isset($_GET['job_id'])){
    die("<div style='padding:20px;text-align:center;color:red;font-weight:bold;'>Job ID missing. Please apply from job listing.</div>");
}

$job_id = (int)$_GET['job_id'];

// 🔍 Check if user already applied
$sql_check = "SELECT * FROM applications WHERE job_id=? AND user_id=?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $job_id, $user_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if($result_check->num_rows > 0){
    $message = "⚠️ You have already applied for this job!";
} else {
    // ✅ Insert application
    $sql = "INSERT INTO applications (job_id, user_id, status) VALUES (?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $job_id, $user_id);
    if($stmt->execute()){
        $message = "🎉 Your application has been submitted successfully!";
    } else {
        $message = "❌ Something went wrong. Please try again later.";
    }
}

// 🔹 Optional: fetch job details for display
$sql_job = "SELECT * FROM jobs WHERE id=?";
$stmt_job = $conn->prepare($sql_job);
$stmt_job->bind_param("i", $job_id);
$stmt_job->execute();
$job_result = $stmt_job->get_result();
$job = $job_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Apply Job</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: linear-gradient(120deg, #fdfbfb, #ebedee);
        font-family: 'Segoe UI', sans-serif;
        min-height: 100vh;
        display:flex;
        justify-content:center;
        align-items:center;
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        max-width:550px;
        width:100%;
    }
    .card-header {
        font-size: 1.5rem;
        font-weight: bold;
        text-align:center;
    }
    .btn-back {
        border-radius:20px;
        padding:8px 20px;
        margin-top:15px;
    }
    .job-info {
        text-align:left;
        margin-bottom:15px;
    }
</style>
</head>
<body>
<div class="card">
    <div class="card-header bg-primary text-white">
        Apply Job
    </div>
    <div class="card-body text-center">

        <?php if($job){ ?>
        <div class="job-info">
            <h5><strong>Job Title:</strong> <?= htmlspecialchars($job['title']); ?></h5>
            <p><strong>Company:</strong> <?= htmlspecialchars($job['company']); ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($job['location']); ?></p>
            <p><strong>Salary:</strong> <?= htmlspecialchars($job['salary']); ?></p>
        </div>
        <?php } ?>

        <p style="font-size:1.2rem; font-weight:bold;"><?= $message; ?></p>

        <a href="view_jobs.php" class="btn btn-secondary btn-back">⬅ Back to Jobs</a>
    </div>
</div>
</body>
</html>