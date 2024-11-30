<?php
require_once '../classes/venue.class.php';
session_start();
$venueObj = new Venue();

$currentBooking = $venueObj->getAllBookings($_SESSION['user']['id'], 2);
$previousBooking = $venueObj->getAllBookings($_SESSION['user']['id'], 4);
?>

<main class="max-w-7xl mx-auto py-6 sm:px-6 pt-20 lg:px-8">
    <div class="px-4 sm:px-0">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Your Rent History</h1>

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button onclick="showTab('current')"
                    class="tab-btn border-black text-gray-900 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                    Current Rental
                </button>
                <button onclick="showTab('previous')"
                    class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                    Previous Rentals
                </button>
            </nav>
        </div>

        <!-- Current Rental Tab -->
        <div id="current-tab" class="tab-content">
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col gap-2">

                <?php

                // var_dump($_SESSION['user']['id']);
                // var_dump($currentBooking);
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
                                    <?php
                                    if ($bookingStartDate > $currentDateTime): ?>
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Upcoming
                                            Booking</span> <!-- Tag for future booking -->
                                    <?php else: ?>
                                        <span class="px-2 py-1 bg-green-100 text-blue-800 rounded-full text-sm font-medium">Active
                                            Booking</span> <!-- Tag for started booking -->
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row gap-6">
                                <?php
                                $imageUrls = !empty($booking['image_urls']) ? explode(',', $booking['image_urls']) : [];
                                ?>

                                <?php if (!empty($imageUrls)): ?>
                                    <img src="./<?= htmlspecialchars($imageUrls[0]) ?>"
                                        alt="<?= htmlspecialchars($booking['venue_name']) ?>"
                                        class="w-full md:w-40 h-40 object-cover rounded-lg">
                                <?php endif; ?>

                                <div>
                                    <p class="text-lg font-medium"><?php echo htmlspecialchars($booking['venue_name']) ?></p>
                                    <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($booking['venue_location']) ?></p>
                                    <p class="text-gray-600 mt-2">
                                        ₱<?php echo number_format(htmlspecialchars($booking['booking_grand_total'] ? $booking['booking_grand_total'] : 0.0)) ?>
                                        for
                                        <?php echo number_format(htmlspecialchars($booking['booking_duration'] ? $booking['booking_duration'] : 0.0)) ?>
                                        days
                                    </p>
                                    <p class="text-gray-600 mt-2">
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
                                        <?php

                                        if ($bookingStartDate > $currentDateTime):
                                            ?>
                                            <button onclick="cancelBooking()"
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
                // var_dump($previousBooking);
                
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
                                            class="w-full md:w-40 h-40 object-cover rounded-lg">
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
                                            ₱<?php echo number_format(htmlspecialchars($booking['booking_grand_total'] ? $booking['booking_grand_total'] : 0.0)) ?>
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

        <!-- Details Modal -->
        <div id="details-modal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center pb-3">
                    <h3 class="text-2xl font-bold" id="modal-title">Venue Details</h3>
                    <button onclick="closeModal()" class="text-black close-modal">&times;</button>
                </div>
                <div id="modal-content" class="mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <img id="modal-main-image" src="./images/black_ico.png" alt="Venue Main Image"
                                    class="w-full h-64 object-cover rounded-lg">
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <img src="./images/black_ico.png" alt="Venue Image 1"
                                    class="w-full h-20 object-cover rounded-lg cursor-pointer"
                                    onclick="changeMainImage(this.src)">
                                <img src="./images/black_ico.png" alt="Venue Image 2"
                                    class="w-full h-20 object-cover rounded-lg cursor-pointer"
                                    onclick="changeMainImage(this.src)">
                                <img src="./images/black_ico.png" alt="Venue Image 3"
                                    class="w-full h-20 object-cover rounded-lg cursor-pointer"
                                    onclick="changeMainImage(this.src)">
                            </div>
                            <h4 class="font-semibold mt-4 mb-2">Venue Capacity</h4>
                            <p>3 guests</p>

                            <h4 class="font-semibold mt-4 mb-2">What this place offers</h4>
                            <ul class="space-y-2">
                                <li>Pool</li>
                                <li>WiFi</li>
                                <li>Air-conditioned Room</li>
                                <li>Smart TV</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">Location</h4>
                            <p>Garden Orchid Hotel and Resort Corporation</p>
                            <p>Governor Camins Avenue, Zone II</p>
                            <p>Baliwasan, Zamboanga City</p>
                            <p>Zamboanga Peninsula, 7000</p>

                            <h4 class="font-semibold mt-4 mb-2">Price Details</h4>
                            <p>₱4,800.00 per night</p>
                            <p>Cleaning fee: ₱500</p>
                            <p>Service fee applies</p>

                            <h4 class="font-semibold mt-4 mb-2">Contact Information</h4>
                            <p>Email: joevinansoc870@gmail.com</p>
                            <p>Phone: 09053258512</p>

                            <div id="book-again-container" class="mt-6 hidden">
                                <button class="w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">Book
                                    Again</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="reviews-section" class="mt-6 border-t pt-6">
                    <h4 class="font-semibold mb-4">Reviews</h4>
                    <div id="reviews-container" class="space-y-4">
                        <!-- Reviews will be dynamically loaded here -->
                    </div>
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

    function showDetails(booking) {
        const modal = document.getElementById('details-modal');
        const bookAgainContainer = document.getElementById('book-again-container');
        modal.classList.remove('hidden');

        document.getElementById('modal-title').textContent = booking.venue_name;
        document.getElementById('modal-main-image').src = './' + booking.image_urls.split(',')[0];

        const imageUrls = booking.image_urls.split(',');
        const imageElements = imageUrls.map(url => `
            <img src="./${url}" alt="Venue Image" class="w-full h-20 object-cover rounded-lg cursor-pointer" onclick="changeMainImage(this.src)">
        `).join('');
        document.querySelector('#modal-content .grid-cols-3').innerHTML = imageElements;

        document.querySelector('#modal-content .grid-cols-1').innerHTML = `
            <h4 class="font-semibold mt-4 mb-2">Venue Capacity</h4>
            <p>${booking.venue_capacity} guests</p>
            <h4 class="font-semibold mt-4 mb-2">What this place offers</h4>
            <ul class="space-y-2">
                ${booking.venue_amenities.split(',').map(amenity => `<li>${amenity}</li>`).join('')}
            </ul>
        `;

        document.querySelector('#modal-content .grid-cols-2').innerHTML = `
            <h4 class="font-semibold mb-2">Location</h4>
            <p>${booking.venue_location}</p>
            <h4 class="font-semibold mt-4 mb-2">Price Details</h4>
            <p>₱${booking.booking_grand_total} for ${booking.booking_duration} days</p>
            <h4 class="font-semibold mt-4 mb-2">Contact Information</h4>
            <p>Email: ${booking.contact_email}</p>
            <p>Phone: ${booking.contact_phone}</p>
        `;

        if (booking.booking_status_id === '2') {
            bookAgainContainer.classList.add('hidden');
        } else {
            bookAgainContainer.classList.remove('hidden');
        }
    }

    function closeModal() {
        document.getElementById('details-modal').classList.add('hidden');
    }

    function changeMainImage(src) {
        document.getElementById('modal-main-image').src = src;
    }

    function cancelBooking() {
        if (confirm('Are you sure you want to proceed to cancel this booking?')) {
            // Redirect to the cancellation page
            window.location.href = '../web-hubvenue/cancelation.php';
        }
    }

    let currentRating = 0;

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
</script>