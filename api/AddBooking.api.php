<?php
require_once '../classes/account.class.php';
require_once '../classes/venue.class.php';
require_once '../sanitize.php';

session_start();

$reservationData = $_SESSION['reservationFormData'];

$accountObj = new Account();
$venueObj = new Venue();

$booking_start_date = $booking_end_date = $booking_duration = $booking_status_id = $booking_participants = $booking_original_price = $booking_grand_total = $booking_guest_id = $booking_venue_id = $booking_discount = $booking_payment_method = $booking_payment_reference = $booking_payment_status_id = $booking_cancellation_reason = $booking_service_fee = "";

$booking_start_dateErr = $booking_end_dateErr = $booking_durationErr = $booking_status_idErr = $booking_participantsErr = $booking_original_priceErr = $booking_grand_totalErr = $booking_guest_idErr = $booking_venue_idErr = $booking_discountErr = $booking_payment_methodErr = $booking_payment_referenceErr = $booking_payment_status_idErr = $booking_cancellation_reasonErr = $booking_service_feeErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $booking_start_date = clean_input($reservationData['checkin']);
    $booking_end_date = clean_input($reservationData['checkout']);
    // Convert dates to DateTime objects
    $startDate = new DateTime($booking_start_date);
    $endDate = new DateTime($booking_end_date);
    // Calculate the difference
    $interval = $startDate->diff($endDate);
    // Get the difference in days
    $booking_duration = $interval->days;
    $booking_status_id = 1;
    $booking_participants = clean_input($reservationData['numberOfGuest']);
    $booking_request = clean_input($reservationData['specialRequest']);
    $booking_original_price = clean_input($reservationData['RawPrice']);
    $booking_grand_total = clean_input($reservationData['Total']);
    $booking_balance = clean_input($reservationData['Balance']);
    $booking_guest_id = clean_input($_SESSION['user']);
    $booking_venue_id = clean_input($reservationData['venueId']);
    $booking_down_payment = clean_input($reservationData['Downpayment']);
    $booking_discount = clean_input(isset($_POST['couponCode']) && !empty($_POST['couponCode']) ? $_POST['couponCode'] : 'none');
    $booking_payment_method = clean_input($_POST['paymentMethod']);
    $booking_payment_reference = clean_input($_POST['finalRef']);
    $booking_payment_receipt = clean_input($_FILES["receiptUpload"]["name"]);
    $booking_payment_status_id = 1;
    $booking_service_fee = clean_input($reservationData['serviceFee']);


    if (empty($booking_start_date)) {
        $booking_start_dateErr = "Start date is required";
    }
    if (empty($booking_end_date)) {
        $booking_end_dateErr = "End date is required";
    }
    if (empty($booking_participants)) {
        $booking_participantsErr = "Number of participants is required";
    }
    if (empty($booking_duration)) {
        $booking_durationErr = "Duration is required";
    }
    if (empty($booking_status_id)) {
        $booking_status_idErr = "Status is required";
    }
    if (empty($booking_participants)) {
        $booking_participantsErr = "Number of participants is required";
    }
    if (empty($booking_original_price)) {
        $booking_original_priceErr = "Original price is required";
    }
    if (empty($booking_grand_total)) {
        $booking_grand_totalErr = "Grand total is required";
    }
    if (empty($booking_guest_id)) {
        $booking_guest_idErr = "Guest ID is required";
    }
    if (empty($booking_venue_id)) {
        $booking_venue_idErr = "Venue ID is required";
    }
    if (empty($booking_payment_method)) {
        $booking_payment_methodErr = "Payment method is required";
    } else if ($booking_payment_method === "gcash") {
        $bpm = "G-cash";
    } else if ($booking_payment_method === "paymaya") {
        $bpm = "PayMaya";
    }

    if ($booking_payment_receipt !== "") {
        $target_dir = "/paymentReceipts/";
        $target_file = $target_dir . basename($_FILES["receiptUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["receiptUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["receiptUpload"]["size"] > 500000) {
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $booking_payment_receipt = "";
        } else {
            if (move_uploaded_file($_FILES["receiptUpload"]["tmp_name"], ".." . $target_file)) {
                $booking_payment_receipt = $target_file;
            } else {
                $booking_payment_receipt = "";
            }
        }
    }

    if (empty($booking_payment_receipt) && empty($booking_payment_reference)) {
        $booking_payment_referenceErr = "Payment reference is required";
    }


    if (
        empty($booking_start_dateErr) && empty($booking_end_dateErr) && empty($booking_participantsErr) &&
        empty($booking_durationErr) && empty($booking_original_priceErr) && empty($booking_grand_totalErr) &&
        empty($booking_guest_idErr) && empty($booking_venue_idErr) && empty($booking_payment_methodErr) &&
        empty($booking_payment_referenceErr)
    ) {
        $booking_payment_reference = $booking_payment_reference === "" ? $booking_payment_receipt : $booking_payment_reference;

        $result = $venueObj->bookVenue(
            $booking_start_date,
            $booking_end_date,
            $booking_duration,
            $booking_status_id,
            $booking_request,
            $booking_participants,
            $booking_original_price,
            $booking_grand_total,
            $booking_balance,
            $booking_guest_id,
            $booking_venue_id,
            $booking_down_payment,
            $booking_discount,
            $bpm,
            $booking_payment_reference,
            $booking_payment_status_id,
            $booking_service_fee
        );

        echo json_encode($result);
        unset($_SESSION['reservationFormData']);
        exit();

    } else {
        echo json_encode([
            'status' => 'error',
            'message' => implode('<br>', array_filter([
                $booking_start_dateErr,
                $booking_end_dateErr,
                $booking_participantsErr,
                $booking_durationErr,
                $booking_original_priceErr,
                $booking_grand_totalErr,
                $booking_guest_idErr,
                $booking_venue_idErr,
                $booking_payment_methodErr,
                $booking_payment_referenceErr
            ]))
        ]);
    }
}


