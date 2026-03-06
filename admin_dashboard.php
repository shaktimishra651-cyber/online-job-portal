<?php
session_start();
require_once "db.php";

// ✅ Only admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

// Fetch stats
$total_users = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='user'")->fetch_assoc()['count'];
$total_employers = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='employer'")->fetch_assoc()['count'];
$total_jobs = $conn->query("SELECT COUNT(*) as count FROM jobs")->fetch_assoc()['count'];
$total_pending_apps = $conn->query("SELECT COUNT(*) as count FROM applications WHERE status='pending'")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f4f6f9;
        min-height: 100vh;
    }
    .sidebar {
        height: 100vh;
        position: fixed;
        left:0;
        top:0;
        width:220px;
        background: linear-gradient(180deg, #0d6efd, #6610f2);
        color: #fff;
        padding-top: 20px;
    }
    .sidebar a {
        color:#fff;
        text-decoration:none;
        display:block;
        padding:10px 20px;
        margin:5px 0;
        border-radius:10px;
    }
    .sidebar a:hover {
        background: rgba(255,255,255,0.2);
    }
    .content {
        margin-left:240px;
        padding:20px;
    }
    .card {
        border-radius:15px;
        box-shadow:0 10px 20px rgba(0,0,0,0.1);
        margin-bottom:20px;
    }
    .card h3 {
        font-weight:bold;
    }
    .stats-icon {
        font-size:2.5rem;
    }
    .topbar {
        background:#fff;
        padding:10px 20px;
        border-radius:15px;
        margin-bottom:20px;
        box-shadow:0 5px 15px rgba(0,0,0,0.05);
        display:flex;
        justify-content:space-between;
        align-items:center;
    }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center mb-4">Admin Panel</h4>
    <a href="admin_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="admin_manage_users.php"><i class="bi bi-people"></i> Manage Users</a>
    <a href="admin_view_jobs.php"><i class="bi bi-briefcase"></i> Manage Jobs</a>
    <a href="admin_manage_applications.php"><i class="bi bi-file-text"></i> Manage Applications</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="content">
    <div class="topbar">
        <h5>Welcome, <?= htmlspecialchars($_SESSION['name']); ?></h5>
        <span><i class="bi bi-person-circle"></i> Admin</span>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center p-3">
                <i class="bi bi-people stats-icon text-primary"></i>
                <h3><?= $total_users; ?></h3>
                <p>Users</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <i class="bi bi-person-badge stats-icon text-success"></i>
                <h3><?= $total_employers; ?></h3>
                <p>Employers</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <i class="bi bi-briefcase stats-icon text-warning"></i>
                <h3><?= $total_jobs; ?></h3>
                <p>Jobs Posted</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <i class="bi bi-clock-history stats-icon text-danger"></i>
                <h3><?= $total_pending_apps; ?></h3>
                <p>Pending Applications</p>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row mt-4">
        <div class="col-md-4">
            <a href="admin_manage_users.php" class="btn btn-primary w-100 p-3 fs-5 mb-3">Manage Users</a>
        </div>
        <div class="col-md-4">
            <a href="admin_view_jobs.php" class="btn btn-success w-100 p-3 fs-5 mb-3">Manage Jobs</a>
        </div>
        <div class="col-md-4">
            <a href="admin_manage_applications.php" class="btn btn-warning w-100 p-3 fs-5 mb-3">Manage Applications</a>
        </div>
    </div>
</div>

</body>
</html>