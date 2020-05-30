<?php 
    require_once('../db_setup.php');
    $job_id = $_GET['job_id'];
    $net_id = $_GET['net_id'];

    $sql = "SELECT resume from APPLIES_TO where job_id=$job_id and net_id=$net_id;";
    $res = $conn -> query($sql);

    if($res->num_rows >0){
        $resume = $res->fetch_assoc()['resume'];
        echo "<iframe src=\"data:application/pdf;base64,";
        echo $resume;
        echo "\" height=\"100%\" width=\"100%\"></iframe>";
    } else {
        //this should never happen...
        header("Content-Type: text/plain");
        echo $conn->error;
    }
?>
