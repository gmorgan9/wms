<!-- WORKING -->
<?php

require_once "../../app/database/connection.php";
require_once "../../app/database/functions.php";
require_once "../../path.php";

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
  
    $update = "UPDATE timesheet SET approval_status = 'pending', new_date = '$date', new_timein = '$timein', new_timeout = '$timeout', reason = '$reason' WHERE timeID = '$id'";
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

  <!-- NON ADMIN VIEW TIMESHEET -->
    <?php if($_SESSION['acc_type'] == 0) { ?> 
    
    <?php 

    $id = $_GET['timeID'];
    $select = " SELECT * FROM timesheet WHERE timeID = '$id' ";
    $result = mysqli_query($conn, $select);
    
    if (mysqli_num_rows($result) > 0) {
       while($row = mysqli_fetch_assoc($result)) {
          //$acc_type = $row['acc_type'];
    ?>
      <div class="page-header mx-auto">
        <p class="page_title" style="float: left; padding-top: 2px;"></p>
        <ul class="breadcrumb">
          <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
          <li><a href="<?php echo BASE_URL . '/pages/timesheet.php' ?>">Timesheets</a></li>
          <li>Viewing: <span class="text-muted" style="text-transform: capitalize"><?php echo $row['idno']; ?>  </span></li>
        </ul>
      </div>
      
    <div class="page-content mx-auto mt-2">
    <form action="" method="post">
          <div class="col-md-8 me-4">
                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Timesheet Entry ID</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                        <span class="text-capitalize"><?php echo $row['idno']; ?></span>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Date</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php 
                            $orgDate = $row['date'];
                            $date = date("M d, Y", strtotime($orgDate));
                            ?>
                            <?php if($row['new_date'] != null && $orgDate != $row['new_date']) { ?>
                              <span class="text-warning">Change in Progress</span>
                            <?php } else { ?>
                              <?php echo $date; ?>
                            <?php } ?>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Time In</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php 
                            $orgTimein = $row['timein'];
                            $timein = date("h:i A", strtotime($orgTimein));
                            ?>
                         <?php if($row['new_timein'] != null && $orgTimein != $row['new_timein']) { ?>
                              <span class="text-warning">Change in Progress</span>  
                            <?php } else { ?>
                              <?php echo $timein; ?>
                            <?php } ?>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Time Out</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php 
                            $orgTimeout = $row['timeout'];
                            $timeout = date("h:i A", strtotime($orgTimeout));
                            ?>
                        <?php if($row['new_timeout'] != null && $orgTimeout != $row['new_timeout']) { ?>
                              <span class="text-warning">Change in Progress</span>
                            <?php } else { ?>
                              <?php echo $timeout; ?>
                            <?php } ?>
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
                            
                            
                            
          <?php 
          }
       } else {
         echo "0 results";
       }
          ?>
       </form>
    </div>
  <!-- END NON ADMIN VIEW TIMESHEET --> 


  <!-- ADMIN VIEW TIMESHEET -->
    <?php } else { ?>



        <?php 

    $id = $_GET['timeID'];
    $select = " SELECT * FROM timesheet WHERE timeID = '$id' ";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
       while($row = mysqli_fetch_assoc($result)) {
          //$acc_type = $row['acc_type'];
    ?>
      <div class="page-header mx-auto">
        <p class="page_title" style="float: left; padding-top: 2px;"></p>
        <ul class="breadcrumb">
          <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
          <li><a href="<?php echo BASE_URL . '/pages/timesheet.php' ?>">Timesheets</a></li>
          <li>Viewing: <span class="text-muted" style="text-transform: capitalize"><?php echo $row['idno']; ?>  </span></li>
        </ul>
      </div>

    <div class="page-content mx-auto mt-2">
    <form action="" method="post">
          <div class="col-md-8 me-4">
                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Timesheet Entry ID</h6>
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
                          <h6 class="mb-0">New Date</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php 
                            $orgDate = $row['new_date'];
                            $new_date = date("M d, Y", strtotime($orgDate));
                            ?>
                            <?php //if($new_date == null) { ?>
                              <?php //echo $date; ?>
                            <?php //} else { ?>
                              <?php if($orgDate != $row['date']) { ?>
                                <span class="text-warning"><?php echo $new_date; ?></span>
                              <?php } else { ?>
                                <?php echo $date; ?>
                              <?php } ?>
                            <?php //} ?>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">New Time In</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php 
                            $orgTimein = $row['new_timein'];
                            $new_timein = date("h:i A", strtotime($orgTimein));
                            ?>
                            <?php if($orgTimein != $row['timein']) { ?>
                                <span class="text-warning"><?php echo $new_timein; ?></span>
                            <?php } else { ?>
                                <?php echo $new_timein; ?>
                            <?php } ?>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">New Time Out</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php 
                            $orgTimeout = $row['new_timeout'];
                            $new_timeout = date("h:i A", strtotime($orgTimeout));
                            ?>
                            <?php if($orgTimeout != $row['timeout']) { ?>
                                <span class="text-warning"><?php echo $new_timeout; ?></span>
                            <?php } else { ?>
                                <?php echo $new_timeout; ?>
                            <?php } ?>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Reason</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                        <?php echo $row['reason']; ?>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Actions</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <a class="text-decoration-none badge text-bg-primary" href="javascript:history.back()">Go Back</a>
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







    <?php } ?>
  <!-- END ADMIN VIEW TIMESHEET -->
  
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
        <label for="new_date" style="font-size: 14px;">Date <span class="text-muted" style="font-size: 10px;">e.g. "mm/dd/yyyy"</span></label>
        <input class="form-control" id="new_date" type="date" name="new_date" value="<?php echo $row['date']; ?>" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 95%;">
        <label for="new_timein" style="font-size: 14px;">Time In <span class="text-muted" style="font-size: 10px;">e.g. "hh:mm"</span></label>
        <input class="form-control" id="new_timein" type="time" name="new_timein" value="<?php echo $row['timein']; ?>" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 95%;">
        <label for="new_timeout" style="font-size: 14px;">Time Out <span class="text-muted" style="font-size: 10px;">e.g. "hh:mm"</span></label>
        <input class="form-control" id="new_timeout" type="time" name="new_timeout" value="<?php echo $row['timeout']; ?>" required>
      </div>
      <div class="form-group pt-3 mx-auto" style="width: 95%;">
        <label for="reason" style="font-size: 14px;">Reason <span class="text-muted" style="font-size: 10px;">Give reason for changing time</span></label>
        <textarea class="form-control" id="reason" type="text" name="reason" value="" required></textarea>
      </div>

      <div class="form-group pt-3 mx-auto d-grid d-md-flex justify-content-md-end" style="width: 95%; margin-bottom: 10px;">
        <button type="submit" style="border-color: rgba(0,0,0,0);" name="update-time" class="badge text-bg-secondary">Update Time</button>
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