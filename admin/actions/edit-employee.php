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




// if(isset($_POST['update-profile'])){

//    //$sID   = mysqli_real_escape_string($conn, $_POST['studentID']);
//    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
//    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
//    $uname = mysqli_real_escape_string($conn, $_POST['uname']);
//    $email = mysqli_real_escape_string($conn, $_POST['email']);
//    // $pass = md5($_POST['password']);
//    // $cpass = md5($_POST['cpassword']);
//    // $isadmin = $_POST['isadmin'];

//    $update_select = " SELECT * FROM employee WHERE uname = '$uname' && email = '$email' ";

//    $update_result = mysqli_query($conn, $update_select);

//    if(mysqli_num_rows($result) > 0){

//       // $error[] = 'user already exist!';
//       $update = "UPDATE employee SET fname = '$fname', lname = '$lname', uname = '$uname', email = '$email' where employeeID = '$empID' ";
//       mysqli_query($conn, $update);
//       $success[] = 'Success';
//       header('location:' . BASE_URL . '/admin/profile.php');
      
//    }else{
      
//    } 
// };

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | View User</title>

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

$id = $_GET['employeeID'];
$select = " SELECT * FROM employee WHERE employeeID = '$id' ";
$result = mysqli_query($conn, $select);

if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      $acc_type = $row['acc_type'];
?>

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Profile</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li><a href="<?php echo BASE_URL . '/admin/employees.php' ?>">Employees</a></li>
      <li>Viewing Employee: <span class="text-muted" style="text-transform: capitalize"><?php echo $row['fname']; ?>  </span></li>
    </ul>
  </div>

<div class="page-content mt-2 float-start" style="margin-left: -55px; width: 48%;">
<form action="" method="post">
      <span class="mx-auto text-muted" style="padding-top: 10px; width: 95%;">Personal Information</span>
      <hr>
      <div class="row" style="margin-left: 20px;">
      <div class="form-group pt-3" style="width: 20%;">
            <label for="idno">Employee ID Number</label>
            <input class="form-control" style="width: 90%" id="idno" type="text" value="<?php echo $row['idno']; ?>" name="idno" disabled>
         </div>

         <div class="form-group pt-3" style="width: 20%;">
            <label for="status">Account Type</label>
            <?php
            if($acc_type == 1){ 
            ?>
            <input class="form-control" style="width: 90%" id="status" type="text" value="Admin" name="status" disabled>
            <?php 
            } else {
            ?>
            <input class="form-control" style="width: 90%" id="status" type="text" value="Employee" name="status" disabled>
            <?php 
            }
            ?>
         </div>
      </div>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="fname">First Name</label>
            <input class="form-control" id="fname" type="text" name="fname" value="<?php echo $row['fname']; ?>" required>
         </div>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="lname">Last Name</label>
            <input class="form-control" id="lname" type="text" name="lname" value="<?php echo $row['lname']; ?>" required>
         </div>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="uname">User Name</label>
            <input class="form-control" id="uname" type="text" name="uname" value="<?php echo $row['uname']; ?>" required>
         </div>   
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="email">Email Address</label>
            <input class="form-control" id="email" type="email" name="email" value="<?php echo $row['email']; ?>" required>
         </div> 
      <?php 
      }
   } else {
     echo "0 results";
   }
      ?>
   </form>
</div>


<?php 

$id = $_GET['employeeID'];
$select = " SELECT * FROM employee WHERE employeeID = '$id' ";
$result = mysqli_query($conn, $select);

if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
      $acc_type = $row['acc_type'];
?>


<div class="page-content mt-2 float-end" style="margin-left: -120px; width: 48%;">
<form action="" method="post">
      <span class="mx-auto text-muted" style="padding-top: 10px; width: 95%;">Employee Information</span>
      <hr>
      <div class="row" style="margin-left: 20px;">
      <div class="form-group pt-3" style="width: 20%;">
            <label for="idno">Employee ID Number</label>
            <input class="form-control" style="width: 90%" id="idno" type="text" value="<?php echo $row['idno']; ?>" name="idno" disabled>
         </div>

         <div class="form-group pt-3" style="width: 20%;">
            <label for="status">Account Type</label>
            <?php
            if($acc_type == 1){ 
            ?>
            <input class="form-control" style="width: 90%" id="status" type="text" value="Admin" name="status" disabled>
            <?php 
            } else {
            ?>
            <input class="form-control" style="width: 90%" id="status" type="text" value="Employee" name="status" disabled>
            <?php 
            }
            ?>
         </div>
      </div>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="fname">First Name</label>
            <input class="form-control" id="fname" type="text" name="fname" value="<?php echo $row['fname']; ?>" required>
         </div>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="lname">Last Name</label>
            <input class="form-control" id="lname" type="text" name="lname" value="<?php echo $row['lname']; ?>" required>
         </div>
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="uname">User Name</label>
            <input class="form-control" id="uname" type="text" name="uname" value="<?php echo $row['uname']; ?>" required>
         </div>   
         <div class="form-group pt-3 mx-auto" style="width: 95%;">
            <label for="email">Email Address</label>
            <input class="form-control" id="email" type="email" name="email" value="<?php echo $row['email']; ?>" required>
         </div> 
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