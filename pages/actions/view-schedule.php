<!-- WORKING -->
<?php

// REQUIRE
  require_once "../../app/database/connection.php";
  require_once "../../app/database/functions.php";
  require_once "../../path.php";
// END REQUIRE

session_start();

if(!isLoggedIn()){
   header('location:' . BASE_URL . '/pages/entry/login.php');
}

// UPDATE TIME FUNCTION
  if(isset($_POST['update-time'])){
    $id = $_GET['timeID'];
    $timeID = mysqli_real_escape_string($conn, $_POST['jobID']);
    $idno  = rand(1000000, 9999999); // figure how to not allow duplicates
    $date = mysqli_real_escape_string($conn, $_POST['new_date']);
    $timein = mysqli_real_escape_string($conn, $_POST['new_timein']);
    $timeout = mysqli_real_escape_string($conn, $_POST['new_timeout']);
    $totalhours = mysqli_real_escape_string($conn, $_POST['totalhours']);
    //$comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $employee_fname = mysqli_real_escape_string($conn, $_POST['employee_fname']);
    $employee_lname = mysqli_real_escape_string($conn, $_POST['employee_lname']);
    $employee_idno = mysqli_real_escape_string($conn, $_POST['employee_idno']);
    $new_idno = rand(1000000, 9999999); // figure how to not allow duplicates
  
    $update = "UPDATE timesheet SET approval_status = 'pending', new_idno = '$new_idno', new_date = '$date', new_timein = '$timein', new_timeout = '$timeout', reason = '$reason' WHERE timeID = '$id'";
    mysqli_query($conn, $update);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  
  };
