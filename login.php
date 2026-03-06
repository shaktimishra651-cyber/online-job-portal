<?php
session_start();
require_once "db.php";

$error = "";

if (isset($_POST['login'])) {

    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == "" || $password == "") {
        $error = "Please fill all fields";
    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $user = $result->fetch_assoc();
            $dbPassword = $user['password'];

            // ✅ BOTH PLAIN + HASH PASSWORD SUPPORT
            if (
                password_verify($password, $dbPassword) ||
                $password === $dbPassword
            ) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name']    = $user['name'];
                $_SESSION['role']    = $user['role'];

                // 🔁 Role based redirect
                if ($user['role'] === 'admin') {
                    header("Location: admin_dashboard.php");
                } elseif ($user['role'] === 'employer') {
                    header("Location: employer_dashboard.php");
                } else {
                    header("Location: user_dashboard.php");
                }
                exit;

            } else {
                $error = "Incorrect password";
            }

        } else {
            $error = "Account not found";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg,#141e30,#243b55);
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
}
.card{
    border-radius:22px;
    box-shadow:0 18px 35px rgba(0,0,0,0.4);
}
.card-header{
    background:#0d6efd;
    color:white;
    font-size:24px;
    text-align:center;
    font-weight:600;
    border-radius:22px 22px 0 0;
}
.form-control{
    border-radius:14px;
    padding:10px;
}
.btn-login{
    border-radius:20px;
    padding:10px;
    font-weight:600;
}
</style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="col-md-5">

        <div class="card">
            <div class="card-header">
                🔐 Job Portal Login
            </div>

            <div class="card-body p-4">

                <?php if ($error) { ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <form method="post">

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="login" class="btn btn-success btn-login">
                            Login
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <small>Don't have an account?</small>
                        <a href="register.php"> Register</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

</body>
</html>