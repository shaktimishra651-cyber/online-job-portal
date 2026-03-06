<?php
session_start();
include 'db.php';

/* 🔐 ADMIN AUTH CHECK */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* ✅ JOB ID CHECK */
if (!isset($_GET['id'])) {
    header("Location: manage_jobs.php");
    exit;
}

$job_id = intval($_GET['id']);

/* 🗑 DELETE APPLICATIONS FIRST */
mysqli_query($conn, "DELETE FROM applications WHERE job_id = $job_id");

/* 🗑 DELETE JOB */
mysqli_query($conn, "DELETE FROM jobs WHERE id = $job_id");

/* 🔁 REDIRECT BACK */
header("Location: manage_jobs.php");
exit;