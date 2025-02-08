<?php
require_once '../classes/venue.class.php';
$venueObj = new Venue();
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Get JSON data from request body
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['venue_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Venue ID is required']);
    exit;
}

$venueObj = new Venue();
$venue = $venueObj->getVenue($data['venue_id']);

// Check if venue exists and belongs to the current user
if (!$venue || $venue['user_id'] !== $_SESSION['user']['id']) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'You do not have permission to delete this venue']);
    exit;
}

// Delete the venue
$result = $venueObj->deleteVenue($data['venue_id']);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to delete venue']);
}