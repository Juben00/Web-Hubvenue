<?php
require_once '../classes/venue.class.php';

session_start();

$venueObj = new Venue();
$venuePost = $venueObj->getAllVenues($status, $_SESSION['user']['id']);
?>

<main class="max-w-7xl mx-auto py-6 pt-20 sm:px-6 lg:px-8">
    <div class="px-4 sm:px-0" id="mainContent">
        <!-- Main Listings View -->
        <div id="bookmarksView">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Your Bookmarks</h1>
                <?php if ($_SESSION['user']['user_type_id'] === 2) { ?>
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
                <?php } ?>
            </div>

            <?php
            if ($_SESSION['user']['user_type_id'] !== 2) {
                echo '<p class="text-gray-500 text-left">You need to apply for Host Account before you can list your venue.</p>';
            }

            if (empty($venuePost)) {
                echo '<p class="text-gray-500 text-left">No listings found.</p>';
            }
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($venuePost as $venue): ?>
                    <a class="venue-card cursor-pointer" data-id="<?php echo htmlspecialchars($venue['venue_id']); ?>">
                        <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition duration-300">
                            <div class="relative">
                                <?php if ($venue['status'] === "Pending") { ?>
                                    <div
                                        class="absolute top-2 right-2 border border-yellow-600 bg-yellow-500 text-white px-2 py-1 rounded-full text-sm">
                                        Complete Listing
                                    </div>
                                <?php } else if ($venue['status'] === "Declined") { ?>
                                        <div
                                            class="absolute top-2 right-2 border border-red-600 bg-red-500 text-white px-2 py-1 rounded-full text-sm">
                                            Post Declined
                                        </div>
                                <?php } else if ($venue['status'] === "Declined") { ?>
                                            <div
                                                class="absolute top-2 right-2 border border-red-600 bg-red-500 text-white px-2 py-1 rounded-full text-sm">
                                                Pending
                                            </div>
                                <?php } else if ($venue['status'] === "Approved") { ?>
                                                <div
                                                    class="absolute top-2 right-2 border border-green-600 bg-green-500 text-white px-2 py-1 rounded-full text-sm">
                                                    Venue Approved
                                                </div>
                                <?php } ?>
                                <img src="./<?php echo !empty($venue['image_urls'][0]) ? $venue['image_urls'][0] : '../images/black_ico.png'; ?>"
                                    alt="<?php echo htmlspecialchars($venue['name'] ?? 'Venue'); ?>"
                                    class="w-full h-48 object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="font-medium text-lg mb-1"><?php echo htmlspecialchars($venue['name']); ?></h3>
                                <p class="text-gray-500 text-sm mb-2">
                                    <?php echo htmlspecialchars($venue['location'] ?? 'No location specified'); ?>
                                </p>
                                <!-- <p class="text-black font-semibold">
                                    <?php echo htmlspecialchars($venue['price'] ?? 'Price not specified'); ?> / day
                                </p> -->
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>