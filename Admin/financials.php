<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archon HRIS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#f41c1c',
                        secondary: '#F3F4F6',
                        'light-gray': '#F9FAFB',
                        'dark-gray': '#4B5563',
                    }
                }
            }
        };
    </script>
    <style>
        body {
            background-image: url('bg.jpg');
            background-size: cover;
            background-attachment: fixed;
        }

        .semi-transparent {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .rounded-card {
            border-radius: 1rem;
        }

        .dark-mode {
            background: radial-gradient(circle at left, #121212 0%, #3D0000 50%, #000000 100%);
        }
        
        .dark-mode .bg-white {
            background-color: transparent;
        }

        .dark-mode .text-gray-600,
        .dark-mode .text-gray-700,
        .dark-mode .text-gray-800 {
            color: #D1D5DB;
        }

        .dark-mode table thead th,
        .dark-mode table tbody td {
            color: #FFFFFF;
        }

        .dark-mode .semi-transparent {
            background-color: rgba(31, 41, 55, 0.8);
            color: #FFFFFF;
        }

        .dark-mode .bg-light-gray {
            background-color: rgba(55, 65, 81, 0.8);
            color: #FFFFFF;
        }

        .h3 {
            color: #c10000;
        }

        .dark-mode #h1 {
            color: white;
        }

        .main-content {
            position: relative;
            z-index: 1;
            min-height: calc(100vh - 64px); /* Adjust based on your topbar height */
        }

        /* Fix the semi-transparent background */
        .bg-white {
            background-color: rgba(255, 255, 255, 0.95);
        }

        /* Ensure content is visible in dark mode */
        .dark-mode .bg-white {
            background-color: rgba(31, 41, 55, 0.95) !important;
        }

        .dark-mode .bg-gray-100 {
            background-color: rgba(17, 24, 39, 0.8);
        }
    </style>
</head>
<body class="text-gray-800 gradient-background">
    <div class="flex h-screen">
        <?php include 'sidebar.php'; ?>
        
        <div class="flex-1 flex flex-col overflow-hidden">
            <?php include 'topbar.php'; ?>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content p-4">
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
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample JSON data
        const financialData = {
            incomeVsExpenses: {
                income: [50000, 55000, 60000, 58000, 65000, 70000],
                expenses: [40000, 42000, 45000, 47000, 50000, 52000]
            },
            paymentBreakdown: {
                completed: 180000,
                pending: 20000,
                refunded: 5000
            },
            financialPerformance: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                revenue: [60000, 65000, 70000, 68000, 75000, 80000],
                profit: [20000, 23000, 25000, 21000, 25000, 28000]
            },
            refundRequests: [
                { date: '2023-09-30', customer: 'Mike Wazowski', amount: 2300, status: 'Pending' },
                { date: '2023-09-29', customer: 'Jake Quenca', amount: 6000, status: 'Approved' },
                { date: '2023-09-28', customer: 'Mike Bautista', amount: 4200, status: 'Rejected' }
            ],
            topEarningVenues: {
                labels: ['Grand Hall', 'Garden Terrace', 'Conference Room A', 'Ballroom', 'Rooftop Lounge'],
                earnings: [50000, 45000, 40000, 35000, 30000]
            }
        };

        // Function to update the financial management page with data
        function updateFinancialManagement(data) {
            // Update Income vs Expenses Chart
            const incomeExpensesCtx = document.getElementById('incomeExpensesChart').getContext('2d');
            const incomeExpensesChart = createChart(incomeExpensesCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Income',
                        data: data.incomeVsExpenses.income,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgb(75, 192, 192)',
                        borderWidth: 1
                    }, {
                        label: 'Expenses',
                        data: data.incomeVsExpenses.expenses,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgb(255, 99, 132)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Update Payment Breakdown
            document.getElementById('completedPayments').textContent = `₱${data.paymentBreakdown.completed.toLocaleString()}`;
            document.getElementById('pendingPayments').textContent = `₱${data.paymentBreakdown.pending.toLocaleString()}`;
            document.getElementById('refundedPayments').textContent = `₱${data.paymentBreakdown.refunded.toLocaleString()}`;

            // Update Financial Performance Chart
            const financialPerformanceCtx = document.getElementById('financialPerformanceChart').getContext('2d');
            const financialPerformanceChart = createChart(financialPerformanceCtx, {
                type: 'line',
                data: {
                    labels: data.financialPerformance.labels,
                    datasets: [{
                        label: 'Revenue',
                        data: data.financialPerformance.revenue,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }, {
                        label: 'Profit',
                        data: data.financialPerformance.profit,
                        borderColor: 'rgb(153, 102, 255)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Update Refund Requests Table
            const refundRequestsTable = document.getElementById('refundRequestsTable');
            refundRequestsTable.innerHTML = '';
            data.refundRequests.forEach(request => {
                const row = refundRequestsTable.insertRow();
                row.insertCell(0).textContent = request.date;
                row.insertCell(1).textContent = request.customer;
                row.insertCell(2).textContent = `₱${request.amount.toLocaleString()}`;
                row.insertCell(3).textContent = request.status;
                const actionCell = row.insertCell(4);
                actionCell.innerHTML = `<button class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-600 transition-colors">Review</button>`;
            });

            // Update Top Earning Venues Chart
            const topEarningVenuesCtx = document.getElementById('topEarningVenuesChart').getContext('2d');
            const topEarningVenuesChart = createChart(topEarningVenuesCtx, {
                type: 'pie',
                data: {
                    labels: data.topEarningVenues.labels,
                    datasets: [{
                        data: data.topEarningVenues.earnings,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        title: {
                            display: true,
                            text: 'Top Earning Venues'
                        }
                    }
                }
            });
        }

        // Initialize the financial management page with sample data
        updateFinancialManagement(financialData);

        // Ensure charts are properly sized
        window.addEventListener('load', function() {
            // Force charts to refresh
            window.dispatchEvent(new Event('resize'));
        });

        // Add error handling for chart creation
        function createChart(ctx, config) {
            try {
                return new Chart(ctx, config);
            } catch (error) {
                console.error('Error creating chart:', error);
                return null;
            }
        }
    </script>
</body>
</html>