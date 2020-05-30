
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
<h1>Add Job</h1>

<?php

require_once('../db_setup.php');
// Query:
//job_id,emp_id,email,wage,post_date,title,location,description,flexible,hours_week
$emp_id = $_POST['emp_id'];
$email = $_POST['email'];
$wage = $_POST['wage'];
$post_date = date("Y-m-d H:i:s");
$title = $_POST['title'];
$location = $_POST['location'];
$description = $_POST['description'];

//Radio button has been set to "true"
if(isset($_POST['flexible']) && $_POST['flexible'] == 'true') $_POST['flexible'] = TRUE;
//Radio button has been set to "false" or a value was not selected
else $_POST['flexible'] = FALSE;
$flexible = $_POST['flexible'];

$hours_week = $_POST['hours_week'];

$sql = "INSERT INTO JOBS (emp_id, email, wage, post_date, title, location, description, flexible, hours_week) values ('$emp_id', '$email', $wage, '$post_date', '$title', '$location', '$description', '$flexible', $hours_week);";

$result = $conn->query($sql);
if($result == TRUE){
    echo "New JOB created successfully!";
?>

<a href="viewJobs.php">View All Jobs</a>

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