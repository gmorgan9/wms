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


    <title>ETES | Reports</title>
</head>
<body>
    
<?php include(ROOT_PATH . "/app/includes/header.php"); ?>


<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>

<!-- START MAIN -->
  <div class="main">
    <div class="page-header mx-auto">
      <p class="page_title" style="float: left; padding-top: 2px;">Reports</p>
      <ul class="breadcrumb">
        <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
        <li>Reports</li>
      </ul>
    </div>


  <!-- START REPORTS -->

  <div class="page-content mx-auto mt-2">
    <!-- <span class="mx-auto">Timesheet for <span class="text-muted text-capitalize"><?php //echo $_SESSION['fname']; ?></span></span> -->
    <table class="table">
      <thead>
        <tr>
          <th scope="col" style="font-size: 14px;">ID #</th>
          <th scope="col" style="font-size: 14px;">Report Name</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <tr>
          <th scope="row"><?php echo $idno; ?></th>
          <td>Employee Timesheet View</td>
        </tr>
      </tbody>
    </table> 
    <!-- end PAGE-CONTENT -->
    </div>










  </div>
<!-- END MAIN -->


<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>


</body>
</html>