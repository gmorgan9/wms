<!-- WORKING -->
<?php

require_once "../app/database/connection.php";
require_once "../app/database/functions.php";
require_once "../path.php";

session_start();

if(!isLoggedIn()){
   header('location:' . BASE_URL . '/pages/entry/login.php');
}



$empID = $_SESSION['empID'];
$select = " SELECT * FROM employee WHERE employeeID = '$empID' ";
$result = mysqli_query($conn, $select);
if(isset($_POST['update-profile'])){

   $fname = mysqli_real_escape_string($conn, $_POST['fname']);
   $lname = mysqli_real_escape_string($conn, $_POST['lname']);
   $uname = mysqli_real_escape_string($conn, $_POST['uname']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $gender = mysqli_real_escape_string($conn, $_POST['gender']);

   $update_select = " SELECT * FROM employee WHERE uname = '$uname' && email = '$email' ";

   $update_result = mysqli_query($conn, $update_select);

   if(mysqli_num_rows($result) > 0){

      $update = "UPDATE employee SET fname = '$fname', lname = '$lname', uname = '$uname', email = '$email', gender = '$gender' where employeeID = '$empID' ";
      mysqli_query($conn, $update);
      $success[] = 'Success';
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } 
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | Admin Profile</title>

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
<?php 

$empID = $_SESSION['empID'];
$select = " SELECT * FROM employee WHERE employeeID = '$empID' ";
$result = mysqli_query($conn, $select);
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      $acc_type = $row['acc_type'];
?>

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Profile</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Employee Profile</li>
    </ul>
  </div>




<div class="page-content mx-auto mt-2">
<form action="" method="post">
      <h3 class="mx-auto" style="width: 95%;">My Profile</h3>


      <div class="col-md-8 float-start w-25" style="margin-top: 45px;">
              <div class="card mb-3">
                <div class="card-body">
                  <img class="ms-1" src="../../assets/img/pic_holder.jpg" style="height: 250px; width: 250px; border-radius: 150px;" alt="">
                  </div>
                </div>
              </div>
              <div class="col-md-8 float-start w-25 ms-4">
              <div class="card mb-3">
                <div class="card-body">
                  <img class="ms-1" src="../../assets/img/pic_holder.jpg" style="height: 250px; width: 250px; border-radius: 150px;" alt="">
                  </div>
                </div>
              </div>



      <div class="col-md-8 float-end me-4">
              <div class="card mb-3">
                <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Account Type</h6>
                    </div>
                    <div class="col-sm-9 text-info">
                    <?php if($row['acc_type'] == 1) { ?>
                        Admin
                     <?php } if($row['acc_type'] == 0) { ?>
                        Employee
                     <?php } ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Employee</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <span class="text-capitalize"><?php echo $row['lname']; ?>, <?php echo $row['fname']; ?> &nbsp; (<?php echo $row['idno']; ?>)</span>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Username</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $row['uname']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email <span class="text-muted" style="font-size: 10px;">Personal</span></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                     <?php echo $row['email']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Gender</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <span class="text-capitalize"><?php echo $row['gender']; ?></span>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Employment Status</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php if($row['status'] == 1) { ?>
                        <span class="text-success">Active</span>
                     <?php } if($row['status'] == 0) { ?>
                        <span class="text-danger">Inactive</span>
                     <?php } ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Actions</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <a style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#editEmployee" class="badge text-bg-primary" href="#">Edit</a>
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

 
<!-- end MAIN -->
</div> 


<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>


<!-- Modal -->
<div class="modal fade" id="editEmployee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit My Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

<?php 
//$id = $_GET['employeeID'];
$select = " SELECT * FROM employee WHERE employeeID = '$empID' ";
$result = mysqli_query($conn, $select);

if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
    ?>

<form action="" method="post">
    <!-- <div class="section-header pt-2">
      <span class="text-muted pt-4" style="width: 95%;"></span>
    </div> -->
    <!-- <hr style="margin-bottom: -5px; margin-top: 5px;"> -->
    <?php 
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname']; 
    $employee_idno = $_SESSION['employee_idno'];?>
      <!-- <input class="form-control" id="fname" type="text" name="fname" value="<?php //echo $fname; ?>"> -->
      <!-- <input class="form-control" id="lname" type="text" name="lname" value="<?php //echo $lname; ?>"> -->
      <!-- <input class="form-control" id="idno" type="text" name="idno" value="<?php //echo $idno; ?>"> -->
    <div class="form-group pt-3" style="width: 35%;">
      <label for="idno" style="font-size: 14px;">Employee ID</label>
      <input class="form-control" id="idno" type="text" name="idno" value="<?php echo $row['idno']; ?>" disabled>
    </div>
    <div class="row">
      <div class="form-group pt-3" style="width: 50%;">
        <label for="fname" style="font-size: 14px;">First Name</label>
        <input class="form-control" id="fname" type="text" name="fname" value="<?php echo $row['fname']; ?>" required>
      </div>
      <div class="form-group pt-3" style="width: 50%;">
        <label for="lname" style="font-size: 14px;">Last Name</label>
        <input class="form-control" id="lname" type="text" name="lname" value="<?php echo $row['lname']; ?>" required>
      </div>
    </div>
    <div class="row">
      <div class="form-group pt-3" style="width: 50%;">
        <label for="uname" style="font-size: 14px;">User Name</label>
        <input class="form-control" id="uname" type="text" name="uname" value="<?php echo $row['uname']; ?>" required>
      </div>
      <div class="form-group pt-3" style="width: 50%;">
        <label for="gender" style="font-size: 14px;">Gender</label>
        <input class="form-control" id="gender" type="text" name="gender" value="<?php echo $row['gender']; ?>" required>
      </div>
    </div>
    <div class="form-group pt-3">
      <label for="email" style="font-size: 14px;">Email <span class="text-muted" style="font-size: 10px;">Personal</span></label>
      <input class="form-control" id="email" type="email" name="email" value="<?php echo $row['email']; ?>" required>
    </div>
    <div class="form-group pt-3">
      <label for="avatar" style="font-size: 14px;">Profile Picture</label>
      <input class="form-control" id="avatar" type="file" name="avatar" value="<?php echo $row['avatar']; ?>">
    </div>
    
    
    
    

              <?php }} ?>






      </div>
      <div class="modal-footer">
        <div class="form-group pt-3" style="margin-bottom: 10px;">
          <button type="button" style="border-color: rgba(0,0,0,0);" class="badge text-bg-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" style="border-color: rgba(0,0,0,0);" name="update-profile" class="badge text-bg-secondary">Update Profile</button>
        </div>
      </div>
      </form>
    </div>
  </div>
  <!-- end modal -->
</div>

</body>
</html>