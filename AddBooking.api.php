<?php

$booking_dp_id = clean_input($reservationData['Downpayment']);
$booking_coupon_code = clean_input($venueObj->getIdOfCoupon(isset($_POST['couponCode']) && !empty($_POST['couponCode']) ? $_POST['couponCode'] : 'none'));
$booking_discount_id = clean_input($reservationData['booking_discount_id'] ?? null);

if (empty($booking_start_date)) {
    // Handle the case where $booking_start_date is empty
} 