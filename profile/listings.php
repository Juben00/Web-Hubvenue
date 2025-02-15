<?php
require_once '../classes/venue.class.php';
require_once '../classes/account.class.php';
require_once '../api/coorAddressVerify.api.php';

session_start();

$venueObj = new Venue();
$accountObj = new Account();

$USER_ID = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$userRole = $accountObj->getUserRole($USER_ID);
$venuePost = $venueObj->getAllVenues('', '', $USER_ID);

$HOST_ROLE = "Host";
$GUEST_ROLE = "Guest";

?>
<main class="max-w-7xl mx-auto py-6 pt-20 sm:px-6 lg:px-8">
    <div class="px-4 sm:px-0" id="mainContent">
        <!-- Main Listings View -->
        <div id="listingsView">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-medium">Your listings</h1>
                <?php if ($userRole == $HOST_ROLE) { ?>
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
            if ($userRole == $GUEST_ROLE) {
                echo '<p class="text-gray-500 text-left">You need to apply for Host Account before you can list your venue.</p>';
            }

            if (empty($venuePost)) {
                echo '<p class="text-gray-500 text-left">No listings found.</p>';
            }
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($venuePost as $venue):
                    // $address = getAddressByCoordinates($venue['location']);
                    ?>
                    <div class="cursor-pointer venue-card relative group"
                        data-id="<?php echo htmlspecialchars($venue['venue_id']); ?>">
                        <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition duration-300">
                            <div class="relative">
                                <?php
                                switch ($venue['status']) {
                                    case 'Approved':
                                        echo '<div class="absolute top-2 text-white px-2 py-1 rounded-full text-xs p-1" style="right: 0.5rem; background-color: #3f3f46;">Approved</div>';
                                        break;
                                    case 'Pending':
                                        echo '<div class="absolute top-2 text-white px-2 py-1 rounded-full text-xs p-1" style="right: 0.5rem; background-color: #3f3f46;">Pending</div>';
                                        break;
                                    case 'Declined':
                                        echo '<div class="absolute top-2 text-white px-2 py-1 rounded-full text-xs p-1" style="right: 0.5rem; background-color: #3f3f46;">Declined</div>';
                                        break;
                                }
                                ?>
                                <img src="./<?php echo !empty($venue['image_urls'][0]) ? $venue['image_urls'][$venue['thumbnail']] : '../images/black_ico.png'; ?>"
                                    alt="<?php echo htmlspecialchars($venue['name'] ?? 'Venue'); ?>"
                                    class="w-full h-48 object-cover">
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-medium text-lg"><?php echo htmlspecialchars($venue['name']); ?></h3>

                                </div>
                                <p class="text-gray-500 text-sm mt-1">
                                    <?php echo htmlspecialchars($venue['venue_tag_name'] ?? 'No tag specified'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>