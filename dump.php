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

<!-- Add Modal Structure -->
<div id="editModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">Booking Details</h3>
                        <div class="mt-2 grid grid-cols-2 gap-4">
                            <!-- Booking Information -->
                            <div class="col-span-2">
                                <h4 class="font-semibold text-gray-700 mb-2">Booking Information</h4>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Booking ID</label>
                                <p id="bookingId" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <p id="bookingStatus" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <!-- Venue Details -->
                            <div class="col-span-2">
                                <h4 class="font-semibold text-gray-700 mb-2 mt-4">Venue Details</h4>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Venue Name</label>
                                <p id="venueName" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <p id="venueLocation" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <!-- Dates and Duration -->
                            <div class="col-span-2">
                                <h4 class="font-semibold text-gray-700 mb-2 mt-4">Dates and Duration</h4>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                <p id="startDate" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">End Date</label>
                                <p id="endDate" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Duration</label>
                                <p id="duration" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Number of Participants</label>
                                <p id="participants" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <!-- Payment Details -->
                            <div class="col-span-2">
                                <h4 class="font-semibold text-gray-700 mb-2 mt-4">Payment Details</h4>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Original Price</label>
                                <p id="originalPrice" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Service Fee</label>
                                <p id="serviceFee" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Discount Applied</label>
                                <p id="discount" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Grand Total</label>
                                <p id="grandTotal" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <p id="paymentMethod" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Reference</label>
                                <p id="paymentReference" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Status</label>
                                <p id="paymentStatus" class="mt-1 text-sm text-gray-900"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
</div>

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

    function showDetails(booking) {
        // Format currency
        const formatCurrency = (amount) => {
            return new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP'
            }).format(amount);
        };

        // Format date
        const formatDate = (dateString) => {
            return new Date(dateString).toLocaleDateString('en-PH', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        };

        // Populate modal fields
        document.getElementById('bookingId').textContent = booking.booking_id;
        document.getElementById('bookingStatus').textContent = getStatusText(booking.booking_status_id);
        document.getElementById('venueName').textContent = booking.venue_name;
        document.getElementById('venueLocation').textContent = booking.venue_location;
        document.getElementById('startDate').textContent = formatDate(booking.booking_start_date);
        document.getElementById('endDate').textContent = formatDate(booking.booking_end_date);
        document.getElementById('duration').textContent = `${booking.booking_duration} days`;
        document.getElementById('participants').textContent = booking.booking_participants;
        document.getElementById('originalPrice').textContent = formatCurrency(booking.booking_original_price);
        document.getElementById('serviceFee').textContent = formatCurrency(booking.booking_service_fee);
        document.getElementById('discount').textContent = booking.booking_discount || 'None';
        document.getElementById('grandTotal').textContent = formatCurrency(booking.booking_grand_total);
        document.getElementById('paymentMethod').textContent = booking.booking_payment_method;
        document.getElementById('paymentReference').textContent = booking.booking_payment_reference;
        document.getElementById('paymentStatus').textContent = getPaymentStatusText(booking.booking_payment_status_id);

        // Show the modal
        document.getElementById('editModal').classList.remove('hidden');
    }

    function getStatusText(statusId) {
        const statuses = {
            '1': 'Pending',
            '2': 'Confirmed',
            '3': 'Cancelled',
            '4': 'Completed'
        };
        return statuses[statusId] || 'Unknown';
    }

    function getPaymentStatusText(statusId) {
        const statuses = {
            '1': 'Pending',
            '2': 'Paid',
            '3': 'Failed'
        };
        return statuses[statusId] || 'Unknown';
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>