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
<!-- Initialize JavaScript variables -->
<script>
// Global variables
window.venueState = {
    isEditVenue: false,
    imagesToDelete: [],
    newImages: [],
    thumbnailIndex: <?php echo $venueView['thumbnail'] ?>
};
</script>

<!-- Tab Navigation -->
<div class="container mx-auto pt-20 px-6">
    <div class="flex border-b mb-6" id="tab-buttons">
        <button type="button" class="px-8 py-3 text-sm font-medium border-b-2 tab-button" data-tab="venue-details">
            Venue Details
        </button>
        <button type="button" class="px-8 py-3 text-sm font-medium border-b-2 tab-button" data-tab="venue-settings">
            Venue Settings
        </button>
        <button type="button" class="px-8 py-3 text-sm font-medium border-b-2 tab-button" data-tab="ratings-reviews">
            Ratings & Reviews
        </button>
        <button type="button" class="px-8 py-3 text-sm font-medium border-b-2 tab-button" data-tab="calendar-pricing">
            Calendar & Pricing
        </button>
    </div>

    <form id="editVenueForm" enctype="multipart/form-data">
        <!-- Tab Content -->
        <div class="tab-content flex gap-8">
            <!-- Main Content Area -->
        <div class="flex-grow">
                <!-- Venue Details Tab -->
                <div id="venue-details" class="tab-pane">
                    <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h1 id="detailVenueName" class="text-gray-600 text-2xl viewMode">
                            <?php echo htmlspecialchars($venueView['venue_name']); ?>
                        </h1>
                        <input id="VenueName" name="editVenueName" class="text-2xl font-bold w-full editMode hidden"
                            value="<?php echo htmlspecialchars(trim($venueView['venue_name'])); ?>">
                                <button id="editVenueButton" class="text-xs px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg flex items-center gap-2">
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
                        echo '<div class="relative image-container ' . ($isThumbnail ? 'border-4 border-blue-500' : '') . ' group" id="image-' . $index . '">
        <img src="./' . htmlspecialchars($image_url) . '" data-bs-src="' . htmlspecialchars($image_url) . '" alt="Venue Image" class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-75" 
            data-bs-index="' . $index . '">
        <button class="thumbnailButton absolute top-2 left-1 text-xs text-white bg-blue-500 px-2 py-1 rounded-lg hover:bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300" data-index="' . $index . '" onclick="setThumbnail(event)">
            Set as Thumbnail
        </button>
        <button class="absolute top-2 right-1 text-xs text-white bg-red-500 px-2 py-1 rounded-lg hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300" 
            data-bs-marked="' . $image_url . '" onclick="markForDeletion(event)">Remove</button>
    </div>';
                    }
                    ?>

                    </div>
                    <div id="newImagesContainer" class=" grid-cols-3 gap-2 editMode hidden">
                        <!-- New images will be appended here -->
                    </div>
                    <div class="mt-4 editMode hidden">
                        <input type="file" id="imageUpload" class="hidden" accept="image/*" multiple
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
                                    // $address = getAddressByCoordinates($venueView['venue_location']);
                                    echo htmlspecialchars(trim($venueView['address'])); ?>
                                </p>
                                <div class="editMode hidden">
                                    <span class="flex items-center space-x-2">
                                        <input id="editVenueAdd" placeholder="Click the button to set a location"
                                            required type="text"
                                            class="mt-1 border block w-full p-2 editVenueAddress text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0"
                                            value="<?php echo htmlspecialchars(trim($venueView['address'])); ?>" readonly />
                                        <input type="hidden" class="" id="editVenueAddCoordinates"
                                            name="editVenueAddCoor" value="<?php echo htmlspecialchars($venueView['venue_location']) ?>"/>
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
            </div>

                <!-- Ratings & Reviews Tab -->
                <div id="ratings-reviews" class="tab-pane">
                    <div class="bg-white rounded-lg shadow-sm p-8">
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
            </div>

                <!-- Calendar & Pricing Tab -->
                <div id="calendar-pricing" class="tab-pane">
                    <div class="bg-white rounded-lg shadow-sm p-8">
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
                                <h4 class="text-lg font-semibold calendar-month">October 2024</h4>
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
                                // Get booked dates for this venue
                                $bookedDates = $venueObj->getBookedDates($getParams);
                                $bookedDatesArray = [];
                                
                                // Convert booked dates to array for easy checking
                                foreach ($bookedDates as $booking) {
                                    $start = new DateTime($booking['startdate']);
                                    $end = new DateTime($booking['enddate']);
                                    $interval = new DateInterval('P1D');
                                    $dateRange = new DatePeriod($start, $interval, $end->modify('+1 day'));
                                    
                                    foreach ($dateRange as $date) {
                                        $bookedDatesArray[] = $date->format('Y-m-d');
                                    }
                                }

                                $today = new DateTime();
                                $currentMonth = $today->format('n');
                                $currentYear = $today->format('Y');
                                $firstDay = new DateTime("$currentYear-$currentMonth-01");
                                $lastDay = new DateTime("$currentYear-$currentMonth-" . $firstDay->format('t'));
                                
                                // Fill in empty days at start
                                $firstDayOfWeek = $firstDay->format('w');
                                for ($i = 0; $i < $firstDayOfWeek; $i++) {
                            echo '<div class="p-2 border-b border-r text-gray-400"></div>';
                        }

                                // Fill in days of month
                                for ($day = 1; $day <= $lastDay->format('d'); $day++) {
                                    $currentDate = new DateTime("$currentYear-$currentMonth-$day");
                                    $dateString = $currentDate->format('Y-m-d');
                                    $isBooked = in_array($dateString, $bookedDatesArray);
                                    $isToday = $currentDate->format('Y-m-d') === $today->format('Y-m-d');
                                    
                                    $cellClass = 'relative p-2 border-b border-r hover:bg-gray-50 cursor-pointer';
                                    if ($isBooked) {
                                        $cellClass .= ' bg-red-100';
                                    }
                                    if ($isToday) {
                                        $cellClass .= ' font-bold';
                                    }

                                    echo '<div class="' . $cellClass . '">';
                                    echo '<div class="text-sm">' . $day . '</div>';
                                    echo '<div class="text-xs text-gray-600">₱' . number_format($venueView['price'], 2) . '</div>';
                                    if ($isBooked) {
                                        echo '<div class="text-xs text-red-600">Booked</div>';
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                        <!-- Discounts Section -->
                        <div class="mt-8">
                            <h4 class="text-lg font-semibold mb-4">Discounts</h4>
                            <div class="space-y-4">
                                <?php
                                $discounts = $venueObj->getAllDiscounts();
                                foreach ($discounts as $discount) {
                                    echo '<div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">';
                                    echo '<div>';
                                    echo '<p class="font-medium">' . htmlspecialchars($discount['discount_code']) . '</p>';
                                    echo '<p class="text-sm text-gray-600">' . htmlspecialchars($discount['discount_type']) . ' - ' . 
                                         ($discount['discount_type'] === 'percentage' ? $discount['discount_value'] . '%' : '₱' . $discount['discount_value']) . '</p>';
                                    echo '</div>';
                                    if ($discount['expiration_date']) {
                                        echo '<p class="text-sm text-gray-500">Expires: ' . date('M d, Y', strtotime($discount['expiration_date'])) . '</p>';
                                    }
                                    echo '</div>';
                                }
                                ?>
                    </div>
                    </div>
                    </div>
                        </div>
                    </div>

            <!-- Right Sidebar - Settings -->
            <div id="venue-settings" class="tab-pane w-[400px]">
                <div class="bg-white rounded-lg shadow-sm p-8 sticky top-24">
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold">Venue Settings</h3>
                            <button id="editSettingsButton" class="text-sm px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit Settings
                            </button>
        </div>

                        <!-- Settings Content -->
                        <div class="space-y-6">
                    <!-- Venue Status -->
                            <div class="setting-group">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Venue Status</h4>
                                <div class="viewMode">
                                    <p class="text-gray-900"><?php echo htmlspecialchars($venueView['availability_id'] == 1 ? "Active" : "Onhold") ?></p>
                        </div>
                                <div class="editMode hidden">
                                    <div class="flex items-center gap-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="editVenueStatus" value="1" <?php echo ($venueView['availability_id'] == 1) ? 'checked' : ''; ?> class="form-radio h-4 w-4 text-blue-600">
                                            <span class="ml-2">Active</span>
                            </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="editVenueStatus" value="2" <?php echo ($venueView['availability_id'] == 2) ? 'checked' : ''; ?> class="form-radio h-4 w-4 text-blue-600">
                                            <span class="ml-2">Onhold</span>
                            </label>
                        </div>
                    </div>
                     </div>

                    <!-- Venue Type -->
                            <div class="setting-group">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Venue Type</h4>
                                <div class="viewMode">
                                    <p class="text-gray-900"><?php 
                            $venueType = $venueView['venue_tag'];
                            switch ($venueType) {
                                        case 1: echo "Corporate Events"; break;
                                        case 2: echo "Reception Hall"; break;
                                        case 3: echo "Intimate Gatherings"; break;
                                        case 4: echo "Outdoor"; break;
                                        default: echo "Unknown"; break;
                            }
                            ?></p>
                        </div>
                                <div class="editMode hidden">
                                    <select name="editVenueType" class="w-full rounded-lg border-gray-300 shadow-sm">
                            <option value="1" <?php echo ($venueView['venue_tag'] == 1) ? 'selected' : ''; ?>>Corporate Events</option>
                            <option value="2" <?php echo ($venueView['venue_tag'] == 2) ? 'selected' : ''; ?>>Reception Hall</option>
                            <option value="3" <?php echo ($venueView['venue_tag'] == 3) ? 'selected' : ''; ?>>Intimate Gatherings</option>
                            <option value="4" <?php echo ($venueView['venue_tag'] == 4) ? 'selected' : ''; ?>>Outdoor</option>
                        </select>
                        </div>
                    </div>

                            <!-- Price Settings -->
                            <div class="setting-group">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Price Settings</h4>
                                <div class="space-y-4">
                                    <!-- Price per day -->
                                    <div>
                                        <label class="text-sm text-gray-600">Price per day</label>
                                        <div class="viewMode">
                                            <p class="text-gray-900">₱<?php echo number_format($venueView['price'], 2) ?></p>
                                        </div>
                                        <div class="editMode hidden">
                        <div class="flex items-center">
                            <span class="text-gray-500 mr-2">₱</span>
                                                <input type="number" name="editVenuePrice" value="<?php echo htmlspecialchars($venueView['price']) ?>" class="w-full rounded-lg border-gray-300 shadow-sm">
                        </div>
                        </div>
                    </div>

                                    <!-- Entrance Fee -->
                                    <div>
                                        <label class="text-sm text-gray-600">Entrance Fee (per person)</label>
                                        <div class="viewMode">
                                            <p class="text-gray-900">₱<?php echo number_format($venueView['entrance'], 2) ?></p>
                    </div>
                                        <div class="editMode hidden">
                        <div class="flex items-center">
                            <span class="text-gray-500 mr-2">₱</span>
                                                <input type="number" name="editVenueEntrance" value="<?php echo htmlspecialchars($venueView['entrance']) ?>" class="w-full rounded-lg border-gray-300 shadow-sm">
                                            </div>
                        </div>
                    </div>

                    <!-- Cleaning Fee -->
                                    <div>
                                        <label class="text-sm text-gray-600">Cleaning Fee</label>
                                        <div class="viewMode">
                                            <p class="text-gray-900">₱<?php echo number_format($venueView['cleaning'], 2) ?></p>
                        </div>
                                        <div class="editMode hidden">
                        <div class="flex items-center">
                            <span class="text-gray-500 mr-2">₱</span>
                                                <input type="number" name="editVenueCleaning" value="<?php echo htmlspecialchars($venueView['cleaning']) ?>" class="w-full rounded-lg border-gray-300 shadow-sm">
                        </div>
                    </div>
                            </div>
                        </div>
                    </div>

                            <!-- Down Payment -->
                            <div class="setting-group">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Down Payment Required</h4>
                                <div class="viewMode">
                                    <p class="text-gray-900"><?php
                                    $downPayment = $venueView['down_payment_id'];
                                    echo $downPayment == 1 ? '30% Down Payment' : ($downPayment == 2 ? '50% Down Payment' : 'Full Payment Required');
                                    ?></p>
                                </div>
                                <div class="editMode hidden">
                                    <select name="editDownPayment" class="w-full rounded-lg border-gray-300 shadow-sm">
                                        <option value="1" <?php echo ($venueView['down_payment_id'] == 1) ? 'selected' : ''; ?>>30% of total amount</option>
                                        <option value="2" <?php echo ($venueView['down_payment_id'] == 2) ? 'selected' : ''; ?>>50% of total amount</option>
                                        <option value="3" <?php echo ($venueView['down_payment_id'] == 3) ? 'selected' : ''; ?>>Full payment required</option>
                                    </select>
                                </div>
                </div>

                            <!-- Discounts -->
                            <div class="setting-group">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Discounts</h4>
                                <div class="viewMode">
                <?php
                                    $discounts = $venueObj->getAllDiscounts();
                                    if (!empty($discounts)) {
                                        foreach ($discounts as $discount) {
                                            echo '<div class="flex justify-between items-center p-2 bg-gray-50 rounded-lg mb-2">';
                                            echo '<div>';
                                            echo '<p class="font-medium text-sm">' . htmlspecialchars($discount['discount_code']) . '</p>';
                                            echo '<p class="text-xs text-gray-600">' . 
                                                 ($discount['discount_type'] === 'percentage' ? $discount['discount_value'] . '%' : '₱' . number_format($discount['discount_value'], 2)) . 
                                                 ' off</p>';
                                            echo '</div>';
                                            if ($discount['expiration_date']) {
                                                echo '<p class="text-xs text-gray-500">Expires: ' . date('M d, Y', strtotime($discount['expiration_date'])) . '</p>';
                                            }
                                            echo '</div>';
                                        }
                                    } else {
                                        echo '<p class="text-sm text-gray-500">No active discounts</p>';
                                    }
                                    ?>
                                </div>
                                <div class="editMode hidden">
                                    <div class="space-y-3" id="discountFields">
                                        <!-- Existing discounts will be listed here -->
                <?php
                                        if (!empty($discounts)) {
                                            foreach ($discounts as $index => $discount) {
                                                echo '<div class="flex gap-2 items-start discount-entry">';
                                                echo '<div class="flex-grow space-y-2">';
                                                echo '<input type="text" name="discount_code[]" placeholder="Discount code" class="w-full text-sm" value="' . htmlspecialchars($discount['discount_code']) . '">';
                                                echo '<div class="flex gap-2">';
                                                echo '<select name="discount_type[]" class="text-sm">';
                                                echo '<option value="percentage"' . ($discount['discount_type'] === 'percentage' ? ' selected' : '') . '>Percentage</option>';
                                                echo '<option value="fixed"' . ($discount['discount_type'] === 'fixed' ? ' selected' : '') . '>Fixed Amount</option>';
                                                echo '</select>';
                                                echo '<input type="number" name="discount_value[]" placeholder="Value" class="w-24 text-sm" value="' . htmlspecialchars($discount['discount_value']) . '">';
                                                echo '</div>';
                                                echo '<input type="date" name="discount_expiry[]" class="w-full text-sm" value="' . htmlspecialchars($discount['expiration_date']) . '">';
                                                echo '</div>';
                                                echo '<button type="button" onclick="removeDiscount(this)" class="text-red-500 hover:text-red-700 p-1">';
                                                echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                                                echo '</svg>';
                                                echo '</button>';
                                                echo '</div>';
                                            }
                                        }
                                        ?>
                        </div>
                                    <button type="button" onclick="addNewDiscount()" class="mt-3 text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add New Discount
                                    </button>
                        </div>
                        </div>

                            <!-- Save Changes Button -->
                            <div class="editMode hidden pt-4">
                                <button type="button" onclick="saveChanges(event)" class="w-full bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-transparent text-green-600 transition-colors">
                                    Save Changes
                                </button>
                        </div>
                    </div>
                </div>
                                    </div>
                                </div>
                                </div>
    </form>
                    </div>

<style>
/* Update existing styles */
.tab-button {
    color: #6B7280;
    border-color: transparent;
    transition: all 0.3s;
    position: relative;
}

.tab-button:hover {
    color: #111827;
}

.tab-button.active {
    color: #111827;
    border-color: #111827;
    font-weight: 600;
}

.tab-button::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #111827;
    transform: scaleX(0);
    transition: transform 0.3s;
}

.tab-button:hover::after {
    transform: scaleX(0.5);
}

.tab-button.active::after {
    transform: scaleX(1);
}

.tab-content {
    min-height: calc(100vh - 200px);
}

.tab-pane {
    display: none;
    width: 100%;
}

.tab-pane.active {
    display: block !important;
}

/* Setting group styles */
.setting-group {
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #E5E7EB;
}

.setting-group:last-child {
    border-bottom: none;
}

/* Form control styles */
input[type="text"],
input[type="number"],
select,
textarea {
    width: 100%;
    padding: 0.5rem;
    border-radius: 0.5rem;
    border: 1px solid #D1D5DB;
    transition: all 0.3s;
}

input[type="text"]:focus,
input[type="number"]:focus,
select:focus,
textarea:focus {
    outline: none;
    border-color: #2563EB;
    ring: 2px solid #2563EB;
}

/* Responsive styles */
@media (max-width: 1280px) {
    .tab-content {
        flex-direction: column;
    }
    
    #venue-settings {
        width: 100% !important;
        margin-top: 2rem;
    }
}

