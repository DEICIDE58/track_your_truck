<?php
session_start();

// Ensure user is authenticated and has the admin role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Include database connection
require_once 'db_connection.php'; // Replace with your actual DB connection file

// Fetch vehicle data from the database
try {
    $sql = "SELECT vehicle_id, status, last_update, correct_latitude_column, correct_longitude_column FROM vehicle_status";
    $result = $conn->query($sql);

    $pdo = null;
    if ($pdo === null) {
        die('Database connection is not established.');
    }
    $stmt = $pdo ->prepare("SELECT * FROM track_your_truck");
    $stmt ->execute();
    $numRows = $stmt ->rowCount();
    $vehicles = [];
    if ($result-> num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }
    }
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=track_your_truck', 'username', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
  
    header('Content-Type: application/json');
    echo json_encode($vehicles);
} catch (Exception $e) {
    // Handle errors and return appropriate JSON response
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => $e->getMessage()]);
} finally {
   

    $pdo = null;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truck Fleet Management - Real-Time Tracking</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

      
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #2c3e50;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            margin: 5px 0;
            font-size: 18px;
            border-radius: 4px;
        }
        .sidebar a:hover {
            background: #34495e;
        }

      
        .main-content {
            margin-left: 250px;
            padding: 20px;
            box-sizing: border-box;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
        }
        #map {
            height: 500px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

      
        @media (max-width: 1024px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
            }
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
                padding: 10px;
            }
            h1 {
                font-size: 24px;
            }
        }
        @media (max-width: 480px) {
            h1 {
                font-size: 20px;
            }
            .sidebar a {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="tracking2.php">Tracking</a>
        <a href="index.php">View Location</a>
        <a href="add_user.php">Add User</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <h1>Real-Time Truck Fleet Tracking</h1>
        <div id="map"></div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1k7B3NqZ9kOAA6ydcHXWtcctWYpoEA5w&callback=initMap" async defer></script>
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: { lat: 10.2991389, lng: 123.8549722 }, // Default center
            });

            // Fetch vehicle data and create markers
            fetch('tracking2.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(vehicle => {
                        const marker = new google.maps.Marker({
                            position: { lat: parseFloat(vehicle.latitude), lng: parseFloat(vehicle.longitude) },
                            map: map,
                            title: `${vehicle.vehicle_id} - ${vehicle.status}`,
                        });

                        // Create info windows for markers
                        const infoWindow = new google.maps.InfoWindow({
                            content: `
                                <strong>${vehicle.vehicle_id}</strong><br>
                                Status: ${vehicle.status}<br>
                                Last Updated: ${new Date(vehicle.last_update).toLocaleString()}
                            `,
                        });

                        // Add click listener for info window
                        marker.addListener('click', () => {
                            infoWindow.open(map, marker);
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching vehicle data:', error);
                });
        }
    </script>
</body>
</html>
