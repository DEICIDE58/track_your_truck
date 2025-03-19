<?php
require_once 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        form button:hover {
            background-color: #45a049;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007BFF;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <form action="register_handler.php" method="POST" onsubmit="return validateForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <small id="usernameError" class="error"></small>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <small id="passwordError" class="error"></small>

            <button type="submit">Register</button>
        </form>
        <a href="login.php" class="back-link">Back to Login</a>
    </div>

    <script>
        function validateForm() {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            let isValid = true;

            if (username.length < 4) {
                document.getElementById('usernameError').innerText = 'Username must be at least 4 characters.';
                isValid = false;
            } else {
                document.getElementById('usernameError').innerText = '';
            }

            if (password.length < 6) {
                document.getElementById('passwordError').innerText = 'Password must be at least 6 characters.';
                isValid = false;
            } else {
                document.getElementById('passwordError').innerText = '';
            }

            return isValid;
        }
    </script>
</body>
</html>
