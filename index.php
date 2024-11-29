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
    <title>HubVenue || Home</title>
    <link rel="icon" href="./images/black_ico.png">
    <link rel="stylesheet" href="./output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        .slideshow-container .slide {
            display: none;
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: opacity 0.5s ease-in-out;
        }

        .slideshow-container .slide.active {
            display: block;
            opacity: 1;
            z-index: 1;
        }


        body {
            background: #3490dc;
        }

        .cloud-bottom {
            position: absolute;
            bottom: -2px;
            /* Slightly overlap to avoid thin line */
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .cloud-bottom svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 128px;
            /* Increased height for more pronounced layers */
        }

        .cloud-bottom .shape-fill {
            fill: #3490dc;
        }

        .sidebar {
            background: transparent;
            transition: color 0.3s ease;
        }

        .sidebar button {
            color: white;
            transition: color 0.3s ease;
        }

        .first-section {
            height: 75vh;
            /* 3/4 of the viewport height */
        }
    </style>
    <style>
        /* ... (rest of the styles remain unchanged) */

        #authModal {
            transition: opacity 0.3s ease-in-out;
        }

        #loginForm,
        #signupForm {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
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

<body class="min-h-screen text-gray-900 flex flex-col">



    <!-- Header -->
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


    <div class="flex flex-1 ">
        <!-- Sidebar -->
        <?php include_once './components/sidebar.html' ?>

        <!-- Main content -->
        <main class="flex-1 mt-28">
            <!-- First section with blue background -->
            <div class="bg-blue-500/20 relative">
                <?php require_once './components/coverPage.html' ?>
            </div>

            <!-- New second section -->
            <section class="bg-white -32 py-16">
                <!-- Content container with left margin for sidebar -->
                <div class="ml-20">
                    <div class="container mx-auto px-4 md:px-8">
                        <div class="mt-16 max-w-6xl mx-auto">
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 text-center">
                                Find Your Perfect Venue
                            </h2>
                            <p class="text-gray-600 text-center mb-12 max-w-3xl mx-auto">
                                From intimate gatherings to grand celebrations, discover spaces that match your vision.
                                Browse through our carefully curated selection of venues to find the one that speaks to you.
                            </p>
                        </div>
                    </div>

                    <!-- Second section with white background -->
                    <div class="bg-white p-50 pt-10 relative z-10">
                        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
                            <h2 class="text-3xl font-bold mb-4">Featured Venues</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 w-full h-full" id="venueList">
                                <!-- Venue cards will be dynamically inserted here -->
                                <?php
                                if (empty($venues)) {
                                    echo '<p class="text-left text-gray-500">No venues available</p>';
                                }
                                foreach ($venues as $venue) {
                                    $isBookmarked = in_array($venue['id'], $bookmarkIds);
                                    ?>
                                    <div class="bg-white rounded-2xl overflow-hidden  cursor-pointer">
                                        <div class="relative">
                                            <!-- Slideshow Container for each venue -->
                                            <div class="relative w-full h-96 overflow-hidden">
                                                <!-- Image Slideshow for each venue -->
                                                <div class="slideshow-container venueCard"
                                                    data-id="venues.php?id=<?php echo $venue['venue_id']; ?>"
                                                    data-isloggedin="<?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>">
                                                    <?php if (!empty($venue['image_urls'])): ?>
                                                        <?php foreach ($venue['image_urls'] as $index => $imageUrl): ?>
                                                            <div class="slide <?= $index === 0 ? 'active' : '' ?>">
                                                                <img src="./<?= htmlspecialchars($imageUrl) ?>"
                                                                    alt="<?= htmlspecialchars($venue['name']) ?>"
                                                                    class="w-full h-full object-cover rounded-2xl transition-opacity duration-1000">
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
                                            <?php
                                            if (isset($_SESSION['user'])) { ?>
                                                <button id="bookmarkBtn"
                                                    data-venueId="<?php echo htmlspecialchars($venue['id']); ?>"
                                                    data-userId="<?php echo htmlspecialchars($_SESSION['user']['id']); ?>"
                                                    class="bookmark-btn absolute top-3 right-3 z-50 <?php echo $isBookmarked ? 'bookmarked' : 'text-white'; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            <?php } ?>



                                            <!-- Venue details below the slideshow -->
                                            <div class="p-4 ">
                                                <div class="flex justify-between items-center mb-1">
                                                    <h3 class="text-base font-semibold text-gray-900">
                                                        <?= htmlspecialchars($venue['name']) ?>
                                                    </h3>
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 text-yellow-500 mr-1" viewBox="0 0 20 20"
                                                            fill="currentColor">
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
                        </section>
                        <section class="max-w-7xl mx-auto mt-40 px-4 sm:px-6 lg:px-8 mt-12">
                            <div class="flex flex-col">
                                <div class="text-center mb-8">
                                    <h2 class="text-3xl font-bold mb-2">Our Services</h2>
                                    <p class="text-gray-600 max-w-2xl mx-auto text-sm">Discover how HubVenue can help you find the perfect space or monetize your venue with our comprehensive services.</p>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
                                    <!-- Space Rentals Card -->
                                    <div class="group bg-white p-4 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <div class="relative overflow-hidden rounded-xl mb-4">
                                            <img src="./images/serviceimages/pexels-pixabay-267569.jpg" 
                                                 alt="Rent Space"
                                                 class="w-full h-52 object-cover transform group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                        <div class="space-y-2">
                                            <h3 class="text-xl font-semibold text-gray-800">Space Rentals</h3>
                                            <p class="text-sm text-gray-600">Discover unique spaces for any event, from intimate gatherings to large-scale functions.</p>
                                        </div>
                                    </div>

                                    <!-- Post Your Space Card -->
                                    <div class="group bg-white p-4 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <div class="relative overflow-hidden rounded-xl mb-4">
                                            <img src="./images/serviceimages/pexels-rdne-7414284.jpg" 
                                                 alt="Post Listings"
                                                 class="w-full h-52 object-cover transform group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                        <div class="space-y-2">
                                            <h3 class="text-xl font-semibold text-gray-800">Post Your Space</h3>
                                            <p class="text-sm text-gray-600">Earn money by listing your home or commercial space for event rentals.</p>
                                        </div>
                                    </div>

                                    <!-- Book Event Space Card -->
                                    <div class="group bg-white p-4 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <div class="relative overflow-hidden rounded-xl mb-4">
                                            <img src="./images/serviceimages/pexels-tima-miroshnichenko-6694575.jpg" 
                                                 alt="Book Event"
                                                 class="w-full h-52 object-cover transform group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                        <div class="space-y-2">
                                            <h3 class="text-xl font-semibold text-gray-800">Book an Event Space</h3>
                                            <p class="text-sm text-gray-600">Easily browse and book spaces for weddings, meetings, parties, and more.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Services section -->
                        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 mb-8">
                            <div class="container mx-auto flex flex-col ">
                                <h2 class="text-3xl font-bold mb-4 text-center">About Us</h2>

                                <div class="flex flex-col gap-4">

                                    <div
                                        class="flex flex-col items-center bg-white border p-4 lg:p-4 lg:py-8 rounded-lg shadow-md gap-2">
                                        <h3 class="text-xl font-semibold  text-red-500 italic">Our Story</h3>
                                        <p>
                                            Hubvenue was born out of the need to streamline the often complex and
                                            time-consuming
                                            process of
                                            event
                                            planning. The journey began when our founders, faced with the daunting task of
                                            organizing
                                            multiple
                                            events, realized how fragmented the venue and catering service industry was.
                                            From
                                            endless phone
                                            calls to
                                            lengthy negotiations, the process was anything but easy. Inspired by the vision
                                            of a
                                            one-stop
                                            platform,
                                            Hubvenue was developed to centralize and simplify these interactions, allowing
                                            users
                                            to focus on
                                            creating memorable experiences instead of logistics.
                                        </p>
                                        <p>Throughout our journey, we faced challenges, such as integrating diverse services
                                            and
                                            building
                                            trust
                                            within the community. However, these obstacles only strengthened our commitment
                                            to
                                            innovation.
                                            Hubvenue
                                            continues to grow, expanding our network of partners and refining our platform
                                            based
                                            on user
                                            feedback,
                                            making it the ultimate event planning tool for everyone.</p>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <!-- mission -->
                                        <div
                                            class="flex flex-col items-center bg-white border p-4 lg:p-4 lg:py-8 rounded-lg shadow-md gap-2">
                                            <h3 class="text-xl font-semibold  text-red-500 italic">Our Mission</h3>
                                            <p class="text-center">
                                                To simplify finding and booking available venues, offering users an easy and
                                                efficient platform
                                                that connects them with ideal spaces for their events, ensuring seamless
                                                experience from
                                                discovery ro registration.
                                            </p>
                                        </div>
                                        <!-- vission -->
                                        <div
                                            class="flex flex-col items-center bg-white border p-4 lg:p-4 lg:py-8 rounded-lg shadow-md gap-2">
                                            <h3 class="text-xl font-semibold  text-red-500 italic">Our Vision</h3>
                                            <p class="text-center">
                                                To be the go to platform for venue reservations, helping people connect with
                                                the
                                                perfect spaces
                                                for any event.
                                            </p>
                                        </div>
                                    </div>

                                    <!-- FAQ -->
                                    <div
                                        class="flex flex-col bg-white border text-neutral-700 p-4 lg:p-4 lg:py-8 rounded-lg shadow-md">
                                        <h3 class="text-xl font-semibold text-red-500 italic text-center">FAQs</h3>
                                        <div class="w-full ">
                                            <div class="faq-item mb-4">
                                                <button class="faq-header w-full text-left">
                                                    1. How do I book a space?
                                                </button>
                                                <div class="faq-content hidden">
                                                    <p class="text-xs">To book a space, simply look for your desired
                                                        location
                                                        and
                                                        date on our platform. Browse
                                                        through the available options, select the space that suits your
                                                        needs,
                                                        and follow
                                                        the
                                                        booking process to confirm your reservation.</p>
                                                </div>
                                            </div>
                                            <div class="faq-item mb-4">
                                                <button class="faq-header  w-full text-left">
                                                    2. Can I list my own space on HubVenue?
                                                </button>
                                                <div class="faq-content hidden">
                                                    <p class="text-sm ">Yes, you can list your space on HubVenue. Create an
                                                        account,
                                                        provide details about your
                                                        space, upload photos, and set your availability and pricing. Once
                                                        your
                                                        listing is
                                                        approved, it will be visible to potential renters.</p>
                                                </div>
                                            </div>
                                            <div class="faq-item mb-4">
                                                <button class="faq-header  w-full text-left">
                                                    3. What types of spaces can I list?
                                                </button>
                                                <div class="faq-content hidden">
                                                    <p class="text-sm ">You can list a variety of spaces including
                                                        residential
                                                        homes,
                                                        commercial venues, event
                                                        halls, and more. The platform is designed to accommodate all types
                                                        of
                                                        spaces that
                                                        can be
                                                        used for events and gatherings.</p>
                                                </div>
                                            </div>
                                            <div class="faq-item mb-4">
                                                <button class="faq-header  w-full text-left">
                                                    4. Are there any fees associated with booking or listing a space?
                                                </button>
                                                <div class="faq-content hidden">
                                                    <p class="text-sm ">Yes, there may be fees associated with both booking
                                                        and
                                                        listing
                                                        spaces. Booking fees are
                                                        typically a percentage of the total rental cost, while listing fees
                                                        may
                                                        vary based
                                                        on
                                                        the type of space and duration of the listing. Detailed information
                                                        about fees will
                                                        be
                                                        provided during the booking or listing process.</p>
                                                </div>
                                            </div>
                                            <div class="faq-item mb-4">
                                                <button class="faq-header  w-full text-left">
                                                    5. How can I contact customer support?
                                                </button>
                                                <div class="faq-content hidden">
                                                    <p class="text-sm ">If you need assistance, you can contact our customer
                                                        support
                                                        team via the contact form on
                                                        our website, or by email at info@hubvenue.com. Our team is available
                                                        to
                                                        help you
                                                        with
                                                        any questions or issues you may have.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </section>
                    </div>
                </div>
            </section>
            <div id="openstreetmapplaceholder"></div>
            <?php require_once './components/footer.html' ?>
        </main>
    </div>

    <!-- jQuery -->
    <script src="./vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="./js/user.jquery.js"></script>
    <script>
        let map;
        let marker;
    </script>
    <!-- venue slideshow -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const venueSlideshows = document.querySelectorAll('.slideshow-container');

            venueSlideshows.forEach((slideshow) => {
                let currentSlide = 0;
                const slides = slideshow.querySelectorAll('.slide');

                function showSlide(index) {
                    // First set display:block on next slide before starting transition
                    slides[index].style.display = 'block';

                    // Small delay to ensure display:block is processed
                    setTimeout(() => {
                        // Hide all slides
                        slides.forEach((slide) => {
                            slide.classList.remove('active');
                            slide.style.opacity = '0';
                        });

                        // Show and fade in the current slide
                        slides[index].classList.add('active');
                        slides[index].style.opacity = '1';

                        // Clean up non-active slides after transition
                        setTimeout(() => {
                            slides.forEach((slide, i) => {
                                if (i !== index) {
                                    slide.style.display = 'none';
                                }
                            });
                        }, 500); // Match this to transition duration
                    }, 10);
                }

                // Show next slide every 4 seconds
                setInterval(() => {
                    currentSlide = (currentSlide + 1) % slides.length;
                    showSlide(currentSlide);
                }, 4000);

                // Initialize the first slide
                showSlide(currentSlide);
            });
        });

    </script>

    <script>
        // Date picker functionality
        const checkInBtn = document.getElementById('checkInBtn');
        const checkOutBtn = document.getElementById('checkOutBtn');
        const checkInText = document.getElementById('checkInText');
        const checkOutText = document.getElementById('checkOutText');

        checkInBtn.addEventListener('click', () => {
            const date = luxon.DateTime.local().plus({ days: 1 }).toFormat('LLL dd, yyyy');
            checkInText.textContent = date;
        });

        checkOutBtn.addEventListener('click', () => {
            const date = luxon.DateTime.local().plus({ days: 6 }).toFormat('LLL dd, yyyy');
            checkOutText.textContent = date;
        });
    </script>

    <!-- login and signup form functionality || styling css  -->
    <script>
        // Get modal elements
        const authModal = document.getElementById('authModal');
        const closeModal = document.getElementById('closeModal');
        const loginTab = document.getElementById('loginTab');
        const signupTab = document.getElementById('signupTab');
        const loginForm = document.getElementById('loginForm');
        const signupForm = document.getElementById('signupForm');
        const tabUnderline = document.getElementById('tabUnderline');

        // Get all buttons that should open the modal
        const signInButtons = document.querySelectorAll('button[onclick="openModal()"]');

        // Function to open modal with smooth transition
        function openModal() {
            authModal.style.display = 'flex';
            authModal.style.opacity = '0';
            setTimeout(() => {
                authModal.style.opacity = '1';
            }, 10);
        }

        // Function to close modal with smooth transition
        function closeModalFunc() {
            authModal.style.opacity = '0';
            setTimeout(() => {
                authModal.style.display = 'none';
            }, 300);
        }

        // Add click event listeners to all sign in buttons
        signInButtons.forEach(button => {
            button.addEventListener('click', openModal);
        });

        // Close modal when clicking close button
        closeModal.addEventListener('click', closeModalFunc);

        // Tab switching functionality
        loginTab.addEventListener('click', () => {
            switchTab(loginTab, signupTab, loginForm, signupForm);
        });

        signupTab.addEventListener('click', () => {
            switchTab(signupTab, loginTab, signupForm, loginForm);
        });

        function switchTab(activeTab, inactiveTab, activeForm, inactiveForm) {
            activeTab.classList.add('text-blue-500');
            activeTab.classList.remove('text-gray-500');
            inactiveTab.classList.remove('text-blue-500');
            inactiveTab.classList.add('text-gray-500');

            // Move the tab underline
            if (activeTab === loginTab) {
                tabUnderline.style.left = '0';
            } else {
                tabUnderline.style.left = '50%';
            }

            // Fade out the current form
            activeForm.classList.add('opacity-0');
            inactiveForm.classList.add('opacity-0');

            setTimeout(() => {
                activeForm.classList.add('hidden');
                inactiveForm.classList.add('hidden');

                // Show and fade in the new form
                activeForm.classList.remove('hidden');
                setTimeout(() => {
                    activeForm.classList.remove('opacity-0');
                }, 50);
            }, 300);
        }

        // Ensure the DOM is fully loaded before attaching event listeners
        document.addEventListener('DOMContentLoaded', (event) => {
            // Reattach event listeners to make sure they work
            closeModal.addEventListener('click', closeModalFunc);
            loginTab.addEventListener('click', () => switchTab(loginTab, signupTab, loginForm, signupForm));
            signupTab.addEventListener('click', () => switchTab(signupTab, loginTab, signupForm, loginForm));
        });
    </script>

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