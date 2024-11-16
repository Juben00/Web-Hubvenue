<?php
require_once '../classes/venue.class.php';

session_start();

$status = "";
$venueObj = new Venue();
$venuePost = $venueObj->getAllVenues($status, $_SESSION['user']['id']);
?>
<main class="max-w-7xl mx-auto py-6 pt-20 sm:px-6 lg:px-8">
    <div class="px-4 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Your listings</h1>
            <div class="flex items-center space-x-4">
                <button class="p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                <button class="p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <button class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800"
                    id="addVenueButton">+</button>
            </div>
        </div>

        <!-- Listings Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if (empty($venuePost)) {
                echo '<p class=" text-gray-500 border-2 text-left">No listings found.</p>';
            }

            foreach ($venuePost as $venue): ?>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="relative">
                        <?php if ($venue['status'] !== "Approved"): ?>
                            <div class="absolute top-4 left-4 bg-red-500 text-white px-2 py-1 rounded-full text-sm">
                                Verification required
                            </div>
                        <?php endif; ?>
                        <img src="./<?php echo !empty($venue['image_urls'][0])
                            ? htmlspecialchars($venue['image_urls'][0])
                            : './images/black_ico.png'; ?>"
                            alt="<?php echo htmlspecialchars($venue['name'] ?? 'Venue'); ?>"
                            class="w-full h-48 object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium"><?php echo htmlspecialchars($venue['name']); ?></h3>
                        <p class="text-gray-500 text-xs">
                            <?php echo htmlspecialchars($venue['location'] ?? 'No location specified'); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>