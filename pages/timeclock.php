<!-- WORKING -->
<?php
require_once "../app/database/connection.php";
require_once "../app/database/functions.php";
require_once "../path.php";
session_start();

if(!isLoggedIn()){
  header('location:' . BASE_URL . '/pages/entry/login.php');
}

// CLOCKIN FUNCTION
    if (isset($_POST['clockin'])) {
        $timein = $_POST['timein'];
        $date = $_POST['date'];
        $employee_idno = $_SESSION['employee_idno'];
        $apptUpdateQuery = "INSERT INTO timeclock (employee_idno, date, timein) VALUES('$employee_idno', '$date', '$timein')";
        $apptUpdateResult = mysqli_query($conn, $apptUpdateQuery);
        header('Location: timeclock.php');
    } 
// END CLOCKIN FUNCTION

// CLOCKOUT FUNCTION
    if (isset($_POST['clockout'])) {
        $emp = $_POST['employee_idno'];
        $timeout = $_POST['timeout'];
        $rejUpdateQuery = "UPDATE timeclock SET timeout = '$timeout' WHERE employee_idno = '$emp'";
        $rejUpdateResult = mysqli_query($conn,$rejUpdateQuery);
        header('Location: timeclock.php');
    }
// END CLOCKOUT FUNCTION

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

    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>WMS | Time Clock</title>
</head>
<body>
    
<?php include(ROOT_PATH . "/app/includes/header.php"); ?>
<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
  
<!-- START MAIN -->
  <div class="main">
  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Time Clock</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Time Clock</li>
    </ul>
  </div>


    <div class="page-content mx-auto mt-2">

    <div class="container">
      <div class="row">
      <div class="col-lg-6">
         <div id="clock">
            <div class="hour">
               <div class="min"></div>
               <div class="min"></div>
               <div class="min"></div>
               <div class="min"></div>
               <div class="min"></div>
            </div>
            <div class="hour">
               <div class="min"></div>
               <div class="min"></div>
               <div class="min"></div>
               <div class="min"></div>
               <div class="min"></div>
            </div>
            <div id="alarm"> </div>
            <div id="min"></div>
            <div id="hour"></div>
            <div id="sec"></div>
            <ol>
               <li></li>
               <li></li>
               <li></li>
               <li></li>
               <li></li>
               <li></li>
               <li></li>
               <li></li>
               <li></li>
               <li></li>
               <li></li>
               <li></li>
            </ol>
            <hr>
            <center>
               <div class="date">
                  <?php 
                     date_default_timezone_set("asia/manila");
                      $time = date("h:i A",strtotime("+0 HOURS"));
                      $date = date("M-d-Y");
                      ?>
                  <strong style="font-size: 1.6em;"><?php echo  $date;?>&nbsp;&nbsp;<font style="color:#ffc107;">|</font>&nbsp;&nbsp; <span style="color: #ff6666;font-size: 1em;" id="tick2" class="timeh1"></strong>
            </center>
            </div>
         </div>
        




    </div>





  </div>
<!-- END MAIN -->

<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>


</body>
</html>