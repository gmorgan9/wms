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

// Delete User
if(isset($_GET['companyID'])) {
    $id = $_GET['companyID'];

    $sql = "DELETE FROM company WHERE companyID = $id";
    $delete = mysqli_query($conn, $sql);
    if($delete) {
        // echo "Deleted Successfully";
        header('location: companies.php'); // returns back to same page
    } else {
        die(mysqli_error($conn));
    }
}

$select = " SELECT * FROM company";
$result = mysqli_query($conn, $select);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | Companies</title>

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
    <p class="page_title" style="float: left; padding-top: 2px;">Companies</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Companies</li>
    </ul>
  </div>

  <!-- <div class="jumbotron jumbotron-fluid bg-white m-2 mx-auto" style="width: 98%;">
  <div class="container">
    <h3 class="display-6 text-center" style="padding-top: 5px !important;padding-bottom: 10px !important;">Welcome, <span style="text-transform: capitalize;"><?php //echo $row['fname'] ?>!</span></h3>
  </div>
</div> -->

<!-- start PAGE-CONTENT -->
<div class="page-content mx-auto mt-2">
<div class="d-grid d-md-flex justify-content-md-end">
  <button class="badge text-bg-secondary" style="border-color: rgba(0,0,0,0);" type="button"><a style="color: white; text-decoration:none;" href="<?php echo BASE_URL . '/admin/actions/add-company.php' ?>"><i class="bi bi-plus-lg"></i> Company</a></button>
  <!-- <button class="btn btn-primary" type="button">Button</button> -->
</div>
    <table class="table">
    <?php 


if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
  
?>
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Company Name</th>
      <th scope="col">City</th>
      <th scope="col">State</th>
      <th scope="col">Zip Code</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">

  <?php
  


      $sql = "SELECT * FROM company";
      $all = mysqli_query($conn, $sql);
      if($all) {
          while ($row = mysqli_fetch_assoc($all)) {
            $compID   = $row['companyID'];
            $cname    = $row['companyname'];
            $ccity    = $row['ccity'];
            $cstate   = $row['cstate'];
            $czip     = $row['czip'];
            ?>
    <tr>
        <th scope="row"><?php echo $compID; ?></th>
        <td><?php echo $cname; ?></td>
        <td><?php echo $ccity; ?></td>
        <td><?php echo $cstate; ?></td>
        <td><?php echo $czip; ?></td>
        <td><a style="text-decoration: none;" class="badge text-bg-danger" href="companies.php?companyID=<?php echo $compID; ?>">Delete</a></td>
        <?php }}} ?>
        
   
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