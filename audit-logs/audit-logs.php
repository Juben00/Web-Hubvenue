<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">Audit Logs</h1>

    <!-- Admin Activity Logs Section -->
    <section id="admin-activity-logs" class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-4">Admin Activity Logs</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 text-left">Timestamp</th>
                        <th class="py-2 px-4 text-left">Admin</th>
                        <th class="py-2 px-4 text-left">Action</th>
                        <th class="py-2 px-4 text-left">Details</th>
                    </tr>
                </thead>
                <tbody id="adminActivityLogsTable">
                    <!-- Table rows will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </section>
</div>