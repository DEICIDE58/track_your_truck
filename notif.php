<?php
session_start();
require 'db_connect.php'; // Include your database connection

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);

    // Insert notification into the database
    $stmt = $conn->prepare("INSERT INTO notifications (message) VALUES (?)");
    $stmt->bind_param("s", $message);
    $stmt->execute();
    $stmt->close();

    echo "Notification sent!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notification</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: 50px auto; padding: 20px; background: #f8f9fa; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; }
        select, textarea, button { width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #3498db; color: white; border: none; cursor: pointer; }
        button:hover { background: #2980b9; }
    </style>
    <script>
        function updateMessage() {
            let dropdown = document.getElementById("presetMessages");
            let customInput = document.getElementById("customMessage");

            if (dropdown.value !== "custom") {
                customInput.value = dropdown.value;
            } else {
                customInput.value = "";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Send Notification</h2>
        <form method="POST">
            <label for="presetMessages">Choose a Notification:</label>
            <select id="presetMessages" onchange="updateMessage()">
                <option value="custom">-- Type a Custom Message --</option>
                <option value="Your delivery is on the way.">Your delivery is on the way.</option>
                <option value="Truck has arrived at the destination.">Truck has arrived at the destination.</option>
                <option value="Please update your current location.">Please update your current location.</option>
                <option value="Emergency: Contact Admin Immediately!">Emergency: Contact Admin Immediately!</option>
            </select>

            <label for="customMessage">Or Type Your Own:</label>
            <textarea id="customMessage" name="message" required></textarea>

            <button type="submit">Send Notification</button>
        </form>
    </div>
</body>
</html>
