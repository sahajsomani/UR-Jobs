
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

?>