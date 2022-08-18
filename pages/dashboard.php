<?php

// REQUIRE
  //require_once "../app/database/connection.php";
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
    <!-- scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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

  <?php
  $empID = $_SESSION['employee_idno'];
      $sql = "SELECT * FROM employee WHERE idno = '$empID'";
      $all = mysqli_query($conn, $sql);
      if($all) {
          while ($row = mysqli_fetch_assoc($all)) {
            $empID     = $row['employeeID'];
            $idno      = $row['idno'];
            $fname     = $row['fname'];
            $lname     = $row['lname'];
            $uname     = $row['uname'];
            $email     = $row['email'];
            $acc_type  = $row['acc_type'];
          }}
            ?>

  <?php if($_SESSION['acc_type'] == 0) { ?> 
  <!-- NON ADMIN DASHBOARD -->
  <div class="page-content mt-2 mx-auto" style="margin-right: 10px;">
    <div class="container text-center">
      <div class="row mt-3">
        <div class="col me-3 ms-3" style="height: 75px; background-color: #eee; border-radius: 15px;">
          <div class="col-content" style="padding-top: 12.5px;">
            <h3>Welcome Back, <?php echo $fname; ?>!</h3>
            <p class="text-muted" style="margin-top: -5px; font-size: 12px;">Check your notifications and messages.</p>
          </div>
          <div class="col" style="margin-top: 22.5px; height: 130px; background-color: #eee; border-radius: 15px;">
            <div class="col-content" style="padding-top: 10px;">
              <h5>
                Time Card
              </h5>
            </div>
            <?php
              $curr_date = date('Y-m-d');
              $empID = $_SESSION['employee_idno'];
              $sql = "SELECT * FROM timesheet WHERE employee_idno = '$empID'";
              $all = mysqli_query($conn, $sql);
              if($all) {
                while ($row = mysqli_fetch_assoc($all)) {
                  $empID      = $row['employeeID'];
                  $db_date    = $row['date'];
                  $db_timein  = $row['timein'];
                  $db_timeout = $row['timeout'];
              }}
            ?>
            <span style="padding-top: 10px;">
              <?php if($db_date != $curr_date) { ?>
                No timesheet created yet
              <?php } else if($db_timein == null) { ?>
                Timesheet was created, but not clocked in
              <?php } else if($db_timeout == null) { ?>
                Timesheet was created, but not clocked out
              <?php } ?>
              </span>
              <br><br>
              <span class="float-end pe-3 mt-2 text-muted" style="font-size: 14px;">
                <a class="text-decoration-none text-muted" href="<?php echo BASE_URL . '/pages/timesheet.php' ?>">My Timecard <i class="bi bi-chevron-right text-muted" style=" background-color: white; border-radius: 50%; border: 1px solid grey; padding: 10px;"></i></a>
              </span>
          </div>
        </div>
        <div class="col me-3 ms-3" style="height: 220px; background-color: #eee; border-radius: 15px;">
              <div class="col-md-8 float-start ms-4" style="margin-top: 33px; width: 165px;">
                <div class="card mb-3" style="border-color: white;">
                <div class="card-body">
                  <img class="ms-1" src="../../assets/img/pic_holder.jpg" style="height: 120px; width: 120px; border-radius: 150px;" alt="">
                  </div>
                </div>
              </div>
              <div class="col-md-8 float-start ms-3" style="margin-top: 53px; width: 300px;">
                <div class="card mb-3" style="border-color: white; text-align: left;">
                <div class="card-body">
                  <h5>
                    <?php echo $fname; ?> <?php echo $lname; ?>
                  </h5>
                  <span>
                    <i class="bi bi-person-badge"></i> &nbsp; <span style="font-size: 14px;"><?php echo $idno; ?></span> <br>
                  </span>
                  <span>
                    <?php if($email != null) { ?>
                      <i class="bi bi-envelope"></i> &nbsp; <span style="font-size: 14px;"><?php echo $email; ?></span>  
                    <?php } else { ?>
                      <span class='text-warning'>No Email Found!</span>
                    <?php } ?>
                  </span>
                  </div>
                </div>
              </div>
        </div>
      </div>
      <div class="row mt-3">
        
      </div>
      <div class="row mt-3">
        <div class="col me-3 ms-3" style="height: 350px; background-color: #eee; border-radius: 15px;">
          <div class="col-content" style="padding-top: 10px;">
              <h5>
                My Schedule
              </h5>
            </div>
        </div>
        <div class="col me-3 ms-3" style="height: 350px; background-color: #eee; border-radius: 15px;">
          <div class="col-content" style="padding-top: 10px;">
              <h5>
                My Notifications
              </h5>
            </div>
        </div>
        <div class="col me-3 ms-3" style="height: 350px; background-color: #eee; border-radius: 15px;">
          <div class="col-content" style="padding-top: 10px;">
              <h5>
                Current Date & Time
              </h5>
            </div>
        </div>
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