// END UPDATE TIME FUNCTION

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | View Job</title>

  <!-- START SCRIPTS -->
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

  <!-- VIEW TIMESHEET -->
    
    <?php 

    $id = $_GET['scheduleID'];
    $select = " SELECT * FROM schedule WHERE scheduleID = '$id' ";
    $result = mysqli_query($conn, $select);
    
    if (mysqli_num_rows($result) > 0) {
       while($row = mysqli_fetch_assoc($result)) {
          //$acc_type = $row['acc_type'];
    ?>
      <div class="page-header mx-auto">
        <p class="page_title" style="float: left; padding-top: 2px;">View Schedule</p>
        <ul class="breadcrumb">
          <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
          <li><a href="<?php echo BASE_URL . '/pages/schedule_request.php' ?>">Schedule Requests</a></li>
          <li>Viewing: <span class="text-muted" style="text-transform: capitalize"><?php echo $row['idno']; ?>  </span></li>
        </ul>
      </div>

      <div class="page-content mx-auto mt-2">
                <!-- <div class="col-md-8 float-start" style="width: 50%;">
                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Employee ID</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                        <span class="text-capitalize"><?php //echo $row['employee_idno']; ?></span>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Employee</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                        <span class="text-capitalize"><?php //echo $row['employee_lname']; ?>, <?php //echo $row['employee_fname']; ?></span>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Company</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                        <span class="text-capitalize"><?php //echo $row['companyname']; ?></span>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Department</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                        <span class="text-capitalize"><?php //echo $row['deptname']; ?></span>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Job Position</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                        <span class="text-capitalize"><?php //echo $row['jobtitle']; ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->

          <div class="col-md-8 mx-auto">
                  <div class="card mb-3">
                    <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-3">
                                    <h6 class="mb-0">Schedule ID</h6>
                                  </div>
                                  <div class="col-sm-9 text-secondary">
                                  <span class="text-capitalize"><?php echo $row['idno']; ?></span>
                                  </div>
                                </div>
                      <hr>
                                <div class="row">
                                  <div class="col-sm-3">
                                    <h6 class="mb-0">Employee</h6>
                                  </div>
                                  <div class="col-sm-9 text-secondary">
                                  <span class="text-capitalize"><?php echo $row['employee_lname']; ?>, <?php echo $row['employee_fname']; ?></span>
                                  </div>
                                </div>
                      <hr>
                                <div class="row">
                                  <div class="col-sm-3">
                                    <h6 class="mb-0">Monday</h6>
                                  </div>
                                  <div class="col-sm-9 text-secondary">
                                      <?php 
                                      $mon_date = date("M d, Y", strtotime($row['mon_date']));
                                      $mon_timein = date("h:i A", strtotime($row['mon_timein']));
                                      $mon_timeout = date("h:i A", strtotime($row['mon_timeout']));
                                      ?>
                                      <?php //if($row['new_date'] != null && $orgDate != $row['new_date']) { ?>
                                        <!-- <span class="text-warning">Change in Progress</span> -->
                                      <?php //} else { ?>
                                        <?php echo $mon_date; ?> &nbsp; <?php echo $mon_timein; ?> - <?php echo $mon_timeout; ?>
                                      <?php //} ?>
                                  </div>
                                </div>
                      <hr>
                                <div class="row">
                                  <div class="col-sm-3">
                                    <h6 class="mb-0">Tuesday</h6>
                                  </div>
                                  <div class="col-sm-9 text-secondary">
                                      <?php 
                                      $tues_date = date("M d, Y", strtotime($row['tues_date']));
                                      $tues_timein = date("h:i A", strtotime($row['tues_timein']));
                                      $tues_timeout = date("h:i A", strtotime($row['tues_timeout']));
                                      ?>
                                      <?php //if($row['new_date'] != null && $orgDate != $row['new_date']) { ?>
                                        <!-- <span class="text-warning">Change in Progress</span> -->
                                      <?php //} else { ?>
                                        <?php echo $tues_date; ?> &nbsp; <?php echo $tues_timein; ?> - <?php echo $tues_timeout; ?>
                                      <?php //} ?>
                                  </div>
                                </div>
                      <hr>
                                <div class="row">
                                  <div class="col-sm-3">
                                    <h6 class="mb-0">Wednesday</h6>
                                  </div>
                                  <div class="col-sm-9 text-secondary">
                                      <?php 
                                      $wed_date = date("M d, Y", strtotime($row['wed_date']));
                                      $wed_timein = date("h:i A", strtotime($row['wed_timein']));
                                      $wed_timeout = date("h:i A", strtotime($row['wed_timeout']));
                                      ?>
                                      <?php //if($row['new_date'] != null && $orgDate != $row['new_date']) { ?>
                                        <!-- <span class="text-warning">Change in Progress</span> -->
                                      <?php //} else { ?>
                                        <?php echo $wed_date; ?> &nbsp; <?php echo $wed_timein; ?> - <?php echo $wed_timeout; ?>
                                      <?php //} ?>
                                  </div>
                                </div>
                      <hr>
                                <div class="row">
                                  <div class="col-sm-3">
                                    <h6 class="mb-0">Thursday</h6>
                                  </div>
                                  <div class="col-sm-9 text-secondary">
                                      <?php 
                                      $thurs_date = date("M d, Y", strtotime($row['thurs_date']));
                                      $thurs_timein = date("h:i A", strtotime($row['thurs_timein']));
                                      $thurs_timeout = date("h:i A", strtotime($row['thurs_timeout']));
                                      ?>
                                      <?php //if($row['new_date'] != null && $orgDate != $row['new_date']) { ?>
                                        <!-- <span class="text-warning">Change in Progress</span> -->
                                      <?php //} else { ?>
                                        <?php echo $thurs_date; ?> &nbsp; <?php echo $thurs_timein; ?> - <?php echo $thurs_timeout; ?>
                                      <?php //} ?>
                                  </div>
                                </div>
                      <hr>
                                <div class="row">
                                  <div class="col-sm-3">
                                    <h6 class="mb-0">Friday</h6>
                                  </div>
                                  <div class="col-sm-9 text-secondary">
                                      <?php 
                                      $fri_date = date("M d, Y", strtotime($row['fri_date']));
                                      $fri_timein = date("h:i A", strtotime($row['fri_timein']));
                                      $fri_timeout = date("h:i A", strtotime($row['fri_timeout']));
                                      ?>
                                      <?php //if($row['new_date'] != null && $orgDate != $row['new_date']) { ?>
                                        <!-- <span class="text-warning">Change in Progress</span> -->
                                      <?php //} else { ?>
                                        <?php echo $fri_date; ?> &nbsp; <?php echo $fri_timein; ?> - <?php echo $fri_timeout; ?>
                                      <?php //} ?>
                                  </div>
                                </div>
                      <hr>
                                <div class="row">
                                  <div class="col-sm-3">
                                    <h6 class="mb-0">Actions</h6>
                                  </div>
                                  <div class="col-sm-9 text-secondary">
                                  <a class="text-decoration-none badge text-bg-success" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">Edit</a>
                                  </div>
                                </div>
                    </div>
                  </div>
                                      </div>                   
                            
                            
                            
          <?php 
          }
       } else {
         echo "0 results";
       }
          ?>
       </form>
    </div>
  <!-- END VIEW TIMESHEET --> 

  
  </div> 
<!-- end MAIN -->

