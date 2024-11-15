<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ./index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HubVenue || Profile</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="icon" href="./images/black_ico.png">
    <link rel="stylesheet" href="./output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .active {
            border-bottom: 2px solid black;
            color: black;
            font-weight: bold;
            transition: all 0.1s;
        }

        #add-venue {
            width: 80vh;
        }

        #add-venue #formGrids {
            gap: .5rem;
        }

        #add-venue #formTitle {
            padding: 1rem;
        }
    </style>

    </style>
</head>

<body class="bg-gray-50 relative">
    <?php
    require_once './components/profile.nav.php';

    include_once './components/SignupForm.html';
    include_once './components/feedback.modal.html';
    include_once './components/confirm.feedback.modal.html';
    include_once './components/Menu.html';

    ?>

    <div id="profileDisplay">

    </div>

    <div id="userAddVenueForm"
        class="fixed inset-0 bg-black bg-opacity-40 items-center justify-center z-40 p-8 hidden  ">
        <?php require_once './venue-management/add-venue.html' ?>
    </div>

    <script src="./vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="./js/user.jquery.js"></script>
    <script>
        let map;
        let marker;
    </script>

</body>