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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showDetails(booking) {
        const modal = document.getElementById('details-modal');

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


        // Calculate and set age
        const birthDate = new Date(booking.birthdate);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        document.getElementById('age').textContent = isNaN(age) ? 'Unknown' : age;

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
</script>