<?php
session_start();
require_once "db.php";

// Security check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    header("Location: login.php");
    exit;
}

$employer_id = $_SESSION['user_id'];

// Fetch employer jobs
$sql = "SELECT * FROM jobs WHERE employer_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(120deg, #fdfbfb, #ebedee); font-family: 'Segoe UI', sans-serif; min-height: 100vh; }
        .card { border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
        .table thead { background: #0d6efd; color: white; }
        .btn-sm { border-radius: 20px; padding: 4px 12px; margin-bottom: 3px; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card">
        <div class="card-header bg-primary text-white text-center fs-4">📋 My Posted Jobs</div>
        <div class="card-body">
            <?php if ($result->num_rows > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Location</th>
                                <th>Salary</th>
                                <th>Posted On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($row['title']); ?></td>
                                <td><?= htmlspecialchars($row['company']); ?></td>
                                <td><?= htmlspecialchars($row['location']); ?></td>
                                <td><?= htmlspecialchars($row['salary']); ?></td>
                                <td><?= date("d M Y", strtotime($row['created_at'])); ?></td>
                                <td>
                                    <!-- View Applicants -->
                                    <a href="view_applicants.php?job_id=<?= $row['id']; ?>" 
                                       class="btn btn-info btn-sm">Applicants</a>

                                    <!-- Edit Job -->
                                    <a href="edit_job.php?id=<?= $row['id']; ?>" 
                                       class="btn btn-warning btn-sm">Edit</a>

                                    <!-- Delete Job -->
                                    <a href="delete_job.php?id=<?= $row['id']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="alert alert-warning text-center">You have not posted any jobs yet.</div>
            <?php } ?>
        </div>
        <div class="card-footer text-center">
            <a href="employer_dashboard.php" class="btn btn-secondary">⬅ Back to Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>