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

   //$sID   = mysqli_real_escape_string($conn, $_POST['studentID']);
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

    $sql = "DELETE FROM employees WHERE employeeID = $id";
    $delete = mysqli_query($conn, $sql);
    if($delete) {
        // echo "Deleted Successfully";
        header('location: manage-users.php'); // returns back to same page
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
   <title>WMS | Users</title>

   <!-- Custom Styles -->
   <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/other-style.css?v='. time(); ?>">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

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
    <p class="page_title" style="float: left; padding-top: 2px;">Users</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Users</li>
    </ul>
  </div>

  <div class="jumbotron jumbotron-fluid bg-white m-2 mx-auto" style="width: 98%;">
  <div class="container">
    <h3 class="display-6 text-center" style="padding-top: 5px !important;padding-bottom: 10px !important;">Welcome, <span style="text-transform: capitalize;"><?php echo $row['fname'] ?>!</span></h3>
  </div>
</div>

<!-- start PAGE-CONTENT -->
<div class="page-content mx-auto">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">ID #</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
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
            $idno   =$row['idno'];
            $fname  = $row['fname'];
            $lname  = $row['lname'];
            $uname  = $row['uname'];
            $email  = $row['email'];
            $status = $row['acc_type'];
            ?>
    <tr>
        <?php 
        if($_SESSION['empID'] == $row['employeeID']){ 
        ?>
        <!-- <th class="bg-warning" scope="row"><?php //echo $idno; ?></th>
        <td class="bg-warning"><?php //echo $fname; ?></td>
        <td class="bg-warning"><?php //echo $lname; ?></td>
        <td class="bg-warning"><?php //echo $uname; ?></td>
        <td class="bg-warning"><?php //echo $email; ?></td>
        <?php //if($status == 1){ ?>
          <td class="bg-warning">Admin</td>
        <?php //} else { ?>
          <td class="bg-warning">Employee</td>
        <?php //} ?>
        <td class="bg-warning" colspan="2">
            <a style="text-decoration: none;" class="badge text-bg-primary" href="<?php //echo BASE_URL . '/admin/profile.php' ?>">My Profile</a>
        </td> -->

        <?php } else {?>
        <th scope="row"><?php echo $idno; ?></th>
        <td><?php echo $fname; ?></td>
        <td><?php echo $lname; ?></td>
        <td><?php echo $uname; ?></td>
        <td><?php echo $email; ?></td>
        <?php if($status == 1){ ?>
          <td>Admin</td>
        <?php } else { ?>
          <td>Employee</td>
        <?php } ?>
        <td>
          <a style="text-decoration: none;" class="badge text-bg-success" href="view-user.php?employeeID=<?php echo $employeeID; ?>">View</a>
          <a style="text-decoration: none;" class="badge text-bg-danger" href="manage-users.php?employeeID=<?php echo $employeeID; ?>">Delete</a>
        </td>
        <?php }}} ?>
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

 
<!-- end MAIN -->
</div> 


<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>