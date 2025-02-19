<?php
header('Content-Type: application/json');
require_once '../classes/venue.class.php';

try {
    if (!isset($_POST['venue_id'])) {
        throw new Exception('Venue ID is required');
    }

    $venueObj = new Venue();
    $result = $venueObj->declineVenue($_POST['venue_id']);

    if ($result['status'] === 'success') {
        echo json_encode([
            'success' => true,
            'message' => 'Venue declined successfully'
        ]);
    } else {
        throw new Exception($result['message'] ?? 'Failed to decline venue');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 