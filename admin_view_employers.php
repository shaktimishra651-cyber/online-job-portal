<?php
session_start();
include 'db.php';

/* 🔐 ADMIN CHECK */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* 🗑 DELETE EMPLOYER */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $check = mysqli_query($conn, "SELECT role FROM users WHERE id=$id");
    $row = mysqli_fetch_assoc($check);

    if ($row && $row['role'] === 'employer') {
        mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    }
    header("Location: manageemployers.php");
    exit;
}

/* 📋 FETCH EMPLOYERS */
$employers = mysqli_query($conn,
    "SELECT id, name, email FROM users WHERE role='employer' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Employers | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    background: linear-gradient(120deg,#1d2671,#c33764);
    min-height:100vh;
}
.card{
    border-radius:16px;
}
.table{
    background:#fff;
    border-radius:12px;
    overflow:hidden;
}
</style>
</head>
<body>

<!-- 🔝 NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand fw-bold">🏢 Manage Employers</span>
    <div>
        <a href="admin_dashboard.php" class="btn btn-sm btn-light">Dashboard</a>
        <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
    </div>
</nav>

<div class="container py-5">

<div class="card shadow-lg p-4">
<h4 class="text-center mb-4">Registered Employers</h4>

<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th width="120">Action</th>
</tr>
</thead>
<tbody>

<?php if (mysqli_num_rows($employers) > 0): ?>
<?php while($e = mysqli_fetch_assoc($employers)): ?>
<tr>
    <td><?= $e['id'] ?></td>
    <td><?= htmlspecialchars($e['name']) ?></td>
    <td><?= htmlspecialchars($e['email']) ?></td>
    <td>
        <a href="?delete=<?= $e['id'] ?>"
           onclick="return confirm('Delete this employer?')"
           class="btn btn-sm btn-danger">
           Delete
        </a>
    </td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
<td colspan="4" class="text-center text-muted">No employers found</td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>

</div>
</div>

</body>
</html>