@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .tab-button {
        padding: 0.75rem 1rem;
    }
}
</style>

<script>
$(document).ready(function() {
    // Tab Functionality
    function switchTab(tabId) {
        console.log('Switching to tab:', tabId);
        
        // Hide all panes and deactivate all buttons
        $('.tab-pane').removeClass('active').hide();
        $('.tab-button').removeClass('active');
        
        // Show selected pane and activate selected button
        $(`#${tabId}`).addClass('active').show();
        $(`.tab-button[data-tab="${tabId}"]`).addClass('active');

        // Handle special layout for settings tab
        if (tabId === 'venue-settings') {
            $('.tab-content').addClass('settings-active');
        } else {
            $('.tab-content').removeClass('settings-active');
        }
        
        console.log('Tab switched successfully to:', tabId);
    }

    // Add click handlers to tab buttons
    $('.tab-button').on('click', function(e) {
        e.preventDefault();
        const tabId = $(this).data('tab');
        switchTab(tabId);
    });

    // Initialize first tab as active
    switchTab('venue-details');

    // Calendar Functionality
    const prevButton = $('.calendar-prev');
    const nextButton = $('.calendar-next');
    const monthDisplay = $('.calendar-month');
    
    if (prevButton.length && nextButton.length && monthDisplay.length) {
        let currentDate = new Date();

        function updateCalendar() {
            monthDisplay.text(currentDate.toLocaleString('default', { month: 'long', year: 'numeric' }));
        }

        prevButton.on('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateCalendar();
        });

        nextButton.on('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateCalendar();
        });

        updateCalendar();
    }

    // Initialize edit mode elements
    $('.editMode').addClass('hidden');

    // Edit button functionality
    const editButton = $('#editVenueButton');
    if (editButton.length) {
        editButton.on('click', function(e) {
        e.preventDefault();

            if (window.venueState.isEditVenue) {
                $(this).text('Edit Details');
                $('#editImageGallery').html($('#editImageGallery').html());

                // Show all the removed images before clearing the array
                window.venueState.imagesToDelete.forEach(index => {
                    const imageDiv = $(`#image-${index}`);
                    if (imageDiv.length) {
                        imageDiv.show();
                    }
                });

                // Clear arrays
                window.venueState.imagesToDelete = [];
                window.venueState.newImages = [];
                $('#newImagesContainer').empty();
                $('#imageUpload').val('');
            } else {
                $(this).text('Cancel Editing');
            }

            // Toggle visibility
            $('.viewMode').toggleClass('hidden');
            $('.editMode').toggleClass('hidden');

            // Toggle gallery grids
            $('#editImageGallery, #newImagesContainer').toggleClass('grid');

            window.venueState.isEditVenue = !window.venueState.isEditVenue;
        });
    }

    // Image upload trigger
    const addImageTrigger = $('#addImageTrigger');
    if (addImageTrigger.length) {
        addImageTrigger.on('click', function(e) {
            e.preventDefault();
            $('#imageUpload').click();
        });
    }

    // Add settings edit functionality
    $('#editSettingsButton').on('click', function(e) {
        e.preventDefault();
        const isEditing = $(this).hasClass('editing');
        
        if (isEditing) {
            $(this).removeClass('editing').html(`
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Settings
            `);
        } else {
            $(this).addClass('editing').html(`
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Cancel
            `);
        }
        
        $('#venue-settings .viewMode, #venue-settings .editMode').toggleClass('hidden');
    });
});

