<?php

require_once "app/database/connection.php";
require_once "path.php";

session_start();

// if(isLoggedIn()){
//    header('location:' . BASE_URL . '/pages/dashboard.php');
// }

if(isset($_POST['login-btn'])){
	$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
	$fname = mysqli_real_escape_string($conn, $_POST['fname']);
	$lname = mysqli_real_escape_string($conn, $_POST['lname']);
	$uname = mysqli_real_escape_string($conn, $_POST['uname']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
	// $pass = md5($_POST['password']);
	$isadmin = $_POST['account_type'];
	$loggedin = $_POST['logged_in'];
 
	$select = " SELECT * FROM users WHERE uname = '$uname' && password = '$pass' ";
	$result = mysqli_query($conn, $select);
	if(mysqli_num_rows($result) > 0){
	    $row = mysqli_fetch_array($result);
	    $sql = "UPDATE users SET logged_in='1' WHERE uname='$uname'";
	    mysqli_query($conn, $sql);
	    $_SESSION['fname']          = $row['fname'];
	    $_SESSION['user_id']        = $row['user_id'];
	    $_SESSION['loggedin']       = $row['logged_in'];
	    $_SESSION['user_idno']      = $row['idno'];
	    $_SESSION['lname']          = $row['lname'];
	    $_SESSION['acc_type']       = $row['account_type'];
	    $_SESSION['uname']          = $row['uname'];
	    $_SESSION['email']          = $row['email'];
	    $_SESSION['pass']           = $row['password'];
	    header('location:' . BASE_URL . '/pages/dashboard.php');
        // header('location: pages/dashboard.php');
	} else {
	   $error[] = 'Incorrect username or password!';
	}
 };
?>

<html>

<head>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/loginpage.css?v=<?php echo time(); ?>">

  <!-- Page Title -->
  <title>Sign In | WMS</title>

</head>

<body>
    <div class="main" style="height: 450px;">
        <p class="sign">Sign in</p>
        <p class="sub_sign">Work Management System</p>
        <?php
            if(isset($error)){
                foreach($error as $err){
                    echo '<div class="alert alert-danger error-msg" role="alert">'.$err.'</div>';
                }
            }
        ?>
        <form class="form1" method="POST">
            <input class="un " type="text" placeholder="Username" name="uname">
            <input class="pass" type="password" style="align: center;" placeholder="Password" name="password">
            <input type="submit" name="login-btn" value="Login" class="submit">
            <p class="forgot"><a href="#">Forgot Password?</a></p>
            <p class="signup">Dont have an account? <a href="#">Sign up</a></p>          
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/loginpage.js"></script>
     
</body>

</html>