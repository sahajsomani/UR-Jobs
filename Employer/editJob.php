<?php session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

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
            $job_id = $_POST['job_id'];
            $email = $_POST['email'];
            $wage = $_POST['wage'];
            $title = $_POST['title'];
            $location = $_POST['location'];
            $description = $_POST['description'];
    
            //Radio button has been set to "true"
            if(isset($_POST['flexible']) && $_POST['flexible'] == 'TRUE') $_POST['flexible'] = TRUE;
            //Radio button has been set to "false" or a value was not selected
            else $_POST['flexible'] = FALSE;
            $flexible = $_POST['flexible'];
    
            $hours_week = $_POST['hours_week'];
    
            $sql_update_jobs = "UPDATE JOBS SET email='$email', wage=$wage,  flexible='$flexible', title='$title', location='$location', description='$description' where job_id=$job_id;";
            
            $result = $conn->query($sql_update_jobs);
            if($result == TRUE){
                echo "JOB updated successfully!";
            } else {
                echo "Error: " . $sql_update_jobs . "<br>" . $conn->error;
            }
        }

    $job_id = $_GET['job_id'];
    $emp_id = $_SESSION['emp_id'];
    $sql_get_old_val = "SELECT email, wage, title, location, description, IF(flexible, 'yes', 'no') flexible, hours_week FROM JOBS WHERE emp_id=$emp_id and job_id=$job_id;";
    $get_old_val = $conn->query($sql_get_old_val);
    if($get_old_val->num_rows > 0){
        while($row = $get_old_val->fetch_assoc()){
?>
    <div class="section">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?job_id=<?php echo $job_id; ?>" method="POST" class="form">
    <h1>Edit Job</h1>
    <!-- job_id,emp_id,email,wage,post_date,title,location,description,flexible,hours_week -->
        <input type="hidden" name="job_id" value=<?php echo $_GET['job_id']?>>
        <div class="txtb">
            <!-- added name = mgmt_rating -->
            <input type="email" name="email" required maxlength="30" placeholder="Contact Email" value="<?php echo $row['email']?>">
        </div>	
        <div class="txtb">
            <!-- added name = mgmt_rating -->
            <input type="number" name="wage" required min="9" max="100" step=".01" placeholder="Wage" value="<?php echo $row['wage']?>">
        </div>
        <div class="txtb">
            <input type="text" name="title" required maxlength="15" placeholder="Title" value="<?php echo $row['title']?>">
        </div>
        
        <div class="txtb">
            <input type="number" name="hours_week" min="0" max="20" step="1" required placeholder="Hours per Week" value="<?php echo $row['hours_week']?>">
        </div>

        <div style="padding: 10px 0;">
            Location: 
            <select name="location" required style="width: 100px;">
                <option <?php if($row['location'] == 'URMC'){echo "selected ";}?> value="URMC">UR Medical College</option>
                <option <?php if($row['location'] == 'RC'){echo "selected ";}?>value="RC">River Campus</option>
                <option <?php if($row['location'] == 'ESM'){echo "selected ";}?>value="ESM">Eastman School of Music</option>
            </select>
        </div>

        <div style="padding: 10px 0;">
            <textarea rows=5 cols=50 wrap="hard" style="width: 100%; overflow-wrap: break-word;" maxlength=250 name="description" pattern="[A-Za-z0-9 ]*" placeholder="Description"><?php echo $row['description']?></textarea>
            <p style="margin: 0; font-size: 12px; text-align: right;">Max Characters: 250</p>
        </div>
        <div style="padding: 10px 0;">
            Flexible: <input <?php if($row['flexible'] == 'yes'){echo "checked ";}?> type="checkbox" name="flexible" value="TRUE"><br>
        </div>
        <input type="submit" name="submit" class="btn btn-primary" value="Update">
        <a class="text-danger" href="deleteJob.php?job_id=<?php echo $_GET['job_id'] ?>"> Delete Job </a>
    </form>

<?php
        }
    }
?>

</div>

</body> 
</html>
