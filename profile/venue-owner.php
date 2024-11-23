<!-- Main Content -->

<?php
session_start();
$fullname = $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'];
?>
<main class="max-w-7xl pt-20 mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Welcome Section -->
    <div class="px-4 sm:px-0">
        <h1 class="text-2xl font-bold text-gray-900">Welcome back,
            <?php echo $fullname; ?>
        </h1>


        <!-- Reservations Section -->
        <div class="mt-8">
            <div class="flex justify-between items-center px-4 sm:px-0">
                <h2 class="text-xl font-bold text-gray-900">Your reservations</h2>
                <a href="#" class="text-gray-900">All reservations (0)</a>
            </div>

            <!-- Reservation Tabs -->
            <div class="mt-4 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <a href="#"
                        class="border-black text-gray-900 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Confirm Bookings (0)
                    </a>
                    <a href="#"
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Current Bookings (0)
                    </a>
                    <a href="#"
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Booking History (0)
                    </a>
                    <!-- Add more tabs as needed -->
                </nav>
            </div>

            <!-- No Reservations Message -->
            <div class="mt-8 text-center py-12 bg-gray-50">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                    <!-- Add your icon SVG here -->
                </svg>
                <p class="mt-2 text-sm text-gray-500">
                    You don't have any guests<br>
                    checking out today<br>
                    or tomorrow.
                </p>
            </div>
        </div>
</main>