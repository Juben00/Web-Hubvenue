<?php
require_once './classes/venue.class.php';

header('Content-Type: application/json');

$venueObj = new Venue();

// Get the current venue ID from the query parameters
$current_venue_id = isset($_GET['current_venue_id']) ? $_GET['current_venue_id'] : 0;

// Get all venues except the current one, limit to 3 similar venues
$venues = $venueObj->getAllVenues('2');

// Filter out the current venue and limit to 3 venues
$comparison_venues = array_filter($venues, function($venue) use ($current_venue_id) {
    return $venue['id'] != $current_venue_id;
});

// Take only the first 3 venues
$comparison_venues = array_slice($comparison_venues, 0, 3);

// Return the venues as JSON
echo json_encode(array_values($comparison_venues));
?> 