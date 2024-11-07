<?php
require_once '../classes/venue.class.php';
require_once '../sanitize.php';

$venueObj = new Venue();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venue_id = clean_input($_POST['venue_id'] ?? '');

    if (empty($venue_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Venue ID is required']);
        exit;
    }

    $result = $venueObj->declineVenue($venue_id);
    echo json_encode($result);
    exit;
}