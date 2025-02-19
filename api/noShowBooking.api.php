<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';

header('Content-Type: application/json');

$venueObj = new Venue();
$accountObj = new Account();

// Check if user is logged in and has admin privileges
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] != 3) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized access'
    ]);
    exit;
}

// Get booking ID from POST data
$booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : null;

if (!$booking_id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Booking ID is required'
    ]);
    exit;
}

try {
    // Update booking check-in status to No-Show
    $result = $venueObj->updateBookingNoShow($booking_id);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Guest has been marked as no-show'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to mark guest as no-show'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>