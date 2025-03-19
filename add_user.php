<?php
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once 'db_connection.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = trim($_POST['role'] ?? '');

    if (!empty($username) && !empty($password) && !empty($role)) {
        try {
            
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            
            $sql = "INSERT INTO users (username, password_hash, role) VALUES (:username, :password_hash, :role)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password_hash', $passwordHash, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);

            $stmt->execute();
            $success = "User successfully added!";
        } catch (PDOException $e) {
            $error = "Error adding user: " . $e->getMessage();
        }
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #2c3e50;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px;
        }
        .sidebar h2 {
            text-align: center;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            margin: 10px 0;
        }
        .sidebar a:hover {
            background: #34495e;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #2980b9;
        }
        .message {
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
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
    <div class="main-content">
        <div class="form-container">
            <h2>Add Driver</h2>
            <?php if (!empty($error)) { echo "<p class='message error'>$error</p>"; } ?>
            <?php if (!empty($success)) { echo "<p class='message success'>$success</p>"; } ?>
            <form method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="drivers">Driver</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit">Add User</button>
            </form>
        </div>
    </div>
</body>
</html>
