<?php
require_once '../classes/venue.class.php';

if (!isset($_GET['venue_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Venue ID is required']);
    exit;
}

$venueId = $_GET['venue_id'];
$venueObj = new Venue();

$stats = [
    'total_bookings' => 0,
    'average_rating' => 0,
    'total_revenue' => 0,
    'occupancy_rate' => 0,
    'time_based_stats' => []
];

// Get venue statistics
$venueStats = $venueObj->getVenueStatistics($venueId);
if ($venueStats) {
    $stats = array_merge($stats, $venueStats);
}

// Get time-based statistics
$timeBasedStats = $venueObj->getTimeBasedStats($venueId);
if ($timeBasedStats) {
    $stats['time_based_stats'] = $timeBasedStats;
}

header('Content-Type: application/json');
echo json_encode($stats); 