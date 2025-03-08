<?php
require_once '../classes/venue.class.php';

session_start();

$venueObj = new Venue();

$USER_ID = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$venueStats = $venueObj->getAllVenuesWithStats($USER_ID);
?>

<main class="max-w-7xl mx-auto py-6 pt-20 sm:px-6 lg:px-8">
    <div class="px-4 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Venue Statistics</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($venueStats as $venue):
                var_dump($venue);
                ?>
                <!-- <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition duration-300">
                    <!-- Venue Image -->
                <div class="relative h-48">
                    <img src="./<?php echo !empty($venue['image_urls']) ? $venue['image_urls'][$venue['thumbnail']] : '../images/black_ico.png'; ?>"
                        alt="<?php echo htmlspecialchars($venue['name']); ?>" class="w-full h-full object-cover">
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
                            <p class="text-lg font-semibold"><?php echo number_format($venue['occupancy_rate'], 1); ?>%
                            </p>
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
</main>

<!-- Detailed Statistics Modal -->
<div id="statsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="min-h-screen px-4 text-center">
        <div
            class="inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-2xl font-bold" id="modalVenueName"></h3>
                <button onclick="closeStatsModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6">
                <!-- Revenue Chart -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold mb-4">Revenue Over Time</h4>
                    <canvas id="revenueChart" class="w-full h-64"></canvas>
                </div>

                <!-- Bookings Chart -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold mb-4">Bookings Distribution</h4>
                    <canvas id="bookingsChart" class="w-full h-64"></canvas>
                </div>

                <!-- Reviews Section -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold mb-4">Recent Reviews</h4>
                    <div id="reviewsList" class="space-y-4">
                        <!-- Reviews will be populated here -->
                    </div>
                </div>

                <!-- Additional Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="text-sm text-gray-600 mb-1">Average Booking Duration</h5>
                        <p class="text-xl font-semibold" id="avgDuration"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="text-sm text-gray-600 mb-1">Most Popular Month</h5>
                        <p class="text-xl font-semibold" id="popularMonth"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="text-sm text-gray-600 mb-1">Total Guest Count</h5>
                        <p class="text-xl font-semibold" id="totalGuests"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let revenueChart = null;
    let bookingsChart = null;

    function showVenueDetailStats(venue) {
        const modal = document.getElementById('statsModal');
        modal.classList.remove('hidden');
        document.getElementById('modalVenueName').textContent = venue.name;

        // Initialize or update charts
        initializeCharts(venue);

        // Update additional stats
        document.getElementById('avgDuration').textContent = venue.average_duration + ' days';
        document.getElementById('popularMonth').textContent = venue.popular_month;
        document.getElementById('totalGuests').textContent = venue.total_guests;

        // Populate reviews
        const reviewsList = document.getElementById('reviewsList');
        reviewsList.innerHTML = venue.recent_reviews.map(review => `
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-medium">${review.guest_name}</p>
                    <p class="text-sm text-gray-600">${review.date}</p>
                </div>
                <div class="text-yellow-400">${'⭐'.repeat(review.rating)}</div>
            </div>
            <p class="mt-2">${review.review}</p>
        </div>
    `).join('');
    }

    function closeStatsModal() {
        document.getElementById('statsModal').classList.add('hidden');
        if (revenueChart) revenueChart.destroy();
        if (bookingsChart) bookingsChart.destroy();
    }

    function initializeCharts(venue) {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        if (revenueChart) revenueChart.destroy();
        revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: venue.revenue_data.labels,
                datasets: [{
                    label: 'Monthly Revenue',
                    data: venue.revenue_data.values,
                    borderColor: 'rgb(0, 0, 0)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Bookings Distribution Chart
        const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
        if (bookingsChart) bookingsChart.destroy();
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
                maintainAspectRatio: false
            }
        });
    }
</script> -->