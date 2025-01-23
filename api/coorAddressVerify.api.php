<?php
function coorAddressVerify($address, $coor)
{
    if (empty($address) || empty($coor)) {
        throw new Exception('Missing parameters');
    }

    $coordinates = explode(',', $coor);
    if (count($coordinates) !== 2) {
        throw new Exception('Invalid coordinates format');
    }

    $lat = trim($coordinates[0]);
    $lng = trim($coordinates[1]);

    if (!is_numeric($lat) || !is_numeric($lng)) {
        throw new Exception('Invalid coordinates');
    }

    $url = "https://nominatim.openstreetmap.org/reverse?lat=$lat&lon=$lng&format=json";
    $options = [
        'http' => [
            'header' => "User-Agent: MyApp/1.0 (joevinansoc870@gmail.com)\r\n"
        ]
    ];
    $context = stream_context_create($options);

    $response = @file_get_contents($url, false, $context);
    if ($response === false) {
        throw new Exception('Failed to fetch data from the API');
    }

    $data = json_decode($response, true);
    if (empty($data) || !isset($data['display_name'])) {
        throw new Exception('API returned an empty or invalid response');
    }

    $addressData = $data['display_name'];

    // Normalize country name in the API response
    $normalizedAddressData = str_replace('Pilipinas', 'Philippines', $addressData);

    // Normalize and compare
    if (strtolower(trim($normalizedAddressData)) === strtolower(trim($address))) {
        return true;
    }

    return false; // Explicitly return false when the addresses do not match
}

function getAddressByCoordinates($coor)
{
    if (empty($coor)) {
        throw new Exception('Missing parameters');
    }

    $coordinates = explode(',', $coor);
    if (count($coordinates) !== 2) {
        throw new Exception('Invalid coordinates format');
    }

    $lat = trim($coordinates[0]);
    $lng = trim($coordinates[1]);

    if (!is_numeric($lat) || !is_numeric($lng)) {
        throw new Exception('Invalid coordinates');
    }

    $url = "https://nominatim.openstreetmap.org/reverse?lat=$lat&lon=$lng&format=json";
    $options = [
        'http' => [
            'header' => "User-Agent: MyApp/1.0 (joevinansoc870@gmail.com)\r\n",
        ],
    ];
    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);
    if ($response === false) {
        return $coor;
    }
    $data = json_decode($response, true);
    if (empty($data) || !isset($data['display_name'])) {
        return $coor;
    }
    return $data['display_name'];
}