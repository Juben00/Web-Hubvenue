<?php
require_once '../classes/account.class.php';
require_once '../classes/venue.class.php';
require_once '../sanitize.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Read and decode the raw JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    $bookingId = clean_input($data['booking_id'] ?? '');

    if (empty($bookingId)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to mark booking as no-show. Booking ID is missing.',
        ]);
        exit();
    }

    $venueObj = new Venue();
    $result = $venueObj->markNoShow($bookingId);

    echo json_encode([
        'status' => $result ? 'success' : 'error',
        'message' => $result ? 'Booking marked as no-show.' : 'Failed to mark booking as no-show.',
    ]);
    exit();
}
?>