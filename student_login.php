<?php 
	session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet">

	<meta charset="utf-8">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>

	<title>
		UR JOBS
	</title>

<link rel="stylesheet" type="text/css" href="style.css">

<script type="text/javascript" src="app.js"></script>

</head>

<body>

<div class="header">
	<h1>UR JOBS</h1>
</div>

<!-- STUDENT FORMS -->

<form class="login-form student-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

	<h1 style="margin-bottom: 27px;">Login</h1>
	<p>Try "12345678" and "password123"</p>
	
	<div class="txtb">
		<input type="text" name="net_id">
		<span data-placeholder="Net ID"></span>
	</div>

	<div class="txtb">
		<input type="password" name="password">
		<span data-placeholder="Password"></span>
	</div>

	<input type="submit" class="logbtn" value="Login" name="submit">

	<p class="signup">
		Don't have an account? <a href="student_signup.php" class="signup-std ">Sign Up.</a>
		<br>
		Login as a <a href="employer_login.php" class="signup-std">Employer</a> instead
	</p>

	<!-- php to validate login -->
	<?php
		require('db_setup.php');
		$net_id = $_POST['net_id'];
		$password = $_POST['password'];

		if(isset($_POST['submit'])){ 
			$sql_get_std = "SELECT net_id from STUDENTS WHERE password='$password' AND net_id='$net_id';";
			$result = $conn->query($sql_get_std);
			if($result->num_rows > 0){
				//save netid to session
				$_SESSION['currUser'] = $net_id;
				header("Location: Student/searchJobs.php"); 
			} else {
				echo "<span style='color:red;'> Something went wrong, please check your credentials </span>";
			}
		}
	?>

</form>

</body>
</html>
