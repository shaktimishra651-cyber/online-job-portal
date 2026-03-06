<?php
session_start();
include "db.php";

$user_id = $_SESSION['user_id']; // login ke time set hona chahiye

if (isset($_POST['upload_resume'])) {

    if (!empty($_FILES['resume']['name'])) {

        $file_name = $_FILES['resume']['name'];
        $tmp_name  = $_FILES['resume']['tmp_name'];
        $error     = $_FILES['resume']['error'];

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($error == 0) {

            if ($ext == 'pdf') {

                $new_name = time() . "_" . $file_name;
                $path = "resume_00/" . $new_name;

                if (move_uploaded_file($tmp_name, $path)) {

                    $sql = "UPDATE users SET resume='$new_name' WHERE id='$user_id'";
                    mysqli_query($conn, $sql);

                    echo "<script>alert('Resume uploaded successfully');</script>";

                } else {
                    echo "File move failed";
                }

            } else {
                echo "Only PDF file allowed";
            }

        } else {
            echo "File upload error";
        }

    } else {
        echo "Please select a resume";
    }
}
?>