<!-- EDIT MODAL -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

  <?php 
  $id = $_GET['timeID'];
  $select = " SELECT * FROM timesheet WHERE timeID = '$id' ";
  $result = mysqli_query($conn, $select);

  if (mysqli_num_rows($result) > 0) {
     while($row = mysqli_fetch_assoc($result)) {
      ?>

<form action="" method="post">
    <div class="section-header pt-2 text-center fs-5">
      <span class="text-muted pt-4" style="width: 95%;">Schedule Requests</span>
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

    <?php 

    $monday     = date( 'Y-m-d', strtotime( 'monday next week' ) );
    $tuesday    = date( 'Y-m-d', strtotime( 'tuesday next week' ) );
    $wednesday  = date( 'Y-m-d', strtotime( 'wednesday next week' ) );
    $thursday   = date( 'Y-m-d', strtotime( 'thursday next week' ) );
    $friday     = date( 'Y-m-d', strtotime( 'friday next week' ) );

    ?>
    <div class="row mx-auto">
      <div class="form-group pt-3 mx-auto" style="width: 25%;">
        <label for="employee_fname" style="font-size: 14px;">First Name</label>
        <input class="form-control" id="employee_fname" type="text" name="employee_fname" value="<?php echo $fname; ?>" readonly>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 25%;">
        <label for="employee_lname" style="font-size: 14px;">Last Name</label>
        <input class="form-control" id="employee_lname" type="text" name="employee_lname" value="<?php echo $lname; ?>" readonly>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="employee_idno" style="font-size: 14px;">Employee ID #</label>
        <input class="form-control" id="employee_idno" type="text" name="employee_idno" value="<?php echo $employeeID; ?>" readonly>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 35%;">
        <label for="jobtitle" style="font-size: 14px;">Job Title</label>
        <input class="form-control" id="jobtitle" type="text" name="jobtitle" value="<?php echo $jobtitle; ?>" readonly>
      </div>
    </div>
    <div class="row">
      <div class="form-group pt-3 mx-auto" style="width: 48%;">
        <label for="companyname" style="font-size: 14px;">Company</label>
        <input class="form-control" id="companyname" type="text" name="companyname" value="<?php echo $companyname; ?>" readonly>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 48%;">
        <label for="deptname" style="font-size: 14px;">Department</label>
        <input class="form-control" id="deptname" type="text" name="deptname" value="<?php echo $deptname; ?>" readonly>
      </div>
    </div>
    <br>
    <hr>
    <?php 
    $new_monday = date( 'F d, Y', strtotime($monday));
    $new_friday = date( 'F d, Y', strtotime($friday));

    ?>
    <div class="section-header pt-1 text-center fs-5">
      <span class="pt-3" style="width: 95%;">Schedule for <span class="text-muted"><?php echo $new_monday; ?> - <?php echo $new_friday; ?></span></span>
    </div>
    <div class="row">
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="mon_date" style="font-size: 14px;">Monday Date</label>
        <input class="form-control" id="mon_date" type="date" name="mon_date" value="<?php echo $monday; ?>" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="mon_timein" style="font-size: 14px;">Monday Time in</label>
        <input class="form-control" id="mon_timein" type="time" name="mon_timein" value="" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="mon_timeout" style="font-size: 14px;">Monday Timeout</label>
        <input class="form-control" id="mon_timeout" type="time" name="mon_timeout" value="" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="tues_date" style="font-size: 14px;">Tuesday Date</label>
        <input class="form-control" id="tues_date" type="date" name="tues_date" value="<?php echo $tuesday; ?>" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="tues_timein" style="font-size: 14px;">Tuesday Time in</label>
        <input class="form-control" id="tues_timein" type="time" name="tues_timein" value="" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="tues_timeout" style="font-size: 14px;">Tuesday Time out</label>
        <input class="form-control" id="tues_timeout" type="time" name="tues_timeout" value="" required>
      </div>
    </div>
    <div class="row">
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="wed_date" style="font-size: 14px;">Wednesday Date</label>
        <input class="form-control" id="wed_date" type="date" name="wed_date" value="<?php echo $wednesday; ?>" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="wed_timein" style="font-size: 14px;">Wednesday Time in</label>
        <input class="form-control" id="wed_timein" type="time" name="wed_timein" value="" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="wed_timeout" style="font-size: 14px;">Wednesday Timeout</label>
        <input class="form-control" id="wed_timeout" type="time" name="wed_timeout" value="" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="thurs_date" style="font-size: 14px;">Thursday Date</label>
        <input class="form-control" id="thurs_date" type="date" name="thurs_date" value="<?php echo $thursday; ?>" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="thurs_timein" style="font-size: 14px;">Thursday Time in</label>
        <input class="form-control" id="thurs_timein" type="time" name="thurs_timein" value="" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="thurs_timeout" style="font-size: 14px;">Thursday Time out</label>
        <input class="form-control" id="thurs_timeout" type="time" name="thurs_timeout" value="" required>
      </div>
    </div>
    <div class="row">
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="fri_date" style="font-size: 14px;">Friday Date</label>
        <input class="form-control" id="fri_date" type="date" name="fri_date" value="<?php echo $friday; ?>" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="fri_timein" style="font-size: 14px;">Friday Time in</label>
        <input class="form-control" id="fri_timein" type="time" name="fri_timein" value="" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 15%;">
        <label for="fri_timeout" style="font-size: 14px;">Friday Timeout</label>
        <input class="form-control" id="fri_timeout" type="time" name="fri_timeout" value="" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 48%;">
        <label for="notes" style="font-size: 14px;">Notes</label>
        <textarea class="form-control" id="notes" type="text" name="notes" value=""></textarea>
      </div>
    </div>
    <div class="form-group pt-3 mx-auto d-grid d-md-flex justify-content-md-end" style="width: 95%; margin-bottom: 10px;">
      <button type="submit" style="border-color: rgba(0,0,0,0);" name="update-schedule" class="badge text-bg-secondary">Request Schedule</button>
    </div>
    </form>

                <?php }} ?>






        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
    
  </div>
<!-- END EDIT MODAL -->

<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>