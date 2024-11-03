<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HubVenue Dashboard</title>
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
            /* Uncomment this line */
            background-size: cover;
            /* Add this line to ensure the image covers the entire body */
            background-attachment: fixed;
            /* Add this to keep the background fixed while scrolling */
        }

        .topbar,
        .sidebar {
            background-color: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
        }

        .sidebar-brand,
        .sidebar-heading,
        .nav-item {
            background-color: transparent;
        }

        .gradient-background {
            background: radial-gradient(circle at left, #F3F4F6 0%, #E5E7EB 50%, #D1D5DB 100%);
        }

        #sidebar nav a:hover,
        #sidebar nav button:hover {
            background-color: #f41c1c;
            color: white;
            border-radius: 0.5rem;
        }

        #sidebar nav a,
        #sidebar nav button {
            color: #1F2937;
        }

        #sidebar.w-16 nav a,
        #sidebar.w-16 nav button {
            justify-content: center;
        }

        #sidebar.w-16 nav a svg,
        #sidebar.w-16 nav button svg {
            margin-left: 0;
            margin-right: 0;
        }

        #sidebar nav a,
        #sidebar nav button {
            margin: 0.25rem 0.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem 0 0 0.5rem;
            justify-content: flex-start;
            width: calc(100% - 1rem);
            overflow: hidden;
        }

        #sidebar nav a svg,
        #sidebar nav button svg {
            min-width: 1.25rem;
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
        }

        #sidebar nav a span,
        #sidebar nav button span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #sidebar nav a:hover,
        #sidebar nav button:hover {
            background-color: #e60e0e;
            color: white;
            border-radius: 0.5rem 0 0 0.5rem;
            margin-right: 0;
            width: calc(100% - 0.5rem);
        }

        #sidebar.w-16 nav a,
        #sidebar.w-16 nav button {
            justify-content: center;
            padding: 0.5rem;
            margin: 0.25rem;
            width: calc(100% - 0.5rem);
            border-radius: 0.5rem;
        }

        #sidebar.w-16 nav a:hover,
        #sidebar.w-16 nav button:hover {
            border-radius: 0.5rem;
            width: calc(100% - 0.5rem);
        }

        #sidebar {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #sidebar nav {
            width: 100%;
        }

        #sidebar nav a,
        #sidebar nav button {
            margin: 0.50rem 0.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem 0 0 0.5rem;
        }

        #sidebar.w-16 {
            border-right: none;
        }

        #darkModeToggle:checked+label div {
            transform: translateX(100%);
            background-color: #1F2937;
        }

        #darkModeToggle:checked+label .sun {
            display: none;
        }

        #darkModeToggle:checked+label .moon {
            display: block;
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
            /* Set text color to white in dark mode */
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


        * New dark mode styles for sidebar and card components */ .dark-mode #sidebar {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .dark-mode #sidebar nav a,
        .dark-mode #sidebar nav button,
        .dark-mode #sidebar .sidebar-full {
            color: #FFFFFF;
        }

        .dark-mode #sidebar nav a:hover,
        .dark-mode #sidebar nav button:hover {
            background-color: #f41c1c;
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

        .dark-mode .text-gray-800 .h1 {
            color: #FFFFFF;
        }

        .dark-mode .border-gray-300 {
            border-color: #4B5563;
        }

        /* Dark mode styles */

        .dark-mode .hover:text-gray-800:hover {
            color: #F3F4F6;
        }

        .dark-mode .bg-gray-100 {
            background-color: transparent;
        }

        /* New dark mode styles for sidebar and card components */
        .dark-mode #sidebar {
            background-color: transparent;
        }

        .dark-mode #sidebar nav a,
        .dark-mode #sidebar nav button,
        .dark-mode #sidebar .sidebar-full {
            color: #FFFFFF;
        }

        .dark-mode #sidebar nav a:hover,
        .dark-mode #sidebar nav button:hover {
            background-color: #f41c1c;
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

        /* Ensure text is gray in light mode */
        #totalEarnings,
        #monthlyEarnings,
        #venueOccupancy,
        #newBookings {
            color: #4B5563;
            /* Set to a gray color */
        }

        /* Ensure text is white in dark mode */
        .dark-mode #totalEarnings,
        .dark-mode #monthlyEarnings,
        .dark-mode #venueOccupancy,
        .dark-mode #newBookings {
            color: #FFFFFF;
            /* Set to white */
        }
    </style>
