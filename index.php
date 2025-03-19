<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
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
        <a href="notif.php">Push Notification</a>
    </div>

    <div class="main-content">
        <h1>Real-Time Truck Fleet Tracking</h1>
        <div id="map"></div>
    </div>

    <script>
        function initMap() {
          
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: { lat: 10.2991389, lng: 123.8549722 },
            });

            fetch('get_locations.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(driver => {
                        
                        var marker = new google.maps.Marker({
                            position: { lat: driver.latitude, lng: driver.longitude },
                            map: map,
                            title: driver.name + ' (' + driver.vehicle_id + ')'
                        });

                        
                        var infoWindow = new google.maps.InfoWindow({
                            content: `<strong>${driver.name}</strong><br>Vehicle: ${driver.vehicle_id}`
                        });

                        marker.addListener('click', () => {
                            infoWindow.open(map, marker);
                        });
                    });
                })
                .catch(error => console.error('Error fetching locations:', error));
        }
    </script>

 
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1k7B3NqZ9kOAA6ydcHXWtcctWYpoEA5w&callback=initMap" async defer></script>
</body>
</html>
