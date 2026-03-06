<?php
include("db.php");

if(isset($_POST['search'])){

    $search = mysqli_real_escape_string($conn, $_POST['search']);

    if($search == ""){
        exit();
    }

    $query = "SELECT * FROM jobs 
              WHERE title LIKE '%$search%' 
              OR company LIKE '%$search%' 
              OR location LIKE '%$search%' 
              OR description LIKE '%$search%'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_assoc($result)){
?>
        <div class="job-card">
            <h3><?php echo $row['title']; ?></h3>

            <p><b>Company:</b> <?php echo $row['company']; ?></p>
            <p><b>Location:</b> <?php echo $row['location']; ?></p>
            <p><b>Salary:</b> ₹<?php echo $row['salary']; ?></p>

            <p style="margin-top:8px;color:#555;">
                <?php echo substr($row['description'], 0, 120); ?>...
            </p>

            <a href="apply_job.php?id=<?php echo $row['id']; ?>" class="apply-btn">
                Apply Now
            </a>
        </div>
<?php
        }

    } else {
        echo "<p style='text-align:center;color:red;'>No jobs found</p>";
    }
}
?>