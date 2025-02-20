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

// Get booking ID from GET data
$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null;

if (!$booking_id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Booking ID is required'
    ]);
    exit;
}

try {
    // Get the booking charges
    $charges = $venueObj->getBookingCharges($booking_id);

    echo json_encode([
        'status' => 'success',
        'charges' => $charges
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?> 