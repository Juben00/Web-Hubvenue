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
            <div id="pending-content" class="mt-8 tab-content">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <?php
                    if (empty($pendingBookings)) {
                        echo '<p class="p-6 text-center text-gray-700">You do not have any previous bookings.</p>';
                    } else {
                        foreach ($pendingBookings as $booking) {
                            $timezone = new DateTimeZone('Asia/Manila');
                            $currentDateTime = new DateTime('now', $timezone);
                            $bookingStartDate = new DateTime($booking['booking_start_date'], $timezone);
                            ?>
                            <div class="p-6 border-b border-gray-200 booking-item"
                                data-status="<?php echo $booking['booking_status_id']; ?>">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($booking['name']) ?></h2>
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
                                            alt="<?= htmlspecialchars($booking['name']) ?>"
                                            class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
                                    <?php endif; ?>
                                    <div class="flex-1">
                                        <p class="text-lg font-medium"><?php echo htmlspecialchars($booking['name']) ?></p>
                                        <p class="text-gray-700 mt-1"><?php echo htmlspecialchars($booking['address']) ?></p>
                                        <p class="text-gray-700 mt-1">
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_grand_total'] ? $booking['booking_grand_total'] : 0.0)) ?>
                                            for
                                            <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                            days
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            <?php
                                            $startDate = new DateTime($booking['booking_start_date']);
                                            $endDate = new DateTime($booking['booking_end_date']);
                                            echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                            ?>
                                        </p>
                                        <div class="mt-4 space-x-4">
                                            <button
                                                onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View Details
                                            </button>
                                            <?php if ($booking['booking_status_id'] == '2' || $booking['booking_status_id'] == '4'): ?>
                                                <button onclick="printReceipt(<?php echo htmlspecialchars(json_encode([
                                                    'booking_id' => $booking['booking_id'],
                                                    'venue_name' => $booking['name'],
                                                    'booking_start_date' => $booking['booking_start_date'],
                                                    'booking_end_date' => $booking['booking_end_date'],
                                                    'booking_duration' => $booking['booking_duration'],
                                                    'booking_grand_total' => $booking['booking_grand_total'],
                                                    'booking_payment_method' => $booking['booking_payment_method'],
                                                    'booking_payment_reference' => $booking['booking_payment_reference'],
                                                    'booking_service_fee' => $booking['booking_service_fee'],
                                                    'venue_location' => $booking['address']
                                                ])); ?>)" type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-print mr-2"></i>Print Receipt
                                                </button>
                                                <button onclick="downloadReceipt(<?php echo htmlspecialchars(json_encode([
                                                    'booking_id' => $booking['booking_id'],
                                                    'venue_name' => $booking['name'],
                                                    'booking_start_date' => $booking['booking_start_date'],
                                                    'booking_end_date' => $booking['booking_end_date'],
                                                    'booking_duration' => $booking['booking_duration'],
                                                    'booking_grand_total' => $booking['booking_grand_total'],
                                                    'booking_payment_method' => $booking['booking_payment_method'],
                                                    'booking_payment_reference' => $booking['booking_payment_reference'],
                                                    'booking_service_fee' => $booking['booking_service_fee'],
                                                    'venue_location' => $booking['address']
                                                ])); ?>)" type="button"
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

            <div id="confirmed-content" class="mt-8 hidden tab-content">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <?php
                    if (empty($confirmedBookings)) {
                        echo '<p class="p-6 text-center text-gray-700">You do not have any previous bookings.</p>';
                    } else {
                        foreach ($confirmedBookings as $booking) {
                            $timezone = new DateTimeZone('Asia/Manila');
                            $currentDateTime = new DateTime('now', $timezone);
                            $bookingStartDate = new DateTime($booking['booking_start_date'], $timezone);
                            ?>
                            <div class="p-6 border-b border-gray-200 booking-item"
                                data-status="<?php echo $booking['booking_status_id']; ?>">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($booking['name']) ?></h2>
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
                                            alt="<?= htmlspecialchars($booking['name']) ?>"
                                            class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
                                    <?php endif; ?>
                                    <div class="flex-1">
                                        <p class="text-lg font-medium"><?php echo htmlspecialchars($booking['name']) ?></p>
                                        <p class="text-gray-700 mt-1"><?php echo htmlspecialchars($booking['address']) ?></p>
                                        <p class="text-gray-700 mt-1">
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_grand_total'] ? $booking['booking_grand_total'] : 0.0)) ?>
                                            for
                                            <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                            days
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            <?php
                                            $startDate = new DateTime($booking['booking_start_date']);
                                            $endDate = new DateTime($booking['booking_end_date']);
                                            echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                            ?>
                                        </p>
                                        <div class="mt-4 space-x-4">
                                            <button
                                                onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View Details
                                            </button>
                                            <?php if ($booking['booking_status_id'] == '2' || $booking['booking_status_id'] == '4'): ?>
                                                <button onclick="printReceipt(<?php echo htmlspecialchars(json_encode([
                                                    'booking_id' => $booking['booking_id'],
                                                    'venue_name' => $booking['name'],
                                                    'booking_start_date' => $booking['booking_start_date'],
                                                    'booking_end_date' => $booking['booking_end_date'],
                                                    'booking_duration' => $booking['booking_duration'],
                                                    'booking_grand_total' => $booking['booking_grand_total'],
                                                    'booking_payment_method' => $booking['booking_payment_method'],
                                                    'booking_payment_reference' => $booking['booking_payment_reference'],
                                                    'booking_service_fee' => $booking['booking_service_fee'],
                                                    'venue_location' => $booking['address']
                                                ])); ?>)" type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-print mr-2"></i>Print Receipt
                                                </button>
                                                <button onclick="downloadReceipt(<?php echo htmlspecialchars(json_encode([
                                                    'booking_id' => $booking['booking_id'],
                                                    'venue_name' => $booking['name'],
                                                    'booking_start_date' => $booking['booking_start_date'],
                                                    'booking_end_date' => $booking['booking_end_date'],
                                                    'booking_duration' => $booking['booking_duration'],
                                                    'booking_grand_total' => $booking['booking_grand_total'],
                                                    'booking_payment_method' => $booking['booking_payment_method'],
                                                    'booking_payment_reference' => $booking['booking_payment_reference'],
                                                    'booking_service_fee' => $booking['booking_service_fee'],
                                                    'venue_location' => $booking['address']
                                                ])); ?>)" type="button"
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
                            $bookingStartDate = new DateTime($booking['booking_start_date'], $timezone);
                            ?>
                            <div class="p-6 border-b border-gray-200 booking-item"
                                data-status="<?php echo $booking['booking_status_id']; ?>">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($booking['name']) ?></h2>
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
                                            alt="<?= htmlspecialchars($booking['name']) ?>"
                                            class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
                                    <?php endif; ?>
                                    <div class="flex-1">
                                        <p class="text-lg font-medium"><?php echo htmlspecialchars($booking['name']) ?></p>
                                        <p class="text-gray-700 mt-1"><?php echo htmlspecialchars($booking['address']) ?></p>
                                        <p class="text-gray-700 mt-1">
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_grand_total'] ? $booking['booking_grand_total'] : 0.0)) ?>
                                            for
                                            <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                            days
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            <?php
                                            $startDate = new DateTime($booking['booking_start_date']);
                                            $endDate = new DateTime($booking['booking_end_date']);
                                            echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                            ?>
                                        </p>
                                        <div class="mt-4 space-x-4">
                                            <button
                                                onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View Details
                                            </button>
                                            <?php if ($booking['booking_status_id'] == '2' || $booking['booking_status_id'] == '4'): ?>
                                                <button onclick="printReceipt(<?php echo htmlspecialchars(json_encode([
                                                    'booking_id' => $booking['booking_id'],
                                                    'venue_name' => $booking['name'],
                                                    'booking_start_date' => $booking['booking_start_date'],
                                                    'booking_end_date' => $booking['booking_end_date'],
                                                    'booking_duration' => $booking['booking_duration'],
                                                    'booking_grand_total' => $booking['booking_grand_total'],
                                                    'booking_payment_method' => $booking['booking_payment_method'],
                                                    'booking_payment_reference' => $booking['booking_payment_reference'],
                                                    'booking_service_fee' => $booking['booking_service_fee'],
                                                    'venue_location' => $booking['address']
                                                ])); ?>)" type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-print mr-2"></i>Print Receipt
                                                </button>
                                                <button onclick="downloadReceipt(<?php echo htmlspecialchars(json_encode([
                                                    'booking_id' => $booking['booking_id'],
                                                    'venue_name' => $booking['name'],
                                                    'booking_start_date' => $booking['booking_start_date'],
                                                    'booking_end_date' => $booking['booking_end_date'],
                                                    'booking_duration' => $booking['booking_duration'],
                                                    'booking_grand_total' => $booking['booking_grand_total'],
                                                    'booking_payment_method' => $booking['booking_payment_method'],
                                                    'booking_payment_reference' => $booking['booking_payment_reference'],
                                                    'booking_service_fee' => $booking['booking_service_fee'],
                                                    'venue_location' => $booking['address']
                                                ])); ?>)" type="button"
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
                            $bookingStartDate = new DateTime($booking['booking_start_date'], $timezone);
                            ?>
                            <div class="p-6 border-b border-gray-200 booking-item"
                                data-status="<?php echo $booking['booking_status_id']; ?>">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($booking['name']) ?></h2>
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
                                            alt="<?= htmlspecialchars($booking['name']) ?>"
                                            class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
                                    <?php endif; ?>
                                    <div class="flex-1">
                                        <p class="text-lg font-medium"><?php echo htmlspecialchars($booking['name']) ?></p>
                                        <p class="text-gray-700 mt-1"><?php echo htmlspecialchars($booking['address']) ?></p>
                                        <p class="text-gray-700 mt-1">
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_grand_total'] ? $booking['booking_grand_total'] : 0.0)) ?>
                                            for
                                            <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                            days
                                        </p>
                                        <p class="text-gray-700 mt-1">
                                            <?php
                                            $startDate = new DateTime($booking['booking_start_date']);
                                            $endDate = new DateTime($booking['booking_end_date']);
                                            echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                            ?>
                                        </p>
                                        <div class="mt-4 space-x-4">
                                            <button
                                                onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View Details
                                            </button>
                                            <?php if ($booking['booking_status_id'] == '2' || $booking['booking_status_id'] == '4'): ?>
                                                <button onclick="printReceipt(<?php echo htmlspecialchars(json_encode([
                                                    'booking_id' => $booking['booking_id'],
                                                    'venue_name' => $booking['name'],
                                                    'booking_start_date' => $booking['booking_start_date'],
                                                    'booking_end_date' => $booking['booking_end_date'],
                                                    'booking_duration' => $booking['booking_duration'],
                                                    'booking_grand_total' => $booking['booking_grand_total'],
                                                    'booking_payment_method' => $booking['booking_payment_method'],
                                                    'booking_payment_reference' => $booking['booking_payment_reference'],
                                                    'booking_service_fee' => $booking['booking_service_fee'],
                                                    'venue_location' => $booking['address']
                                                ])); ?>)" type="button"
                                                    class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                    <i class="fas fa-print mr-2"></i>Print Receipt
                                                </button>
                                                <button onclick="downloadReceipt(<?php echo htmlspecialchars(json_encode([
                                                    'booking_id' => $booking['booking_id'],
                                                    'venue_name' => $booking['name'],
                                                    'booking_start_date' => $booking['booking_start_date'],
                                                    'booking_end_date' => $booking['booking_end_date'],
                                                    'booking_duration' => $booking['booking_duration'],
                                                    'booking_grand_total' => $booking['booking_grand_total'],
                                                    'booking_payment_method' => $booking['booking_payment_method'],
                                                    'booking_payment_reference' => $booking['booking_payment_reference'],
                                                    'booking_service_fee' => $booking['booking_service_fee'],
                                                    'venue_location' => $booking['address']
                                                ])); ?>)" type="button"
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

            <!-- Add Statistics Tab Content -->
            <div id="statistics-content" class="mt-8 hidden tab-content">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php 
                    $venueStats = $venueObj->getAllVenuesWithStats($hostId);
                    foreach ($venueStats as $venue): ?>
                        <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition duration-300">
                            <!-- Venue Image -->
                            <div class="relative h-48">
                                <img src="./<?php echo !empty($venue['image_urls']) ? $venue['image_urls'][$venue['thumbnail']] : '../images/black_ico.png'; ?>"
                                    alt="<?php echo htmlspecialchars($venue['name']); ?>"
                                    class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="px-2 py-1 bg-black text-white rounded-full text-xs">
                                        <?php echo htmlspecialchars($venue['venue_tag_name']); ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Venue Details -->
                            <div class="p-4">
                                <h3 class="font-medium text-lg mb-2"><?php echo htmlspecialchars($venue['name']); ?></h3>
                                
                                <!-- Quick Stats Grid -->
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <!-- Total Bookings -->
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-sm text-gray-600">Total Bookings</p>
                                        <p class="text-lg font-semibold"><?php echo $venue['total_bookings']; ?></p>
                                    </div>
                                    
                                    <!-- Average Rating -->
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-sm text-gray-600">Average Rating</p>
                                        <p class="text-lg font-semibold">
                                            <?php echo number_format($venue['average_rating'], 1); ?> ⭐
                                        </p>
                                    </div>
                                    
                                    <!-- Total Revenue -->
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-sm text-gray-600">Total Revenue</p>
                                        <p class="text-lg font-semibold">₱<?php echo number_format($venue['total_revenue']); ?></p>
                                    </div>
                                    
                                    <!-- Occupancy Rate -->
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-sm text-gray-600">Occupancy Rate</p>
                                        <p class="text-lg font-semibold"><?php echo number_format($venue['occupancy_rate'], 1); ?>%</p>
                                    </div>
                                </div>

                                <!-- Additional Stats -->
                                <div class="mb-4">
                                    <div class="bg-gray-50 p-3 rounded-lg mb-2">
                                        <p class="text-sm text-gray-600">Average Duration</p>
                                        <p class="text-md font-semibold"><?php echo number_format($venue['average_duration'], 1); ?> days</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-sm text-gray-600">Total Guests</p>
                                        <p class="text-md font-semibold"><?php echo number_format($venue['total_guests']); ?> guests</p>
                                    </div>
                                </div>

                                <!-- Booking Status Distribution -->
                                <div class="space-y-2">
                                    <!-- Pending -->
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Pending</span>
                                        <span class="font-medium"><?php echo $venue['pending_bookings']; ?></span>
                                    </div>
                                    <!-- Confirmed -->
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Confirmed</span>
                                        <span class="font-medium"><?php echo $venue['confirmed_bookings']; ?></span>
                                    </div>
                                    <!-- Completed -->
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Completed</span>
                                        <span class="font-medium"><?php echo $venue['completed_bookings']; ?></span>
                                    </div>
                                    <!-- Cancelled -->
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Cancelled</span>
                                        <span class="font-medium"><?php echo $venue['cancelled_bookings']; ?></span>
                                    </div>
                                </div>

                                <!-- View Details Button -->
                                <button onclick="showVenueDetailStats(<?php echo htmlspecialchars(json_encode($venue)); ?>)" 
                                        class="w-full mt-4 px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition duration-300">
                                    View Detailed Statistics
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</main>
<div id="details-modal"
    class="hidden fixed inset-0 bg-black/50 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-all duration-300 ease-out opacity-0">
    <div
        class="relative top-20 mx-auto p-6 border w-full max-w-4xl shadow-lg rounded-xl bg-white transition-all duration-300 transform scale-95">
        <!-- Modal Header -->
        <div class="flex justify-between items-center pb-4 border-b">
            <span class="flex items-center space-x-2">
                <h3 class="text-xl font-bold" id="modal-title"></h3>
                <div class="flex items-center gap-2">
                    <span id="booking-status" class="px-2.5 py-0.5 rounded-full text-sm font-medium"></span>
                </div>
            </span>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Modal Content -->
        <div id="modal-content" class="mt-4">
            <!-- Main image and details container -->
            <div class="flex flex-col items-center">
                <!-- Images Section -->
                <div class="w-full mb-6">
                    <!-- Main Image -->
                    <div class="relative h-80 rounded-lg overflow-hidden mb-4">
                        <img id="modal-main-image" src="" alt="Venue Main Image"
                            class="w-full h-full object-cover transition-transform duration-200 hover:scale-105">
                    </div>

                    <!-- Horizontal Thumbnail Strip -->
                    <div class="flex gap-2 overflow-x-auto py-2" id="image-gallery">
                        <!-- Thumbnail images will be inserted here -->
                    </div>
                </div>

                <!-- Details Section -->
                <div class="w-full space-y-6">
                    <!-- Two Column Layout for Venue Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <!-- Location Section -->
                            <div>
                                <h4 class="font-semibold text-lg text-gray-900 mb-2">Location</h4>
                                <div class="space-y-1 text-gray-700 text-sm" id="location-details"></div>
                            </div>

                            <!-- Capacity -->
                            <div>
                                <h4 class="font-semibold text-lg text-gray-900 mb-2">Capacity</h4>
                                <p id="venue-capacity" class="text-gray-700 text-sm"></p>
                            </div>

                            <!-- Rules -->
                            <div>
                                <h4 class="font-semibold text-lg text-gray-900 mb-2">Rules</h4>
                                <p id="venue-rules" class="text-gray-700 text-sm"></p>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <!-- Amenities -->
                            <div>
                                <h4 class="font-semibold text-lg text-gray-900 mb-2">Amenities</h4>
                                <ul id="amenities-list"
                                    class="text-gray-700 grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Booking and Guest Details Section -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <!-- Booking Details Section -->
                        <div class="p-6">
                            <h4 class="font-bold text-xl text-gray-900 mb-6">Booking Details</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Booking Duration</h5>
                                    <p id="booking-duration" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Start Date</h5>
                                    <p id="start-date" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">End Date</h5>
                                    <p id="end-date" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Request</h5>
                                    <p id="request" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Attendees</h5>
                                    <p id="attendees" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Mode of Payment</h5>
                                    <p id="mode-of-payment" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Raw Cost</h5>
                                    <p id="raw-cost" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Total Cost</h5>
                                    <p id="total-cost" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Payment</h5>
                                    <p id="payment" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Balance</h5>
                                    <p id="balance" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Discount</h5>
                                    <p id="discount" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Reservation Date</h5>
                                    <p id="reservation-date" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Guest Details Section -->
                        <div class="p-6 border-t border-gray-100">
                            <h4 class="font-bold text-xl text-gray-900 mb-6">Guest Details</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Name</h5>
                                    <p id="name" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Email</h5>
                                    <p id="maile" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Address</h5>
                                    <p id="address" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Sex</h5>
                                    <p id="xes" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Age</h5>
                                    <p id="age" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                                <div
                                    class="p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                                    <h5 class="font-semibold text-sm text-gray-600 mb-1">Date Joined</h5>
                                    <p id="date-joined" class="text-gray-900 font-medium text-sm"></p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 border-t border-gray-100 flex space-x-4 justify-around">
                            <!-- Check-In QR Code Button -->
                            <button id="checkInBtn"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-2xl shadow-md">
                                Check-In QR Code
                            </button>

                            <!-- Check-Out QR Code Button -->
                            <button id="checkOutBtn"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-2xl shadow-md">
                                Check-Out QR Code
                            </button>

                            <!-- Guest No Show Button -->
                            <button id="noShowBtn"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-2xl shadow-md">
                                Guest No Show
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="qrModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96 text-center relative">
        <span onclick="closeQr()" class="absolute right-4 top-4 text-gray-500 cursor-pointer hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </span>

        <h2 class="text-xl font-semibold mb-4">Scan to check-in</h2>

        <!-- QR Code Image -->
        <div class="flex items-center justify-center mb-4" id="qrCodeContainer">
            <!-- QR code will be generated here -->
        </div>

        <a id="qrLink" href="#" target="_blank" class="text-blue-500 hover:underline">Open Link</a>
    </div>
