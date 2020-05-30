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

<form class="login-form emp-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

	<h1 style="margin-bottom: 27px;">Login</h1>
	<p>Try "1" and "hello_world" for the CS Department</p>
	
	<div class="txtb">
		<input type="text" name="emp_id">
		<span data-placeholder="Employee ID"></span>
	</div>

	<div class="txtb">
		<input type="password" name="password">
		<span data-placeholder="Password"></span>
	</div>

	<input type="submit" class="logbtn" name="submit" value="Login">

	<p class="signup">
		Don't have an account? <a href="employer_signup.php" class="signup-emp ">Sign Up.</a>
		<br>
		Login as a <a href="student_login.php" class="signup-emp">Student</a> instead
	</p>

	<?php
		require_once('db_setup.php');
		$emp_id = $_POST['emp_id'];
		$password = $_POST['password'];

		if(isset($_POST['submit'])){ 
			$sql_get_emp = "SELECT emp_id from EMPLOYERS where emp_id=$emp_id and password='$password';";
			$result = $conn->query($sql_get_emp);
			if($result->num_rows > 0){
				//save employer emp_id in a session
				$_SESSION['emp_id'] = $emp_id;
				header("Location: Employer/myJobs.php"); 
			} else {
				echo "<span style='color:red;'> Something went wrong, please check your credentials </span>";
			}
		}
	?>
</form>



</body>
</html>
