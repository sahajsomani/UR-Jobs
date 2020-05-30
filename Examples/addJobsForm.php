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
$sql = "SELECT emp_id, name FROM EMPLOYERS";
$result = $conn->query($sql);
if($result->num_rows > 0){
?>


<form action="addJobs.php" method="POST">
<!-- job_id,emp_id,email,wage,post_date,title,location,description,flexible,hours_week -->
    Employer Id: 
    <select name="emp_id" style="width: 100px;" required>
        <?php
            while($row = $result->fetch_assoc()){
        ?>
        <option value=<?php echo $row['emp_id']?>><?php echo $row['name']?></option>
        <?php
            }
        ?>
    </select>
    <br>

    Email: <input type="email" name="email" required><br>
    Wage: <input type="number" name="wage" required min="9" max="100" step=".01"><br>
    Title: <input type="text" name="title" required><br>
    Location: 
    <select name="location" required style="width: 100px;">
        <option value="URMC">UR Medical College</option>
        <option value="RC">River Campus</option>
        <option value="ESM">Eastman School of Music</option>
    </select>
    <br>
    Description: <input type="textarea" rows="4" cols="50" name="description"><br>
    Flexible: <input type="radio" name="flexible" value="TRUE" required><br>
    Hours_Week: <input type="number" name="hours_week" min="0" max="20" required><br>

    <input type="submit"> 
</form>

<?php
} else {
    echo "You cannot add jobs at this time.";
}
?>

</div>
</body>
</html>