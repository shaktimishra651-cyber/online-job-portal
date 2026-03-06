<?php
session_start();
include "db.php";

/* Only employer can access */
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'employer'){
    header("Location: login.php");
    exit;
}

$employer_id = $_SESSION['user_id'];

$query = "SELECT * FROM jobs WHERE employer_id='$employer_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Employer - My Jobs</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#eef2f7;}
.job-card{border-radius:16px;transition:0.3s;box-shadow:0 8px 22px rgba(0,0,0,0.1);}
.job-card:hover{transform:translateY(-6px);box-shadow:0 15px 35px rgba(0,0,0,0.15);}
.job-title{font-size:20px;font-weight:600;color:#0d6efd;}
.job-info{font-size:14px;color:#555;}
.btn-custom{border-radius:12px;font-size:14px;font-weight:500;}
</style>
</head>
<body>
<div class="container mt-5">
<h3 class="text-center mb-4 text-primary">🏢 My Posted Jobs</h3>
<div class="row">
<?php if(mysqli_num_rows($result) > 0){ 
while($row = mysqli_fetch_assoc($result)){ ?>
<div class="col-md-6 mb-4">
<div class="card job-card p-3">
<div class="card-body">
<div class="job-title mb-2"><?php echo $row['title']; ?></div>
<div class="job-info mb-1"><b>Company:</b> <?php echo $row['company']; ?></div>
<div class="job-info mb-1"><b>Location:</b> <?php echo $row['location']; ?></div>
<div class="job-info mb-1"><b>Salary:</b> <?php echo $row['salary']; ?></div>
<div class="job-info mb-1"><b>Description:</b> <?php echo $row['description']; ?></div>
<div class="job-info mb-1"><b>Created:</b> <?php echo date("d M Y", strtotime($row['created_at'])); ?></div>
<div class="job-info mb-1"><b>Fake:</b> <?php echo $row['is_fake'] ? 'Yes' : 'No'; ?></div>

<!-- 🔹 Correct Link -->
<a href="view_applicants.php?job_id=<?php echo $row['id']; ?>" class="btn btn-success w-100 btn-custom">👥 view Applicants</a>

</div>
</div>
</div>
<?php } } else { ?>
<div class="text-center text-danger fw-bold">No jobs posted yet</div>
<?php } ?>
</div>
</div>
</body>
</html>