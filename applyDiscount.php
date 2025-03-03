<?php
require_once './classes/venue.class.php';

$discountCode = $_GET['discountCode'];
$venue_id = $_GET['venue_id'];
$venueObj = new Venue();
$discounts = $venueObj->getAllDiscounts($venue_id);

$response = ['valid' => false, 'discountValue' => 0];

foreach ($discounts as $discount) {
    if ($discount['discount_code'] === $discountCode && new DateTime() <= new DateTime($discount['expiration_date'])) {
        $response['valid'] = true;
        $response['discountValue'] = $discount['discount_type'] === 'flat' ? $discount['discount_value'] : $discount['discount_value'] / 100;
        break;
    }
}

echo json_encode($response);
?>