
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
<h1>Students</h1>
<h3>Password and netId not shown</h3>
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
$sql = "select * from STUDENTS;";
$result = $conn->query($sql);
if($result->num_rows > 0){

?>
   <table>
      <tr>
         <th>first name</th>
         <th>last name</th>
         <th>class year</th>
      </tr>
<?php

    while($row = $result->fetch_assoc()){

    ?>
        <tr>
            <td><?php echo $row['first_name']?></td>
            <td><?php echo $row['last_name']?></td>
            <td><?php echo $row['class_year']?></td>
        </tr>

    <?php
    }
} else {
    echo "Nothing to display";
}
?>

    </table>

<?php
$conn->close();

?>
</div>
</body>
</html>