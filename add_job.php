<?php
session_start();
include "db.php";

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $description = $_POST['description'];
    $employer_id = $_SESSION['user_id'];

    mysqli_query($conn, "
        INSERT INTO jobs 
        (title, company, location, salary, description, employer_id, created_at)
        VALUES 
        ('$title','$company','$location','$salary','$description','$employer_id',NOW())
    ");

    header("Location: employer_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Job</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<!-- Back to Dashboard -->
<a href="user_dashboard.php" class="back-btn">← Back to Dashboard</a>
<div class="container py-5">
<h3>Add New Job</h3>

<form method="post" class="bg-white p-4 rounded shadow">
    <input class="form-control mb-3" name="title" placeholder="Job Title" required>
    <input class="form-control mb-3" name="company" placeholder="Company Name" required>
    <input class="form-control mb-3" name="location" placeholder="Location">
    <input class="form-control mb-3" name="salary" placeholder="Salary">
    <textarea class="form-control mb-3" name="description" placeholder="Job Description"></textarea>
    <button name="submit" class="btn btn-primary">Post Job</button>
</form>
</div>

</body>
</html>