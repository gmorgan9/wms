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

// Add Company
if(isset($_POST['add-company'])){

  $jobID = mysqli_real_escape_string($conn, $_POST['jobID']);
  $idno  = rand(1000000, 9999999); // figure how to not allow duplicates
  $jobtitle = mysqli_real_escape_string($conn, $_POST['jobtitle']);
  // $ccity = mysqli_real_escape_string($conn, $_POST['ccity']);
  // $cstate = mysqli_real_escape_string($conn, $_POST['cstate']);
  // $czip = mysqli_real_escape_string($conn, $_POST['czip']);

  $select = " SELECT * FROM job WHERE jobtitle = '$jobtitle' ";

  $result = mysqli_query($conn, $select);

  if(mysqli_num_rows($result) > 0){

     $error[] = 'Job already exist!';

  }else{
        $insert = "INSERT INTO company (idno, jobtitle) VALUES('$idno', '$jobtitle')";
        mysqli_query($conn, $insert);
        header('location: /admin/companies.php');
     }

};

// Delete Company
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
<div class="page-content float-start" style="margin-top: 12px; width: 32%;margin-left: -50px; height: unset !important;">
  <form action="" method="post">
    <!-- <h6 class="mx-auto" style="width: 95%;">Add Company</h6> -->
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="companyname" style="font-size: 14px;">Job Title / Position <span class="text-muted" style="font-size: 10px;">e.g. "Chief Executive Officer"</span></label>
      <input class="form-control" id="companyname" type="text" name="companyname" value="" required>
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
      <th scope="col" style="font-size: 14px;">ID #</th>
      <th scope="col" style="font-size: 14px;">Job Title</th>
      <!-- <th scope="col">City</th>
      <th scope="col">State</th>
      <th scope="col">Zip Code</th> -->
      <th scope="col"  style="font-size: 14px;">Actions</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">

  <?php
      $sql = "SELECT * FROM job";
      $all = mysqli_query($conn, $sql);
      if($all) {
          while ($row = mysqli_fetch_assoc($all)) {
            $jobID   = $row['companyID'];
            $idno     = $row['idno'];
            $jobtitle    = $row['jobtitle'];
  ?>
    <tr>
        <th scope="row"><?php echo $idno; ?></th>
        <td><?php echo $jobtitle; ?></td>
        <!-- <td><?php //echo $ccity; ?></td>
        <td><?php //echo $cstate; ?></td>
        <td><?php //echo $czip; ?></td> -->
        <td><a style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#confirmDelete" class="badge text-bg-danger" href="jobs.php?jobID=<?php echo $jobID; ?>">Delete</a></td>
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


<!-- Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Job Deletion Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php 
          $job = "SELECT * FROM job where jobID = '$jobID'";
          $jobr = mysqli_query($conn, $job);
          if($jobr) {
              while ($row = mysqli_fetch_assoc($jobr)) {
                $compID   = $row['jobID'];
                $jobtitle    = $row['jobtitle'];
        ?>
        <span class="badge text-bg-danger" style="font-size: 10px;">This will delete all corresponding departments and jobs with this company</span>
        <br>
        <br>
        Are you sure you want to delete: <span class="text-muted"><?php echo $jobtitle; ?></span>?
        <?php }
        } ?>
      </div>
      <div class="modal-footer">
        <a class="badge text-bg-primary" style="text-decoration: none; cursor: pointer;" data-bs-dismiss="modal">Cancel</a>
        <a class="badge text-bg-danger" style="text-decoration: none; cursor: pointer;" href="companies.php?companyID=<?php echo $compID; ?>">Delete</a>
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