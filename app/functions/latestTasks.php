<?php
// Include database connection
require_once "../database/connection.php";

// Fetch latest 2 tasks from the database along with client name
$sql = "SELECT tasks.*, clients.client_name 
        FROM tasks 
        INNER JOIN clients ON tasks.client_idno = clients.idno
        ORDER BY tasks.updated_at DESC 
        LIMIT 2";

$result = mysqli_query($conn, $sql);

$tasks = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;
}

// Output tasks as JSON
echo json_encode($tasks);

// Close database connection
mysqli_close($conn);
?>
