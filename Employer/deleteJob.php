<!DOCTYPE html>
<html>

<?php 
    include('../head.php');
    require_once('../db_setup.php');
?>

<body>
<?php

include('emp-nav.php');


$job_id = $_GET['job_id'];

$sql = "DELETE from JOBS where job_id=$job_id;";
$res = $conn -> query($sql);

if($res == TRUE){
    header("Location: myJobs.php");
} else {
    //this should never happen...
    echo $conn->error;
}



?>
</body>
</html>