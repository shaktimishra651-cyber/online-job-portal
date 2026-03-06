<?php
session_start();
require_once "db.php";

/* ===== SECURITY CHECK ===== */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    header("Location: login.php");
    exit;
}

$employer_id = $_SESSION['user_id'];
$message = "";

/* ===== UPDATE PROFILE ===== */
if (isset($_POST['update_profile'])) {

    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $mobile  = $_POST['mobile'];
    $address = $_POST['address'];
    $gender  = $_POST['gender'];

    $update = $conn->prepare(
        "UPDATE users 
         SET name = ?, email = ?, mobile = ?, address = ?, gender = ? 
         WHERE id = ?"
    );
    $update->bind_param("sssssi", $name, $email, $mobile, $address, $gender, $employer_id);
    $update->execute();

    if ($update->affected_rows >= 0) {
        $message = "Profile updated successfully!";
    }
}

/* ===== FETCH PROFILE ===== */
$stmt = $conn->prepare(
    "SELECT name, email, mobile, address, gender 
     FROM users 
     WHERE id = ?"
);
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("User not found");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employer Profile</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#667eea,#764ba2);
            min-height:100vh;
            font-family:Segoe UI, sans-serif;
        }
        .profile-card{
            border-radius:20px;
            box-shadow:0 15px 30px rgba(0,0,0,0.3);
        }
        .profile-header{
            background:#0d6efd;
            color:#fff;
            padding:20px;
            font-size:22px;
            font-weight:600;
            text-align:center;
            border-radius:20px 20px 0 0;
        }
        .form-control{
            border-radius:12px;
        }
        .btn-round{
            border-radius:20px;
            padding:8px 25px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card profile-card">
                <div class="profile-header">
                    👤 Employer Profile
                </div>

                <div class="card-body">

                    <?php if ($message) { ?>
                        <div class="alert alert-success text-center">
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>

                    <form method="post">

                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Mobile</label>
                            <input type="text" name="mobile" class="form-control"
                                   value="<?php echo htmlspecialchars($user['mobile']); ?>">
                        </div>

                        <div class="mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="3"><?php
                                echo htmlspecialchars($user['address']);
                            ?></textarea>
                        </div>

                        <!-- Gender Dropdown -->
                        <div class="mb-3">
                            <label>Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?php if($user['gender']=='Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if($user['gender']=='Female') echo 'selected'; ?>>Female</option>
                                <option value="Other" <?php if($user['gender']=='Other') echo 'selected'; ?>>Other</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="update_profile"
                                    class="btn btn-success btn-round">
                                Update Profile
                            </button>

                            <a href="employer_dashboard.php"
                               class="btn btn-secondary btn-round ms-2">
                                Back
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>