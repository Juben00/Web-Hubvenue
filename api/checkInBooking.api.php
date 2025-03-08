<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';

header('Content-Type: text/html');

$venueObj = new Venue();
$accountObj = new Account();

session_start();

$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null;
if (!isset($_SESSION['user'])) {
    renderMessage("Error", "Unauthorized Access", "error");
    exit;
}

if (!isset($booking_id)) {
    renderMessage("Error", "Booking ID not provided", "error");
    exit;
}

// Get booking ID from GET data

function renderMessage($title, $message, $type)
{
    $colors = [
        'success' => ['#d4edda', '#155724', '#c3e6cb'],
        'error' => ['#f8d7da', '#721c24', '#f5c6cb']
    ];
    $bgColor = $colors[$type][0];
    $textColor = $colors[$type][1];
    $borderColor = $colors[$type][2];

    echo "
        <div style='
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: $bgColor;
            border: 1px solid $borderColor;
            color: $textColor;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        '>
            <h2 style='margin-bottom: 10px;'>$title</h2>
            <p style='font-size: 16px;'>$message</p>
            <a href='/hubvenue/index.php' style='
                display: inline-block;
                margin-top: 15px;
                padding: 10px 20px;
                background-color: $textColor;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                transition: background 0.3s;
            ' onmouseover='this.style.backgroundColor=\"#444\"' onmouseout='this.style.backgroundColor=\"$textColor\"'>
                Back to Dashboard
            </a>
        </div>
    ";
}

try {
    // Update booking check-in status
    $result = $venueObj->updateBookingCheckIn($booking_id);

    if ($result) {
        renderMessage("Success", "Guest has been checked in successfully!", "success");
    } else {
        renderMessage("Error", "Failed to check in guest.", "error");
    }
} catch (Exception $e) {
    renderMessage("Error", $e->getMessage(), "error");
}
?>