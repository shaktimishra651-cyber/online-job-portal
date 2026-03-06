<?php
session_start();

/* Session destroy */
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logged Out | Job Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-card {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            animation: fadeIn 0.6s ease-in-out;
        }

        .logout-icon {
            font-size: 60px;
            color: #764ba2;
            margin-bottom: 15px;
        }

        h2 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            font-size: 14px;
        }

        .btn-login {
            margin-top: 20px;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 500;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: #fff;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }

        .redirect-text {
            margin-top: 15px;
            font-size: 13px;
            color: #888;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Auto redirect after 3 seconds -->
    <meta http-equiv="refresh" content="3;url=login.php">
</head>
<body>

    <div class="logout-card">
        <div class="logout-icon">👋</div>
        <h2>Logged Out Successfully</h2>
        <p>You have been safely logged out from the Job Portal.</p>

        <a href="login.php" class="btn-login">Go to Login</a>

        <div class="redirect-text">
            Redirecting to login page in 3 seconds...
        </div>
    </div>

</body>
</html>