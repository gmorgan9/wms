<?php

// REQUIRE
  require_once "../app/database/connection.php";
  require_once "../app/database/functions.php";
  require_once "../path.php";
//END REQUIRE 

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
    
  <!-- START SCRIPTS -->
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/other-style.css?v='. time(); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <!-- END SCRIPTS -->

    <title>WMS | Dashboard</title>
</head>
<body>
   
<div class="blocked-page">
  <?php include(ROOT_PATH . '/app/includes/blocked-page.php'); ?>
</div>

    
<div class="main-container">
<?php include(ROOT_PATH . "/app/includes/header.php"); ?>
<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
  
<!-- START MAIN -->
  <div class="main">
  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Dashboard</p>
  </div>

  <?php if($_SESSION['acc_type'] == 0) { ?> 
  <!-- NON ADMIN DASHBOARD -->
  <div class="page-content mt-2 mx-auto" style="margin-right: 10px;">
    <div class="container text-center">
      <div class="row">
        <div class="col">col1</div>
        <div class="col">col2</div>
        <div class="col">col3</div>
      </div>
      <div class="row">
        <div class="col-8">col-8</div>
        <div class="col-4">col-4</div>
      </div>
    </div>
  </div>
  <!-- END NON ADMIN DASHBOARD -->
  <?php } else { ?>
  <!-- ADMIN DASHBOARD -->
    <div class="stats d-flex justify-content-center" style="margin-left: -1px; margin-top: 5px !important;">



    <div class="row">
    <div class="card" style="width: 24.1rem; margin-right: 10px; border-radius: 0 !important; border-color: #fff;">
    <div class="card-body">
    <div class="card-content" style="float: right;">
          <?php 
        $day = date('w');
        $monday = date( 'Y-m-d', strtotime( 'monday this week' ) );
        $friday = date( 'Y-m-d', strtotime( 'friday this week' ) );
        $week_start = date('Y-m-d', strtotime($monday));
        $week_end = date('Y-m-d', strtotime($friday));

        $sql = " SELECT * FROM timesheet WHERE date BETWEEN '$week_start' AND '$week_end'";
        if ($result = mysqli_query($conn, $sql)) {
          $rowcount = mysqli_num_rows( $result );
        ?>
      <h5 class="card-title text-end">Total Timesheets</h5>
      <h6 class="card-subtitle mb-2 text-muted text-end" style="font-size: 40px !important;"><?php echo $rowcount; ?></h6>
      <p class="card-text text-end"><a href="timesheet.php" class="detail-btn" style="">View Details</a></p>
      </div>
      <p style="float: left; font-size: 40px; margin-top: 20px;"><i class="bi bi-briefcase"></i></p>
      <?php }?>
    </div>
    </div>

    <div class="card" style="width: 24.1rem; margin-right: 10px; border-radius: 0 !important; border-color: #fff;">
      <div class="card-body">
        <div class="card-content" style="float: right;">
        <?php 
          $sql = " SELECT * FROM timesheet WHERE approval_status = 'pending'";
          if ($result = mysqli_query($conn, $sql)) {
            $rowcount = mysqli_num_rows( $result );
        ?>
        <h5 class="card-title text-end">Pending Timesheets</h5>
          <?php if($rowcount > 0) { ?>
            <h6 class="card-subtitle mb-2 text-end" style="font-size: 40px !important;"><span class="text-primary"><?php echo $rowcount; ?></span></h6>
          <?php } else { ?>
            <h6 class="card-subtitle mb-2 text-muted text-end" style="font-size: 40px !important;"><?php echo $rowcount; ?></h6>
          <?php } ?>
        <p class="card-text text-end"><a href="timesheet.php" class="detail-btn" style="">View Details</a></p>
        </div>
        <p style="float: left; font-size: 40px; margin-top: 20px;"><i class="bi bi-file-earmark-text"></i></p>
        <?php } ?>
      </div>
    </div>

    </div>

    </div>
  <!-- END ADMIN DASHBOARD -->
  <?php } ?>

<!-- END MAIN -->

<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
</div>
<!-- BLOCKED PAGE -->
  <div class="blocked-footer">
    <?php include(ROOT_PATH . "/app/includes/blocked-footer.php"); ?>
  </div>
<!-- END BLOCKED PAGE -->

<!-- GUMROAD LINK -->
  <!-- <script src="https://gumroad.com/js/gumroad.js"></script>
    <a class="gumroad-button" href="https://garrettmorgan.gumroad.com/l/fwwwc">Buy on</a>
  </div> -->
<!-- END GUMROAD LINK -->

</body>
</html>