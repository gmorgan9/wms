<!-- WORKING -->
<pre><?php

//require_once "../../app/database/connection.php";
require_once "../../app/database/functions.php";
require_once "../../path.php";

session_start();

if(isLoggedIn()){
   header('location:' . BASE_URL . '/pages/dashboard.php');
}




?>
</pre>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | Login</title>

<!-- Custom Styles -->
<link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/main-style.css?v='. time(); ?>">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

</head>
<body>

<?php include("../../app/includes/header.php"); ?>
   
<br><br><br>
<div class="form-container mx-auto">

   <form action="" method="post">
      <h3>login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="uname" required placeholder="enter your user name">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="login-btn" value="Login" class="form-btn">
      <p>don't have an account? <a href="/pages/entry/register.php">register now</a></p>
   </form>

</div>

<?php include("../../app/includes/footer.php"); ?>

</body>
</html>