<?php
require_once 'db_connection.php';
$defaultAdminUsername = 'admin@trackyourtruck.com';
$defaultAdminPassword = '1234';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        if (strlen($username) < 4) {
            die("Error: Username must be at least 4 characters. <a href='register.php'>Try Again</a>");
        }

        if (strlen($password) < 6) {
            die("Error: Password must be at least 6 characters. <a href='register.php'>Try Again</a>");
        }

        try {
            
            $checkSql = "SELECT COUNT(*) FROM users WHERE username = :username";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bindParam(':username', $username, PDO::PARAM_STR);
            $checkStmt->execute();

            if ($checkStmt->fetchColumn() > 0) {
                die("Error: Username already exists. <a href='register.php'>Try Again</a>");
            }


            $passwordHash = password_hash($password, PASSWORD_BCRYPT);


            $sql = "INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password_hash', $passwordHash, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "Registration successful! <a href='login.php'>Go to Login</a>";
            } else {
                echo "Error: Unable to register user.";
            }
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    } else {
        echo "Error: All fields are required. <a href='register.php'>Try Again</a>";
    }
}
?>