</head>

<body class="text-gray-800 gradient-background">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include_once './sidebar.php'; ?>
        <div class="flex-1 flex flex-col overflow-hidden">
            <?php include_once './topbar.php'; ?>

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100" id="adminView">


            </main>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        // Ensure the dark mode toggle is working
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;

        darkModeToggle.addEventListener('change', () => {
            body.classList.toggle('dark-mode');
        });

        // Sample JSON data (in a real application, this would come from an API)
        const dashboardData = {
            totalReservations: 1234,
            completedReservations: 980,
            upcomingReservations: 234,
            canceledReservations: 20,
            totalEarnings: 50000,
            monthlyEarnings: 15000,
            venueOccupancy: 75,
            newBookings: 15,
            upcomingReservationsList: [
                { date: '2023-09-30', venue: 'La Gran', customer: 'Joevin Hermosa', status: 'Confirmed' },
                { date: '2023-10-01', venue: 'Garden Orchid', customer: 'Randolf Festival', status: 'Pending' },
                { date: '2023-10-02', venue: 'Hui Fon', customer: 'Fritzie Balagosa', status: 'Confirmed' }
            ],
            financialData: {
                income: [10000, 15000, 20000, 18000, 25000, 30000],
                expenses: [8000, 10000, 12000, 15000, 18000, 20000]
            },
            paymentBreakdown: {
                completed: 45000,
                pending: 5000,
                refunded: 500
            },
            popularVenues: [
                { name: 'La Gran', bookings: 50 },
                { name: 'Garden Orchid', bookings: 45 },
                { name: 'Hui Fon', bookings: 30 }
            ],
            venueAvailability: [
                { name: 'La Gran', available: true },
                { name: 'Garden Orchid', available: false },
                { name: 'Hui Fon', available: true },
                { name: 'Conference Room B', available: true }
            ]
        };

        // Function to update the dashboard with data
        function updateDashboard(data) {
            // Update overview section
            document.getElementById('totalReservations').textContent = data.totalReservations;
            document.getElementById('completedReservations').textContent = data.completedReservations;
            document.getElementById('upcomingReservations').textContent = data.upcomingReservations;
            document.getElementById('canceledReservations').textContent = data.canceledReservations;
            document.getElementById('totalEarnings').textContent = `₱${data.totalEarnings.toLocaleString()}`;
            document.getElementById('monthlyEarnings').textContent = `₱${data.monthlyEarnings.toLocaleString()}`;
            document.getElementById('venueOccupancy').textContent = `${data.venueOccupancy}%`;
            document.getElementById('newBookings').textContent = data.newBookings;

            // Update upcoming reservations table
            const tableBody = document.getElementById('upcomingReservationsTable');
            tableBody.innerHTML = '';
            data.upcomingReservationsList.forEach(reservation => {
                const row = tableBody.insertRow();
                row.insertCell(0).textContent = reservation.date;
                row.insertCell(1).textContent = reservation.venue;
                row.insertCell(2).textContent = reservation.customer;
                row.insertCell(3).textContent = reservation.status;
            });

            // Update financial dashboard
            document.getElementById('completedPayments').textContent = `₱${data.paymentBreakdown.completed.toLocaleString()}`;
            document.getElementById('pendingPayments').textContent = `₱${data.paymentBreakdown.pending.toLocaleString()}`;
            document.getElementById('refundedPayments').textContent = `₱${data.paymentBreakdown.refunded.toLocaleString()}`;

            // Update income vs expenses chart
            const ctx = document.getElementById('incomeExpensesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Income',
                        data: data.financialData.income,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }, {
                        label: 'Expenses',
                        data: data.financialData.expenses,
                        borderColor: 'rgb(255, 99, 132)',
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

            // Update popular venues
            const popularVenuesList = document.getElementById('popularVenues');
            popularVenuesList.innerHTML = '';
            data.popularVenues.forEach(venue => {
                const li = document.createElement('li');
                li.textContent = `${venue.name} - ${venue.bookings} bookings`;
                popularVenuesList.appendChild(li);
            });

            // Update venue availability
            const venueAvailabilityDiv = document.getElementById('venueAvailability');
            venueAvailabilityDiv.innerHTML = '';
            data.venueAvailability.forEach(venue => {
                const p = document.createElement('p');
                p.textContent = `${venue.name}: ${venue.available ? 'Available' : 'Booked'}`;
                p.className = venue.available ? 'text-green-600' : 'text-red-600';
                venueAvailabilityDiv.appendChild(p);
            });
        }

        // Initialize the dashboard with sample data
        updateDashboard(dashboardData);

        // Handle logout button click
        document.getElementById('logoutButton').addEventListener('click', function () {
            alert('Logout functionality would be implemented here.');
        });

        // Handle account settings form submission
        document.getElementById('accountSettingsForm').addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Account settings update functionality would be implemented here.');
        });

        // Modified mobile menu toggle functionality
        document.querySelector('.mobile-menu').addEventListener('click', function (event) {
            event.stopPropagation();
            const sidebar = document.querySelector('.desktop-sidebar');
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside of it
        document.addEventListener('click', function (event) {
            const sidebar = document.querySelector('.desktop-sidebar');
            const mobileMenu = document.querySelector('.mobile-menu');
            if (!sidebar.contains(event.target) && !mobileMenu.contains(event.target) && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });

        // Prevent clicks inside the sidebar from closing it
        document.querySelector('.desktop-sidebar').addEventListener('click', function (event) {
            event.stopPropagation();
        });





        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const logo = document.querySelector('#sidebar img');
            const sidebarFullElements = document.querySelectorAll('.sidebar-full');
            const icons = document.querySelectorAll('#sidebar nav a svg, #sidebar nav button svg, #sidebar > div:last-child button svg');
            const navItems = document.querySelectorAll('#sidebar nav a, #sidebar nav button, #sidebar > div:last-child button');
            const searchInput = document.querySelector('.search-input');
            const searchButton = document.querySelector('.search-button');
            const collapsedSearch = document.querySelector('.sidebar-collapsed-search');
            const logoutButton = document.querySelector('#sidebar > div:last-child button');
            const logoutIcon = logoutButton.querySelector('svg');
            const logoutText = logoutButton.querySelector('span');

            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-16');

            // Toggle logo size
            logo.classList.toggle('w-12');
            logo.classList.toggle('h-12');
            logo.classList.toggle('w-8');
            logo.classList.toggle('h-8');

            sidebarFullElements.forEach(element => {
                element.classList.toggle('hidden');
            });

            navItems.forEach(item => {
                item.classList.toggle('justify-center');
                item.classList.toggle('px-4');
                item.classList.toggle('px-2');
            });

            icons.forEach(icon => {
                icon.classList.toggle('mr-3');
                icon.classList.toggle('mr-0');
            });

            sidebar.classList.toggle('border-r-0');

            // Toggle search input and button
            searchInput.parentElement.classList.toggle('hidden');
            collapsedSearch.classList.toggle('hidden');

            // Align collapsed search with other icons
            collapsedSearch.querySelector('button').classList.toggle('justify-center');
            collapsedSearch.querySelector('button').classList.toggle('px-4');
            collapsedSearch.querySelector('button').classList.toggle('px-2');

            // Adjust logout button
            logoutButton.classList.toggle('justify-center');
            logoutButton.classList.toggle('px-4');
            logoutButton.classList.toggle('px-2');
            logoutIcon.classList.toggle('mr-3');
            logoutIcon.classList.toggle('mr-0');

            // Toggle visibility of logout text and adjust icon
            if (sidebar.classList.contains('w-16')) {
                logoutText.classList.add('hidden');
                logoutIcon.classList.remove('mr-3');
                logoutIcon.classList.add('mx-auto');
            } else {
                logoutText.classList.remove('hidden');
                logoutIcon.classList.add('mr-3');
                logoutIcon.classList.remove('mx-auto');
            }
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

    </script>

    <script src="../vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="./js/admin.jquery.js"></script>
    <script>
        $(document).ready(function () {
            console.log("jQuery is working!");
        });
    </script>
</body>

</html>