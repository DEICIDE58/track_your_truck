<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'driver') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    
</head>
<body>
    <h1>Welcome User, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <a href="logout.php">Logout</a>
    <a href="driver.php">HALO</a>
</body>
</html>
