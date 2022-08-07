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

// Add Department
if(isset($_POST['add-department'])){

  $deptID = mysqli_real_escape_string($conn, $_POST['deptID']);
  $idno  = rand(1000000, 9999999); // figure how to not allow duplicates
  $deptname = mysqli_real_escape_string($conn, $_POST['deptname']);
  //$compID = mysqli_real_escape_string($conn, $_POST['companyID']);

  $select = " SELECT * FROM department WHERE deptname = '$deptname' ";

  $result = mysqli_query($conn, $select);

  if(mysqli_num_rows($result) > 0){

     $error[] = 'Department already exist!';

  }else{
        $insert = "INSERT INTO department (idno, deptname) VALUES('$idno', '$deptname')";
        mysqli_query($conn, $insert);
        header('location: /admin/departments.php');
     }

};

// Delete Department
if(isset($_GET['deptID'])) {
    $id = $_GET['deptID'];

    $sql = "DELETE FROM department WHERE deptID = $id";
    $delete = mysqli_query($conn, $sql);
    if($delete) {
        // echo "Deleted Successfully";
        header('location: departments.php'); // returns back to same page
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
   <title>WMS | Jobs</title>

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

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Jobs</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Jobs</li>
    </ul>
  </div>

  <!-- <div class="jumbotron jumbotron-fluid bg-white m-2 mx-auto" style="width: 98%;">
  <div class="container">
    <h3 class="display-6 text-center" style="padding-top: 5px !important;padding-bottom: 10px !important;">Welcome, <span style="text-transform: capitalize;"><?php //echo $row['fname'] ?>!</span></h3>
  </div>
</div> -->


<!-- start PAGE-CONTENT -->
<div class="page-content float-start" style="margin-top: 12px; width: 32%;margin-left: -45px;">
  <form action="" method="post">
    <!-- <h6 class="mx-auto" style="width: 95%;">Add Company</h6> -->
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="jobtitle" style="font-size: 14px;">Job Title <span class="text-muted" style="font-size: 10px;">e.g. "Cheif Executive Officer"</span></label>
      <!-- <input class="form-control" id="jobtitle" type="text" name="jobtitle" value="" required> -->
      <select class="form-control" name="jobtitle" id="jobtitle">

      </select>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="jobtitle" style="font-size: 14px;">Job Title <span class="text-muted" style="font-size: 10px;">e.g. "Cheif Executive Officer"</span></label>
      <input class="form-control" id="jobtitle" type="text" name="jobtitle" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto d-grid d-md-flex justify-content-md-end" style="width: 95%; margin-bottom: 10px;">
      <button type="submit" style="border-color: rgba(0,0,0,0);" name="add-job" class="badge text-bg-secondary">Add Job</button>
    </div>
  </form>

 <!-- end PAGE-CONTENT -->
</div>

<!-- start PAGE-CONTENT -->
<div class="page-content mt-2 float-end" style="width: 65%; margin-right: 10px;">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">ID #</th>
      <th scope="col">Department Name</th>
      <!-- <th scope="col">City</th>
      <th scope="col">State</th>
      <th scope="col">Zip Code</th> -->
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">

  <?php
      $sql = "SELECT * FROM department";
      $all = mysqli_query($conn, $sql);
      if($all) {
          while ($row = mysqli_fetch_assoc($all)) {
            $deptID   = $row['deptID'];
            $idno     = $row['idno'];
            $deptname    = $row['deptname'];
            //$compID    = $row['compID'];
  ?>
    <tr>
        <th scope="row"><?php echo $idno; ?></th>
        <td><?php echo $deptname; ?></td>
        <td><a style="text-decoration: none;" class="badge text-bg-danger" href="departments.php?deptID=<?php echo $deptID; ?>">Delete</a></td>
        <?php } ?>
        
   
      </tbody>
</table> 
<?php 
     
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