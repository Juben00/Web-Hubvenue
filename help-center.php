<?php

require_once './sanitize.php';
require_once './classes/venue.class.php';
require_once './classes/account.class.php';

session_start();

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['user_type_id'] == 3) {
        header('Location: admin/');
    }

}

$venueObj = new Venue();
$accountObj = new Account();

// Get all venues
$venues = $venueObj->getAllVenues('2');
$bookmarks = $accountObj->getBookmarks(isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0);
$bookmarkIds = array_column($bookmarks, 'venue_id');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center | HubVenue</title>
    <link rel="icon" href="./images/black_ico.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./output.css">
    <!-- Add Tailwind CSS -->
    <style>
        .search-container {
            position: relative;
            max-width: 600px;
            margin: 2rem auto;
        }

        .search-container input {
            width: 100%;
            padding: 1rem;
            padding-right: 3rem;
            border-radius: 9999px;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .search-container button {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background-color: #ec4899;
            color: white;
            padding: 0.5rem;
            border-radius: 9999px;
        }

        .tab-underline {
            height: 2px;
            background-color: currentColor;
            transition: all 0.3s ease;
        }
    </style>
</head>
<?php
    // Check if the 'user' key exists in the session
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
<body class="bg-white min-h-screen">
    <!-- Header with logo -->
    <header class="border-b">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <img src="./images/black_ico.png" alt="HubVenue Logo" class="h-8">
                <h1 class="text-xl font-semibold">Help Center</h1>
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 rounded-full hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                </button>
                <button class="p-2 rounded-full hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <section class="text-center mb-8">
            <h2 class="text-4xl font-semibold mb-8">
                Hi <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Guest'; ?>, how can we help?
            </h2>
            <div class="search-container">
                <input type="text" placeholder="Search how-tos and more" class="focus:outline-none focus:ring-2 focus:ring-pink-500">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </section>

        <!-- Tabs -->
        <nav class="border-b mb-8">
            <div class="flex gap-8">
                <button class="py-4 text-black relative">
                    Guest
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-black"></div>
                </button>
                <button class="py-4 text-gray-500">Host</button>
                <button class="py-4 text-gray-500">Experience Host</button>
                <button class="py-4 text-gray-500">Travel admin</button>
            </div>
        </nav>

        <!-- Recommended Section -->
        <section class="mb-8">
            <h3 class="text-2xl font-semibold mb-6">Recommended for you</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Action Required Card -->
                <div class="border rounded-xl p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-red-500 font-semibold">ACTION REQUIRED</span>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Your identity is not fully verified</h4>
                    <p class="text-gray-600 mb-4">Identity verification helps us check that you're really you. It's one of the ways we keep HubVenue secure.</p>
                    <div class="space-y-2">
                        <a href="#" class="block text-black hover:underline">Check identity verification status</a>
                        <a href="#" class="block text-black hover:underline">Learn more</a>
                    </div>
                </div>

                <!-- Quick Link Card -->
                <div class="border rounded-xl p-6">
                    <div class="mb-4">
                        <span class="text-gray-600">QUICK LINK</span>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Finding reservation details</h4>
                    <p class="text-gray-600 mb-4">Your Trips tab has full details, receipts, and Host contact info for each of your reservations.</p>
                    <a href="#" class="block text-black hover:underline">Go to Trips</a>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Add any necessary JavaScript here
    </script>
</body>

</html>
