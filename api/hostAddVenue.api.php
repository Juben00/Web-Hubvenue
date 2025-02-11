<?php

require_once '../classes/venue.class.php';
require_once '../sanitize.php';
require_once './coorAddressVerify.api.php';
session_start();

$venueObj = new Venue();

$name = $description = $location = $address = $price = $capacity = $amenities = $tag = $entrance = $cleaning = $rules = $addRules = $checkIn = $checkOut = $check_inout = "";
$nameErr = $descriptionErr = $locationErr = $priceErr = $capacityErr = $amenitiesErr = $tagErr = $entranceErr = $cleaningErr = $imageErr = $rulesErr = $checkInErr = $checkOutErr = "";

$uploadDir = '/venue_image_uploads/';
$allowedType = ['jpg', 'jpeg', 'png'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $name = clean_input($_POST['venue-title']);
    $description = clean_input($_POST['venue-description']);
    $location = clean_input($_POST['venue-location']);
    $coor = clean_input($_POST['venueCoordinates']);
    $address = getAddressByCoordinates($coor);
    $price = clean_input($_POST['price']);
    $capacity = clean_input($_POST['venue-max-guest']);
    $amenities = $_POST['amenities'];
    $tag = clean_input(isset($_POST['placeType']) ? $_POST['placeType'] : '');
    $entrance = clean_input($_POST['entrance-fee'] ?? 0);
    $cleaning = clean_input($_POST['cleaning-fee']) ?? 0;
    $thumbnail = clean_input($_POST['imageThumbnail']);
    $rules = isset($_POST['fixedRules']) && is_array($_POST['fixedRules']) ? $_POST['fixedRules'] : [];
    $sanitizedRules = array_map('clean_input', $rules); // Sanitize each checkbox value
    $addRules = isset($_POST['additionalRules']) ? clean_input($_POST['additionalRules']) : '';
    $checkIn = clean_input($_POST['checkin-time']);
    $checkOut = clean_input($_POST['checkout-time']);
    $check_inout = json_encode(['check_in' => $checkIn, 'check_out' => $checkOut]);

    // Validate address
    // $addressData = coorAddressVerify($location, $coor);
    // if (!$addressData) {
    //     $locationErr = 'Invalid address and coordinates. Please try again.';
    // }
    // Validation for required fields
    if (empty($name))
        $nameErr = "Name is required";
    if (empty($description))
        $descriptionErr = "Description is required";
    if (empty($location))
        $locationErr = "Location is required";
    if (empty($price))
        $priceErr = "Price is required";
    if (empty($capacity))
        $capacityErr = "Capacity is required";
    if (empty($amenities))
        $amenitiesErr = "Amenities are required";
    if (empty($tag))
        $tagErr = "Tag is required";
    if (empty($rules))
        $rulesErr = "Rules are required";
    if (empty($checkIn))
        $checkInErr = "Check-in time is required";
    if (empty($checkOut))
        $checkOutErr = "Check-out time is required";
    if ($thumbnail === '' || $thumbnail === null)
        $imageErr = "Thumbnail is required";
    if (empty($address))
        $locationErr = "Invalid address";


    // Prepare amenities JSON
    $amenitiesJson = json_encode($amenities);

    $additionalRulesArray = !empty($addRules) ? array_map('trim', explode(',', $addRules)) : [];

    // Combine both fixedRules and additionalRules into one array
    $mergedRules = array_merge($sanitizedRules, $additionalRulesArray);

    // Convert the combined array into JSON
    $mergedRulesJson = json_encode($mergedRules);

    if ($tag == 'Corporate Space') {
        $tag = 1;
    } else if ($tag == 'Reception Hall') {
        $tag = 2;
    } else if ($tag == 'Intimate Space') {
        $tag = 3;
    } else if ($tag == 'Outdoor Venue') {
        $tag = 4;
    }

    $imageErr = [];
    $uploadedImages = [];

    if (empty($_FILES['venue_images']['name'][0])) {
        $imageErr[] = 'At least one image is required.';
    } else {
        foreach ($_FILES['venue_images']['name'] as $key => $image) {
            $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

            // Validate each image
            if (!in_array($imageFileType, $allowedType)) {
                $imageErr[] = "File " . $_FILES['venue_images']['name'][$key] . " has an invalid format. Only jpg, jpeg, and png are allowed.";
            } else {
                // Generate a unique target path for each image
                $targetImage = $uploadDir . uniqid() . '.' . $imageFileType;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['venue_images']['tmp_name'][$key], '..' . $targetImage)) {
                    $uploadedImages[] = $targetImage;
                } else {
                    $imageErr[] = "Failed to upload image: " . $_FILES['venue_images']['name'][$key];
                }
            }
        }
    }

    // Proceed if no errors
    if (
        empty($nameErr) && empty($descriptionErr) && empty($checkInErr) && empty($checkOutErr) && empty($locationErr) && empty($priceErr) && empty($capacityErr) && empty($amenitiesErr)
        && empty($imageErr)
    ) {
        // Set venue object data
        $venueObj->name = $name;
        $venueObj->description = $description;
        $venueObj->location = $coor;
        $venueObj->price = $price;
        $venueObj->capacity = $capacity;
        $venueObj->amenities = $amenitiesJson;
        $venueObj->rules = $mergedRulesJson;
        $venueObj->tag = $tag;
        $venueObj->host_id = $_SESSION['user'];
        $venueObj->entrance = $entrance;
        $venueObj->cleaning = $cleaning;
        $venueObj->check_inout = $check_inout;
        $venueObj->image_url = json_encode($uploadedImages); // Save multiple image paths as JSON
        $venueObj->imageThumbnail = $thumbnail;
        $venueObj->address = $address;

        // Add venue with image URLs to the database
        $result = $venueObj->addVenue();

        echo json_encode($result);
        exit();
    } else {
        // Return validation errors as JSON
        echo json_encode([
            'status' => 'error',
            'errors' => implode('<br>', array_filter([
                $nameErr,
                $descriptionErr,
                $locationErr,
                $priceErr,
                $capacityErr,
                $amenitiesErr,
                $entranceErr,
                $cleaningErr,
                $imageErr,
                $checkInErr,
                $checkOutErr,
            ]))
        ]);
    }
    exit;
}
