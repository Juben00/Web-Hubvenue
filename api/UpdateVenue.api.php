<?php
require_once '../classes/venue.class.php';
require_once '../sanitize.php';

$venueObj = new Venue();

$venueId = $venueName = $defaultImages = $removedImage = $venueImgs = $newImages = $venueThumbnail = $venueLocation = $venueDescription = $venueCapacity = $venueAmenities = $venueRules = $venueStatus = $venueType = $venuePrice = $venueDownpayment = $venueEntrance = $venueCleaning = "";

$venueIdErr = $venueNameErr = $venueImgsErr = $newImagesErr = $venueThumbnailErr = $venueLocationErr = $venueDescriptionErr = $venueCapacityErr = $venueAmenitiesErr = $venueRulesErr = $venueStatusErr = $venueTypeErr = $venuePriceErr = $venueDownpaymentErr = $venueEntranceErr = $venueCleaningErr = "";

$uploadDir = '/venue_image_uploads/'; // Ensure this is writable
$allowedType = ['jpg', 'jpeg', 'png'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $venueId = clean_input($_POST['venueID']);
    $venueName = clean_input($_POST['editVenueName'] ?? "");
    $defaultImages = json_decode($_POST['defaultImages'], true) ?? [];
    $removedImage = json_decode($_POST['imagesToDelete'], true) ?? [];
    $venueThumbnail = clean_input($_POST['thumbnailIndex'] ?? 0);
    $venueLocation = clean_input($_POST['editVenueAddCoor']);
    $venueDescription = clean_input($_POST['editVenueDescription']);
    $venueCapacity = clean_input($_POST['editVenueCapacity']);
    $venueAmenities = clean_input($_POST['editVenueAmenities'] ?? '');
    $venueRules = clean_input($_POST['editVenueRules'] ?? '');
    $venueStatus = clean_input($_POST['editVenueStatus']);
    $venueType = clean_input($_POST['editVenueType']);
    $venuePrice = clean_input($_POST['editVenuePrice']);
    $venueEntrance = clean_input($_POST['editVenueEntrance']);
    $venueCleaning = clean_input($_POST['editVenueCleaning']);
    $venueAvailability = clean_input($_POST['editVenueStatus'] ?? 1);
    $venueDownpayment = clean_input($_POST['editDownPayment']);

    // Process venue amenities and rules
    $venueAmenities = !empty($venueAmenities) ? array_map('trim', explode(',', $venueAmenities)) : [];
    $venueRules = !empty($venueRules) ? array_map('trim', explode(',', $venueRules)) : [];

    // Filter out removed images from default images
    $venueImgs = array_values(array_filter($defaultImages, function ($image) use ($removedImage) {
        return !in_array($image, $removedImage, true);
    }));

    $allowedStatuses = [1, 2]; // Example for valid statuses
    $allowedTypes = [1, 2, 3, 4]; // Example for valid types

    if (!in_array($venueStatus, $allowedStatuses, true)) {
        $errors[] = "Invalid Venue Status";
    }
    if (!in_array($venueType, $allowedTypes, true)) {
        $errors[] = "Invalid Venue Type";
    }

    if (empty($venueId)) {
        $venueIdErr = "Invalid Venue ID";
    }

    // Handle file uploads
    $imageErr = [];
    $uploadedImages = [];

    if (!empty($_FILES['newImages']['name'][0])) {
        foreach ($_FILES['newImages']['name'] as $key => $image) {
            $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

            if (!in_array($imageFileType, $allowedType)) {
                $imageErr[] = "File " . $_FILES['newImages']['name'][$key] . " has an invalid format. Only jpg, jpeg, and png are allowed.";
            } else {
                $targetImage = $uploadDir . uniqid() . '.' . $imageFileType;

                if (move_uploaded_file($_FILES['newImages']['tmp_name'][$key], '..' . $targetImage)) {
                    $uploadedImages[] = $targetImage;
                } else {
                    $imageErr[] = "Failed to upload image: " . $_FILES['newImages']['name'][$key];
                }
            }
        }
    }

    // Merge default images with uploaded images
    $venueImgs = array_merge($venueImgs, $uploadedImages);
    $venueRules = json_encode($venueRules);
    $venueAmenities = json_encode($venueAmenities);

    // If no errors, proceed with updating the venue
    if (empty($venueStatusErr) && empty($venueTypeErr) && empty($venueIdErr) && empty($imageErr)) {
        $result = $venueObj->updateVenue(
            $venueId,
            $venueName,
            $venueImgs,
            $venueThumbnail,
            $venueLocation,
            $venueDescription,
            $venueCapacity,
            $venueAmenities,
            $venueRules,
            $venueStatus,
            $venueType,
            $venuePrice,
            $venueDownpayment,
            $venueEntrance,
            $venueCleaning,
            $venueAvailability,
            $removedImage
        );

        echo json_encode($result);
        exit();
    } else {
        // Return errors as a JSON response
        echo json_encode([
            'status' => 'error',
            'errors' => implode('<br>', array_merge(
                array_filter([$venueStatusErr, $venueTypeErr, $venueIdErr]),
                $imageErr
            ))
        ]);
    }
}
