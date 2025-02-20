<?php
header('Content-Type: application/json');
require_once '../classes/venue.class.php';

try {
    if (!isset($_GET['venue_id'])) {
        throw new Exception('Venue ID is required');
    }

    $venueObj = new Venue();
    $venue = $venueObj->getSingleVenue($_GET['venue_id']);

    if (!$venue) {
        throw new Exception('Venue not found');
    }

    // Check if venue is an error response
    if (isset($venue['status']) && $venue['status'] === 'error') {
        throw new Exception($venue['message']);
    }

    echo json_encode([
        'success' => true,
        'venue' => $venue
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 