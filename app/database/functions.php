<!-- WORKING -->
<?php

session_start();
require('connection.php');




if(isset($_POST['login-btn'])){

	$empID = mysqli_real_escape_string($conn, $_POST['employeeID']);
	$fname = mysqli_real_escape_string($conn, $_POST['fname']);
	$lname = mysqli_real_escape_string($conn, $_POST['lname']);
	$uname = mysqli_real_escape_string($conn, $_POST['uname']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pass = md5($_POST['password']);
	$cpass = md5($_POST['cpassword']);
	$isadmin = $_POST['isadmin'];
	$loggedin = $_POST['loggedin'];
 
	$select = " SELECT * FROM employee WHERE uname = '$uname' && password = '$pass' ";
 
	$result = mysqli_query($conn, $select);
 
	if(mysqli_num_rows($result) > 0){
 
	   $row = mysqli_fetch_array($result);
	   $sql = "UPDATE employee SET loggedin='1' WHERE uname='$uname'";
	   if (mysqli_query($conn, $sql)) {
		  echo "Record updated successfully";
		} else {
		  echo "Error updating record: " . mysqli_error($conn);
		}
		$_SESSION['fname']           = $row['fname'];
		$_SESSION['empID']           = $row['employeeID'];
		$_SESSION['loggedin']        = $row['loggedin'];
		$_SESSION['employee_idno']   = $row['idno'];
		$_SESSION['lname']           = $row['lname'];
		$_SESSION['acc_type']        = $row['acc_type'];
		$_SESSION['uname']           = $row['uname'];
	   $_SESSION['email']            = $row['email'];
	   $_SESSION['pass']             = $row['password'];
	   $_SESSION['cpass']            = $row['cpassword'];
	   header('location:' . BASE_URL . '/pages/dashboard.php');
	  
	}else{
	   $error[] = 'incorrect email or password!';
	}
 
 };








function isLoggedIn()
{
	if (isset($_SESSION['employee_idno'])) {
		return true;
	}else{
		return false;
	}
}

function isAdmin()
{
	if ($_SESSION['acc_type'] == 1) {
		return true;
	}else{
		return false;
	}
}