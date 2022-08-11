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

  <div class="page-content mt-2 float-end" style="width: 65%; margin-right: 10px;">
    <!-- <span class="mx-auto">Timesheet for <span class="text-muted text-capitalize"><?php //echo $_SESSION['fname']; ?></span></span> -->
    <table class="table">
      <thead>
        <tr>
          <th scope="col" style="font-size: 14px;">ID #</th>
          <th scope="col" style="font-size: 14px;">Employee</th>
          <th scope="col" style="font-size: 14px;">Status</th>
          <th scope="col" style="font-size: 14px;">Actions</th>
        </tr>
      </thead>
    <tbody class="table-group-divider">

    <?php
        $sql = "SELECT * FROM timesheet";
        $all = mysqli_query($conn, $sql);
        if($all) {
            while ($row = mysqli_fetch_assoc($all)) {
              $timeID           = $row['timeID'];
              $idno             = $row['idno'];
              $orgDate          = $row['date'];
              $date             = date("M d, Y", strtotime($orgDate));
              $orgTimein        = $row['timein'];
              $timein           = date("h:i A", strtotime($orgTimein));
              $orgTimeout       = $row['timeout'];
              $timeout          = date("h:i A", strtotime($orgTimeout));
              $totalhours       = $row['totalhours'];
              $employee_fname   = $row['employee_fname'];
              $employee_lname   = $row['employee_lname'];
              $employee_idno    = $row['employee_idno'];
              $comment          = $row['comment'];
              $reason           = $row['reason'];
              $app_status       = $row['approval_status'];
              // $companyname    = $row['companyname'];
    ?>
      <tr>
          <th scope="row"><?php echo $idno; ?></th>
          <td><?php echo $employee_lname; ?>, <?php echo $employee_fname; ?></td>
          <?php if($app_status == 'approved'){ ?>
          <td><span class="text-capitalize text-success"><?php echo $app_status; ?><span></td>
          <?php } if($app_status == 'rejected') { ?>
            <td><span class="text-capitalize text-danger"><?php echo $app_status; ?><span></td>
          <?php } if($app_status == 'pending') { ?>
            <td><span class="text-capitalize text-primary"><?php echo $app_status; ?><span></td>
          <?php }?>
          <!-- <td><?php //echo $companyname; ?></td> -->
          <td>
            <a style="text-decoration: none;" class="badge text-bg-success" href="actions/view-timesheet.php?timeID=<?php echo $timeID; ?>">View</a>
          <a onclick="return confirm('Be Careful! \r\nOK to delete?')" style="text-decoration: none;" class="badge text-bg-danger" href="timesheet.php?timeID=<?php echo $timeID; ?>">Delete</a></td>
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










  </div>
<!-- END MAIN -->


<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>


</body>
</html>