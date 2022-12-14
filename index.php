<!-- WORKING -->
<?php

require_once "app/database/connection.php";
require_once "app/database/functions.php";
require_once "path.php";
session_start();

if(isLoggedIn()){
  header('location:' . BASE_URL . '/pages/dashboard.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Custom Styles -->
   <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/main-style.css?v='. time(); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">



    <title>WMS | Home Page</title>
</head>
<body>
   
<div class="blocked-page">
  <?php include(ROOT_PATH . '/app/includes/blocked-page.php'); ?>
</div>
    
<div class="main-container">
<?php include("app/includes/header.php"); ?>

    <div class="container text-start">
        <br><br><br><br><br><br><br>
        <div class="row">
          <div class="col"></div>
          <div class="col"></div>
          <div class="col"></div>
        </div>
        <div class="row">
          <div class="col">
          <h1 style="color: white;">Keep Track of your <br><span style="color: #ffaa48;">Timesheets</span></h1>
              <p style="color: white; margin-bottom: -10px !important; font-weight: 100 !important;">Right at your fingertips</p>
              <span style="border-bottom: 3px solid #ffffff; color: rgba(0, 0, 0, 0);">color</span><span style="border-bottom: 3px solid #ffaa48; color: rgba(0, 0, 0, 0);">color</span>
          </div>
          
            <div class="col">
          <!-- <img style="margin-left: 75px;" src="/assets/img/laptop.png" alt=""> -->
            </div>
  
          </div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col"></div>
            <div class="col">
              
            </div>
          </div>
          <div class="row">
            <div class="col"></div>
            <div class="col"></div>
            <div class="col" style="margin-top: -23px;">
            </div>
          </div>
      </div>


      <?php include("app/includes/footer.php"); ?>

      </div>
      <div class="blocked-footer">
        <?php include(ROOT_PATH . "/app/includes/blocked-footer.php"); ?>
      </div>

</body>
</html>