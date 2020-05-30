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
  include('emp-nav.php'); 
?>

<div id="edit-pf" class="section">

<form style="padding: 10px 40px; height:460px;" class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <h1 style="margin: 20px;">Edit Profile</h1>

  <div class="txtb">
    <input type="text" name='name'>
    <span data-placeholder="Name"></span>
  </div>

  <div class="txtb">
    <input type="password" name='phone_no'>
    <span data-placeholder="Phone No."></span>
  </div>
  

  <div class="txtb">
    <input type="password" name='password'>
    <span data-placeholder="Password"></span>
  </div>

  <div class="txtb">
    <input type="text" name='address'>
    <span data-placeholder="Address"></span>
  </div>

  <input style="transform: translateY(-10px);" type="submit" class="logbtn" value="Save" name="submit">

<?php
//code to get data from form
if(isset($_POST['submit'])){ 
  //the isset($POST['submit'] ensures the script doesn't run until the form is submitted)
  $name = $_POST['name'];
  $phone_no = $_POST['phone_no'];
  $password = $_POST['password'];
  $address = $_POST['address'];
  $emp_id = $_SESSION['emp_id'];

  //query - note only put the ' mark around vraible in VALUES if it supposed to be a string...
  //in this case, only net_id is a string
  
  $sql = "UPDATE EMPLOYERS SET name='$name', phone_number=$phone_no, password='$password', address='$address' WHERE emp_id=$emp_id ";
  $result = $conn->query($sql);

  if($result == TRUE){
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
