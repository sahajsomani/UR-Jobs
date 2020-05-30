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

<form style="padding: 10px 40px;" class="login-form signup-form-emp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

	<h1 style="margin: 10px;">Sign Up</h1>

	<div class="txtb">
		<input type="number" name="emp_id" required step="1" min=0>
		<span data-placeholder="Employer ID (number)"></span>
	</div>

	<div class="txtb">
		<input type="text" name="name" required maxlength="15">
		<span data-placeholder="Name (max 15 char)"></span>
	</div>

	<div class="txtb">
		<input type="tel" name="phone_number" pattern="[0-9]{10}">
		<span data-placeholder="Phone No (pattern 1234567890)"></span>
	</div>

	<div class="txtb">
		<input type="text" name="address" maxlength="30">
		<span data-placeholder="Address (max 30 char)"></span>
	</div>

	<div class="txtb">
		<input type="password" name="password" required maxlength="15">
		<span data-placeholder="Password (max 15 char)"></span>
	</div>

	<input style="transform: translateY(-10px);" type="submit" name="submit" class="logbtn" value="REGISTER!">

	<?php
		require_once('db_setup.php');

		if(isset($_POST['submit'])){ 
			$sql_add_emp = "INSERT INTO EMPLOYERS (emp_id, password, name";
			$emp_id = $_POST['emp_id'];
			$name = $_POST['name'];
			$password = $_POST['password'];

			$sql_val = ") VALUES ($emp_id, '$password', '$name'";

			if(isset($_POST['address'])){
				$address = $_POST['address'];
				$sql_add_emp .= ", address";
				$sql_val .= ", '$address'";
			}
			if(isset($_POST['phone_number'])){
				$phone_number = $_POST['phone_number'];
				$sql_add_emp .= ", phone_number";
				$sql_val .= ", $phone_number";
			}

			$sql_add_emp .= $sql_val . ");";
			$result = $conn->query($sql_add_emp);
			if($result == TRUE){
				//save employer emp_id in a session
				$_SESSION['emp_id'] = $emp_id;
				header("Location: Employer/myJobs.php"); 
			} else {
				echo "<span style='color:red;'> Error: " . $conn->error . "</span>";
			}
		}
	?>

	<p class="signup"><a href="employer_login.php"> Back to Login </a></p>

</form>

</body>
</html>
