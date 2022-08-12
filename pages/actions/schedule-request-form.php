<!-- WORKING -->
<?php

// REQUIRES
  require_once "../../app/database/connection.php";
  require_once "../../app/database/functions.php";
  require_once "../../path.php";
// END REQURIES

session_start();

if(!isLoggedIn()){
   header('location: /login.php');
}

// ADD SCHEDULE
  if(isset($_POST['add-schedule'])){
    $scheduleID = mysqli_real_escape_string($conn, $_POST['scheduleID']);
    $idno  = rand(1000000, 9999999); // figure how to not allow duplicates
    $mon_date = mysqli_real_escape_string($conn, $_POST['mon_date']);
    $mon_timein = mysqli_real_escape_string($conn, $_POST['mon_timein']);
    $mon_timeout = mysqli_real_escape_string($conn, $_POST['mon_timeout']);
    $tues_date = mysqli_real_escape_string($conn, $_POST['tues_date']);
    $tues_timein = mysqli_real_escape_string($conn, $_POST['tues_timein']);
    $tues_timeout = mysqli_real_escape_string($conn, $_POST['tues_timeout']);
    $wed_date = mysqli_real_escape_string($conn, $_POST['wed_date']);
    $wed_timein = mysqli_real_escape_string($conn, $_POST['wed_timein']);
    $wed_timeout = mysqli_real_escape_string($conn, $_POST['wed_timeout']);
    $thurs_date = mysqli_real_escape_string($conn, $_POST['thurs_date']);
    $thurs_timein = mysqli_real_escape_string($conn, $_POST['thurs_timein']);
    $thurs_timeout = mysqli_real_escape_string($conn, $_POST['thurs_timeout']);
    $fri_date = mysqli_real_escape_string($conn, $_POST['fri_date']);
    $fri_timein = mysqli_real_escape_string($conn, $_POST['fri_timein']);
    $fri_timeout = mysqli_real_escape_string($conn, $_POST['fri_timeout']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $jobtitle = mysqli_real_escape_string($conn, $_POST['jobtitle']);
    $companyname = mysqli_real_escape_string($conn, $_POST['companyname']);
    $deptname = mysqli_real_escape_string($conn, $_POST['deptname']);
    $employee_fname = mysqli_real_escape_string($conn, $_POST['employee_fname']);
    $employee_lname = mysqli_real_escape_string($conn, $_POST['employee_lname']);
    $employee_idno = mysqli_real_escape_string($conn, $_POST['employee_idno']);

    $insert = "INSERT INTO job (idno, jobtitle, companyname, deptname, employee_fname, employee_lname, employee_idno) 
    VALUES('$idno', '$jobtitle', '$companyname', '$deptname', '$employee_fname', '$employee_lname', '$employee_idno')";
    mysqli_query($conn, $insert);
    header('location: job_request.php');
  };
// END ADD JOB

// DELETE JOB (NOT IN USE)
  if(isset($_GET['jobID'])) {
    $id = $_GET['jobID'];

    $sql = "DELETE FROM job WHERE jobID = $id";
    $delete = mysqli_query($conn, $sql);
    if($delete) {
        // echo "Deleted Successfully";
        header('location: jobs_request.php'); // returns back to same page
    } else {
        die(mysqli_error($conn));
    }
  }
// END DELETE JOB (NOT IN USE)

// SET TERMINATED
  if (isset($_POST['terminated'])) {
    $terUpdateQuery = "UPDATE job SET approval_status = 'terminated' WHERE jobID = '".$_POST['jobID']."'";
    $terUpdateResult = mysqli_query($conn, $terUpdateQuery);
    header('location: job_request.php');
  }
// END SET TERMINATED

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | Schedule</title>

  <!-- LINKS -->
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/other-style.css?v='. time(); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- END LINKS -->

</head>
<body>


<?php include(ROOT_PATH . "/app/includes/header.php"); ?>
<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
        
<!-- STAR MAIN -->
  <div class="main"> 

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Schedules</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Schedules</li>
    </ul>
  </div>


  <!-- START ADD COMPANY (LEFT SIDE) -->
    <div class="page-content mx-auto" style="margin-top: 10px;">
    <form action="" method="post">
    <div class="section-header pt-2">
      <span class="text-muted text-center pt-4" style="width: 95%;">Schedule Requests</span>
    </div>
    <hr style="margin-bottom: -5px; margin-top: 5px;">
    <?php 

    $employee_idno = $_SESSION['employee_idno'];
    $sql = "SELECT * FROM job WHERE employee_idno = '$employee_idno' AND status = 'active'";
    $all = mysqli_query($conn, $sql);
      if($all) {
        while ($row = mysqli_fetch_assoc($all)) {
    
    $fname = $row['employee_fname'];
    $lname = $row['employee_lname']; 
    $employeeID = $row['employee_idno'];
    $jobtitle = $row['jobtitle'];
    $companyname = $row['companyname']; 
    $deptname = $row['deptname'];?>
    <?php }} ?>

    <div class="row">
      <div class="form-group pt-3 mx-auto" style="width: 30%;">
        <label for="employee_fname" style="font-size: 14px;">First Name</label>
        <input class="form-control" id="employee_fname" type="text" name="employee_fname" value="<?php echo $fname; ?>">
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 30%;">
        <label for="employee_lname" style="font-size: 14px;">Last Name</label>
        <input class="form-control" id="employee_lname" type="text" name="employee_lname" value="<?php echo $lname; ?>">
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 30%;">
        <label for="employee_idno" style="font-size: 14px;">Employee ID #</label>
        <input class="form-control" id="employee_idno" type="text" name="employee_idno" value="<?php echo $employeeID; ?>">
      </div>
    </div>
      <input class="form-control" id="employee_lname" type="text" name="employee_lname" value="<?php echo $lname; ?>">
      <input class="form-control" id="employee_idno" type="text" name="employee_idno" value="<?php echo $employeeID; ?>">
      <input class="form-control" id="jobtitle" type="text" name="jobtitle" value="<?php echo $jobtitle; ?>">
      <input class="form-control" id="companyname" type="text" name="companyname" value="<?php echo $companyname; ?>">
      <input class="form-control" id="deptname" type="text" name="deptname" value="<?php echo $deptname; ?>">
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="companyname" style="font-size: 14px;">Company <span class="text-muted" style="font-size: 10px;">e.g. "Apple Corporation"</span></label>
      <input class="form-control" id="companyname" type="text" name="companyname" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="deptname" style="font-size: 14px;">Department <span class="text-muted" style="font-size: 10px;">e.g. "Accounting"</span></label>
      <input class="form-control" id="deptname" type="text" name="deptname" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="jobtitle" style="font-size: 14px;">Job Title / Position <span class="text-muted" style="font-size: 10px;">e.g. "Chief Executive Officer"</span></label>
      <input class="form-control" id="jobtitle" type="text" name="jobtitle" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto d-grid d-md-flex justify-content-md-end" style="width: 95%; margin-bottom: 10px;">
      <button type="submit" style="border-color: rgba(0,0,0,0);" name="add-job" class="badge text-bg-secondary">Request Job</button>
    </div>
    </form>
    </div>
  <!-- END ADD JOB (LEFT SIDE) -->

  </div> 
<!-- END MAIN -->

<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>