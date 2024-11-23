<?php
require_once '../classes/account.class.php';
require_once '../classes/venue.class.php';
require_once '../sanitize.php';

$accountObj = new Account();
$venueObj = new Venue();

$uploadDir = '/discount_id_uploads/';
$allowedType = ['jpg', 'jpeg', 'png'];

$id = $startDate = $endDate = $startTime = $endTime = $duration = $status = $participants = $grandTotal = $guestId = $venueId = $discountType = $paymentMethod = $paymentRef = $paymentStatus = $cancelReason = "";
$id = $startDateErr = $endDateErr = $startTimeErr = $endTimeErr = $durationErr = $statusErr = $participantsErr = $grandTotalErr = $guestIdErr = $venueIdErr = $discountTypeErr = $discountImgErr = $paymentMethodErr = $paymentRefErr = $paymentStatusErr = $cancelReasonErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = clean_input($_POST['startDate']);
    $endDate = clean_input($_POST['endDate']);
    $startTime = clean_input($_POST['startTime']);
    $endTime = clean_input($_POST['endTime']);
    $duration = clean_input($_POST['duration']);
    $status = 1;
    $participants = clean_input($_POST['participants']);
    $grandTotal = clean_input($_POST['grandTotal']);
    $guestId = clean_input($_POST['guestId']);
    $venueId = clean_input($_POST['venueId']);
    $paymentMethod = clean_input($_POST['paymentMethod']);
    $paymentRef = clean_input($_POST['paymentRef']);
    $paymentStatus = 1;
    $cancelReason = isset($_POST['cancelReason']) ? clean_input($_POST['cancelReason']) : null;

    if (isset($_FILES['discount_images']['name'][0]) && !empty($_FILES['discount_images']['name'][0])) {
        foreach ($_FILES['discount_images']['name'] as $key => $image) {
            $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

            if (!in_array($imageFileType, $allowedType)) {
                $discountImgErr[] = "Invalid file format: " . $_FILES['discount_images']['name'][$key];
            } else {
                $targetImage = $uploadDir . uniqid() . '.' . $imageFileType;

                if (move_uploaded_file($_FILES['discount_images']['tmp_name'][$key], $targetImage)) {
                    $uploadedImages[] = $targetImage;
                } else {
                    $discountImgErr[] = "Failed to upload: " . $_FILES['discount_images']['name'][$key];
                }
            }
        }
    }

    if (empty($startDate)) {
        $startDateErr = "Start date is required";
    }
    if (empty($endDate)) {
        $endDateErr = "End date is required";
    }
    if (empty($startTime)) {
        $startTimeErr = "Start time is required";
    }
    if (empty($endTime)) {
        $endTimeErr = "End time is required";
    }
    if (empty($duration)) {
        $durationErr = "Duration is required";
    }
    if (empty($status)) {
        $statusErr = "Status is required";
    }
    if (empty($participants)) {
        $participantsErr = "Participants is required";
    }
    if (empty($grandTotal)) {
        $grandTotalErr = "Grand total is required";
    }
    if (empty($guestId)) {
        $guestIdErr = "Guest ID is required";
    }
    if (empty($venueId)) {
        $venueIdErr = "Venue ID is required";
    }
    if (empty($paymentMethod)) {
        $paymentMethodErr = "Payment method is required";
    }
    if (empty($paymentRef)) {
        $paymentRefErr = "Payment reference is required";
    }
    if (empty($paymentStatus)) {
        $paymentStatusErr = "Payment status is required";
    }

    if (empty($startDateErr) && empty($endDateErr) && empty($startTimeErr) && empty($endTimeErr) && empty($durationErr) && empty($statusErr) && empty($participantsErr) && empty($grandTotalErr) && empty($guestIdErr) && empty($venueIdErr) && empty($paymentMethodErr) && empty($paymentRefErr) && empty($paymentStatusErr)) {
        // Add booking
        $result = $venueObj->bookVenue($startDate, $endDate, $startTime, $endTime, $duration, $status, $participants, $grandTotal, $guestId, $venueId, $paymentMethod, $paymentRef, $paymentStatus, $discountType, $uploadedImages[0] ?? null, $uploadedImages[1] ?? null);

        if ($result['status'] == 'success') {
            echo json_encode(['status' => 'success', 'message' => 'Booking added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add booking']);
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => implode('<br>', array_filter([$startDateErr, $endDateErr, $startTimeErr, $endTimeErr, $durationErr, $statusErr, $participantsErr, $grandTotalErr, $guestIdErr, $venueIdErr, $paymentMethodErr, $paymentRefErr, $paymentStatusErr]))]);
    }
}



