<?php

require_once '../classes/venue-image.class.php';
require_once '../sanitize.php';

$venueObj = new Venue();

$name = $description = $location = $price = $capacity = $amenities = $image = $imageTemp = "";
$nameErr = $descriptionErr = $locationErr = $priceErr = $capacityErr = $amenitiesErr = $imageErr = "";

$uploadDir = '../venue_image_uploads/';
$allowedType = ['jpg', 'jpeg', 'png'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $name = clean_input($_POST['name']);
    $description = clean_input($_POST['description']);
    $location = clean_input($_POST['location']);
    $price = clean_input($_POST['price']);
    $capacity = clean_input($_POST['capacity']);
    $amenities = clean_input($_POST['amenities']);
    $image = $_FILES['venue_images']['name'];
    $imageTemp = $_FILES['venue_images']['tmp_name'];

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

    // Image validation
    $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    if (empty($image)) {
        $imageErr = 'Product image is required.';
    } else if (!in_array($imageFileType, $allowedType)) {
        $imageErr = 'Accepted files are jpg, jpeg, and png only.';
    }

    // Prepare amenities JSON
    $amenitiesArray = explode(',', $amenities);
    $amenitiesJson = json_encode(array_map('trim', $amenitiesArray));

    // Proceed if no errors
    if (
        empty($nameErr) && empty($descriptionErr) && empty($locationErr) && empty($priceErr) && empty($capacityErr) && empty($amenitiesErr)
        && empty($imageErr)
    ) {
        // Set venue object data
        $venueObj->name = $name;
        $venueObj->description = $description;
        $venueObj->location = $location;
        $venueObj->price = $price;
        $venueObj->capacity = $capacity;
        $venueObj->amenities = $amenitiesJson;

        // Generate a unique target path for the image
        $targetImage = $uploadDir . uniqid() . '.' . $imageFileType;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($imageTemp, $targetImage)) {
            $venueObj->image_url = $targetImage;

            // Add venue with image URL to database
            $result = $venueObj->addVenue();

            if ($result['status'] === 'success') {
                echo json_encode(['status' => 'success', 'message' => 'Venue added successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $result['message']]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image.']);
        }
    } else {
        // Return validation errors as JSON
        echo json_encode([
            'status' => 'error',
            'errors' => [
                'nameErr' => $nameErr,
                'descriptionErr' => $descriptionErr,
                'locationErr' => $locationErr,
                'priceErr' => $priceErr,
                'capacityErr' => $capacityErr,
                'amenitiesErr' => $amenitiesErr,
                'imageErr' => $imageErr,
            ]
        ]);
    }
    exit;
}
