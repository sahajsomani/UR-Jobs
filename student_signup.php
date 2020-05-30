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

<form style="margin-top: 80px; padding: 10px 40px; height: 650px;" class="login-form signup-form-std" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" onsubmit="return validateform();">
	<script>
		function validateform(){
			var majors = document.getElementById('major_list').value;
			var majors_list = majors.split(',');
			var valid = true;
			majors_list.forEach(function(major){
				if(major.length > 25){
					alert("each major needs to be under 25 characters");
					valid = false;
				}
			});
			return valid;
		}
	</script>
	<h1 style="margin: 20px;">Sign Up</h1>

	<div class="txtb">
		<input type="text" required name="first_name" maxlength="15">
		<span data-placeholder="First Name"></span>
	</div>

	<div class="txtb">
		<input type="text" required name="last_name" maxlength="15">
		<span data-placeholder="Last Name"></span>
	</div>
	
	<div class="txtb">
		<input type="text" required name="net_id" pattern="[0-9]{8}">
		<span data-placeholder="Net ID"></span>
	</div>

	<div class="txtb">
		<input type="password" required name="password" maxlength="20">
		<span data-placeholder="Password"></span>
	</div>

	<div class="txtb">
		<input type="text" maxlength="4" pattern="2[0-9]{3}" required name="class_year">
		<span data-placeholder="Class Year"></span>
	</div>

	<div class="txtb">
		<input type="text" name="major" id="major_list">
		<span data-placeholder="Major (comma separated)"></span>
	</div>

	<input type="submit" name="submit" class="logbtn" value="REGISTER!">

	<?php
		//net_id,first_name,last_name,class_year,password
		require_once('db_setup.php');

		if(isset($_POST['submit'])){ 
			$net_id = $_POST['net_id'];
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$class_year = $_POST['class_year'];
			$password = $_POST['password'];

			$sql_add_std = "INSERT INTO STUDENTS (net_id,first_name,last_name,class_year,password) VALUES ('$net_id','$first_name','$last_name',$class_year,'$password')";
			$result = $conn->query($sql_add_std);
			if($result == TRUE){

				if(isset($_POST['major'])){
					$majors_input = $_POST['major'];
					$majors_list = explode (',', $majors_input);
					foreach($majors_list as $major){
						$sql_insert_student_majors = "INSERT INTO STUDENT_MAJORS (net_id, major) VALUES ('$net_id', '$major')";
						$conn->query($sql_insert_student_majors);
					}
				}	
				//save net_id to session
				$_SESSION['currUser'] = $net_id;
				header("Location: Student/searchJobs.php"); 
			} else {
				echo "<span style='color:red;'> Error: " . $conn->error . "</span>";
			}
		}
	?>

	<p class="signup"><a href="student_login.php"> Back to Login </a></p>
</form>

</body>
</html>
