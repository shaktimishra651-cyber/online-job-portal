<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$q = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body{
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background:#f4f6fb;
}

/* Sidebar */
.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:230px;
    height:100%;
    background:#0d1b2a;
    padding-top:20px;
}

.sidebar h2{
    color:#fff;
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:#ddd;
    padding:12px 20px;
    text-decoration:none;
}

.sidebar a:hover{
    background:#1b263b;
    color:#fff;
}

/* Main */
.main{
    margin-left:230px;
    padding:20px;
}

.welcome{
    background:#fff;
    padding:15px 20px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
    margin-bottom:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* SEARCH */
.search-box{
    width:100%;
    margin-bottom:25px;
    display:flex;
    justify-content:center;
}

.search-box input{
    width:60%;
    padding:14px 20px;
    border-radius:30px;
    border:1px solid #ccc;
    font-size:16px;
    outline:none;
    transition:.3s;
    box-shadow:0 4px 10px rgba(0,0,0,.1);
}

.search-box input:focus{
    border-color:#4a6cf7;
    box-shadow:0 6px 15px rgba(74,108,247,.3);
}

/* Profile Card */
.profile{
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.profile h3{
    margin-bottom:15px;
}

.profile-grid{
    display:grid;
    grid-template-columns: repeat(3,1fr);
    gap:20px;
}

.profile p{
    background:#f4f6fb;
    padding:10px;
    border-radius:8px;
}

/* JOB CARD */
.job-card{
    background:#fff;
    padding:15px;
    margin:12px auto;
    width:80%;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.job-card h3{
    color:#4a6cf7;
}

.apply-btn{
    display:inline-block;
    margin-top:8px;
    padding:8px 18px;
    background:#4a6cf7;
    color:#fff;
    border-radius:20px;
    text-decoration:none;
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Job Portal</h2>
    <a href="#"><i class="fa fa-home"></i> Dashboard</a>
    <a href="view_jobs.php"><i class="fa fa-briefcase"></i> View Jobs</a>
    <a href="applied_jobs.php"><i class="fa fa-check"></i> Applied Jobs</a>
    <a href="edit_profile.php"><i class="fa fa-user"></i> Edit Profile</a>
    <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
</div>

<!-- Main -->
<div class="main">

    <div class="welcome">
        <h2>Welcome, <?php echo $user['name']; ?> 👋</h2>
        <span><?php echo $user['email']; ?></span>
    </div>

    <!-- SEARCH BAR -->
    <div class="search-box">
        <input type="text" id="jobSearch" placeholder="🔍 Search jobs by title, skill or company">
    </div>

    <!-- SEARCH RESULT -->
    <div id="searchResult"></div>

    <!-- USER PROFILE -->
    <div class="profile">
        <h3>User Profile</h3>
        <div class="profile-grid">
            <p><b>Name:</b> <?php echo $user['name']; ?></p>
            <p><b>Email:</b> <?php echo $user['email']; ?></p>
            <p><b>Mobile:</b> <?php echo $user['mobile']; ?></p>

            <p><b>Gender:</b> <?php echo $user['gender']; ?></p>
            <p><b>Skills:</b> <?php echo $user['skills']; ?></p>
            <p><b>Address:</b> <?php echo $user['address']; ?></p>
        </div>
    </div>

</div>

<!-- AJAX SEARCH -->
<script>
document.getElementById("jobSearch").addEventListener("keyup", function(){
    let keyword = this.value;

    let xhr = new XMLHttpRequest();
    xhr.open("POST","search_jobs.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xhr.onload = function(){
        if(this.status == 200){
            document.getElementById("searchResult").innerHTML = this.responseText;
        }
    }
    xhr.send("search="+keyword);
});
</script>

</body>
</html>