<!-- WORKING -->
<?php
require_once "../app/database/connection.php";
require_once "../app/database/functions.php";
require_once "../path.php";
session_start();

if(!isLoggedIn()){
  header('location:' . BASE_URL . '/pages/entry/login.php');
}

// UPDATE JOB FUNCTION
  if(isset($_POST['update-job'])){
    $id = $_GET['jobID'];
    $jobID = mysqli_real_escape_string($conn, $_POST['jobID']);
    $idno  = rand(1000000, 9999999); // figure how to not allow duplicates
    $jobtitle = mysqli_real_escape_string($conn, $_POST['jobtitle']);
    $companyname = mysqli_real_escape_string($conn, $_POST['companyname']);
    $deptname = mysqli_real_escape_string($conn, $_POST['deptname']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
  
    $update = "UPDATE job SET approval_status = 'pending', jobtitle = '$jobtitle', companyname = '$companyname', deptname = '$deptname', reason = '$reason' WHERE jobID = '$id'";
    mysqli_query($conn, $update);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  
  };
// END UPDATE JOB FUNCTION

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Custom Styles -->
   <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/other-style.css?v='. time(); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>WMS | Information</title>
</head>
<body>
    
<?php include(ROOT_PATH . "/app/includes/header.php"); ?>
<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
  
<!-- START MAIN -->
  <div class="main">
  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Employee Information</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Information</li>
    </ul>
  </div>

  <!-- START EMPLOYMENT INFO -->
    <?php 
    if($_SESSION['acc_type'] == 0) {
    
    $empID = $_SESSION['employee_idno'];
    $select = " SELECT * FROM job WHERE employee_idno = '{$_SESSION['employee_idno']}' AND status = 'active";
    $result = mysqli_query($conn, $select);
    if (mysqli_num_rows($result) > 0) {
     while($row = mysqli_fetch_assoc($result)) {
        $jobID = $row['jobID'];
        $jobtitle = $row['jobtitle'];
        $companyname = $row['companyname'];
        $deptname = $row['deptname'];
        $pay = $row['pay'];
        $status = $row['status'];
 
        }
     } 
    ?>


    <div class="page-content mx-auto mt-2">
    <form action="" method="post">
        <h3 class="text-center">Employment Information</h3>



        <div class="col-md-8 mx-auto">
                <div class="card mb-3">
                  <div class="card-body">
                  <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Current Job</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <?php if(!isset($jobtitle)) { ?>
                          <span class="text-capitalize">No Current Job</span>
                        <?php } else { ?>
                          <span class="text-capitalize"><?php echo $jobtitle; ?></span>
                        <?php } ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Company</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <?php if(!isset($companyname)) { ?>
                          <span class="text-capitalize">No Current Job</span>
                        <?php } else { ?>
                          <span class="text-capitalize"><?php echo $companyname; ?></span>
                        <?php } ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Department</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        <?php if(!isset($deptname)) { ?>
                          <span class="text-capitalize">No Current Job</span>
                        <?php } else { ?>
                          <span class="text-capitalize"><?php echo $deptname; ?></span>
                        <?php } ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Pay</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      <?php if(!isset($pay)) { ?>
                          <span class="text-capitalize">No Current Job</span>
                        <?php } else { ?>
                          <span class="text-capitalize">$<?php echo $pay; ?>.00</span>
                        <?php } ?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Status</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      <?php if(!isset($jobtitle)) { ?>
                          <span class="text-capitalize">No Current Job</span>
                        <?php } if($status == 'active') { ?>
                          <span class="text-capitalize text-success"><?php echo $status; ?></span>
                        <?php } if($status == 'inactive') { ?>
                          <span class="text-capitalize text-danger"><?php echo $status; ?></span>
                        <?php } ?>
                      </div>
                    </div>

                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Actions</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                      <?php if(!isset($jobtitle)) { ?>
                          <span class="text-capitalize">No Current Job</span>
                        <?php } else { ?>
                          <a class="text-decoration-none badge text-bg-success" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">Edit</a>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
                
     </form>
    </div>
  <!-- END EMPLOYMENY INFO -->

  <!-- ADMIN EMPLOYMENY INFO -->
    <?php } else { ?>
      <div class="page-content mx-auto mt-2">
    <form action="" method="post">
        <h3 class="text-center">Employment Information</h3>



        <div class="col-md-8 mx-auto">
                <div class="card mb-3">
                  <div class="card-body">
                  <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Current Job</h6>
                      </div>
                      <div class="col-sm-9 text-warning">
                      <span class="text-capitalize">No Current Job</span>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Company</h6>
                      </div>
                      <div class="col-sm-9 text-warning">
                      <span class="text-capitalize">No Current Company</span>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Department</h6>
                      </div>
                      <div class="col-sm-9 text-warning">
                      <span class="text-capitalize">No Current Department</span>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Pay</h6>
                      </div>
                      <div class="col-sm-9 text-warning">
                      <span class="text-capitalize">$0.00</span>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Status</h6>
                      </div>
                      <div class="col-sm-9 text-warning">
                      <span class="text-capitalize">Admin</span>
                      </div>
                    </div>

                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Notes</h6>
                      </div>
                      <div class="col-sm-9 text-warning">
                        Admin doesn't obtain a job.
                      <!-- <a class="text-decoration-none badge text-bg-success" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">Edit</a> -->
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">View All Jobs</h6>
                      </div>
                      <div class="col-sm-9 text-warning">
                      <a class="text-decoration-none badge text-bg-primary" href="../admin/jobs.php">View</a>
                      </div>
                    </div>
                  </div>
                </div>
                
     </form>
    </div>
    <?php } ?>
  <!-- END ADMIN EMPLOYMENT INFO -->

  </div>
<!-- END MAIN -->

<!-- START MODAL -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

    <?php 
    $id = $_SESSION['employee_idno'];
    $select = " SELECT * FROM job WHERE employee_idno = '$id' AND status = 'active' ";
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
          <!-- <input class="form-control" id="employee_fname" type="hidden" name="employee_fname" value="<?php //echo $fname; ?>">
          <input class="form-control" id="employee_lname" type="hidden" name="employee_lname" value="<?php //echo $lname; ?>">
          <input class="form-control" id="employee_idno" type="hidden" name="employee_idno" value="<?php //echo $employee_idno; ?>"> -->
        <div class="form-group pt-3 mx-auto" style="width: 95%;">
          <label for="jobtitle" style="font-size: 14px;">Date <span class="text-muted" style="font-size: 10px;">e.g. "mm/dd/yyyy"</span></label>
          <input class="form-control" id="jobtitle" type="text" name="jobtitle" value="<?php echo $row['jobtitle']; ?>" required>
        </div>
        <div class="form-group pt-3 mx-auto" style="width: 95%;">
          <label for="companyname" style="font-size: 14px;">Time In <span class="text-muted" style="font-size: 10px;">e.g. "hh:mm"</span></label>
          <input class="form-control" id="companyname" type="text" name="companyname" value="<?php echo $row['companyname']; ?>" required>
        </div>
        <div class="form-group pt-3 mx-auto" style="width: 95%;">
          <label for="deptname" style="font-size: 14px;">Time Out <span class="text-muted" style="font-size: 10px;">e.g. "hh:mm"</span></label>
          <input class="form-control" id="deptname" type="text" name="deptname" value="<?php echo $row['deptname']; ?>" required>
        </div>
        <div class="form-group pt-3 mx-auto" style="width: 95%;">
          <label for="reason" style="font-size: 14px;">Reason <span class="text-muted" style="font-size: 10px;">Give reason for changing time</span></label>
          <textarea class="form-control" id="reason" type="text" name="reason" value="" required></textarea>
        </div>

        <div class="form-group pt-3 mx-auto d-grid d-md-flex justify-content-md-end" style="width: 95%; margin-bottom: 10px;">
          <button type="submit" style="border-color: rgba(0,0,0,0);" name="update-job" class="badge text-bg-secondary">Update Job</button>
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