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


// $compID = $_SESSION['empID'];
// $select = " SELECT * FROM employee WHERE employeeID = '$empID' ";
// $result = mysqli_query($conn, $select);

if(isset($_POST['update-company'])){

    $compID   = mysqli_real_escape_string($conn, $_POST['companyID']);
    $cname = mysqli_real_escape_string($conn, $_POST['companyname']);
    $ccity = mysqli_real_escape_string($conn, $_POST['ccity']);
    $cstate = mysqli_real_escape_string($conn, $_POST['cstate']);
    $czip = mysqli_real_escape_string($conn, $_POST['czip']);
 
    $select = " SELECT * FROM company WHERE companyname = '$cname'";
    $update_result = mysqli_query($conn, $select);
 
    if(mysqli_num_rows($update_result) > 0){
 
       // $error[] = 'user already exist!';
       $update = "UPDATE company SET companyname = '$cname', ccity = '$ccity', cstate = '$cstate', czip = '$czip' where companyID = '$compID' ";
       mysqli_query($conn, $update);
       $success[] = 'Success';
       //header('location:' . BASE_URL . '/admin/companies.php');
    //    header('Location: ' . $_SERVER['HTTP_REFERER']);
       
    }else{
       $error[] = "Error";
    } 
 };
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | Update Company</title>

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
   
<?php 
 if (mysqli_num_rows($update_result) > 0) {
   while($row = mysqli_fetch_assoc($update_result)) {
//       $acc_type = $row['acc_type'];
?>

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Add Company</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li><a href="<?php echo BASE_URL . '/admin/companies.php' ?>">Companies</a></li>
      <li>Add Company</li>
    </ul>
  </div>

  <!-- <div class="jumbotron jumbotron-fluid bg-white m-2 mx-auto" style="width: 98%;">
  <div class="container">
    <h3 class="display-6 text-center" style="padding-top: 5px !important;padding-bottom: 10px !important;">Welcome, <span style="text-transform: capitalize;"><?php //echo $row['fname'] ?>!</span></h3>
  </div>
</div> -->

<div class="page-content mx-auto mt-2">
<form action="" method="post">
      <h3 class="mx-auto" style="width: 95%;">Update Company Data</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };

      if(isset($success)){
         foreach($success as $success){
            echo '<span class="success-msg">'.$success.'</span>';
         };
      };
      ?> 
      <?php
    //   $sql = "SELECT * FROM company";
    //   $all = mysqli_query($conn, $sql);
    //   if($all) {
    //       while ($row = mysqli_fetch_assoc($all)) {
    //         $compID   = $row['companyID'];
    //         $cname    = $row['companyname'];
    //         $ccity    = $row['ccity'];
    //         $cstate   = $row['cstate'];
    //         $czip     = $row['czip'];
  ?>
      <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="companyID">Company ID</label>
            <input class="form-control" style="width: 20%" id="companyID" type="text" value="<?php echo $compID; ?>" name="companyID" disabled>
         </div>
      <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="companyname">Company Name</label>
            <input class="form-control" id="companyname" type="text" name="companyname" value="<?php echo $cname; ?>" required>
         </div>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="ccity">City</label>
            <input class="form-control" id="ccity" type="text" name="ccity" value="<?php echo $ccity; ?>" required>
         </div>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="cstate">State</label>
            <input class="form-control" id="cstate" type="text" name="cstate" value="<?php echo $cstate; ?>" required>
         </div>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="czip">Zip Code</label>
            <input class="form-control" id="czip" type="number" name="czip" value="<?php echo $czip; ?>" required>
         </div>
      <div class="form-group pt-3 mx-auto" style="width: 95%; margin-bottom: 10px;">
      <input type="submit" name="update-company" value="Update Company" class="btn btn-secondary">
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

<!-- <script>
   const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });

        // prevent form submit
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });
</script> -->

</body>
</html>