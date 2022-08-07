<!-- WORKING -->
<?php

require_once "../app/database/connection.php";
require_once "../app/database/functions.php";
require_once "../path.php";

session_start();

if(!isLoggedIn()){
   header('location: /login.php');
}
if(!isAdmin()){
  header('location: /dashboard.php');
}


$empID = $_SESSION['empID'];
$select = " SELECT * FROM employee WHERE employeeID = '$empID' ";
$result = mysqli_query($conn, $select);

if(isset($_POST['update-profile'])){

   $employeeID   = mysqli_real_escape_string($conn, $_POST['employeeID']);
   $fname = mysqli_real_escape_string($conn, $_POST['fname']);
   $lname = mysqli_real_escape_string($conn, $_POST['lname']);
   $uname = mysqli_real_escape_string($conn, $_POST['uname']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   // $pass = md5($_POST['password']);
   // $cpass = md5($_POST['cpassword']);
   // $isadmin = $_POST['isadmin'];

   $update_select = " SELECT * FROM employee WHERE uname = '$uname' && email = '$email' ";

   $update_result = mysqli_query($conn, $update_select);

   if(mysqli_num_rows($result) > 0){

      // $error[] = 'user already exist!';
      $update = "UPDATE employee SET fname = '$fname', lname = '$lname', uname = '$uname', email = '$email' where employeeID = '$empID' ";
      mysqli_query($conn, $update);
      $success[] = 'Success';
      header('location:' . BASE_URL . '/admin/profile.php');
      
   }else{
      
   } 
};

// Delete User
if(isset($_GET['employeeID'])) {
    $id = $_GET['employeeID'];

    $sql = "DELETE FROM employee WHERE employeeID = $id";
    $delete = mysqli_query($conn, $sql);
    if($delete) {
        // echo "Deleted Successfully";
        header('location: employees.php'); // returns back to same page
    } else {
        die(mysqli_error($conn));
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | Employees</title>

   <!-- Custom Styles -->
   <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/other-style.css?v='. time(); ?>">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

<!-- scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

   
<!-- <div class="land-container">
   <div class="content">

      <h3><span>Admin Profile Page</span></h3>
      <h1>welcome <span><?php //echo $_SESSION['admin_fname'] ?></span></h1>
      <p>this is an admin profile</p>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div> -->

<?php include(ROOT_PATH . "/app/includes/header.php"); ?>


<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
        
<!-- start MAIN -->
<div class="main"> 
   
<?php 

if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
?>

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Employees</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Employees</li>
    </ul>
  </div>

  <!-- <div class="jumbotron jumbotron-fluid bg-white m-2 mx-auto" style="width: 98%;">
  <div class="container">
    <h3 class="display-6 text-center" style="padding-top: 5px !important;padding-bottom: 10px !important;">Welcome, <span style="text-transform: capitalize;"><?php //echo $row['fname'] ?>!</span></h3>
  </div>
</div> -->

<!-- start PAGE-CONTENT -->
<div class="page-content mx-auto mt-2">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">ID #</th>
      <th scope="col">Employee</th>
      <th scope="col">Company</th>
      <th scope="col">Department</th>
      <th scope="col">Postion</th>
      <th scope="col">Status</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">

  <?php
      $sql = "SELECT * FROM employee";
      $all = mysqli_query($conn, $sql);
      if($all) {
          while ($row = mysqli_fetch_assoc($all)) {
            $empID     = $row['employeeID'];
            $idno      = $row['idno'];
            $fname     = $row['fname'];
            $lname     = $row['lname'];
            $uname     = $row['uname'];
            $email     = $row['email'];
            $acc_type  = $row['acc_type'];
            $status    = $row['status'];
            ?>
    <tr>
        <?php if($_SESSION['empID'] != $row['employeeID']){ ?>
        <th scope="row"><?php echo $idno; ?></th>
        <td><?php echo $lname; ?>, <?php echo $fname; ?></td>
        <!-- <?php //if($acc_type == 1){ ?>
          <td>Admin</td>
        <?php //} else { ?>
          <td>Employee</td>
        <?php //} ?> -->
        <?php if($status == 1){ ?>
          <td>Active</td>
        <?php } else { ?>
          <td>Inactive</td>
        <?php } ?>
        <td>
          <a style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#editEmployee" class="badge text-bg-primary" href="actions/edit-employee.php?employeeID=<?php echo $empID; ?>">Edit</a>
          <a style="text-decoration: none;" class="badge text-bg-success" href="actions/view-employee.php?employeeID=<?php echo $empID; ?>">View</a>
          <a style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#confirmDelete" class="badge text-bg-danger" href="employees.php?employeeID=<?php echo $empID; ?>">Delete</a>
        </td>
        <?php } else { }}}?>
  </tbody>
</table>
      <?php 
      }
   } else {
     echo "0 results";
   }
      ?>
 
 <!-- end PAGE-CONTENT -->
</div>



<!-- EDIT Modal -->
<div class="modal fade" id="editEmployee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Employee Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php 
          $new = "SELECT * FROM employee where employeeID = '$empID'";
          $newa = mysqli_query($conn, $new);
          if($newa) {
              while ($row = mysqli_fetch_assoc($newa)) {
                $empID   = $row['employeeID'];
                $fname    = $row['fname'];
        ?>
       
        <span class="badge text-bg-danger" style="font-size: 10px;">Be Careful! This will delete all data corresponding with this employee!</span>
       <br>
       
        <div class="conatiner">
          <div class="row">
            <div class="col">

            <?php 
            $id = $_GET['employeeID'];
            $select = " SELECT * FROM employee WHERE employeeID = '$empID' ";
            $result = mysqli_query($conn, $select);          
            if (mysqli_num_rows($result) > 0) {
               while($row = mysqli_fetch_assoc($result)) {
                  $acc_type = $row['acc_type'];
            ?>

            <form action="" method="post">
              <span class="mx-auto text-muted" style="padding-top: 10px; width: 95%;">Personal Information</span>
              <hr>
              <div class="form-group pt-1" style="width: 30%;">
                <label for="idno">Company</label>
                <input class="form-control" id="idno" type="text" value="<?php echo $row['idno']; ?>" name="idno" required>
              </div>
              <div class="form-group pt-3 mx-auto" style="width: 95%;">
                <label for="status">Department</label>
                <input class="form-control" id="idno" type="text" value="<?php echo $row['idno']; ?>" name="idno" required>
              </div>
              <div class="form-group pt-1 mx-auto" style="width: 95%;">
                <label for="fname">Job Title / Position</label>
                <input class="form-control" id="fname" type="text" name="fname" value="<?php echo $row['fname']; ?>" required>
              </div>
              <div class="form-group pt-3 mx-auto" style="width: 95%;">
                <label for="lname">Company Email</label>
                <input class="form-control" id="lname" type="text" name="lname" value="<?php echo $row['lname']; ?>" required>
              </div>
              <span class="mx-auto text-muted" style="padding-top: 10px; width: 95%;">Employment Information</span>
              <hr>
              <div class="form-group pt-3 mx-auto" style="width: 95%;">
                <label for="uname">Employment Type</label>
                <input class="form-control" id="uname" type="text" name="uname" value="<?php echo $row['uname']; ?>" required>
              </div>   
              <div class="form-group pt-3 mx-auto" style="width: 95%;">
                <label for="email">Employee Status</label>
                <input class="form-control" id="email" type="email" name="email" value="<?php echo $row['email']; ?>" required>
              </div> 
              <div class="form-group pt-3 mx-auto" style="width: 95%;">
                <label for="email">Official Start Date</label>
                <input class="form-control" id="email" type="email" name="email" value="<?php echo $row['email']; ?>" required>
              </div> 
              <?php 
                }
              } else {
                echo "0 results";
              }
              ?>
            </form>
              
            


            </div>
            <div class="col">



            <?php 
            $id = $_GET['employeeID'];
            $new = " SELECT * FROM employee WHERE employeeID = '$empID' ";
            $newresult = mysqli_query($conn, $new);          
            if (mysqli_num_rows($newresult) > 0) {
               while($newrow = mysqli_fetch_assoc($newresult)) {
                  $acc_type = $newrow['acc_type'];
            ?>

            <form action="" method="post">
              <span class="mx-auto text-muted" style="padding-top: 10px; width: 95%;">Personal Information</span>
              <hr>
              <div class="form-group pt-1 mx-auto" style="width: 95%;">
                <label for="idno">Company</label>
                <input class="form-control" id="idno" type="text" value="<?php echo $newrow['idno']; ?>" name="idno" required>
              </div>
              <div class="form-group pt-3 mx-auto" style="width: 95%;">
                <label for="status">Department</label>
                <input class="form-control" id="idno" type="text" value="<?php echo $row['idno']; ?>" name="idno" required>
              </div>
              <div class="form-group pt-1 mx-auto" style="width: 95%;">
                <label for="fname">Job Title / Position</label>
                <input class="form-control" id="fname" type="text" name="fname" value="<?php echo $row['fname']; ?>" required>
              </div>
              <div class="form-group pt-3 mx-auto" style="width: 95%;">
                <label for="lname">Company Email</label>
                <input class="form-control" id="lname" type="text" name="lname" value="<?php echo $row['lname']; ?>" required>
              </div>
              <span class="mx-auto text-muted" style="padding-top: 10px; width: 95%;">Employment Information</span>
              <hr>
              <div class="form-group pt-3 mx-auto" style="width: 95%;">
                <label for="uname">Employment Type</label>
                <input class="form-control" id="uname" type="text" name="uname" value="<?php echo $row['uname']; ?>" required>
              </div>   
              <div class="form-group pt-3 mx-auto" style="width: 95%;">
                <label for="email">Employee Status</label>
                <input class="form-control" id="email" type="email" name="email" value="<?php echo $row['email']; ?>" required>
              </div> 
              <div class="form-group pt-3 mx-auto" style="width: 95%;">
                <label for="email">Official Start Date</label>
                <input class="form-control" id="email" type="email" name="email" value="<?php echo $row['email']; ?>" required>
              </div> 
              <?php 
                }
              } else {
                echo "0 results";
              }
              ?>
            </form>


            <!-- end col -->
            </div>
          </div>
        </div>









        <?php }
        } ?>
      </div>
      <div class="modal-footer">
        <a class="badge text-bg-primary" style="text-decoration: none; cursor: pointer;" data-bs-dismiss="modal">Cancel</a>
        <a class="badge text-bg-success" style="text-decoration: none; cursor: pointer;" href="employees.php?employeeID=<?php echo $empID; ?>">Save</a>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <a href=""></a>
      </div>
    </div>
  </div>
</div>

<!-- DELETE Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Employee Deletion Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php 
          $new = "SELECT * FROM employee where employeeID = '$empID'";
          $newa = mysqli_query($conn, $new);
          if($newa) {
              while ($row = mysqli_fetch_assoc($newa)) {
                $empID   = $row['employeeID'];
                $fname    = $row['fname'];
        ?>
       
        <span class="badge text-bg-danger" style="font-size: 10px;">Be Careful! This will delete all data corresponding with this employee!</span>
        <br>
        <br>
        Are you sure you want to delete: <span class="text-muted"><?php echo $fname; ?></span>?
        <?php }
        } ?>
      </div>
      <div class="modal-footer">
        <a class="badge text-bg-primary" style="text-decoration: none; cursor: pointer;" data-bs-dismiss="modal">Cancel</a>
        <a class="badge text-bg-danger" style="text-decoration: none; cursor: pointer;" href="employees.php?employeeID=<?php echo $empID; ?>">Delete</a>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <a href=""></a>
      </div>
    </div>
  </div>
</div>

 
<!-- end MAIN -->
</div> 


<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>