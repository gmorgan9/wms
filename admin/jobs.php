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
if(isset($_POST['update-job'])){

  $jobID = mysqli_real_escape_string($conn, $_POST['jobID']);
  $idno  = rand(1000000, 9999999); // figure how to not allow duplicates
  $jobtitle = mysqli_real_escape_string($conn, $_POST['jobtitle']);
  $companyname = mysqli_real_escape_string($conn, $_POST['companyname']);
  $deptname = mysqli_real_escape_string($conn, $_POST['deptname']);

  $select = " SELECT * FROM job WHERE jobtitle = '$jobtitle' ";
  $result = mysqli_query($conn, $select);

  if(mysqli_num_rows($result) > 0){

     $error[] = 'Job already exist!';

  }else{
        // $insert2 = "INSERT INTO employee_company_data (employee_code, company_code, dept_code, job_code) SELECT employee_code, company_code, dept_code, jobID FROM job";
        $insert = "INSERT INTO job (idno, jobtitle, companyname, deptname) VALUES('$idno', '$jobtitle', '$companyname', '$deptname')";
        mysqli_query($conn, $insert);
        // mysqli_query($conn, $insert2);
        header('location: /admin/jobs.php');
     }

};



// Delete Department
if(isset($_GET['jobID'])) {
    $id = $_GET['jobID'];

    $sql = "DELETE FROM job WHERE jobID = $id";
    $delete = mysqli_query($conn, $sql);
    if($delete) {
        // echo "Deleted Successfully";
        header('location: jobs.php'); // returns back to same page
    } else {
        die(mysqli_error($conn));
    }
  }

  if(isset($_POST['approve'])) {
    $id = $_GET['jobID'];
    $jobID = mysqli_real_escape_string($conn, $_POST['jobID']);
    $app_status = mysqli_real_escape_string($conn, $_POST['approval_status']);
  
  
        $update = "UPDATE job SET approval_status = '$app_status' where jobID = '$id' ";
        mysqli_query($conn, $update);
        //$success[] = 'Success';
        header('location:' . BASE_URL . '/admin/jobs.php');
  };

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | Departments</title>

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
<div class="page-content float-start" style="margin-top: 12px; width: 32%;margin-left: -45px; height: unset !important;">
  <!-- <form action="" method="post"> -->
    <div class="section-header pt-2">
      <span class="text-muted pt-4" style="width: 95%;">Pending Job Requests</span>
    </div>
    <hr style="margin-bottom: -5px; margin-top: 5px;">
    <table class="table">
  <thead>
    <tr>
      <th scope="col" style="font-size: 14px;">Job Title / Position</th>
      <th scope="col" style="font-size: 14px;">Actions</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">

  <?php
      $sql = "SELECT * FROM job where approval_status = 'pending'";
      $result = mysqli_query($conn, $sql);
      if($result) {
          while ($row = mysqli_fetch_assoc($result)) {
            $jobID       = $row['jobID'];
            $idno        = $row['idno'];
            $jobtitle    = $row['jobtitle'];
            $companyname = $row['companyname'];
            $deptname    = $row['deptname'];
            $status      = $row['approval_status'];
            // $companyname    = $row['companyname'];
  ?>
    <tr>
        <th scope="row"><?php echo $jobtitle; ?></th>
        <td>
<form action="" method="post">
        <select name="approval_status" required class="">
					<option name="approval_status" value="">Choose your option</option>
				  <option name="approval_status" value="approved">Approved</option>
				  <option name="approval_status" value="rejected">Rejected</option>
				</select>
          
      
      
      </td>
        <td>
        <input type="submit" name="approve" value="approve" class="btn btn-success btn-sm">
          </form>
          <!-- <a style="text-decoration: none;" class="badge text-bg-success" href="jobs.php?approval_status='approved'">Approve</a> -->
          <!-- <a style="text-decoration: none;" class="badge text-bg-danger" href="jobs.php?jobID='rejected'">Reject</a> -->
        </td>
        <!--  onclick="return confirm('Be Careful! \r\nOK to delete?')" -->
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

<!-- start PAGE-CONTENT -->
<div class="page-content mt-2 float-end" style="width: 65%; margin-right: 10px;">
    <table class="table">
  <thead>
    <tr>
      <th scope="col" style="font-size: 14px;">ID #</th>
      <th scope="col" style="font-size: 14px;">Job Title / Position</th>
      <th scope="col" style="font-size: 14px;">Actions</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">

  <?php
      $sql = "SELECT * FROM job where approval_status = 'approved'";
      $all = mysqli_query($conn, $sql);
      if($all) {
          while ($row = mysqli_fetch_assoc($all)) {
            $jobID       = $row['jobID'];
            $idno        = $row['idno'];
            $jobtitle    = $row['jobtitle'];
            $companyname = $row['companyname'];
            $deptname    = $row['deptname'];
            // $companyname    = $row['companyname'];
  ?>
    <tr>
        <th scope="row"><?php echo $idno; ?></th>
        <td><?php echo $jobtitle; ?></td>
        <!-- <td><?php //echo $companyname; ?></td> -->
        <td><a onclick="return confirm('Be Careful! \r\nOK to delete?')" style="text-decoration: none;" class="badge text-bg-danger" href="jobs.php?jobID=<?php echo $jobID; ?>">Delete</a></td>
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