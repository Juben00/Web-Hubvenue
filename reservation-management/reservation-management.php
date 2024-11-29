<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';
$venueObj = new Venue();
$accountObj = new Account();

$Reservations = $venueObj->getBookings();

function formatDate($date)
{
    return date('F d, Y', strtotime($date));
}

?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Reservation Management</h1>

    <!-- Search and Filter Section -->
    <section class="bg-white rounded-lg shadow-md p-4 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Search and Filter Reservations</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="date" id="dateFilter" class="border rounded p-2" placeholder="Filter by date">
            <input type="text" id="venueFilter" class="border rounded p-2" placeholder="Filter by venue">
            <input type="text" id="customerFilter" class="border rounded p-2" placeholder="Filter by customer">
        </div>
        <button id="applyFilters"
            class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors">Apply
            Filters</button>
    </section>

    <!-- Reservations Table -->
    <section class="bg-white rounded-lg shadow-md p-4 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Reservations</h2>
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
                        <th class="py-2 px-4 text-left">Capacity</th>
                        <th class="py-2 px-4 text-left">Participants</th>
                        <th class="py-2 px-4 text-left">Original Price</th>
                        <th class="py-2 px-4 text-left">Discount Code</th>
                        <th class="py-2 px-4 text-left">Discount Value</th>
                        <th class="py-2 px-4 text-left">Grand Total</th>
                        <th class="py-2 px-4 text-left">Payment Method</th>
                        <th class="py-2 px-4 text-left">Payment Reference</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="reservationsTable">
                    <?php
                    foreach ($Reservations as $reservation) {
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
                            <td class="py-2 px-4"><?php echo $reservation['venue_capacity']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['booking_participants']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['booking_original_price']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['booking_discount']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['discount_value']; ?></td>
                            <td class="py-2 px-4"><?php echo $reservation['booking_grand_total']; ?></td>
                            <td class="py-2 px-4">
                                <?php echo $reservation['booking_payment_method']; ?></t d>
                            <td class="py-2 px-4"><?php echo $reservation['booking_payment_reference']; ?></td>
                            <td class="py-2 px-4">
                                <?php
                                if ($reservation['booking_status_id'] == 1) {
                                    echo '<span class="bg-yellow-200 text-yellow-800 rounded-full px-2">Pending</span>';
                                } elseif ($reservation['booking_status_id'] == 2) {
                                    echo '<span class="bg-green-200 text-green-800 rounded-full px-2">Approved</span>';
                                } elseif ($reservation['booking_status_id'] == 3) {
                                    echo '<span class="bg-red-200 text-red-800 rounded-full px-2">Cancelled</span>';
                                } elseif ($reservation['booking_status_id'] == 4) {
                                    echo '<span class="bg-blue-200 text-blue-800 rounded-full px-2">Completed</span>';
                                }
                                ?>
                            </td>
                            <td clas s="py-2 px-4">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                    Approve
                                </button>
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                    Reject
                                </button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>


    <!-- Notifications Section -->
    <section class="bg-white rounded-lg shadow-md p-4 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Custom Notifications</h2>
        <div id="notificationsContainer">
            <!-- Notifications will be populated by JavaScript -->
        </div>
    </section>
</div>