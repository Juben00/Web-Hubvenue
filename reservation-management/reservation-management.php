<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Reservation Management</h1>

    <!-- Search and Filter Section -->
    <section class="bg-white rounded-lg shadow-md p-4 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Search and Filter Reservations</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="date" id="dateFilter" class="border rounded p-2" placeholder="Filter by date">
            <input type="text" id="venueFilter" class="border rounded p-2" placeholder="Filter by venue">
            <input type="text" id="customerFilter" class="border rounded p-2" placeholder="Filter by customer">
        </div>
        <button id="applyFilters"
            class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors">Apply
            Filters</button>
    </section>

    <!-- Reservations Table -->
    <section class="bg-white rounded-lg shadow-md p-4 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Reservations</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 text-left">Date</th>
                        <th class="py-2 px-4 text-left">Venue</th>
                        <th class="py-2 px-4 text-left">Space Name</th>
                        <th class="py-2 px-4 text-left">Customer</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="reservationsTable">
                    <!-- Table rows will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Notifications Section -->
    <section class="bg-white rounded-lg shadow-md p-4 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Custom Notifications</h2>
        <div id="notificationsContainer">
            <!-- Notifications will be populated by JavaScript -->
        </div>
    </section>
</div>