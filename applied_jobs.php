<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "
SELECT 
    jobs.title,
    jobs.company,
    jobs.location,
    jobs.salary,
    jobs.description,
    applications.applied_at
FROM applications
INNER JOIN jobs ON applications.job_id = jobs.id
WHERE applications.user_id = ?
ORDER BY applications.applied_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Applied Jobs</title>
    <style>
        body{
            margin:0;
            font-family: Arial;
            background: linear-gradient(120deg,#1e3c72,#2a5298);
        }
        .container{
            max-width:1000px;
            margin:40px auto;
            background:#fff;
            padding:25px;
            border-radius:12px;
            box-shadow:0 10px 30px rgba(0,0,0,.2);
        }
        h2{
            text-align:center;
            margin-bottom:20px;
            color:#2a5298;
        }
        .job{
            border:1px solid #ddd;
            padding:18px;
            border-radius:10px;
            margin-bottom:15px;
            transition:.3s;
        }
        .job:hover{
            transform:scale(1.01);
            box-shadow:0 5px 15px rgba(0,0,0,.15);
        }
        .job h3{
            margin:0;
            color:#1e3c72;
        }
        .meta{
            font-size:14px;
            color:#555;
            margin:5px 0;
        }
        .desc{
            margin-top:8px;
            color:#333;
        }
        .date{
            margin-top:8px;
            font-size:13px;
            color:green;
        }
        .back{
            display:inline-block;
            margin-bottom:15px;
            text-decoration:none;
            background:#2a5298;
            color:white;
            padding:8px 14px;
            border-radius:6px;
        }
        .empty{
            text-align:center;
            padding:30px;
            color:red;
            font-weight:bold;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="user_dashboard.php" class="back">← Dashboard</a>
    <h2>My Applied Jobs</h2>

    <?php if($result->num_rows > 0){ ?>
        <?php while($row = $result->fetch_assoc()){ ?>
            <div class="job">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <div class="meta">
                    <?= htmlspecialchars($row['company']) ?> |
                    <?= htmlspecialchars($row['location']) ?> |
                    ₹<?= htmlspecialchars($row['salary']) ?>
                </div>
                <div class="desc">
                    <?= htmlspecialchars($row['description']) ?>
                </div>
                <div class="date">
                    Applied on: <?= date("d M Y", strtotime($row['applied_at'])) ?>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="empty">You have not applied to any jobs yet.</div>
    <?php } ?>
</div>

</body>
</html>