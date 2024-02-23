<?php
// // Include database connection
// require_once "../database/connection.php";

// // Fetch latest 2 tasks from the database along with client name
// $sql = "SELECT tasks.*, clients.client_name 
//         FROM tasks 
//         INNER JOIN clients ON tasks.client_idno = clients.idno
//         ORDER BY tasks.updated_at DESC 
//         LIMIT 2";

// $result = mysqli_query($conn, $sql);

// $tasks = [];
// while ($row = mysqli_fetch_assoc($result)) {
//     $tasks[] = $row;
// }

// // Output tasks as JSON
// echo json_encode($tasks);

// // Close database connection
// mysqli_close($conn);

// Include database connection
require_once "../database/connection.php";

// Fetch latest 2 tasks from the database along with client name
$sql = "SELECT tasks.*, clients.client_name 
        FROM tasks 
        INNER JOIN clients ON tasks.client_idno = clients.idno
        ORDER BY tasks.updated_at DESC 
        LIMIT 2";

$result = mysqli_query($conn, $sql);

// Output tasks as HTML
while ($row = mysqli_fetch_assoc($result)) {
    // Format date
    $formattedDate = date('j M Y', strtotime($row['updated_at']));
    // Output task card
    echo '<div class="task-card">
            <p class="text-secondary fw-semibold my-auto text-truncate" style="max-width: 200px;">' . $row['title'] . '</p>
            <p class="text-secondary my-auto ms-4">' . $formattedDate . '</p>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: ' . $row['progress'] . '%" aria-valuenow="' . $row['progress'] . '" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <p class="text-secondary my-auto" style="margin-left: 80px;">' . $row['client_name'] . '</p>
            <p class="text-secondary my-auto end"><i class="bi bi-three-dots-vertical"></i></p>
        </div>';
}

// Close database connection
mysqli_close($conn);
?>

