<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("location:login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {

    $mobile  = $_POST['mobile'];
    $gender  = $_POST['gender'];
    $skills  = $_POST['skills'];
    $address = $_POST['address'];

    if (!empty($_FILES['resume']['name'])) {

        $file_name = $_FILES['resume']['name'];
        $tmp_name  = $_FILES['resume']['tmp_name'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($ext == 'pdf') {

            if (!is_dir("resume_00")) {
                mkdir("resume_00", 0777, true);
            }

            $new_name = time() . "_" . $file_name;
            $path = "resume_00/" . $new_name;

            if (move_uploaded_file($tmp_name, $path)) {

                mysqli_query($conn, "UPDATE users SET
                    mobile='$mobile',
                    gender='$gender',
                    skills='$skills',
                    address='$address',
                    resume='$new_name'
                    WHERE id='$user_id'");
            }
        }
    } else {
        mysqli_query($conn, "UPDATE users SET
            mobile='$mobile',
            gender='$gender',
            skills='$skills',
            address='$address'
            WHERE id='$user_id'");
    }

    echo "<script>alert('Profile Updated Successfully');</script>";
}

$data = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profile</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
html, body{
    background-color: #ffd6e8 !important; /* LIGHT PINK */
    min-height: 100%;
}

/* Back Button */
.back-btn{
    display:inline-block;
    margin:20px;
    padding:10px 18px;
    background:#764ba2;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-weight:600;
}
.back-btn:hover{
    background:#5a3c8b;
}

/* Card Styling */
.card{
    background:#ffffff;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.profile-title{
    font-weight:600;
    color:#764ba2;
}

.btn-custom{
    background:#764ba2;
    color:white;
}
.btn-custom:hover{
    background:#5a3c8b;
}
</style>
</head>

<body>

<!-- Back to Dashboard -->
<a href="user_dashboard.php" class="back-btn">← Back to Dashboard</a>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="text-center profile-title mb-4">Edit Your Profile</h3>

                <form method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control"
                               value="<?php echo $row['mobile']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select</option>
                            <option value="Male" <?php if($row['gender']=="Male") echo "selected"; ?>>Male</option>
                            <option value="Female" <?php if($row['gender']=="Female") echo "selected"; ?>>Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Skills</label>
                        <input type="text" name="skills" class="form-control"
                               value="<?php echo $row['skills']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3" required><?php echo $row['address']; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Upload Resume (PDF)</label>
                        <input type="file" name="resume" class="form-control">
                        <?php if(!empty($row['resume'])){ ?>
                            <small class="text-success">Resume uploaded ✔</small>
                        <?php } ?>
                    </div>

                    <button type="submit" name="update_profile" class="btn btn-custom w-100">
                        Update Profile
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>