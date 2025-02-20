<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';
$venueObj = new Venue();
$accountObj = new Account();

// Get rejected bookings using the new method
$Reservations = $venueObj->getAdminBookings('rejected');

function formatDate($date)
{
    return date('F d, Y', strtotime($date));
}
?>

<!-- Search and Filter Section -->
<section class="bg-white rounded-lg shadow-md p-4 mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Search and Filter Reservations</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
            <div class="flex gap-2">
                <input type="date" id="startDate" class="border rounded p-2 w-full" placeholder="Start Date">
                <input type="date" id="endDate" class="border rounded p-2 w-full" placeholder="End Date">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
            <input type="text" id="venueFilter" class="border rounded p-2 w-full" placeholder="Filter by venue name">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
            <input type="text" id="customerFilter" class="border rounded p-2 w-full"
                placeholder="Filter by customer name">
        </div>
    </div>
    <div class="flex items-center gap-2">
        <button id="applyFilters" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 transition-colors">
            Apply Filters
        </button>
        <button id="clearFilters"
            class="border border-gray-300 bg-white text-gray-700 py-2 px-4 rounded hover:bg-gray-100 transition-colors">
            Clear
        </button>
    </div>
</section>

<!-- Reservations Table -->
<section class="bg-white rounded-lg shadow-md p-4 mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Rejected Reservations</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left">Book Date</th>
                    <th class="py-2 px-4 text-left">Start Date</th>
                    <th class="py-2 px-4 text-left">End Date</th>
                    <th class="py-2 px-4 text-left">Number of Days</th>
                    <th class="py-2 px-4 text-left">Name</th>
                    <th class="py-2 px-4 text-left">Contact</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">Venue</th>
                    <th class="py-2 px-4 text-left">Venue Location</th>
                    <th class="py-2 px-4 text-left">Down payment requirement</th>
                    <th class="py-2 px-4 text-left">Venue Price</th>
                    <th class="py-2 px-4 text-left">Capacity</th>
                    <th class="py-2 px-4 text-left">Participants</th>
                    <th class="py-2 px-4 text-left">Mandatory Discount</th>
                    <th class="py-2 px-4 text-left">Coupon Code</th>
                    <th class="py-2 px-4 text-left">Coupon Value</th>
                    <th class="py-2 px-4 text-left">Cleaning Fee</th>
                    <th class="py-2 px-4 text-left">Entrance Fee</th>
                    <th class="py-2 px-4 text-left">Grand Total</th>
                    <th class="py-2 px-4 text-left">Down Payment</th>
                    <th class="py-2 px-4 text-left">Balance</th>
                    <th class="py-2 px-4 text-left">Service Fee</th>
                    <th class="py-2 px-4 text-left">Check In Status</th>
                    <th class="py-2 px-4 text-left">Check In Date</th>
                    <th class="py-2 px-4 text-left">Check Out Status</th>
                    <th class="py-2 px-4 text-left">Checkout Date</th>
                    <th class="py-2 px-4 text-left">Payment Method</th>
                    <th class="py-2 px-4 text-left">Payment Reference</th>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="reservationsTable">
                <?php
                if (!empty($Reservations)) {
                    foreach ($Reservations as $reservation) {
                        // Calculate discount
                        $original_price = $reservation['booking_original_price'];
                        $discount_value = $reservation['discount_value'];
                        $discounted_amount = ($original_price * $discount_value) / 100;
                        $payref = $reservation['booking_payment_reference'];
                        $paymentTemp = null;
                        if (str_ends_with($payref, ".png") || str_ends_with($payref, ".jpeg") || str_ends_with($payref, ".jpg")) {
                            $paymentTemp = "<img src='..$payref' alt='Payment Reference Image' style='max-width: 100%; height: auto;'>";
                        } else {
                            $paymentTemp = $payref;
                        }
                        $isMandatory_Discount = $reservation['booking_discount_id'] == 0 ? "None" : "20%";
                        $dp_option = $reservation['booking_dp_id'];
                        switch ($dp_option) {
                            case 0:
                                $dp_option = "30% Downpayment";
                                break;
                            case 1:
                                $dp_option = "50% Downpayment";
                                break;
                            case 3:
                                $dp_option = "100% Downpayment";
                                break;
                        }
                        $checkin_status = $reservation['booking_checkin_status'];
                        $checkout_status = $reservation['booking_checkout_status'];
                        $checkin_date = $reservation['booking_checkin_date'] ? formatDate($reservation['booking_checkin_date']) : 'N/A';
                        $checkout_date = $reservation['booking_checkout_date'] ? formatDate($reservation['booking_checkout_date']) : 'N/A';

                        switch ($checkin_status) {
                            case 'Checked-In':
                                $checkin_status = 'Checked In';
                                break;
                            case 'No-Show':
                                $checkin_status = 'Guest did not show up';
                                break;
                            default:
                                $checkin_status = 'Not yet checked in';
                                break;
                        }

                        switch ($checkout_status) {
                            case 'Checked-Out':
                                $checkout_status = 'Checked Out';
                                break;
                            default:
                                $checkout_status = 'Not yet checked out';
                                break;
                        }

                        $status = $reservation['booking_status_id'];
                        switch ($status) {
                            case 1:
                                $status = "<span class='bg-yellow-200 text-yellow-800 rounded-full px-2'>Pending</span>";
                                break;
                            case 2:
                                $status = "<span class='bg-green-200 text-green-800 rounded-full px-2'>Confirmed</span>";
                                break;
                            case 3:
                                $status = "<span class='bg-red-200 text-red-800 rounded-full px-2'>Cancelled</span>";
                                break;
                            case 4:
                                $status = "<span class='bg-blue-200 text-blue-800 rounded-full px-2'>Completed</span>";
                                break;
                        }
                        ?>
                        <tr>
                            <td class="py-2 px-4"><?php echo formatDate($reservation['booking_created_at']); ?></td>
                            <td class="py-2 px-4"><?php echo formatDate($reservation['booking_start_date']); ?></td>
                            <td class="py-2 px-4"><?php echo formatDate($reservation['booking_end_date']); ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['booking_duration']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['guest_name']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['guest_contact_number']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['guest_email']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['venue_name']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['venue_location']; ?></td>
                            <td class="py-2 px-4"><?php echo $dp_option ?></td>
                            <td class="py-2 px-4">₱<?php echo number_format($reservation['booking_venue_price'], 2); ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['venue_capacity']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['booking_participants']; ?></td>
                            <td class="py-2 px-4"><?php echo $isMandatory_Discount ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['discount_code']; ?></td>
                            <td class="py-2 px-4">₱<?php echo number_format($discounted_amount, 2); ?></td>
                            <td class="py-2 px-4">₱<?php echo number_format($reservation['booking_cleaning'], 2); ?></td>
                            <td class="py-2 px-4">₱<?php echo number_format($reservation['booking_entrance'], 2); ?></td>
                            <td class="py-2 px-4">₱<?php echo number_format($reservation['booking_grand_total'], 2); ?></td>
                            <td class="py-2 px-4">₱<?php echo number_format($reservation['booking_dp_amount'], 2); ?></td>
                            <td class="py-2 px-4">₱<?php echo number_format($reservation['booking_balance'], 2); ?></td>
                            <td class="py-2 px-4">₱<?php echo number_format($reservation['booking_service_fee'], 2); ?></td>
                            <td class="py-2 px-4"><?php echo $checkin_status; ?></td>
                            <td class="py-2 px-4"><?php echo $checkin_date ?></td>
                            <td class="py-2 px-4"><?php echo $checkout_status; ?></td>
                            <td class="py-2 px-4"><?php echo $checkout_date ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['payment_method_name']; ?></td>
                            <td class="py-2 px-4"><?php echo $paymentTemp ?></td>
                            <td class="py-2 px-4">
                                <?php echo $status ?>
                            </td>
                            <td class="py-2 px-4">
                                <form class="cancelReservationButton inline-block" method="POST">
                                    <input type="hidden" name="booking_id" value="<?php echo $reservation['booking_id']; ?>">
                                    <button type="submit" class="text-red-500 font-bold py-1 px-3 rounded">
                                        Cancel
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="19" class="py-4 text-center">No rejected reservations found</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Keep the same script as cancelled-reservations.php -->
<script>
    // Same script as cancelled-reservations.php
    $(document).ready(function () {
        // ... (same filter functionality)
    });
</script>