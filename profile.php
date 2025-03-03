<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ./index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HubVenue || Profile</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="icon" href="./images/black_ico.png">
    <link rel="stylesheet" href="./output.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>




    <style>
        .slideshow {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .slide {
            display: none;
            width: 100%;
            height: 100%;
        }

        .slide.active {
            display: block;
        }

        .active {
            border-bottom: 2px solid black;
            color: black;
            font-weight: bold;
            transition: all 0.1s;
        }

        #add-venue {
            width: 80vh;
        }

        #add-venue #formGrids {
            gap: .5rem;
        }

        #add-venue #formTitle {
            padding: 1rem;
        }
    </style>
    <style>
        .bookmark-btn {
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .bookmark-btn:active {
            transform: scale(1.5) rotate(360deg);
        }

        .bookmark-btn.bookmarked {
            color: #ef4444;
            /* red-500 */
            filter: drop-shadow(0 0 8px rgba(239, 68, 68, 0.5));
            transform: scale(1.2);
        }

        .bookmark-btn:hover {
            transform: scale(1.2);
        }

        @keyframes heartbeat {
            0% {
                transform: scale(1);
            }

            25% {
                transform: scale(1.3);
            }

            50% {
                transform: scale(1);
            }

            75% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1.2);
            }
        }

        .bookmark-btn.animate {
            animation: heartbeat 0.8s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-50 relative">
    <?php
    require_once './components/profile.nav.php';
    require_once './spinner.php';
    require_once './components/SignupForm.html';
    require_once './components/feedback.modal.html';
    require_once './components/confirm.feedback.modal.html';
    require_once './components/Menu.html';
    require_once './spinner.php';
    ?>

    <div id="profileDisplay">

    </div>

    <div id="userAddVenueForm"
        class="fixed inset-0 bg-black bg-opacity-40 items-center justify-center z-40 p-8 hidden  ">
        <?php require_once './venue-management/add-venue.html' ?>
    </div>

    <script src="./vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="./js/user.jquery.js"></script>
    <script>
        let map;
        let marker;
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slideshows = document.querySelectorAll('.slideshow');
            slideshows.forEach(slideshow => {
                let slides = slideshow.querySelectorAll('.slide');
                let currentIndex = 0;

                function showSlide(index) {
                    slides.forEach((slide, i) => {
                        slide.classList.toggle('active', i === index);
                    });
                }

                function nextSlide() {
                    currentIndex = (currentIndex + 1) % slides.length;
                    showSlide(currentIndex);
                }

                showSlide(currentIndex);
                setInterval(nextSlide, 3000); // Change slide every 3 seconds
            });
        });
    </script>
    <script>
        // Tab switching functionality
        function showCont(tabName) {
            // Hide all tab contents
            var tabContents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.add('hidden');
            }

            // Show selected tab content
            var selectedTab = document.getElementById(tabName + '-content');
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }

            // Update tab button styles
            var tabButtons = document.getElementsByClassName('tab-links');
            for (var i = 0; i < tabButtons.length; i++) {
                tabButtons[i].classList.remove('border-black', 'text-gray-900');
                tabButtons[i].classList.add('border-transparent', 'text-gray-500');
            }

            // Add active styles to clicked tab
            var clickedTab = event.currentTarget;
            clickedTab.classList.remove('border-transparent', 'text-gray-500');
            clickedTab.classList.add('border-black', 'text-gray-900');
        }

        // Set default tab when page loads
        document.addEventListener('DOMContentLoaded', function () {
            var firstTab = document.querySelector('.tab-links');
            if (firstTab) {
                firstTab.click();
            }
        });
    </script>
    <script>
        // Temporary arrays to track changes
        let imagesToDelete = [];
        let newImages = [];
        let isEditVenue = false;
        let thumbnailIndex;


        const spinner = $("#spinner");

        function spinnerOn() {
            spinner.removeClass("hidden");
            spinner.addClass("flex");
        }

        function spinnerOff() {
            spinner.removeClass("flex");
            spinner.addClass("hidden");
        }

        let currentMonth = null;
        let currentYear = null;
        let bookedDatesArr = null;
        let venueView = null;

        let currentStats = null;
        let revenueChart = null;
        let bookingsChart = null;


        let discountsToDelete = []; 
    </script>
</body>