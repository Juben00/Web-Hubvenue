<?php
session_start();
require_once __DIR__ . '/classes/venue.class.php';
require_once __DIR__ . '/classes/account.class.php';

// Initialize objects
$venueObj = new Venue();
$accountObj = new Account();

// Get user ID from session
$USER_ID = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// Redirect if not logged in or not a host
if (!$USER_ID) {
    header("Location: login.php");
    exit();
}

$user = $accountObj->getUser($USER_ID);
if ($user['user_type_id'] != 1) { // 1 is for host type
    header("Location: index.php");
    exit();
}

// Get dashboard data
$stats = $venueObj->getDashboardStats($USER_ID);
$venues = $venueObj->getAllVenuesWithStats($USER_ID);
$monthlyRevenue = $venueObj->getMonthlyRevenue($USER_ID);
$bookingStats = $venueObj->getBookingStatusStats($USER_ID);
$calendarEvents = $venueObj->getVenueCalendarEvents($USER_ID);

// Format data for charts
$revenueLabels = [];
$revenueData = [];
foreach ($monthlyRevenue as $data) {
    $revenueLabels[] = date('M Y', strtotime($data['month']));
    $revenueData[] = $data['revenue'];
}

$bookingLabels = [];
$bookingData = [];
foreach ($bookingStats as $stat) {
    $bookingLabels[] = $stat['status'];
    $bookingData[] = $stat['count'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Owner Dashboard - HubVenue</title>
    <link rel="stylesheet" href="./output.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bai palitan mo lang calendar kung meron ka alam na mas maganda -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
</head>

<body class="bg-gray-50">
    <?php include_once './components/navbar.logged.in.php'; ?>

    <!-- Main container with proper navbar spacing -->
    <div class="pt-20">
        <!-- Dashboard Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <div class="flex space-x-4">
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-500">Total Bookings</p>
                    <p class="text-2xl font-semibold mt-1"><?php echo $stats['total_reservations']; ?></p>
                    <p class="text-xs text-gray-400 mt-1">+<?php echo $stats['current_month_reservations']; ?> this
                        month</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-500">Upcoming</p>
                    <p class="text-2xl font-semibold mt-1"><?php echo $stats['upcoming_reservations']; ?></p>
                    <p class="text-xs text-gray-400 mt-1">Next 7 days</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-semibold mt-1"><?php echo $stats['pending_requests']; ?></p>
                    <p class="text-xs text-gray-400 mt-1">Awaiting approval</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-500">Revenue</p>
                    <p class="text-2xl font-semibold mt-1">
                        ₱<?php echo number_format($stats['current_month_revenue']); ?></p>
                    <p class="text-xs text-gray-400 mt-1">This month</p>
                </div>
            </div>

            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button class="tab-button active border-black text-black px-1 py-4 text-sm font-medium border-b-2"
                        data-tab="bookings">
                        Bookings
                    </button>
                    <button class="tab-button text-gray-500 hover:text-gray-700 px-1 py-4 text-sm font-medium"
                        data-tab="calendar">
                        Calendar
                    </button>
                    <button class="tab-button text-gray-500 hover:text-gray-700 px-1 py-4 text-sm font-medium"
                        data-tab="statistics">
                        Statistics
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="py-6">
                <!-- Bookings Tab -->
                <div id="bookings-tab" class="tab-content active">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- New Booking Requests -->
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="p-4 border-b">
                                <h2 class="text-lg font-medium">New Requests</h2>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Guest</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Venue</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach ($venues as $venue):
                                            $pendingBookings = $venueObj->getVenueBookings($venue['id'], 1, 5);
                                            foreach ($pendingBookings as $booking): ?>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <?php if ($booking['profile_pic'] && strlen($booking['profile_pic']) > 1): ?>
                                                                <img src="./<?php echo htmlspecialchars($booking['profile_pic']); ?>"
                                                                    alt="Profile" class="w-8 h-8 rounded-full mr-2 object-cover">
                                                            <?php else: ?>
                                                                <div
                                                                    class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center mr-2">
                                                                    <span
                                                                        class="text-sm"><?php echo strtoupper(substr($booking['firstname'], 0, 1)); ?></span>
                                                                </div>
                                                            <?php endif; ?>
                                                            <span
                                                                class="text-sm text-gray-900"><?php echo htmlspecialchars($booking['firstname'] . ' ' . $booking['lastname']); ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <?php echo htmlspecialchars($booking['venue_name']); ?>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <?php echo date('M d, Y', strtotime($booking['booking_start_datetime'])); ?>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        <button class="text-green-600 hover:text-green-800 mr-3"
                                                            data-booking-id="<?php echo $booking['id']; ?>"
                                                            data-booking-action="accept">Accept</button>
                                                        <button class="text-red-600 hover:text-red-800"
                                                            data-booking-id="<?php echo $booking['id']; ?>"
                                                            data-booking-action="decline">Decline</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Confirmed Bookings -->
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="p-4 border-b">
                                <h2 class="text-lg font-medium">Confirmed Bookings</h2>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Guest</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Venue</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach ($venues as $venue):
                                            $confirmedBookings = $venueObj->getVenueBookings($venue['id'], 2, 5);
                                            foreach ($confirmedBookings as $booking): ?>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <?php if ($booking['profile_pic'] && strlen($booking['profile_pic']) > 1): ?>
                                                                <img src="./<?php echo htmlspecialchars($booking['profile_pic']); ?>"
                                                                    alt="Profile" class="w-8 h-8 rounded-full mr-2 object-cover">
                                                            <?php else: ?>
                                                                <div
                                                                    class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center mr-2">
                                                                    <span
                                                                        class="text-sm"><?php echo strtoupper(substr($booking['firstname'], 0, 1)); ?></span>
                                                                </div>
                                                            <?php endif; ?>
                                                            <span
                                                                class="text-sm text-gray-900"><?php echo htmlspecialchars($booking['firstname'] . ' ' . $booking['lastname']); ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <?php echo htmlspecialchars($booking['venue_name']); ?>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <?php echo date('M d, Y', strtotime($booking['booking_start_datetime'])); ?>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span
                                                            class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                            <?php echo htmlspecialchars($booking['status_name']); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Tab -->
                <div id="calendar-tab" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <!-- Calendar Toolbar -->
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex space-x-4">
                                <button id="todayBtn"
                                    class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">Today</button>
                                <div class="flex space-x-2">
                                    <button id="prevBtn" class="p-2 rounded hover:bg-gray-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button id="nextBtn" class="p-2 rounded hover:bg-gray-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <h2 id="calendarTitle" class="text-xl font-semibold"></h2>
                            <div class="flex space-x-2">
                                <button data-view="dayGridMonth" class="view-btn px-4 py-2 rounded">Month</button>
                                <button data-view="timeGridWeek" class="view-btn px-4 py-2 rounded">Week</button>
                                <button data-view="timeGridDay" class="view-btn px-4 py-2 rounded">Day</button>
                            </div>
                        </div>

                        <!-- Calendar Legend -->
                        <div class="flex flex-wrap gap-4 mb-4 text-sm">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-[#FCD34D] mr-2"></span>
                                <span>Pending</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-[#34D399] mr-2"></span>
                                <span>Confirmed</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-[#F87171] mr-2"></span>
                                <span>Cancelled</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-[#60A5FA] mr-2"></span>
                                <span>Completed</span>
                            </div>
                        </div>

                        <!-- Calendar Container -->
                        <div id="calendar" class="min-h-[700px]"></div>
                    </div>
                </div>

                <!-- Statistics Tab -->
                <div id="statistics-tab" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($venues as $venue): ?>
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
                                    <h3 class="font-medium text-lg mb-2"><?php echo htmlspecialchars($venue['name']); ?>
                                    </h3>

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
                                            <p class="text-lg font-semibold">
                                                ₱<?php echo number_format($venue['total_revenue']); ?></p>
                                        </div>

                                        <!-- Occupancy Rate -->
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <p class="text-sm text-gray-600">Occupancy Rate</p>
                                            <p class="text-lg font-semibold">
                                                <?php echo number_format($venue['occupancy_rate'], 1); ?>%
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
                                    <button
                                        onclick="showVenueDetailStats(<?php echo htmlspecialchars(json_encode($venue)); ?>)"
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
    </div>

    <!-- Detailed Statistics Modal -->
    <div id="statsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="min-h-screen px-4 text-center">
            <div
                class="inline-block w-full max-w-6xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 class="text-2xl font-bold" id="modalVenueName"></h3>
                    <button onclick="closeStatsModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4">Performance Overview</h2>

                    <!-- Time Period Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button
                                class="period-tab border-b-2 px-1 py-4 text-sm font-medium transition-colors duration-200"
                                data-period="today">Today</button>
                            <button
                                class="period-tab border-b-2 px-1 py-4 text-sm font-medium transition-colors duration-200"
                                data-period="week">This Week</button>
                            <button
                                class="period-tab border-b-2 px-1 py-4 text-sm font-medium transition-colors duration-200"
                                data-period="month">This Month</button>
                            <button
                                class="period-tab border-b-2 px-1 py-4 text-sm font-medium transition-colors duration-200"
                                data-period="year">This Year</button>
                        </nav>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Revenue Card -->
                        <div class="bg-white rounded-lg p-6 border">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-base text-gray-500">Revenue</h3>
                                    <p class="text-2xl font-bold mt-1" id="periodRevenue">₱0</p>
                                    <p class="text-sm text-gray-500" id="periodRevenueLabel">Total earnings for the
                                        period</p>
                                </div>
                                <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded">Last 24h</span>
                            </div>
                        </div>

                        <!-- Bookings Card -->
                        <div class="bg-white rounded-lg p-6 border">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-base text-gray-500">Bookings</h3>
                                    <p class="text-2xl font-bold mt-1" id="periodBookings">0</p>
                                    <p class="text-sm text-gray-500">Total bookings for the period</p>
                                </div>
                            </div>
                        </div>

                        <!-- Average Guests Card -->
                        <div class="bg-white rounded-lg p-6 border">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-base text-gray-500">Average Guests</h3>
                                    <p class="text-2xl font-bold mt-1" id="periodAvgGuests">0</p>
                                    <p class="text-sm text-gray-500">Average guests per booking</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                        <!-- Total Revenue -->
                        <div class="bg-white rounded-lg p-4 border">
                            <h3 class="text-sm text-gray-500">Total Revenue</h3>
                            <p class="text-xl font-bold mt-1" id="totalRevenue">₱0.00</p>
                            <p class="text-xs text-gray-500">Lifetime earnings</p>
                        </div>

                        <!-- Average Rating -->
                        <div class="bg-white rounded-lg p-4 border">
                            <h3 class="text-sm text-gray-500">Average Rating</h3>
                            <p class="text-xl font-bold mt-1" id="averageRating">0 ⭐</p>
                            <p class="text-xs text-gray-500">Based on all reviews</p>
                        </div>

                        <!-- Total Bookings -->
                        <div class="bg-white rounded-lg p-4 border">
                            <h3 class="text-sm text-gray-500">Total Bookings</h3>
                            <p class="text-xl font-bold mt-1" id="totalBookings">0</p>
                            <p class="text-xs text-gray-500">All-time bookings</p>
                        </div>

                        <!-- Occupancy Rate -->
                        <div class="bg-white rounded-lg p-4 border">
                            <h3 class="text-sm text-gray-500">Occupancy Rate</h3>
                            <p class="text-xl font-bold mt-1" id="occupancyRate">0%</p>
                            <p class="text-xs text-gray-500">Average occupancy</p>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Revenue Chart -->
                        <div class="bg-white rounded-lg p-6 border">
                            <h3 class="text-base font-semibold mb-4">Revenue Over Time</h3>
                            <div class="h-[300px]">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>

                        <!-- Bookings Distribution -->
                        <div class="bg-white rounded-lg p-6 border">
                            <h3 class="text-base font-semibold mb-4">Bookings Distribution</h3>
                            <div class="h-[300px]">
                                <canvas id="bookingsChart"></canvas>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mt-4 text-sm">
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-yellow-400 mr-2"></span>
                                    <span>Pending</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-green-400 mr-2"></span>
                                    <span>Confirmed</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-red-400 mr-2"></span>
                                    <span>Cancelled</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-blue-400 mr-2"></span>
                                    <span>Completed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div id="eventModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 class="text-xl font-semibold" id="eventTitle"></h3>
                    <button onclick="closeEventModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Venue</p>
                            <p class="font-medium" id="eventVenue"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="font-medium" id="eventStatus"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Guest Name</p>
                            <p class="font-medium" id="eventGuest"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Contact Number</p>
                            <p class="font-medium" id="eventContact"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium" id="eventEmail"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Number of Participants</p>
                            <p class="font-medium" id="eventParticipants"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Amount</p>
                            <p class="font-medium" id="eventAmount"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date & Time</p>
                            <p class="font-medium" id="eventDateTime"></p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Special Requests</p>
                        <p class="font-medium mt-1" id="eventRequests"></p>
                    </div>
                </div>
                <div class="flex justify-end gap-2 p-6 border-t bg-gray-50">
                    <button onclick="closeEventModal()"
                        class="px-4 py-2 text-gray-700 bg-gray-100 rounded hover:bg-gray-200">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab-button');
            const contents = document.querySelectorAll('.tab-content');

            // Initialize FullCalendar
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: false, // We'll use our custom toolbar
                events: <?php echo json_encode($calendarEvents); ?>,
                height: 'auto',
                nowIndicator: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                slotMinTime: '06:00:00',
                slotMaxTime: '24:00:00',
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'short'
                },
                views: {
                    timeGrid: {
                        dayMaxEventRows: 6
                    }
                },
                eventClick: function (info) {
                    showEventDetails(info.event);
                },
                eventDidMount: function (info) {
                    // Add tooltips using Tippy.js
                    tippy(info.el, {
                        content: `
                            <div class="text-sm">
                                <div class="flex items-center gap-2 mb-2">
                                    ${info.event.extendedProps.profile_pic.type === 'placeholder' ?
                                `<div class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center text-sm">
                                            ${info.event.extendedProps.profile_pic.content}
                                        </div>` :
                                `<img src="./${info.event.extendedProps.profile_pic.content}" alt="Profile" class="w-8 h-8 rounded-full object-cover">`
                            }
                                    <div>
                                        <p class="font-semibold">${info.event.extendedProps.venue_name}</p>
                                        <p>${info.event.extendedProps.guest_name}</p>
                                    </div>
                                </div>
                                <p class="mt-1">
                                    <span class="inline-block px-2 py-1 rounded-full text-xs" style="background-color: ${info.event.backgroundColor}; color: white;">
                                        ${info.event.extendedProps.status}
                                    </span>
                                </p>
                            </div>
                        `,
                        allowHTML: true,
                        placement: 'top',
                        arrow: true,
                        theme: 'light',
                        interactive: true
                    });
                }
            });

            // Function to initialize charts
            function initializeCharts() {
                // Revenue Chart
                const revenueCanvas = document.getElementById('revenueChart');
                if (revenueCanvas) {
                    const revenueCtx = revenueCanvas.getContext('2d');

                    // Check if Chart.js is loaded
                    if (typeof Chart === 'undefined') {
                        console.error('Chart.js is not loaded');
                        return;
                    }

                    // Get existing chart instance
                    const existingChart = Chart.getChart(revenueCanvas);
                    if (existingChart) {
                        existingChart.destroy();
                    }

                    // Create new chart
                    new Chart(revenueCtx, {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($revenueLabels); ?>,
                            datasets: [{
                                label: 'Monthly Revenue',
                                data: <?php echo json_encode($revenueData); ?>,
                                borderColor: '#10B981',
                                backgroundColor: '#10B98120',
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
                                        callback: function (value) {
                                            return '₱' + value.toLocaleString();
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            return '₱' + context.raw.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Booking Stats Chart
                const bookingsCanvas = document.getElementById('bookingsChart');
                if (bookingsCanvas) {
                    const bookingsCtx = bookingsCanvas.getContext('2d');

                    // Get existing chart instance
                    const existingChart = Chart.getChart(bookingsCanvas);
                    if (existingChart) {
                        existingChart.destroy();
                    }

                    const bookingData = <?php echo json_encode($bookingData); ?>;
                    const bookingLabels = <?php echo json_encode($bookingLabels); ?>;
                    const total = bookingData.reduce((a, b) => a + b, 0);

                    // Create new chart
                    new Chart(bookingsCtx, {
                        type: 'doughnut',
                        data: {
                            labels: bookingLabels,
                            datasets: [{
                                data: bookingData,
                                backgroundColor: [
                                    '#FCD34D', // yellow for pending
                                    '#34D399', // green for confirmed
                                    '#F87171', // red for cancelled
                                    '#60A5FA'  // blue for completed
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            const value = context.raw;
                                            const percentage = ((value / total) * 100).toFixed(1);
                                            return `${context.label}: ${value} (${percentage}%)`;
                                        }
                                    }
                                }
                            },
                            cutout: '70%'
                        }
                    });
                }
            }

            // Tab switching functionality with improved chart handling
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Remove active classes
                    tabs.forEach(t => {
                        t.classList.remove('border-black', 'text-black');
                        t.classList.add('text-gray-500');
                    });
                    contents.forEach(c => c.classList.add('hidden'));

                    // Add active classes
                    tab.classList.add('border-black', 'text-black');
                    tab.classList.remove('text-gray-500');
                    const tabContent = document.getElementById(`${tab.dataset.tab}-tab`);
                    tabContent.classList.remove('hidden');

                    // Handle specific tab content with delay for proper rendering
                    if (tab.dataset.tab === 'calendar') {
                        setTimeout(() => calendar.render(), 0);
                    } else if (tab.dataset.tab === 'statistics') {
                        setTimeout(() => initializeCharts(), 0);
                    }
                });
            });

            // Set initial active tab and render content
            const initialTab = document.querySelector('.tab-button.active');
            if (initialTab) {
                const tabContent = document.getElementById(`${initialTab.dataset.tab}-tab`);
                tabContent.classList.remove('hidden');
                if (initialTab.dataset.tab === 'calendar') {
                    calendar.render();
                } else if (initialTab.dataset.tab === 'statistics') {
                    initializeCharts();
                }
            }

            // Bind custom toolbar buttons
            document.getElementById('todayBtn').addEventListener('click', () => calendar.today());
            document.getElementById('prevBtn').addEventListener('click', () => calendar.prev());
            document.getElementById('nextBtn').addEventListener('click', () => calendar.next());

            document.querySelectorAll('.view-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    document.querySelectorAll('.view-btn').forEach(btn => {
                        btn.classList.remove('bg-black', 'text-white');
                        btn.classList.add('text-gray-700', 'bg-gray-100');
                    });
                    e.target.classList.remove('text-gray-700', 'bg-gray-100');
                    e.target.classList.add('bg-black', 'text-white');
                    calendar.changeView(e.target.dataset.view);
                });
            });

            // Update calendar title
            function updateCalendarTitle() {
                const title = calendar.view.title;
                document.getElementById('calendarTitle').textContent = title;
            }

            calendar.on('datesSet', updateCalendarTitle);
            updateCalendarTitle();

            // Booking action handlers
            document.querySelectorAll('[data-booking-action]').forEach(button => {
                button.addEventListener('click', async function () {
                    const bookingId = this.dataset.bookingId;
                    const action = this.dataset.bookingAction;

                    if (!confirm(`Are you sure you want to ${action} this booking?`)) {
                        return;
                    }

                    try {
                        const response = await fetch('api/manage-booking.api.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `booking_id=${bookingId}&action=${action}`
                        });

                        const data = await response.json();

                        if (data.status === 'success') {
                            alert(data.message);
                            window.location.reload();
                        } else {
                            alert(data.message || 'An error occurred');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred while processing your request');
                    }
                });
            });
        });

        function showVenueDetailStats(venue) {
            const modal = document.getElementById('statsModal');
            modal.classList.remove('hidden');
            document.getElementById('modalVenueName').textContent = venue.name;

            // Set up period switching
            const periodTabs = document.querySelectorAll('.period-tab');
            periodTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    periodTabs.forEach(t => {
                        t.classList.remove('border-black', 'text-black');
                        t.classList.add('border-transparent', 'text-gray-500');
                    });

                    tab.classList.remove('border-transparent', 'text-gray-500');
                    tab.classList.add('border-black', 'text-black');

                    updatePeriodStats(venue, tab.dataset.period);
                });
            });

            // Initialize with 'today' period selected
            const todayTab = document.querySelector('[data-period="today"]');
            todayTab.classList.remove('border-transparent', 'text-gray-500');
            todayTab.classList.add('border-black', 'text-black');
            updatePeriodStats(venue, 'today');

            // Update summary stats with proper formatting
            document.getElementById('totalRevenue').textContent = '₱' + venue.total_revenue.toLocaleString();
            document.getElementById('averageRating').textContent = venue.average_rating.toFixed(1) + ' ⭐';
            document.getElementById('totalBookings').textContent = venue.total_bookings.toLocaleString();
            document.getElementById('occupancyRate').textContent = venue.occupancy_rate.toFixed(1) + '%';

            // Initialize charts with a slight delay to ensure proper rendering
            setTimeout(() => initializeVenueCharts(venue), 0);
        }

        function updatePeriodStats(venue, period) {
            const stats = venue.time_based_stats[period] || {
                revenue: 0,
                bookings: 0,
                avg_guests: 0
            };

            document.getElementById('periodRevenue').textContent = '₱' + stats.revenue.toLocaleString();
            document.getElementById('periodBookings').textContent = stats.bookings.toLocaleString();
            document.getElementById('periodAvgGuests').textContent = stats.avg_guests.toFixed(1);
        }

        function initializeVenueCharts(venue) {
            // Revenue Chart
            const revenueCanvas = document.getElementById('revenueChart');
            if (revenueCanvas) {
                const revenueCtx = revenueCanvas.getContext('2d');

                // Get existing chart instance
                const existingRevenueChart = Chart.getChart(revenueCanvas);
                if (existingRevenueChart) {
                    existingRevenueChart.destroy();
                }

                // Create new chart
                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: venue.revenue_data.labels,
                        datasets: [{
                            label: 'Monthly Revenue',
                            data: venue.revenue_data.values,
                            borderColor: '#10B981',
                            backgroundColor: '#10B98120',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: value => '₱' + value.toLocaleString()
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return '₱' + context.raw.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Bookings Distribution Chart
            const bookingsCanvas = document.getElementById('bookingsChart');
            if (bookingsCanvas) {
                const bookingsCtx = bookingsCanvas.getContext('2d');

                // Get existing chart instance
                const existingBookingsChart = Chart.getChart(bookingsCanvas);
                if (existingBookingsChart) {
                    existingBookingsChart.destroy();
                }

                const bookingData = [
                    venue.pending_bookings,
                    venue.confirmed_bookings,
                    venue.cancelled_bookings,
                    venue.completed_bookings
                ];
                const total = bookingData.reduce((a, b) => a + b, 0);

                // Create new chart
                new Chart(bookingsCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Confirmed', 'Cancelled', 'Completed'],
                        datasets: [{
                            data: bookingData,
                            backgroundColor: [
                                '#FCD34D', // yellow for pending
                                '#34D399', // green for confirmed
                                '#F87171', // red for cancelled
                                '#60A5FA'  // blue for completed
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        const value = context.raw;
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return `${context.label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            }
        }

        function closeStatsModal() {
            document.getElementById('statsModal').classList.add('hidden');
        }

        function showEventDetails(event) {
            const modal = document.getElementById('eventModal');
            const props = event.extendedProps;

            // Set modal content
            document.getElementById('eventTitle').textContent = event.title;
            document.getElementById('eventVenue').textContent = props.venue_name;
            document.getElementById('eventStatus').textContent = props.status;
            document.getElementById('eventGuest').textContent = props.guest_name;
            document.getElementById('eventContact').textContent = props.guest_contact;
            document.getElementById('eventEmail').textContent = props.guest_email;
            document.getElementById('eventParticipants').textContent = props.participants;
            document.getElementById('eventAmount').textContent = `₱${props.total_amount}`;
            document.getElementById('eventDateTime').textContent = `${event.start.toLocaleDateString()} ${event.start.toLocaleTimeString()} - ${event.end.toLocaleDateString()} ${event.end.toLocaleTimeString()}`;
            document.getElementById('eventRequests').textContent = props.special_requests || 'None';

            // Show modal
            modal.classList.remove('hidden');
        }

        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }
    </script>
</body>

</html>