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

        .dark-mode .border-gray-800 {
            border-color: #4B5563;
        }

        .dark-mode .semi-transparent {
            background-color: rgba(31, 41, 55, 0.8);
            color: #FFFFFF;
        }

        .dark-mode .bg-light-gray {
            background-color: rgba(55, 65, 81, 0.8);
            color: #FFFFFF;
        }

        .dark-mode #h1 {
            color: white;
        }
    </style>
</head>
<body class="text-gray-800 gradient-background">
    <div class="flex h-screen">
        <?php include 'sidebar.php'; ?>

        <div class="flex-1">
            <?php include 'topbar.php'; ?>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content">
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
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const analyticsData = {
            popularVenues: [
                { name: 'Grand Ballroom', bookings: 150, popularityScore: 95 },
                { name: 'Garden Terrace', bookings: 120, popularityScore: 88 },
                { name: 'Conference Room A', bookings: 100, popularityScore: 82 },
                { name: 'Rooftop Lounge', bookings: 80, popularityScore: 75 },
                { name: 'Seaside Pavilion', bookings: 70, popularityScore: 70 }
            ],
            venueAvailability: [
                { name: 'Grand Ballroom', available: false, nextAvailable: '2023-10-05' },
                { name: 'Garden Terrace', available: true, nextAvailable: 'Now' },
                { name: 'Conference Room A', available: true, nextAvailable: 'Now' },
                { name: 'Rooftop Lounge', available: false, nextAvailable: '2023-10-03' },
                { name: 'Seaside Pavilion', available: true, nextAvailable: 'Now' }
            ],
            utilizationRate: [
                { name: 'Grand Ballroom', rate: 85 },
                { name: 'Garden Terrace', rate: 70 },
                { name: 'Conference Room A', rate: 60 },
                { name: 'Rooftop Lounge', rate: 55 },
                { name: 'Seaside Pavilion', rate: 50 }
            ],
            customerPreferences: [
                { name: 'Grand Ballroom', percentage: 30 },
                { name: 'Garden Terrace', percentage: 25 },
                { name: 'Conference Room A', percentage: 20 },
                { name: 'Rooftop Lounge', percentage: 15 },
                { name: 'Seaside Pavilion', percentage: 10 }
            ]
        };

        // Function to update the analytics page with data
        function updateAnalytics(data) {
            // Update Most Popular Venues table
            const popularVenuesTable = document.getElementById('popularVenuesTable');
            popularVenuesTable.innerHTML = '';
            data.popularVenues.forEach(venue => {
                const row = popularVenuesTable.insertRow();
                row.insertCell(0).textContent = venue.name;
                row.insertCell(1).textContent = venue.bookings;
                row.insertCell(2).textContent = venue.popularityScore;
            });

            // Update Venue Availability
            const venueAvailabilityList = document.getElementById('venueAvailabilityList');
            venueAvailabilityList.innerHTML = '';
            data.venueAvailability.forEach(venue => {
                const card = document.createElement('div');
                card.className = 'bg-gray-50 p-4 rounded-lg';
                card.innerHTML = `
                    <h3 class="font-semibold text-lg">${venue.name}</h3>
                    <p class="${venue.available ? 'text-green-600' : 'text-red-600'} font-medium">
                        ${venue.available ? 'Available' : 'Booked'}
                    </p>
                    <p class="text-sm text-gray-600">Next Available: ${venue.nextAvailable}</p>
                `;
                venueAvailabilityList.appendChild(card);
            });

            // Update Utilization Rate Chart
            const utilizationCtx = document.getElementById('utilizationRateChart').getContext('2d');
            new Chart(utilizationCtx, {
                type: 'bar',
                data: {
                    labels: data.utilizationRate.map(item => item.name),
                    datasets: [{
                        label: 'Utilization Rate (%)',
                        data: data.utilizationRate.map(item => item.rate),
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            // Update Customer Preferences Chart
            const preferencesCtx = document.getElementById('customerPreferencesChart').getContext('2d');
            new Chart(preferencesCtx, {
                type: 'pie',
                data: {
                    labels: data.customerPreferences.map(item => item.name),
                    datasets: [{
                        data: data.customerPreferences.map(item => item.percentage),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        title: {
                            display: true,
                            text: 'Customer Venue Preferences'
                        }
                    }
                }
            });
        }

        // Initialize the analytics page with sample data
        updateAnalytics(analyticsData);
    </script>
</body>
</html>