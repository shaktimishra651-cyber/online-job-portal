<?php
session_start();
require_once "db.php";

// Admin session check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

// Fetch all users
$sql = "SELECT * FROM users ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Manage Users</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    font-family:'Segoe UI', sans-serif;
    background:#f4f6f9;
    padding:20px;
}
.card{
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}
.table thead{
    background:#0d6efd;
    color:#fff;
}
.btn-sm{
    border-radius:20px;
    margin:2px;
}
.badge-admin{ background:#6f42c1; }
.badge-employer{ background:#0d6efd; }
.badge-user{ background:#198754; }
.btn-resume{
    border-radius:20px;
    padding:5px 14px;
}
</style>
</head>

<body>
<div class="container">
<div class="card">

<div class="card-header bg-primary text-white text-center fs-4">
    👥 Manage Users
</div>

<div class="card-body">

<?php if($result->num_rows > 0){ ?>
<div class="table-responsive">
<table class="table table-bordered table-hover text-center align-middle">

<thead>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Mobile</th>
    <th>Address</th>
    <th>Skills</th>
    <th>Gender</th>
    <th>Resume</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>
<?php $i=1; while($row = $result->fetch_assoc()){ ?>

<tr>
<td><?= $i++; ?></td>
<td><?= htmlspecialchars($row['name']); ?></td>
<td><?= htmlspecialchars($row['email']); ?></td>

<td>
<?php
if($row['role']=='admin')
    echo '<span class="badge badge-admin">Admin</span>';
elseif($row['role']=='employer')
    echo '<span class="badge badge-employer">Employer</span>';
else
    echo '<span class="badge badge-user">User</span>';
?>
</td>

<td><?= htmlspecialchars($row['mobile']); ?></td>
<td><?= htmlspecialchars($row['address']); ?></td>
<td><?= htmlspecialchars($row['skills']); ?></td>
<td><?= htmlspecialchars($row['gender']); ?></td>

<!-- ✅ FIXED RESUME SECTION -->
<td>
<?php
$resumePath = "resume_00/".$row['resume'];

if(!empty($row['resume']) && file_exists($resumePath)){
?>
    <a href="<?= $resumePath ?>" target="_blank" class="btn btn-primary btn-sm btn-resume">
        <i class="bi bi-file-earmark-pdf"></i> View
    </a>
<?php } else { ?>
    <span class="text-danger">No Resume</span>
<?php } ?>
</td>

<td>
<a href="delete_user.php?id=<?= $row['id']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Are you sure you want to delete this user?');">
   <i class="bi bi-trash"></i> Delete
</a>
</td>

</tr>

<?php } ?>
</tbody>
</table>
</div>

<?php } else { ?>
<div class="alert alert-warning text-center">
    No users found.
</div>
<?php } ?>

</div>

<div class="card-footer text-center">
<a href="admin_dashboard.php" class="btn btn-secondary">
⬅ Back to Dashboard
</a>
</div>

</div>
</div>
</body>
</html>