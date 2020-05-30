
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
<h1>Jobs</h1>
<h3>Horizontal scroll to view the whole table</h3>
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
$sql = "SELECT job_id, emp_id, email, wage, post_date, title, location, description, IF(flexible, 'yes', 'no') flexible, hours_week FROM JOBS";
$result = $conn->query($sql);
if($result->num_rows > 0){

?>
<div style="overflow-x:auto;">
   <table>
      <tr>
         <th>Job ID</th>
         <th>Employer ID</th>
         <th>Email</th>
         <th>Wage</th>
         <th>Post Date</th>
         <th>Title</th>
         <th>Location</th>
         <th>Description</th>
         <th>Flexible?</th>
         <th>Hours Per Week</th>
      </tr>
<?php

    while($row = $result->fetch_assoc()) {
        //job_id,emp_id,email,wage,post_date,title,location,description,flexible,hours_week
    ?>
        <tr>
            <td><?php echo $row['job_id']?></td>
            <td><?php echo $row['emp_id']?></td>
            <td><?php echo $row['email']?></td>
            <td><?php echo '$'.$row['wage']?></td>
            <td><?php echo $row['post_date']?></td>
            <td><?php echo $row['title']?></td>
            <td><?php echo $row['location']?></td>
            <td><?php echo $row['description']?></td>
            <td><?php echo $row['flexible']?></td>
            <td><?php echo $row['hours_week']?></td>
        </tr>

    <?php
    }
} else {
    echo "Nothing to display";
}
?>

    </table>
</div>

<?php
$conn->close();

?>
</div>
</body>
</html>