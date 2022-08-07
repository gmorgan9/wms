<!-- WORKING -->
<?php
session_start();
require_once "app/database/connection.php";
require_once "path.php";

$empID = $_SESSION['empID'];
$sql = "UPDATE employee SET loggedin='0' WHERE employeeID='$empID'";
if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

session_unset();
session_destroy();
header('location:' . BASE_URL . '/pages/entry/login.php');

?>