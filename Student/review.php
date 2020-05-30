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

<div id="review" class="section">

<!-- php to handle the form data on the same page.  -->
  <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <!-- php query for getting all employer name and id from DB -->
  <?php
  $net_id = $_SESSION['currUser'];
    // Query:
  $sql = "SELECT emp_id, name FROM EMPLOYERS";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
  ?>
  <!-- end php -->

  <h1>Review</h1>

  <input type="hidden" name="net_id" value="<?php echo $net_id?>">
  
  <div>
  Employer ID: 
  <select name="emp_id" style="width: 100px;" required>
  <!-- php to dynamically create options for the dropdown-->
  <?php
      while($row = $result->fetch_assoc()){
  ?> 
        <option value=<?php echo $row['emp_id']?>><?php echo $row['name']?></option>
  <?php
      }
  ?>
  <!-- end php -->

  </select>
  </div>

  <div class="txtb">
    <!-- added name = mgmt_rating -->
    <input min="1" max="5" type="number" name="mgmt_rating" step=".1">
    <span data-placeholder="Management Rating (1-5)"></span>
  </div>

  <div class="txtb">
    <!-- added name = culture_rating -->
    <input min="1" max="5" type="number" name="culture_rating" step=".1">
    <span data-placeholder="Culture Rating (1-5)"></span>
  </div>

  <div class="txtb">
    <!-- added name = full_rating -->
    <input min="1" max="5" type="number" name="full_rating" step=".1">
    <span data-placeholder="Full Rating (1-5)"></span>
  </div>

  <input type="submit" class="logbtn" name="submit">

<!-- php end of if -->
<?php
} else {
    echo "You cannot add reviews at this time";
}

//code to get data from form
if(isset($_POST['submit'])){ 
  //the isset($POST['submit'] ensures the script doesn't run until the form is submitted)
  $net_id = $_POST['net_id'];
  $emp_id = $_POST['emp_id'];
  $mgmt_rating = $_POST['mgmt_rating'];
  $culture_rating = $_POST['culture_rating'];
  $full_rating = $_POST['full_rating'];
  //query - note only put the ' mark around vraible in VALUES if it supposed to be a string...
  //in this case, only net_id is a string
  $sql = "INSERT INTO REVIEWS (net_id, emp_id, mgmt_rating, culture_rating, full_rating) VALUES ('$net_id', $emp_id, $mgmt_rating, $culture_rating, $full_rating)";

  $result = $conn->query($sql);
  if($result == TRUE){
      echo "Thank you for submitting a rating!";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>

</form>

</div>

</body>

</html>
