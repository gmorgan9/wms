<?php
include("../database/connection.php");

// Array to store counts for each day
$counts = array(
    'Monday' => 0,
    'Tuesday' => 0,
    'Wednesday' => 0,
    'Thursday' => 0,
    'Friday' => 0
);

// Fetch data
$sql = "SELECT * FROM tasks";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    // Assuming you have a column named 'day' in your 'tasks' table
    $day = $row['day'];

    // Increment count for corresponding day
    if (array_key_exists($day, $counts)) {
        $counts[$day]++;
    }
}

// Prepare data for JSON output
$data = array();
foreach ($counts as $day => $count) {
    $data[] = array(
        'x_value' => $day,
        'y_value' => $count
    );
}

// Output data as JSON
echo json_encode($data);

// Close connection
mysqli_close($conn);
?>
