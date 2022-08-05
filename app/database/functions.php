<!-- WORKING -->
<?php

session_start();
require('connection.php');

function isLoggedIn()
{
	if (isset($_SESSION['empID'])) {
		return true;
	}else{
		return false;
	}
}

function isAdmin()
{
	if ($_SESSION['isadmin'] == 1) {
		return true;
	}else{
		return false;
	}
}