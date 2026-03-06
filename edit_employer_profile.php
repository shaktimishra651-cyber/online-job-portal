<?php
session_start();
include "db.php";

if (!isset($_SESSION['employer_id'])) {
    header("Location: login.php");
    exit;
}

$employer_id = $_SESSION['employer_id'];

// Fetch employer data
$sql = "SELECT * FROM employer WHERE id='$employer_id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

// Update profile
if (isset($_POST['update_profile'])) {

    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
    $gender    =$_POST['gender'];
    $company   = $_POST['company'];
    $location  = $_POST['location'];
    $phone     = $_POST['phone'];

    $update = "UPDATE employer SET 
                full_name='$full_name',
                email='$email',
                gender='$gender',
                company='$company',
                location='$location',
                phone='$phone'
              WHERE id='$employer_id'";

    if (mysqli_query($conn, $update)) {
        header("Location: edit_employer_profile.php?success=1");
        exit;
    } else {
        $error = "Profile update failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Employer Profile</title>
<style>
body{
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#667eea,#764ba2);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
.card{
    background:#fff;
    width:420px;
    padding:30px;
    border-radius:16px;
    box-shadow:0 25px 50px rgba(0,0,0,0.25);
    animation: fadeIn 0.5s ease-in-out;
}
h2{
    text-align:center;
    margin-bottom:20px;
    color:#333;
}
input{
    width:100%;
    padding:12px;
    margin-bottom:14px;
    border-radius:8px;
    border:1px solid #ddd;
    font-size:14px;
}
button{
    width:100%;
    padding:12px;
    background:#667eea;
    color:white;
    font-size:16px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}
button:hover{
    background:#5a67d8;
}
.success{
    background:#e6fffa;
    color:#065f46;
    padding:10px;
    border-radius:6px;
    text-align:center;
    margin-bottom:15px;
}
.error{
    background:#fee2e2;
    color:#991b1b;
    padding:10px;
    border-radius:6px;
    text-align:center;
    margin-bottom:15px;
}
@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}
</style>
</head>

<body>

<div class="card">
    <h2>Edit Employer Profile</h2>

    <?php if(isset($_GET['success'])){ ?>
        <div class="success">Profile updated successfully!</div>
    <?php } ?>

    <?php if(isset($error)){ ?>
        <div class="error"><?= $error ?></div>
    <?php } ?>

    <form method="post">
        <input type="text" name="full_name" placeholder="Full Name" 
               value="<?= $data['full_name'] ?>" required>

        <input type="email" name="email" placeholder="Email" 
               value="<?= $data['email'] ?>" required>

        <input type="text" name="gender" placeholder="gender" 
              value="<?= $data['gender'] ?>" required>
      

        <input type="text" name="company" placeholder="Company Name" 
               value="<?= $data['company'] ?>" required>

        <input type="text" name="location" placeholder="Location" 
               value="<?= $data['location'] ?>" required>


        <input type="text" name="phone" placeholder="Phone Number" 
               value="<?= $data['phone'] ?>" required>

        <button type="submit" name="update_profile">Update Profile</button>
    </form>
</div>

</body>
</html>