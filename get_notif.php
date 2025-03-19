<?php
require 'db_connect.php'; // Include your database connection

// Get the latest notification
$result = $conn->query("SELECT message FROM notifications ORDER BY created_at DESC LIMIT 1");

if ($row = $result->fetch_assoc()) {
    echo json_encode(["message" => $row['message']]);
} else {
    echo json_encode(["message" => ""]);
}
?>
