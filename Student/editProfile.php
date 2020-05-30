<?php 
	session_start();
?>
<!DOCTYPE html>
<html>

<!-- this file loads the header -->
<?php include('../head.php') ?>

<body>

<!-- php for loading DB and nav-->
<?php
  require_once('../db_setup.php');

  //this part loads the nav bar
  include('nav.php') 
?>

<div class="section" id="edit-pfl">

<form style="padding: 10px 40px; height: 550px;" class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <h1 style="margin: 20px;">Edit Profile</h1>

  <div class="txtb">
    <input type="text" name="f_name">
    <span data-placeholder="First Name"></span>
  </div>

  <div class="txtb">
    <input type="text" name="l_name">
    <span data-placeholder="Last Name"></span>
  </div>

  <div class="txtb">
    <input type="password" name="password">
    <span data-placeholder="Password"></span>
  </div>

  <div class="txtb">
    <input type="text" name="class_year">
    <span data-placeholder="Class Year"></span>
  </div>

  <div class="txtb">
    <input type="text" name="major">
    <span data-placeholder="Major"></span>
  </div>

  <input type="submit" class="logbtn" value="Save" name="submit">

<?php
//code to get data from form
if(isset($_POST['submit'])){ 
  //the isset($POST['submit'] ensures the script doesn't run until the form is submitted)
  $f_name = $_POST['f_name'];
  $l_name = $_POST['l_name'];
  $password = $_POST['password'];
  $class_year = $_POST['class_year'];
  $major = $_POST['major'];
  $currUser = $_SESSION['currUser'];

  //query - note only put the ' mark around vraible in VALUES if it supposed to be a string...
  //in this case, only net_id is a string
  //$sql = "INSERT INTO REVIEWS (net_id, emp_id, mgmt_rating, culture_rating, full_rating) VALUES ('$net_id', $emp_id, $mgmt_rating, $culture_rating, $full_rating)";
  
  $sql = "UPDATE STUDENTS SET first_name='$f_name', last_name='$l_name', password='$password', class_year='$class_year' WHERE net_id='$currUser'"; 
  $sql2 = "UPDATE STUDENT_MAJORS SET major='$major' WHERE net_id='$currUser'";

  $result = $conn->query($sql);
  $result2 = $conn->query($sql2);

  if($result == TRUE){
      echo "Profile has been updated!";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  if($result2 == TRUE){
    echo "Profile has been updated!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

}
?>

</form>
  
</div>

</body>

</html>
