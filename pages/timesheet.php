<!-- WORKING -->
<?php

require_once "../app/database/connection.php";
require_once "../app/database/functions.php";
require_once "../path.php";

session_start();

if(!isLoggedIn()){
   header('location: /login.php');
}


// Add Department
if(isset($_POST['add-time'])){

  $timeID = mysqli_real_escape_string($conn, $_POST['jobID']);
  $idno  = rand(1000000, 9999999); // figure how to not allow duplicates
  $date = mysqli_real_escape_string($conn, $_POST['date']);
  $timein = mysqli_real_escape_string($conn, $_POST['timein']);
  $timeout = mysqli_real_escape_string($conn, $_POST['timeout']);
  $totalhours = mysqli_real_escape_string($conn, $_POST['totalhours']);
  $comment = mysqli_real_escape_string($conn, $_POST['comment']);
  $reason = mysqli_real_escape_string($conn, $_POST['reason']);
  $employee_fname = mysqli_real_escape_string($conn, $_POST['employee_fname']);
  $employee_lname = mysqli_real_escape_string($conn, $_POST['employee_lname']);
  $employee_idno = mysqli_real_escape_string($conn, $_POST['employee_idno']);

  $select = " SELECT * FROM timesheet WHERE idno = '$idno' ";
  $result = mysqli_query($conn, $select);

  if(mysqli_num_rows($result) > 0){

     $error[] = 'Timesheet already exist!';

  }else{
        // $insert2 = "INSERT INTO employee_company_data (employee_code, company_code, dept_code, job_code) SELECT employee_code, company_code, dept_code, jobID FROM job";
        $insert = "INSERT INTO timesheet (idno, date, timein, timeout, employee_fname, employee_lname, employee_idno) VALUES('$idno', '$date', '$timein', '$timeout', '$employee_fname', '$employee_lname', '$employee_idno')";
        mysqli_query($conn, $insert);
        // mysqli_query($conn, $insert2);
        header('location: timesheet.php');
     }

};

// Delete Department
if(isset($_GET['timeID'])) {
    $id = $_GET['timeID'];

    $sql = "DELETE FROM timesheet WHERE timeID = $id";
    $delete = mysqli_query($conn, $sql);
    if($delete) {
        // echo "Deleted Successfully";
        header('location: timesheet.php'); // returns back to same page
    } else {
        die(mysqli_error($conn));
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | Timesheet</title>

   <!-- Custom Styles -->
   <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/other-style.css?v='. time(); ?>">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

<!-- scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

   
<!-- <div class="land-container">
   <div class="content">

      <h3><span>Admin Profile Page</span></h3>
      <h1>welcome <span><?php //echo $_SESSION['admin_fname'] ?></span></h1>
      <p>this is an admin profile</p>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div> -->

<?php include(ROOT_PATH . "/app/includes/header.php"); ?>


<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
        
<!-- start MAIN -->
<div class="main"> 

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Timesheet</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Timesheet</li>
    </ul>
  </div>


<!-- start PAGE-CONTENT -->
<div class="page-content float-start" style="margin-top: 12px; width: 32%;margin-left: -95px; height: unset !important;">
  <form action="" method="post">
    <div class="section-header pt-2">
      <span class="text-muted pt-4" style="width: 95%;">Time Entry</span>
    </div>
    <hr style="margin-bottom: -5px; margin-top: 5px;">
    <?php 

    $sql = "SELECT * FROM employee";
    $all = mysqli_query($conn, $sql);
      if($all) {
        while ($row = mysqli_fetch_assoc($all)) {
    
    $fname = $row['fname'];
    $lname = $row['lname']; 
    $employeeID = $row['idno']?>
    <?php }} ?>
      <input class="form-control" id="employee_fname" type="hidden" name="employee_fname" value="<?php echo $fname; ?>">
      <input class="form-control" id="employee_lname" type="hidden" name="employee_lname" value="<?php echo $lname; ?>">
      <input class="form-control" id="employee_idno" type="hidden" name="employee_idno" value="<?php echo $employeeID; ?>">
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="date" style="font-size: 14px;">Date <span class="text-muted" style="font-size: 10px;">e.g. "mm/dd/yyyy"</span></label>
      <input class="form-control" id="date" type="text" name="date" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="timein" style="font-size: 14px;">Time In <span class="text-muted" style="font-size: 10px;">e.g. "hh:mm"</span></label>
      <input class="form-control" id="timein" type="text" name="timein" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="timeout" style="font-size: 14px;">Time Out <span class="text-muted" style="font-size: 10px;">e.g. "hh:mm"</span></label>
      <input class="form-control" id="timeout" type="text" name="timeout" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto d-grid d-md-flex justify-content-md-end" style="width: 95%; margin-bottom: 10px;">
      <button type="submit" style="border-color: rgba(0,0,0,0);" name="add-time" class="badge text-bg-secondary">Add Time</button>
    </div>
  </form>

 <!-- end PAGE-CONTENT -->
</div>

<!-- start PAGE-CONTENT -->
<div class="page-content mt-2 float-end" style="width: 65%; margin-right: 10px;">
    <table class="table">
  <thead>
    <tr>
      <th scope="col" style="font-size: 14px;">ID #</th>
      <th scope="col" style="font-size: 14px;">Job Title / Position</th>
      <th scope="col" style="font-size: 14px;">Status</th>
      <th scope="col" style="font-size: 14px;">Actions</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">

  <?php
      $sql = "SELECT * FROM job";
      $all = mysqli_query($conn, $sql);
      if($all) {
          while ($row = mysqli_fetch_assoc($all)) {
            $jobID       = $row['jobID'];
            $idno        = $row['idno'];
            $jobtitle    = $row['jobtitle'];
            $companyname = $row['companyname'];
            $deptname    = $row['deptname'];
            $app_status  = $row['approval_status'];
            // $companyname    = $row['companyname'];
  ?>
    <tr>
        <th scope="row"><?php echo $idno; ?></th>
        <td><?php echo $jobtitle; ?></td>
        <?php if($app_status == 'approved'){ ?>
        <td><span class="text-capitalize text-success"><?php echo $app_status; ?><span></td>
        <?php } if($app_status == 'rejected') { ?>
          <td><span class="text-capitalize text-danger"><?php echo $app_status; ?><span></td>
        <?php } if($app_status == 'pending') { ?>
          <td><span class="text-capitalize text-primary"><?php echo $app_status; ?><span></td>
        <?php }?>
        <!-- <td><?php //echo $companyname; ?></td> -->
        <td><a onclick="return confirm('Be Careful! \r\nOK to delete?')" style="text-decoration: none;" class="badge text-bg-danger" href="jobs.php?jobID=<?php echo $jobID; ?>">Delete</a></td>
        <?php } ?>
        
   
      </tbody>
</table> 
<?php 
     
} else {
  echo "0 results";
}
    ?>
 <!-- end PAGE-CONTENT -->
</div>

 
<!-- end MAIN -->
</div> 


<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>