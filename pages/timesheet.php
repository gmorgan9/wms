<!-- WORKING -->
<?php

date_default_timezone_set('America/Denver');

// REQUIRE
  require_once "../app/database/connection.php";
  require_once "../app/database/functions.php";
  require_once "../path.php";
// END REQUIRE

session_start();

if(!isLoggedIn()){
   header('location: /login.php');
}


// ADD TIME FUNCTION
  if(isset($_POST['add-time'])) {
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
// END ADD TIME FUNCTION

// DELETE TIME
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
// END DELETE TIME FUNCTION

// APPROVED STATUS FUNCTION
  if (isset($_POST['approved-status'])) {
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $timein = mysqli_real_escape_string($conn, $_POST['timein']);
    $timeout = mysqli_real_escape_string($conn, $_POST['timeout']);
    $new_idno = rand(1000000, 9999999); // figure how to not allow duplicates
    
    $appUpdateQuery = "UPDATE timesheet SET new_idno = null, date = '$date', timein = '$timein', timeout = '$timeout', new_date = null, new_timein = null, new_timeout = null, reason = null, approval_status = 'approved' WHERE timeID = '".$_POST['timeID']."'";
    $appUpdateResult = mysqli_query($conn, $appUpdateQuery);
    header('location: timesheet.php');
  }
// END APPROVED STATUS FUNCTION

// APPROVED TIME FUNCTION
  if (isset($_POST['approved-time'])) {
    $apptUpdateQuery = "UPDATE timesheet SET approval_status = 'approved' WHERE timeID = '".$_POST['timeID']."'";
    $apptUpdateResult = mysqli_query($conn, $apptUpdateQuery);
    header('location: timesheet.php');
  }
// END APPROVED TIME FUNCTION

// REJECTED TIME STATUS FUNCTION
  if (isset($_POST['rejected'])) {
    $rejUpdateQuery = "UPDATE timesheet SET approval_status = 'rejected' WHERE timeID = '".$_POST['timeID']."'";
    $rejUpdateResult = mysqli_query($conn,$rejUpdateQuery);
    header('location: timesheet.php');
  }
// END REJECTED TIME STATUS FUNCTION

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | Timesheet</title>

  <!-- SCRIPTS -->
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/other-style.css?v='. time(); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- END SCRIPTS -->


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

  <!-- NON ADMIN TIMESHEET (LEFT SIDE) -->
     <?php if($_SESSION['acc_type'] == 0){ ?>
     <!-- start PAGE-CONTENT -->
     <div class="page-content float-start" style="margin-top: 12px; width: 32%;margin-left: -100px; height: 250px; !important;">
       <div class="section-header pt-2">
         <span class="text-muted pt-4" style="width: 95%;">Time Entry</span>
       </div>
       <hr style="margin-bottom: -5px; margin-top: 5px;">
       <?php 
        $timezone = date_default_timezone_get();
        date_default_timezone_set($timezone);
        $date = date('Y-m-d');
        $time = date('h:i:s');
    ?>

        <?php 
        $employee_idno = $_SESSION['employee_idno'];
        $select = " SELECT * FROM timeclock WHERE employee_idno = '$employee_idno' ";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
         while($row = mysqli_fetch_assoc($result)) {

            $timein = $row['timein'];
            $timeout = $row['timeout'];
         } }?>
        <div class="section-header text-center pt-2">
          <?php $formatted_date = date('F d, Y', stripos($date)); ?>
         <span class="pt-4" style="width: 95%;">Today's Date is <span class="text-muted"><?php echo $formatted_date ?></span></span>
       </div>
        
        <form id="clockin" method="post" action="">
            <?php $empID = $_SESSION['employee_idno']; ?>
            <input type="hidden" name="employee_idno" value="<?php echo $empID; ?>" />
            <input type="hidden" name="date" value="<?php echo $date; ?>" />
            <input type="hidden" name="timein" value="<?php echo $time; ?>" />
            <button style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="clockin"><span class="badge text-bg-success">Clock In</span></button>
        </form>
        <?php if ($timein != null) {?>
            <style type="text/css">
                #clockin{
                    display:none;
                }
            </style>

            <?php } ?>

            <?php if ($timein != null) {?>
        <form id="clockout" method="post" action="">
            <?php $empID = $_SESSION['employee_idno']; ?>
            <input type="hidden" name="employee_idno" value="<?php echo $empID; ?>" />
            <input type="hidden" name="timeout" value="<?php echo $time; ?>" />
            <button style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="clockout"><span class="badge text-bg-danger">Clock Out</span></button>
        </form>
        <?php } ?>
        <?php if ($timeout != null) { ?>
            <style type="text/css">
                #clockout{
                    display:none;
                }
            </style>
            <?php } ?>

     <!-- end PAGE-CONTENT -->
     </div>
  <!-- END NON ADMIN TIMESHEET (LEFT SIDE) -->

  <!-- ADMIN TIME SHEET (LEFT SIDE) -->
    <?php } else { ?>
    <!-- start PAGE-CONTENT -->
    <div class="page-content float-start" style="margin-top: 12px; width: 32%;margin-left: -100px; height: unset !important;">
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
        $sql = "SELECT * FROM timesheet where approval_status = 'pending'";
        $result = mysqli_query($conn, $sql);
        if($result) {
            while ($row = mysqli_fetch_assoc($result)) {
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

              $new_date         = $row['new_date'];
              $new_timein       = $row['new_timein'];
              $new_timeout      = $row['new_timeout'];
              // $companyname    = $row['companyname'];
    ?>
      <tr>
          <th scope="row"><a class="text-decoration-none text-dark" href="actions/view-timesheet.php?timeID=<?php echo $timeID; ?>"><?php echo $idno; ?></a></th>
          <td>
            <?php if($row['new_idno'] != null) { ?>
              Change
            <?php } else { ?>
              Submission 
            <?php } ?>

          </td>
          <td>
            <div class="forms d-flex" style="">
              <?php if($row['new_idno'] != null) { ?>
            <form class="me-2" method="post" action="">
            <?php $timeid = $row['timeID']; ?>
              <input type="hidden" name="timeID" value="<?php echo $timeid; ?>" />
              <input type="hidden" name="date" value="<?php echo $new_date; ?>" />
              <input type="hidden" name="timein" value="<?php echo $new_timein; ?>" />
              <input type="hidden" name="timeout" value="<?php echo $new_timeout; ?>" />
              <button style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="approved-status"><span class="badge text-bg-success">Approve</span></button>
            </form>
            <?php } else { ?>
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
    <?php } ?>
  <!-- END ADMIN TIME SHEET (LEFT SIDE) -->

  <!-- NON ADMIN TIMESHEET (RIGHT SIDE) -->
    <?php if($_SESSION['acc_type'] == 0){ ?>
    <!-- start PAGE-CONTENT -->
    <?php
      $day = date('w');
      $monday = date( 'Y-m-d', strtotime( 'monday this week' ) );
      $friday = date( 'Y-m-d', strtotime( 'friday this week' ) );
      $week_start = date('Y-m-d', strtotime($monday));
      $week_end = date('Y-m-d', strtotime($friday));
      $week_num = date('W', strtotime($week_start));
      $display_week_start = date('F d, Y', strtotime($monday));
      $display_week_end   = date('F d, Y', strtotime($friday));
    ?>
    <div class="page-content mt-2 float-end" style="width: 65%; margin-right: 10px;">
    <p class="text-center fs-4"><span>Timesheet for <span class="text-muted text-capitalize"><?php echo $display_week_start; ?> - <?php echo $display_week_end; ?></span></span></p>
      <table class="table">
    <thead>
      <tr>
        <th scope="col" style="font-size: 14px;">ID #</th>
        <th scope="col" style="font-size: 14px;">Date</th>
        <th scope="col" style="font-size: 14px;">Time in / Time out</th>
        <th scope="col" style="font-size: 14px;">Total Hours</th>
        <th scope="col" style="font-size: 14px;">Status</th>
        <th scope="col" style="font-size: 14px;">Actions</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">

    <?php

            $day = date('w');
            $monday = date( 'Y-m-d', strtotime( 'monday this week' ) );
            $friday = date( 'Y-m-d', strtotime( 'friday this week' ) );
            $week_start = date('Y-m-d', strtotime($monday));
            $week_end = date('Y-m-d', strtotime($friday));
            $week_num = date('W', strtotime($week_start));

        $sql = "SELECT * FROM timesheet where employee_idno = '{$_SESSION['employee_idno']}' AND date BETWEEN '$week_start' AND '$week_end' ";
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
          <td><?php echo $date; ?></td>
          <td><?php echo $timein; ?> / <?php echo $timeout; ?></td>
          <td>

          <?php
          $total_time = round((strtotime($timeout) - strtotime($timein))/3600, 1);
          $total = round($total_time / 3600);
          $totalhrs = round($total_time / 60);
          //$maxmin = '59';
          ?>

          <?php echo $total_time ?>
          </td>
          <?php if($app_status == 'pending') { ?>
            <td><span class="text-primary">Pending</span></td>
          <?php } if($app_status == 'approved') { ?>
            <td><span class="text-success">Approved</span></td>
          <?php } if($app_status == 'rejected') { ?>
            <td><span class="text-danger">Rejected</span></td>
          <?php } ?>
          <!-- <td><?php //echo $companyname; ?></td> -->
          <td><a style="text-decoration: none;" class="badge text-bg-success" href="actions/view-timesheet.php?timeID=<?php echo $timeID; ?>">View</a></td>
          <!-- <a onclick="return confirm('Be Careful! \r\nOK to delete?')" style="text-decoration: none;" class="badge text-bg-danger" href="timesheet.php?timeID=<?php //echo $timeID; ?>">Delete</a></td> -->
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
  <!-- END NON ADMIN TIMESHEET (RIGHT SIDE) -->

  <!-- ADMIN TIME SHEET (RIGHT SIDE) -->
    <?php } else { ?>
    <!-- start PAGE-CONTENT -->
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
        $sql = "SELECT * FROM timesheet";
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
    <?php } ?>
  <!-- END ADMIN TIME SHEET (RIGHT SIDE)  -->

  </div> 
<!-- end MAIN -->

<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>