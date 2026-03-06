<?php
session_start();
include "db.php";

/* 🔐 Only USER allowed */
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
        }
        .job-card{
            border-radius:16px;
            transition:0.3s;
        }
        .job-card:hover{
            transform:translateY(-6px);
            box-shadow:0 12px 30px rgba(0,0,0,0.15);
        }
        .job-title{
            font-size:20px;
            font-weight:600;
            color:#0d6efd;
        }
        .job-info{
            font-size:14px;
            color:#555;
        }
        .apply-btn{
            border-radius:12px;
            font-weight:500;
        }
    </style>
</head>

<body>

<!-- Back to Dashboard -->
<a href="user_dashboard.php" class="back-btn">← Back to Dashboard</a>

<div class="container mt-5">

    <h3 class="text-center mb-4 text-primary">
        🌟 Available Jobs
    </h3>

    <div class="row">
        <?php
        $query = "SELECT * FROM jobs ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="col-md-4 mb-4">
            <div class="card job-card p-3">
                <div class="card-body">

                    <div class="job-title mb-2">
                        <?php echo $row['title']; ?>
                    </div>

                    <div class="job-info mb-1">
                        🏢 <b>Company:</b> <?php echo $row['company']; ?>
                    </div>

                    <div class="job-info mb-1">
                        📍 <b>Location:</b> <?php echo $row['location']; ?>
                    </div>

                    <div class="job-info mb-3">
                        💰 <b>Salary:</b> <?php echo $row['salary']; ?>
                    </div>

                    <!-- ✅ USER CAN ONLY APPLY -->
                    <a href="apply_job.php?job_id=<?php echo $row['id']; ?>"
                       class="btn btn-primary w-100 apply-btn">
                        🚀 Apply Job
                    </a>

                </div>
            </div>
        </div>
        <?php
            }
        } else {
        ?>
            <div class="text-center text-danger fw-bold">
                No jobs available right now
            </div>
        <?php } ?>
    </div>

</div>

</body>
</html>