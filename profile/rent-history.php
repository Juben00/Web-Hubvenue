<?php
require_once '../classes/venue.class.php';
session_start();
$venueObj = new Venue();

$USER_ID = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$PENDING_BOOKING = 1;
$CURRENT_BOOKING = 2;
$CANCELLED_BOOKING = 3;
$PREVIOUS_BOOKING = 4;

$pendingBooking = $venueObj->getAllBookings($USER_ID, $PENDING_BOOKING);
$currentBooking = $venueObj->getAllBookings($USER_ID, $CURRENT_BOOKING);
$cancelledBooking = $venueObj->getAllBookings($USER_ID, $CANCELLED_BOOKING);
$previousBooking = $venueObj->getAllBookings($USER_ID, $PREVIOUS_BOOKING);

?>
pendingBooking
<main class="max-w-7xl mx-auto py-6 sm:px-6 pt-20 lg:px-8">
    <div class="px-4 sm:px-0">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Your Rent History</h1>
        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button onclick="showTab('pending')"
                    class="tab-btn border-black text-gray-900 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                    Pending Rentals
                </button>
                <button onclick="showTab('current')"
                    class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                    Current Rental
                </button>
                <button onclick="showTab('previous')"
                    class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                    Previous Rentals
                </button>
                <button onclick="showTab('cancelled')"
                    class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                    Cancelled Rentals
                </button>
            </nav>
        </div>

        <!-- Pending Rental Tab -->
        <div id="pending-tab" class="tab-content">
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col gap-2">

                <?php

                if (empty($pendingBooking)) {
                    // Skip rendering if all fields are NULL
                    echo '<p class="p-6 text-center text-gray-600">You do not have any pending bookings.</p>';
                } else {
                    foreach ($pendingBooking as $booking) {
                        $timezone = new DateTimeZone('Asia/Manila');
                        $currentDateTime = new DateTime('now', $timezone);
                        $bookingStartDate = new DateTime($booking['booking_start_date'], $timezone);
                        ?>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($booking['venue_tag_name']) ?>
                                </h2>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 rounded-full text-sm font-medium <?php
                                    switch ($booking['booking_status_id']) {
                                        case '1': // Pending
                                            echo 'bg-yellow-100 text-yellow-800';
                                            break;
                                        case '2': // Approved
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        case '3': // Cancelled
                                            echo 'bg-red-100 text-red-800';
                                            break;
                                        case '4': // Completed
                                            echo 'bg-blue-100 text-blue-800';
                                            break;
                                        default:
                                            echo 'bg-gray-100 text-gray-800';
                                            break;
                                    }
                                    ?>">
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
                                    <?php
                                    if ($bookingStartDate > $currentDateTime): ?>
                                        <span
                                            class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">Upcoming
                                            Booking</span> <!-- Tag for future booking -->
                                    <?php else: ?>
                                        <span
                                            class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">Active
                                            Booking</span> <!-- Tag for started booking -->
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
                                    <p class="text-lg font-medium"><?php echo htmlspecialchars($booking['venue_name']) ?></p>
                                    <p class="text-gray-600 mt-1"><?php echo htmlspecialchars($booking['venue_location']) ?></p>
                                    <p class="text-gray-600 mt-1">
                                        ₱<?php echo number_format(htmlspecialchars($booking['booking_original_price'] ? $booking['booking_original_price'] : 0.0)) ?>
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
                                        <button onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                            class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View
                                            Details</button>
                                        <?php if ($booking['booking_status_id'] == '2' || $booking['booking_status_id'] == '4'): ?>
                                            <button onclick="printReceipt(<?php
                                            echo htmlspecialchars(json_encode([
                                                'booking_id' => $booking['booking_id'] ?? '',
                                                'venue_name' => $booking['venue_name'] ?? '',
                                                'booking_start_date' => $booking['booking_start_date'] ?? '',
                                                'booking_end_date' => $booking['booking_end_date'] ?? '',
                                                'booking_duration' => $booking['booking_duration'] ?? '',
                                                'booking_grand_total' => $booking['booking_grand_total'] ?? '',
                                                'booking_payment_method' => $booking['booking_payment_method'] ?? '',
                                                'booking_payment_reference' => $booking['booking_payment_reference'] ?? '',
                                                'booking_service_fee' => $booking['booking_service_fee'] ?? '',
                                                'venue_location' => $booking['venue_location'] ?? ''
                                            ]), ENT_QUOTES, 'UTF-8');
                                            ?>)" type="button"
                                                class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                <i class="fas fa-print mr-2"></i>Print Receipt
                                            </button>
                                            <button onclick="downloadReceipt(<?php
                                            echo htmlspecialchars(json_encode([
                                                'booking_id' => $booking['booking_id'] ?? '',
                                                'venue_name' => $booking['venue_name'] ?? '',
                                                'booking_start_date' => $booking['booking_start_date'] ?? '',
                                                'booking_end_date' => $booking['booking_end_date'] ?? '',
                                                'booking_duration' => $booking['booking_duration'] ?? '',
                                                'booking_grand_total' => $booking['booking_grand_total'] ?? '',
                                                'booking_payment_method' => $booking['booking_payment_method'] ?? '',
                                                'booking_payment_reference' => $booking['booking_payment_reference'] ?? '',
                                                'booking_service_fee' => $booking['booking_service_fee'] ?? '',
                                                'venue_location' => $booking['venue_location'] ?? ''
                                            ]), ENT_QUOTES, 'UTF-8');
                                            ?>)" type="button"
                                                class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                <i class="fas fa-download mr-2"></i>Download Receipt
                                            </button>
                                        <?php endif; ?>
                                        <?php

                                        if ($bookingStartDate > $currentDateTime):
                                            ?>
                                            <button onclick="cancelBooking(<?php echo htmlspecialchars($booking['booking_id']); ?>)"
                                                class="px-4 py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-50">Cancel
                                                Booking</button>
                                            <?php
                                        endif;
                                        ?>
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

        <!-- Current Rental Tab -->
        <div id="current-tab" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col gap-2">

                <?php
                if (empty($currentBooking)) {
                    // Skip rendering if all fields are NULL
                    echo '<p class="p-6 text-center text-gray-600">You do not have any current bookings.</p>';
                } else {
                    foreach ($currentBooking as $booking) {
                        $timezone = new DateTimeZone('Asia/Manila');
                        $currentDateTime = new DateTime('now', $timezone);
                        $bookingStartDate = new DateTime($booking['booking_start_date'], $timezone);
                        ?>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($booking['venue_tag_name']) ?>
                                </h2>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 rounded-full text-sm font-medium <?php
                                    switch ($booking['booking_status_id']) {
                                        case '1': // Pending
                                            echo 'bg-yellow-100 text-yellow-800';
                                            break;
                                        case '2': // Approved
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        case '3': // Cancelled
                                            echo 'bg-red-100 text-red-800';
                                            break;
                                        case '4': // Completed
                                            echo 'bg-blue-100 text-blue-800';
                                            break;
                                        default:
                                            echo 'bg-gray-100 text-gray-800';
                                            break;
                                    }
                                    ?>">
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
                                    <?php
                                    if ($bookingStartDate > $currentDateTime): ?>
                                        <span
                                            class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">Upcoming
                                            Booking</span> <!-- Tag for future booking -->
                                    <?php else: ?>
                                        <span
                                            class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">Active
                                            Booking</span> <!-- Tag for started booking -->
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
                                    <p class="text-lg font-medium"><?php echo htmlspecialchars($booking['venue_name']) ?></p>
                                    <p class="text-gray-600 mt-1"><?php echo htmlspecialchars($booking['venue_location']) ?></p>
                                    <p class="text-gray-600 mt-1">
                                        ₱<?php echo number_format(htmlspecialchars($booking['booking_original_price'] ? $booking['booking_original_price'] : 0.0)) ?>
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
                                        <button onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                            class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">View
                                            Details</button>
                                        <?php if ($booking['booking_status_id'] == '2' || $booking['booking_status_id'] == '4'): ?>
                                            <button onclick="printReceipt(<?php
                                            echo htmlspecialchars(json_encode([
                                                'booking_id' => $booking['booking_id'] ?? '',
                                                'venue_name' => $booking['venue_name'] ?? '',
                                                'booking_start_date' => $booking['booking_start_date'] ?? '',
                                                'booking_end_date' => $booking['booking_end_date'] ?? '',
                                                'booking_duration' => $booking['booking_duration'] ?? '',
                                                'booking_grand_total' => $booking['booking_grand_total'] ?? '',
                                                'booking_payment_method' => $booking['booking_payment_method'] ?? '',
                                                'booking_payment_reference' => $booking['booking_payment_reference'] ?? '',
                                                'booking_service_fee' => $booking['booking_service_fee'] ?? '',
                                                'venue_location' => $booking['venue_location'] ?? ''
                                            ]), ENT_QUOTES, 'UTF-8');
                                            ?>)" type="button"
                                                class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                <i class="fas fa-print mr-2"></i>Print Receipt
                                            </button>
                                            <button onclick="downloadReceipt(<?php
                                            echo htmlspecialchars(json_encode([
                                                'booking_id' => $booking['booking_id'] ?? '',
                                                'venue_name' => $booking['venue_name'] ?? '',
                                                'booking_start_date' => $booking['booking_start_date'] ?? '',
                                                'booking_end_date' => $booking['booking_end_date'] ?? '',
                                                'booking_duration' => $booking['booking_duration'] ?? '',
                                                'booking_grand_total' => $booking['booking_grand_total'] ?? '',
                                                'booking_payment_method' => $booking['booking_payment_method'] ?? '',
                                                'booking_payment_reference' => $booking['booking_payment_reference'] ?? '',
                                                'booking_service_fee' => $booking['booking_service_fee'] ?? '',
                                                'venue_location' => $booking['venue_location'] ?? ''
                                            ]), ENT_QUOTES, 'UTF-8');
                                            ?>)" type="button"
                                                class="px-4 py-2 border border-black text-black rounded-lg hover:bg-gray-100">
                                                <i class="fas fa-download mr-2"></i>Download Receipt
                                            </button>
                                        <?php endif; ?>
                                        <?php

                                        if ($bookingStartDate > $currentDateTime):
                                            ?>
                                            <button onclick="cancelBooking(<?php echo htmlspecialchars($booking['booking_id']); ?>)"
                                                class="px-4 py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-50">Cancel
                                                Booking</button>
                                            <?php
                                        endif;
                                        ?>
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
        <!-- Previous Rentals Tab -->
        <div id="previous-tab" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <?php

                if (empty($previousBooking)) {
                    // Skip rendering if all fields are NULL
                    echo '<p class="p-6 text-center text-gray-600">You do not have any previous bookings.</p>';
                } else {
                    foreach ($previousBooking as $booking) {
                        $timezone = new DateTimeZone('Asia/Manila');
                        $currentDateTime = new DateTime('now', $timezone);
                        $bookingStartDate = new DateTime($booking['booking_start_date'], $timezone);
                        ?>
                        <div class="p-6">
                            <div class="space-y-6">
                                <div class="flex flex-col md:flex-row gap-6 border-b pb-6">
                                    <?php
                                    $imageUrls = !empty($booking['image_urls']) ? explode(',', $booking['image_urls']) : [];
                                    ?>

                                    <?php if (!empty($imageUrls)): ?>
                                        <img src="./<?= htmlspecialchars($imageUrls[0]) ?>"
                                            alt="<?= htmlspecialchars($booking['venue_name']) ?>"
                                            class="w-28 h-28 object-cover rounded-lg">
                                    <?php endif; ?>
                                    <div>
                                        <p class="text-lg font-medium"><?php echo htmlspecialchars($booking['venue_name']) ?>
                                        </p>
                                        <p class="text-gray-600 mt-2"><?php
                                        $startDate = new DateTime($booking['booking_start_date']);
                                        $endDate = new DateTime($booking['booking_end_date']);
                                        echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                        ?></p>
                                        <p class="text-gray-600">
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_original_price'] ? $booking['booking_original_price'] : 0.0)) ?>
                                            for
                                            <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                            days
                                        </p>
                                        <div class="mt-4 ">
                                            <div class="flex flex-row">
                                                <form id="reviewForm">
                                                    <div class="flex items-center mb-3">
                                                        <div class="flex items-center space-x-1">
                                                            <input type="number" class="hidden" name="venueId"
                                                                value="<?php echo htmlspecialchars($booking['venue_id']) ?>">
                                                            <label onclick="rate(1)" for="one"
                                                                class="text-2xl text-gray-300 hover:text-yellow-400 star"
                                                                data-rating="1">
                                                                <input type="radio" name="ratings" value="1" class="hidden"
                                                                    id="one">★</label>
                                                            <label onclick="rate(2)" for="two"
                                                                class="text-2xl text-gray-300 hover:text-yellow-400 star"
                                                                data-rating="2">
                                                                <input type="radio" name="ratings" value="2" class="hidden"
                                                                    id="two">★</label>
                                                            <label onclick="rate(3)" for="three"
                                                                class="text-2xl text-gray-300 hover:text-yellow-400 star"
                                                                data-rating="3">
                                                                <input type="radio" name="ratings" value="3" class="hidden"
                                                                    id="three">★</label>
                                                            <label onclick="rate(4)" for="four"
                                                                class="text-2xl text-gray-300 hover:text-yellow-400 star"
                                                                data-rating="4">
                                                                <input type="radio" name="ratings" value="4" class="hidden"
                                                                    id="four">★</label>
                                                            <label onclick="rate(5)" for="five"
                                                                class="text-2xl text-gray-300 hover:text-yellow-400 star"
                                                                data-rating="5">
                                                                <input type="radio" name="ratings" value="5" class="hidden"
                                                                    id="five">★</label>
                                                        </div>
                                                        <span class="ml-2 text-sm text-gray-600">Rate your stay</span>
                                                    </div>
                                                    <div class="mb-4">
                                                        <textarea id="review-text" name="review-text"
                                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                                            rows="3" placeholder="Share your experience (optional)"></textarea>
                                                    </div>
                                                    <div class="flex space-x-4">
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
                                                            Submit Review
                                                        </button>
                                                        <button
                                                            onclick="showDetails(<?php echo htmlspecialchars(json_encode($booking)); ?>)"
                                                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">View
                                                            Details</button>
                                                        <button id="bookAgainBtn"
                                                            data-bvid="<?php echo htmlspecialchars($booking['venue_id']); ?>"
                                                            class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
                                                            Book Again
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
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
        <!-- Cancelled Rentals Tab -->
        <div id="cancelled-tab" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <?php
                if (empty($cancelledBooking)) {
                    echo '<p class="p-6 text-center text-gray-600">You do not have any cancelled bookings.</p>';
                } else {
                    foreach ($cancelledBooking as $booking) {
                        $timezone = new DateTimeZone('Asia/Manila');
                        $currentDateTime = new DateTime('now', $timezone);
                        $bookingStartDate = new DateTime($booking['booking_start_date'], $timezone);
                        ?>
                        <div class="p-6">
                            <div class="space-y-6">
                                <div class="flex flex-col md:flex-row gap-6 border-b pb-6">
                                    <?php
                                    $imageUrls = !empty($booking['image_urls']) ? explode(',', $booking['image_urls']) : [];
                                    ?>

                                    <?php if (!empty($imageUrls)): ?>
                                        <img src="./<?= htmlspecialchars($imageUrls[0]) ?>"
                                            alt="<?= htmlspecialchars($booking['venue_name']) ?>"
                                            class="w-28 h-28 object-cover rounded-lg">
                                    <?php endif; ?>
                                    <div>
                                        <p class="text-lg font-medium">
                                            <?php echo htmlspecialchars($booking['venue_name']) ?>
                                        </p>
                                        <p class="text-gray-600 mt-2"><?php
                                        $startDate = new DateTime($booking['booking_start_date']);
                                        $endDate = new DateTime($booking['booking_end_date']);
                                        echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                        ?></p>
                                        <p class="text-gray-600">
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_original_price'] ? $booking['booking_original_price'] : 0.0)) ?>
                                            for
                                            <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                            days
                                        </p>


                                        <h4 class="text-gray-600">Reason:
                                            <?php echo htmlspecialchars($booking['booking_cancellation_reason']) ?>
                                        </h4>


                                        <div class="mt-4">
                                            <button id="bookAgainBtn"
                                                data-bvid="<?php echo htmlspecialchars($booking['venue_id']); ?>"
                                                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
                                                Book Again
                                            </button>
                                        </div>
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
        <!-- Details Modal -->
        <div id="details-modal"
            class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-300 ease-out opacity-0">
            <div
                class="relative top-20 mx-auto p-8 border w-full max-w-4xl shadow-lg rounded-2xl bg-white transition-all duration-300 transform scale-95 mb-20">
                <!-- Modal Header -->
                <div class="flex justify-between items-center pb-6 border-b">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900" id="modal-title"></h3>
                        <p class="text-sm text-gray-500 mt-1">Booking Details</p>
                    </div>
                    <button onclick="closeModal()"
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-2 rounded-full hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div id="modal-content" class="mt-8">
                    <!-- Main image and details container -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Column - Images -->
                        <div class="space-y-4">
                            <!-- Main Image -->
                            <div class="relative rounded-xl overflow-hidden bg-gray-100 aspect-[4/3]">
                                <img id="modal-main-image" src="" alt="Venue Main Image"
                                    class="w-full h-full object-cover transition-all duration-300">
                            </div>

                            <!-- Image Gallery -->
                            <div class="grid grid-cols-4 gap-2" id="image-gallery">
                                <!-- Thumbnails will be inserted here -->
                            </div>
                        </div>

                        <!-- Right Column - Details -->
                        <div class="space-y-6">
                            <!-- Status Tags -->
                            <div class="flex items-center gap-3">
                                <span id="booking-status" class="px-3 py-1 rounded-full text-sm font-medium"></span>
                                <span id="booking-type" class="px-3 py-1 rounded-full text-sm font-medium"></span>
                            </div>

                            <!-- Price Details -->
                            <div class="bg-gray-50 p-6 rounded-xl space-y-3">
                                <h4 class="font-semibold text-gray-900">Price Details</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Total Amount</span>
                                        <span id="price-per-night" class="text-xl font-bold text-gray-900"></span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm text-gray-600">
                                        <span>Duration</span>
                                        <span id="booking-duration"></span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm text-gray-600">
                                        <span>Cleaning Fee</span>
                                        <span id="cleaning-fee"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Details -->
                            <div class="space-y-2">
                                <h4 class="font-semibold text-gray-900">Location</h4>
                                <div id="location-details" class="text-gray-600 text-sm space-y-1"></div>
                            </div>

                            <!-- Capacity & Amenities -->
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-900">Capacity</h4>
                                    <p id="venue-capacity" class="text-gray-600 text-sm"></p>
                                </div>
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-900">Amenities</h4>
                                    <ul id="amenities-list" class="text-gray-600 text-sm space-y-1"></ul>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="space-y-2">
                                <h4 class="font-semibold text-gray-900">Contact Information</h4>
                                <div id="contact-details" class="text-gray-600 text-sm space-y-1"></div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-3 pt-4">
                                <div id="book-again-container" class="hidden">
                                    <button
                                        class="px-6 py-2.5 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors duration-200">
                                        Book Again
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div id="reviews-section" class="mt-8 pt-6 border-t">
                        <h4 class="font-semibold text-gray-900 mb-4">Reviews</h4>
                        <div id="reviews-container" class="space-y-4">
                            <!-- Reviews will be dynamically loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancellation Modal -->
        <div id="cancellation-modal"
            class="hidden fixed inset-0 bg-black/50 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-all duration-300 ease-out opacity-0">
            <div
                class="relative top-20 mx-auto p-6 border w-full max-w-lg shadow-lg rounded-xl bg-white transition-all duration-300 transform scale-95">
                <!-- Modal Header -->
                <div class="flex justify-between items-center pb-4 border-b">
                    <h3 class="text-xl font-bold">Cancel Booking</h3>
                    <button onclick="closeCancellationModal()"
                        class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div>
                    <h4 class="font-semibold mt-3 mb-3">Cancellation Policy</h4>
                    <div class="space-y-3">
                        <p class="text-gray-700 text-xs">Free cancellation for 48 hours after booking.</p>
                        <p class="text-gray-700 text-xs">Cancel before check-in and get a full refund, minus the
                            service
                            fee.</p>
                        <div class="mt-4">
                            <h5 class="font-medium mb-2">Refund Policy:</h5>
                            <ul class="space-y-2 text-gray-700 text-xs">
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check text-green-600"></i>
                                    <span>100% refund: Cancel 7 days before check-in</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check text-green-600"></i>
                                    <span>50% refund: Cancel 3-7 days before check-in</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-times text-red-600"></i>
                                    <span>No refund: Cancel less than 3 days before check-in</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="mt-4">
                    <form id="cancellation-form">
                        <input type="hidden" id="cancellation-booking-id" name="booking-id">
                        <div class="mb-4">
                            <label for="cancellation-reason" class="block font-medium text-gray-700">Reason for
                                Cancellation</label>
                            <textarea id="cancellation-reason" name="cancellation-reason"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                rows="4" placeholder="Enter your reason for cancellation"></textarea>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="closeCancellationModal()"
                                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
    function showTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        document.getElementById(tabName + '-tab').classList.remove('hidden');

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-black', 'text-gray-900');
            btn.classList.add('border-transparent', 'text-gray-500');
        });

        event.currentTarget.classList.remove('border-transparent', 'text-gray-500');
        event.currentTarget.classList.add('border-black', 'text-gray-900');
    }

    // Set default tab to 'pending'
    document.addEventListener('DOMContentLoaded', function () {
        showTab('pending');
    });

    function showDetails(booking) {
        const modal = document.getElementById('details-modal');
        const bookAgainContainer = document.getElementById('book-again-container');

        // Show modal with fade-in effect
        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            modal.classList.add('opacity-100');
            modal.querySelector('.relative').classList.add('scale-100');
            modal.querySelector('.relative').classList.remove('scale-95');
        });

        // Set main title
        document.getElementById('modal-title').textContent = booking.venue_name;

        // Setup main image and gallery
        const mainImage = document.getElementById('modal-main-image');
        mainImage.src = './' + booking.image_urls.split(',')[booking.thumbnail];
        console.log(mainImage.src);


        // Setup image gallery with thumbnails
        const imageGallery = document.getElementById('image-gallery');
        const imageUrls = booking.image_urls.split(',');
        imageGallery.innerHTML = imageUrls.map(url => `
            <div class="aspect-square rounded-lg overflow-hidden bg-gray-100">
                <img src="./${url}" 
                    alt="Venue Image" 
                    class="w-full h-full object-cover cursor-pointer hover:opacity-75 transition-all duration-200" 
                    onclick="changeMainImage(this.src)">
            </div>
        `).join('');

        // Set booking status and type
        const bookingStatus = document.getElementById('booking-status');
        const statusText = getBookingStatusText(booking.booking_status_id);
        bookingStatus.textContent = statusText;
        bookingStatus.className = `px-3 py-1 rounded-full text-sm font-medium ${getStatusColor(booking.booking_status_id)}`;

        // Set price details
        document.getElementById('price-per-night').textContent = `₱${numberWithCommas(booking.booking_grand_total)}`;
        document.getElementById('booking-duration').textContent = `${booking.booking_duration} days`;
        document.getElementById('cleaning-fee').textContent = `₱500`;

        // Set location details
        const locationDetails = document.getElementById('location-details');
        locationDetails.innerHTML = `
            <p class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                ${booking.venue_location}
            </p>
            <p class="ml-6">Governor Camins Avenue, Zone II</p>
            <p class="ml-6">Baliwasan, Zamboanga City</p>
            <p class="ml-6">Zamboanga Peninsula, 7000</p>
        `;

        // Set capacity and amenities
        document.getElementById('venue-capacity').textContent = `${booking.venue_capacity || 3} guests`;
        const amenitiesList = document.getElementById('amenities-list');
        amenitiesList.innerHTML = `
            <li class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Pool
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                WiFi
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Air-conditioned Room
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Smart TV
            </li>
        `;

        // Set contact details
        const contactDetails = document.getElementById('contact-details');
        contactDetails.innerHTML = `
            <p class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                joevinansoc870@gmail.com
            </p>
            <p class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                09053258512
            </p>
        `;

        // Toggle book again button
        bookAgainContainer.classList.toggle('hidden', booking.booking_status_id === '2');
    }

    // Helper functions
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function getBookingStatusText(statusId) {
        const statuses = {
            '1': 'Pending',
            '2': 'Approved',
            '3': 'Cancelled',
            '4': 'Completed'
        };
        return statuses[statusId] || 'Unknown';
    }

    function getStatusColor(statusId) {
        const colors = {
            '1': 'bg-yellow-100 text-yellow-800',
            '2': 'bg-green-100 text-green-800',
            '3': 'bg-red-100 text-red-800',
            '4': 'bg-blue-100 text-blue-800'
        };
        return colors[statusId] || 'bg-gray-100 text-gray-800';
    }

    // Update close modal function with smooth transition
    function closeModal() {
        const modal = document.getElementById('details-modal');
        modal.classList.remove('opacity-100');
        modal.querySelector('.relative').classList.remove('scale-100');
        modal.querySelector('.relative').classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function changeMainImage(src) {
        const mainImage = document.getElementById('modal-main-image');
        mainImage.style.opacity = '0';
        setTimeout(() => {
            mainImage.src = src;
            mainImage.style.opacity = '1';
        }, 200);
    }

    function cancelBooking(bookingId) {
        document.getElementById('cancellation-booking-id').value = bookingId;
        showCancellationModal();
    }

    function showCancellationModal() {
        const modal = document.getElementById('cancellation-modal');
        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            modal.classList.add('opacity-100');
            modal.querySelector('.relative').classList.add('scale-100');
            modal.querySelector('.relative').classList.remove('scale-95');
        });
    }

    function closeCancellationModal() {
        const modal = document.getElementById('cancellation-modal');
        modal.classList.remove('opacity-100');
        modal.querySelector('.relative').classList.remove('scale-100');
        modal.querySelector('.relative').classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function rate(rating) {
        currentRating = rating;
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }

    window.onclick = function (event) {
        const modal = document.getElementById('details-modal');
        if (event.target === modal) {
            closeModal();
        }
    }

    function printReceipt(bookingData) {
        const receiptWindow = window.open('', '_blank');

        const imageExt = ['jpeg', 'jpg', 'png'];
        let = paymentReferenceTemplate = null;
        if (imageExt.some(ext => bookingData.booking_payment_reference.endsWith(ext))) {
            paymentReferenceTemplate = `<img src="./${bookingData.booking_payment_reference}" alt="Payment Reference" class="w-full h-auto">`;
        } else {
            paymentReferenceTemplate = `<p>${bookingData.booking_payment_reference}</p>`;
        }


        // Add error handling for the window opening
        if (!receiptWindow) {
            alert('Please allow popups to print the receipt');
            return;
        }

        const receiptHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Booking Receipt</title>
                <style>
                    @page {
                        size: A4;
                        margin: 1.5cm;
                    }
                    body {
                        font-family: Arial, sans-serif;
                        max-width: 800px;
                        margin: 0 auto;
                        padding: 20px;
                        color: #333;
                        line-height: 1.6;
                    }
                    .logo {
                        width: 150px;
                        height: auto;
                        margin-bottom: 10px;
                        object-fit: contain;
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 40px;
                        padding-bottom: 20px;
                        border-bottom: 2px solid #e5e5e5;
                    }
                    .header h1 {
                        color: #1a1a1a;
                        margin: 10px 0;
                        font-size: 28px;
                    }
                    .header p {
                        color: #666;
                        font-size: 14px;
                    }
                    .receipt-details {
                        margin-bottom: 30px;
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        gap: 20px;
                    }
                    .receipt-details .section {
                        margin-bottom: 20px;
                    }
                    .receipt-details .section-title {
                        font-weight: bold;
                        color: #1a1a1a;
                        margin-bottom: 10px;
                        font-size: 16px;
                    }
                    .receipt-details .info {
                        background: #f8f8f8;
                        padding: 15px;
                        border-radius: 8px;
                    }
                    .receipt-details .info div {
                        margin-bottom: 8px;
                        font-size: 14px;
                    }
                    .receipt-details .label {
                        color: #666;
                        font-weight: 500;
                    }
                    .total {
                        margin-top: 30px;
                        padding: 20px;
                        background: #f8f8f8;
                        border-radius: 8px;
                    }
                    .total-row {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 10px;
                        font-size: 14px;
                    }
                    .grand-total {
                        margin-top: 15px;
                        padding-top: 15px;
                        border-top: 2px solid #e5e5e5;
                        font-weight: bold;
                        font-size: 16px;
                    }
                    .footer {
                        margin-top: 40px;
                        text-align: center;
                        color: #666;
                        font-size: 12px;
                        padding-top: 20px;
                        border-top: 1px solid #e5e5e5;
                    }
                    @media print {
                        .no-print {
                            display: none;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <img src="./images/white_ico.png" alt="HubVenue Logo" class="logo" 
                         onerror="this.style.display='none'">
                    <h1>Booking Receipt</h1>
                    <p>Thank you for choosing HubVenue!</p>
                </div>
                
                <div class="receipt-details">
                    <div class="section">
                        <div class="section-title">Booking Information</div>
                        <div class="info">
                            <div><span class="label">Booking ID:</span> #${bookingData.booking_id}</div>
                            <div><span class="label">Check-in:</span> ${new Date(bookingData.booking_start_date).toLocaleDateString()}</div>
                            <div><span class="label">Check-out:</span> ${new Date(bookingData.booking_end_date).toLocaleDateString()}</div>
                            <div><span class="label">Duration:</span> ${bookingData.booking_duration} days</div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Venue Details</div>
                        <div class="info">
                            <div><span class="label">Venue Name:</span> ${bookingData.venue_name}</div>
                            <div><span class="label">Location:</span> ${bookingData.venue_location}</div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Payment Details</div>
                        <div class="info">
                            <div>
                            <span class="label">Payment Method:</span> ${bookingData.booking_payment_method}
                            </div>
                            <div class="flex flex-col gap-2 items-start">
                            <span class="label">Reference Number:</span> 
                            <div>${paymentReferenceTemplate}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="total">
                    <div class="total-row">
                        <span>Service Fee</span>
                        <span>₱${parseFloat(bookingData.booking_service_fee).toFixed(2)}</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total Amount</span>
                        <span>₱${parseFloat(bookingData.booking_grand_total).toFixed(2)}</span>
                    </div>
                </div>

                <div class="footer">
                    <p>This is an electronically generated receipt. For questions or concerns, please contact our support team.</p>
                    <p>© ${new Date().getFullYear()} HubVenue. All rights reserved.</p>
                </div>
            </body>
            </html>
        `;

        receiptWindow.document.write(receiptHTML);
        receiptWindow.document.close();

        // Add error handling for printing
        receiptWindow.onload = function () {
            try {
                receiptWindow.print();
                receiptWindow.onafterprint = function () {
                    receiptWindow.close();
                };
            } catch (error) {
                console.error('Printing failed:', error);
                alert('There was an error printing the receipt. Please try again.');
                receiptWindow.close();
            }
        };

        // Add error handler for load failures
        receiptWindow.onerror = function () {
            alert('There was an error generating the receipt. Please try again.');
            receiptWindow.close();
        };
    }

    function downloadReceipt(bookingData) {
        // Create the receipt HTML (reuse the same template as printReceipt)
        const receiptHTML = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Booking Receipt</title>
                <style>
                    @page {
                        size: A4;
                        margin: 1.5cm;
                    }
                    body {
                        font-family: Arial, sans-serif;
                        max-width: 800px;
                        margin: 0 auto;
                        padding: 20px;
                        color: #333;
                        line-height: 1.6;
                    }
                    .logo {
                        width: 150px;
                        height: auto;
                        margin-bottom: 10px;
                        object-fit: contain;
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 40px;
                        padding-bottom: 20px;
                        border-bottom: 2px solid #e5e5e5;
                    }
                    .header h1 {
                        color: #1a1a1a;
                        margin: 10px 0;
                        font-size: 28px;
                    }
                    .header p {
                        color: #666;
                        font-size: 14px;
                    }
                    .receipt-details {
                        margin-bottom: 30px;
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        gap: 20px;
                    }
                    .receipt-details .section {
                        margin-bottom: 20px;
                    }
                    .receipt-details .section-title {
                        font-weight: bold;
                        color: #1a1a1a;
                        margin-bottom: 10px;
                        font-size: 16px;
                    }
                    .receipt-details .info {
                        background: #f8f8f8;
                        padding: 15px;
                        border-radius: 8px;
                    }
                    .receipt-details .info div {
                        margin-bottom: 8px;
                        font-size: 14px;
                    }
                    .receipt-details .label {
                        color: #666;
                        font-weight: 500;
                    }
                    .total {
                        margin-top: 30px;
                        padding: 20px;
                        background: #f8f8f8;
                        border-radius: 8px;
                    }
                    .total-row {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 10px;
                        font-size: 14px;
                    }
                    .grand-total {
                        margin-top: 15px;
                        padding-top: 15px;
                        border-top: 2px solid #e5e5e5;
                        font-weight: bold;
                        font-size: 16px;
                    }
                    .footer {
                        margin-top: 40px;
                        text-align: center;
                        color: #666;
                        font-size: 12px;
                        padding-top: 20px;
                        border-top: 1px solid #e5e5e5;
                    }
                    @media print {
                        .no-print {
                            display: none;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <img src="./images/white_ico.png" alt="HubVenue Logo" class="logo" 
                         onerror="this.style.display='none'">
                    <h1>Booking Receipt</h1>
                    <p>Thank you for choosing HubVenue!</p>
                </div>
                
                <div class="receipt-details">
                    <div class="section">
                        <div class="section-title">Booking Information</div>
                        <div class="info">
                            <div><span class="label">Booking ID:</span> #${bookingData.booking_id}</div>
                            <div><span class="label">Check-in:</span> ${new Date(bookingData.booking_start_date).toLocaleDateString()}</div>
                            <div><span class="label">Check-out:</span> ${new Date(bookingData.booking_end_date).toLocaleDateString()}</div>
                            <div><span class="label">Duration:</span> ${bookingData.booking_duration} days</div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Venue Details</div>
                        <div class="info">
                            <div><span class="label">Venue Name:</span> ${bookingData.venue_name}</div>
                            <div><span class="label">Location:</span> ${bookingData.venue_location}</div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">Payment Details</div>
                        <div class="info">
                            <div><span class="label">Payment Method:</span> ${bookingData.booking_payment_method}</div>
                            <div><span class="label">Reference Number:</span> ${bookingData.booking_payment_reference}</div>
                        </div>
                    </div>
                </div>

                <div class="total">
                    <div class="total-row">
                        <span>Service Fee</span>
                        <span>₱${parseFloat(bookingData.booking_service_fee).toFixed(2)}</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total Amount</span>
                        <span>₱${parseFloat(bookingData.booking_grand_total).toFixed(2)}</span>
                    </div>
                </div>

                <div class="footer">
                    <p>This is an electronically generated receipt. For questions or concerns, please contact our support team.</p>
                    <p>© ${new Date().getFullYear()} HubVenue. All rights reserved.</p>
                </div>
            </body>
            </html>
        `;

        // Create a Blob from the HTML content
        const blob = new Blob([receiptHTML], { type: 'text/html' });

        // Create a temporary link element
        const downloadLink = document.createElement('a');
        downloadLink.href = URL.createObjectURL(blob);
        downloadLink.download = `receipt-${bookingData.booking_id}.html`;

        // Append link to body, click it, and remove it
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);

        // Clean up the URL object
        URL.revokeObjectURL(downloadLink.href);
    }
</script>

<style>
    /* Add these styles for smooth transitions */
    .modal-transition {
        transition: all 0.3s ease-out;
    }

    .modal-content-transition {
        transition: transform 0.3s ease-out;
    }

    #modal-main-image {
        transition: opacity 0.2s ease-in-out;
    }

    /* Image gallery hover effects */
    #image-gallery img {
        transition: transform 0.2s ease-in-out;
    }

    #image-gallery img:hover {
        transform: scale(1.05);
    }

    /* Status badge styles */
    .status-badge {
        transition: background-color 0.2s ease-in-out;
    }

    /* Button hover effects */
    button {
        transition: all 0.2s ease-in-out;
    }

    /* Add smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
</style>