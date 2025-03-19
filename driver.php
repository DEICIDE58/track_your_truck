<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Notifications</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .notification { padding: 20px; background: #ffcc00; color: black; border-radius: 5px; display: none; margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Driver Notification Panel</h2>
    <div id="notification" class="notification"></div>

    <script>
        function checkNotification() {
            fetch('get_notif.php')
                .then(response => response.json())
                .then(data => {
                    let notifBox = document.getElementById('notification');

                    if (data.message) {
                        notifBox.innerText = data.message;
                        notifBox.style.display = 'block';
                    } else {
                        notifBox.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        setInterval(checkNotification, 3000); // Check every 3 seconds
    </script>
</body>
</html>
