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
if(!isAdmin()){
   header('location:' . BASE_URL . '/pages/dashboard.php');
}

// UPDATE TIME FUNCTION
  if(isset($_POST['update-job'])){
    $id = $_GET['jobID'];
    $timeID = mysqli_real_escape_string($conn, $_POST['jobID']);
    $idno  = rand(1000000, 9999999); // figure how to not allow duplicates
    $jobtitle = mysqli_real_escape_string($conn, $_POST['jobtitle']);
    $companyname = mysqli_real_escape_string($conn, $_POST['companyname']);
    $deptname = mysqli_real_escape_string($conn, $_POST['deptname']);
    $pay = mysqli_real_escape_string($conn, $_POST['pay']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $employee_fname = mysqli_real_escape_string($conn, $_POST['employee_fname']);
    $employee_lname = mysqli_real_escape_string($conn, $_POST['employee_lname']);
    $employee_idno = mysqli_real_escape_string($conn, $_POST['employee_idno']);

    if($end_date == null) {
      $update = "UPDATE job SET approval_status = 'approved', jobtitle = '$jobtitle', companyname = '$companyname', deptname = '$deptname', pay = '$pay', start_date = '$start_date', end_date = null, status = 'active', note = '$note' WHERE jobID = '$id'";
      mysqli_query($conn, $update);
      header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
      $update = "UPDATE job SET approval_status = 'approved', jobtitle = '$jobtitle', companyname = '$companyname', deptname = '$deptname', pay = '$pay', start_date = '$start_date', end_date = '$end_date', status = 'active', note = '$note' WHERE jobID = '$id'";
      mysqli_query($conn, $update);
      header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
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
   
  <?php 

  $id = $_GET['jobID'];
  $select = " SELECT * FROM job WHERE jobID = '$id' ";
  $result = mysqli_query($conn, $select);

  if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      //$acc_type = $row['acc_type'];
  ?>

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;"></p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li><a href="<?php echo BASE_URL . '/admin/jobs.php' ?>">Jobs</a></li>
      <li>Viewing Job: <span class="text-muted" style="text-transform: capitalize"><?php echo $row['jobtitle']; ?>  </span></li>
    </ul>
  </div>

  <div class="page-content mx-auto mt-2">
  <form action="" method="post">
      <h3 class="text-center">Job View</h3>


      <div class="col-md-8 mx-auto">
              <div class="card mb-3">
                <div class="card-body">
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
                      <h6 class="mb-0">Job Title / Position</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $row['jobtitle']; ?> &nbsp; (<?php echo $row['idno']; ?>)
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Company</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $row['companyname']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Department</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php echo $row['deptname']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Start Date</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php if($row['start_date'] == null) { ?>
                        <span class="text-warning">Needs a Start Date</span>
                      <?php } else { ?>
                        <?php echo $row['start_date']; ?>
                      <?php } ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">End Date</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php if($row['end_date'] == null) { ?>
                        <span class="text-warning">Enter end date when job is terminated.</span>
                      <?php } else { ?>
                        <?php echo $row['end_date']; ?>
                      <?php } ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Pay</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php if($row['pay'] == null) { ?>
                        <span class="text-warning">Needs a Pay/Salary.</span>
                      <?php } else { ?>
                        $<?php echo $row['pay']; ?>.00
                      <?php } ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Status</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php if($row['approval_status'] == 'approved') { ?>
                            <span class="text-success text-capitalize"><?php echo $row['approval_status']; ?></span>
                        <?php } if($row['approval_status'] == 'rejected') { ?>
                            <span class="text-danger text-capitalize"><?php echo $row['approval_status']; ?></span>
                        <?php } if($row['approval_status'] == 'pending') { ?>
                            <span class="text-primary text-capitalize"><?php echo $row['approval_status']; ?></span>
                        <?php } if($row['approval_status'] == 'terminated') { ?>
                            <span class="text-danger"><span class="text-capitalize"><?php echo $row['approval_status']; ?></span>
                            <span class="text-muted" style="font-size: 10px;">Most likely will need to be deleted</span></span>
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
                    <a class="text-decoration-none badge text-bg-primary" href="javascript:history.back()">Back</a>
                    </div>
                  </div>

                  <!-- end -->
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

 

  </div> 
<!-- end MAIN -->

<!-- EDIT MODAL -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Job</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

  <?php 
  $id = $_GET['jobID'];
  $select = " SELECT * FROM job WHERE jobID = '$id' ";
  $result = mysqli_query($conn, $select);

  if (mysqli_num_rows($result) > 0) {
     while($row = mysqli_fetch_assoc($result)) {
      ?>

  <form action="" method="post">
      <div class="section-header pt-2">
        <span class="text-muted pt-4" style="width: 95%;">Job Info</span>
      </div>
      <hr style="margin-bottom: -5px; margin-top: 5px;">
        <input class="form-control" id="employee_fname" type="hidden" name="employee_fname" value="<?php echo $row['employee_fname']; ?>">
        <input class="form-control" id="employee_lname" type="hidden" name="employee_lname" value="<?php echo $row['employee_lname']; ?>">
        <input class="form-control" id="employee_idno" type="hidden" name="employee_idno" value="<?php echo $row['employee_idno']; ?>">
      <div class="row">
        <div class="form-group pt-3" style="width: 48%;">
          <label for="companyname" style="font-size: 14px;">Company <span class="text-muted" style="font-size: 10px;">e.g. "Apple Corporation"</span></label>
          <input class="form-control" id="companyname" type="text" name="companyname" value="<?php echo $row['companyname']; ?>" required>
        </div>
        <div class="form-group pt-3" style="width: 48%;">
          <label for="deptname" style="font-size: 14px;">Department <span class="text-muted" style="font-size: 10px;">e.g. "Accounting"</span></label>
          <input class="form-control" id="deptname" type="text" name="deptname" value="<?php echo $row['deptname']; ?>" required>
        </div>
      </div>
      <div class="form-group pt-3">
        <label for="jobtitle" style="font-size: 14px;">Job Title / Position <span class="text-muted" style="font-size: 10px;">e.g. "Cheif Executive Officer"</span></label>
        <input class="form-control" id="jobtitle" type="text" name="jobtitle" value="<?php echo $row['jobtitle']; ?>" required>
      </div>
      <div class="form-group pt-3">
        <label for="pay" style="font-size: 14px;">Pay</label>
        <input class="form-control" id="pay" type="text" name="pay" value="<?php echo $row['pay']; ?>">
      </div>
      <div class="form-group pt-3">
        <label for="start_date" style="font-size: 14px;">Start Date</label>
        <input class="form-control" id="start_date" type="date" name="start_date" value="<?php echo $row['start_date']; ?>">
      </div>
      <?php if($row['end_date'] == null) { ?>
        <div class="form-group pt-3">
          <label for="end_date" style="font-size: 14px;">End Date</label>
          <input class="form-control" id="end_date" type="date" name="end_date" value="null">
        </div>
      <?php } else { ?>
        <div class="form-group pt-3">
          <label for="end_date" style="font-size: 14px;">End Date</label>
          <input class="form-control" id="end_date" type="date" name="end_date" value="<?php echo $row['end_date']; ?>">
        </div>
      <?php } ?>
      <div class="form-group pt-3">
        <label for="note" style="font-size: 14px;">Notes</label>
        <textarea class="form-control" id="note" type="text" name="note"><?php echo $row['note']; ?></textarea>
      </div>
      </div>
        <div class="modal-footer">
          <div class="form-group pt-3">
            <button type="button" style="border-color: rgba(0,0,0,0);" class="badge text-bg-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" style="border-color: rgba(0,0,0,0);" name="update-job" class="badge text-bg-secondary">Approve</button>
          </div>
        </div>
        </form>
        <?php }} ?>
      </div>
    </div>
    
  </div>
<!-- END EDIT MODAL -->

<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>