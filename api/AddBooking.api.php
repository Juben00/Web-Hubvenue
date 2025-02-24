<?php
require_once '../classes/account.class.php';
require_once '../classes/venue.class.php';
require_once '../sanitize.php';

session_start();

$reservationData = $_SESSION['reservationFormData'];

$accountObj = new Account();
$venueObj = new Venue();

$booking_start_date = $booking_end_date = $booking_duration = $booking_status_id = $booking_participants = $booking_original_price = $booking_grand_total = $booking_guest_id = $booking_venue_id = $booking_discount = $payment_method_name = $booking_payment_reference = $booking_payment_status_id = $booking_cancellation_reason = $booking_service_fee = "";

$booking_start_dateErr = $booking_end_dateErr = $booking_durationErr = $booking_status_idErr = $booking_participantsErr = $booking_original_priceErr = $booking_grand_totalErr = $booking_guest_idErr = $booking_venue_idErr = $booking_discountErr = $payment_method_nameErr = $booking_payment_referenceErr = $booking_payment_status_idErr = $booking_cancellation_reasonErr = $booking_service_feeErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $booking_start_date = clean_input($reservationData['checkin']);
    $booking_end_date = clean_input($reservationData['checkout']);

    // conver to 24 hours
    $booking_start_date = date("Y-m-d H:i:s", strtotime($booking_start_date));
    $booking_end_date = date("Y-m-d H:i:s", strtotime($booking_end_date));

    $booking_status_id = 1;
    $booking_participants = clean_input($reservationData['numberOfGuest']);
    $booking_request = clean_input($reservationData['specialRequest']);
    $booking_grand_total = clean_input($reservationData['grandTotal']);
    $booking_balance = clean_input($reservationData['Balance']);
    $booking_guest_id = clean_input($_SESSION['user']);
    $booking_venue_id = clean_input($reservationData['venueId']);
    $payment_method_name = clean_input($_POST['paymentMethod']);
    $booking_payment_reference = clean_input($_POST['finalRef']);
    $booking_payment_receipt = clean_input($_FILES["receiptUpload"]["name"]);
    $booking_payment_status_id = 1;
    $booking_service_fee = clean_input($reservationData['serviceFee']);
    $booking_price = clean_input($reservationData['price']);
    $booking_cleaning = clean_input($reservationData['cleaningFee']);
    $booking_entrance = clean_input($reservationData['entranceFee']);
    $booking_dp_amount = clean_input($_POST['Total']);
    $booking_balance = clean_input($_POST['Balance']);
    $booking_dp_id = clean_input($reservationData['Downpayment']);
    $booking_coupon_code = clean_input($venueObj->getIdOfCoupon(isset($_POST['couponCode']) && !empty($_POST['couponCode']) ? $_POST['couponCode'] : 'none'));

    // Debug logging
    error_log("Reservation Data: " . print_r($reservationData, true));
    error_log("Raw booking_discount_id: " . print_r($reservationData['booking_discount_id'] ?? 'null', true));

    // Properly handle the discount ID - set to NULL if not present
    $booking_discount_id = isset($reservationData['booking_discount_id']) && !empty($reservationData['booking_discount_id'])
        ? clean_input($reservationData['booking_discount_id'])
        : null;
    error_log("Cleaned booking_discount_id: " . print_r($booking_discount_id, true));

    // Get payment method ID
    $bpm = clean_input($_POST['paymentMethod']);
    error_log("Payment Method ID: " . print_r($bpm, true));

    if (empty($booking_start_date)) {
        $booking_start_dateErr = "Start date is required";
    }
    if (empty($booking_end_date)) {
        $booking_end_dateErr = "End date is required";
    }
    if (empty($booking_participants)) {
        $booking_participantsErr = "Number of participants is required";
    }
    // if (empty($booking_duration)) {
    //     $booking_durationErr = "Duration is required";
    // }
    if (empty($booking_status_id)) {
        $booking_status_idErr = "Status is required";
    }
    if (empty($booking_participants)) {
        $booking_participantsErr = "Number of participants is required";
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
    if (empty($payment_method_name)) {
        $payment_method_nameErr = "Payment method is required";
    } else if ($payment_method_name === "gcash") {
        $bpm = "1";
    } else if ($payment_method_name === "paymaya") {
        $bpm = "2";
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
        empty($booking_durationErr) && empty($booking_grand_totalErr) &&
        empty($booking_guest_idErr) && empty($booking_venue_idErr) && empty($payment_method_nameErr) &&
        empty($booking_payment_referenceErr)
    ) {
        $booking_payment_reference = $booking_payment_reference === "" ? $booking_payment_receipt : $booking_payment_reference;

        $result = $venueObj->bookVenue(
            $booking_start_date,
            $booking_end_date,
            $booking_participants,
            $booking_price,
            $booking_entrance,
            $booking_cleaning,
            $booking_service_fee,
            $booking_duration,
            $booking_grand_total,
            $booking_dp_amount,
            $booking_balance,
            $booking_dp_id,
            $booking_coupon_code,
            $booking_discount_id,
            $booking_status_id,
            $booking_guest_id,
            $booking_venue_id,
            $bpm,
            $booking_payment_reference,
            $booking_payment_status_id,
            $booking_request
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
                $booking_grand_totalErr,
                $booking_guest_idErr,
                $booking_venue_idErr,
                $payment_method_nameErr,
                $booking_payment_referenceErr
            ]))
        ]);
    }
}


