<?php
// Include database connection
require_once "../database/connection.php";

// Fetch audit type counts from the database
$sql = "SELECT framework, COUNT(*) AS count FROM audits GROUP BY framework";
$result = mysqli_query($conn, $sql);

$frameworkCount = [];
while ($row = mysqli_fetch_assoc($result)) {
    $frameworkCount[] = $row;
}

// Output audit type counts as JSON
echo json_encode($frameworkCount);

// Close database connection
mysqli_close($conn);
?>
