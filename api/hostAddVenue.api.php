<?php

require_once '../classes/venue.class.php';
require_once '../sanitize.php';
require_once './coorAddressVerify.api.php';
session_start();

$venueObj = new Venue();

$name = $description = $location = $address = $amenities = $rules = $addRules = $pricing_type = $price = $min_attendees = $max_attendees = $min_time = $max_time = $cleaning = $entrance = $tag = $thumbnail = "";

$nameErr = $descriptionErr = $locationErr = $addressErr = $amenitiesErr = $rulesErr = $pricing_typeErr = $priceErr = $attendeesErr = $timeErr = $tagErr = $thumbnailErr = "";

$uploadDir = '/venue_image_uploads/';
$allowedType = ['jpg', 'jpeg', 'png'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $name = clean_input($_POST['venue-title']);
    $description = clean_input($_POST['venue-description']);
    $location = clean_input($_POST['venue-location']);
    $coor = clean_input($_POST['venueCoordinates']);
    $address = getAddressByCoordinates($coor);
    $amenities = array_map('clean_input', $_POST['amenities']);
    $rules = isset($_POST['fixedRules']) && is_array($_POST['fixedRules']) ? $_POST['fixedRules'] : [];
    $addRules = isset($_POST['additionalRules']) ? clean_input($_POST['additionalRules']) : '';
    $pricing_type = clean_input($_POST['pricing-type']);
    $price = clean_input($_POST['price']);
    $min_attendees = clean_input($_POST['min-attendees']);
    $max_attendees = clean_input($_POST['max-attendees']);
    $min_time = clean_input($_POST['min-time']);
    $max_time = clean_input($_POST['max-time']);
    $opening_time = clean_input($_POST['open-time']) ?? null;
    $closing_time = clean_input($_POST['close-time']) ?? null;
    $cleaning = clean_input($_POST['cleaning-fee']) ?? 0;
    $entrance = clean_input($_POST['entrance-fee'] ?? 0);
    $tag = clean_input(isset($_POST['placeType']) ? $_POST['placeType'] : '');
    $thumbnail = clean_input($_POST['imageThumbnail']);
    $sanitizedRules = array_map('clean_input', $rules); // Sanitize each checkbox value

    // Validation for required fields
    if (empty($name))
        $nameErr = "Name is required";
    if (empty($description))
        $descriptionErr = "Description is required";
    if (empty($location))
        $locationErr = "Location is required";
    if (empty($address))
        $locationErr = "Invalid address";
    if (empty($pricing_type))
        $pricing_typeErr = "Pricing type is required";
    if (empty($price))
        $priceErr = "Price is required";
    if (empty($min_attendees) || empty($max_attendees)) {
        $attendeesErr = "Mininum and Maximun number of attendees is required";
    }
    if (empty($min_time) || empty($max_time)) {
        $timeErr = "Minimum and Maximum time is required";
    }
    if (empty($amenities))
        $amenitiesErr = "Amenities are required";
    if (empty($tag))
        $tagErr = "Tag is required";
    if (empty($sanitizedRules))
        $rulesErr = "Rules are required";
    if ($thumbnail === '' || $thumbnail === null)
        $imageErr = "Thumbnail is required";

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
        empty($nameErr) && empty($descriptionErr) && empty($locationErr) && empty($addressErr) && empty($pricing_typeErr) && empty($priceErr) && empty($attendeesErr) && empty($timeErr) && empty($amenitiesErr) && empty($rulesErr) && empty($tagErr) && empty($thumbnailErr) && empty($imageErr)
    ) {
        // Set venue object data
        $venueObj->name = $name;
        $venueObj->description = $description;
        $venueObj->address = $address;
        $venueObj->location = $coor;
        $venueObj->amenities = $amenitiesJson;
        $venueObj->rules = $mergedRulesJson;
        $venueObj->pricing_type = $pricing_type;
        $venueObj->price = $price;
        $venueObj->min_attendees = $min_attendees;
        $venueObj->max_attendees = $max_attendees;
        $venueObj->min_time = $min_time;
        $venueObj->max_time = $max_time;
        $venueObj->opening_time = $opening_time;
        $venueObj->closing_time = $closing_time;
        $venueObj->entrance = $entrance;
        $venueObj->cleaning = $cleaning;
        $venueObj->tag = $tag;
        $venueObj->imageThumbnail = $thumbnail;
        $venueObj->host_id = $_SESSION['user'];
        $venueObj->image_url = json_encode($uploadedImages);

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
