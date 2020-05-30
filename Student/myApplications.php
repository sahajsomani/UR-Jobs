<?php 
	session_start();
?>
<!DOCTYPE html>
<html>

<!-- this file loads the header -->
<?php include('../head.php'); ?>

<body>

<!-- php for loading DB and nav-->
<?php
  require_once('../db_setup.php');

  //this part loads the nav bar
  include('nav.php'); 
?>

<br><br>

<div id="fav" class="section">

<?php
$currUser = $_SESSION['currUser'];

//code to get all the applications of the user
$sql_get_apps = "SELECT job_id, status from APPLIES_TO where net_id='$currUser';";
$get_apps = $conn->query($sql_get_apps);
$apps = array();
if($get_apps->num_rows >0){
	while ($res = $get_apps->fetch_assoc()){
		$apps[$res['job_id']] = $res['status'];
	};
}

//code to get emp ratings
$sql_get_emp_reviews = "SELECT AVG(full_rating) as full_rating, emp_id from REVIEWS GROUP BY emp_id";
$emp_ratings_result = $conn->query($sql_get_emp_reviews);
$emp_ratings = array(); // employer id -> rating
while ($res = $emp_ratings_result -> fetch_assoc()) {
	$emp_ratings[$res['emp_id']] = number_format($res['full_rating'], 1);
}


//code to unfavorite from form (if any)
if(isset($_POST['fav'])) {
	$job_id = $_POST['job_id'];
	$sql_fav = "DELETE FROM FAVORITES WHERE (net_id='$currUser' AND  job_id=$job_id);";
	$conn->query($sql_fav);	
};

//code to get data about JOBS that the user favorites
$sql = "SELECT job_id, emp_id, email, wage, post_date, title, location, description, IF(flexible, 'yes', 'no') flexible, name from EMPLOYERS NATURAL JOIN JOBS where job_id IN (SELECT job_id from APPLIES_TO where net_id='$currUser');";
$result = $conn->query($sql);
	if($result->num_rows > 0){
?>
	<div class="card-columns">

	<?php while($row = $result->fetch_assoc()) { ?>
		<div class="card">
			<h5 class="card-header">
				<?php echo $row['title']?>
			</h5>
			<div class="card-body">	
				<h5 class="card-title"> <?php echo $row['name'] . " (" . $emp_ratings[$row['emp_id']]; ?>/5)</h5>
				
				<p class="card-subtitle text-muted">Post Date: <?php echo $row['post_date']?></p>
				<p class="card-text">
					<strong> Wage: </strong> $<?php echo $row['wage']?> <br>
					<strong> Location:</strong>  <?php echo $row['location']?> <br>
					<strong> Flexible:</strong>  <?php echo $row['flexible']?> <br>
					<strong> Hours per week: </strong> <?php echo $row['hours_week']?> <br>
					<br>
					<?php echo $row['description']?>
				</p>
				<p> Application Status: <b><?php echo $apps[$row['job_id']] ?></b></p>
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<input type="hidden" name="job_id" value="<?php echo $row['job_id']?>">
				</form>
			</div>
		</div>
	<?php } ?>

	</div>
<!-- if query fails -->
<?php 
		
	} else {
		echo "<p> You have no favorites yet! Go to search jobs to favorite some jobs and they will show up here!</p>";
		//echo "Error: " . $sql . "<br>" . $conn->error;
	}
?>

</div>

</body>

</html>
