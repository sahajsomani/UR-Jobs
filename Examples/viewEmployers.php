
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
<h1>Employers</h1>
<h3>Password not shown</h3>
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
$sql = "SELECT * FROM EMPLOYERS";
$result = $conn->query($sql);
if($result->num_rows > 0){

?>
<div style="overflow-x:auto;">
   <table>
      <tr>
         <th>Employer ID</th>
         <th>Name</th>
         <th>Address</th>
         <th>Phone Number</th>
      </tr>
<?php

    while($row = $result->fetch_assoc()){
        //emp_id,password,name,address,phone_number
    ?>
        <tr>
            <td><?php echo $row['emp_id']?></td>
            <td><?php echo $row['name']?></td>
            <td><?php echo $row['address']?></td>
            <td><?php echo $row['phone_number']?></td>
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