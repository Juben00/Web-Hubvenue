<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';

// Check if user is logged in
session_start();

$venueObj = new Venue();
$USER_ID = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$fullname = $accountObj->getFullName($USER_ID);

// Fetch booking counts by status
$PENDING_BOOKING = 1;
$CONFIRMED_BOOKING = 2;
$CANCELLED_BOOKING = 3;
$PREVIOUS_BOOKING = 4;

$pendingBookings = $venueObj->getAllBookings($USER_ID, $PENDING_BOOKING);
$confirmedBookings = $venueObj->getAllBookings($USER_ID, $CONFIRMED_BOOKING);
$cancelledBookings = $venueObj->getAllBookings($USER_ID, $CANCELLED_BOOKING);
$completedBookings = $venueObj->getAllBookings($USER_ID, $PREVIOUS_BOOKING);

$pendingCount = count($pendingBookings);
$confirmedCount = count($confirmedBookings);
$cancelledCount = count($cancelledBookings);
$completedCount = count($completedBookings);
$totalCount = $pendingCount + $confirmedCount + $cancelledCount + $completedCount;
?>

<style>
    .period-btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #6B7280;
        border-bottom: 2px solid transparent;
        background: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .period-btn:hover {
        color: #000;
    }

    .period-btn.selected {
        color: #000;
        border-bottom-color: #000;
    }
</style>

