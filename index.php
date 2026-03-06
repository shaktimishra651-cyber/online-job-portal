<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Online Job Portal</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.hero{
    background: linear-gradient(to right, #0d6efd, #198754);
    color:white;
    padding:80px 20px;
}
.feature-card{
    transition: 0.3s;
}
.feature-card:hover{
    transform: scale(1.05);
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
<a class="navbar-brand fw-bold" href="index.php">JobPortal</a>
<div>
<a href="login.php" class="btn btn-success me-2">Login</a>
<a href="register.php" class="btn btn-primary">Register</a>
</div>
</div>
</nav>

<!-- HERO SECTION -->
<section class="hero text-center">
<div class="container">
<h1 class="fw-bold">Find Genuine Jobs & Hire Talent</h1>
<p class="lead">A trusted platform for job seekers and employers</p>
</div>
</section>

<!-- FEATURES -->
<section class="container mt-5">
<div class="row text-center">

<div class="col-md-4">
<div class="card feature-card shadow p-4">
<h5>Fake Job Filter</h5>
<p>Admin removes fake job postings</p>
</div>
</div>

<div class="col-md-4">
<div class="card feature-card shadow p-4">
<h5>Resume Upload</h5>
<p>Upload and manage resumes easily</p>
</div>
</div>

<div class="col-md-4">
<div class="card feature-card shadow p-4">
<h5>Trusted Employers</h5>
<p>Verified employers only</p>
</div>
</div>

</div>
</section>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center p-3 mt-5">
© 2025 Online Job Portal Project
</footer>

</body>
</html>
