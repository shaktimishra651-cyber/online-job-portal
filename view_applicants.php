<?php
session_start();
require_once "db.php";

// Security: Only employer
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer'){
    header("Location: login.php");
    exit;
}

// Job ID check
if (!isset($_GET['job_id'])) {
    die("Job ID missing. Please open applicants from your jobs.");
}
$job_id = intval($_GET['job_id']);
$employer_id = $_SESSION['user_id'];

// Ensure this job belongs to the employer
$check = $conn->prepare("SELECT id FROM jobs WHERE id=? AND employer_id=?");
$check->bind_param("ii", $job_id, $employer_id);
$check->execute();
$check_result = $check->get_result();
if($check_result->num_rows==0){
    die("You do not have permission to view this job.");
}

// Fetch applicants
$sql = "
    SELECT 
        a.id AS application_id,
        a.status,
        u.name,
        u.email,
        u.mobile,
        u.address,
        u.resume
    FROM applications a
    JOIN users u ON a.user_id = u.id
    WHERE a.job_id = ?
    ORDER BY a.applied_at DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Applicants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(120deg, #89f7fe, #66a6ff); font-family: 'Segoe UI', sans-serif; min-height: 100vh; }
        .card { border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .table thead { background-color: #0d6efd; color: white; }
        .btn-resume { border-radius: 20px; padding: 5px 15px; margin-bottom:3px; }
        .status { padding: 6px 12px; border-radius: 20px; font-size: 13px; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card">
        <div class="card-header bg-primary text-white text-center fs-4">👨‍💼 Job Applicants List</div>
        <div class="card-body">
            <?php if ($result->num_rows > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Resume</th>
                                <th>Status / Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; while($row=$result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['mobile']); ?></td>
                                <td><?= htmlspecialchars($row['address']); ?></td>
                                <td>
                                    <?php if(!empty($row['resume'])){ ?>
                                        <a href="resume_00/<?= htmlspecialchars($row['resume']); ?>" target="_blank"
                                           class="btn btn-sm btn-primary btn-resume">View Resume</a>
                                    <?php } else { ?>
                                        <span class="text-danger">No Resume</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if($row['status']=='pending'){ ?>
                                        <a href="update_applicant_status.php?id=<?= $row['application_id']; ?>&status=accepted"
                                           class="btn btn-success btn-sm mb-1">Accept</a>
                                        <a href="update_applicant_status.php?id=<?= $row['application_id']; ?>&status=rejected"
                                           class="btn btn-danger btn-sm mb-1">Reject</a>
                                    <?php } elseif($row['status']=='accepted'){ ?>
                                        <span class="badge bg-success">Accepted</span>
                                    <?php } else { ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="alert alert-warning text-center">No applicants found for this job.</div>
            <?php } ?>
        </div>
        <div class="card-footer text-center">
            <a href="my_jobs.php" class="btn btn-secondary">⬅ Back to My Jobs</a>
        </div>
    </div>
</div>
</body>
</html>