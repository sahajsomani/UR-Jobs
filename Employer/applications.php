<!DOCTYPE html>
<html>

<?php 
    include('../head.php');
    require_once('../db_setup.php'); 

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
?>

<body>

<?php
    include('emp-nav.php');
?>

<div class="section">

<?php 
$job_id = $_GET['job_id'];
$sql_get_applications = "SELECT status, resume, net_id, first_name, last_name, class_year from APPLIES_TO natural join STUDENTS where job_id=$job_id";
$res = $conn -> query($sql_get_applications);
if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
?>

    <div class="box">
        <div class="box-head">
            <p><?php echo $row['first_name'] . " " . $row['last_name']; ?></p>	
        </div>
        <br>
        <div class="box-content">
            <!-- <p class="box-attr">Major: </p> -->
            <p class="box-attr">Class Year: <?php echo $row['class_year'] ?> </p>
        </div>
        <div class="button-holder">
        <?php
            if($row['resume'] != NULL){
        ?>
                <a target="_blank" href="resume.php?net_id=<?php echo $row['net_id'] ?>&job_id=<?php echo $job_id; ?>"> View Resume </a>
        <?php
            }

            if($row['status'] == "received"){
        ?>
                <a class="btn btn-primary" href="respondApplication.php?status=accepted&net_id=<?php echo $row['net_id'] ?>&job_id=<?php echo $job_id; ?>">Accept </a>
                <a class="btn btn-danger" href="respondApplication.php?status=rejected&net_id=<?php echo $row['net_id'] ?>&job_id=<?php echo $job_id; ?>">Reject</a>
        <?php    
            } else {
                echo "<span style='padding: 10px;'> Status: " . $row['status'] . "</span>";
            }
        ?>



        </div>
    </div>

<?php  
    }
} else {
    echo "No one has applied to this job yet.";
}
?>

</div>


</body>
</html>