<main class="max-w-7xl pt-20 mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Add Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                    <button onclick="showCont('pending')"
                        class="tab-links border-black text-gray-900 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Pending (<?php echo $pendingCount; ?>)
                    </button>
                    <button onclick="showCont('confirmed')"
                        class="tab-links border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Confirmed (<?php echo $confirmedCount; ?>)
                    </button>
                    <button onclick="showCont('cancelled')"
                        class="tab-links border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Cancelled (<?php echo $cancelledCount; ?>)
                    </button>
                    <button onclick="showCont('completed')"
                        class="tab-links border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Completed (<?php echo $completedCount; ?>)
                    </button>
                    <button onclick="showCont('statistics')"
                        class="tab-links border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Statistics
                    </button>
                </nav>
            </div>


            <!-- Tab Content -->
            <!-- <div id="pending-content" class="mt-8 tab-content">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <?php
                    if (empty($pendingBookings)) {
                        echo '<p class="p-6 text-center text-gray-700">You do not have any previous bookings.</p>';
                    } else {
                        foreach ($pendingBookings as $booking) {
                            $timezone = new DateTimeZone('Asia/Manila');
                            $currentDateTime = new DateTime('now', $timezone);
                            $bookingStartDate = new DateTime($booking['booking_start_datetime'], $timezone);
                            ?>
                            <div class="p-6 border-b border-gray-200 booking-item"
                                data-status="<?php echo $booking['booking_status_id']; ?>">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($booking['venue_name']) ?>
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
                                        <p class="text-gray-700 mt-1"><?php echo htmlspecialchars($booking['venue_location']) ?>
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_grand_total'] ? $booking['booking_grand_total'] : 0.0)) ?>
                                            for
                                            <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                            days
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            <?php
                                            $startDate = new DateTime($booking['booking_start_datetime']);
                                            $endDate = new DateTime($booking['booking_end_datetime']);
                                            echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                            ?>
                                        </p>
                                        <div class="mt-4 space-x-4">
                                            <button
                                                onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View Details
                                            </button>
                                            <?php if ($booking['booking_status_id'] == '2' || $booking['booking_status_id'] == '4'): ?>
                                                <button
                                                    onclick="printReceipt(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                    type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-print mr-2"></i>Print Receipt
                                                </button>
                                                <button
                                                    onclick="downloadReceipt(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                    type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-download mr-2"></i>Download Receipt
                                                </button>
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
            </div> -->

            <div id="pending-content" class="mt-8 tab-content">
                <div class="rounded-xl p-6 text-gray-800">
                    <?php if (empty($pendingBookings)) { ?>
                        <p class="text-center text-gray-400">You do not have any pending bookings.</p>
                    <?php } else {
                        foreach ($pendingBookings as $booking) {
                            $timezone = new DateTimeZone('Asia/Manila');
                            $currentDateTime = new DateTime('now', $timezone);
                            $bookingStartDate = new DateTime($booking['booking_start_datetime'], $timezone);
                            ?>
                            <div class="p-6  rounded-lg shadow-lg mb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-2xl font-bold"> <?php echo htmlspecialchars($booking['venue_name']) ?> </h2>
                                    <div class="flex items-center gap-3">
                                        <span class="px-3 py-1 bg-yellow-500 text-white rounded-full text-sm font-semibold">
                                            Pending Approval
                                        </span>
                                        <?php if ($bookingStartDate > $currentDateTime) { ?>
                                            <span
                                                class="px-3 py-1 bg-blue-500 text-white rounded-full text-sm font-semibold">Upcoming</span>
                                        <?php } else { ?>
                                            <span
                                                class="px-3 py-1 bg-green-500 text-white rounded-full text-sm font-semibold">Active</span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="flex gap-6">
                                    <?php $imageUrls = !empty($booking['image_urls']) ? explode(',', $booking['image_urls']) : []; ?>
                                    <?php if (!empty($imageUrls)) { ?>
                                        <img src="./<?php echo htmlspecialchars($imageUrls[0]); ?>"
                                            alt="<?php echo htmlspecialchars($booking['venue_name']); ?>"
                                            class="w-40 h-40 object-cover rounded-xl shadow-lg border-4 border-gray-700">
                                    <?php } ?>
                                    <div class="flex-1">
                                        <p class="text-lg font-medium">Location:
                                            <?php echo htmlspecialchars($booking['venue_location']); ?>
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">Participants:
                                            <?php echo number_format($booking['booking_participants']); ?>
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">Total Cost:
                                            ₱<?php echo number_format($booking['booking_grand_total']); ?></p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Duration: <?php echo number_format($booking['booking_duration']); ?> hours
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Schedule:
                                            <?php echo $bookingStartDate->format('F j, Y, g:i A') . ' - ' . (new DateTime($booking['booking_end_datetime']))->format('F j, Y, g:i A'); ?>
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">Guest:
                                            <?php echo htmlspecialchars($booking['guest_name']); ?>
                                            (<?php echo htmlspecialchars($booking['guest_contact_number']); ?>)
                                        </p>
                                        <div class="mt-4 space-x-4">
                                            <button
                                                onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">View
                                                Details</button>
                                            <form class="approveReservationButton inline-block" method="POST">
                                                <input type="hidden" name="booking_id"
                                                    value="<?php echo $booking['booking_id']; ?>">
                                                <input type="hidden" name="status_id" value="2">
                                                <button type="submit"
                                                    class="text-blue-500 font-bold border-2 px-4 border-blue-500 py-2 rounded-lg">
                                                    Approve
                                                </button>
                                            </form>
                                            <form class="rejectReservationButton inline-block" method="POST">
                                                <input type="hidden" name="booking_id"
                                                    value="<?php echo $booking['booking_id']; ?>">
                                                <input type="hidden" name="status_id" value="4">
                                                <button type="submit"
                                                    class="text-red-500 font-bold border-2 px-4 border-red-500 py-2 rounded-lg">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>

            <div id="confirmed-content" class="mt-8 hidden tab-content">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <?php
                    if (empty($confirmedBookings)) {
                        echo '<p class="p-6 text-center text-gray-700">You do not have any previous bookings.</p>';
                    } else {
                        foreach ($confirmedBookings as $booking) {
                            $timezone = new DateTimeZone('Asia/Manila');
                            $currentDateTime = new DateTime('now', $timezone);
                            $bookingStartDate = new DateTime($booking['booking_start_datetime'], $timezone);
                            ?>
                            <div class="p-6 border-b border-gray-200 booking-item"
                                data-status="<?php echo $booking['booking_status_id']; ?>">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($booking['venue_name']) ?>
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
                                        <p class="text-gray-700 mt-1"><?php echo htmlspecialchars($booking['venue_location']) ?>
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_grand_total'] ? $booking['booking_grand_total'] : 0.0)) ?>
                                            for
                                            <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                            days
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            <?php
                                            $startDate = new DateTime($booking['booking_start_datetime']);
                                            $endDate = new DateTime($booking['booking_end_datetime']);
                                            echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                            ?>
                                        </p>
                                        <div class="mt-4 space-x-4">
                                            <button
                                                onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View Details
                                            </button>
                                            <?php if ($booking['booking_status_id'] == '2' || $booking['booking_status_id'] == '4'): ?>
                                                <button
                                                    onclick="printReceipt(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                    type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-print mr-2"></i>Print Receipt
                                                </button>
                                                <button
                                                    onclick="downloadReceipt(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                    type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-download mr-2"></i>Download Receipt
                                                </button>
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

            <div id="cancelled-content" class="mt-8 hidden tab-content">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <?php
                    if (empty($cancelledBookings)) {
                        echo '<p class="p-6 text-center text-gray-700">You do not have any previous bookings.</p>';
                    } else {
                        foreach ($cancelledBookings as $booking) {
                            $timezone = new DateTimeZone('Asia/Manila');
                            $currentDateTime = new DateTime('now', $timezone);
                            $bookingStartDate = new DateTime($booking['booking_start_datetime'], $timezone);
                            ?>
                            <div class="p-6 border-b border-gray-200 booking-item"
                                data-status="<?php echo $booking['booking_status_id']; ?>">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($booking['venue_name']) ?>
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
                                        <p class="text-gray-700 mt-1"><?php echo htmlspecialchars($booking['venue_location']) ?>
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_grand_total'] ? $booking['booking_grand_total'] : 0.0)) ?>
                                            for
                                            <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                            days
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            <?php
                                            $startDate = new DateTime($booking['booking_start_datetime']);
                                            $endDate = new DateTime($booking['booking_end_datetime']);
                                            echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                            ?>
                                        </p>
                                        <div class="mt-4 space-x-4">
                                            <button
                                                onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View Details
                                            </button>
                                            <?php if ($booking['booking_status_id'] == '2' || $booking['booking_status_id'] == '4'): ?>
                                                <button
                                                    onclick="printReceipt(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                    type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-print mr-2"></i>Print Receipt
                                                </button>
                                                <button
                                                    onclick="downloadReceipt(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                    type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-download mr-2"></i>Download Receipt
                                                </button>
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

            <div id="completed-content" class="mt-8 hidden tab-content">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <?php
                    if (empty($completedBookings)) {
                        echo '<p class="p-6 text-center text-gray-700">You do not have any previous bookings.</p>';
                    } else {
                        foreach ($completedBookings as $booking) {
                            $timezone = new DateTimeZone('Asia/Manila');
                            $currentDateTime = new DateTime('now', $timezone);
                            $bookingStartDate = new DateTime($booking['booking_start_datetime'], $timezone);
                            ?>
                            <div class="p-6 border-b border-gray-200 booking-item"
                                data-status="<?php echo $booking['booking_status_id']; ?>">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($booking['venue_name']) ?>
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
                                        <p class="text-gray-700 mt-1"><?php echo htmlspecialchars($booking['venue_location']) ?>
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_grand_total'] ? $booking['booking_grand_total'] : 0.0)) ?>
                                            for
                                            <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                            days
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            <?php
                                            $startDate = new DateTime($booking['booking_start_datetime']);
                                            $endDate = new DateTime($booking['booking_end_datetime']);
                                            echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                            ?>
                                        </p>
                                        <div class="mt-4 space-x-4">
                                            <button
                                                onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View Details
                                            </button>
                                            <?php if ($booking['booking_status_id'] == '2' || $booking['booking_status_id'] == '4'): ?>
                                                <button
                                                    onclick="printReceipt(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                    type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-print mr-2"></i>Print Receipt
                                                </button>
                                                <button
                                                    onclick="downloadReceipt(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                    type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-download mr-2"></i>Download Receipt
                                                </button>
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

            <!-- Add Statistics Content -->
            <div id="statistics-content" class="mt-8 hidden tab-content">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php
                    // Fetch venues for this host
                    $hostVenues = $venueObj->getVenuesByHost($USER_ID);

                    foreach ($hostVenues as $venue) {
                        // Get statistics for each venue
                        $venueStats = $venueObj->getVenueStatistics($venue['id']);
                        $totalBookings = $venueStats['total_bookings'] ?? 0;
                        $averageRating = $venueStats['average_rating'] ?? 0;
                        $totalRevenue = $venueStats['total_revenue'] ?? 0;
                        $occupancyRate = $venueStats['occupancy_rate'] ?? 0;

                        // Get pending, confirmed, completed, cancelled counts for this venue
                        $venuePending = $venueObj->getBookingCountByStatus($venue['id'], 1);
                        $venueConfirmed = $venueObj->getBookingCountByStatus($venue['id'], 2);
                        $venueCompleted = $venueObj->getBookingCountByStatus($venue['id'], 4);
                        $venueCancelled = $venueObj->getBookingCountByStatus($venue['id'], 3);
                        ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="relative h-48">
                                <?php
                                $imageUrls = !empty($venue['image_urls']) ? explode(',', $venue['image_urls']) : [];
                                if (!empty($imageUrls)):
                                    ?>
                                    <img src="./<?= htmlspecialchars($imageUrls[$venue['thumbnail']]) ?>"
                                        alt="<?= htmlspecialchars($venue['name']) ?>" class="w-full h-full object-cover">
                                <?php endif; ?>
                                <div
                                    class="absolute top-4 right-4 bg-black bg-opacity-75 text-white px-2 py-1 rounded text-sm">
                                    Intimate Gatherings
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-4"><?= htmlspecialchars($venue['name']) ?></h3>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Bookings</p>
                                        <p class="text-xl font-semibold"><?= $totalBookings ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Average Rating</p>
                                        <p class="text-xl font-semibold flex items-center">
                                            <?= number_format($averageRating, 1) ?>
                                            <span class="text-yellow-400 ml-1">★</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Revenue</p>
                                        <p class="text-xl font-semibold">₱<?= number_format($totalRevenue, 2) ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Occupancy Rate</p>
                                        <p class="text-xl font-semibold"><?= number_format($occupancyRate, 1) ?>%</p>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Pending</span>
                                        <span class="text-sm font-medium"><?= $venuePending ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Confirmed</span>
                                        <span class="text-sm font-medium"><?= $venueConfirmed ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Completed</span>
                                        <span class="text-sm font-medium"><?= $venueCompleted ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Cancelled</span>
                                        <span class="text-sm font-medium"><?= $venueCancelled ?></span>
                                    </div>
                                </div>

                                <button onclick="showDetailedStats(<?= htmlspecialchars(json_encode([
                                    'name' => $venue['name'],
                                    'id' => $venue['id'],
                                    'time_based_stats' => $venue['time_based_stats'] ?? null
                                ])); ?>)"
                                    class="mt-6 w-full bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition-colors">
                                    View Detailed Statistics
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- details modal -->
<?php
require_once '../components/venue-details.modal.html';
require_once '../components/qr-code.modal.html';
require_once '../components/stats.modal.html';
?>

<script>
    function closeQr() {
        const qrModal = document.getElementById('qrModal');
        qrModal.classList.remove('flex');
        qrModal.classList.add('hidden');
    }

    function showDetails(booking) {
        const modal = document.getElementById('details-modal');

        console.log(booking);

        if (booking.booking_status_id == 2) {
            const checkInBtn = document.getElementById('checkInBtn');
            checkInBtn.onclick = () => {
                const qrModal = document.getElementById('qrModal');
                qrModal.classList.remove('hidden');
                qrModal.classList.add('flex');
                qrModal.classList.add('z-50');

                // Set the check-in link for the QR code
                const checkLink = booking.booking_checkin_link;
                document.getElementById('qrLink').href = checkLink;

                // Generate the QR code
                const qrCodeContainer = document.getElementById('qrCodeContainer');
                qrCodeContainer.innerHTML = '';
                new QRCode(qrCodeContainer, checkLink);
            };

            const checkOutBtn = document.getElementById('checkOutBtn');
            checkOutBtn.onclick = () => {
                const qrModal = document.getElementById('qrModal');
                qrModal.classList.remove('hidden');
                qrModal.classList.add('flex');
                qrModal.classList.add('z-50');

                // Set the check-out link for the QR code
                const checkLink = booking.booking_checkout_link;
                document.getElementById('qrLink').href = checkLink;

                // Generate the QR code
                const qrCodeContainer = document.getElementById('qrCodeContainer');
                qrCodeContainer.innerHTML = '';
                new QRCode(qrCodeContainer, checkLink);
            };

            const noShowBtn = document.getElementById('noShowBtn');
            noShowBtn.onclick = () => {
                confirmshowModal('Are you sure you want to mark this booking as a no-show?', () => {
                    fetch('./api/noShowBooking.api.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ booking_id: booking.booking_id })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                showModal('Booking marked as no-show.', undefined, "../images/black_ico.png");
                                closeModal();
                            } else {
                                showModal(data.message, undefined, "../images/black_ico.png");
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showModal('An error occurred. Please try again.', undefined, "../images/black_ico.png");
                        });
                }, "../images/black_ico.png");
            };
        } else {
            document.getElementById('checkInBtn').style.display = 'none';
            document.getElementById('checkOutBtn').style.display = 'none';
            document.getElementById('noShowBtn').style.display = 'none';
        }

        // Set maile with fallback
        document.getElementById('maile').innerHTML = booking.guest_email && booking.guest_email.trim() !== ""
            ? booking.guest_email
            : 'No email provided';

        // Set xes with fallback
        document.getElementById('xes').innerHTML = booking.guest_sex === 1
            ? 'Male'
            : (booking.guest_sex === 2 ? 'Female' : 'Not specified');

        // Show modal with fade-in effect
        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            modal.classList.add('opacity-100');
            modal.querySelector('.relative').classList.add('scale-100');
            modal.querySelector('.relative').classList.remove('scale-95');
        });

        // Set main title
        document.getElementById('modal-title').textContent = booking.name;

        // Setup main image and gallery
        const mainImage = document.getElementById('modal-main-image');
        mainImage.src = './' + booking.image_urls.split(',')[booking.thumbnail];

        // Setup image gallery with horizontal thumbnails
        const imageGallery = document.getElementById('image-gallery');
        const imageUrls = booking.image_urls.split(',');
        imageGallery.innerHTML = imageUrls.map(url => `
            <div class="flex-shrink-0 h-16 w-16 rounded-lg overflow-hidden">
                <img src="./${url}" 
                    alt="Venue Image" 
                    class="w-full h-full object-cover cursor-pointer hover:opacity-75 transition-opacity duration-200" 
                    onclick="changeMainImage(this.src)">
            </div>
        `).join('');

        // Set booking status and type
        const bookingStatus = document.getElementById('booking-status');
        const statusText = getBookingStatusText(booking.booking_status_id);
        bookingStatus.textContent = statusText;
        bookingStatus.className = `px-3 py-1 rounded-full text-sm font-medium ${getStatusColor(booking.booking_status_id)}`;

        // Set location details
        const locationDetails = document.getElementById('location-details');
        locationDetails.innerHTML = `<p>${booking.address}</p>`;

        // Set capacity and amenities
        document.getElementById('venue-capacity').textContent = `${booking.venue_capacity} guests`;

        const amenitiesList = document.getElementById('amenities-list');
        const amenities = JSON.parse(booking.venue_amenities); // Parse the JSON string first
        amenitiesList.innerHTML = amenities.map(amenity => `<li>${amenity}</li>`).join('');

        // Set rules
        const rulesList = document.getElementById('venue-rules');
        const rules = JSON.parse(booking.venue_rules); // Parse the JSON string first
        rulesList.innerHTML = rules.map(rule => `<li>${rule}</li>`).join('');

        // Set booking details
        document.getElementById('booking-duration').textContent = `${booking.booking_duration} day/s`;
        document.getElementById('start-date').textContent = new Date(booking.booking_start_datetime).toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });
        document.getElementById('end-date').textContent = new Date(booking.booking_end_datetime).toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });
        document.getElementById('request').textContent = booking.booking_request;
        document.getElementById('attendees').textContent = booking.booking_participants;
        document.getElementById('mode-of-payment').textContent = booking.payment_method_name;
        document.getElementById('raw-cost').textContent = `₱${numberWithCommas(booking.booking_grand_total)}`;
        document.getElementById('total-cost').textContent = `₱${numberWithCommas(parseFloat(booking.booking_dp_amount + booking.booking_balance))}`;
        document.getElementById('payment').textContent = `₱${numberWithCommas(booking.booking_dp_amount)}`;
        document.getElementById('balance').textContent = `₱${numberWithCommas(booking.booking_balance)}`;
        document.getElementById('reservation-date').textContent = new Date(booking.booking_created_at).toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });

        // Set discount details
        const discount = document.getElementById('discount');
        let discountText = booking.is_discounted == null ? '' : 'PWD/Senior Citizen Discount';
        let platformDiscount = '';
        discount.textContent = `${discountText} ${booking.discount_code ? `${booking.discount_code} - ${booking.discount_value}%` : ''}`;
        document.getElementById('name').textContent = `${booking.guest_name}`;

        const birthDate = new Date(booking.guest_birthdate); // Assuming 'booking.birthdate' is in a valid date format
        const today = new Date();

        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        // Adjust age if the birth month and day haven't passed yet
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        document.getElementById('age').textContent = age;

        // Set address with fallback
        document.getElementById('address').textContent = booking.guest_address && booking.guest_address.trim() !== ""
            ? booking.guest_address
            : 'No address provided';

        // Set date joined with formatted date
        document.getElementById('date-joined').textContent = new Date(booking.guest_created_at).toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });

    }

    function getBookingStatusText(statusId) {
        const statusTexts = {
            '1': 'Pending',
            '2': 'Confirmed',
            '3': 'Cancelled',
            '4': 'Completed'
        };
        return statusTexts[statusId] || 'Unknown';
    }

    function getStatusColor(statusId) {
        const statusColors = {
            '1': 'bg-yellow-100 text-yellow-800',
            '2': 'bg-green-100 text-green-800',
            '3': 'bg-red-100 text-red-800',
            '4': 'bg-blue-100 text-blue-800'
        };
        return statusColors[statusId] || 'bg-gray-100 text-gray-800';
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function changeMainImage(src) {
        const mainImage = document.getElementById('modal-main-image');
        mainImage.src = src;
    }

    function showCont(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        document.getElementById(tabName + '-content').classList.remove('hidden');

        document.querySelectorAll('.tab-links').forEach(btn => {
            btn.classList.remove('border-black', 'text-gray-900');
            btn.classList.add('border-transparent', 'text-gray-500');
        });

        event.currentTarget.classList.remove('border-transparent', 'text-gray-500');
        event.currentTarget.classList.add('border-black', 'text-gray-900');
    }

    // Set default tab to 'pending'
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('.tab-links').click();
    });

    currentStats = null;
    revenueChart = null;
    bookingsChart = null;

    function showDetailedStats(venueData) {
        currentStats = venueData;
        const modal = document.getElementById('stats-modal');
        document.getElementById('modal-venue-name').textContent = venueData.name;

        // Show modal
        modal.classList.remove('hidden');

        // Initialize charts if they haven't been created yet
        if (!revenueChart) {
            initializeCharts();
        }

        // Get all stats at once
        fetchVenueStats(venueData.id).then(stats => {
            currentStats.stats = stats;
            // Set initial period to 'today'
            switchPeriod('today');

            // Update overall statistics
            updateOverallStats(stats);

            // Update charts with new data
            updateCharts(stats);
        });
    }

    function initializeCharts() {
        // Initialize Revenue Chart
        const revenueCtx = document.getElementById('revenue-chart').getContext('2d');
        revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Revenue',
                    data: [],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        // Initialize Bookings Chart
        const bookingsCtx = document.getElementById('bookings-chart').getContext('2d');
        bookingsChart = new Chart(bookingsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Confirmed', 'Cancelled', 'Completed'],
                datasets: [{
                    data: [0, 0, 0, 0],
                    backgroundColor: [
                        'rgb(251, 191, 36)',
                        'rgb(34, 197, 94)',
                        'rgb(239, 68, 68)',
                        'rgb(59, 130, 246)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right'
                    }
                }
            }
        });
    }

    function updateCharts(stats) {
        if (!stats || !stats.revenue_over_time || !stats.booking_distribution) return;

        // Update Revenue Chart
        revenueChart.data.labels = stats.revenue_over_time.map(item => item.date);
        revenueChart.data.datasets[0].data = stats.revenue_over_time.map(item => item.revenue);
        revenueChart.update();

        // Update Bookings Chart
        bookingsChart.data.datasets[0].data = [
            stats.booking_distribution.pending,
            stats.booking_distribution.confirmed,
            stats.booking_distribution.cancelled,
            stats.booking_distribution.completed
        ];
        bookingsChart.update();
    }

    function fetchVenueStats(venueId) {
        return fetch(`./api/getVenueStats.php?venue_id=${venueId}`)
            .then(response => response.json())
            .catch(error => {
                console.error('Error fetching stats:', error);
                return null;
            });
    }

    function updateOverallStats(stats) {
        if (!stats) return;

        document.getElementById('stats-total-revenue').textContent = `₱${numberWithCommas(stats.total_revenue.toFixed(2))}`;
        document.getElementById('stats-avg-rating').textContent = `${stats.average_rating.toFixed(1)} `;
        document.getElementById('stats-total-bookings').textContent = stats.total_bookings;
        document.getElementById('stats-occupancy').textContent = `${stats.occupancy_rate.toFixed(1)}%`;
    }

    function switchPeriod(period) {
        if (!currentStats || !currentStats.stats) return;

        // Update button styles
        document.querySelectorAll('.period-btn').forEach(btn => {
            if (btn.textContent.toLowerCase().includes(period.toLowerCase())) {
                btn.classList.add('selected');
            } else {
                btn.classList.remove('selected');
            }
        });

        const stats = currentStats.stats[period];
        if (!stats) return;

        // Update period statistics
        document.getElementById('stats-revenue').textContent = `₱${numberWithCommas(stats.revenue.toFixed(2))}`;
        document.getElementById('stats-bookings').textContent = stats.bookings;
        document.getElementById('stats-avg-guests').textContent = stats.avg_guests.toFixed(1);

        // Update the "Last 24h" text based on period
        const periodText = document.querySelector('.text-xs.text-blue-600');
        switch (period) {
            case 'today':
                periodText.textContent = 'Last 24h';
                break;
            case 'week':
                periodText.textContent = 'This Week';
                break;
            case 'month':
                periodText.textContent = 'This Month';
                break;
            case 'year':
                periodText.textContent = 'This Year';
                break;
        }
    }

    function closeStatsModal() {
        const modal = document.getElementById('stats-modal');
        modal.classList.add('hidden');

        // Reset charts when closing modal
        if (revenueChart) {
            revenueChart.destroy();
            revenueChart = null;
        }
        if (bookingsChart) {
            bookingsChart.destroy();
            bookingsChart = null;
        }
    }

    // Close modal when clicking outside
    document.getElementById('stats-modal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeStatsModal();
        }
    });
</script>