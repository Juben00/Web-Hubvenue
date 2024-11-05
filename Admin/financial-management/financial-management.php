<div class="container mx-auto px-4 py-8">
    <h1 id="h1" class="text-2xl md:text-3xl font-semibold mb-6">Financial Management</h1>

    <!-- Grid layout for better organization -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Total Income vs. Expenses Section -->
        <section id="income-expenses" class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Total Income vs. Expenses</h2>
            <div class="h-64">
                <canvas id="incomeExpensesChart"></canvas>
            </div>
        </section>

        <!-- Payment Breakdown Section -->
        <section id="payment-breakdown" class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Breakdown</h2>
            <div class="grid grid-cols-1 gap-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-700">Completed Payments</h3>
                    <p class="text-2xl font-bold text-green-500" id="completedPayments">₱0</p>
                </div>
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-700">Pending Payments</h3>
                    <p class="text-2xl font-bold text-yellow-500" id="pendingPayments">₱0</p>
                </div>
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-700">Refunded Payments</h3>
                    <p class="text-2xl font-bold text-red-500" id="refundedPayments">₱0</p>
                </div>
            </div>
        </section>

        <!-- Financial Performance Chart -->
        <section id="financial-performance" class="bg-white rounded-lg shadow-md p-6 md:col-span-2">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Financial Performance Over Time</h2>
            <div class="h-80">
                <canvas id="financialPerformanceChart"></canvas>
            </div>
        </section>

        <!-- Refund Requests Section -->
        <section id="refund-requests" class="bg-white rounded-lg shadow-md p-6 md:col-span-2">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Refund Requests</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 text-left">Date</th>
                            <th class="py-2 px-4 text-left">Customer</th>
                            <th class="py-2 px-4 text-left">Amount</th>
                            <th class="py-2 px-4 text-left">Status</th>
                            <th class="py-2 px-4 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody id="refundRequestsTable">
                        <!-- Table rows will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Top Earning Venues Section -->
        <section id="top-earning-venues" class="bg-white rounded-lg shadow-md p-6 md:col-span-2">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Top Earning Venues</h2>
            <div class="h-80">
                <canvas id="topEarningVenuesChart"></canvas>
            </div>
        </section>
    </div>
</div>