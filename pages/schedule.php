<!-- WORKING -->
<?php

// REQUIRES
  require_once "../app/database/connection.php";
  require_once "../app/database/functions.php";
  require_once "../path.php";
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
    header('location: schedule.php');
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
    $terUpdateQuery = "UPDATE schedule SET approval_status = 'terminated' WHERE scheduleID = '".$_POST['scheduleID']."'";
    $terUpdateResult = mysqli_query($conn, $terUpdateQuery);
    header('location: schedule.php');
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

  <?php if($_SESSION['acc_type'] == 0) { ?> 
  <!-- START SCHEDULE-REQUEST (RIGHT SIDE) -->
    <div class="page-content mt-2 mx-auto" style="margin-right: 10px;">
    <a class="badge text-bg-secondary text-decoration-none float-end mt-2" href="actions/schedule-request-form.php">Request Schedule</a>
    <table class="table">
    <thead>
      <tr>
        <th scope="col" style="font-size: 14px;">ID #</th>
        <th scope="col" style="font-size: 14px;">Employee</th>
        <th scope="col" style="font-size: 14px;">Schedule Dates</th>
        <th scope="col" style="font-size: 14px;">Status</th>
        <th scope="col" style="font-size: 14px;">Actions</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">

    <?php
    $emp_id = $_SESSION['employee_idno'];
        $sql = "SELECT * FROM schedule WHERE employee_idno = '$emp_id' AND approval_status != 'terminated'";
        $all = mysqli_query($conn, $sql);
        if($all) {
            while ($row = mysqli_fetch_assoc($all)) {
              $scheduleID       = $row['scheduleID'];
              $idno             = $row['idno'];
              $fname            = $row['employee_fname'];
              $lname            = $row['employee_lname'];
              $emp_idno         = $row['employee_idno'];
              $deptname         = $row['deptname'];
              $jobtitle         = $row['jobtitle'];
              $companyname      = $row['companyname'];
              $deptname         = $row['deptname'];
              $app_status       = $row['approval_status'];
              $monday       = date( 'M d, Y', strtotime($row['mon_date']));
              $friday       = date( 'M d, Y', strtotime($row['fri_date']));
    ?>
      <tr>
          <th scope="row"><?php echo $idno; ?></th>
          <td><?php echo $lname; ?>, <?php echo $fname; ?></td>
          <td><?php echo $monday; ?> - <?php echo $friday; ?></td>
          <?php if($app_status == 'approved'){ ?>
          <td><span class="text-capitalize text-success"><?php echo $app_status; ?><span></td>
          <?php } if($app_status == 'rejected') { ?>
            <td><span class="text-capitalize text-danger"><?php echo $app_status; ?><span></td>
          <?php } if($app_status == 'pending') { ?>
            <td><span class="text-capitalize text-primary"><?php echo $app_status; ?><span></td>
          <?php } if($app_status == 'terminated') { ?>
            <td><span class="text-capitalize text-danger"><?php echo $app_status; ?><span></td>
          <?php }?>
          <!-- <td><?php //echo $companyname; ?></td> -->
          <td>
            <form method="post" action="">
              <input type="hidden" name="scheduleID" value="<?php echo $scheduleID; ?>" />
              <a style="text-decoration: none;" class="badge text-bg-success" href="actions/view-schedule.php?scheduleID=<?php echo $scheduleID; ?>">View</a>
              <button onclick="return confirm('Be Careful, Can\'t be undone! \r\nOK to Terminate?')" style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="terminated"><span class="badge text-bg-danger">Delete</span></button>
            </form>
          </td>
          <?php } ?>
          
          
        </tbody>
        </table> 
        <?php 
        } else {
          echo "0 results";
        }
          ?>
      </div>
  <!-- END SCHEDULE-REQUEST (RIGHT SIDE) -->
  <?php } else { ?>
  <!-- START ADMIN SCHEDULE-REQUEST (LEFT SIDE) -->

    <div class="page-content float-start" style="margin-top: 12px; width: 32%;margin-left: -90px; height: unset !important;">
    <form action="" method="post">
    <div class="section-header pt-2">
        <span class="text-muted pt-4" style="width: 95%;">Pending Time Change Requests</span>
      </div>
      <hr style="margin-bottom: -5px; margin-top: 5px;">
      <table class="table">
    <thead>
      <tr>
        <th scope="col" style="font-size: 14px;">Timesheet ID</th>
        <th scope="col" style="font-size: 14px;">Type</th>
        <th scope="col" style="font-size: 14px;">Actions</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">

    <?php
        $sql = "SELECT * FROM schedule where approval_status = 'pending'";
        $result = mysqli_query($conn, $sql);
        if($result) {
            while ($row = mysqli_fetch_assoc($result)) {
              $scheduleID       = $row['scheduleID'];
              $idno             = $row['idno'];
              $orgDate          = $row['date'];
              $date             = date("M d, Y", strtotime($orgDate));
              $orgTimein        = $row['timein'];
              $timein           = date("h:i A", strtotime($orgTimein));
              $orgTimeout       = $row['timeout'];
              $timeout          = date("h:i A", strtotime($orgTimeout));
              $totalhours       = $row['totalhours'];
              $employee_fname   = $row['employee_fname'];
              $employee_lname   = $row['employee_lname'];
              $employee_idno    = $row['employee_idno'];
              $comment          = $row['comment'];
              $reason           = $row['reason'];

              $new_date         = $row['new_date'];
              $new_timein       = $row['new_timein'];
              $new_timeout      = $row['new_timeout'];
              // $companyname    = $row['companyname'];
    ?>
      <tr>
          <th scope="row"><a class="text-decoration-none text-dark" href="actions/view-schedule.php?scheduleID=<?php echo $scheduleID; ?>"><?php echo $idno; ?></a></th>
          <td>
            <?php if($row['approval_status'] == 'pending') { ?>
              Approval
            <?php } elseif($row['approval_status'] == 'terminated') { ?>
              Termination 
            <?php } ?>

          </td>
          <td>
            <div class="forms d-flex" style="">
              <?php if($row['approval_status'] == 'pending') { ?>
            <form class="me-2" method="post" action="">
            <?php $timeid = $row['scheduleID']; ?>
              <button style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="approved-status"><span class="badge text-bg-success">Approve</span></button>
            </form>
            <?php } if($row['approval_status'] == 'terminated') { ?>
          <form method="post" action="">
          <?php $timeid = $row['timeID']; ?>
            <input type="hidden" name="timeID" value="<?php echo $timeid; ?>" />
            <button style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="approved-time"><span class="badge text-bg-success">Approve</span></button>
          </form>
          <?php } ?>
          &nbsp;
          <form method="post" action="">
          <?php $timeid = $row['timeID']; ?>
            <input type="hidden" name="timeID" value="<?php echo $timeid; ?>" />
            <button style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="rejected"><span class="badge text-bg-danger">Reject</span></button>
          </form>
          </div>
          </td>
          <!--  onclick="return confirm('Be Careful! \r\nOK to delete?')" -->
          <?php } 

          ?>

            
        </tbody>
    </table> 
    <?php 
    } else {
      echo "0 results";
    }
    ?>
    </form>

    <!-- end PAGE-CONTENT -->
    </div>
  <!-- END ADMIN SCHEDULE-REQUEST (LEFT SIDE) -->

  <!-- START ADMIN SCHEDULE-REQUEST (RIGHT SIDE) -->
    <div class="page-content mt-2 float-end" style="width: 65%; margin-right: 10px;">
    <!-- <span class="mx-auto">Timesheet for <span class="text-muted text-capitalize"><?php //echo $_SESSION['fname']; ?></span></span> -->
    <table class="table">
      <thead>
        <tr>
          <th scope="col" style="font-size: 14px;">ID #</th>
          <th scope="col" style="font-size: 14px;">Employee</th>
          <th scope="col" style="font-size: 14px;">Status</th>
          <th scope="col" style="font-size: 14px;">Actions</th>
        </tr>
      </thead>
    <tbody class="table-group-divider">

    <?php
        $sql = "SELECT * FROM schedule";
        $all = mysqli_query($conn, $sql);
        if($all) {
            while ($row = mysqli_fetch_assoc($all)) {
              $timeID           = $row['timeID'];
              $idno             = $row['idno'];
              $orgDate          = $row['date'];
              $date             = date("M d, Y", strtotime($orgDate));
              $orgTimein        = $row['timein'];
              $timein           = date("h:i A", strtotime($orgTimein));
              $orgTimeout       = $row['timeout'];
              $timeout          = date("h:i A", strtotime($orgTimeout));
              $totalhours       = $row['totalhours'];
              $employee_fname   = $row['employee_fname'];
              $employee_lname   = $row['employee_lname'];
              $employee_idno    = $row['employee_idno'];
              $comment          = $row['comment'];
              $reason           = $row['reason'];
              $app_status       = $row['approval_status'];
              // $companyname    = $row['companyname'];
    ?>
      <tr>
          <th scope="row"><?php echo $idno; ?></th>
          <td><?php echo $employee_lname; ?>, <?php echo $employee_fname; ?></td>
          <?php if($app_status == 'approved'){ ?>
          <td><span class="text-capitalize text-success"><?php echo $app_status; ?><span></td>
          <?php } if($app_status == 'rejected') { ?>
            <td><span class="text-capitalize text-danger"><?php echo $app_status; ?><span></td>
          <?php } if($app_status == 'pending') { ?>
            <td><span class="text-capitalize text-primary"><?php echo $app_status; ?><span></td>
            <?php } if($app_status == 'terminated') { ?>
            <td><span class="text-capitalize text-danger"><?php echo $app_status; ?><span></td>
          <?php }?>
          <!-- <td><?php //echo $companyname; ?></td> -->
          <td>
            <a style="text-decoration: none;" class="badge text-bg-success" href="actions/view-timesheet.php?timeID=<?php echo $timeID; ?>">View</a>
          <a onclick="return confirm('Be Careful! \r\nOK to delete?')" style="text-decoration: none;" class="badge text-bg-danger" href="timesheet.php?timeID=<?php echo $timeID; ?>">Delete</a></td>
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
  <!-- END ADMIN SCHEDULE-REQUEST (RIGHT SIDE) -->
  <?php } ?>

  </div> 
<!-- END MAIN -->

<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>