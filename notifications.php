<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <style>
        .notification-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .notification {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            background-color: #fff;
        }

        .notification.new {
            border-color: #007bff;
            background-color: #e7f3ff;
        }
    </style>
</head>

<body>
    <div class="notification-container">
        <div class="notification new">Your order has been shipped!</div>
        <div class="notification">You have a new message.</div>
        <div class="notification">Your profile has been updated.</div>
    </div>
</body>

</html>