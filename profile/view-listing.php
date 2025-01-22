<?php
require_once '../classes/venue.class.php';
require_once '../api/coorAddressVerify.api.php';

session_start();
$venueObj = new Venue();
$venuePost = null;

$getParams = $_GET['id'];
$venueView = $venueObj->getSingleVenue($getParams);

$ratings = $venueObj->getRatings($_GET['id']);
$reviews = $venueObj->getReview($_GET['id']);

$bookings = $venueObj->getBookingByVenue($_GET['id'], 2);

$bookingCount = 0;
$bookingRevenue = 0;
$bookingThisMonth = 0;

$thumbnail = $venueView['image_urls'][$venueView['thumbnail']];
?>

<head>
    <link rel="stylesheet" href="./output.css">
</head>
<div id="openstreetmapplaceholder"></div>
<!-- Venue Details View (Initially Hidden) -->
<div id="venueDetailsView" class="container mx-auto pt-20">
    <form class="flex gap-6" id="editVenueForm">
        <!-- Main Content -->
        <div class="flex-grow">
            <div class="bg-white text-neutral-900 rounded-lg shadow-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h1 id="detailVenueName" class="text-gray-600 text-2xl viewMode">
                            <?php echo htmlspecialchars($venueView['venue_name']); ?>
                        </h1>
                        <input id="VenueName" name="editVenueName" class="text-2xl font-bold w-full editMode hidden"
                            value="<?php echo htmlspecialchars(trim($venueView['venue_name'])); ?>">
                        <button id="editVenueButton" class=" text-xs px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg flex items-center
                            gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Edit Details
                        </button>
                    </div>

                    <!-- Image Gallery -->
                    <div class="mb-6 grid grid-cols-2 gap-2 relative viewMode">
                        <div class="col-span-2 ">
                            <?php if (!empty($venueView['image_urls'])): ?>
                                <img src="./<?= htmlspecialchars($thumbnail) ?>" alt="Venue Image"
                                    class="w-full h-96 object-cover rounded-lg">
                            <?php else: ?>
                                <img src="default-image.jpg" alt="Default Venue Image"
                                    class="bg-slate-50 w-full h-96 object-cover rounded-lg">
                            <?php endif; ?>
                        </div>
                        <div class="grid grid-cols-3 col-span-2 gap-2 ">
                            <?php if (!empty($venueView['image_urls']) && count($venueView['image_urls']) > 1): ?>
                                <img src="./<?= htmlspecialchars($venueView['image_urls'][1]) ?>" alt="Venue Image"
                                    class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-75">
                            <?php else: ?>
                                <div
                                    class="bg-slate-50 w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-75 border flex items-center justify-center">
                                    <p class="text-center">No more image to show</p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($venueView['image_urls']) && count($venueView['image_urls']) > 2): ?>
                                <img src="./<?= htmlspecialchars($venueView['image_urls'][2]) ?>" alt="Venue Image"
                                    class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-75">
                            <?php else: ?>
                                <div
                                    class="bg-slate-50 w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-75 border flex items-center justify-center">
                                    <p class="text-center">No more image to show</p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($venueView['image_urls']) && count($venueView['image_urls']) > 3): ?>
                                <img src="./<?= htmlspecialchars($venueView['image_urls'][3]) ?>" alt="Venue Image"
                                    class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-75">
                            <?php else: ?>
                                <div
                                    class="bg-slate-50 w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-75 border flex items-center justify-center">
                                    <p class="text-center">No more image to show</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button
                            class="absolute text-xs border-2 border-gray-500 bottom-4 right-4 bg-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">
                            Show all photos
                        </button>
                    </div>

                    <!-- Image gallery editMode hidden -->
                    <div class="mb-6 grid-cols-3 col-span-6 gap-2 relative editMode hidden" id="editImageGallery">
                        <?php
                        // Re-index the image URLs array
                        $venueView['image_urls'] = array_values($venueView['image_urls']);

                        foreach ($venueView['image_urls'] as $index => $image_url) {
                            $isThumbnail = $index == $venueView['thumbnail']; // Check if the image is the thumbnail
                            echo '<div class="relative image-container  ' . ($isThumbnail ? 'border-4 border-blue-500' : '') . '"  id="image-' . $index . '">
                            <img  src="./' . htmlspecialchars($image_url) . '" data-bs-src="' . htmlspecialchars($image_url) . '" alt="Venue Image" class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-75" 
                                data-bs-index="' . $index . '">
                            <button class="thumbnailButton absolute top-2 left-1 text-xs text-white bg-blue-500 px-2 py-1 rounded-lg hover:bg-blue-600" data-index="' . $index . '" onclick="setThumbnail(event)">
                                Set as Thumbnail
                            </button>
                            <button class="absolute top-2 right-1 text-xs text-white bg-red-500 px-2 py-1 rounded-lg hover:bg-red-600" 
                                data-bs-marked="' . $index . '" onclick="markForDeletion(event)">Remove</button>
                        </div>';
                        }
                        ?>

                    </div>
                    <div id="newImagesContainer" class=" grid-cols-3 gap-2 editMode hidden">
                        <!-- New images will be appended here -->
                    </div>
                    <div class="mt-4 editMode hidden">
                        <input type="file" id="imageUpload" class="hidden" accept="image/*"
                            onchange="previewImage(event)">
                        <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600"
                            id="addImageTrigger">Add Image</button>
                    </div>

                    <div class="flex gap-6 w-full ">
                        <div class=" w-full">
                            <!-- Location -->
                            <div class="mb-6  w-full">
                                <h3 class="text-lg font-semibold mb-2">Location</h3>
                                <p id="detailVenueLocation" class="text-gray-600 viewMode">
                                    <?php
                                    $address = getAddressByCoordinates($venueView['venue_location']);
                                    echo htmlspecialchars(trim($address)); ?>
                                </p>
                                <div class="editMode hidden">
                                    <span class="flex items-center space-x-2">
                                        <input id="editVenueAdd" placeholder="Click the button to set a location"
                                            required type="text"
                                            class="mt-1 border block w-full p-2 editVenueAddress text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0"
                                            value="<?php echo htmlspecialchars(trim($address)); ?>" readonly />
                                        <input type="hidden" class="" id="editVenueAddCoordinates"
                                            name="editVenueAddCoor" />
                                        <button id="maps-button"
                                            class="border bg-gray-50 hover:bg-gray-100 duration-150 p-2 rounded-md">
                                            <svg height="24px" width="24px" version="1.1" id="Layer_1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                                                xml:space="preserve" fill="#bcc2bc" stroke="#bcc2bc">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <polygon points="154.64,420.096 154.64,59.496 0,134 0,512 ">
                                                    </polygon>
                                                    <polygon style="fill:#d3d5de;"
                                                        points="309.288,146.464 309.288,504.472 154.64,420.096 154.64,59.496 ">
                                                    </polygon>
                                                    <polygon
                                                        points="463.928,50.152 309.288,146.464 309.288,504.472 463.928,415.68 ">
                                                    </polygon>
                                                    <path style="fill:#e73023;"
                                                        d="M414.512,281.656l-11.92-15.744c-8.8-11.472-85.6-113.984-85.6-165.048 C317.032,39.592,355.272,0,414.512,0S512,39.592,512,100.864c0,50.992-76.8,153.504-85.488,165.048L414.512,281.656z">
                                                    </path>
                                                    <circle style="fill:#FFFFFF;" cx="414.512" cy="101.536" r="31.568">
                                                    </circle>
                                                </g>
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Description</h3>
                                <p id="detailVenueDescription" class="text-gray-600 viewMode">
                                    <?php echo trim(htmlspecialchars($venueView['venue_description'])); ?>
                                </p>
                                <textarea id="editVenueDescription" name="editVenueDescription"
                                    class="w-full rounded-md editMode hidden"
                                    rows="4"><?php echo trim(htmlspecialchars($venueView['venue_description'])); ?></textarea>
                            </div>

                            <!-- Capacity -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Capacity</h3>
                                <p id="detailVenueCapacity" class="text-gray-600 viewMode">
                                    <?php echo trim(htmlspecialchars($venueView['capacity'])); ?> guests
                                </p>
                                <input type="number" id="VenueCapacity" name="editVenueCapacity" class=" w-full rounded-md editMode hidden"
                                    value=<?php echo trim(htmlspecialchars($venueView['capacity'])); ?>>
                            </div>

                            <!-- Amenities -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">What this place offers</h3>
                                <?php if (!empty($venueView['amenities'])): ?>
                                    <?php
                                    $amenities = json_decode($venueView['amenities'], true);
                                    if ($amenities):
                                        ?>
                                        <ul class="list-disc pl-5 space-y-1 viewMode">
                                            <?php foreach ($amenities as $amenity): ?>
                                                <li class="text-sm text-gray-800 leading-tight">
                                                    <?= htmlspecialchars($amenity) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="text-sm text-gray-500">No amenities available</p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="text-sm text-gray-500">No amenities available</p>
                                <?php endif; ?>
                                <textarea type="text" id="editVenueAmenities" name="editVenueAmenities"
                                    class="editMode hidden space-y-2  w-full" rows="4"><?php
                                    if ($amenities):
                                        $formattedAmenities = implode(', ', array_map('htmlspecialchars', $amenities));
                                        echo trim($formattedAmenities);
                                    endif;
                                    ?></textarea>
                            </div>

                            <!-- Venue Rules -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Venue Rules</h3>
                                <?php if (!empty($venueView['rules'])): ?>
                                    <?php
                                    $rules = json_decode($venueView['rules'], true);
                                    if ($rules):
                                        ?>
                                        <ul class="list-disc pl-5 space-y-1 viewMode">
                                            <?php foreach ($rules as $rule): ?>
                                                <li class="text-sm text-gray-800 leading-tight">
                                                    <?= htmlspecialchars($rule) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="text-sm text-gray-500">No Rules Stated</p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="text-sm text-gray-500">No Rules Stated</p>
                                <?php endif; ?>
                                <textarea type="text" id="editVenueRules" name="editVenueRules"
                                    class="editMode hidden space-y-2  w-full" rows="4"><?php
                                    if ($rules):
                                        $formattedRules = implode(', ', array_map('htmlspecialchars', $rules));
                                        echo trim($formattedRules);
                                    endif;
                                    ?></textarea>
                            </div>

                            <!-- Cancellation Policy -->
                            <!-- <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Cancellation Policy</h3>
                                <div class="viewMode">
                                    <div id="detailCancellationPolicy" class="text-gray-600"></div>
                                </div>
                                <div class="editMode hidden">
                                    <select id="editCancellationPolicy" class=" rounded-md w-full mb-2">
                                        <option value="flexible">Flexible - Full refund 24 hours prior</option>
                                        <option value="moderate">Moderate - Full refund 5 days prior</option>
                                        <option value="strict">Strict - 50% refund 7 days prior</option>
                                        <option value="custom">Custom Policy</option>
                                    </select>
                                    <textarea id="editCustomPolicy" class=" w-full rounded-md mt-2 hidden" rows="4"
                                        placeholder="Enter your custom cancellation policy..."></textarea>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Ratings & Reviews Section - Moved to bottom -->
            <div class="bg-white rounded-lg shadow-sm mt-6 p-6">
                <h3 class="text-2xl font-bold mb-6">Ratings & Reviews</h3>

                <!-- Rating Summary -->
                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <div class="flex items-center gap-8">
                        <!-- Overall Rating -->
                        <div class="text-center">
                            <div class="text-5xl font-bold mb-1">
                                <?php echo number_format($ratings['average'], 1) ?>
                            </div>
                            <div class="flex items-center justify-center text-yellow-400 mb-1">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <!-- Repeat stars for 5 total -->
                            </div>
                            <div class="text-sm text-gray-600">
                                <?php echo htmlspecialchars($ratings['total']) ?? 0 ?> reviews
                            </div>
                        </div>

                        <!-- Rating Breakdown -->
                        <div class="flex-grow">
                            <div class="space-y-2">
                                <?php
                                $totalReviews = isset($ratings['total']) ? (int) $ratings['total'] : 0;
                                $rate = [
                                    5 => isset($ratings['rating_5']) ? (int) $ratings['rating_5'] : 0,
                                    4 => isset($ratings['rating_4']) ? (int) $ratings['rating_4'] : 0,
                                    3 => isset($ratings['rating_3']) ? (int) $ratings['rating_3'] : 0,
                                    2 => isset($ratings['rating_2']) ? (int) $ratings['rating_2'] : 0,
                                    1 => isset($ratings['rating_1']) ? (int) $ratings['rating_1'] : 0,
                                ];

                                // Find the maximum review count to normalize widths
                                $maxReviewCount = max($rate);

                                for ($i = 5; $i >= 1; $i--):
                                    $count = isset($rate[$i]) ? $rate[$i] : 0; // Count of reviews for the current star rating
                                    // Normalize percentage based on $maxReviewCount
                                    $normalizedPercentage = $maxReviewCount > 0 ? (($count) / $ratings['total']) * 100 : 0;
                                    ?>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm w-16"><?php echo $i; ?> stars</span>
                                        <!-- Set explicit max width -->
                                        <div class="flex-grow h-2 bg-gray-200 rounded max-w-[500px]">
                                            <!-- Dynamically set the width based on normalized percentage -->
                                            <div class="h-full bg-yellow-400 rounded"
                                                style="width: <?php echo $normalizedPercentage; ?>%;"></div>
                                        </div>
                                        <span class="text-sm w-8"><?php echo $count; ?></span>
                                    </div>
                                <?php endfor; ?>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Individual Reviews -->
                <div class="mt-8 space-y-6">
                    <?php foreach ($reviews as $index => $review): ?>
                        <div class="border-b pb-6 review" data-index="<?php echo $index; ?>"
                            style="<?php echo $index === 0 ? '' : 'display: none;'; ?>">
                            <div class="flex items-center gap-4 mb-4">
                                <?php if ($review['profile_pic'] == null): ?>
                                    <div
                                        class="w-12 h-12 bg-black text-white rounded-full flex items-center justify-center font-bold">
                                        <?php echo htmlspecialchars($review['user_name'][0]); ?>
                                    </div>
                                <?php else: ?>
                                    <img class="w-12 h-12 bg-gray-200 rounded-full"
                                        src="./<?php echo htmlspecialchars($review['profile_pic']); ?>" alt="Profile Picture">
                                <?php endif; ?>
                                <div>
                                    <a href="user-page.php"
                                        class="font-semibold hover:underline"><?php echo htmlspecialchars($review['user_name']); ?></a>
                                    <p class="text-sm text-gray-500">
                                        <?php
                                        $originalDate = $review['date'];
                                        $formattedDate = date('F j, Y \a\t g:i A', strtotime($originalDate));
                                        echo htmlspecialchars($formattedDate);
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <div class="flex text-yellow-400 mb-2">
                                <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <p class="text-gray-700"><?php echo htmlspecialchars($review['review']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-center gap-2 mt-6">
                    <button id="prevReview"
                        class="px-4 py-2 text-sm border w-24 bg-neutral-200 transition-all duration-150 text-gray-600 hover:bg-gray-100 rounded">Previous</button>
                    <button id="nextReview"
                        class="px-4 py-2 text-sm border w-24 bg-neutral-200 transition-all duration-150 text-gray-600 hover:bg-gray-100 rounded">Next</button>
                </div>
            </div>

            <!-- After the Ratings & Reviews section, add this new Calendar Pricing section -->
            <div class="bg-white rounded-lg shadow-sm mt-6 p-6">
                <h3 class="text-2xl font-bold mb-6">Calendar & Pricing</h3>

                <!-- Calendar Header -->
                <div class="flex justify-between items-center mb-4 calendar-header">
                    <div class="flex items-center space-x-4">
                        <button class="p-2 hover:bg-gray-100 rounded-lg calendar-prev">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <h4 class="text-lg font-semibold">October 2024</h4>
                        <button class="p-2 hover:bg-gray-100 rounded-lg calendar-next">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 text-sm border rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </button>
                        <button class="px-3 py-1 text-sm border rounded-lg hover:bg-gray-50">View</button>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="border rounded-lg">
                    <!-- Calendar Header -->
                    <div class="grid grid-cols-7 text-sm font-medium text-gray-500 border-b">
                        <div class="p-2 text-center">Su</div>
                        <div class="p-2 text-center">Mo</div>
                        <div class="p-2 text-center">Tu</div>
                        <div class="p-2 text-center">We</div>
                        <div class="p-2 text-center">Th</div>
                        <div class="p-2 text-center">Fr</div>
                        <div class="p-2 text-center">Sa</div>
                    </div>

                    <!-- Calendar Days -->
                    <div class="grid grid-cols-7 calendar-days">
                        <?php
                        // Previous month days (greyed out)
                        for ($i = 0; $i < 0; $i++) {
                            echo '<div class="p-2 border-b border-r text-gray-400"></div>';
                        }

                        // Current month days
                        for ($day = 1; $day <= 31; $day++) {
                            $isToday = $day === 5; // Example: 5th is today
                            $hasPrice = true; // Example: All days have prices
                        
                            echo '<div class="relative p-2 border-b border-r hover:bg-gray-50 cursor-pointer">';
                            echo '<div class="text-sm ' . ($isToday ? 'font-bold' : '') . '">' . $day . '</div>';
                            if ($hasPrice) {
                                echo '<div class="text-xs text-gray-600"> ₱' . $venueView['price'] . '</div>';
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Settings Panel -->
                <!-- <div class="mt-6 border rounded-lg p-4">
                    <h4 class="text-lg font-semibold mb-4">Settings</h4>
                    <p class="text-sm text-gray-600 mb-4">These apply to all nights, unless you customize them
                        by date.</p>

                    <!-- Pricing Tab -->
                <!-- <div class="border-b pb-4 mb-4">
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Base price</span>
                        <span class="text-sm text-gray-500">PHP</span>
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm text-gray-600 mb-1">Per night</label>
                        <p>₱ <?php echo htmlspecialchars($venueView['price']) ?></p>
                    </div>
                </div> -->

                <!-- Custom Weekend Price -
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Custom weekend price</span>
                            <button class="text-sm text-blue-600 hover:text-blue-800">Add</button>
                        </div>
                    </div>

                    <!-- Smart Pricing Toggle -
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="font-medium block">Smart Pricing</span>
                            <span class="text-sm text-gray-600">Adjust your pricing to attract more
                                guests.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </div>
                </div> -->
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="w-96">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Venue Settings</h3>

                    <!-- Venue Status -->
                     <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="">Venue Status</span>
                            <p><?php echo htmlspecialchars($venueView['availability_id'] == 1 ? "Active" : "Onhold") ?></p>
                        </div>
                     </div>
                     <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Venue Status</label>
                        <div class=" flex items-center gap-2">
                            <div class="flex items center gap-2">
                                <label class="switch">
                                    <input type="radio" name="editVenueStatus" id="editVenueStatus" <?php echo ($venueView['availability_id'] == 1) ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                                <span class="text-sm text-gray-600">Active</span>
                            </div>
                            <div class="flex items center gap-2">
                                <label class="switch">
                                    <input type="radio" name="editVenueStatus" id="editVenueStatus" <?php echo ($venueView['availability_id'] == 2) ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                                <span class="text-sm text-gray-600">Onhold</span>
                            </div>
                        </div>
                     </div>

                    <!-- Venue Type -->
                      <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="">Venue Status</span>
                            <p><?php 
                            $venueType = $venueView['venue_tag'];

                            switch ($venueType) {
                                case 1:
                                    echo "Corporate Events";
                                    break;
                                case 2:
                                    echo "Reception Hall";
                                    break;
                                case 3:
                                    echo "Intimate Gatherings";
                                    break;
                                case 4:
                                    echo "Outdoor";
                                    break;
                                default:
                                    echo "Unknown";
                                    break;
                            }
                            ?></p>
                        </div>
                    </div>
                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Venue Type</label>
                        <select class="block w-full p-2 pl-10 text-sm text-gray-700 rounded-md" name="editVenueType"
                            id="">
                            <option value="1" <?php echo ($venueView['venue_tag'] == 1) ? 'selected' : ''; ?>>Corporate Events</option>
                            <option value="2" <?php echo ($venueView['venue_tag'] == 2) ? 'selected' : ''; ?>>Reception Hall</option>
                            <option value="3" <?php echo ($venueView['venue_tag'] == 3) ? 'selected' : ''; ?>>Intimate Gatherings</option>
                            <option value="4" <?php echo ($venueView['venue_tag'] == 4) ? 'selected' : ''; ?>>Outdoor</option>
                        </select>
                    </div>


                    <!-- Price Setting -->
                     <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="">Price per day</span>
                            <p>₱<?php echo htmlspecialchars($venueView['price']) ?></p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price per day</label>
                        <div class="flex items-center">
                            <span class="text-gray-500 mr-2">₱</span>
                            <input type="number" id="venuePrice" name="editVenuePrice" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['price']) ?>">
                        </div>
                    </div>

                    <!-- Down Payment Options -->
                     <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="">Down Payment Options</span>
                            <p><?php
                            $downPayment = $venueView['down_payment_id'];
                            $downPaymentName = $downPayment == 1 ? '30% Down Payment' : ($downPayment == 2 ? '50% Down Payment' : 'Full Payment Required');
                            echo htmlspecialchars($downPaymentName);
                            ?></p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Down Payment
                            Required</label>
                        <select class=" rounded-md w-full" name="editDownPayment" id="editDownPayment">
                            <option value="30" <?php echo ($venueView['down_payment_id'] == 1) ? 'selected' : ''; ?>>30%
                                of
                                total amount
                            </option>
                            <option value="50" <?php echo ($venueView['down_payment_id'] == 2) ? 'selected' : ''; ?>>50%
                                of
                                total amount
                            </option>
                            <option value="100" <?php echo ($venueView['down_payment_id'] == 3) ? 'selected' : ''; ?>>Full
                                payment
                                required</option>
                        </select>
                    </div>


                    <!-- Entrance -->
                     <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="">Entrance per person</span>
                            <p>₱<?php echo htmlspecialchars($venueView['entrance']) ?></p>
                        </div>
                    </div>
                    
                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Entrance per person</label>
                        <div class="flex items-center">
                            <span class="text-gray-500 mr-2">₱</span>
                            <input type="number" id="venueEntrance" name="editVenueEntrance" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['entrance']) ?>">
                        </div>
                    </div>

                    <!-- Cleaning Fee -->
                      <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="">Cleaning Fee</span>
                            <p>₱<?php echo htmlspecialchars($venueView['cleaning']) ?></p>
                        </div>
                    </div>

                    
                    
                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cleaning Fee</label>
                        <div class="flex items-center">
                            <span class="text-gray-500 mr-2">₱</span>
                            <input type="number" id="venueCleaning" name="editVenueCleaning" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['cleaning']) ?>">
                        </div>
                    </div>


                    <!-- Discounts -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Discounts</label>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <input type="number" placeholder="%" class=" rounded-md w-20">
                                <input type="text" placeholder="Discount name" class=" rounded-md flex-grow">
                                <button class="p-2 text-red-500 hover:bg-red-50 rounded-md">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <button class="text-sm text-blue-600 hover:text-blue-800">+ Add new
                                discount</button>
                        </div>
                    </div>

                    <!-- Save Changes Button -->
                    <button onclick="saveChanges(event)"
                        class="w-full bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-800 mt-4">
                        Save Changes
                    </button>
                </div>

                <?php
                $currentMonth = new DateTime(); // Defaults to the current date and time
                foreach ($bookings as $booking) {
                    $bookingCount += $booking['booking_count']; // Aggregate booking count
                    $bookingRevenue += $booking['booking_grand_total']; // Aggregate revenue
                
                    $bookingEndDate = new DateTime($booking['booking_end_date']);

                    if (
                        $bookingEndDate->format('Y') === $currentMonth->format('Y') &&
                        $bookingEndDate->format('m') === $currentMonth->format('m')
                    ) {
                        $bookingThisMonth += 1; // Increment count for bookings this month
                    }
                }
                ?>

                <?php
                // var_dump($bookings);
                ?>

                <!-- Quick Stats -->
                <div class="border-t pt-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Booking Statistics</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm text-gray-600">Total Bookings</p>
                            <p class="text-xl font-semibold"><?php echo htmlspecialchars($bookingCount) ?></p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm text-gray-600">This Month</p>
                            <p class="text-xl font-semibold"><?php echo htmlspecialchars($bookingThisMonth) ?></p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm text-gray-600">Revenue</p>
                            <p class="text-xl font-semibold">₱<?php echo htmlspecialchars($bookingRevenue) ?></p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-sm text-gray-600">Rating</p>
                            <p class="text-xl font-semibold"><?php echo number_format($ratings['average'], 1) ?>/5</p>
                        </div>
                    </div>
                </div>

                <!-- New Reservation History Section -->
                <div class="border-t pt-6 mt-6">
                    <h4 class="text-lg font-semibold mb-4">Recent Reservations</h4>
                    <div class="space-y-4">

                        <?php
                        if (empty($bookings)) {
                            echo '<p class="text-gray-600 text-xs text-center">No bookings found.</p>';
                        }
                        foreach ($bookings as $booking):
                            ?>
                            <!-- Sample Reservation Items -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-medium">Wedding Reception</p>
                                        <p class="text-sm text-gray-600">
                                            <?php echo htmlspecialchars($booking['firstname'] . " " . $booking['middlename'] . "." . " " . $booking['lastname']); ?>
                                        </p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Confirmed
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <p class="text-gray-600 mt-1">
                                        <?php
                                        $startDate = new DateTime($booking['booking_start_date']);
                                        $endDate = new DateTime($booking['booking_end_date']);
                                        echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                        ?>
                                    </p>
                                </div>
                                <p>₱<?php echo htmlspecialchars($booking['booking_grand_total']) ?></p>
                            </div>
                            <?php
                        endforeach;
                        ?>
                    </div>



                    <!-- <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-medium">Birthday Party</p>
                                    <p class="text-sm text-gray-600">John Cruz</p>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <p>Dec 20, 2024</p>
                                <p>₱12,000</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-medium">Corporate Event</p>
                                    <p class="text-sm text-gray-600">Tech Corp.</p>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Completed
                                </span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <p>Nov 30, 2024</p>
                                <p>₱20,000</p>
                            </div>
                        </div> -->

                    <!-- View All Reservations Link -->
                    <div class="mt-4 text-center">
                        <a href="calendar.php" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View All Reservations →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</>

