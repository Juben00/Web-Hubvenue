<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">Reports and Analytics</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Most Popular Venues Section -->
        <section id="popular-venues" class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Most Popular Venues</h2>
            <div class="overflow-x-auto max-h-80">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 text-left">Venue</th>
                            <th class="py-2 px-4 text-left">Total Bookings</th>
                            <th class="py-2 px-4 text-left">Popularity Score</th>
                        </tr>
                    </thead>
                    <tbody id="popularVenuesTable">
                        <!-- Table rows will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Venue Availability Section -->
        <section id="venue-availability" class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Venue Availability</h2>
            <div id="venueAvailabilityList" class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-80 overflow-y-auto">
                <!-- Venue availability cards will be populated by JavaScript -->
            </div>
        </section>

        <!-- Utilization Rate Section -->
        <section id="utilization-rate" class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Venue Utilization Rate</h2>
            <div class="h-64">
                <canvas id="utilizationRateChart"></canvas>
            </div>
        </section>

        <!-- Customer Preferences Section -->
        <section id="customer-preferences" class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Customer Preferences</h2>
            <div class="h-64">
                <canvas id="customerPreferencesChart"></canvas>
            </div>
        </section>
    </div>
</div>