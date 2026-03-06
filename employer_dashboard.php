<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'employer'){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Employer Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Roboto',sans-serif;}
body{
    background: linear-gradient(120deg,#3b82f6,#2563eb);
    min-height:100vh;
}
.container{
    max-width:1200px;
    margin:auto;
    padding:30px;
    position:relative;
}
h1{
    color:white;
    text-align:center;
    font-size:2.5rem;
    margin-bottom:40px;
}

/* Logout Button */
.logout-btn {
    position: absolute;
    top:30px;
    right:30px;
    background:#ff4d4d;
    color:white;
    padding:10px 20px;
    border-radius:8px;
    text-decoration:none;
    font-weight:500;
    transition:0.3s;
}
.logout-btn:hover {
    background:#e60000;
}

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}
.card{
    background:#fff;
    padding:30px 20px;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.2);
    text-align:center;
    transition:0.3s;
}
.card:hover{
    transform: translateY(-10px);
    box-shadow:0 12px 35px rgba(0,0,0,0.3);
}
.card h3{
    font-size:1.5rem;
    margin-bottom:10px;
    color:#1e40af;
}
.card p{
    font-size:1rem;
    color:#555;
    margin-bottom:20px;
}
.btn{
    display:inline-block;
    padding:10px 20px;
    border-radius:8px;
    text-decoration:none;
    color:white;
    font-weight:500;
    transition:0.3s;
}
.btn.green{background:#16a34a;}
.btn.green:hover{background:#15803d;}
.btn.orange{background:#f97316;}
.btn.orange:hover{background:#c2410c;}
.btn.blue{background:#2563eb;}
.btn.blue:hover{background:#1e40af;}
</style>
</head>
<body>
<div class="container">
    <!-- Logout Button -->
    <a href="logout.php" class="logout-btn">Logout</a>

    <h1>Welcome, Employer 👋</h1>

    <div class="cards">
        <!-- Post Job -->
        <div class="card">
            <h3>Post Job</h3>
            <p>Create & publish a new job</p>
            <a href="add_job.php" class="btn green">Post Job</a>
        </div>

        <!-- My Jobs -->
        <div class="card">
            <h3>My Jobs</h3>
            <p>View jobs & applicants</p>
            <a href="my_jobs.php" class="btn orange">My Jobs</a>
        </div>

        <!-- My Profile -->
        <div class="card">
            <h3>My Profile</h3>
            <p>Update your profile information</p>
            <a href="employer_profile.php" class="btn green">My Profile</a>
        </div>
    </div>
</div>
</body>
</html>