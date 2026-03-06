<?php
include 'db.php';

$result = mysqli_query($conn,"SELECT * FROM jobs");
?>

<!DOCTYPE html>
<html>
<head>
<title>Verify Jobs</title>
</head>
<body>

<h2>Job Verification Panel</h2>

<?php
while($row=mysqli_fetch_assoc($result)){
?>
    <div style="border:1px solid black;margin:10px;padding:10px">
        <b><?php echo $row['title']; ?></b><br>
        Company: <?php echo $row['company']; ?><br>
        Location: <?php echo $row['location']; ?><br>
        Salary: <?php echo $row['salary']; ?><br>
        Current Status:
        <b style="color:<?php echo $row['is_fake'] ? 'red' : 'green'; ?>">
            <?php echo $row['is_fake'] ? 'Fake' : 'Real'; ?>
        </b>
        <br><br>

        <a href="update_job_status.php?id=<?php echo $row['id']; ?>&is_fake=0">
            ✅ Mark Real
        </a>
        |
        <a href="update_job_status.php?id=<?php echo $row['id']; ?>&is_fake=1">
            ❌ Mark Fake
        </a>
    </div>
<?php } ?>

</body>
</html>