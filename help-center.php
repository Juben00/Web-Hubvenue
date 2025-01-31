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
            background-color: #ef4444;
            color: white;
            padding: 0.5rem;
            border-radius: 9999px;
        }

        .faq-content {
            transition: all 0.3s ease-in-out;
        }

        .navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen">
    <div class="navbar-fixed">
        <?php
        if (isset($_SESSION['user'])) {
            include_once './components/navbar.logged.in.php';
        } else {
            include_once './components/navbar.html';
        }
        ?>
    </div>

    <?php
    include_once './components/SignupForm.html';
    include_once './components/feedback.modal.html';
    include_once './components/confirm.feedback.modal.html';
    include_once './components/Menu.html';
    ?>

    <!-- Main Content -->
    <main class="container mx-auto">
        <?php require_once './spinner.php'; ?>
        <!-- Welcome Section -->
        <section class="text-center mb-8 mt-28">
            <h2 class="text-4xl font-semibold mb-8">
                Hi
                <?php echo isset($_SESSION['user']['firstname']) ? htmlspecialchars($_SESSION['user']['firstname']) : 'Guest'; ?>,
                how can we help?
            </h2>
            <div class="search-container">
                <input type="text" placeholder="Search how-tos and more"
                    class="focus:outline-none focus:ring-2 focus:ring-red-500">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="max-w-3xl mx-auto mb-8">
            <div class="bg-slate-50 border text-neutral-700 p-4 lg:p-8 rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold text-red-500 italic text-center mb-6">Frequently Asked Questions</h3>
                <div class="w-full space-y-4">
                    <div class="faq-item">
                        <button
                            class="faq-header w-full text-left p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                            1. How do I book a space?
                        </button>
                        <div class="faq-content hidden p-4">
                            <p class="text-sm">To book a space, simply look for your desired location and date on our
                                platform. Browse through the available options, select the space that suits your needs,
                                and follow the booking process to confirm your reservation.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button
                            class="faq-header w-full text-left p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                            2. Can I list my own space on HubVenue?
                        </button>
                        <div class="faq-content hidden p-4">
                            <p class="text-sm">Yes, you can list your space on HubVenue. Create an account, provide
                                details about your space, upload photos, and set your availability and pricing. Once
                                your listing is approved, it will be visible to potential renters.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button
                            class="faq-header w-full text-left p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                            3. What types of spaces can I list?
                        </button>
                        <div class="faq-content hidden p-4">
                            <p class="text-sm">You can list a variety of spaces including residential homes, commercial
                                venues, event halls, and more. The platform is designed to accommodate all types of
                                spaces that can be used for events and gatherings.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button
                            class="faq-header w-full text-left p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                            4. Are there any fees associated with booking or listing a space?
                        </button>
                        <div class="faq-content hidden p-4">
                            <p class="text-sm">Yes, there may be fees associated with both booking and listing spaces.
                                Booking fees are typically a percentage of the total rental cost, while listing fees may
                                vary based on the type of space and duration of the listing. Detailed information about
                                fees will be provided during the booking or listing process.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button
                            class="faq-header w-full text-left p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                            5. How can I contact customer support?
                        </button>
                        <div class="faq-content hidden p-4">
                            <p class="text-sm">If you need assistance, you can contact our customer support team via the
                                contact form on our website, or by email at info@hubvenue.com. Our team is available to
                                help you with any questions or issues you may have.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Us Card -->
        <section class="max-w-3xl mb-16 mx-auto">
            <div class="bg-slate-50 border rounded-lg shadow-md p-6">
                <h3 class="text-2xl font-semibold text-red-500 italic text-center mb-6">Contact Us</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold">Email Us</h4>
                            <p class="text-sm text-gray-600">rezierjohn@hubvenue.com</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold">Call Us</h4>
                            <p class="text-sm text-gray-600">+63 917 123 4567</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold">Visit Us</h4>
                            <p class="text-sm text-gray-600">Zamboanga City, Philippines</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const faqHeaders = document.querySelectorAll(".faq-header");

            faqHeaders.forEach((header) => {
                header.addEventListener("click", function () {
                    const faqContent = this.nextElementSibling;

                    if (faqContent.classList.contains("hidden")) {
                        faqContent.classList.remove("hidden");
                    } else {
                        faqContent.classList.add("hidden");
                    }
                });
            });
        });
    </script>
</body>

</html>