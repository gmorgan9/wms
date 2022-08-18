<!-- WORKING -->
<?php

session_start();
require('connection.php');

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


// variable declaration
$username = "";
$email    = "";
$errors   = array(); 

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM employee WHERE uname='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['acc_type'] == 1) {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: /pages/dashboard.php');		  
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: /pages/dashboard.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}