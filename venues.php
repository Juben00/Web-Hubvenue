<?php
session_start();
require_once __DIR__ . '/classes/venue.class.php';
require_once __DIR__ . '/classes/account.class.php';

$venueObj = new Venue();
$accountObj = new Account();

$USER_ID = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$MANDATORY_DISCOUNT_VALUE = 20;

// Check if 'id' parameter is present and valid
if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

// Retrieve venue information based on 'id' parameter
$venue = $venueObj->getSingleVenue($_GET['id']);

// If no venue is found, redirect to index.php
if (empty($venue['name'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in
    if (isset($USER_ID)) {
        $_SESSION['reservationFormData'] = $_POST;
        header("Location: payment.php");
        exit();
    }
}

// Retrieve the owner's information
$owner = $accountObj->getUser($venue['host_id']);
$bookedDate = $venueObj->getBookedDates($_GET['id']);
$closedDateTime = $venueObj->getClosedDateTime($_GET['id']);


$ratings = $venueObj->getRatings($_GET['id']);
$reviews = $venueObj->getReview($_GET['id']);

$discountStatus = $accountObj->getDiscountApplication($USER_ID);
// var_dump($bookedDate);
// var_dump($closedDateTime);
// var_dump($venue['min_time']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Details - HubVenue</title>
    <link rel="icon" href="./images/black_ico.png">
    <link rel="stylesheet" href="./output.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>
    <link rel="stylesheet" href="node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <style>
        .flatpickr-calendar {
            z-index: 100 !important;
        }

        .flatpickr-calendar.static {
            position: absolute;
            top: 100% !important;
        }

        /* Add these new styles for image transitions */
        .venue-image {
            transition: opacity 0.5s ease-in-out;
        }

        .venue-image.fade-out {
            opacity: 0;
        }

        .venue-image.fade-in {
            opacity: 1;
        }

        #thumbnailContainer::-webkit-scrollbar {
            height: 8px;
        }

        #thumbnailContainer::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        #thumbnailContainer::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        #thumbnailContainer::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .modal-fade-enter {
            opacity: 0;
            transform: scale(0.9);
        }

        .modal-fade-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: opacity 300ms, transform 300ms;
        }

        .modal-fade-exit {
            opacity: 1;
            transform: scale(1);
        }

        .modal-fade-exit-active {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 300ms, transform 300ms;
        }

        .split-view {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            transition: all 0.3s ease;
        }

        .venue-comparison {
            height: 100vh;
            overflow-y: auto;
            padding: 120px 4rem 2rem;
            border-left: 1px solid #e5e7eb;
            background: #ffffff;
            position: fixed;
            right: -50%;
            top: 0;
            width: 50%;
            transition: all 0.3s ease;
            z-index: 40;
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.1);
        }

        .venue-comparison.active {
            right: 0;
        }

        .venue-comparison::-webkit-scrollbar {
            width: 8px;
        }

        .venue-comparison::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .venue-comparison::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .venue-comparison::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        .comparison-close {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 50;
            background: white;
            border-radius: 50%;
            padding: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .comparison-close:hover {
            transform: rotate(90deg);
            background: #f3f4f6;
        }

        .venue-comparison .comparison-content {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .venue-comparison .bg-slate-50 {
            margin-bottom: 1.5rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .venue-comparison h2 {
            margin-bottom: 2rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .main-content {
            transition: all 0.3s ease;
            width: 100%;
            max-width: 1200px;
            padding: 100px 2rem 0;
            margin: 0 auto;
            /* Account for sidebar */
        }

        .main-content.shifted {
            margin-right: 50%;
            width: 50%;
            padding: 100px 0 0;
            /* Remove horizontal padding */
            margin-left: 5rem;
            max-width: none;
            height: 100vh;
            overflow-y: auto;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            /* Center the content */
        }

        .main-container {
            transition: all 0.3s ease;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px 0 0;
            display: flex;
            justify-content: center;
        }

        .main-container.shifted {
            max-width: none;
            width: 100%;
            padding: 0;
            margin: 0;
            height: 100vh;
            overflow: hidden;
        }

        #venueDetails {
            width: 100%;
            margin: 0 auto;
            padding-bottom: 2rem;
            /* Add padding at the bottom for scrolling space */
        }

        .grid.grid-cols-3 {
            width: 100%;
            gap: 1rem;
            margin-top: 1rem;
        }

        @media (max-width: 1400px) {
            .main-content.shifted #venueDetails {
                padding: 0 2rem;
            }

            .venue-comparison {
                padding: 120px 2rem 2rem;
            }
        }

        @media (max-width: 768px) {
            .main-content.shifted #venueDetails {
                padding: 0 1rem;
            }

            .venue-comparison {
                padding: 120px 1rem 2rem;
            }
        }

        .venue-comparison .bg-slate-50 {
            transition: all 0.3s ease;
        }

        .venue-comparison .hidden {
            display: none;
        }

        /* Animation for expanding/collapsing details */
        .venue-comparison [id^="venue-details-"] {
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }

        .venue-comparison [id^="venue-details-"]:not(.hidden) {
            max-height: 2000px;
            /* Large enough to fit content */
        }

        /* Update main content shifted styles to fix rating section */
        .main-content.shifted #venueDetails {
            width: 100%;
            max-width: 800px;
            padding: 0 4rem;
            margin: 0 auto;
        }

        /* Add styles for ratings section to prevent cutoff */
        .main-content.shifted .rating-bars {
            width: 100%;
            max-width: 200px;
            /* Adjust as needed */
        }

        .main-content.shifted .reviews-section {
            width: 100%;
            overflow-x: hidden;
        }

        /* Add new styles for the highlights */
        .venue-comparison .highlight-card {
            transition: all 0.2s ease;
        }

        .venue-comparison .highlight-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>

