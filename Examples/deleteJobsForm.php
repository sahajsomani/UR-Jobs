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
<h1>Delete Jobs</h1>
<h3>I have queried the available jobs for you :) </h3>

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

// Query:
$sql = "SELECT job_id, title FROM JOBS";
$result = $conn->query($sql);
if($result->num_rows > 0){
?>


<form action="deleteJobs.php" method="POST">
    Job Id: 
    <select name="job_id" required>
        <?php
            while($row = $result->fetch_assoc()){
        ?>
        <option value=<?php echo $row['job_id']?>><?php echo $row['job_id']?>: <?php echo $row['title']?></option>
        <?php
            }
        ?>
    </select>
    <br>
    <input type="submit"> 
</form>

<?php
}
?>

</div>
</body>
</html>