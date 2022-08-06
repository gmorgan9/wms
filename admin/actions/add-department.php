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


// $compID = $_SESSION['empID'];
// $select = " SELECT * FROM employee WHERE employeeID = '$empID' ";
// $result = mysqli_query($conn, $select);

if(isset($_POST['add-department'])){

    $deptID = mysqli_real_escape_string($conn, $_POST['deptID']);
    $idno  = rand(1000000, 9999999); // figure how to not allow duplicates
    $deptname = mysqli_real_escape_string($conn, $_POST['deptname']);
    $compID = mysqli_real_escape_string($conn, $_POST['companyID']);
 
    $select = " SELECT * FROM department WHERE deptname = '$deptname' ";
 
    $result = mysqli_query($conn, $select);
 
    if(mysqli_num_rows($result) > 0){
 
       $error[] = 'Department already exist!';
 
    }else{
          $insert = "INSERT INTO department (idno, deptname, companyID) VALUES ('$idno', '$deptname', '$compID')";
          mysqli_query($conn, $insert);
          header('location: /admin/departments.php');
       }
 
 };
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | Add Department</title>

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

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Add Department</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li><a href="<?php echo BASE_URL . '/admin/departments.php' ?>">Departments</a></li>
      <li>Add Department</li>
    </ul>
  </div>

<div class="page-content mx-auto mt-2">
<form action="" method="post">
      <h3 class="mx-auto" style="width: 95%;">Add Department</h3>
      <?php
       if(isset($error)){
          foreach($error as $error){
             echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?> 
      <div class="row" style="margin-left: 20px;">
      <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="deptname">Department Name</label>
            <input class="form-control" id="deptname" type="text" name="deptname" value="" required>
         </div>

         <?php 
    $query ="SELECT company.companyname FROM department INNER JOIN company ON departments.deptID=company.companyID;";
    $result = $conn->query($query);
    if($result->num_rows> 0){
      $options= mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
?>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="companyID">Department Name</label>
            <select class="form-control" name="companyID" id="companyID">
                <?php foreach($options as $option) { ?>                         
                    <option><?php echo $option['companyID']; ?></option>
                <?php } ?>
            </select>
         </div>




          

      <div class="form-group pt-3 mx-auto" style="width: 95%; margin-bottom: 10px;">
      <input type="submit" name="add-department" value="Add Department" class="btn btn-secondary">
 
   </form>
</div>

 
<!-- end MAIN -->
</div> 


<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>