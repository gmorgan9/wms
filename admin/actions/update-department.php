<!-- WORKING -->
<?php

require_once "../../app/database/connection.php";
require_once "../../app/database/functions.php";
require_once "../../path.php";

session_start();

if(!isLoggedIn()){
   header('location:' . BASE_URL . '/pages/entry/login.php');
}
if(!isAdmin()){
   header('location:' . BASE_URL . '/pages/dashboard.php');
}


$id = $_GET['deptID'];
$select = " SELECT * FROM department WHERE deptID = '$id' ";
$result = mysqli_query($conn, $select);


if(isset($_POST['update-department'])){

   $deptID   = mysqli_real_escape_string($conn, $_POST['deptID']);
   $deptname = mysqli_real_escape_string($conn, $_POST['deptname']);
   //$companyID = mysqli_real_escape_string($conn, $_POST['companyID']);

   if(mysqli_num_rows($result) > 0){

      // $error[] = 'user already exist!';
      $update = "UPDATE department SET deptname = '$deptname' where deptID = '$id' ";
      mysqli_query($conn, $update);
      // $success[] = 'Success';
      header('location:' . BASE_URL . '/admin/departments.php');
      
   }else{
      
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

</head>
<body>

<?php include(ROOT_PATH . "/app/includes/header.php"); ?>


<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
        
<!-- start MAIN -->
<div class="main"> 
   
<?php 

if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
?>

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Update Department</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li><a href="<?php echo BASE_URL . '/admin/departments.php' ?>">Departments</a></li>
      <li>Update Department</li>
    </ul>
  </div>

<div class="page-content mx-auto mt-2">
<form action="" method="post">
      <h3 class="mx-auto" style="width: 95%;">Admin Profile</h3>
      <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="deptID">Department ID</label>
            <input class="form-control" style="width: 20%" id="deptID" type="text" value="<?php echo $row['deptID']; ?>" name="deptID" disabled>
         </div>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="deptname">Department Name</label>
            <input class="form-control" id="deptname" type="text" name="deptname" value="<?php echo $row['deptname']; ?>" required>
         </div>
      <div class="form-group pt-3 mx-auto" style="width: 95%; margin-bottom: 10px;">
      <input type="submit" name="update-department" value="Update Company" class="btn btn-secondary">
      <?php 
      }
   } else {
     echo "0 results";
   }
      ?>
   </form>
</div>

<!-- end MAIN -->
</div> 


<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>