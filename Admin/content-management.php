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

        .dark-mode .border-gray-300 {
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
        
        <div class="flex-1 flex flex-col overflow-hidden">
            <?php include 'topbar.php'; ?>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content">
                <div class="container mx-auto px-4 py-8">
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6 hidden md:block">Content Management</h1>
                    
                    <!-- Admin Notifications Section -->
                    <section id="admin-notifications" class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Admin Notifications</h2>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between bg-yellow-100 p-4 rounded-md">
                                <span class="text-yellow-800">New review pending approval</span>
                                <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition-colors">Review</button>
                            </div>
                            <div class="flex items-center justify-between bg-green-100 p-4 rounded-md">
                                <span class="text-green-800">Blog post scheduled for publication</span>
                                <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors">View</button>
                            </div>
                        </div>
                    </section>

                    <!-- Rest of your content sections... -->
                    <!-- (Keep all the existing content sections, just removed them for brevity) -->

                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Keep only the content-specific JavaScript
        const contentManagementData = {
            adminNotifications: [
                { type: 'review', message: 'New review pending approval' },
            ],
            pages: [
                { name: 'About Us', lastUpdated: '2023-09-15' },
                { name: 'FAQ', lastUpdated: '2023-09-20' },
                { name: 'Terms & Conditions', lastUpdated: '2023-09-10' }
            ],
            customerReviews: [
                { name: 'Fritzie Balagosa', rating: 4, comment: 'Great venue! The staff was very helpful and accommodating.' },
                { name: 'Randolf Festival', rating: 5, comment: 'Beautiful location for our wedding. Everything was perfect!' }
            ],
            // ... rest of your data object
        };

        function updateContentManagement(data) {
            // Keep your existing update functions
            // ... (keep all the content management specific functions)
        }

        // Initialize the content management page with sample data
        updateContentManagement(contentManagementData);
    </script>
</body>
</html>