<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicle_id = $_POST['vehicle_id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $query = "UPDATE drivers SET latitude = :latitude, longitude = :longitude, last_updated = CURRENT_TIMESTAMP WHERE vehicle_id = :vehicle_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':latitude', $latitude);
    $stmt->bindParam(':longitude', $longitude);
    $stmt->bindParam(':vehicle_id', $vehicle_id);
    $stmt->execute();
}
?>