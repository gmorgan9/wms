<?php
session_start();
require_once "app/database/connection.php";
require_once "path.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "UPDATE users SET logged_in='0' WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL);
        exit; // Ensure no further code is executed after the redirection
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Handle case where $_SESSION['user_id'] is not set
    echo "Session user_id not set.";
}
?>
