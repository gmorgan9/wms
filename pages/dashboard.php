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
                $sql = "SELECT * FROM timesheet WHERE date = '$curr_date' AND employee_idno = '$empID'";
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
                  <span class="text-black fw-bold">
                    Create Time Sheet
                  </span>
                  <br>
                  <span class="text-muted" style="margin-top: -10px; font-size: 12px;">
                    You need to go create a timesheet.
                  </span>
                  <br>
                  <span class="float-end pe-3 text-muted" style="font-size: 14px;margin-top: 10px;">
                    <a class="text-decoration-none text-muted" href="<?php echo BASE_URL . '/pages/timesheet.php' ?>">My Timecard <i class="bi bi-chevron-right"></i></a>
                  </span>
                <?php } else if($db_timein == null) { ?>


                  <table class="table w-50 mx-auto">
                <thead>
                  <tr>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row" style="font-size: 14px; border-bottom: 0;">Time In</th>
                    <td class="text-start" style="font-size: 14px; border-bottom: 0;">
                    <span class="text-warning">
                    Not Clocked In Yet
                  </span>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" style="font-size: 14px; border-bottom: 0;">Time Out</th>
                    <td class="text-start" style="font-size: 14px; border-bottom: 0;">
                    <span class="text-warning">
                    Not Clocked out Yet
                  </span>
                    </td>
                  </tr>
                </tbody>
              </table>


              <span class="float-end pe-3 text-muted" style="font-size: 14px; margin-top: -30px;">
                <a class="text-decoration-none text-muted" href="<?php echo BASE_URL . '/pages/timesheet.php' ?>">My Timecard <i class="bi bi-chevron-right"></i></a>
              </span>

                <?php } else if($db_timeout == null) { ?>


                  <table class="table w-50 mx-auto">
                <thead>
                  <tr>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row" style="font-size: 14px; border-bottom: 0;">Time In</th>
                    <td class="text-start" style="font-size: 14px; border-bottom: 0;">
                      <?php 
                        $f_timein = date('h:i a', strtotime($db_timein));
                        echo $f_timein;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" style="font-size: 14px; border-bottom: 0;">Time Out</th>
                    <td class="text-start" style="font-size: 14px; border-bottom: 0;">
                    <span class="text-warning">
                    Not Clocked out Yet
                  </span>
                    </td>
                  </tr>
                </tbody>
              </table>


              <span class="float-end pe-3 text-muted" style="font-size: 14px; margin-top: -30px;">
                <a class="text-decoration-none text-muted" href="<?php echo BASE_URL . '/pages/timesheet.php' ?>">My Timecard <i class="bi bi-chevron-right"></i></a>
              </span>

                <?php } else if ($db_timeout != null) { ?>
                  <table class="table w-50 mx-auto">
                <thead>
                  <tr>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row" style="font-size: 14px; border-bottom: 0;">Time In</th>
                    <td class="text-start" style="font-size: 14px; border-bottom: 0;">
                      <?php 
                        $f_timein = date('h:i a', strtotime($db_timein));
                        echo $f_timein;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th scope="row" style="font-size: 14px; border-bottom: 0;">Time Out</th>
                    <td class="text-start" style="font-size: 14px; border-bottom: 0;">
                      <?php 
                        $f_timeout = date('h:i a', strtotime($db_timeout));
                        echo $f_timeout;
                      ?>
                    </td>
                  </tr>
                </tbody>
              </table>

              <span class="float-end pe-3 text-muted" style="font-size: 14px; margin-top: -30px;">
                <a class="text-decoration-none text-muted" href="<?php echo BASE_URL . '/pages/timesheet.php' ?>">My Timecard <i class="bi bi-chevron-right"></i></a>
              </span>


                <?php } ?>
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
                <span class="float-end pe-1 mt-2 text-muted" style="font-size: 14px;">
                <a class="text-decoration-none text-muted" href="<?php echo BASE_URL . '/pages/profile.php' ?>">My Profile <i class="bi bi-chevron-right"></i></a>
              </span>
          </div>
        </div>
        <div class="row mt-3">
                      
        </div>
        <div class="row mt-3">
          <div class="col me-3 ms-3" style="height: 350px; background-color: #eee; border-radius: 15px;">
          <?php
                $current_mon    = date('Y-m-d', strtotime('monday this week'));
                $f_curr_mon     = date('M d', strtotime('monday this week'));
                $f_curr_fri     = date('M d', strtotime('friday this week'));
                $s_f_mon        = date('d', strtotime('monday this week'));
                $s_f_tues       = date('d', strtotime('tuesday this week'));
                $s_f_wed        = date('d', strtotime('wednesday this week'));
                $s_f_thurs      = date('d', strtotime('thursday this week'));
                $s_f_fri        = date('d', strtotime('friday this week'));
                $current_day    = date('d');
                $employee_idno  = $_SESSION['employee_idno'];
                $sql = "SELECT * FROM schedule WHERE mon_date = '$current_mon' AND employee_idno = '$employee_idno' ";
                $all = mysqli_query($conn, $sql);
                if($all) {
                  while ($row = mysqli_fetch_assoc($all)) {
                    $scheduleID       = $row['scheduleID'];
                    $idno        = $row['idno'];
                    // MONDAY
                    $db_mon_date    = $row['mon_date'];
                    $f_mon          = date('M d, Y', strtotime($db_mon_date));
                    $short_f_mon    = date('d', strtotime($db_mon_date));
                    $db_mon_timein  = $row['mon_timein'];
                    $f_mon_timein   = date('g:i A', strtotime($db_mon_timein));
                    $db_mon_timeout = $row['mon_timeout'];
                    $f_mon_timeout   = date('g:i A', strtotime($db_mon_timeout));
                    // TUESDAY
                    $db_tues_date    = $row['tues_date'];
                    $f_tues          = date('M d, Y', strtotime($db_tues_date));
                    $short_f_tues    = date('d', strtotime($db_tues_date));
                    $db_tues_timein  = $row['tues_timein'];
                    $f_tues_timein   = date('g:i A', strtotime($db_tues_timein));
                    $db_tues_timeout = $row['tues_timeout'];
                    $f_tues_timeout   = date('g:i A', strtotime($db_tues_timeout));
                    // WEDNESDAY
                    $db_wed_date    = $row['wed_date'];
                    $f_wed          = date('M d, Y', strtotime($db_wed_date));
                    $short_f_wed    = date('d', strtotime($db_wed_date));
                    $db_wed_timein  = $row['wed_timein'];
                    $f_wed_timein   = date('g:i A', strtotime($db_wed_timein));
                    $db_wed_timeout = $row['wed_timeout'];
                    $f_wed_timeout   = date('g:i A', strtotime($db_wed_timeout));
                    // THURSDAY
                    $db_thurs_date    = $row['thurs_date'];
                    $f_thurs          = date('M d, Y', strtotime($db_thurs_date));
                    $short_f_thurs    = date('d', strtotime($db_thurs_date));
                    $db_thurs_timein  = $row['thurs_timein'];
                    $f_thurs_timein   = date('g:i A', strtotime($db_thurs_timein));
                    $db_thurs_timeout = $row['thurs_timeout'];
                    $f_thurs_timeout   = date('g:i A', strtotime($db_thurs_timeout));
                    // FRIDAY
                    $db_fri_date    = $row['fri_date'];
                    $f_fri          = date('M d, Y', strtotime($db_fri_date));
                    $short_f_fri    = date('d', strtotime($db_fri_date));
                    $db_fri_timein  = $row['fri_timein'];
                    $f_fri_timein   = date('g:i A', strtotime($db_fri_timein));
                    $db_fri_timeout = $row['fri_timeout'];
                    $f_fri_timeout   = date('g:i A', strtotime($db_fri_timeout));
                    // DATES DONE
                    $deptname    = $row['deptname'];
                    $app_status  = $row['approval_status'];
                  
      ?>
      <?php }} ?>

      <?php
      $count_employee     = $_SESSION['employee_idno'];
      $count_curr_mon     = date('Y-m-d', strtotime('monday this week'));
      $sql = " SELECT * FROM schedule WHERE mon_date = '$count_curr_mon' AND employee_idno = '$count_employee' ";
      if ($result = mysqli_query($conn, $sql)) {
          $rowcount = mysqli_num_rows( $result );}
      
      ?>
            <div class="col-content" style="padding-top: 10px;">
                <h5>
                  My Schedule
                </h5>
                <span class="text-muted" style="font-size: 13px;">
                  <?php echo $f_curr_mon; ?> - <?php echo $f_curr_fri; ?>
                </span>
                <table class="table mt-1">
                <thead>
                  <tr>
                  </tr>
                </thead>
                <tbody style="border-radius: 15px;">
                <?php $curr_m_s = date('d', strtotime('monday this week')); ?>
                  <?php if($curr_m_s == $current_day) { ?>
                    <tr>
                      <th scope="row" class="text-bg-secondary" style="font-size: 12px; width: 30%;">
                        &nbsp; Mon <br>
                        <?php echo $s_f_mon; ?>
                      </th>
                      <?php if ($db_mon_timein != null) { ?>
                      <td class="text-start text-bg-secondary" style="width: 65%;">
                        <div style="opacity:0; font-size: 5px;">test</div>
                        <?php echo $f_mon_timein; ?> - <?php echo $f_mon_timeout; ?>
                      </td>
                      <?php } else { ?>
                        <td class="text-start text-bg-secondary" style="width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                            No Shift
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <th scope="row" style="font-size: 12px; width: 30%;">
                        &nbsp; Mon <br>
                        <?php echo $s_f_mon; ?>
                      </th>
                      <?php if ($db_mon_timein != null) { ?>
                      <td class="text-start" style="width: 65%;">
                        <div style="opacity:0; font-size: 5px;">test</div>
                        <?php echo $f_mon_timein; ?> - <?php echo $f_mon_timeout; ?>
                      </td>
                      <?php } else { ?>
                        <td class="text-start" style="width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                            No Shift
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } ?>
                  <?php $curr_tu_s = date('d', strtotime('tuesday this week')); ?>
                  <?php if($curr_tu_s == $current_day) { ?>
                    <tr>
                      <th scope="row" class="text-bg-secondary" style="font-size: 12px; width: 30%;">
                        &nbsp; Tues <br>
                        <?php echo $s_f_tues; ?>
                      </th>
                      <?php if ($db_tues_timein != null) { ?>
                        <td class="text-start text-bg-secondary" style="width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                          <?php echo $f_tues_timein; ?> - <?php echo $f_tues_timeout; ?>
                        </td>
                      <?php } else { ?>
                        <td class="text-start text-bg-secondary" style="width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                            No Shift
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <th scope="row" style="font-size: 12px; width: 30%;">
                        &nbsp; Tues <br>
                        <?php echo $s_f_tues; ?>
                      </th>
                      <?php if ($db_tues_timein != null) { ?>
                        <td class="text-start" style="width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                          <?php echo $f_tues_timein; ?> - <?php echo $f_tues_timeout; ?>
                        </td>
                      <?php } else { ?>
                        <td class="text-start" style="width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                          No Shift
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } ?>
                  <?php $curr_w_s = date('d', strtotime('wednesday this week')); ?>
                  <?php if($curr_w_s == $current_day) { ?>
                    <tr>
                      <th scope="row" class="text-bg-secondary" style="font-size: 12px; width: 30%;">
                        &nbsp; Wed <br>
                        <?php echo $s_f_wed; ?>
                      </th>
                      <?php if ($db_wed_timein != null) { ?>
                        <td class="text-start text-bg-secondary" style="width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                          <?php echo $f_wed_timein; ?> - <?php echo $f_wed_timeout; ?>
                        </td>
                      <?php } else { ?>
                        <td class="text-start text-bg-secondary" style="width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                          No Shift
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <th scope="row" style="font-size: 12px; width: 30%;">
                        &nbsp; Wed <br>
                        <?php echo $s_f_wed; ?>
                      </th>
                      <?php if ($db_wed_timein != null) { ?>
                        <td class="text-start" style="width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                          <?php echo $f_wed_timein; ?> - <?php echo $f_wed_timeout; ?>
                        </td>
                      <?php } else { ?>
                        <td class="text-start" style="width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                          No Shift
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } ?>
                  <?php $curr_th_s = date('d', strtotime('thursday this week')); ?>
                  <?php if($curr_th_s == $current_day) { ?>
                  <tr>
                  <th scope="row" class="text-bg-secondary" style="font-size: 12px; width: 30%;">
                      &nbsp; Thurs <br>
                      <?php echo $s_f_thurs; ?>
                    </th>
                    <?php if ($db_thurs_timein != null) { ?>
                      <td class="text-start text-bg-secondary" style="width: 65%;">
                        <div style="opacity:0; font-size: 5px;">test</div>
                        <?php echo $f_thurs_timein; ?> - <?php echo $f_thurs_timeout; ?>
                      </td>
                    <?php } else { ?>
                      <td class="text-start text-bg-secondary" style="width: 65%;">
                        <div style="opacity:0; font-size: 5px;">test</div>
                        No Shift
                      </td>
                    <?php } ?>
                  </tr>
                  <?php } else { ?>
                  <tr>
                    <th scope="row" style="font-size: 12px; width: 30%;"> 
                      &nbsp; Thurs <br>
                      <?php echo $s_f_thurs; ?>
                    </th>
                    <?php if ($db_thurs_timein != null) { ?>
                      <td class="text-start" style="width: 65%;">
                        <div style="opacity:0; font-size: 5px;">test</div>
                        <?php echo $f_thurs_timein; ?> - <?php echo $f_thurs_timeout; ?>
                      </td>
                    <?php } else { ?>
                      <td class="text-start" style="width: 65%;">
                        <div style="opacity:0; font-size: 5px;">test</div>
                        No Shift
                      </td>
                    <?php } ?>
                  </tr>
                  <?php } ?>
                  <?php $curr_f_s = date('d', strtotime('friday this week')); ?>
                  <?php if($curr_f_s == $current_day) { ?>
                    <tr>
                      <th scope="row" class="text-bg-secondary" style="font-size: 12px; border-bottom: 0; width: 30%;">
                        &nbsp; Fri <br>
                        <?php echo $s_f_fri; ?>
                      </th>
                      <?php if ($db_fri_timein != null) { ?>
                        <td class="text-start text-bg-secondary" style="border-bottom: 0; width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                          <?php echo $f_fri_timein; ?> - <?php echo $f_fri_timeout; ?>
                        </td>
                      <?php } else { ?>
                        <td class="text-start text-bg-secondary" style="border-bottom: 0; width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                          No Shift
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <th scope="row" style="font-size: 12px; border-bottom: 0; width: 30%;">
                        &nbsp; Fri <br>
                        <?php echo $s_f_fri; ?>
                      </th>
                      <?php if ($db_fri_timein != null) { ?>
                        <td class="text-start" style="border-bottom: 0; width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                          <?php echo $f_fri_timein; ?> - <?php echo $f_fri_timeout; ?>
                        </td>
                      <?php } else { ?>
                        <td class="text-start" style="border-bottom: 0; width: 65%;">
                          <div style="opacity:0; font-size: 5px;">test</div>
                          No Shift
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } ?> 
                </tbody>
              </table>
                      
              </div>
          </div>
          <div class="col me-3 ms-3" style="height: 175px; background-color: #eee; border-radius: 15px;">
            <div class="col-content" style="padding-top: 10px;">
                <h5>
                  My Notifications
                </h5>
              </div>
              <table class="table w-75 mx-auto mt-2">
                <thead>
                  <tr>
                      
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php
                    $sql = " SELECT * FROM task WHERE status = 'notstarted' OR status = 'inprogress' ";
                    if ($result = mysqli_query($conn, $sql)) {
                      $tCount = mysqli_num_rows( $result );
                    ?>
                    <th scope="row" class="text-center"><?php echo $tCount; ?></th>
                    <?php } ?>
                    <td class="text-start">Tasks</td>
                  </tr>
                  <tr>
                  <?php
                    $sql = " SELECT * FROM project WHERE status = 'notstarted' OR status = 'inprogress' ";
                    if ($result = mysqli_query($conn, $sql)) {
                      $pCount = mysqli_num_rows( $result );
                    ?>
                    <th scope="row" class="text-center"><?php echo $pCount; ?></th>
                    <?php } ?>
                    <td class="text-start">Projects</td>
                  </tr>
                  <!-- <tr>
                    <th scope="row" class="text-center">0</th>
                    <td class="text-start">My Requests</td>
                  </tr> -->
                  <tr>
                  <?php
                    $sql = " SELECT * FROM timesheet WHERE approval_status = 'pending' ";
                    if ($result = mysqli_query($conn, $sql)) {
                      $tsCount = mysqli_num_rows( $result );
                    ?>
                    <th scope="row" class="text-center" style="border-bottom: 0;"><?php echo $tsCount; ?></th>
                    <?php } ?>
                    <td class="text-start" style="border-bottom: 0;">Timesheet Requests</td>
                  </tr>
                  <!-- <tr>
                    <th scope="row" class="text-center">0</th>
                    <td class="text-start">My Messages</td>
                  </tr> -->
                </tbody>
              </table>
              <div class="col-content" style="margin-top: 25px !important; width: 350px !important; margin-right: -25px !important; margin-left: -8px; padding-top: 12.5px; height: 160px; background-color: #eee; border-radius: 15px;">
                <h5>Upcoming Meetings</h5>
              </div>
          </div>
          <div class="col me-3 ms-3" style="height: 350px; background-color: #eee; border-radius: 15px;">
            <div class="col-content" style="padding-top: 10px;">
                <h5>
                  Current Date & Time
                </h5>
                <style>

                    .clock
                    {
                    width: 210px;
                    height: 210px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    background: url(../assets/img/clock.png);
                    background-size: cover;
                    border: 4px solid rgb(120, 120, 120);
                    border-radius: 50%;
                    box-shadow: 0 -15px 15px rgba(255,255,255,0.05),
                    inset 0 -15px 15px rgba(255,255,255,0.05),
                    0 15px 15px rgba(0,0,0,0.3),
                    inset 0 15px 15px rgba(0,0,0,0.3);
                    }
                    .clock::before
                    {
                    content: '';
                    position: absolute;
                    width: 15px;
                    height: 15px;
                    background: #fff;
                    border-radius: 50%;
                    z-index: 10000;
                    }
                    .clock .hour,
                    .clock .min,
                    .clock .sec
                    {
                    position: absolute;
                    }
                    .clock .hour, .hr
                    {
                    width: 160px;
                    height: 160px;
                    }
                    .clock .min, .mn
                    {
                    width: 190px;
                    height: 190px;
                    }
                    .clock .sec, .sc
                    {
                    width: 230px;
                    height: 190px;
                    }
                    .hr, .mn, .sc
                    {
                    display: flex;
                    justify-content: center;
                    /* align-items: center; */
                    position: absolute;
                    border-radius: 50%;
                    }
                    .hr:before
                    {
                    content: '';
                    position: absolute;
                    width: 8px;
                    height: 80px;
                    background: #ffaa48;
                    z-index: 10;
                    border-radius: 6px 6px 0 0;
                    }
                    .mn:before
                    {
                    content: '';
                    position: absolute;
                    width: 4px;
                    height: 90px;
                    background: rgb(120, 120, 120);
                    z-index: 11;
                    border-radius: 6px 6px 0 0;
                    }
                    .sc:before
                    {
                    content: '';
                    position: absolute;
                    width: 2px;
                    height: 90px;
                    background: rgb(120, 120, 120);
                    z-index: 12;
                    border-radius: 6px 6px 0 0;
                    }
                  
                </style>
                <script>

                </script>
                        <div class="clock mx-auto">
                        <div class="hour">
                        <div class="hr" id="hr"></div>
                        </div>
                        <div class="min">
                        <div class="mn" id="mn"></div>
                        </div>
                        <div class="sec">
                        <div class="sc" id="sc"></div>
                        </div>
                        </div>
                        <!-- Start script part -->
                        <script type="text/Javascript">
                        const deg = 6;
                        const hr = document.querySelector('#hr');
                        const mn = document.querySelector('#mn');
                        const sc = document.querySelector('#sc');
                        setInterval(() => {
                        let day = new Date();
                        let hh = day.getHours() * 30;
                        let mm = day.getMinutes() * deg;
                        let ss = day.getSeconds() * deg;
                        var hour =day.getHours() % 12;
                        cHour = ("0" + hour).slice(-2);
                        var min = day.getMinutes() % 60;
                        cMin = ("0" + min).slice(-2);
	                      var sec = day.getSeconds();
                        cSec = ("0" + sec).slice(-2);
                        let ampmH = day.getHours();
                        let ampm = ampmH >= 12 ? 'PM' : 'AM';
                        hr.style.transform = `rotateZ(${hh+(mm/12)}deg)`;
                        mn.style.transform = `rotateZ(${mm}deg)`;
                        sc.style.transform = `rotateZ(${ss}deg)`;
                        document.getElementById("time").innerHTML=cHour+":"+cMin+":"+cSec+" "+ampm;
                        })
                        </script>
                        <!-- End script part -->
                        <br>
                        <?php 
                        $cdt_current_date = date('l, F d, Y ')
                        ?>


                        <span class="text-center">
                          <?php echo $cdt_current_date; ?>
                          <p id="time"></p>

                        </span>
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