// Keep these functions outside as they're called from HTML
function setThumbnail(e) {
        e.preventDefault();
    window.venueState.thumbnailIndex = $(e.target).data('index');

    $('.image-container').removeClass('border-4 border-blue-500');
    $(`#image-${window.venueState.thumbnailIndex}`).addClass('border-4 border-blue-500');
}

function markForDeletion(e) {
    e.preventDefault();
        const index = e.target.getAttribute('data-bs-marked');

    if (!window.venueState.imagesToDelete.includes(index)) {
        window.venueState.imagesToDelete.push(index);
        }

        const imageContainer = e.target.closest('.image-container');
        if (imageContainer) {
            imageContainer.remove();
        }

        const remainingImages = [];
    $('.image-container').each((newIndex, container) => {
            container.id = `image-${newIndex}`;
            container.querySelector('img').setAttribute('data-bs-index', newIndex);
            container.querySelector('.thumbnailButton').setAttribute('data-index', newIndex);

            const imgDataSrc = container.querySelector('img').getAttribute('data-bs-src');
            if (imgDataSrc) {
                remainingImages.push(imgDataSrc);
            }
    });

    // Update thumbnail index
    if (window.venueState.thumbnailIndex == index) {
        window.venueState.thumbnailIndex = 0;
    } else if (index < window.venueState.thumbnailIndex) {
        window.venueState.thumbnailIndex--;
    }
}

        function previewImage(event) {
    const files = event.target.files;
        if (files.length > 0) {
            Array.from(files).forEach(file => {
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
            window.venueState.newImages.push(file);
            });
        }
        }

    function removeNewImage(event) {
        event.preventDefault();
        const filename = event.target.getAttribute('data-bs-newImage');
    window.venueState.newImages = window.venueState.newImages.filter(image => image.name !== filename);

        const container = event.target.parentElement;
        if (container) {
            container.remove();
        }
    }

