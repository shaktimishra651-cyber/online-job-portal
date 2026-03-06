<?php
include "db.php";

// Agar id set hai to fetch karo job details
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM jobs WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $job = mysqli_fetch_assoc($result);
}

// Agar form submit hua hai to update karo
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $description = $_POST['description'];

    $update_sql = "UPDATE jobs SET 
                    title='$title',
                    company='$company',
                    location='$location',
                    salary='$salary',
                    description='$description'
                   WHERE id='$id'";

    if(mysqli_query($conn, $update_sql)){
        header("Location: my_jobs.php?updated=1");
    } else {
        echo "Update failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f4f6f9">

<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Job</h2>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow">
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $job['id']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Job Title</label>
                        <input type="text" class="form-control" name="title" value="<?= $job['title']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company</label>
                        <input type="text" class="form-control" name="company" value="<?= $job['company']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" value="<?= $job['location']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Salary</label>
                        <input type="text" class="form-control" name="salary" value="<?= $job['salary']; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4" required><?= $job['description']; ?></textarea>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary w-100">Update Job</button>
                    <a href="my_jobs.php" class="btn btn-secondary w-100 mt-2">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>