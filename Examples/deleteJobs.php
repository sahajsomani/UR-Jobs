
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <title>CSC 261 Milestone 3</title>
</head>
<body>
<div id="container">
<div id="nav"><a href="index.html">Back</a></div>
<h1>Add Student</h1>

<?php

$servername = "localhost";
$username = "sbose5";
$password = "xTYE8KqM";
$dbname = "sbose5_1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

// Query:
$job_id = $_POST['job_id'];
$sql = "DELETE FROM JOBS WHERE job_id = $job_id;";

$result = $conn->query($sql);
if($result == TRUE){
    echo "Job has been deleted";
?>

<a href="viewJobs.php">View Jobs</a>

<?php
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>

    </table>

<?php
$conn->close();

?>
</div>
</body>
</html>