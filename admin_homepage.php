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
                padding-top: 0px;
            font-family: Arial, sans-serif;
            background-image: url('images.jpg'); /* Use your background image */
            background-size: 900px; /* Ensures the image covers the whole viewport */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-position: center; /* Centers the image */
            background-attachment: fixed; /* Keeps the background fixed while scrolling */
            }
            .main-content {
            margin-left: auto; /* Centers the content horizontally */
            margin-right: auto; /* Centers the content horizontally */
            padding: 20px;
            width: 500px; /* Adjust form width as needed */
            border-radius: 10px; /* Adds rounded edges to the form container */
            margin-top: 50px; /* Adds some spacing from the top */
            }
        .sideBar {
            width: 250px;
            height: 100vh;
            background: #2c3e50;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
        }
        .sideBar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sideBar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            margin: 5px 0;
        }
        .sideBar a:hover {
            background: #34495e;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }
        form {
            margin-left: 403px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds a subtle shadow for design */
            margin-right: 500px;
            background-color: rgba(255, 255, 255, 0.4);
    max-width: 500px;
    margin-top: 20px;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
label {
    display: block;
    margin-top: 10px;
}

input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
        button {
            margin-top: 15px;
            padding: 10px;
            background: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        .back{
            margin-top: 15px;
            padding: 10px;
            background: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #2980b9;
        }
        .back:hover {
            background: #2980b9;
        }
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #2c3e50;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            margin: 5px 0;
        }
        .sidebar a:hover {
            background: #34495e;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #3498db;
            color: white;
        }
        a.action-link {
            color: red;
            margin-right: 10px;
        }
        a.action-link:hover {
            text-decoration: underline;
        }
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="index.php">View Location</a>
        <a href="add_user.php">Add User</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
     </div>
    
    <h1>Real-Time Truck Fleet Tracking</h1>
    <div id="map"></div>

    <script>
        function initMap() {
            // Create a map centered at a default location (e.g., center of your city or area)
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: { lat: 10.2991389, lng: 123.8549722 },
            });

            // Example of fetching real-time truck locations from PHP
            fetch('get_locations.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(driver => {
                        // Create a marker for each driver
                        var marker = new google.maps.Marker({
                            position: { lat: driver.latitude, lng: driver.longitude },
                            map: map,
                            title: driver.name + ' (' + driver.vehicle_id + ')'
                        });

                        // Optionally, you can add an info window on the map for each marker
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

    <!-- Load Google Maps API with your API key -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1k7B3NqZ9kOAA6ydcHXWtcctWYpoEA5w&callback=initMap" async defer></script>
    
</body>
</html>
