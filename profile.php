<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HubVenue || Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .active {
            border-bottom: 2px solid black;
            color: black;
            font-weight: bold;
            transition: all 0.1s;
        }
    </style>
</head>

<body class="bg-gray-50">
    <?php
    require_once './components/profile.nav.php';

    include_once './components/SignupForm.html';
    include_once './components/feedback.modal.html';
    include_once './components/confirm.feedback.modal.html';
    include_once './components/Menu.html';

    ?>

    <div id="profileDisplay">

    </div>

    <script src="./vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="./js/user.jquery.js"></script>
</body>