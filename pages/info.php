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

$empID = $_SESSION['empID'];
$select = " SELECT * FROM employee WHERE employeeID = '$empID' ";
$result = mysqli_query($conn, $select);
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      $acc_type = $row['acc_type'];
?>


  <div class="page-content mx-auto mt-2">
<form action="" method="post">
      <h3 class="mx-auto" style="width: 95%;">My Profile</h3>


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








</div>
<!-- END MAIN -->



<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>


</body>
</html>