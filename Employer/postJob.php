<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<!-- bootstrap cdn and stuff -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet">
	<!-- -------------------------------------------- -->
	
	<script type="text/javascript" src="../app.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet">

	<meta charset="utf-8">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>

	<title>
		UR JOBS
	</title>

<link rel="stylesheet" type="text/css" href="../style.css">

<link rel="stylesheet" type="text/css" href="../substyle.css">

</head>

<body>
<?php
	include("emp-nav.php");
	require_once('../db_setup.php');

	// Query:
	//job_id,emp_id,email,wage,post_date,title,location,description,flexible,hours_week
	if(isset($_POST['submit'])){
		$emp_id = $_SESSION['emp_id'];
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

		$sql_insert_into_jobs = "INSERT INTO JOBS (emp_id, email, wage, post_date, title, location, description, flexible, hours_week) values ('$emp_id', '$email', $wage, '$post_date', '$title', '$location', '$description', '$flexible', $hours_week);";

		$result = $conn->query($sql_insert_into_jobs);
		if($result == TRUE){
			header("Location: myJobs.php");
			//echo "New JOB created successfully!";
		} else {
			echo "Error: " . $sql_insert_into_jobs . "<br>" . $conn->error;
		}
	}
?>

<div class="section">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="form">
<h1>Post Job</h1>
<!-- job_id,emp_id,email,wage,post_date,title,location,description,flexible,hours_week -->
	<div class="txtb">
		<!-- added name = mgmt_rating -->
		<input type="email" name="email" required maxlength="30" placeholder="Contact Email">
	</div>	
	<div class="txtb">
		<!-- added name = mgmt_rating -->
		<input type="number" name="wage" required min="9" max="100" step=".01" placeholder="Wage">
	</div>
	<div class="txtb">
		<input type="text" name="title" required maxlength="30" placeholder="Title">
	</div>
	
	<div class="txtb">
		<input type="number" name="hours_week" min="0" max="20" step="1" required placeholder="Hours per Week">
	</div>

	<div style="padding: 10px 0;">
		Location: 
		<select name="location" required style="width: 100%;">
			<option value="URMC">UR Medical College</option>
			<option value="RC">River Campus</option>
			<option value="ESM">Eastman School of Music</option>
		</select>
	</div>

	<div style="padding: 10px 0;">
		<textarea rows=5 cols=50 wrap="hard" style="width: 100%; overflow-wrap: break-word;" maxlength=250 name="description" pattern="[A-Za-z0-9 ]*" placeholder="Description"></textarea>
		<p style="margin: 0; font-size: 12px; text-align: right;">Max Characters: 250</p>
	</div>
    <div style="padding: 10px 0;">
		Flexible: <input type="checkbox" name="flexible" value="TRUE"><br>
	</div>
    <input type="submit" name="submit" class="btn btn-primary"> 
</form>
</div>

</body> 
</html>
