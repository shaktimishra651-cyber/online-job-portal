<?php
session_start();
require_once "db.php";

$error = "";
$success = "";

if (isset($_POST['register'])) {

    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $mobile   = trim($_POST['mobile']);
    $address  = trim($_POST['address']);
    $role     = $_POST['role'];

    /* ===== ROLE SECURITY (Admin blocked) ===== */
    if ($role !== 'employer' && $role !== 'user') {
        $error = "Invalid role selected!";
    } else {

        // Email already exists check
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Email already registered!";
        } else {

            // Password hash (basic – enough for college project)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password, mobile, address, role)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param(
                "ssssss",
                $name,
                $email,
                $hashed_password,
                $mobile,
                $address,
                $role
            );

            if ($stmt->execute()) {
                $success = "Registration successful! Please login.";
            } else {
                $error = "Something went wrong. Try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#43cea2,#185a9d);
            min-height:100vh;
            font-family:'Segoe UI',sans-serif;
        }
        .register-card{
            border-radius:20px;
            box-shadow:0 15px 30px rgba(0,0,0,0.3);
        }
        .card-header{
            background:#0d6efd;
            color:#fff;
            text-align:center;
            font-size:22px;
            font-weight:600;
            border-radius:20px 20px 0 0;
        }
        .form-control, .form-select{
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

            <div class="card register-card">
                <div class="card-header">
                    📝 User Registration
                </div>

                <div class="card-body">

                    <?php if ($error) { ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>

                    <?php if ($success) { ?>
                        <div class="alert alert-success text-center">
                            <?php echo $success; ?>
                        </div>
                    <?php } ?>

                    <form method="post">

                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Mobile</label>
                            <input type="text" name="mobile" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Select Role</label>
                            <select name="role" class="form-select" required>
                                <option value="">-- Select Role --</option>
                                <option value="employer">Employer</option>
                                <option value="user">Job Seeker</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="register"
                                    class="btn btn-success btn-round">
                                Register
                            </button>

                            <a href="login.php"
                               class="btn btn-secondary btn-round ms-2">
                                Login
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