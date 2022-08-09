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

  $insert = "INSERT INTO timesheet (idno, date, timein, timeout, employee_fname, employee_lname, employee_idno) VALUES('$idno', '$date', '$timein', '$timeout', '$employee_fname', '$employee_lname', '$employee_idno')";
  mysqli_query($conn, $insert);
  header('location: timesheet.php');

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

<?php include(ROOT_PATH . "/app/includes/header.php"); ?>


<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
        
<!-- start MAIN -->
<div class="main"> 

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Timeesheet</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Timesheet</li>
    </ul>
  </div>


<!-- start PAGE-CONTENT -->
<div class="page-content float-start" style="margin-top: 12px; width: 32%;margin-left: -100px; height: unset !important;">
  <form action="" method="post">
    <div class="section-header pt-2">
      <span class="text-muted pt-4" style="width: 95%;">Time Entry</span>
    </div>
    <hr style="margin-bottom: -5px; margin-top: 5px;">
    <?php 
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname']; 
    $employee_idno = $_SESSION['employee_idno'];?>
      <input class="form-control" id="employee_fname" type="hidden" name="employee_fname" value="<?php echo $fname; ?>">
      <input class="form-control" id="employee_lname" type="hidden" name="employee_lname" value="<?php echo $lname; ?>">
      <input class="form-control" id="employee_idno" type="hidden" name="employee_idno" value="<?php echo $employee_idno; ?>">
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="date" style="font-size: 14px;">Date <span class="text-muted" style="font-size: 10px;">e.g. "mm/dd/yyyy"</span></label>
      <input class="form-control" id="date" type="date" name="date" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="timein" style="font-size: 14px;">Time In <span class="text-muted" style="font-size: 10px;">e.g. "hh:mm"</span></label>
      <input class="form-control" id="timein" type="time" name="timein" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="timeout" style="font-size: 14px;">Time Out <span class="text-muted" style="font-size: 10px;">e.g. "hh:mm"</span></label>
      <input class="form-control" id="timeout" type="time" name="timeout" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto d-grid d-md-flex justify-content-md-end" style="width: 95%; margin-bottom: 10px;">
      <button type="submit" style="border-color: rgba(0,0,0,0);" name="add-time" class="badge text-bg-secondary">Add Time</button>
    </div>
  </form>

 <!-- end PAGE-CONTENT -->
</div>

<!-- start PAGE-CONTENT -->
<div class="page-content mt-2 float-end" style="width: 65%; margin-right: 10px;">
<span class="float-center">Timesheet for <span class="text-muted text-capitalize"><?php echo $_SESSION['fname']; ?></span></span>
    <table class="table">
  <thead>
    <tr>
      <th scope="col" style="font-size: 14px;">ID #</th>
      <th scope="col" style="font-size: 14px;">Date</th>
      <th scope="col" style="font-size: 14px;">Time in / Time out</th>
      <th scope="col" style="font-size: 14px;">Actions</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">

  <?php
      $sql = "SELECT * FROM timesheet where employee_idno = '{$_SESSION['employee_idno']}'";
      $all = mysqli_query($conn, $sql);
      if($all) {
          while ($row = mysqli_fetch_assoc($all)) {
            $timeID           = $row['timeID'];
            $idno             = $row['idno'];
            $date             = $row['date'];
            $timein           = $row['timein'];
            $timeout          = $row['timeout'];
            $totalhours       = $row['totalhours'];
            $employee_fname   = $row['employee_fname'];
            $employee_lname   = $row['employee_lname'];
            $employee_idno    = $row['employee_idno'];
            $comment          = $row['comment'];
            $reason           = $row['reason'];
            // $companyname    = $row['companyname'];
  ?>
    <tr>
        <th scope="row"><?php echo $idno; ?></th>
        <td><?php echo $date; ?></td>
        <td><?php echo $timein; ?> / <?php echo $timeout; ?></td>
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