<script>

    // Temporary arrays to track changes
    let imagesToDelete = [];
    let newImages = [];
    let isEditVenue = false;
    let thumbnailIndex;
    // const submitButton = document.getElementById('saveChanges');

    // Initialize: Hide edit-mode elements
    document.querySelectorAll('.editMode').forEach(function (element) {
        element.classList.add('hidden');
    });


    // Toggle edit mode
    // Store the initial HTML of the editImageGallery
    const originalEditImageGalleryHTML = document.getElementById('editImageGallery').innerHTML;

    document.getElementById('editVenueButton').addEventListener('click', function (e) {
        e.preventDefault();

        if (isEditVenue) {
            // submitButton.disabled = true;
            // Reset edit mode
            document.getElementById('editVenueButton').innerText = 'Edit Details';

            // Reset the editImageGallery content to its original state
            document.getElementById('editImageGallery').innerHTML = originalEditImageGalleryHTML;

            // Show all the removed images before clearing the array
            imagesToDelete.forEach(index => {
                const imageDiv = document.getElementById(`image-${index}`);
                if (imageDiv) {
                    imageDiv.style.display = ''; // Reset to its default display value
                }
            });

            // Clear the removed images array and new images
            imagesToDelete = [];
            newImages = [];
            document.getElementById('newImagesContainer').innerHTML = '';
            document.getElementById('imageUpload').value = '';

        } else {
            // submitButton.disabled = false;
            document.getElementById('editVenueButton').innerText = 'Cancel Editing';
        }

        // Toggle visibility of view/edit modes
        document.querySelectorAll('.viewMode').forEach(function (element) {
            element.classList.toggle('hidden');
        });
        document.querySelectorAll('.editMode').forEach(function (element) {
            element.classList.toggle('hidden');
        });

        // Toggle gallery grids
        document.getElementById('editImageGallery').classList.toggle('grid');
        document.getElementById('newImagesContainer').classList.toggle('grid');

        isEditVenue = !isEditVenue;
    });

    // Trigger file upload
    document.getElementById('addImageTrigger').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('imageUpload').click();
    });

    function setThumbnail(e) {
        e.preventDefault();

        // Get the index from the button's data attribute
        thumbnailIndex = e.target.getAttribute('data-index');

        // Remove the blue border from all images
        document.querySelectorAll('.image-container').forEach((container) => {
            container.classList.remove('border-4', 'border-blue-500');
        });

        // Add the blue border to the selected image
        const selectedImage = document.getElementById(`image-${thumbnailIndex}`);
        if (selectedImage) {
            selectedImage.classList.add('border-4', 'border-blue-500');
        }

        // Optionally update the thumbnail value in your backend via AJAX
        console.log(`Thumbnail set to index: ${thumbnailIndex}`);

        // // Toggle visibility of all thumbnail buttons
        // document.querySelectorAll('.thumbnailButton').forEach((button) => {
        //     if (button.getAttribute('data-index') === index) {
        //         button.classList.remove('hidden');
        //     } else {
        //         button.classList.add('hidden');
        //     }
        // });
    }



    // Mark an image for deletion
    function markForDeletion(e) {
        e.preventDefault();

        const index = e.target.getAttribute('data-bs-marked');

        // Add the index to the deletion list
        if (!imagesToDelete.includes(index)) {
            imagesToDelete.push(index);
        }

        // Remove the corresponding image container
        const imageContainer = e.target.closest('.image-container');
        if (imageContainer) {
            imageContainer.remove();
        }

        // Update the indices of remaining images
        const remainingImages = [];
        document.querySelectorAll('.image-container').forEach((container, newIndex) => {
            // Update the container's id and relevant attributes
            container.id = `image-${newIndex}`;
            container.querySelector('img').setAttribute('data-bs-index', newIndex);
            container.querySelector('.thumbnailButton').setAttribute('data-index', newIndex);
            container.querySelector('[data-bs-marked]').setAttribute('data-bs-marked', newIndex);

            // Collect remaining image data from data-bs-src
            const imgDataSrc = container.querySelector('img').getAttribute('data-bs-src');
            if (imgDataSrc) {
                remainingImages.push(imgDataSrc);
            }

        });
        if (thumbnailIndex == index) {
            thumbnailIndex = 0;
        }

        if (index < thumbnailIndex) {
            thumbnailIndex--;
        }

        if (index > thumbnailIndex) {
            thumbnailIndex = thumbnailIndex;
        }
        // Log the remaining images
        console.log("Remaining Images:", remainingImages);
        console.log("Thumbnail index: ", thumbnailIndex);
        console.log("remaining length: ", remainingImages.length - 1);


    }


    // Preview newly added images
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const container = document.createElement('div');
                container.className = 'relative image-container';
                container.innerHTML = `
                    <img src="${e.target.result}" alt="New Image" class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-75">
                    <button class="absolute top-2 right-2 text-xs text-white bg-red-500 px-2 py-1 rounded-lg hover:bg-red-600" data-bs-newImage="${file.name}" onclick="removeNewImage(event)">Remove</button>
                `;
                document.getElementById('newImagesContainer').appendChild(container);
            };
            reader.readAsDataURL(file);

            newImages.push(file);
        }
    }

    // Remove a newly added image
    function removeNewImage(event) {
        event.preventDefault();

        const filename = event.target.getAttribute('data-bs-newImage');
        newImages = newImages.filter(image => image.name !== filename);

        const container = event.target.parentElement;
        if (container) {
            container.remove();
        }
    }

    // Save changes
    function saveChanges(e) {
        e.preventDefault();

        const form = document.querySelector('#editVenueForm'); // Form element
        const formData = new FormData(form); // Create FormData from the form

        formData.append('imagesToDelete', JSON.stringify(imagesToDelete));

        formData.append('thumbnailIndex', thumbnailIndex ?? <?php echo $venueView['thumbnail'] ?>);

        formData.append('venueID', <?php echo $getParams?>);
        // Append new images as files, not as JSON string
        newImages.forEach(file => {
        console.log(file);  // Log each file to inspect the details
        formData.append('newImages[]', file);  // Append each new image file to the FormData
    });

    // Optional: Log the FormData object to inspect the data
    for (let [key, value] of formData.entries()) {
        console.log(`${key}:`, value);  // Log each key-value pair in the FormData
    }
        // newImages.forEach((image, index) => {
        //     formData.append(`newImages[${index}]`, image);
        // });

        // fetch('manage_images.php', {
        //     method: 'POST',
        //     body: formData,
        // })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.success) {
        //             alert('Changes saved successfully.');
        //             location.reload();
        //         } else {
        //             alert(`Failed to save changes: ${data.error || 'Unknown error'}`);
        //         }
        //     })
        //     .catch(error => {
        //         console.error('Error:', error);
        //         alert('An error occurred while saving changes.');
        //     });
    }
</script>