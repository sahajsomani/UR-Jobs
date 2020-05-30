<?php 
	session_start();
?>
<!DOCTYPE html>
<html>

<?php include('../head.php') ?>

<body>

<?php 

include('emp-nav.php'); 
require_once('../db_setup.php');

//get all jobs posted by this employer
$emp_id = $_SESSION['emp_id'];
$sql = "SELECT job_id, emp_id, email, wage, post_date, title, location, description, IF(flexible, 'yes', 'no') flexible, hours_week FROM JOBS WHERE emp_id=$emp_id;";
$result = $conn->query($sql);
	if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
?>

<div>
  <div class="job-appl">
    <div class="job-title">
      <h2><?php echo $row['title']?></h2>
      <hr>
    </div>
    <div class="job-buttons">
      <a href="editJob.php?job_id=<?php echo $row['job_id'] ?>"><button>Edit</button></a>
      <a href="applications.php?job_id=<?php echo $row['job_id'] ?>"><button>Applications</button></a>
    </div>
  </div>
</div>

<?php 
    } //end of while
  } else { //end of if
    echo "You don't have any jobs posted yet! <a href='postJob.php'> Post </a> one now!";
    echo "Error: " .  $conn->error;
  } 
?>

</body>

</html>
