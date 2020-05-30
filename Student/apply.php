<?php session_start(); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

<div class="section">

<form style="padding: 10px 40px; height: 460px;" enctype="multipart/form-data" class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <h1 style="margin: 20px;">Apply to Job</h1>
  <p style="margin: 20px;">Add your resume to complete your application. Please only upload a .pdf file.</p>

  <input type=hidden value="<?php echo $_GET['job_id'] ?>" name="job_id">

  <div style="padding: 20px;">
    <input type="file" name="resume" accept="application/pdf">
  </div>

  <!-- <div class="txtb">
    <input type="textarea" name="comments">
    <span data-placeholder="Comments"></span>
  </div> -->

  <input type="submit" class="logbtn" value="Apply" name="submit">

</form>

<?php

if(isset($_POST['submit'])){
    try{
        $net_id = $_SESSION['currUser'];
        $job_id = $_POST['job_id'];
        $resume_name = $_FILES['resume']['name'];
        $resume_type = $_FILES['resume']['type'];
        $data = base64_encode(file_get_contents($_FILES['resume']['tmp_name']));
        $stmt = $conn->prepare("INSERT INTO APPLIES_TO (net_id, job_id, resume, status) VALUES (?, ?, ?, 'received');");
        $stmt->bind_param("sis", $net_id, $job_id, $data);
       
        $res = $stmt -> execute();

        if($res != TRUE){
            echo $stmt->error;
        } else {
            header("Location: searchJobs.php"); 
        }
    } catch (Exception $e){
        echo "Error : " . $e;
    }
    
}

?>

</body>
</html>