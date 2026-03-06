<?php
session_start();
require_once "db.php";

// Admin session check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

// Fetch applications with job title from jobs table
$sql = "
SELECT 
    a.id AS application_id, 
    a.status, 
    a.applied_at,
    u.name AS user_name, 
    u.email AS user_email,
    j.title AS job_title
FROM applications a
JOIN users u ON a.user_id = u.id
JOIN jobs j ON a.job_id = j.id
ORDER BY a.applied_at DESC
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Manage Applications</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { font-family:'Segoe UI', sans-serif; background:#f4f6f9; padding:20px; }
.card { border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.1); }
.table thead { background:#0d6efd; color:#fff; }
.btn-sm { border-radius:20px; margin:2px; }
.status-pending { background:#ffc107; color:#000; border-radius:20px; padding:5px 12px; }
.status-accepted { background:#198754; color:#fff; border-radius:20px; padding:5px 12px; }
.status-rejected { background:#dc3545; color:#fff; border-radius:20px; padding:5px 12px; }
.btn-resume { border-radius:20px; padding:5px 12px; }
</style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white text-center fs-4">
            📝 Manage Applications
        </div>
        <div class="card-body">
            <?php if($result->num_rows > 0){ ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Applicant Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Applied On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; while($row = $result->fetch_assoc()){ ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['job_title']); ?></td>
                            <td><?= htmlspecialchars($row['user_name']); ?></td>
                            <td><?= htmlspecialchars($row['user_email']); ?></td>
                            <td>
                                <?php 
                                    if($row['status'] == 'pending') echo '<span class="status-pending">Pending</span>';
                                    elseif($row['status'] == 'accepted') echo '<span class="status-accepted">Accepted</span>';
                                    else echo '<span class="status-rejected">Rejected</span>';
                                ?>
                            </td>
                            <td><?= date("d M Y", strtotime($row['applied_at'])); ?></td>
                            <td>
                                <a href="admin_update_application.php?id=<?= $row['application_id']; ?>&status=accepted" class="btn btn-success btn-sm">Accept</a>
                                <a href="admin_update_application.php?id=<?= $row['application_id']; ?>&status=rejected" class="btn btn-danger btn-sm">Reject</a>
                                <a href="admin_update_application.php?id=<?= $row['application_id']; ?>&status=pending" class="btn btn-secondary btn-sm">Pending</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
                <div class="alert alert-warning text-center">No applications found.</div>
            <?php } ?>
        </div>
        <div class="card-footer text-center">
            <a href="admin_dashboard.php" class="btn btn-secondary">⬅ Back to Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>