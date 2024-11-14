<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Listings - HubVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <base href="/">
</head>
<body class="bg-gray-50">
   
    <?php include __DIR__ . '/includes/nav.php'; ?>
    <main class="max-w-7xl mx-auto py-6 pt-20 sm:px-6 lg:px-8">
        <div class="px-4 sm:px-0">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Your listings</h1>
                <div class="flex items-center space-x-4">
                    <button class="p-2 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                    <button class="p-2 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <button class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">+</button>
                </div>
            </div>

            <!-- Listings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Listing Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="relative">
                        <div class="absolute top-4 left-4 bg-red-500 text-white px-2 py-1 rounded-full text-sm">
                            Verification required
                        </div>
                        <img src="path-to-venue-image" alt="Venue" class="w-full h-48 object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium">asdas</h3>
                        <p class="text-gray-500">Zamboanga, Zamboanga Peninsula</p>
                    </div>
                </div>

                <!-- Add more listing cards as needed -->
            </div>
        </div>
    </main>
</body>
</html> 