<?php
session_start(); ?>
<div class="container mx-auto px-6 py-8">
    <h3 class="text-gray-700 text-3xl font-medium">Welcome,
        <?php echo htmlspecialchars($_SESSION['user']['firstname']) ?>
    </h3>
    <h6 class="text-gray-500 text-1xl font-small">Let's make this day productive.</h6>

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">Venue
                Reservation Dashboard</h1>

            <!-- Overview Section -->
            <section id="overview" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Reservations</h3>
                    <p class="text-3xl font-bold text-primary" id="totalReservations">1,234</p>
                    <ul class="mt-2 text-sm text-gray-600">
                        <li>Completed: <span id="completedReservations">980</span></li>
                        <li>Upcoming: <span id="upcomingReservations">234</span></li>
                        <li>Canceled: <span id="canceledReservations">20</span></li>
                    </ul>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Revenue Statistics</h3>
                    <p class="text-3xl font-bold text-secondary" id="totalEarnings">₱50,000</p>
                    <p class="mt-2 text-sm text-gray-600">This Month: <span id="monthlyEarnings">₱15,000</span></p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Venue Occupancy</h3>
                    <p class="text-3xl font-bold text-primary" id="venueOccupancy">75%</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">New Bookings (Last 24h)</h3>
                    <p class="text-3xl font-bold text-secondary" id="newBookings">15</p>
                </div>
            </section>

            <!-- Upcoming Reservations Section -->
            <section id="upcoming-reservations" class="bg-white rounded-lg shadow-md p-4 mb-8">
                <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-4">Upcoming Reservations
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 text-left">Date</th>
                                <th class="py-2 px-4 text-left">Venue</th>
                                <th class="py-2 px-4 text-left">Customer</th>
                                <th class="py-2 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody id="upcomingReservationsTable">
                            <!-- Table rows will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Financial Dashboard Section -->
            <section id="financial-dashboard" class="grid grid-cols-1 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Income vs. Expenses</h3>
                    <canvas id="incomeExpensesChart" width="400" height="200"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Payment Breakdown</h3>
                    <ul class="mt-2 text-sm text-gray-600">
                        <li>Completed: <span id="completedPayments">₱45,000</span></li>
                        <li>Pending: <span id="pendingPayments">₱5,000</span></li>
                        <li>Refunded: <span id="refundedPayments">₱500</span></li>
                    </ul>
                </div>
            </section>

            <!-- Venue Analytics Section -->
            <section id="venue-analytics" class="grid grid-cols-1 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Most Popular Venues</h3>
                    <ol class="mt-2 text-sm text-gray-600" id="popularVenues">
                        <!-- List items will be populated by JavaScript -->
                    </ol>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Venue Availability</h3>
                    <div id="venueAvailability" class="mt-2 text-sm text-gray-600">
                        <!-- Venue availability will be populated by JavaScript -->
                    </div>
                </div>
            </section>

            <!-- Account Settings Section -->

        </div>
    </main>

</div>