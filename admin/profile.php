<!-- WORKING -->
<?php

require_once "../app/database/connection.php";
require_once "../app/database/functions.php";
require_once "../path.php";

session_start();

if(!isLoggedIn()){
   header('location:' . BASE_URL . '/pages/entry/login.php');
}
if(!isAdmin()){
   header('location:' . BASE_URL . '/pages/dashboard.php');
}


$empID = $_SESSION['empID'];
$select = " SELECT * FROM employees WHERE employeeID = '$empID' ";
$result = mysqli_query($conn, $select);

if(isset($_POST['update-profile'])){

   //$sID   = mysqli_real_escape_string($conn, $_POST['studentID']);
   $fname = mysqli_real_escape_string($conn, $_POST['fname']);
   $lname = mysqli_real_escape_string($conn, $_POST['lname']);
   $uname = mysqli_real_escape_string($conn, $_POST['uname']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   // $pass = md5($_POST['password']);
   // $cpass = md5($_POST['cpassword']);
   // $isadmin = $_POST['isadmin'];

   $update_select = " SELECT * FROM employees WHERE uname = '$uname' && email = '$email' ";

   $update_result = mysqli_query($conn, $update_select);

   if(mysqli_num_rows($result) > 0){

      // $error[] = 'user already exist!';
      $update = "UPDATE employees SET fname = '$fname', lname = '$lname', uname = '$uname', email = '$email' where employeeID = '$empID' ";
      mysqli_query($conn, $update);
      $success[] = 'Success';
      header('location:' . BASE_URL . '/admin/profile.php');
      
   }else{
      
   } 
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ETES | Admin Profile</title>

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

if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
?>

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Profile</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/dashboard.php' ?>">Dashboard</a></li>
      <li>Admin Profile</li>
    </ul>
  </div>

  <div class="jumbotron jumbotron-fluid bg-white m-2 mx-auto" style="width: 98%;">
  <div class="container">
    <h3 class="display-6 text-center" style="padding-top: 5px !important;padding-bottom: 10px !important;">Welcome, <span style="text-transform: capitalize;"><?php echo $row['fname'] ?>!</span></h3>
  </div>
</div>

<div class="page-content mx-auto">
<form action="" method="post">
      <h3 class="mx-auto" style="width: 95%;">Admin Profile</h3>
      <?php
      // if(isset($error)){
      //    foreach($error as $error){
      //       echo '<span class="error-msg">'.$error.'</span>';
      //    };
      // };

      // if(isset($success)){
      //    foreach($success as $success){
      //       echo '<span class="error-msg">'.$success.'</span>';
      //    };
      // };
      ?> 
      <div class="row" style="margin-left: 20px;">
      <div class="form-group pt-3" style="width: 20%;">
            <label for="studentID">Student ID</label>
            <input class="form-control" style="width: 90%" id="studentID" type="text" value="<?php echo $row['employeeID']; ?>" name="studentID" disabled>
         </div>

         <div class="form-group pt-3" style="width: 20%;">
            <label for="status">Account Status</label>
            <?php
            if($_SESSION['isadmin'] == 1){ 
            ?>
            <input class="form-control" style="width: 90%" id="status" type="text" value="Admin" name="studentID" disabled>
            <?php 
            } else {
            ?>
            <input class="form-control" style="width: 90%" id="status" type="text" value="Student" name="studentID" disabled>
            <?php 
            }
            ?>
         </div>
      </div>
      <!-- <div class="row" style="margin-left: 20px;"> -->
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="fname">First Name</label>
            <input class="form-control" id="fname" type="text" name="fname" value="<?php echo $row['fname']; ?>" required>
         </div>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="fname">Last Name</label>
            <input class="form-control" id="lname" type="text" name="lname" value="<?php echo $row['lname']; ?>" required>
         </div>
      <!-- </div>end ROW -->
      <!-- <div class="row" style="margin-left: 20px;"> -->
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="fname">User Name</label>
            <input class="form-control" id="uname" type="text" name="uname" value="<?php echo $row['uname']; ?>" required>
         </div>   
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="fname">Email Address</label>
            <input class="form-control" id="email" type="email" name="email" value="<?php echo $row['email']; ?>" required>
         </div> 
      <!-- </div> end ROW -->
      <!-- <div class="row" style="margin-left: 20px;">
         <div class="form-group pt-3" style="width: 48.6%;">
            <label for="fname">Password</label>
            <input class="form-control" id="password" type="password" name="password" value="<?php //echo $row['password']; ?>" required>
            <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>  Show/Hide Password
         </div>   
         <div class="form-group pt-3" style="width: 48.6%;">
            <label for="fname">Confirm Password</label>
            <input class="form-control" id="cpassword" type="password" name="cpassword" value="<?php //echo $row['password']; ?>" required>
         </div>
      </div> -->
      <!-- end ROW -->

      <div class="form-group pt-3 mx-auto" style="width: 95%; margin-bottom: 10px;">
      <input type="submit" name="update-profile" value="Update User" class="btn btn-secondary">
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