<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('../db_setup.php');
    $status = $_GET['status'];
    $job_id = $_GET['job_id'];
    $net_id = $_GET['net_id'];

    $sql_update_status = "UPDATE APPLIES_TO set status='$status' where job_id=$job_id and net_id='$net_id';";
    $res = $conn->query($sql_update_status);

    if($res == TRUE){
        header("Location: applications.php?job_id=$job_id");
    } else {
        //it shouldn't come here...
        echo $conn->error;
    }

?>

