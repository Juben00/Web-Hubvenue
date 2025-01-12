<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (isset($_GET['lat']) && isset($_GET['lon'])) {
    $lat = $_GET['lat'];
    $lon = $_GET['lon'];
    $url = "https://nominatim.openstreetmap.org/reverse?lat=$lat&lon=$lon&format=json";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Add User-Agent header
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "User-Agent: YourAppName/1.0 (contact@yourdomain.com)"
    ));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Handle response or error codes
    if ($httpCode != 200) {
        echo json_encode(["error" => "Failed to fetch data from OpenStreetMap"]);
    } else {
        header("Content-Type: application/json");
        echo $response;
    }
} else {
    echo json_encode(["error" => "Latitude and Longitude are required"]);
}