<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Owner Dashboard - HubVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <base href="/">
</head>
<body class="bg-gray-50">
<?php include __DIR__ . '/includes/nav.php'; ?>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="px-4 sm:px-0">
            <h1 class="text-2xl font-bold text-gray-900">Welcome back, Rezier John</h1>
            
            <!-- Verification Notice -->
            <div class="mt-4 bg-white rounded-lg shadow p-4">
                <h2 class="font-semibold">Confirm important details</h2>
                <p class="text-red-600 text-sm">Required to publish</p>
                <p class="text-gray-600">asdas</p>
                <button class="mt-2 text-gray-900 font-semibold">Start</button>
            </div>
        </div>

        <!-- Reservations Section -->
        <div class="mt-8">
            <div class="flex justify-between items-center px-4 sm:px-0">
                <h2 class="text-xl font-bold text-gray-900">Your reservations</h2>
                <a href="#" class="text-gray-900">All reservations (0)</a>
            </div>

            <!-- Reservation Tabs -->
            <div class="mt-4 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <a href="#" class="border-black text-gray-900 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Checking out (0)
                    </a>
                    <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Currently hosting (0)
                    </a>
                    <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Arriving soon (0)
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

        <!-- Help Section -->
        <div class="mt-8 px-4 sm:px-0">
            <h2 class="text-xl font-bold text-gray-900">We're here to help</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold">Guidance from a Superhost</h3>
                    <!-- Add content -->
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold">Contact specialized support</h3>
                    <!-- Add content -->
                </div>
            </div>
        </div>
    </main>
</body>
</html> 