function removeDiscount(button) {
    $(button).closest('.discount-entry').remove();
}

function addNewDiscount() {
    const newDiscountHtml = `
        <div class="flex gap-2 items-start discount-entry">
            <div class="flex-grow space-y-2">
                <input type="text" name="discount_code[]" placeholder="Discount code" class="w-full text-sm">
                <div class="flex gap-2">
                    <select name="discount_type[]" class="text-sm">
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed Amount</option>
                    </select>
                    <input type="number" name="discount_value[]" placeholder="Value" class="w-24 text-sm">
                </div>
                <input type="date" name="discount_expiry[]" class="w-full text-sm">
            </div>
            <button type="button" onclick="removeDiscount(this)" class="text-red-500 hover:text-red-700 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    $('#discountFields').append(newDiscountHtml);
}

    function saveChanges(e) {
        e.preventDefault();        
    const form = document.querySelector('#editVenueForm');
    const formData = new FormData(form);
        const defaultImages = <?php echo json_encode($venueView['image_urls']); ?>;

    // Add existing form data
    formData.append('imagesToDelete', JSON.stringify(window.venueState.imagesToDelete));
        formData.append('defaultImages', JSON.stringify(defaultImages));
    formData.append('thumbnailIndex', window.venueState.thumbnailIndex ?? <?php echo $venueView['thumbnail'] ?>);
    formData.append('venueID', <?php echo $getParams?>);

    // Add discount data
    const discounts = [];
    $('.discount-entry').each(function() {
        const discount = {
            code: $(this).find('input[name="discount_code[]"]').val(),
            type: $(this).find('select[name="discount_type[]"]').val(),
            value: $(this).find('input[name="discount_value[]"]').val(),
            expiry: $(this).find('input[name="discount_expiry[]"]').val()
        };
        discounts.push(discount);
    });
    formData.append('discounts', JSON.stringify(discounts));

    // Add new images
    window.venueState.newImages.forEach(file => {
        formData.append('newImages[]', file);
    });

        fetch('./api/updateVenue.api.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.status == 'success') {
                    showModal(data.message, function () {
                        location.reload();
            }, "black_ico.png");
                } else {
                    showModal(`Failed to save changes: ${data.message || 'Unknown error'}`, undefined, "black_ico.png");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModal('An error occurred while saving changes. Please try again.', undefined, "black_ico.png");
            });
    }
</script>
