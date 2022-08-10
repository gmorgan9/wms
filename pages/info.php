<!-- WORKING -->
<?php
require_once "../app/database/connection.php";
require_once "../app/database/functions.php";
require_once "../path.php";
session_start();

if(!isLoggedIn()){
  header('location:' . BASE_URL . '/pages/entry/login.php');
}

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

    <style>
      
    </style>


    <title>ETES | Information</title>
</head>
<body>
    
<?php include(ROOT_PATH . "/app/includes/header.php"); ?>


<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
        
<div class="main">
  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Employee Information</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Information</li>
    </ul>
  </div>

  <?php 

$empID = $_SESSION['employee_idno'];
$select = " SELECT * FROM job WHERE employee_idno = '$empID' ";
$result = mysqli_query($conn, $select);
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      //$acc_type = $row['acc_type'];
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
                    <span class="text-capitalize"><?php echo $row['jobtitle']; ?></span>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Company</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <span class="text-capitalize"><?php echo $row['companyname']; ?></span>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Department</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <span class="text-capitalize"><?php echo $row['deptname']; ?></span>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Pay</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <span class="text-capitalize">$<?php echo $row['pay']; ?>.00</span>
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
     echo "0 results" . $_SESSION['empID'];
   }
      ?>
   </form>
</div>








</div>
<!-- END MAIN -->


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
  $select = " SELECT * FROM job WHERE employee_idno = '$id' ";
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
        <label for="new_date" style="font-size: 14px;">Date <span class="text-muted" style="font-size: 10px;">e.g. "mm/dd/yyyy"</span></label>
        <input class="form-control" id="new_date" type="date" name="new_date" value="<?php echo $row['idno']; ?>" required>
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