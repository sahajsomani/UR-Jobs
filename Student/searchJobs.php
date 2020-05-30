<?php 
	session_start();
?>
<!DOCTYPE html>
<html>

<?php include('../head.php') ?>

<body>

<?php 
require_once('../db_setup.php');
include('nav.php'); 
?>


<div id="job-filter">
	<form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
		<div class="form-check form-check-inline">
			Flexible: 
			<input type="radio" name="flexible-filter" value="TRUE" style="margin-left: 5px; margin-right: 5px;" <?php if($_POST['flexible-filter']=='TRUE') echo 'checked'; ?>> yes
			<input type="radio" name="flexible-filter" value="FALSE" style="margin-left: 5px; margin-right: 5px;" <?php if($_POST['flexible-filter']=='FALSE') echo 'checked'; ?>> no
		</div>	
		<div style="margin-left: 5px; margin-right: 5px;">
			Location:
			<select name="location">
			<option value="URMC" <?php if($_POST['location']=='URMC') echo 'selected'; ?>>UR Medical Center</option>
			<option value="RC" <?php if($_POST['location']=='RC') echo 'selected'; ?>>River Campus</option>
			<option value="ESM" <?php if($_POST['location']=='ESM') echo 'selected'; ?>>Eastman School of Music</option>
			</select>
		</div>
		<div style="margin-left: 5px; margin-right: 5px;"> <input class="btn btn-primary" type="submit" name="filter" value="Filter"> </div>
		<button class="btn btn-primary" onclick="reloadPage()"> Clear </button>
	</form>
	<script>
		function reloadPage() {
			window.location.href = window.location.protocol +'//'+ window.location.host + window.location.pathname;
		}
	</script>
</div>

<?php
$currUser = $_SESSION['currUser'];

//code to get all the applications of the user
$sql_get_apps = "SELECT job_id from APPLIES_TO where net_id='$currUser';";
$get_apps = $conn->query($sql_get_apps);
$apps = array();
if($get_apps->num_rows >0){
	while ($res = $get_apps->fetch_assoc()){
		$apps[] = $res['job_id'];
	};
}

//code to get emp ratings
$sql_get_emp_reviews = "SELECT AVG(full_rating) as full_rating, emp_id from REVIEWS GROUP BY emp_id";
$emp_ratings_result = $conn->query($sql_get_emp_reviews);
$emp_ratings = array(); // employer id -> rating
while ($res = $emp_ratings_result -> fetch_assoc()) {
	$emp_ratings[$res['emp_id']] = number_format($res['full_rating'], 1);
}

//code to add to favorite from form (if any)
if(isset($_POST['fav'])) {
	$job_id = $_POST['job_id'];
	if($_POST['fav'] == "Favorite"){
		$sql_fav = "INSERT INTO FAVORITES (net_id, job_id) VALUES ('$currUser', '$job_id');";
		$res = $conn->query($sql_fav);	
		if($res != TRUE){
			echo $conn->error;
		}
		
	} else {
		$sql_fav = "DELETE FROM FAVORITES WHERE (net_id='$currUser' AND  job_id=$job_id);";
		$conn->query($sql_fav);	
	}
	
};

//code to get the favorites
$sql_favorites = "SELECT job_id from FAVORITES where net_id='$currUser'";
$sql_fav_results = $conn->query($sql_favorites);
$favorites = array();
if($sql_fav_results->num_rows >0){
	while ($res = $sql_fav_results->fetch_assoc()){
		$favorites[] = $res['job_id'];
	};
}


//code to get data from form
$sql = "SELECT job_id, emp_id, email, wage, post_date, title, location, description, IF(flexible, 'yes', 'no') flexible, hours_week, name FROM JOBS NATURAL JOIN EMPLOYERS";

if (isset($_POST['filter'])){ 
	$sql = "SELECT job_id, emp_id, email, wage, post_date, title, location, description, IF(flexible, 'yes', 'no') flexible, hours_week, name FROM JOBS NATURAL JOIN EMPLOYERS WHERE ";
	$where = "";
	
	if(isset($_POST['location'])) {
		$location = $_POST['location'];
		if (strlen($where) > 0) {
			$where .= " AND ";
		}
		$where .= "location = '$location'";
	}
	
	if(isset($_POST['flexible-filter'])){
		if (strlen($where) > 0) {
			$where .= " AND ";
		}
		if($_POST['flexible-filter'] == 'TRUE'){
			$where .= "flexible = TRUE";
		} 
		else {
			$where .= "flexible = FALSE";
		}
	}
	$sql .= $where . ";";
}
?>

<div id="view" class="section">

<?php
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
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<?php 
					//check if job is in favorite and display correct menu item
					if(!in_array($row['job_id'], $apps)){
				?>
						
						<a href="apply.php?job_id=<?php echo $row['job_id']?>" class="card-link" style="padding-right: 20px;">Apply</a>	
						<?php 
							//check if job is in favorite and display correct menu item
							if(in_array($row['job_id'], $favorites)){
						?>
								
								<input type="submit" name="fav" value="Unfavorite" style="border: none; color: #007bff;">
						<?php
							} else {
						?>
								<input type="submit" name="fav" value="Favorite" style="border: none; color: #007bff;">
						<?php
							}
						?>
				<?php

					} else {
				?>
						<span style="padding-right: 10px;"> <i>You have already applied to this job</i> </span><?php 
							//check if job is in favorite and display correct menu item
							if(in_array($row['job_id'], $favorites)){
						?>
								
								<input type="submit" name="fav" value="Unfavorite" style="border: none; color: #007bff;">
						<?php
							} else {
						?>
								<input type="submit" name="fav" value="Favorite" style="border: none; color: #007bff;">
						<?php
							}
						?>

				<?php
					}
				?>
				<input type="hidden" name="job_id" value="<?php echo $row['job_id']?>">
				</form>
			</div>
		</div>
	<?php } ?>

	</div>
<!-- if query fails -->
<?php 
		
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
?>
</div>
</body>

</html>
