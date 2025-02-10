<?php
require_once '../classes/account.class.php';

session_start();

$accountObj = new Account();
$USER_ID = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$bookmarks = $accountObj->getBookmarks($USER_ID);
$bookmarkIds = array_column($bookmarks, 'venue_id');
?>

<main class="max-w-7xl mx-auto py-6 pt-20 sm:px-6 lg:px-8">
    <div class="px-4 sm:px-0" id="mainContent">
        <!-- Main Listings View -->
        <div id="bookmarksView">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Your Bookmarks
                </h1>
            </div>

            <?php

            if (empty($bookmarks)) {
                echo '<p class="text-gray-500 text-left">No Bookmarks found.</p>';
            }
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                foreach ($bookmarks as $venue) {
                    $isBookmarked = in_array($venue['id'], $bookmarkIds);
                    ?>
                    <div class="bg-slate-50 rounded-2xl overflow-hidden shadow-md cursor-pointer">
                        <div class="relative">
                            <!-- Slideshow Container for each venue -->
                            <div class="relative w-full h-96 overflow-hidden">
                                <!-- Image Slideshow for each venue -->
                                <div class="slideshow venueCard" data-id="venues.php?id=<?php echo $venue['venue_id']; ?>"
                                    data-isloggedin="<?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>">
                                    <?php if (!empty($venue['image_urls'])): ?>
                                        <?php foreach ($venue['image_urls'] as $index => $imageUrl): ?>
                                            <div class="slide <?= $index === 0 ? 'active' : '' ?>">
                                                <img src="./<?= htmlspecialchars($imageUrl) ?>"
                                                    alt="<?= htmlspecialchars($venue['name']) ?>"
                                                    class="w-full h-full object-cover rounded-t-2xl transition-opacity duration-1000">
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <?php if (isset($venue['venue_tag_name'])): ?>
                                    <span
                                        class="absolute top-3 left-3 bg-slate-50 text-black text-xs font-semibold px-2 py-1 rounded-full z-50">
                                        <?= htmlspecialchars($venue['venue_tag_name']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <!-- Button (can be used for manual control) -->
                            <button id="bookmarkBtn" data-venueId="<?php echo htmlspecialchars($venue['id']); ?>"
                                data-userId="<?php echo htmlspecialchars($_SESSION['user']['id']); ?>"
                                class="bookmark-btn absolute top-3 right-3 z-50 <?php echo $isBookmarked ? 'bookmarked' : 'text-white'; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>


                            <!-- Venue details below the slideshow -->
                            <div class="p-4 ">
                                <div class="flex justify-between items-center mb-1">
                                    <h3 class="text-base font-semibold text-gray-900">
                                        <?= htmlspecialchars($venue['name']) ?>
                                    </h3>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 mr-1"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>

                                <p class="text-sm text-gray-500 leading-tight line-clamp-2">
                                    <?= htmlspecialchars($venue['description']) ?>
                                </p>



                                <p class="mt-2">
                                    <span
                                        class="font-semibold text-gray-900 text-base">₱<?= number_format($venue['price'], 2) ?></span>
                                    <span class="text-gray-900 text-sm"> per night</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</main>