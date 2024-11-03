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

        /* Dark mode styles */
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

        .dark-mode #h1 {
            color: white;
        }

        .h3 {
            color: #c10000;
        }
    </style>
</head>
<body class="text-gray-800 gradient-background">
    <div class="flex h-screen">
        <!-- Include Sidebar -->
        <?php include 'sidebar.php'; ?>
        
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Include Topbar -->
            <?php include 'topbar.php'; ?>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 main-content">
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
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample JSON data for audit logs
        const auditLogsData = {
            adminActivityLogs: [
                { timestamp: '2023-09-30 14:23:45', admin: 'Rezier John', action: 'Venue Edit', details: 'Updated capacity for Grand Hall' },
                { timestamp: '2023-09-30 13:15:22', admin: 'Randolf Marie Marba', action: 'Reservation Approval', details: 'Approved reservation #12345' },
                { timestamp: '2023-09-30 11:05:17', admin: 'Hui Fon', action: 'User Ban', details: 'Banned user for violating terms' },
                { timestamp: '2023-09-29 16:30:00', admin: 'Joevin Ansoc', action: 'Pricing Update', details: 'Updated pricing for Garden Terrace' },
                { timestamp: '2023-09-29 10:45:33', admin: 'Fritzie Balagosa', action: 'New Venue Added', details: 'Added Conference Room C to venue list' }
            ]
        };

        // Function to update the audit logs tables with data
        function updateAuditLogs(data) {
            const adminActivityLogsTable = document.getElementById('adminActivityLogsTable');
            adminActivityLogsTable.innerHTML = '';
            data.adminActivityLogs.forEach(log => {
                const row = adminActivityLogsTable.insertRow();
                row.insertCell(0).textContent = log.timestamp;
                row.insertCell(1).textContent = log.admin;
                row.insertCell(2).textContent = log.action;
                row.insertCell(3).textContent = log.details;
            });
        }

        // Initialize the audit logs with sample data
        updateAuditLogs(auditLogsData);
    </script>
</body>
</html>