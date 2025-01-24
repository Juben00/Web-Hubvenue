<?php
session_start();
require_once __DIR__ . '/classes/venue.class.php';
require_once __DIR__ . '/classes/account.class.php';

$venueObj = new Venue();
$accountObj = new Account();

$owner = $accountObj->getOwner($_GET['id']);
$venues = $venueObj->getAllVenues(2, $_GET['id']);
$userID = $_SESSION['user']['id'] ?? null;
$profilePic = $owner['profile_pic'] ?? null;

$rating = $venueObj->getHostRatings($userID);

$reviews = $venueObj->getHostReviews($userID);

if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
} else if (!$owner) {
    header("Location: index.php");
    exit();
} else if (!$userID) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Profile - HubVenue</title>
    <link rel="stylesheet" href="./output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="icon" href="./images/black_ico.png">
</head>

<body class="bg-slate-50">
    <?php
    // Include navbar based on login status
    if (isset($_SESSION['user'])) {
        include_once './components/navbar.logged.in.php';
    } else {
        include_once './components/navbar.html';
    }


    include_once './components/SignupForm.html';
    include_once './components/feedback.modal.html';
    include_once './components/confirm.feedback.modal.html';
    include_once './components/Menu.html';

    ?>

    <div class="container mx-auto px-4 py-8 pt-24">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Host Profile Card -->
            <div class="">
                <div class="bg-slate-50 rounded-xl border shadow-lg p-6 md:col-span-1 mt-12">
                    <div class="flex flex-col items-center mt-16 space-y-4 mb-4">
                        <div class="relative">
                            <div
                                class="h-24 w-24 text-4xl font-semibold rounded-full bg-black text-white flex items-center justify-center">
                                <?php
                                if (isset($owner) && empty($profilePic)) {
                                    echo $owner['firstname'][0];
                                } else {
                                    echo '<img id="profileImage" name="profile_image" src="./' . htmlspecialchars($profilePic) . '" alt="Profile Picture" class="w-full h-full rounded-full object-cover">';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="text-center">
                            <h2 class="text-xl font-bold">
                                <?php echo htmlspecialchars($owner['firstname'] . ' ' . $owner['lastname']) ?>
                            </h2>
                            <p class="text-gray-500 text-sm">Host since
                                <?php echo htmlspecialchars(date('F Y', strtotime($owner['host_application_date']))) ?>
                            </p>
                        </div>
                    </div>
                    <!-- <p class="text-sm text-gray-600 mb-4">
                                        <?php echo htmlspecialchars($owner['email']) ?>
                                    </p> -->
                    <div class="flex items-center space-x-2 mb-2">
                        <i class="fas fa-star text-yellow-400"></i>
                        <span class="font-semibold"><?php echo number_format($rating['average'], 1) ?></span>

                        <span class="text-sm text-gray-500"><?php echo htmlspecialchars($rating['total']) ?>
                            Reviews</span>
                    </div>
                    <div class="flex items-center space-x-2 mb-2">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                        <span class="text-sm text-gray-500">Zamboanga City, Zamboanga del Sur</span>
                    </div>
                    <button
                        class="w-full mt-12 bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition duration-300 flex items-center justify-center">
                        <i class="fas fa-comment-alt mr-2"></i>
                        Contact <?php echo htmlspecialchars($owner['firstname'] . ' ' . $owner['lastname']) ?>
                    </button>

                    <!-- Add the Share Profile dropdown -->
                    <div class="relative mt-4">
                        <button id="shareDropdownButton"
                            class="w-full bg-slate-50 text-black border border-gray-300 py-2 px-4 rounded-lg hover:bg-gray-50 transition duration-300 flex items-center justify-center">
                            <i class="fas fa-share-alt mr-2"></i>
                            Share Profile
                        </button>
                        <div id="shareDropdown"
                            class="hidden absolute left-0 right-0 mt-2 bg-slate-50 border border-gray-200 rounded-lg shadow-lg z-50">
                            <a href="#" onclick="shareOnFacebook()"
                                class="flex items-center px-4 py-2 hover:bg-gray-100 transition duration-300">
                                <i class="fab fa-facebook text-blue-600 mr-2"></i>
                                Facebook
                            </a>
                            <a href="#" onclick="shareOnTwitter()"
                                class="flex items-center px-4 py-2 hover:bg-gray-100 transition duration-300">
                                <i class="fab fa-twitter text-blue-400 mr-2"></i>
                                Twitter
                            </a>
                            <a href="#" onclick="shareOnLinkedIn()"
                                class="flex items-center px-4 py-2 hover:bg-gray-100 transition duration-300">
                                <i class="fab fa-linkedin text-blue-700 mr-2"></i>
                                LinkedIn
                            </a>
                            <a href="#" onclick="shareOnWhatsApp()"
                                class="flex items-center px-4 py-2 hover:bg-gray-100 transition duration-300">
                                <i class="fab fa-whatsapp text-green-500 mr-2"></i>
                                WhatsApp
                            </a>
                            <button onclick="copyProfileLink()"
                                class="w-full flex items-center px-4 py-2 hover:bg-gray-100 transition duration-300">
                                <i class="fas fa-link text-gray-600 mr-2"></i>
                                Copy Link
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Venue Listings -->
            <div class="md:col-span-3 ml-12 ">
                <h2 class="text-2xl mt-12 font-bold mb-6"><?php echo htmlspecialchars($owner['firstname'] . "'s") ?>
                    Venues</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Venue Cards -->
                    <?php
                    foreach ($venues as $venue) {
                        ?>
                        <a href="venues.php?id=<?php echo htmlspecialchars($venue['id']); ?>"
                            class="bg-transparent shadow-md rounded-xl overflow-hidden transition duration-300">
                            <img src="./<?= htmlspecialchars($venue['image_urls'][$venue['thumbnail']]) ?>"
                                alt="<?php echo htmlspecialchars($venue['name']) ?>" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($venue['name']) ?></h3>
                                <p class="text-gray-600 mb-4 truncate"><?php echo htmlspecialchars($venue['description']) ?>
                                </p>
                                <div class="mb-2">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                        <span
                                            class="text-sm text-gray-500 truncate"><?php echo htmlspecialchars($venue['address']) ?></span>
                                    </div>

                                </div>
                                <div class="mb-2">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-users text-gray-400"></i>
                                        <span class="text-sm text-gray-500">Up to
                                            <?php echo htmlspecialchars($venue['capacity']) ?> guests</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span
                                        class="bg-blue-50 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">₱<?php echo htmlspecialchars($venue['price']) ?>/Day</span>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span class="font-semibold">
                                            <p class="font-bold text-xs">
                                                <?php echo number_format($venue['rating'], 1) ?? "0" ?>
                                            </p>
                                        </span>
                                        <span
                                            class="text-sm text-gray-500">(<?php echo htmlspecialchars($venue['total_reviews']) ?>)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php
                    }
                    ?>


                    <!-- Additional venue cards follow the same pattern... -->
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Reviews</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Review Cards -->

                <?php if (!empty($reviews) && is_array($reviews)): ?>
                    <?php foreach ($reviews as $index => $review): ?>
                        <div class="shadow-lg p-6 rounded-lg space-y-6">
                            <div class="border-b pb-6 review" data-index="<?php echo $index; ?>">
                                <div class="flex items-center gap-4 mb-4">
                                    <?php
                                    // Check if profile picture exists, otherwise display a placeholder with the user's initial
                                    if (empty($review['profile_pic'])) {
                                        echo '<div class="w-12 h-12 bg-black text-white rounded-full flex items-center justify-center font-bold">';
                                        echo htmlspecialchars($review['user_name'][0] ?? 'U'); // Display the first letter of the user's name or 'U' if name is missing
                                        echo '</div>';
                                    } else {
                                        echo '<img class="w-12 h-12 bg-gray-200 rounded-full" src="' . htmlspecialchars($review['profile_pic']) . '" alt="Profile Picture">';
                                    }
                                    ?>

                                    <div>
                                        <a href="user-page.php"
                                            class="font-semibold hover:underline"><?php echo htmlspecialchars($review['user_name'] ?? 'Unknown User'); ?></a>
                                        <p class="text-sm text-gray-500">
                                            <?php
                                            // Format the date if it exists, otherwise display a default message
                                            if (!empty($review['date'])) {
                                                $originalDate = $review['date'];
                                                $formattedDate = date('F j, Y \a\t g:i A', strtotime($originalDate)); // Format the date
                                                echo htmlspecialchars($formattedDate);
                                            } else {
                                                echo 'Date not available';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex text-yellow-400 mb-2">
                                    <?php
                                    // Display stars based on the rating, default to 0 if rating is missing or invalid
                                    $rating = isset($review['rating']) && is_numeric($review['rating']) ? (int) $review['rating'] : 0;
                                    for ($i = 0; $i < $rating; $i++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-gray-700">
                                    <?php echo htmlspecialchars($review['review'] ?? 'No review provided.'); ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">No reviews available.</p>
                <?php endif; ?>

                <!-- Additional review cards... -->
            </div>
            <form id="hostReviewForm">
                <h2 class="text-2xl font-bold mb-4">Give a Review</h2>
                <div class="border shadow-md p-6 bg-neutral-100">
                    <div class="flex items-center mb-3 gap-4">
                        <div class="flex items-center space-x-1">
                            <input type="number" class="hidden" name="user_id"
                                value="<?php echo htmlspecialchars($userID) ?>">
                            <input type="number" class="hidden" name="host_id"
                                value="<?php echo htmlspecialchars($owner['id']) ?>">

                            <label onclick="rate(1)" for="one" class="text-5xl text-gray-300 hover:text-yellow-400 star"
                                data-rating="1">
                                <input type="radio" name="ratings" value="1" class="hidden" id="one">★</label>
                            <label onclick="rate(2)" for="two" class="text-5xl text-gray-300 hover:text-yellow-400 star"
                                data-rating="2">
                                <input type="radio" name="ratings" value="2" class="hidden" id="two">★</label>
                            <label onclick="rate(3)" for="three"
                                class="text-5xl text-gray-300 hover:text-yellow-400 star" data-rating="3">
                                <input type="radio" name="ratings" value="3" class="hidden" id="three">★</label>
                            <label onclick="rate(4)" for="four"
                                class="text-5xl text-gray-300 hover:text-yellow-400 star" data-rating="4">
                                <input type="radio" name="ratings" value="4" class="hidden" id="four">★</label>
                            <label onclick="rate(5)" for="five"
                                class="text-5xl text-gray-300 hover:text-yellow-400 star" data-rating="5">
                                <input type="radio" name="ratings" value="5" class="hidden" id="five">★</label>
                        </div>
                        <h1 class="text-2xl font-semibold" id="rateFeedback"></h1>
                    </div>
                    <div class="mb-4">
                        <textarea id="review-text" name="review-text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                            rows="3" placeholder="Share your experience (optional)"></textarea>
                    </div>
                    <div class="flex space-x-4">
                        <button type="submit" class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
                            Submit Review
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="./vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="./js/user.jquery.js"></script>
    <script>
        // Your existing JavaScript with improved event handling...

        // Toggle dropdown
        document.getElementById('shareDropdownButton').addEventListener('click', function () {
            document.getElementById('shareDropdown').classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('shareDropdown');
            const button = document.getElementById('shareDropdownButton');
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Share functions
        function shareOnFacebook() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
        }

        function shareOnTwitter() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent("Check out this Host's profile on HubVenue!");
            window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
        }

        function shareOnLinkedIn() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
        }

        function shareOnWhatsApp() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent("Check out this Host's profile on HubVenue!");
            window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
        }

        function copyProfileLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Profile link copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy link: ', err);
            });
        }

        function rate(rating) {
            currentRating = rating;
            const stars = document.querySelectorAll('.star');
            const rateFeedback = document.getElementById('rateFeedback');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
            switch (rating) {
                case 1:
                    rateFeedback.innerText = 'Terrible Experience!';
                    break;
                case 2:
                    rateFeedback.innerText = 'Below Expectations!';
                    break;
                case 3:
                    rateFeedback.innerText = 'Average Experience!';
                    break;
                case 4:
                    rateFeedback.innerText = 'Very Good!';
                    break;
                case 5:
                    rateFeedback.innerText = 'Exceptional!';
                    break;
            }
        }
    </script>
</body>

</html>