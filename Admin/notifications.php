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

        .gradient-background {
            background: radial-gradient(circle at left, #F3F4F6 0%, #E5E7EB 50%, #D1D5DB 100%);
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

        /* Dark mode styles */
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

        .dark-mode .hover\:text-gray-800:hover {
            color: #F3F4F6;
        }

        .dark-mode .bg-gray-100 {
            background-color: transparent;
        }

        .dark-mode .semi-transparent {
            background-color: rgba(31, 41, 55, 0.8);
            color: #FFFFFF;
        }

        .dark-mode .bg-light-gray {
            background-color: rgba(55, 65, 81, 0.8);
            color: #FFFFFF;
        }

        .dark-mode .text-gray-800 .h1 {
            color: #FFFFFF;
        }

        .dark-mode .border-gray-300 {
            border-color: #4B5563;
        }

        .h3 {
            color: #c10000;
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

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-4 py-6">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-4 hidden md:block">Notifications and Alerts</h1>
                    
                    <!-- Admin Notifications Section -->
                    <section id="admin-notifications" class="bg-white rounded-lg shadow-md p-4 mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">Admin Notifications</h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Booking Confirmations</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Payment Alerts</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">System Errors</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </section>
        
                    <!-- Customer Notifications Section -->
                    <section id="customer-notifications" class="bg-white rounded-lg shadow-md p-4 mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">Customer Notifications</h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Booking Confirmations</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Booking Reminders</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Payment Confirmations</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </section>
        
                    <!-- System Alerts Section -->
                    <section id="system-alerts" class="bg-white rounded-lg shadow-md p-4 mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">System Alerts</h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Payment Failures</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Low Venue Availability</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Server Health Issues</span>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dark mode toggle functionality
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;

        darkModeToggle.addEventListener('change', () => {
            body.classList.toggle('dark-mode');
        });
    </script>
</body>
</html>