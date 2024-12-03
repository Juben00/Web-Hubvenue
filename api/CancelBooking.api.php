<?php
require_once '../classes/venue.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingId = $_POST['booking-id'] ?? null;
    $reason = $_POST['cancellation-reason'] ?? null;

    if ($bookingId && $reason) {
        $venueObj = new Venue();
        $result = $venueObj->cancelBooking($bookingId, $reason);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Booking cancelled successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to cancel booking.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>