</div>

<!-- Add Statistics Modal -->
<div id="statsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="min-h-screen px-4 py-8">
        <div class="w-full max-w-7xl mx-auto bg-white shadow-xl rounded-2xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-6 border-b bg-gray-50 rounded-t-2xl">
                <div>
                    <h3 class="text-2xl font-bold" id="modalVenueName"></h3>
                    <p class="text-gray-600 mt-1">Detailed Statistics Overview</p>
                </div>
                <button onclick="closeStatsModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6">
                <!-- Time-based Stats -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold mb-4">Performance Overview</h4>
                    
                    <!-- Time Period Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button onclick="switchTimePeriod('today')"
                                class="time-period-tab border-black text-gray-900 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                Today
                            </button>
                            <button onclick="switchTimePeriod('week')"
                                class="time-period-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                This Week
                            </button>
                            <button onclick="switchTimePeriod('month')"
                                class="time-period-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                This Month
                            </button>
                            <button onclick="switchTimePeriod('year')"
                                class="time-period-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                                This Year
                            </button>
                        </nav>
                    </div>

                    <!-- Stats Content -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Revenue -->
                        <div class="bg-white p-4 rounded-xl border">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-gray-600">Revenue</h5>
                                <span id="time-period-badge" class="px-2 py-1 bg-blue-50 text-blue-600 rounded-full text-xs">Last 24h</span>
                            </div>
                            <p class="text-2xl font-bold" id="period-revenue"></p>
                            <p class="text-sm text-gray-500 mt-1">Total earnings for the period</p>
                        </div>

                        <!-- Bookings -->
                        <div class="bg-white p-4 rounded-xl border">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-gray-600">Bookings</h5>
                            </div>
                            <p class="text-2xl font-bold" id="period-bookings"></p>
                            <p class="text-sm text-gray-500 mt-1">Total bookings for the period</p>
                        </div>

                        <!-- Average Guests -->
                        <div class="bg-white p-4 rounded-xl border">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-medium text-gray-600">Average Guests</h5>
                            </div>
                            <p class="text-2xl font-bold" id="period-guests"></p>
                            <p class="text-sm text-gray-500 mt-1">Average guests per booking</p>
                        </div>
                    </div>
                </div>

                <!-- Key Metrics Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-600">Total Revenue</p>
                        <p class="text-2xl font-bold mt-1" id="totalRevenue"></p>
                        <p class="text-sm text-gray-500 mt-1">Lifetime earnings</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-600">Average Rating</p>
                        <p class="text-2xl font-bold mt-1" id="avgRating"></p>
                        <p class="text-sm text-gray-500 mt-1">Based on all reviews</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-600">Total Bookings</p>
                        <p class="text-2xl font-bold mt-1" id="totalBookings"></p>
                        <p class="text-sm text-gray-500 mt-1">All-time bookings</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-600">Occupancy Rate</p>
                        <p class="text-2xl font-bold mt-1" id="occupancyRate"></p>
                        <p class="text-sm text-gray-500 mt-1">Average occupancy</p>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Revenue Chart -->
                    <div class="bg-white p-4 rounded-xl border">
                        <h4 class="text-lg font-semibold mb-4">Revenue Over Time</h4>
                        <div style="height: 300px; position: relative;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <!-- Bookings Distribution -->
                    <div class="bg-white p-4 rounded-xl border">
                        <h4 class="text-lg font-semibold mb-4">Bookings Distribution</h4>
                        <div style="height: 300px; position: relative;">
                            <canvas id="bookingsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Additional Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h5 class="text-sm text-gray-600 mb-2">Average Booking Duration</h5>
                        <div id="avgDuration"></div>
                        <p class="text-xs text-gray-500 mt-2">Average length of stay per booking</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h5 class="text-sm text-gray-600 mb-2">Most Popular Month</h5>
                        <div id="popularMonth"></div>
                        <p class="text-xs text-gray-500 mt-2">Month with highest booking frequency</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h5 class="text-sm text-gray-600 mb-2">Total Guest Count</h5>
                        <div id="totalGuests"></div>
                        <p class="text-xs text-gray-500 mt-2">Total number of guests hosted</p>
                    </div>
                </div>

                <!-- Booking Status Breakdown -->
                <div class="bg-white p-6 rounded-xl border mb-8">
                    <h4 class="text-lg font-semibold mb-4">Booking Status Breakdown</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="bookingStatusGrid">
                        <!-- Status cards will be populated by JavaScript -->
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="bg-white p-6 rounded-xl border">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold">Recent Reviews</h4>
                        <div class="text-sm text-gray-500" id="reviewCount"></div>
                    </div>
                    <div id="reviewsList" class="space-y-4">
                        <!-- Reviews will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Chart.js and Statistics Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function closeQr() {
        const qrModal = document.getElementById('qrModal');
        qrModal.classList.remove('flex');
        qrModal.classList.add('hidden');
    }

    function showDetails(booking) {
        const modal = document.getElementById('details-modal');

        console.log(booking);


        const checkInBtn = document.getElementById('checkInBtn');
        checkInBtn.onclick = () => {
            const qrModal = document.getElementById('qrModal');
            qrModal.classList.remove('hidden');
            qrModal.classList.add('flex');
            qrModal.classList.add('z-50');

            // Set the check-in link for the QR code
            const checkLink = booking.check_in_link;
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
            const checkLink = booking.check_out_link;
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



        // Set maile with fallback
        document.getElementById('maile').innerHTML = booking.guest_email && booking.guest_email.trim() !== ""
            ? booking.guest_email
            : 'No email provided';

        // Set xes with fallback
        document.getElementById('xes').innerHTML = booking.guest_sex_id === 1
            ? 'Male'
            : (booking.guest_sex_id === 2 ? 'Female' : 'Not specified');

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
        document.getElementById('venue-capacity').textContent = `${booking.capacity || 3} guests`;
        const amenitiesList = document.getElementById('amenities-list');
        const amenities = JSON.parse(booking.amenities); // Parse the JSON string first
        amenitiesList.innerHTML = amenities.map(amenity => `<li>${amenity}</li>`).join('');

        // Set rules
        const rulesList = document.getElementById('venue-rules');
        const rules = JSON.parse(booking.rules); // Parse the JSON string first
        rulesList.innerHTML = rules.map(rule => `<li>${rule}</li>`).join('');

        // Set booking details
        document.getElementById('booking-duration').textContent = `${booking.booking_duration} day/s`;
        document.getElementById('start-date').textContent = new Date(booking.booking_start_date).toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });
        document.getElementById('end-date').textContent = new Date(booking.booking_end_date).toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });
        document.getElementById('request').textContent = booking.booking_request;
        document.getElementById('attendees').textContent = booking.booking_participants;
        document.getElementById('mode-of-payment').textContent = booking.booking_payment_method;
        document.getElementById('raw-cost').textContent = `₱${numberWithCommas(booking.booking_original_price)}`;
        document.getElementById('total-cost').textContent = `₱${numberWithCommas(parseFloat(booking.booking_grand_total) + parseFloat(booking.booking_balance))}`;
        document.getElementById('payment').textContent = `₱${numberWithCommas(booking.booking_grand_total)}`;
        document.getElementById('balance').textContent = `₱${numberWithCommas(booking.booking_balance)}`;
        document.getElementById('reservation-date').textContent = new Date(booking.created_at).toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });

        // Set discount details
        const discount = document.getElementById('discount');
        let discountText = booking.is_discounted == 0 ? '' : 'PWD/Senior Citizen Discount';
        let platformDiscount = '';
        switch (booking.booking_discount) {
            case 'SAVE30':
                platformDiscount = '30% Platform Discount';
                break;
            case 'SAVE20':
                platformDiscount = '20% Platform Discount';
                break;
            case 'SAVE10':
                platformDiscount = '10% Platform Discount';
                break;
            default:
                platformDiscount = '';
                break;
        }
        discount.textContent = `${discountText} ${platformDiscount}`;
        document.getElementById('name').textContent = `${booking.guest_firstname} ${booking.guest_lastname}`;

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
        // Hide all tab contents
        var tabContents = document.getElementsByClassName('tab-content');
        for (var i = 0; i < tabContents.length; i++) {
            tabContents[i].classList.add('hidden');
        }
        
        // Show selected tab content
        var selectedTab = document.getElementById(tabName + '-content');
        if (selectedTab) {
            selectedTab.classList.remove('hidden');
        }

        // Update tab button styles
        var tabButtons = document.getElementsByClassName('tab-links');
        for (var i = 0; i < tabButtons.length; i++) {
            tabButtons[i].classList.remove('border-black', 'text-gray-900');
            tabButtons[i].classList.add('border-transparent', 'text-gray-500');
        }

        // Add active styles to clicked tab
        event.currentTarget.classList.remove('border-transparent', 'text-gray-500');
        event.currentTarget.classList.add('border-black', 'text-gray-900');
    }

    // Set default tab to 'pending' when page loads
    document.addEventListener('DOMContentLoaded', function() {
        var firstTab = document.querySelector('.tab-links');
        if (firstTab) {
            firstTab.click();
        }
    });

    let revenueChart = null;
    let bookingsChart = null;
    let currentStats = null;

    function switchTimePeriod(period) {
        // Update tab styles
        const tabs = document.querySelectorAll('.time-period-tab');
        tabs.forEach(tab => {
            tab.classList.remove('border-black', 'text-gray-900');
            tab.classList.add('border-transparent', 'text-gray-500');
        });
        event.currentTarget.classList.remove('border-transparent', 'text-gray-500');
        event.currentTarget.classList.add('border-black', 'text-gray-900');

        // Update badge text
        const badgeText = {
            'today': 'Last 24h',
            'week': 'Last 7d',
            'month': 'Last 30d',
            'year': 'Year to Date'
        };
        document.getElementById('time-period-badge').textContent = badgeText[period];

        // Update stats
        if (currentStats) {
            document.getElementById('period-revenue').textContent = '₱' + numberWithCommas(currentStats[period].revenue);
            document.getElementById('period-bookings').textContent = currentStats[period].bookings;
            document.getElementById('period-guests').textContent = currentStats[period].avg_guests;
        }
    }

    function showVenueDetailStats(venue) {
        const modal = document.getElementById('statsModal');
        modal.classList.remove('hidden');
        document.getElementById('modalVenueName').textContent = venue.name;

        // Store stats for use in tab switching
        currentStats = venue.time_based_stats;
        
        // Initialize with 'today' period
        switchTimePeriod('today');

        // Update Key Metrics
        document.getElementById('totalRevenue').textContent = '₱' + numberWithCommas(venue.total_revenue);
        document.getElementById('avgRating').textContent = venue.average_rating.toFixed(1) + ' ⭐';
        document.getElementById('totalBookings').textContent = venue.total_bookings;
        document.getElementById('occupancyRate').textContent = venue.occupancy_rate.toFixed(1) + '%';

        // Update Booking Status Grid
        const statusColors = {
            pending: 'bg-yellow-100 text-yellow-800',
            confirmed: 'bg-green-100 text-green-800',
            completed: 'bg-blue-100 text-blue-800',
            cancelled: 'bg-red-100 text-red-800'
        };

        document.getElementById('bookingStatusGrid').innerHTML = `
            <div class="p-4 rounded-lg ${statusColors.pending}">
                <p class="text-sm font-medium">Pending</p>
                <p class="text-2xl font-bold">${venue.pending_bookings}</p>
            </div>
            <div class="p-4 rounded-lg ${statusColors.confirmed}">
                <p class="text-sm font-medium">Confirmed</p>
                <p class="text-2xl font-bold">${venue.confirmed_bookings}</p>
            </div>
            <div class="p-4 rounded-lg ${statusColors.completed}">
                <p class="text-sm font-medium">Completed</p>
                <p class="text-2xl font-bold">${venue.completed_bookings}</p>
            </div>
            <div class="p-4 rounded-lg ${statusColors.cancelled}">
                <p class="text-sm font-medium">Cancelled</p>
                <p class="text-2xl font-bold">${venue.cancelled_bookings}</p>
            </div>
        `;

        // Clean up and initialize charts
        if (revenueChart) {
            revenueChart.destroy();
            revenueChart = null;
        }
        if (bookingsChart) {
            bookingsChart.destroy();
            bookingsChart = null;
        }

        // Create new canvas elements
        const revenueCanvas = document.createElement('canvas');
        revenueCanvas.id = 'revenueChart';
        const bookingsCanvas = document.createElement('canvas');
        bookingsCanvas.id = 'bookingsChart';

        // Replace old canvases
        document.querySelector('#revenueChart').replaceWith(revenueCanvas);
        document.querySelector('#bookingsChart').replaceWith(bookingsCanvas);

        // Initialize Revenue Chart
        const revenueCtx = revenueCanvas.getContext('2d');
        revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: venue.revenue_data.labels,
                datasets: [{
                    label: 'Monthly Revenue',
                    data: venue.revenue_data.values,
                    borderColor: '#000000',
                    backgroundColor: 'rgba(0, 0, 0, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => '₱' + numberWithCommas(value)
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: context => '₱' + numberWithCommas(context.raw)
                        }
                    }
                }
            }
        });

        // Initialize Bookings Chart
        const bookingsCtx = bookingsCanvas.getContext('2d');
        bookingsChart = new Chart(bookingsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
                datasets: [{
                    data: [
                        venue.pending_bookings,
                        venue.confirmed_bookings,
                        venue.completed_bookings,
                        venue.cancelled_bookings
                    ],
                    backgroundColor: [
                        '#FCD34D',
                        '#34D399',
                        '#60A5FA',
                        '#F87171'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
        
        // Update additional stats
        document.getElementById('avgDuration').innerHTML = `
            <p class="text-2xl font-bold">${venue.average_duration.toFixed(1)}</p>
            <p class="text-sm text-gray-600">days average</p>
        `;
        document.getElementById('popularMonth').innerHTML = `
            <p class="text-2xl font-bold">${venue.popular_month}</p>
            <p class="text-sm text-gray-600">peak season</p>
        `;
        document.getElementById('totalGuests').innerHTML = `
            <p class="text-2xl font-bold">${numberWithCommas(venue.total_guests)}</p>
            <p class="text-sm text-gray-600">guests served</p>
        `;

        // Update review count
        document.getElementById('reviewCount').textContent = 
            `${venue.recent_reviews.length} most recent reviews`;

        // Populate reviews
        const reviewsList = document.getElementById('reviewsList');
        reviewsList.innerHTML = venue.recent_reviews.map(review => `
            <div class="bg-gray-50 p-4 rounded-xl hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="font-medium text-lg">${review.guest_name}</p>
                        <p class="text-sm text-gray-600">${review.date}</p>
                    </div>
                    <div class="text-yellow-400 text-lg">${'⭐'.repeat(review.rating)}</div>
                </div>
                <p class="text-gray-700 leading-relaxed">${review.review}</p>
            </div>
        `).join('');
    }

    function closeStatsModal() {
        document.getElementById('statsModal').classList.add('hidden');
        currentStats = null;
        // Clean up charts when modal is closed
        if (revenueChart) {
            revenueChart.destroy();
            revenueChart = null;
        }
        if (bookingsChart) {
            bookingsChart.destroy();
            bookingsChart = null;
        }
    }
</script>