<body class="bg-slate-50 relative">
    <!-- Header -->
    <?php
    if (isset($USER_ID)) {
        include_once './components/navbar.logged.in.php';
    } else {
        include_once './components/navbar.html';
    }

    include_once './components/SignupForm.html';
    include_once './components/feedback.modal.html';
    include_once './components/confirm.feedback.modal.html';
    include_once './components/Menu.html';
    include_once './components/terms.html';

    ?>

    <?php require_once './components/customcalendar.php'; ?>
    <main class="max-w-7xl pt-32 mx-auto px-4 py-6 sm:px-6 lg:px-8 main-container ">
        <div class="main-content">
            <div id="venueDetails">
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-3xl font-semibold"><?php echo htmlspecialchars($venue['name']) ?></h1>
                        <button id="compareButton"
                            class="flex items-center gap-2 px-4 py-2 bg-slate-50 border-2 border-gray-500 rounded-lg hover:bg-gray-50 transition duration-300">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Compare</span>
                        </button>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm font-semibold">
                            <i
                                class="fas fa-star text-yellow-400 mr-1"></i><?php echo number_format($venue['rating'], 1) ?></span>
                        <span class="mx-2">·</span>
                        <span class="text-sm font-semibold"><?php echo htmlspecialchars($venue['total_reviews']) ?>
                            review/s</span>
                        <span class="mx-2">·</span>
                        <span class="text-sm font-semibold"><?php echo htmlspecialchars($venue['tag']) ?></span>
                        <span class="mx-2">·</span>
                        <span class="text-sm font-semibold"><?php echo htmlspecialchars($venue['address']) ?></span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2 mb-8 relative">
                    <!-- Main Image (First in Array) on the Left -->
                    <div class="col-span-2">
                        <?php if (!empty($venue['image_urls'])): ?>
                            <img src="./<?= htmlspecialchars($venue['image_urls'][0]) ?>" alt="Venue Image"
                                class="venue-image w-full h-[30.5rem] object-cover rounded-lg" data-image-index="0">
                        <?php else: ?>
                            <img src="default-image.jpg" alt="Default Venue Image"
                                class="venue-image w-full h-full object-cover rounded-lg">
                        <?php endif; ?>
                    </div>

                    <!-- Small Images on the Right -->
                    <div class="space-y-2">
                        <?php if (!empty($venue['image_urls']) && count($venue['image_urls']) > 1): ?>
                            <img src="./<?= htmlspecialchars($venue['image_urls'][1]) ?>" alt="Venue Image"
                                class="venue-image w-full h-60 object-cover rounded-lg" data-image-index="1">
                        <?php else: ?>
                            <div
                                class="bg-slate-50 w-full h-60 rounded-lg shadow-lg border flex items-center justify-center">
                                <p>No more image to show</p>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($venue['image_urls']) && count($venue['image_urls']) > 2): ?>
                            <img src="./<?= htmlspecialchars($venue['image_urls'][2]) ?>" alt="Venue Image"
                                class="venue-image w-full h-60 object-cover rounded-lg" data-image-index="2">
                        <?php else: ?>
                            <div
                                class="bg-slate-50 w-full h-60 rounded-lg shadow-lg border flex items-center justify-center">
                                <p>No more image to show</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Show All Photos Button -->
                    <button id="showAllPhotosBtn" onclick="openGallery(0)"
                        class="absolute border-2 border-gray-500 bottom-4 right-4 bg-slate-50 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">
                        Show all photos
                    </button>
                </div>

                <div class="flex gap-12 flex-col md:flex-row">
                    <div class="md:w-2/3">
                        <div class="flex justify-between items-center mb-6 gap-4">
                            <div>
                                <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($venue['tag']) ?> at
                                    <?php echo htmlspecialchars($venue['address']); ?>
                                </h2>
                            </div>
                        </div>

                        <hr class="my-6">

                        <h3 class="text-xl font-semibold mb-4">Place Description</h3>
                        <p class="mb-4"><?php echo htmlspecialchars($venue['description']) ?></p>

                        <hr class="my-6">

                        <h3 class="text-xl font-semibold mb-4">Venue Capacity</h3>
                        <p class="">
                            <?php echo htmlspecialchars($venue['max_attendees']) ?>
                            guests
                        </p>

                        <hr class="my-6">

                        <h3 class="text-xl font-semibold mb-4">Venue Availability</h3>
                        <p class="">
                            <?php
                            if (!empty($venue['opening_time']) && !empty($venue['closing_time'])) {
                                $openingTime = DateTime::createFromFormat('H:i:s', $venue['opening_time'])->format('h:i A');
                                $closingTime = DateTime::createFromFormat('H:i:s', $venue['closing_time'])->format('h:i A');
                                echo "Open from $openingTime to $closingTime";
                            } else {
                                echo "Available 24/7";
                            }
                            ?>
                        </p>
                        <p>
                            <?php
                            if (!empty($venue['min_time']) && !empty($venue['max_time'])) {
                                $minTime = $venue['min_time'];
                                $maxTime = $venue['max_time'];
                                echo "Minimum of $minTime hours and a maximum of $maxTime hours";
                            } else {
                                echo "No time limit";
                            }
                            ?>
                        </p>

                        <hr class="my-6">

                        <h3 class="text-xl font-semibold mb-4">What this place offers</h3>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <?php if (!empty($venue['amenities'])): ?>
                                <?php
                                $amenities = json_decode($venue['amenities'], true);
                                if ($amenities):
                                    ?>
                                    <ul class="list-disc pl-5 space-y-1">
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
                        </div>

                        <hr class="my-6">

                        <h3 class="text-xl font-semibold mb-4">Location</h3>
                        <div class="bg-gray-100 rounded-lg h-96 w-full mb-4" id="map">
                            <?php include_once './openStreetMap/autoMapping.osm.php' ?>
                        </div>

                        <hr class="my-6">

                        <h3 class="text-xl font-semibold mb-4">Ratings & Reviews</h3>
                        <div class="mb-8">
                            <div class="flex items-start gap-8">
                                <!-- Overall Rating -->
                                <div class="text-center">
                                    <div class="text-5xl font-bold mb-1">
                                        <?php echo number_format($venue['rating'], 1) ?>
                                    </div>
                                    <div class="flex items-center justify-center text-yellow-400 mb-1">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <?php echo htmlspecialchars($venue['total_reviews']) ?> reviews
                                    </div>
                                </div>

                                <!-- Rating Bars -->
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

                            <!-- Individual Reviews -->
                            <div class="mt-8 space-y-6">
                                <?php foreach ($reviews as $index => $review): ?>
                                    <div class="border-b pb-6 review" data-index="<?php echo $index; ?>"
                                        style="<?php echo $index === 0 ? '' : 'display: none;'; ?>">
                                        <div class="flex items-center gap-4 mb-4">
                                            <?php
                                            if ($review['profile_pic'] == null) {
                                                echo '<div class="w-12 h-12 bg-black text-white rounded-full flex items-center justify-center font-bold">';
                                                echo htmlspecialchars($review['user_name'][0]); // Display the first letter of the user's first name
                                                echo '</div>';
                                            } else {
                                                echo '<img class="w-12 h-12 bg-gray-200 rounded-full" src="./' . htmlspecialchars($review['profile_pic']) . '" alt="Profile Picture">';
                                            }
                                            ?>

                                            <div>
                                                <a href="user-page.php"
                                                    class="font-semibold hover:underline"><?php echo htmlspecialchars($review['user_name']); ?></a>
                                                <p class="text-sm text-gray-500">
                                                    <?php
                                                    $originalDate = $review['date'];
                                                    $formattedDate = date('F j, Y \a\t g:i A', strtotime($originalDate)); // Format the date
                                                    echo htmlspecialchars($formattedDate);
                                                    ?>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="flex text-yellow-400 mb-2">
                                            <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                                <i class="fas fa-star"></i>
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

                        <hr class="my-6">

                        <!-- New Section: Things You Should Know -->
                        <h3 class="text-xl font-semibold mb-4">Things You Should Know</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- House Rules -->
                            <div>
                                <h4 class="font-semibold text-lg mb-3">House Rules</h4>
                                <ul class="space-y-2">
                                    <?php
                                    if (isset($venue['time_inout'])) {
                                        $timeInOut = json_decode($venue['time_inout'], true); // Decode into array
                                    
                                        // Convert to 12-hour format with AM/PM
                                        $checkIn = DateTime::createFromFormat('H:i', $timeInOut['check_in'])->format('h:i A');
                                        $checkOut = DateTime::createFromFormat('H:i', $timeInOut['check_out'])->format('h:i A');
                                        ?>
                                        <li class="flex items-center gap-2">
                                            <i class="fas fa-clock text-gray-600"></i>
                                            <span>Check-in: After <?php echo htmlspecialchars($checkIn); ?></span>
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <i class="fas fa-clock text-gray-600"></i>
                                            <span>Checkout: Before <?php echo htmlspecialchars($checkOut); ?></span>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-users text-gray-600"></i>
                                        <span>Maximum <?php echo htmlspecialchars($venue['max_attendees']) ?>
                                            guests</span>
                                    </li>
                                    <?php
                                    if (!empty($venue['rules'])) {
                                        $rules = json_decode($venue['rules'], true); // Decode the JSON string into an array
                                        if ($rules):
                                            ?>
                                            <?php foreach ($rules as $rule): ?>
                                                <li class="list-disc list-inside flex items-center gap-2">
                                                    <?= htmlspecialchars($rule) ?>
                                                </li>
                                            <?php endforeach; ?>
                                            <?php
                                        endif;
                                    }
                                    ?>
                                </ul>
                            </div>

                            <!-- Cancellation Policy -->
                            <div>
                                <h4 class="font-semibold text-lg mb-3">Cancellation Policy</h4>
                                <div class="space-y-3">
                                    <p class="text-gray-700">Free cancellation for 48 hours after booking.</p>
                                    <p class="text-gray-700">Cancel before check-in and get a full refund, minus the
                                        service
                                        fee.</p>
                                    <div class="mt-4">
                                        <h5 class="font-medium mb-2">Refund Policy:</h5>
                                        <ul class="space-y-2 text-gray-700">
                                            <li class="flex items-center gap-2">
                                                <i class="fas fa-check text-green-600"></i>
                                                <span>100% refund: Cancel 7 days before check-in</span>
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="fas fa-check text-green-600"></i>
                                                <span>50% refund: Cancel 3-7 days before check-in</span>
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <i class="fas fa-times text-red-600"></i>
                                                <span>No refund: Cancel less than 3 days before check-in</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6">


                    </div>

                    <div class="md:w-1/3">
                        <div class="border rounded-xl p-6 shadow-lg mb-6">
                            <h3 class="text-xl font-semibold mb-4">The Owner</h3>
                            <div class="flex gap-4">
                                <a href="owner-page.php?id=<?php echo htmlspecialchars($owner['id']); ?>"
                                    class="bg-slate-50 p-6 w-full hover:bg-slate-100 transition duration-300 cursor-pointer">
                                    <!-- Card Header -->
                                    <div class="text-center mb-4">
                                        <div
                                            class="size-24 text-2xl rounded-full bg-black text-white flex items-center justify-center mx-auto mb-4">
                                            <?php

                                            $profilePic = $owner['profile_pic'];
                                            if (isset($owner) && empty($profilePic)) {
                                                echo $owner['firstname'][0];
                                            } else {
                                                echo '<img id="profileImage" name="profile_image" src="./' . htmlspecialchars($profilePic) . '" alt="Profile Picture" class="w-full h-full rounded-full object-cover">';
                                            }

                                            ?>
                                        </div>
                                        <h2 class="text-xl font-semibold text-gray-800">
                                            <?php echo htmlspecialchars($owner['firstname'] . " " . $owner['lastname']); ?>
                                        </h2>
                                        <p class="text-xs text-gray-500">Owner</p>

                                    </div>
                                </a>
                            </div>
                        </div>




                        <div class="sticky top-32 border rounded-xl p-6 shadow-lg bg-slate-50">

                            <form id="reservationForm" method="POST">
                                <!-- Pr ice Header -->
                                <div class="flex flex-col lg:flex-row justify-between items-center mb-6 flex-wrap">
                                    <div class="flex items-center justify-center w-full text-center">
                                        <span
                                            class="text-lg font-bold">₱<?php echo htmlspecialchars($venue['price']); ?><span
                                                class="text-sm text-gray-600
                                                font-normal"><?php echo $venue['pricing_type'] == "fixed" ? " × hours" : " × hours × attendees" ?></span></span>
                                    </div>
                                </div>

                                <!-- Date and Guest Selection -->
                                <div class="border rounded-xl mb-6 shadow-sm bg-gray-50 relative">
                                    <div class="flex flex-col border-b">
                                        <input type="hidden" name="venueId"
                                            value="<?php echo htmlspecialchars($venue['id']); ?>">
                                        <div class="w-full p-3 border-r">
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">CHECK-IN <?php if (isset($venue['opening_time']) && isset($venue['closing_time'])) {
                                                $openingTime = DateTime::createFromFormat('H:i:s', $venue['opening_time'])->format('h:i A');
                                                $closingTime = DateTime::createFromFormat('H:i:s', $venue['closing_time'])->format('h:i A');
                                                echo "($openingTime to $closingTime)";
                                            } ?> </label>
                                            <input type="text" readonly name="checkin" id="checkin"
                                                placeholder="Set Date"
                                                class="w-full bg-transparent cursor-pointer focus:outline-none text-gray-800">
                                        </div>
                                        <div class="w-full p-3">
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">EVENT DURATION <?php
                                            if (!empty($venue['min_time']) && !empty($venue['max_time'])) {
                                                $minTime = $venue['min_time'];
                                                $maxTime = $venue['max_time'];
                                                echo "(Min $minTime hours & Max $maxTime hours)";
                                            } else {
                                                echo "(No time limit)";
                                            }
                                            ?></label>
                                            <input type="text" name="duration" id="duration"
                                                placeholder="Set Event Duration"
                                                class="w-full bg-transparent focus:outline-none text-gray-800">
                                            <input type="hidden" name="checkout" id="checkout" placeholder="Set Date"
                                                class="w-full bg-transparent focus:outline-none text-gray-800">
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                                            GUESTS (Min <span
                                                class="text-red-500 font-bold"><?php echo htmlspecialchars($venue['min_attendees']); ?></span>
                                            & Max <span
                                                class="text-red-500 font-bold"><?php echo htmlspecialchars($venue['max_attendees']); ?></span>)
                                        </label>
                                        <input type="number" min="<?php echo $venue['min_attendees'] ?>"
                                            name="numberOfGuest" id="numberOFGuest"
                                            max="<?php echo htmlspecialchars($venue['max_attendees']); ?>"
                                            class="w-full bg-transparent focus:outline-none text-gray-800"
                                            placeholder="Enter number of guests">
                                    </div>
                                    <div class="p-3">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                                            SPECIAL REQUEST
                                        </label>
                                        <textarea name="specialRequest" id="specialRequest"
                                            placeholder="Enter your request if any"
                                            class="w-full bg-transparent focus:outline-none text-gray-800"
                                            rows="3"></textarea>
                                    </div>
                                </div>
                                <!-- Price Breakdown -->
                                <div class="space-y-4 mb-6">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 hover:text-gray-900 cursor-help">
                                            ₱<?php echo htmlspecialchars($venue['price']); ?> × <span
                                                total-Hours>0</span>
                                            Hours
                                        </span>
                                        <span class="font-medium flex items-center">
                                            ₱ <p class="text-right bg-transparent w-24 " name="totalPriceForHours"
                                                value="0" readonly>0</p>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 hover:text-gray-900 cursor-help">
                                            Entrance fee × <span total-entrance-guests>0</span> guest
                                        </span>
                                        <span class="font-medium flex items-center">
                                            ₱<p class="text-right bg-transparent w-24 " name="totalEntranceFee"
                                                value="<?php echo htmlspecialchars($venue['entrance']) ?? 0; ?>"
                                                readonly>0
                                            </p>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 hover:text-gray-900 cursor-help">Cleaning fee</span>
                                        <span class="font-medium flex items-center">₱
                                            <p class="text-right bg-transparent w-24" name="cleaningFee" readonly>
                                                <?php echo htmlspecialchars($venue['cleaning']) ?? 0; ?>
                                            </p>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 hover:text-gray-900 cursor-help">HubVenue service
                                            fee</span>
                                        <span class="font-medium flex items-center">₱
                                            <p class="text-right bg-transparent w-24" name="serviceFee" value="0"
                                                readonly>
                                                0
                                            </p>
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-gray-600 hover:text-gray-900 cursor-help text-xs">Discounts(PWD/Senior
                                            Citizen)
                                        </span>
                                        <span class="font-medium text-right bg-transparent w-24" readonly>
                                            <?php
                                            // var_dump($discountStatus);
                                            
                                            if ($discountStatus) {
                                                echo $MANDATORY_DISCOUNT_VALUE . "%";
                                            } else {
                                                echo "0%";
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="border-t pt-4 mb-6">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold">Total</span>
                                        <span class="font-bold flex text-lg">
                                            ₱
                                            <p class="text-right bg-transparent w-24 font-bold" name="totalPrice"
                                                value="0" readonly></p>
                                        </span>
                                    </div>
                                </div>

                                <p class="text-center text-gray-600 my-4">You won't be charged yet</p>
                                <button type="submit"
                                    class="w-full bg-green-500 text-white rounded-lg py-3 font-semibold mb-4 hover:bg-green-600 transition duration-300">Reserve</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="venue-comparison hidden" id="comparisonPanel">
        <button class="comparison-close hidden" id="closeCompareBtn" type="button" onclick="window.closeComparison()">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="comparison-content">
            <h2 class="text-2xl font-semibold">Compare With</h2>
            <div id="comparisonVenues" class="space-y-4">
                <!-- Venues will be loaded here -->
            </div>
        </div>
    </div>

    <script src="./vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="./js/user.jquery.js"></script>
    <script>
        const termsBtn = document.getElementById('termsBtn');
        const termsModal = document.getElementById('terms');

        termsBtn.addEventListener('click', function () {
            termsModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        terms.addEventListener('click', function () {
            termsModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
    </script>
    <script>
        window.closeComparison = function () {
            const mainContent = document.querySelector('.main-content');
            const mainContainer = document.querySelector('.main-container');
            const comparisonPanel = document.getElementById('comparisonPanel');
            const closeCompareBtn = document.getElementById('closeCompareBtn');

            document.body.style.overflow = '';
            mainContent.classList.remove('shifted');
            mainContainer.classList.remove('shifted');
            comparisonPanel.classList.remove('active');

            setTimeout(() => {
                comparisonPanel.classList.add('hidden');
                closeCompareBtn.classList.add('hidden');
            }, 300);
        }
    </script>

    <!-- pagination -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reviews = document.querySelectorAll('.review');
            let currentIndex = 0;

            function showReview(index) {
                reviews.forEach((review, i) => {
                    review.style.display = i === index ? 'block' : 'none';
                });
            }

            document.getElementById('prevReview').addEventListener('click', function () {
                if (currentIndex > 0) {
                    currentIndex--;
                    showReview(currentIndex);
                } else {
                    currentIndex = reviews.length - 1;
                    showReview(currentIndex);
                }
            });

            document.getElementById('nextReview').addEventListener('click', function () {
                if (currentIndex < reviews.length - 1) {
                    currentIndex++;
                    showReview(currentIndex);
                } else {
                    currentIndex = 0;
                    showReview(currentIndex);
                }
            });

            showReview(currentIndex);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // DOM Elements
            const checkinInput = document.querySelector('input[name="checkin"]');
            const durationInput = document.querySelector('input[name="duration"]');
            const checkoutInput = document.querySelector('input[name="checkout"]');
            const guestsInput = document.querySelector('input[name="numberOfGuest"]');
            const totalPriceInput = document.querySelector('p[name="totalPrice"]');
            const totalPriceForHoursInput = document.querySelector('p[name="totalPriceForHours"]');
            const serviceFeeInput = document.querySelector('p[name="serviceFee"]');
            const entranceFeeInput = document.querySelector('p[name="totalEntranceFee"]');
            const cleaningFeeInput = document.querySelector('p[name="cleaningFee"]');
            const reservationForm = document.getElementById('reservationForm');

            // PHP Variables (Sanitized)
            const pricePerHour = parseFloat(<?php echo json_encode($venue['price']); ?>);
            const entranceFee = parseFloat(<?php echo json_encode($venue['entrance']); ?>);
            const cleaningFee = parseFloat(<?php echo json_encode($venue['cleaning']); ?>);
            const SERVICE_FEE_RATE = 0.15;
            const minGuests = parseInt(<?php echo json_encode($venue['min_attendees']); ?>, 10);
            const maxGuests = parseInt(<?php echo json_encode($venue['max_attendees']); ?>, 10);
            const minTime = parseInt(<?php echo json_encode($venue['min_time']); ?>, 10);
            const maxTime = parseInt(<?php echo json_encode($venue['max_time']); ?>, 10);
            const closeDateTime = <?php echo json_encode($closedDateTime['closing_time'] ? $closedDateTime['closing_time'] : null); ?>;
            const openDateTime = <?php echo json_encode($closedDateTime['opening_time'] ? $closedDateTime['opening_time'] : null); ?>;
            const discountMultiplier = <?php echo $discountStatus ? 0.8 : 1; ?>;
            const pricingType = <?php echo json_encode($venue['pricing_type']); ?>;
            const isFixedPricing = pricingType === "fixed" ? true : false;
            let timeout = null;
            let checkOutDateTemp = null;

            // Initialize Flatpickr with validation
            // flatpickr("#checkin", {
            //     enableTime: true,
            //     dateFormat: "Y-m-d h:i K",
            //     minDate: "today",
            //     time_24hr: false,
            //     onClose: function (selectedDates) {
            //         if (selectedDates.length > 0) {
            //             validateDateTime(selectedDates[0]);
            //         }
            //     }
            // });


            document.getElementById("checkin").addEventListener("click", function () {
                document.getElementById("datetimeselector").classList.remove("hidden");
                document.getElementById("datetimeselector").classList.add("flex");

                document.body.style.overflow = "hidden";
            });

            document.getElementById("datetimeselector").addEventListener("click", function (event) {
                if (event.target === this) {
                    document.getElementById("datetimeselector").classList.remove("flex");
                    document.getElementById("datetimeselector").classList.add("hidden");

                    document.body.style.overflow = "auto";
                }
            });



            // flatpickr("#checkin", {
            //     enableTime: true,
            //     dateFormat: "Y-m-d h:i K",
            //     minDate: "today",
            //     time_24hr: false,
            //     allowInput: false,
            //     disable: [
            //         function (date) {
            //             // Disable booked dates
            //             return bookedDates.includes(date.toISOString().split('T')[0]);
            //         }
            //     ],
            //     onClose: function (selectedDates) {
            //         if (selectedDates.length > 0) {
            //             validateDateTime(selectedDates[0]);
            //         }
            //     }
            // });

            flatpickr("#duration", {
                enableTime: true,
                noCalendar: true, // Hide date selection
                dateFormat: "H:i", // Only hours and minutes
                time_24hr: true, // Use 24-hour format
                allowInput: false,
                defaultHour: 0, // Start from 0
                defaultMinute: 0,
            });

            // flatpickr("#checkout", {
            //     enableTime: true,
            //     dateFormat: "Y-m-d h:i K",
            //     minDate: "today",
            //     time_24hr: false,
            //     onClose: function (selectedDates) {
            //         if (selectedDates.length > 0) {
            //             validateDateTime(selectedDates[0]);
            //             // validateCheckinCheckout();
            //         }
            //     }
            // });

            // Validate selected date and time
            function validateDateTime(selectedDateTime) {
                const now = new Date();

                // Check if the selected date is in the past
                if (selectedDateTime < now) {
                    showModal("You cannot select a past date and time.", () => {
                        checkinInput.value = "";
                        checkoutInput.value = "";
                        calculateTotal();
                    }, "black_ico.png");
                    return false;
                }

                // Extract hours and minutes from the selected date
                const selectedHours = selectedDateTime.getHours();
                const selectedMinutes = selectedDateTime.getMinutes();

                // Check if the selected time is outside the allowed range
                if (closeDateTime && openDateTime) {
                    const [closeHour, closeMinutes] = closeDateTime.split(":").map(Number);
                    const [openHour, openMinutes] = openDateTime.split(":").map(Number);

                    if ((selectedHours > closeHour || (selectedHours === closeHour && selectedMinutes >= closeMinutes)) ||
                        (selectedHours < openHour || (selectedHours === openHour && selectedMinutes < openMinutes))) {
                        showModal("Selected time is not available!", () => {
                            checkinInput.value = "";
                            checkoutInput.value = "";
                            durationInput.value = "";
                            calculateTotal();
                        }, "black_ico.png");
                        return false;
                    }
                }

                return true;
            }
            // Additional validation for checkout being after check-in
            function validateCheckinCheckout() {
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                if (checkoutDate <= checkinDate) {
                    showModal("Checkout time must be after check-in time.", () => {
                        checkoutInput.value = "";
                        calculateTotal();
                    }, "black_ico.png");
                    return false;
                }

                return true;
            }

            function validateDuration() {
                if (!durationInput.value.includes(":")) {
                    showModal("Invalid duration format. Expected HH:mm.", () => {
                        durationInput.value = "";
                        calculateCheckout();
                        calculateTotal();
                    }, "black_ico.png");
                    return false;
                }

                const [hours, minutes] = durationInput.value.split(":").map(Number);

                // Ensure valid numeric values
                if (isNaN(hours) || isNaN(minutes)) {
                    showModal("Invalid duration. Please enter a valid time.", () => {
                        durationInput.value = "";
                        calculateCheckout();
                        calculateTotal();
                    }, "black_ico.png");
                    return false;
                }

                const totalHours = hours + minutes / 60;

                if (minTime !== 0 && maxTime !== 0) {
                    if (totalHours < minTime || totalHours > maxTime) {
                        showModal(`Duration must be between ${minTime} and ${maxTime} hours.`, () => {
                            durationInput.value = "";
                            checkoutInput.value = "";
                            calculateCheckout();
                            calculateTotal();
                        }, "black_ico.png");
                        return false;
                    }
                }
                calculateCheckout();
                calculateTotal();


                return true;
            }

            // Validate guest count with debounce
            guestsInput.addEventListener("input", () => {
                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    const value = parseInt(guestsInput.value, 10);
                    let guestView = document.querySelector('span[total-entrance-guests]');

                    if (value < minGuests) {
                        showModal(`Minimum number of attendees is ${minGuests}`, undefined, "black_ico.png");
                        guestsInput.value = minGuests;
                        guestView.textContent = minGuests;
                    } else if (value > maxGuests) {
                        showModal(`Maximum number of attendees is ${maxGuests}`, undefined, "black_ico.png");
                        guestsInput.value = maxGuests;
                        guestView.textContent = maxGuests;
                    }
                }, 500); // Debounce time of 500ms
            });

            function calculateCheckout() {
                const checkinInput = document.getElementById("checkin");
                const durationInput = document.getElementById("duration");
                const checkoutInput = document.getElementById("checkout");

                // Ensure both inputs have values
                if (!checkinInput.value || !durationInput.value) {
                    return;
                }

                // Parse the check-in date using flatpickr's parseDate
                const checkinDate = flatpickr.parseDate(checkinInput.value, "Y-m-d h:i K");
                if (!checkinDate) {
                    return;
                }

                // Parse the duration (H:i format)
                const durationParts = durationInput.value.split(":");

                const hours = parseInt(durationParts[0], 10);
                const minutes = parseInt(durationParts[1], 10);

                // Validate duration values
                if (isNaN(hours) || isNaN(minutes) || hours < 0 || minutes < 0 || minutes >= 60) {
                    console.error("Invalid duration values. Hours must be non-negative, and minutes must be between 0 and 59.");
                    return;
                }

                // Add duration to the check-in date
                checkinDate.setHours(checkinDate.getHours() + hours);
                checkinDate.setMinutes(checkinDate.getMinutes() + minutes);

                // Format the checkout date using flatpickr's formatDate
                const formattedCheckout = flatpickr.formatDate(checkinDate, "Y-m-d h:i K");
                checkoutInput.value = formattedCheckout;
                checkOutDateTemp = new Date(checkinDate);
            }

            function parseDuration(duration) {
                const [hours, minutes] = duration.split(":").map(Number);
                return hours + minutes / 60;
            }

            function calculateTotal() {
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                if (isNaN(checkinDate) || isNaN(checkoutDate)) {
                    return;
                }
                const durationValue = parseDuration(durationInput.value);

                // const hours = (checkoutDate - checkinDate) / (1000 * 60 * 60);
                let guests = parseInt(guestsInput.value, 10) || minGuests;
                // console.log(durationValue);

                if (durationValue > 0) {
                    const discountMultiplier = <?php echo $discountStatus ? 0.8 : 1; ?>;
                    const totalEntranceFee = entranceFee * guests;
                    const totalCleaningFee = cleaningFee;
                    let totalPriceForHours = 0;

                    if (isFixedPricing) {
                        totalPriceForHours = pricePerHour * durationValue;
                    } else {
                        totalPriceForHours = pricePerHour * durationValue * guests;
                    }

                    const serviceFee = (totalPriceForHours + totalEntranceFee + totalCleaningFee) * SERVICE_FEE_RATE;
                    const grandTotal = (totalPriceForHours + totalEntranceFee + totalCleaningFee + serviceFee) * discountMultiplier;
                    const grandTotalshow = (totalPriceForHours + totalEntranceFee + totalCleaningFee + serviceFee);

                    // Update hidden inputs
                    document.querySelector('span[total-Hours]').textContent = durationValue;
                    document.querySelector('span[total-entrance-guests]').textContent = guests;
                    totalPriceForHoursInput.textContent = totalPriceForHours.toFixed(2);
                    entranceFeeInput.textContent = totalEntranceFee.toFixed(2);
                    cleaningFeeInput.textContent = totalCleaningFee.toFixed(2);
                    serviceFeeInput.textContent = serviceFee.toFixed(2);
                    totalPriceInput.textContent = grandTotal.toFixed(2);

                    appendHiddenInput(reservationForm, 'price', pricePerHour.toFixed(2));
                    appendHiddenInput(reservationForm, 'entranceFee', totalEntranceFee.toFixed(2));
                    appendHiddenInput(reservationForm, 'cleaningFee', (totalCleaningFee).toFixed(2));
                    appendHiddenInput(reservationForm, 'duration', durationInput.value);
                    appendHiddenInput(reservationForm, 'discount', <?php echo $discountStatus ? $discountStatus['id'] : null ?>);
                    appendHiddenInput(reservationForm, 'totalPriceForHours', totalPriceForHours.toFixed(2));
                    appendHiddenInput(reservationForm, 'serviceFee', serviceFee.toFixed(2));
                    appendHiddenInput(reservationForm, 'grandTotal', grandTotal.toFixed(2));
                    appendHiddenInput(reservationForm, 'grandTotalShow', grandTotalshow.toFixed(2));
                }
            }
            // Append hidden input to the form
            function appendHiddenInput(form, name, value) {
                const input = document.createElement('input');
                input.type = 'hidden'; // Set input type to hidden
                input.name = name; // Set the name attribute
                input.value = value; // Set the value attribute
                form.appendChild(input); // Append the input to the form
            }

            checkinInput.addEventListener("change", calculateCheckout);
            durationInput.addEventListener("input", calculateCheckout);
            guestsInput.addEventListener("input", calculateCheckout);

            // Event listeners
            checkinInput.addEventListener('change', () => {
                validateCheckinCheckout();
                calculateTotal();
            });
            checkoutInput.addEventListener('change', () => {
                validateCheckinCheckout();
                calculateTotal();
            });
            durationInput.addEventListener('change', () => {
                validateDuration();
                calculateTotal();
            });
            guestsInput.addEventListener('input', calculateTotal);

            // Initial calculation
            calculateTotal();
        });
    </script>

    <!-- image gallery -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const images = <?php echo json_encode($venue['image_urls'] ?? []); ?>;
            if (!images.length) return;

            const mainImage = document.querySelector('.col-span-2 .venue-image');
            const smallImages = document.querySelectorAll('.space-y-2 .venue-image');
            let currentMainIndex = 0;
            let currentSmallIndices = [1, 2];

            // Function to update main image with transition
            function updateMainImage(newIndex) {

                mainImage.classList.add('fade-out');

                setTimeout(() => {
                    mainImage.src = './' + images[newIndex];
                    mainImage.dataset.imageIndex = newIndex;
                    mainImage.classList.remove('fade-out');
                    mainImage.classList.add('fade-in');

                    setTimeout(() => {
                        mainImage.classList.remove('fade-in');
                    }, 500);
                }, 500);

                currentMainIndex = newIndex;
            }

            // Function to update small images without transition
            function updateSmallImages() {
                smallImages.forEach((img, i) => {
                    const nextIndex = (currentMainIndex + i + 1) % images.length;
                    img.src = './' + images[nextIndex];
                    img.dataset.imageIndex = nextIndex;
                    currentSmallIndices[i] = nextIndex;
                });
            }

            // Add click handlers to small images
            smallImages.forEach(img => {
                img.addEventListener('click', function () {
                    const clickedIndex = parseInt(this.dataset.imageIndex);
                    updateMainImage(clickedIndex);

                    // After updating main image, update small images
                    setTimeout(() => {
                        updateSmallImages();
                    }, 500);
                });
            });

            // Automatic rotation for main image only
            setInterval(() => {
                const nextIndex = (currentMainIndex + 1) % images.length;
                updateMainImage(nextIndex);
                updateSmallImages();
            }, 5000);

            // Pause shuffling when user hovers over images
            const imageContainer = document.querySelector('.grid');
            let rotationInterval;

            function startRotation() {
                rotationInterval = setInterval(() => {
                    const nextIndex = (currentMainIndex + 1) % images.length;
                    updateMainImage(nextIndex);
                    updateSmallImages();
                }, 5000);
            }

            imageContainer.addEventListener('mouseenter', () => {
                clearInterval(rotationInterval);
            });

            // Resume shuffling when user moves mouse away
            imageContainer.addEventListener('mouseleave', () => {
                startRotation();
            });

            // Start initial rotation
            startRotation();
        });
    </script>

    <!-- Photo Gallery Modal -->
    <div id="photoGalleryModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black bg-opacity-80 transition-opacity duration-300 opacity-0"
            id="modalBackdrop"></div>

        <!-- Modal Content -->
        <div class="relative h-full w-full flex flex-col">
            <!-- Header -->
            <div class="absolute top-0 left-0 right-0 p-4 z-10">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <button id="closeGallery" class="text-white hover:bg-slate-50/10 p-2 rounded-full transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    <span class="text-white text-sm">
                        <span id="currentImageIndex">1</span> / <span id="totalImages">5</span>
                    </span>
                </div>
            </div>

            <!-- Main Gallery Area -->
            <div class="flex-1 flex items-center justify-center p-4">
                <div class="relative w-full max-w-7xl mx-auto">
                    <!-- Navigation Buttons -->
                    <button id="prevImage"
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:bg-slate-50/10 p-4 rounded-full transition">
                        <i class="fas fa-chevron-left text-2xl"></i>
                    </button>

                    <button id="nextImage"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:bg-slate-50/10 p-4 rounded-full transition">
                        <i class="fas fa-chevron-right text-2xl"></i>
                    </button>

                    <!-- Main Image -->
                    <div class="flex justify-center">
                        <img id="mainGalleryImage" src="" alt="Venue Image" class="max-h-[80vh] object-contain">
                    </div>
                </div>
            </div>

            <!-- Thumbnails -->
            <div class="w-full p-4">
                <div class="max-w-7xl mx-auto">
                    <div id="thumbnailContainer" class="flex gap-2 overflow-x-auto pb-2">
                        <!-- Thumbnails will be inserted here by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- photo gallery -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('photoGalleryModal');
            const modalBackdrop = document.getElementById('modalBackdrop');
            const mainGalleryImage = document.getElementById('mainGalleryImage');
            const thumbnailContainer = document.getElementById('thumbnailContainer');
            const currentImageIndex = document.getElementById('currentImageIndex');
            const totalImages = document.getElementById('totalImages');
            const prevButton = document.getElementById('prevImage');
            const nextButton = document.getElementById('nextImage');
            const closeButton = document.getElementById('closeGallery');

            const images = <?php echo json_encode($venue['image_urls'] ?? []); ?>;
            let currentIndex = 0;

            // Make openGallery function available globally
            window.openGallery = function (index) {
                currentIndex = index;
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalBackdrop.classList.remove('opacity-0');
                }, 10);
                updateGallery();
                createThumbnails();
                document.body.style.overflow = 'hidden';
            }

            // Show All Photos button click handler
            const showAllPhotosButton = document.querySelector('button[class*="border-2 border-gray-500"]');
            if (showAllPhotosButton) {
                showAllPhotosButton.addEventListener('click', function () {
                    openGallery(0);
                });
            }

            function closeGallery() {
                modalBackdrop.classList.add('opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }, 300);
            }

            function updateGallery() {
                mainGalleryImage.src = './' + images[currentIndex];
                currentImageIndex.textContent = currentIndex + 1;
                totalImages.textContent = images.length;

                // Update thumbnails active state
                document.querySelectorAll('.thumbnail').forEach((thumb, index) => {
                    if (index === currentIndex) {
                        thumb.classList.add('ring-2', 'ring-white');
                        thumb.classList.remove('opacity-70');
                    } else {
                        thumb.classList.remove('ring-2', 'ring-white');
                        thumb.classList.add('opacity-70');
                    }
                });
            }

            function createThumbnails() {
                thumbnailContainer.innerHTML = '';
                images.forEach((image, index) => {
                    const thumb = document.createElement('img');
                    thumb.src = './' + image;
                    thumb.classList.add('thumbnail', 'h-20', 'w-32', 'object-cover', 'cursor-pointer',
                        'transition-opacity', 'duration-200', 'opacity-70', 'hover:opacity-100');
                    if (index === currentIndex) {
                        thumb.classList.add('ring-2', 'ring-white');
                        thumb.classList.remove('opacity-70');
                    }
                    thumb.addEventListener('click', () => {
                        currentIndex = index;
                        updateGallery();
                    });
                    thumbnailContainer.appendChild(thumb);
                });
            }

            // Event Listeners
            closeButton.addEventListener('click', closeGallery);
            modalBackdrop.addEventListener('click', closeGallery);

            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                updateGallery();
            });

            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % images.length;
                updateGallery();
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (!modal.classList.contains('hidden')) {
                    if (e.key === 'Escape') closeGallery();
                    if (e.key === 'ArrowLeft') prevButton.click();
                    if (e.key === 'ArrowRight') nextButton.click();
                }
            });
        });
    </script>

    <!-- comparison view -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Comparison Panel Functionality
            const compareButton = document.getElementById('compareButton');
            const mainContent = document.querySelector('.main-content');
            const comparisonPanel = document.getElementById('comparisonPanel');
            const comparisonVenues = document.getElementById('comparisonVenues');
            const closeCompareBtn = document.getElementById('closeCompareBtn');

            // Completely separate compare button handler
            if (compareButton) {
                compareButton.onclick = function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation(); // Stop other events from firing

                    // Remove any photo gallery related classes/states
                    const photoGalleryModal = document.getElementById('photoGalleryModal');
                    if (photoGalleryModal) {
                        photoGalleryModal.classList.add('hidden');
                    }

                    openComparisonPanel();
                    return false;
                };
            }

            function openComparisonPanel() {
                document.body.style.overflow = 'hidden';
                mainContent.classList.add('shifted');
                return false;
            };


            function openComparisonPanel() {
                document.body.style.overflow = 'hidden';
                mainContent.classList.add('shifted');
                document.querySelector('.main-container').classList.add('shifted');
                comparisonPanel.classList.remove('hidden');
                comparisonPanel.classList.add('active');
                closeCompareBtn.classList.remove('hidden');
                loadComparisonVenues();
            }

            function closeComparison() {
                document.body.style.overflow = '';
                mainContent.classList.remove('shifted');
                document.querySelector('.main-container').classList.remove('shifted');
                comparisonPanel.classList.remove('active');
                setTimeout(() => {
                    comparisonPanel.classList.add('hidden');
                    closeCompareBtn.classList.add('hidden');
                }, 300);
            }

            async function loadComparisonVenues() {
                try {
                    comparisonVenues.innerHTML = '<div class="text-center py-4">Loading venues...</div>';
                    const response = await fetch('get_comparison_venues.php?current_venue_id=<?php echo $venue['id']; ?>');
                    const venues = await response.json();

                    if (venues.length === 0) {
                        comparisonVenues.innerHTML = '<div class="text-center py-4">No venues available for comparison</div>';
                        return;
                    }

                    // Get current venue's amenities for comparison
                    const currentVenueAmenities = new Set(<?php echo json_encode(json_decode($venue['amenities'])); ?>);
                    const currentVenuePrice = <?php echo $venue['price']; ?>;

                    let comparisonHTML = '';

                    for (const venue of venues) {
                        const [lat, lon] = venue.location.split(',');
                        const nearbyHighlights = await getNearbyHighlights(lat, lon);
                        const venueAmenities = new Set(JSON.parse(venue.amenities));

                        // Calculate unique and shared amenities
                        const uniqueAmenities = [...venueAmenities].filter(x => !currentVenueAmenities.has(x));
                        const sharedAmenities = [...venueAmenities].filter(x => currentVenueAmenities.has(x));

                        // Calculate price difference
                        const priceDiff = venue.price - currentVenuePrice;
                        const priceDiffText = priceDiff === 0 ? 'Same price' :
                            priceDiff > 0 ? `₱${priceDiff.toLocaleString()} more expensive` :
                                `₱${Math.abs(priceDiff).toLocaleString()} cheaper`;

                        comparisonHTML += `
                            <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 mb-6">
                                <div class="relative">
                                    <div class="relative w-full h-48 overflow-hidden group">
                                        <img src="./${venue.image_urls[0]}" alt="${venue.name}" 
                                            class="w-full h-full object-cover transform transition-transform duration-300 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                        <div class="absolute bottom-4 left-4 right-4">
                                            <h3 class="text-xl font-semibold text-white">${venue.name}</h3>
                                            <div class="flex items-center text-white text-sm mt-1">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                <span class="opacity-90">${venue.address}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <!-- Price Comparison -->
                                    <div class="mb-6">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-2xl font-bold text-gray-900">₱${parseFloat(venue.price).toLocaleString()}</span>
                                            <span class="text-sm px-3 py-1 rounded-full ${priceDiff > 0 ? 'bg-red-100 text-red-700' : priceDiff < 0 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'}">
                                                ${priceDiffText}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Nearby Highlights -->
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-gray-900 mb-3">
                                            <i class="fas fa-location-arrow mr-1"></i>
                                            Special Nearby Highlights
                                        </h4>
                                        <div class="space-y-2">
                                            ${nearbyHighlights.length > 0
                                ? nearbyHighlights.map(highlight => formatHighlight(highlight)).join('')
                                : '<p class="text-gray-500 text-sm">No special highlights found nearby</p>'
                            }
                                        </div>
                                    </div>

                                    <!-- Amenities Comparison -->
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-gray-900 mb-3">Unique Amenities</h4>
                                        <div class="flex flex-wrap gap-2">
                                            ${uniqueAmenities.map(amenity => `
                                                <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm">
                                                    ${amenity}
                                                </span>
                                            `).join('')}
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <h4 class="font-semibold text-gray-900 mb-3">Shared Amenities</h4>
                                        <div class="flex flex-wrap gap-2">
                                            ${sharedAmenities.map(amenity => `
                                                <span class="px-3 py-1 bg-gray-50 text-gray-600 rounded-full text-sm">
                                                    ${amenity}
                                                </span>
                                            `).join('')}
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-2 mt-4">
                                        <a href="venues.php?id=${venue.id}" 
                                           class="flex-1 px-4 py-2 bg-gray-900 text-white text-center font-medium rounded-lg hover:bg-green-600 transition-colors">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    }

                    comparisonVenues.innerHTML = comparisonHTML;

                } catch (error) {
                    console.error('Error loading comparison venues:', error);
                    comparisonVenues.innerHTML = '<div class="text-center py-4 text-red-500">Error loading venues</div>';
                }
            }

            // Add this function to fetch nearby amenities from OpenStreetMap
            async function getNearbyHighlights(lat, lon) {
                try {
                    const radius = 1500; // 1.5km radius for wider coverage
                    const query = `
                    [out:json][timeout:25];
                    (
                        way(around:${radius},${lat},${lon})[leisure=park];
                        way(around:${radius},${lat},${lon})[tourism=hotel];
                        way(around:${radius},${lat},${lon})[amenity=cafe];
                        way(around:${radius},${lat},${lon})[tourism=museum];
                        way(around:${radius},${lat},${lon})[natural=beach];
                        way(around:${radius},${lat},${lon})[leisure=garden];
                        way(around:${radius},${lat},${lon})[tourism=viewpoint];
                        way(around:${radius},${lat},${lon})[tourism=attraction];
                        way(around:${radius},${lat},${lon})[leisure=sports_centre];
                        way(around:${radius},${lat},${lon})[amenity=marketplace];
                        way(around:${radius},${lat},${lon})[amenity=theatre];
                        way(around:${radius},${lat},${lon})[amenity=arts_centre];
                    );
                    out body center;
                    >;
                    out skel qt;`;

                    const response = await fetch(`https://overpass-api.de/api/interpreter?data=${encodeURIComponent(query)}`);
                    const data = await response.json();

                    const highlights = [];
                    const seenTypes = new Set(); // To track unique highlight types

                    data.elements.forEach(element => {
                        if (element.tags) {
                            const distance = calculateDistance(lat, lon, element.center.lat, element.center.lon);
                            const walkingTime = calculateWalkingTime(distance);
                            const drivingTime = calculateDrivingTime(distance);

                            // Create a highlight object with specific categorization
                            let highlight = null;

                            if (element.tags.leisure === 'park' && element.tags.name) {
                                highlight = {
                                    type: 'Park',
                                    name: element.tags.name,
                                    category: 'Nature',
                                    icon: 'tree'
                                };
                            } else if (element.tags.tourism === 'hotel' && element.tags.name) {
                                highlight = {
                                    type: 'Hotel',
                                    name: element.tags.name,
                                    category: 'Accommodation',
                                    icon: 'hotel'
                                };
                            } else if (element.tags.amenity === 'cafe' && element.tags.name) {
                                highlight = {
                                    type: 'Cafe',
                                    name: element.tags.name,
                                    category: 'Dining',
                                    icon: 'coffee'
                                };
                            } else if (element.tags.tourism === 'museum' && element.tags.name) {
                                highlight = {
                                    type: 'Museum',
                                    name: element.tags.name,
                                    category: 'Culture',
                                    icon: 'landmark'
                                };
                            } else if (element.tags.natural === 'beach' && element.tags.name) {
                                highlight = {
                                    type: 'Beach',
                                    name: element.tags.name,
                                    category: 'Nature',
                                    icon: 'umbrella-beach'
                                };
                            } else if (element.tags.tourism === 'viewpoint' && element.tags.name) {
                                highlight = {
                                    type: 'Viewpoint',
                                    name: element.tags.name,
                                    category: 'Attraction',
                                    icon: 'mountain'
                                };
                            } else if (element.tags.tourism === 'attraction' && element.tags.name) {
                                highlight = {
                                    type: 'Tourist Attraction',
                                    name: element.tags.name,
                                    category: 'Attraction',
                                    icon: 'star'
                                };
                            }

                            if (highlight && !seenTypes.has(highlight.type)) {
                                seenTypes.add(highlight.type);
                                highlights.push({
                                    ...highlight,
                                    distance,
                                    walkingTime,
                                    drivingTime
                                });
                            }
                        }
                    });

                    // Sort by distance and limit to top 5 unique highlights
                    return highlights
                        .sort((a, b) => a.distance - b.distance)
                        .slice(0, 5);
                } catch (error) {
                    console.error('Error fetching nearby highlights:', error);
                    return [];
                }
            }

            // Helper functions for distance and time calculations
            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371; // Earth's radius in km
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;
                const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            }

            function calculateWalkingTime(distance) {
                const walkingSpeed = 5; // km/h
                return Math.round(distance / walkingSpeed * 60); // minutes
            }

            function calculateDrivingTime(distance) {
                const drivingSpeed = 30; // km/h (urban average)
                return Math.round(distance / drivingSpeed * 60); // minutes
            }

            // Update the venue card HTML in loadComparisonVenues
            function formatHighlight(highlight) {
                const distanceText = highlight.distance < 1 ?
                    `${Math.round(highlight.distance * 1000)}m` :
                    `${highlight.distance.toFixed(1)}km`;

                let timeText = '';
                if (highlight.walkingTime < 60) {
                    timeText = `${highlight.walkingTime}min walk`;
                } else {
                    timeText = `${highlight.drivingTime}min drive`;
                }

                return `
                    <div class="flex flex-col bg-blue-50 rounded-lg p-3 mb-2 hover:bg-blue-100 transition-colors">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-${highlight.icon} text-blue-600"></i>
                            <span class="text-blue-700 font-medium">${highlight.name}</span>
                        </div>
                        <div class="text-sm text-blue-600">
                            <span class="inline-block px-2 py-0.5 bg-blue-100 rounded-full text-xs mb-1">
                                ${highlight.type}
                            </span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-blue-600 mt-1">
                            <span class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                ${distanceText}
                            </span>
                            <span class="flex items-center">
                                <i class="fas ${highlight.walkingTime < 60 ? 'fa-walking' : 'fa-car'} mr-1"></i>
                                ${timeText}
                            </span>
                        </div>
                    </div>
                `;
            }

            // Make loadComparisonVenues available globally
            window.loadComparisonVenues = loadComparisonVenues;
        });
    </script>

    <script>
        $('#reservationForm').on('submit', function (e) {
            let isLogged = <?php echo isset($USER_ID) ? "true" : "false" ?>;

            if (!isLogged) {
                e.preventDefault();
                showModal("Please login to continue booking.", undefined, "black_ico.png");
            } else {

                const numberOfGuests = $('#numberOFGuest').val(); // Get the value of the input
                const checkInDate = $('#checkin').val(); // Get the value of the input
                const checkOutDate = $('#checkout').val(); // Get the value of the input
                if (numberOfGuests < 1) { // Check if the value is less than 1
                    e.preventDefault(); // Prevent form submission
                    showModal('Please enter a valid number of guests', undefined, "black_ico.png");
                }
                if (!checkInDate || !checkOutDate) { // Check if either date is empty
                    e.preventDefault(); // Prevent form submission        
                    showModal('Please select both check-in and check-out dates.', undefined, "black_ico.png");
                    return;
                }

                // Convert to Date objects for comparison
                const checkIn = new Date(checkInDate);
                const checkOut = new Date(checkOutDate);

                if (checkIn >= checkOut) { // Check if the check-in date is not before the check-out date
                    e.preventDefault(); // Prevent form submission
                    showModal('Check-in date must be before the check-out date.', undefined, "black_ico.png");
                    return;
                }
            }
        });
    </script>

    <!-- Photo Gallery Functionality -->
    <script>
        // Photo Gallery Functionality
        document.addEventListener('DOMContentLoaded', function () {
            const showAllPhotosBtn = document.getElementById('showAllPhotosBtn');
            const photoGalleryModal = document.getElementById('photoGalleryModal');

            // Only attach photo gallery event to the show all photos button
            if (showAllPhotosBtn) {
                showAllPhotosBtn.onclick = function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openGallery(0);
                    return false;
                };
            }
        });
    </script>

    <script src="./js/signinup.trigger.js"></script>
</body>

</html>