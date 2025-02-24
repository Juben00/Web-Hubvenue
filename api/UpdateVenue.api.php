<?php
require_once '../classes/venue.class.php';
require_once '../sanitize.php';
require_once './coorAddressVerify.api.php';

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
    $venueAddress = getAddressByCoordinates($venueLocation);
    $venueDescription = clean_input($_POST['editVenueDescription']);
    $venueAmenities = clean_input($_POST['editVenueAmenities'] ?? '');
    $venueRules = clean_input($_POST['editVenueRules'] ?? '');
    $venueType = clean_input($_POST['editVenueType']);
    $venuePricingType = clean_input($_POST['editVenuePricingType']);
    $venuePrice = clean_input($_POST['editVenuePrice']);
    $venueMinTime = clean_input($_POST['editMinTime']);
    $venueMaxTime = clean_input($_POST['editMaxTime']);
    $venueMinHead = clean_input($_POST['editMinHead']);
    $venueMaxHead = clean_input($_POST['editMaxHead']);
    $venueOpeningTime = clean_input($_POST['editOpeningTime'] ?? null);
    $venueOpeningTime = ($venueOpeningTime === '00:00:00' || empty($venueOpeningTime)) ? null : $venueOpeningTime;
    $venueClosingTime = clean_input($_POST['editClosingTime'] ?? null);
    $venueClosingTime = ($venueClosingTime === '00:00:00' || empty($venueClosingTime)) ? null : $venueClosingTime;
    $venueEntrance = clean_input($_POST['editVenueEntrance']);
    $venueCleaning = clean_input($_POST['editVenueCleaning']);
    $venueAvailability = clean_input($_POST['editVenueStatus'] ?? 1);
    $venueDownpayment = clean_input($_POST['editDownPayment']);
    $discountValue = clean_input($_POST['discountValue']) ?? null;
    $discountType = clean_input($_POST['discountType']) ?? null;
    $discountCode = clean_input($_POST['discountCode']) ?? null;
    $discountDate = clean_input($_POST['discountDate']) ?? null;
    $discountQty = clean_input($_POST['discountQuantity']) ?? null;
    $discountToDelete = json_decode($_POST['discountsToDelete'], true) ?? [];


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

    if ($discountValue < 0) {
        $errors[] = "Discount value cannot be negative";
    }

    if ($discountType > 85) {
        $errors[] = "Discount value cannot be granted more than 85%";
    }

    if (!is_numeric($discountValue)) {
        $errors[] = "Discount value must be a number";
    }

    if ($discountType !== 'percentage' && $discountType !== 'flat') {
        $errors[] = "Invalid discount type";
    }

    if ($discountDate < date('Y-m-d')) {
        $errors[] = "Discount date cannot be in the past";
    }


    if (empty($venueId)) {
        $venueIdErr = "Invalid Venue ID";
    }

    if (empty($venueName)) {
        $venueNameErr = "Venue name is required";
    }

    if (empty($venueThumbnail)) {
        $venueThumbnailErr = "Thumbnail is required";
    }

    if (empty($venueLocation)) {
        $venueLocationErr = "Venue location is required";
    }

    if (empty($venueDescription)) {
        $venueDescriptionErr = "Venue description is required";
    }

    if (empty($venueAmenities)) {
        $venueAmenitiesErr = "Venue amenities are required";
    }

    if (empty($venueRules)) {
        $venueRulesErr = "Venue rules are required";
    }

    if (empty($venueType)) {
        $venueTypeErr = "Venue type is required";
    }

    if (empty($venuePrice)) {
        $venuePriceErr = "Venue price is required";
    }

    if (empty($venueDownpayment)) {
        $venueDownpaymentErr = "Venue downpayment is required";
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
    if (empty($venueStatusErr) && empty($venueTypeErr) && empty($venueIdErr) && empty($imageErr) && empty($venueNameErr) && empty($venueThumbnailErr) && empty($venueLocationErr) && empty($venueDescriptionErr) && empty($venueCapacityErr) && empty($venueAmenitiesErr) && empty($venueRulesErr) && empty($venuePriceErr) && empty($venueDownpaymentErr)) {
        $result = $venueObj->updateVenue(
            $venueId,
            $venueName,
            $venueDescription,
            $venueAddress,
            $venueLocation,
            $venueAmenities,
            $venueRules,
            $venuePricingType,
            $venuePrice,
            $venueMinHead,
            $venueMaxHead,
            $venueMinTime,
            $venueMaxTime,
            $venueOpeningTime,
            $venueClosingTime,
            $venueEntrance,
            $venueCleaning,
            $venueDownpayment,
            $venueType,
            $venueThumbnail,
            $venueAvailability,
            $venueImgs,
            $discountValue,
            $discountType,
            $discountCode,
            $discountDate,
            $discountQty,
            $discountToDelete
        );

        echo json_encode($result);
        exit();
    } else {
        // Return errors as a JSON response
        echo json_encode([
            'status' => 'error',
            'errors' => implode('<br>', array_merge(
                array_filter([$venueStatusErr, $venueTypeErr, $venueIdErr, $venueNameErr, $venueThumbnailErr, $venueLocationErr, $venueDescriptionErr, $venueCapacityErr, $venueAmenitiesErr, $venueRulesErr, $venuePriceErr, $venueDownpaymentErr, $venueEntranceErr, $venueCleaningErr, $imageErr])
            ))
        ]);
    }
}
