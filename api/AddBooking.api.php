<?php
require_once '../classes/account.class.php';
require_once '../classes/venue.class.php';
require_once '../sanitize.php';

$accountObj = new Account();
$venueObj = new Venue();

$uploadDir = '/discount_id_uploads/';
$allowedType = ['jpg', 'jpeg', 'png'];

$booking_start_date = $booking_end_date = $booking_duration = $booking_status_id = $booking_participants = $booking_original_price = $booking_grand_total = $booking_guest_id = $booking_venue_id = $booking_discount = $booking_payment_method = $booking_payment_reference = $booking_payment_status_id = $booking_cancellation_reason = $booking_service_fee = "";

$booking_start_dateErr = $booking_end_dateErr = $booking_durationErr = $booking_status_idErr = $booking_participantsErr = $booking_original_priceErr = $booking_grand_totalErr = $booking_guest_idErr = $booking_venue_idErr = $booking_discountErr = $booking_payment_methodErr = $booking_payment_referenceErr = $booking_payment_status_idErr = $booking_cancellation_reasonErr = $booking_service_feeErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_start_date = clean_input($_POST['startDate']);
    $booking_end_date = clean_input($_POST['endDate']);
    // Convert dates to DateTime objects
    $startDate = new DateTime($booking_start_date);
    $endDate = new DateTime($booking_end_date);
    // Calculate the difference
    $interval = $startDate->diff($endDate);
    // Get the difference in days
    $booking_duration = $interval->days;
    $booking_status_id = 1;
    $booking_participants = clean_input($_POST['participants']);
    $booking_original_price = clean_input($_POST['originalPrice']);
    $booking_grand_total = clean_input($_POST['grandTotal']);
    $booking_guest_id = clean_input($_POST['guestId']);
    $booking_venue_id = clean_input($_POST['venueId']);
    $booking_discount = clean_input(isset($_POST['couponCode']) ? $_POST['couponCode'] : '');
    $booking_payment_method = clean_input($_POST['paymentMethod']);
    $booking_payment_reference = clean_input($_POST['finalRef']);
    $booking_payment_status_id = 1;
    $booking_cancellation_reason = clean_input(isset($_POST['cancellationReason']) ? $_POST['cancellationReason'] : '');
    $booking_service_fee = clean_input($_POST['serviceFee']);

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
    if (empty($booking_payment_reference)) {
        $booking_payment_referenceErr = "Payment reference is required";
    }

    if (
        empty($booking_start_dateErr) && empty($booking_end_dateErr) && empty($booking_participantsErr) &&
        empty($booking_durationErr) && empty($booking_original_priceErr) && empty($booking_grand_totalErr) &&
        empty($booking_guest_idErr) && empty($booking_venue_idErr) && empty($booking_payment_methodErr) &&
        empty($booking_payment_referenceErr)
    ) {

        $result = $venueObj->bookVenue($booking_start_date, $booking_end_date, $booking_duration, $booking_status_id, $booking_participants, $booking_original_price, $booking_grand_total, $booking_guest_id, $booking_venue_id, $booking_discount, $bpm, $booking_payment_reference, $booking_payment_status_id, $booking_cancellation_reason, $booking_service_fee);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Booking Successful']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result['message']]);
        }

    } else {
        echo json_encode([
            'status' => 'error',
            'errors' => implode('<br>', array_filter([
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



