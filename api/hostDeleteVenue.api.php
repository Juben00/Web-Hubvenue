<?php
require_once '../classes/venue.class.php';
session_start();

header("Content-Type: application/json");

// Check if the user is authenticated
if (!isset($_SESSION['user'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit;
}

$USER_ID = $_SESSION['user'];
$venueObj = new Venue();

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['venueId']) || !is_numeric($data['venueId'])) {
    echo json_encode(["status" => "error", "message" => "Invalid venue ID."]);
    exit;
}

$venue_id = intval($data['venueId']);

// Attempt to delete the venue
$result = $venueObj->deleteVenue($venue_id, $USER_ID);
echo json_encode($result);
