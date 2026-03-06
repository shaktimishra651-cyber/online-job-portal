<?php
session_start();
require_once "db.php";

// Security check: Only admin
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

// Fetch all jobs
$sql = "SELECT j.*, u.name AS employer_name 
        FROM jobs j 
        JOIN users u ON j.employer_id = u.id
        ORDER BY j.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Manage Jobs</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: linear-gradient(120deg, #fdfbfb, #ebedee);
        font-family: 'Segoe UI', sans-serif;
        min-height:100vh;
        padding:20px;
    }
    .card { border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
    .table thead { background: #0d6efd; color: #fff; }
    .btn-sm { border-radius: 20px; margin-bottom:3px; }
    .badge-real { background-color: #198754; }
    .badge-fake { background-color: #dc3545; }
</style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white text-center fs-4">
            📝 Manage Jobs
        </div>
        <div class="card-body">
            <?php if($result->num_rows > 0){ ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Location</th>
                            <th>Salary</th>
                            <th>Posted By</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; while($row=$result->fetch_assoc()){ ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['title']); ?></td>
                            <td><?= htmlspecialchars($row['company']); ?></td>
                            <td><?= htmlspecialchars($row['location']); ?></td>
                            <td><?= htmlspecialchars($row['salary']); ?></td>
                            <td><?= htmlspecialchars($row['employer_name']); ?></td>
                            <td>
                                <?php if($row['is_fake']==0){ ?>
                                    <span class="badge badge-real">Real</span>
                                <?php } else { ?>
                                    <span class="badge badge-fake">Fake</span>
                                <?php } ?>
                            </td>
                            <td>
                                <!-- Mark Real / Fake -->
                                <?php if($row['is_fake']==0){ ?>
                                    <a href="mark_fake_job.php?id=<?= $row['id']; ?>&status=fake" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to mark this job as Fake?');">Mark Fake</a>
                                <?php } else { ?>
                                    <a href="mark_fake_job.php?id=<?= $row['id']; ?>&status=real" 
                                       class="btn btn-success btn-sm"
                                       onclick="return confirm('Are you sure you want to mark this job as Real?');">Mark Real</a>
                                <?php } ?>

                                <!-- Edit Job -->
                                <a href="edit_job.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                                <!-- Delete Job -->
                                <a href="delete_job.php?id=<?= $row['id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>

                                <!-- View Applicants -->
                                <a href="view_applicants.php?job_id=<?= $row['id']; ?>" 
                                   class="btn btn-info btn-sm">Applicants</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
                <div class="alert alert-warning text-center">No jobs found.</div>
            <?php } ?>
        </div>
        <div class="card-footer text-center">
            <a href="admin_dashboard.php" class="btn btn-secondary">⬅ Back to Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>