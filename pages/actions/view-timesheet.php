<!-- WORKING -->
<?php

require_once "../../app/database/connection.php";
require_once "../../app/database/functions.php";
require_once "../../path.php";

session_start();

if(!isLoggedIn()){
   header('location:' . BASE_URL . '/pages/entry/login.php');
}
if(!isAdmin()){
   header('location:' . BASE_URL . '/pages/dashboard.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | View Job</title>

   <!-- Custom Styles -->
   <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/other-style.css?v='. time(); ?>">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

</head>
<body>

<?php include(ROOT_PATH . "/app/includes/header.php"); ?>


<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
        
<!-- start MAIN -->
<div class="main"> 
   
<?php 

$id = $_GET['timeID'];
$select = " SELECT * FROM timesheet WHERE timeID = '$id' ";
$result = mysqli_query($conn, $select);

if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      //$acc_type = $row['acc_type'];
?>

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;"></p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li><a href="<?php echo BASE_URL . '/pages/timesheet.php' ?>">Timesheets</a></li>
      <li>Viewing: <span class="text-muted" style="text-transform: capitalize"><?php echo $row['idno']; ?>  </span></li>
    </ul>
  </div>

<div class="page-content mx-auto mt-2">
<form action="" method="post">
      <!-- <h3 class="mx-auto" style="width: 95%;">Employee View</h3> -->


      <!-- <div class="col-md-8 float-start w-25 ms-4">
              <div class="card mb-3">
                <div class="card-body">
                  <img class="ms-1" src="../../assets/img/pic_holder.jpg" style="height: 250px; width: 250px; border-radius: 150px;" alt="">
                  </div>
                </div>
              </div> -->



      <div class="col-md-8 me-4">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Timesheet Entry ID</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <span class="text-capitalize"><?php echo $row['idno']; ?></span>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Date</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php 
                        $orgDate = $row['date'];
                        $newDate = date("M d, Y", strtotime($orgDate));
                        ?>
                      <?php echo $newDate; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Time In</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php 
                        $orgTimein = $row['timein'];
                        $newTimein = date("H:i A", strtotime($orgTimein));
                        ?>
                     <?php echo $newTimein; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Time Out</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php 
                        $orgTimeout = $row['timeout'];
                        $newTimeout = date("H:i A", strtotime($orgTimeout));
                        ?>
                    <?php echo $newTimeout; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Employment Status</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?php if($row['status'] == 1) { ?>
                        <span class="text-success">Active</span>
                     <?php } if($row['status'] == 0) { ?>
                        <span class="text-danger">Inactive</span>
                     <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
              <a class="text-decoration-none text-dark" href="actions/view-timesheet.php?timeID=<?php echo $timeID; ?>"><?php echo $idno; ?></a>

      <?php 
      }
   } else {
     echo "0 results";
   }
      ?>
   </form>
</div>

 
<!-- end MAIN -->
</div> 


<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

</body>
</html>