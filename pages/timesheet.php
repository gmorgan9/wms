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




  if (isset($_POST['approved']))
    {
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $timein = mysqli_real_escape_string($conn, $_POST['timein']);
        $timeout = mysqli_real_escape_string($conn, $_POST['timeout']);
        

        $appUpdateQuery = "UPDATE timesheet SET date = '$date', timein = '$timein', timeout = '$timeout', new_date = null, new_timein = null, new_timeout = null, reason = null, approval_status = 'approved' WHERE timeID = '".$_POST['timeID']."'";
        $appUpdateResult = mysqli_query($conn, $appUpdateQuery);
        header('location: timesheet.php');
        // $appInsertQuery = "INSERT INTO approved(id,status) VALUES ('".$_POST['row_id']."','Approved')";
        // $appInsertResult = mysqli_query($conn, $appInsertQuery);
    }
        
    if (isset($_POST['rejected']))
    {
        $rejUpdateQuery = "UPDATE timesheet SET approval_status = 'rejected' WHERE timeID = '".$_POST['timeID']."'";
        $rejUpdateResult = mysqli_query($conn,$rejUpdateQuery);
        header('location: timesheet.php');
        // $rejInsertQuery = "INSERT INTO rejected(id,status) VALUES ('".$_POST['row_id']."','Rejected')";
        // $rejInsertResult = mysqli_query($conn, $rejInsertQuery);
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


  <?php if($_SESSION['acc_type'] == 0){ ?>
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




  <?php

// $sql = "SELECT * FROM timesheet where employee_idno = '{$_SESSION['employee_idno']}'";
//       $all = mysqli_query($conn, $sql);
//       if($all) {
//           while ($row = mysqli_fetch_assoc($all)) {
//             $timesheetDate = $row['date'];
//           }}

//           $day = date('w');
//           $week_start = date('m/d/y', strtotime('-'.(5-$day).' days'));
//           $week_end = date('m/d/y', strtotime('+'.(5-$day).' days'));


// $monday_this_week = date("Y-m-d",strtotime('monday this week'));
?>
<!-- <label ><?php //echo $week_start; ?> - </label>
<label ><?php //echo $week_end; ?></label> <br>
<?php //for($i=0;$i<=4;$i++): ?>
    <?php //$date = date('M d, Y', strtotime("+$i days", strtotime($monday_this_week))); ?>
      <label ><?php //echo $date; ?></label>
      <label >(<?php //echo date('l', strtotime($date)); ?>)</label><br>
       
<?php //endfor;  ?> -->

 <!-- end PAGE-CONTENT -->
</div>

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
          <div class="forms d-flex" style="">
        <form class="me-2" method="post" action="">
        <?php $timeid = $row['timeID']; ?>
          <input type="hidden" name="timeID" value="<?php echo $timeid; ?>" />
          <input type="hidden" name="date" value="<?php echo $new_date; ?>" />
          <input type="hidden" name="timein" value="<?php echo $new_timein; ?>" />
          <input type="hidden" name="timeout" value="<?php echo $new_timeout; ?>" />
          <button style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="approved"><span class="badge text-bg-success">Approve</span></button>
        </form>
        &nbsp;
        <form method="post" action="">
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




<?php if($_SESSION['acc_type'] == 0){ ?>
<!-- start PAGE-CONTENT -->

<?php
      $sql = "SELECT * FROM timesheet where employee_idno = '{$_SESSION['employee_idno']}'";
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
            $companyname    = $row['companyname'];
          }}

          $day = date('w');
          $week_start = date('m/d/y', strtotime('-'.(5-$day).' days'));
          $week_end = date('m/d/y', strtotime('+'.(5-$day).' days'));
          $week_num = date('W', strtotime($week_start));

          $monday_this_week = date("Y-m-d",strtotime('monday this week'));
?>
<label ><?php echo $week_start; ?> - </label>
<label ><?php echo $week_end; ?></label> <br>
<?php 
$day = date('w');
          $week_start = date('m/d/y', strtotime('-'.(5-$day).' days'));
           $week_end = date('m/d/y', strtotime('+'.(5-$day).' days'));

?>
    <?php 
    $i=0;
    $mon = date('M d, Y', strtotime("+$i days", strtotime($monday_this_week))); 
    $i=1;
    $tues = date('M d, Y', strtotime("+$i days", strtotime($monday_this_week)));
    $i=2;
    $wed = date('M d, Y', strtotime("+$i days", strtotime($monday_this_week))); 
    $i=3;
    $thurs = date('M d, Y', strtotime("+$i days", strtotime($monday_this_week)));
    $i=4;
    $fri = date('M d, Y', strtotime("+$i days", strtotime($monday_this_week))); 
    
    
    
    ?>
      <label ><?php echo $date; ?></label>
      <label >(<?php echo date('l', strtotime($date)); ?>)</label><br>
       





<div class="page-content mt-2 float-end" style="width: 65%; margin-right: 10px;">
<span class="mx-auto">Timesheet for <span class="text-muted text-capitalize"><?php echo $week_start; ?> - <?php echo $week_end; ?></span></span> 
    <table class="table">
  <thead>
    <tr>
      <th scope="col" style="font-size: 14px;"><?php echo $mon; ?></th>
      <th scope="col" style="font-size: 14px;"><?php echo $tues; ?></th>
      <th scope="col" style="font-size: 14px;"><?php echo $wed; ?></th>
      <th scope="col" style="font-size: 14px;"><?php echo $thurs; ?></th>
      <th scope="col" style="font-size: 14px;"><?php echo $fri; ?></th>
      <!-- <th scope="col" style="font-size: 14px;">Actions</th> -->
    </tr>
  </thead>
  <tbody class="table-group-divider">

  
    <tr>
    <td><a style="text-decoration: none;" class="badge text-bg-success" href="actions/view-timesheet.php?timeID=<?php echo $timeID; ?>">View</a>
    <td><a style="text-decoration: none;" class="badge text-bg-success" href="actions/view-timesheet.php?timeID=<?php echo $timeID; ?>">View</a>
    <td><a style="text-decoration: none;" class="badge text-bg-success" href="actions/view-timesheet.php?timeID=<?php echo $timeID; ?>">View</a>
    <td><a style="text-decoration: none;" class="badge text-bg-success" href="actions/view-timesheet.php?timeID=<?php echo $timeID; ?>">View</a>
    <td><a style="text-decoration: none;" class="badge text-bg-success" href="actions/view-timesheet.php?timeID=<?php echo $timeID; ?>">View</a>
        <!-- <a onclick="return confirm('Be Careful! \r\nOK to delete?')" style="text-decoration: none;" class="badge text-bg-danger" href="timesheet.php?timeID=<?php //echo $timeID; ?>">Delete</a></td> -->
        <?php  ?>
        
   
      </tbody>
</table> 
 <!-- end PAGE-CONTENT -->
</div>
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
        <td><a style="text-decoration: none;" class="badge text-bg-success" href="actions/view-timesheet.php?timeID=<?php echo $timeID; ?>">View</a>
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

 
<!-- end MAIN -->
</div> 

<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>