<?php
require_once '../classes/venue.class.php';

// Check if user is logged in
session_start();

$venueObj = new Venue();
$fullname = $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'];

// Fetch booking counts by status
$hostId = $_SESSION['user']['id'];
$pendingBookings = $venueObj->getBookingsByHost($hostId, 1); // Pending
$confirmedBookings = $venueObj->getBookingsByHost($hostId, 2); // Confirmed
$cancelledBookings = $venueObj->getBookingsByHost($hostId, 3); // Cancelled
$completedBookings = $venueObj->getBookingsByHost($hostId, 4); // Completed

$pendingCount = count($pendingBookings);
$confirmedCount = count($confirmedBookings);
$cancelledCount = count($cancelledBookings);
$completedCount = count($completedBookings);
$totalCount = $pendingCount + $confirmedCount + $cancelledCount + $completedCount;
?>

<main class="max-w-7xl pt-20 mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Welcome Section -->
    <div class="px-4 sm:px-0">
        <h1 class="text-2xl font-bold text-gray-900">Welcome back, <?php echo htmlspecialchars($fullname); ?></h1>

        <!-- Reservations Section -->
        <div class="mt-8">
            <div class="flex justify-between items-center px-4 sm:px-0">
                <h2 class="text-xl font-bold text-gray-900">Your reservations</h2>
                <a href="#" class="text-gray-900">All reservations (<?php echo $totalCount; ?>)</a>
            </div>

            <!-- Reservation Tabs -->
            <div class="mt-4 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <a href="#" data-tab="pending-bookings"
                        class="tab-link border-black text-gray-900 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Pending (<?php echo $pendingCount; ?>)
                    </a>
                    <a href="#" data-tab="confirmed-bookings"
                        class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Confirmed (<?php echo $confirmedCount; ?>)
                    </a>
                    <a href="#" data-tab="cancelled-bookings"
                        class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Cancelled (<?php echo $cancelledCount; ?>)
                    </a>
                    <a href="#" data-tab="completed-bookings"
                        class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Completed (<?php echo $completedCount; ?>)
                    </a>
                </nav>
            </div>

            <!-- Tab Content -->
            <div id="tab-content" class="mt-8">
                <!-- Content will be dynamically loaded here -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <?php
                    $bookings = array_merge($pendingBookings, $confirmedBookings, $cancelledBookings, $completedBookings);
                    if (empty($bookings)) {
                        echo '<p class="p-6 text-center text-gray-600">You do not have any previous bookings.</p>';
                    } else {
                        foreach ($bookings as $booking) {
                            $timezone = new DateTimeZone('Asia/Manila');
                            $currentDateTime = new DateTime('now', $timezone);
                            $bookingStartDate = new DateTime($booking['booking_start_date'], $timezone);
                            ?>
                            <div class="p-6 border-b border-gray-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($booking['venue_tag_name']) ?>
                                    </h2>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                            <?php
                                            switch ($booking['booking_status_id']) {
                                                case '1':
                                                    echo 'Pending';
                                                    break;
                                                case '2':
                                                    echo 'Approved';
                                                    break;
                                                case '3':
                                                    echo 'Cancelled';
                                                    break;
                                                case '4':
                                                    echo 'Completed';
                                                    break;
                                                default:
                                                    echo 'Unknown';
                                                    break;
                                            }
                                            ?>
                                        </span>
                                        <?php if ($bookingStartDate > $currentDateTime): ?>
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Upcoming
                                                Booking</span>
                                        <?php else: ?>
                                            <span
                                                class="px-2 py-1 bg-green-100 text-blue-800 rounded-full text-sm font-medium">Active
                                                Booking</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex gap-6">
                                    <?php
                                    $imageUrls = !empty($booking['image_urls']) ? explode(',', $booking['image_urls']) : [];
                                    ?>
                                    <?php if (!empty($imageUrls)): ?>
                                        <img src="./<?= htmlspecialchars($imageUrls[0]) ?>"
                                            alt="<?= htmlspecialchars($booking['venue_name']) ?>"
                                            class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
                                    <?php endif; ?>
                                    <div class="flex-1">
                                        <p class="text-lg font-medium"><?php echo htmlspecialchars($booking['venue_name']) ?>
                                        </p>
                                        <p class="text-gray-600 mt-1"><?php echo htmlspecialchars($booking['venue_location']) ?>
                                        </p>
                                        <p class="text-gray-600 mt-1">
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_grand_total'] ? $booking['booking_grand_total'] : 0.0)) ?>
                                            for
                                            <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                            days
                                        </p>
                                        <p class="text-gray-600 mt-1">
                                            <?php
                                            $startDate = new DateTime($booking['booking_start_date']);
                                            $endDate = new DateTime($booking['booking_end_date']);
                                            echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                            ?>
                                        </p>
                                        <div class="mt-4 space-x-4">
                                            <button
                                                onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View
                                                Details</button>
                                            <?php if ($booking['booking_status_id'] == '2' || $booking['booking_status_id'] == '4'): ?>
                                                <button onclick="printReceipt(<?php echo htmlspecialchars(json_encode([
                                                    'booking_id' => $booking['booking_id'],
                                                    'venue_name' => $booking['venue_name'],
                                                    'booking_start_date' => $booking['booking_start_date'],
                                                    'booking_end_date' => $booking['booking_end_date'],
                                                    'booking_duration' => $booking['booking_duration'],
                                                    'booking_grand_total' => $booking['booking_grand_total'],
                                                    'booking_payment_method' => $booking['booking_payment_method'],
                                                    'booking_payment_reference' => $booking['booking_payment_reference'],
                                                    'booking_service_fee' => $booking['booking_service_fee'],
                                                    'venue_location' => $booking['venue_location']
                                                ])); ?>)" type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-print mr-2"></i>Print Receipt
                                                </button>
                                                <button onclick="downloadReceipt(<?php echo htmlspecialchars(json_encode([
                                                    'booking_id' => $booking['booking_id'],
                                                    'venue_name' => $booking['venue_name'],
                                                    'booking_start_date' => $booking['booking_start_date'],
                                                    'booking_end_date' => $booking['booking_end_date'],
                                                    'booking_duration' => $booking['booking_duration'],
                                                    'booking_grand_total' => $booking['booking_grand_total'],
                                                    'booking_payment_method' => $booking['booking_payment_method'],
                                                    'booking_payment_reference' => $booking['booking_payment_reference'],
                                                    'booking_service_fee' => $booking['booking_service_fee'],
                                                    'venue_location' => $booking['venue_location']
                                                ])); ?>)" type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-download mr-2"></i>Download Receipt
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($bookingStartDate > $currentDateTime): ?>
                                                <button
                                                    onclick="cancelBooking(<?php echo htmlspecialchars($booking['booking_id']); ?>)"
                                                    class="px-4 py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-50">Cancel
                                                    Booking</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.tab-link');
        const tabContent = document.getElementById('tab-content');
        const bookingsTable = document.getElementById('bookings-table');

        tabs.forEach(tab => {
            tab.addEventListener('click', function (event) {
                event.preventDefault();
                const tabName = this.getAttribute('data-tab');

                // Fetch content for the selected tab
                fetch(`fetch-${tabName}.php`)
                    .then(response => response.text())
                    .then(data => {
                        tabContent.innerHTML = data;
                        bookingsTable.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error fetching tab content:', error);
                        tabContent.innerHTML = `<div class="text-center text-red-500">Error loading content.</div>`;
                    });

                // Update active tab styling
                tabs.forEach(t => t.classList.remove('border-black', 'text-gray-900'));
                this.classList.add('border-black', 'text-gray-900');
            });
        });

        // Trigger click on the first tab to load initial content
        if (tabs.length > 0, tabs[0].click());
    });
</script>