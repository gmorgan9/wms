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

    $rejUpdateQuery = "UPDATE timeclock SET timeout = '".$_POST['timeout']."' WHERE employee_idno = '".$_POST['employee_idno']."'";
    $rejUpdateResult = mysqli_query($conn,$rejUpdateQuery);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
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

    <?php 

        $timezone = date_default_timezone_get();
        date_default_timezone_set($timezone);
        $date = date('Y-m-d');
        $time = date('h:i:s');
        echo $date;  echo '&nbsp;';
        echo $time;

    ?>

        <form method="post" action="">
            <?php $empID = $_SESSION['employee_idno']; ?>
            <input type="text" name="employee_idno" value="<?php echo $empID; ?>" />
            <input type="date" name="date" value="<?php echo $date; ?>" />
            <input type="hidden" name="timein" value="<?php echo $time; ?>" />
            <button style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="clockin"><span class="badge text-bg-success">Clock In</span></button>
        </form>
        <form method="post" action="">

            <label for="employee_idno">Employee ID</label>
            <input class="form-control w-25" id="employee_idno" type="text" name="employee_idno">
            <input type="hidden" name="timeout" value="<?php echo $time; ?>" />
            <button style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="clockout"><span class="badge text-bg-danger">Clock Out</span></button>
        </form>

    </div>





  </div>
<!-- END MAIN -->

<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>


</body>
</html>