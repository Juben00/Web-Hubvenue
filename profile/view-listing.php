<?php
require_once '../classes/venue.class.php';
require_once '../api/coorAddressVerify.api.php';

session_start();
$venueObj = new Venue();
$venuePost = null;

$VENUE_ID = $_GET['id'];
$venueView = $venueObj->getSingleVenue($VENUE_ID);
$VENUE_NOT_AVAILABLE = 2;

$ratings = $venueObj->getRatings($VENUE_ID);
$reviews = $venueObj->getReview($VENUE_ID);

$bookings = $venueObj->getBookingByVenue($VENUE_ID, 2);
$remainingBookings = $venueObj->getRemainingBookings($VENUE_ID);
$discounts = $venueObj->getDiscountsByVenue($VENUE_ID);

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
<div id="venueDetailsView" class="container mx-auto pt-24 mb-8">
    <form class="flex gap-6" id="editVenueForm" enctype="multipart/form-data">
        <!-- Main Content -->
        <div class="w-full">
            <div class="bg-white text-neutral-900 rounded-lg shadow-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h1 id="detailVenueName" class="text-gray-600 text-2xl viewMode">
                            <?php echo htmlspecialchars($venueView['venue_name']);
                            ?>
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
                                            value="<?php echo htmlspecialchars(trim($venueView['address'])); ?>"
                                            readonly />
                                        <input type="hidden" class="" id="editVenueAddCoordinates"
                                            name="editVenueAddCoor"
                                            value="<?php echo htmlspecialchars($venueView['venue_location']) ?>" />
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
                        $bookedDates = $venueObj->getBookedDates($VENUE_ID);
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
                                $cellClass .= 'bg-red-100';
                            }
                            if ($isToday) {
                                $cellClass .= 'font-bold text-blue-500';
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
            </div>



        </div>

        <!-- Right Sidebar -->
        <div class="w-2/5">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-0">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Venue Settings</h3>
                    <!-- Venue Status -->
                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Venue Status</span>
                            <p><?php echo htmlspecialchars($venueView['availability_id'] == 1 ? "Active" : "Onhold") ?>
                            </p>
                        </div>
                    </div>
                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Venue Status</label>
                        <div class="flex items-center gap-2">
                            <!-- Active Status -->
                            <div class="flex items-center gap-2">
                                <label class="switch">
                                    <input type="radio" name="editVenueStatus" id="editVenueStatusActive" value="1"
                                        <?php echo ($venueView['availability_id'] == 1) ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                                <span class="text-sm text-gray-600">Active</span>
                            </div>

                            <!-- Onhold Status -->
                            <div class="flex items-center gap-2">
                                <label class="switch">
                                    <input type="radio" name="editVenueStatus" id="editVenueStatusOnhold" value="2"
                                        <?php echo ($venueView['availability_id'] == 2) ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                                <span class="text-sm text-gray-600">Onhold</span>
                            </div>
                        </div>

                    </div>

                    <!-- Venue Type -->
                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Venue Tag</span>
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
                        <select class="block w-full p-2 text-sm text-gray-700 rounded-md border" name="editVenueType"
                            id="">
                            <option value="1" <?php echo ($venueView['venue_tag'] == 1) ? 'selected' : ''; ?>>Corporate
                                Events</option>
                            <option value="2" <?php echo ($venueView['venue_tag'] == 2) ? 'selected' : ''; ?>>Reception
                                Hall</option>
                            <option value="3" <?php echo ($venueView['venue_tag'] == 3) ? 'selected' : ''; ?>>Intimate
                                Gatherings</option>
                            <option value="4" <?php echo ($venueView['venue_tag'] == 4) ? 'selected' : ''; ?>>Outdoor
                            </option>
                        </select>
                    </div>


                    <!-- Price Setting -->

                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Pricing Type</span>
                            <p><?php echo htmlspecialchars($venueView['pricing_type'] == "fixed" ? "Hourly rate" : "Per Head Rate") ?>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pricing Type</label>
                        <select class="block w-full p-2 text-sm text-gray-700 rounded-md border"
                            name="editVenuePricingType" id="">
                            <option value="fixed" <?php echo ($venueView['pricing_type'] == "fixed") ? 'selected' : ''; ?>>Hourly Rate</option>
                            <option value="per_head" <?php echo ($venueView['pricing_type'] == "per_head") ? 'selected' : ''; ?>>Per Head Rate</option>
                        </select>
                    </div>

                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Price</span>
                            <p>₱<?php echo htmlspecialchars($venueView['price']) ?></p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                        <div class="flex items-center border p-1 py-2 rounded-md">
                            <span class="text-gray-500 mr-2">₱</span>
                            <input type="number" id="venuePrice" name="editVenuePrice" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['price']) ?>">
                        </div>
                    </div>

                    <!-- Down Payment Options -->
                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-semibold">Down Payment Options</span>
                            <p class="text-right"><?php
                            $downPayment = $venueView['down_payment_id'];
                            $downPaymentName = $downPayment == 1 ? '30% Down Payment' : ($downPayment == 2 ? '50% Down Payment' : 'Full Payment Required');
                            echo htmlspecialchars($downPaymentName);
                            ?></p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Down Payment
                            Required</label>
                        <select class="border text-sm p-2 rounded-md w-full" name="editDownPayment"
                            id="editDownPayment">
                            <option value="1" <?php echo ($venueView['down_payment_id'] == 1) ? 'selected' : ''; ?>>30%
                                of
                                total amount
                            </option>
                            <option value="2" <?php echo ($venueView['down_payment_id'] == 2) ? 'selected' : ''; ?>>50%
                                of
                                total amount
                            </option>
                            <option value="3" <?php echo ($venueView['down_payment_id'] == 3) ? 'selected' : ''; ?>>Full
                                payment
                                required</option>
                        </select>
                    </div>


                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Minimun booking time</span>
                            <p><?php echo htmlspecialchars(!empty($venueView['min_time']) ? $venueView['min_time'] . " Hours" : "Not Set") ?>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Minimun booking time</label>
                        <div class="flex items-center px-1 py-2 border rounded-md">
                            <input type="number" id="venueMinTime" name="editMinTime" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['min_time']) ?>">
                        </div>
                    </div>

                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Maximum booking time</span>
                            <p><?php echo htmlspecialchars(!empty($venueView['max_time']) ? $venueView['max_time'] . " Hours" : "Not Set") ?>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Maximum booking time</label>
                        <div class="flex items-center px-1 py-2 border rounded-md">
                            <input type="number" id="venueMaxTime" name="editMaxTime" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['max_time']) ?>">
                        </div>
                    </div>



                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Minimum Head Count</span>
                            <p><?php echo htmlspecialchars($venueView['min_attendees']) ?> People</p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Head Count</label>
                        <div class="flex items-center px-1 py-2 border rounded-md">
                            <input type="number" id="venueMinHead" name="editMinHead" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['min_attendees']) ?>">
                        </div>
                    </div>
                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Maximum Head Count</span>
                            <p><?php echo htmlspecialchars($venueView['max_attendees']) ?> Person</p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Maximum Head Count</label>
                        <div class="flex items-center px-1 py-2 border rounded-md">
                            <input type="number" id="venueMaxHead" name="editMaxHead" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['max_attendees']) ?>">
                        </div>
                    </div>


                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Opening Time</span>
                            <p><?php echo htmlspecialchars($venueView['opening_time'] ? $venueView['opening_time'] : "Not Set") ?>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Opening Time</label>
                        <div class="flex items-center px-1 py-2 border rounded-md">
                            <input type="time" id="venueOpeningTime" name="editOpeningTime"
                                placeholder="Set Opening Time" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['opening_time']) ?>">
                        </div>
                    </div>

                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Closing Time</span>
                            <p><?php echo htmlspecialchars($venueView['closing_time'] ? $venueView['closing_time'] : "Not Set") ?>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Closing Time</label>
                        <div class="flex items-center px-1 py-2 border rounded-md">
                            <input type="time" id="venueClosingTime" name="editClosingTime"
                                placeholder="Set Closing Time" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['closing_time']) ?>">
                        </div>
                    </div>


                    <!-- Entrance -->
                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Entrance per person</span>
                            <p>₱<?php echo htmlspecialchars($venueView['entrance']) ?></p>
                        </div>
                    </div>

                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Entrance per person</label>
                        <div class="flex items-center px-1 py-2 border rounded-md">
                            <span class="text-gray-500 mr-2">₱</span>
                            <input type="number" id="venueEntrance" name="editVenueEntrance" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['entrance']) ?>">
                        </div>
                    </div>

                    <!-- Cleaning Fee -->
                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Cleaning Fee</span>
                            <p>₱<?php echo htmlspecialchars($venueView['cleaning']) ?></p>
                        </div>
                    </div>



                    <div class="mb-4 editMode hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cleaning Fee</label>
                        <div class="flex items-center px-1 py-2 border rounded-md">
                            <span class="text-gray-500 mr-2">₱</span>
                            <input type="number" id="venueCleaning" name="editVenueCleaning" class=" rounded-md w-full"
                                value="<?php echo htmlspecialchars($venueView['cleaning']) ?>">
                        </div>
                    </div>


                    <div class="border-b pb-4 mb-4 viewMode text-sm">
                        <div class="flex flex-col justify-start items-start">
                            <span class="font-semibold mb-2">Discounts</span>
                            <div class="flex flex-col gap-1 w-full ">
                                <?php if (!empty($discounts)) {
                                    foreach ($discounts as $discount) {
                                        if ($discount['discount_type'] == 'percentage') {
                                            $displayValue = floatval($discount['discount_value']) . '%';
                                        } else {
                                            $displayValue = '₱' . number_format((float) $discount['discount_value'], 2);
                                        }
                                        echo '<div class="flex justify-between gap-2 items-center w-full p-2 border-2 rounded-md">';
                                        echo '<span class="font-semibold">' . htmlspecialchars($displayValue) . '</span>';
                                        echo '<p class="text-gray-800">' . htmlspecialchars($discount['discount_code']) . '</p>';
                                        echo '<p class="text-gray-800">Qty: ' . htmlspecialchars($discount['remaining_quantity'] . ' / ' . $discount['initial_quantity']) . '</p>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p class="text-gray-500">No discounts available</p>';
                                }
                                ?>
                            </div>

                        </div>
                    </div>

                    <div class="border-b pb-4 mb-4 editMode hidden text-sm">
                        <div class="flex flex-col justify-start items-start gap-4">
                            <span class="font-semibold ">Discounts</span>
                            <div class="flex flex-col gap-1 w-full ">
                                <?php if (!empty($discounts)) {
                                    foreach ($discounts as $discount) {
                                        if ($discount['discount_type'] == 'percentage') {
                                            $displayValue = floatval($discount['discount_value']) . '%';
                                        } else {
                                            $displayValue = '₱' . number_format((float) $discount['discount_value'], 2);
                                        }
                                        echo '<div class="flex justify-between gap-2 items-center w-full p-2 border-2 rounded-md discount-item">';
                                        echo '<span class="font-semibold">' . htmlspecialchars($displayValue) . '</span>';
                                        echo '<p class="text-gray-800">' . htmlspecialchars($discount['discount_code']) . '</p>';
                                        echo '<p class="text-gray-800">Qty: ' . htmlspecialchars($discount['remaining_quantity'] . ' / ' . $discount['initial_quantity']) . '</p>';
                                        echo '<button onclick="deleteDiscount(event)" class="text-red-500 font-bold flex items-center" data-discount-id="' . htmlspecialchars($discount['id']) . '">x</button>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p class="text-gray-500">No discounts available</p>';
                                }
                                ?>
                            </div>
                            <div class="flex flex-col gap-2 w-full border-2 p-2 rounded-md">
                                <label for="" class="font-semibold text-sm ">New Discount</label>
                                <div class="flex flex-col items-start gap-2 w-full">
                                    <span class="flex items-center gap-2 w-full">
                                        <input type="number" name="discountValue" min="1" max="85"
                                            class="w-1/4 p-2 border rounded-md" placeholder="Value">
                                        <select name="discountType" type="text" class="flex-1 p-2 border rounded-md"
                                            placeholder="">
                                            <option value="">Value type</option>
                                            <option value="percentage">Percentage</option>
                                            <option value="flat">Flat</option>
                                        </select>
                                    </span>
                                    <span class="w-full flex items-center gap-2">
                                        <input type="text" name="discountCode"
                                            class="border flex-1 rounded-md p-2 w-2/3" placeholder="Discount Code">
                                        <input type="number" name="discountQuantity" min="1"
                                            class="border rounded-md p-2" placeholder="Quantity">
                                    </span>
                                    <span class="w-full">
                                        <input type="date" name="discountDate" class="border rounded-md p-2 w-full"
                                            placeholder="Description">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <span class="editMode hidden space-y-3">
                        <!-- Save Changes Button -->
                        <button onclick="saveChanges(event)"
                            class="w-full bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-800 ">
                            Save Changes
                        </button>

                        <?php
                        if ($venueView['availability_id'] == $VENUE_NOT_AVAILABLE && empty($remainingBookings)) {
                            echo '<button id="venueDeleteBtn" class="w-full bg-slate-50 border-2 text-black py-2 px-4 rounded-lg hover:bg-gray-800 hover:text-white duration-150 " data-venue-id="' . htmlspecialchars($_GET['id']) . '">Delete Venue</button>';
                        } else {
                            echo '
                            <div class=" p-2 py-4 flex gap-2 flex-col items-center border shadow-md rounded-md">
                        <span class="font-semibold">Note</span>
                        <span class="text-sm text-gray-700 text-center">
                            Deleting venue is only available when the status is on hold and there are no active bookings.
                        </span>
                    </div>';
                        }
                        ?>
                    </span>
                </div>

                <?php
                $currentMonth = new DateTime(); // Defaults to the current date and time
                foreach ($bookings as $booking) {
                    $bookingCount += 1; // Aggregate booking count
                    $bookingRevenue += $booking['booking_dp_amount'];

                    $bookingEndDate = new DateTime($booking['booking_end_datetime']);

                    if (
                        $bookingEndDate->format('Y') === $currentMonth->format('Y') &&
                        $bookingEndDate->format('m') === $currentMonth->format('m')
                    ) {
                        $bookingThisMonth += 1; // Increment count for bookings this month
                    }
                }
                ?>

                <!-- Quick Stats -->
                <div class="pt-4">
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
                            // var_dump($booking);
                            ?>
                            <!-- Sample Reservation Items -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-medium">
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
                                        $startDate = new DateTime($booking['booking_start_datetime']);
                                        $endDate = new DateTime($booking['booking_end_datetime']);
                                        echo $startDate->format('F j, Y') . ' to ' . $endDate->format('F j, Y');
                                        ?>
                                    </p>
                                </div>
                                <p>Total Amount: <span
                                        class="text-gray-600 ">₱<?php echo $booking['booking_dp_amount'] ?></span></p>
                                <p>Balance: <span class="text-gray-600 ">₱<?php echo $booking['booking_balance'] ?></span>
                                </p>
                                <p>Payment Method: <span
                                        class="text-gray-600 "><?php echo $booking['payment_method_name'] ?></span></p>
                            </div>
                            <?php
                        endforeach;
                        ?>
                    </div>

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
</div>

<script>

    function deleteDiscount(e) {
        e.preventDefault();
        const discountId = e.currentTarget.getAttribute('data-discount-id');
        if (!discountsToDelete.includes(discountId)) {
            discountsToDelete.push(discountId);
        }

        const discountElement = e.currentTarget.closest('.discount-item');
        if (discountElement) {
            discountElement.style.display = 'none';
        }
    }

    $('#venueDeleteBtn').on('click', function (e) {
        e.preventDefault();

        const venueId = $(this).data('venue-id');

        confirmshowModal("Are you sure you want to delete this venue?", () => {
            deleteVenue(venueId);
        }, "black_ico.png");
    });

    function deleteVenue(venueId) {
        spinnerOn();
        $.ajax({
            type: "POST",
            url: "./api/hostDeleteVenue.api.php",
            data: JSON.stringify({ venueId: venueId }), // Convert object to JSON string
            contentType: "application/json", // Set the correct content type
            success: function (response) {
                if (response.status === "success") {
                    spinnerOff();
                    showModal(response.message, () => {
                        window.location.reload();
                    }, "black_ico.png");
                } else {
                    spinnerOff();
                    showModal(response.message, undefined, "black_ico.png");
                }
            }
        });
    }


    // Initialize: Hide edit-mode elements
    document.querySelectorAll('.editMode').forEach(function (element) {
        element.classList.add('hidden');
    });


    document.getElementById('editVenueButton').addEventListener('click', function (e) {
        e.preventDefault();

        if (isEditVenue) {
            document.getElementById('editVenueButton').innerText = 'Edit Details';

            document.getElementById('editImageGallery').innerHTML = document.getElementById('editImageGallery').innerHTML;

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
            // container.querySelector('[data-bs-marked]').setAttribute('data-bs-marked', newIndex);

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
        const files = event.target.files; // Get all selected files
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

                // Add the file to the newImages array
                newImages.push(file);
            });
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
        const defaultImages = <?php echo json_encode($venueView['image_urls']); ?>;

        formData.append('imagesToDelete', JSON.stringify(imagesToDelete));
        // Append it to the FormData as a JSON string
        formData.append('defaultImages', JSON.stringify(defaultImages));

        formData.append('thumbnailIndex', thumbnailIndex ?? <?php echo $venueView['thumbnail'] ?>);

        formData.append('venueID', <?php echo $VENUE_ID ?>);
        // Append new images as files, not as JSON string
        newImages.forEach(file => {
            console.log(file);  // Log each file to inspect the details
            formData.append('newImages[]', file);  // Append each new image file to the FormData
        });

        // Append discounts to delete
        formData.append('discountsToDelete', JSON.stringify(discountsToDelete));

        for (let [key, value] of formData.entries()) {
            console.log(`${key}:`, value);  // Log each key-value pair in the FormData
        }

        spinnerOn();

        fetch('./api/updateVenue.api.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    // Handle HTTP errors
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                spinnerOff();
                return response.json();
            })
            .then(data => {
                if (data.status == 'success') {
                    spinnerOff();
                    showModal(data.message, function () {
                        location.reload();
                    }, "black_ico.png");
                } else {
                    spinnerOff();
                    showModal(`Failed to save changes: ${data.message || 'Unknown error'}`, undefined, "black_ico.png");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                spinnerOff();
                showModal('An error occurred while saving changes. Please try again.', undefined, "black_ico.png");
            });

    }
    currentMonth = new Date().getMonth();
    currentYear = new Date().getFullYear();
    bookedDatesArr = <?php echo json_encode($bookedDatesArray); ?>;
    venueView = <?php echo json_encode($venueView); ?>;

    function updateCalendar() {
        const calendarDays = document.querySelector('.calendar-days');
        const calendarMonth = document.querySelector('.calendar-month');
        calendarDays.innerHTML = '';

        // Validate bookedDatesArr and venueView
        const bookedDates = Array.isArray(bookedDatesArr) ? bookedDatesArr : [];
        const venuePrice = venueView?.price || 0;

        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const firstDayOfWeek = firstDay.getDay();

        // Set the calendar month and year
        calendarMonth.textContent = firstDay.toLocaleString('default', { month: 'long', year: 'numeric' });

        // Fill empty grid slots before the 1st of the month
        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'p-2 border-b border-r text-gray-400';
            calendarDays.appendChild(emptyCell);
        }

        // Generate days with proper alignment
        for (let day = 1; day <= lastDay.getDate(); day++) {
            const dateString = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
            const isBooked = bookedDates.includes(dateString);
            const isToday = dateString === new Date().toISOString().split('T')[0];

            // Create day cell
            const dayCell = document.createElement('div');
            dayCell.className = 'relative p-2 border-b border-r hover:bg-gray-50 cursor-pointer';
            if (isBooked) dayCell.classList.add('bg-red-100');
            if (isToday) dayCell.classList.add('font-bold', 'text-blue-500');

            // Add day number
            const dayNumber = document.createElement('div');
            dayNumber.className = 'text-sm';
            dayNumber.textContent = day;

            // Add price
            const price = document.createElement('div');
            price.className = 'text-xs text-gray-600';
            price.textContent = `₱${venuePrice}`;

            // Add booked date text if applicable
            if (isBooked) {
                const bookedText = document.createElement('div');
                bookedText.className = 'text-xs text-red-600';
                bookedText.textContent = 'Booked';
                dayCell.appendChild(bookedText);
            }

            // Append elements to day cell
            dayCell.appendChild(dayNumber);
            dayCell.appendChild(price);
            calendarDays.appendChild(dayCell);
        }
    }

    document.querySelector('.calendar-prev').addEventListener('click', (e) => {
        e.preventDefault();
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateCalendar();
    });

    document.querySelector('.calendar-next').addEventListener('click', (e) => {
        e.preventDefault();
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendar();
    });


    // Initial calendar update
    updateCalendar();

    document.getElementById('prevReview').addEventListener('click', function (e) {
        e.preventDefault();
        navigateReview(-1);
    });

    document.getElementById('nextReview').addEventListener('click', function (e) {
        e.preventDefault();
        navigateReview(1);
    });

    function navigateReview(direction) {
        const reviews = document.querySelectorAll('.review');
        let currentIndex = -1;

        reviews.forEach((review, index) => {
            if (review.style.display !== 'none') {
                currentIndex = index;
            }
        });

        if (currentIndex !== -1) {
            reviews[currentIndex].style.display = 'none';
            let newIndex = currentIndex + direction;

            if (newIndex < 0) {
                newIndex = reviews.length - 1;
            } else if (newIndex >= reviews.length) {
                newIndex = 0;
            }

            reviews[newIndex].style.display = '';
        }
    }
</script>