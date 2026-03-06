<?php
session_start();
include 'db.php';

/* 🔐 ADMIN AUTH */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* 🗑 DELETE JOB */
if (isset($_GET['delete'])) {
    $job_id = intval($_GET['delete']);

    mysqli_query($conn, "DELETE FROM applications WHERE job_id=$job_id");
    mysqli_query($conn, "DELETE FROM jobs WHERE id=$job_id");

    header("Location: fake_jobs.php");
    exit;
}

/* 🚨 FETCH FAKE JOBS */
$fake_jobs = mysqli_query($conn, "
    SELECT jobs.id, jobs.title, jobs.location, jobs.salary, jobs.created_at,
           users.name AS employer_name
    FROM jobs
    LEFT JOIN users ON jobs.employer_id = users.id
    WHERE users.id IS NULL
       OR jobs.title = ''
       OR jobs.salary IS NULL
       OR jobs.salary = 0
    ORDER BY jobs.id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Fake Jobs | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    background: linear-gradient(120deg,#000428,#004e92);
    min-height:100vh;
}
.table{
    background:#fff;
    border-radius:12px;
    overflow:hidden;
}
.badge-fake{
    background:#dc3545;
}
</style>
</head>
<body>

<!-- 🔝 NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand fw-bold">🚨 Fake Jobs Detector</span>
    <div>
        <a href="admin_dashboard.php" class="btn btn-sm btn-light">Dashboard</a>
        <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
    </div>
</nav>

<div class="container py-5">

<div class="card shadow-lg p-4">
<h4 class="text-center mb-4">Suspicious / Fake Jobs</h4>

<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Job Title</th>
    <th>Employer</th>
    <th>Location</th>
    <th>Salary</th>
    <th>Status</th>
    <th width="120">Action</th>
</tr>
</thead>
<tbody>

<?php if (mysqli_num_rows($fake_jobs) > 0): ?>
<?php while($job = mysqli_fetch_assoc($fake_jobs)): ?>
<tr>
    <td><?= $job['id'] ?></td>
    <td><?= htmlspecialchars($job['title'] ?: 'N/A') ?></td>
    <td>
        <?= $job['employer_name'] 
            ? htmlspecialchars($job['employer_name']) 
            : '<span class="text-danger">Unknown</span>' ?>
    </td>
    <td><?= htmlspecialchars($job['location'] ?: 'N/A') ?></td>
    <td><?= htmlspecialchars($job['salary'] ?: 'N/A') ?></td>
    <td><span class="badge badge-fake">Fake</span></td>
    <td>
        <a href="?delete=<?= $job['id'] ?>"
           onclick="return confirm('Delete this fake job?')"
           class="btn btn-sm btn-danger">
           Delete
        </a>
    </td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
<td colspan="7" class="text-center text-muted">No fake jobs found 🎉</td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>

</div>
</div>

</body>
</html>