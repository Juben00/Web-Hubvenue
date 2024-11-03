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
        
        /* Dark mode styles for main content */
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
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Reservation Management</h1>
                    
                    <!-- Search and Filter Section -->
                    <section class="bg-white rounded-lg shadow-md p-4 mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Search and Filter Reservations</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="date" id="dateFilter" class="border rounded p-2" placeholder="Filter by date">
                            <input type="text" id="venueFilter" class="border rounded p-2" placeholder="Filter by venue">
                            <input type="text" id="customerFilter" class="border rounded p-2" placeholder="Filter by customer">
                        </div>
                        <button id="applyFilters" class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors">Apply Filters</button>
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
            </main>
        </div>
    </div>

    <script>
        // Sample reservations data
        const reservationsData = [
            { id: 1, date: '2023-09-30', venue: 'Azura', spaceName: 'Main Stage', customer: 'Mike Wazowski', status: 'Pending' },
            { id: 2, date: '2023-10-01', venue: 'La Gran', spaceName: 'Outdoor Area', customer: 'Jake Quenca', status: 'Confirmed' },
            { id: 3, date: '2023-10-02', venue: 'Garden Orchid', spaceName: 'Room 101', customer: 'Mike Bautista', status: 'Paid' },
            { id: 4, date: '2023-10-03', venue: 'Hui Fon', spaceName: 'Second Floor', customer: 'Hui Fon', status: 'Pending' },
        ];

        // Function to update the reservations table
        function updateReservationsTable(reservations) {
            const tableBody = document.getElementById('reservationsTable');
            tableBody.innerHTML = '';
            reservations.forEach(reservation => {
                const row = tableBody.insertRow();
                row.insertCell(0).textContent = reservation.date;
                row.insertCell(1).textContent = reservation.venue;
                row.insertCell(2).textContent = reservation.spaceName;
                row.insertCell(3).textContent = reservation.customer;
                row.insertCell(4).textContent = reservation.status;
                const actionsCell = row.insertCell(5);
                actionsCell.innerHTML = `
                    <button onclick="approveReservation(${reservation.id})" class="bg-green-500 text-white py-1 px-2 rounded mr-2">Approve</button>
                    <button onclick="declineReservation(${reservation.id})" class="bg-red-500 text-white py-1 px-2 rounded mr-2">Decline</button>
                    <button onclick="cancelReservation(${reservation.id})" class="bg-yellow-500 text-white py-1 px-2 rounded">Cancel</button>
                `;
            });
        }

        // Function to filter reservations
        function filterReservations() {
            const dateFilter = document.getElementById('dateFilter').value;
            const venueFilter = document.getElementById('venueFilter').value.toLowerCase();
            const customerFilter = document.getElementById('customerFilter').value.toLowerCase();

            const filteredReservations = reservationsData.filter(reservation => {
                return (!dateFilter || reservation.date === dateFilter) &&
                       (!venueFilter || reservation.venue.toLowerCase().includes(venueFilter)) &&
                       (!customerFilter || reservation.customer.toLowerCase().includes(customerFilter));
            });

            updateReservationsTable(filteredReservations);
        }

        // Event listener for apply filters button
        document.getElementById('applyFilters').addEventListener('click', filterReservations);

        // Functions for reservation actions
        function approveReservation(id) {
            console.log(`Approving reservation ${id}`);
            addNotification(`Reservation ${id} has been approved.`);
        }

        function declineReservation(id) {
            console.log(`Declining reservation ${id}`);
            addNotification(`Reservation ${id} has been declined.`);
        }

        function cancelReservation(id) {
            console.log(`Cancelling reservation ${id}`);
            addNotification(`Reservation ${id} has been cancelled.`);
        }

        // Function to add a notification
        function addNotification(message) {
            const notificationsContainer = document.getElementById('notificationsContainer');
            const notification = document.createElement('div');
            notification.className = 'bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4';
            notification.textContent = message;
            notificationsContainer.prepend(notification);

            // Remove the notification after 5 seconds
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Initialize the reservations table
        updateReservationsTable(reservationsData);
    </script>
</body>
</html>