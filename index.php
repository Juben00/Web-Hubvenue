<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VenueSpot</title>
=======

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HubVenue</title>
    <link rel="icon" href="./images/black_ico.png">
    <link rel="stylesheet" href="./output.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
>>>>>>> 4203bd179757a1732842751e0d17f76fe1427cec
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #3490dc, #2779bd);
        }
<<<<<<< HEAD
        .cloud-bottom {
            position: absolute;
            bottom: -2px; /* Slightly overlap to avoid thin line */
=======

        .cloud-bottom {
            position: absolute;
            bottom: -2px;
            /* Slightly overlap to avoid thin line */
>>>>>>> 4203bd179757a1732842751e0d17f76fe1427cec
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
<<<<<<< HEAD
=======

>>>>>>> 4203bd179757a1732842751e0d17f76fe1427cec
        .cloud-bottom svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
<<<<<<< HEAD
            height: 128px; /* Increased height for more pronounced layers */
        }
        .cloud-bottom .shape-fill {
            fill: #FFFFFF;
        }
=======
            height: 128px;
            /* Increased height for more pronounced layers */
        }

        .cloud-bottom .shape-fill {
            fill: #FFFFFF;
        }

>>>>>>> 4203bd179757a1732842751e0d17f76fe1427cec
        .sidebar {
            background: transparent;
            transition: color 0.3s ease;
        }
<<<<<<< HEAD
=======

>>>>>>> 4203bd179757a1732842751e0d17f76fe1427cec
        .sidebar button {
            color: white;
            transition: color 0.3s ease;
        }
<<<<<<< HEAD
        .first-section {
            height: 75vh; /* 3/4 of the viewport height */
        }
    </style>
</head>
<body class="min-h-screen text-gray-900 flex flex-col">
      <!-- Header -->
      <?php include 'pages/navbar.html'; ?>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed left-0 top-1/2 transform -translate-y-1/2 w-20 flex flex-col items-center py-8 space-y-8 z-20">
            <button class=" flex flex-col items-center focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs mt-1">Home</span>
            </button>
            <button class="flex flex-col items-center text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span class="text-xs mt-1">Weddings</span>
            </button>
            <button class="flex flex-col items-center text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                </svg>
                <span class="text-xs mt-1">Parties</span>
            </button>
            <button class="flex flex-col items-center text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <span class="text-xs mt-1">Outdoor</span>
            </button>
            <button class="flex flex-col items-center text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                <span class="text-xs mt-1">Outings</span>
            </button>
            <button class="flex flex-col items-center text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
                <span class="text-xs mt-1">Unique</span>
            </button>
        </aside>

        <!-- Main content -->
        <main class="flex-1">
            <!-- First section -->
            <section class="first-section relative">
                <div class="ml-20 p-8"> <!-- Added ml-20 to account for sidebar width -->
                    <div class="bg-white border border-gray-300 rounded-full shadow-lg p-2 mb-8 flex items-center max-w-5xl mx-auto">
                        <div class="flex-1 min-w-0 px-4">
                            <label for="where" class="block text-sm font-medium text-gray-700">Where</label>
                            <input type="text" id="where" placeholder="Search destinations" class="w-full border-0 focus:ring-0 focus:outline-none text-lg bg-transparent">
                        </div>
                        <div class="w-px h-10 bg-gray-300 mx-2"></div>
                        <div class="flex-1 min-w-0 px-4">
                            <button id="checkInBtn" class="w-full text-left font-normal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span id="checkInText">Check in</span>
                            </button>
                        </div>
                        <div class="w-px h-10 bg-gray-300 mx-2"></div>
                        <div class="flex-1 min-w-0 px-4">
                            <button id="checkOutBtn" class="w-full text-left font-normal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span id="checkOutText">Check out</span>
                            </button>
                        </div>
                        <div class="w-px h-10 bg-gray-300 mx-2"></div>
                        <div class="flex-1 min-w-0 px-4">
                            <label for="guests" class="block text-sm font-medium text-gray-700">Who</label>
                            <input type="text" id="guests" placeholder="Add guests" class="w-full border-0 focus:ring-0 focus:outline-none text-lg bg-transparent">
                        </div>
                        <button class="rounded-full bg-red-500 hover:bg-red-600 text-white p-2 mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Updated sign-in section -->
                    <div class="text-white rounded-3xl p-8 mb-8 max-w-5xl mx-auto relative">
                        <div class="flex items-center justify-between relative z-10">
                            <div>
                                <h2 class="text-5xl font-bold mb-2">Sign in, save money</h2>
                                <p class="text-xl mb-4">Save 10% on select properties with VenueSpot Rewards</p>
                                <button class="bg-white text-blue-500 font-semibold py-3 px-8 rounded-full hover:bg-blue-100 transition duration-300 text-lg">
                                    Sign in or register
                                </button>
                            </div>
                            <div class="hidden lg:block">
                                <!-- Replace this with your actual mascot image -->
                                <img src="https://placekitten.com/200/200" alt="VenueSpot Mascot" class="w-48 h-48 object-cover">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cloud-bottom absolute left-0 w-full overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" class="w-full h-32">
                        <path fill="#ffffff" fill-opacity="0.2" d="M0,128L48,144C96,160,192,192,288,197.3C384,203,480,181,576,165.3C672,149,768,139,864,149.3C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                        <path fill="#ffffff" fill-opacity="0.4" d="M0,192L48,181.3C96,171,192,149,288,149.3C384,149,480,171,576,181.3C672,192,768,192,864,181.3C960,171,1056,149,1152,144C1248,139,1344,149,1392,154.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                        <path fill="#ffffff" fill-opacity="0.6" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,213.3C672,224,768,224,864,213.3C960,203,1056,181,1152,170.7C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                        <path fill="#ffffff" fill-opacity="1" d="M0,256L48,245.3C96,235,192,213,288,213.3C384,213,480,235,576,245.3C672,256,768,256,864,245.3C960,235,1056,213,1152,202.7C1248,192,1344,192,1392,192L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                    </svg>
                </div>
            </section>

            <!-- Second section with venue cards -->
            <section class="bg-white py-16 relative z-10">
                <div class="ml-20 max-w-7xl mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-8">Featured Venues</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 w-full h-full" id="venueList">
                        <!-- Venue cards will be dynamically inserted here -->
                    </div>
                </div>
            </section>
=======

        .first-section {
            height: 75vh;
            /* 3/4 of the viewport height */
        }
    </style>
</head>

<body class="min-h-screen text-gray-900 flex flex-col">



    <!-- Header -->
    <?php

    include_once './components/navbar.html';
    include_once './components/SignupForm.html';

    ?>

    <div class="flex flex-1 ">
        <!-- Sidebar -->
        <?php include_once './components/sidebar.html' ?>

        <!-- Main content -->
        <main class="flex-1 mt-28">
            <!-- First section -->
            <?php require_once './components/coverPage.html' ?>

            <!-- Second section with venue cards -->
            <div class="bg-slate-100 pt-10 relative z-10 ">
                <section class="ml-20 max-w-7xl mx-auto px-4  mb-8">
                    <div class="flex flex-col ">
                        <h2 class="text-3xl font-bold mb-4">Our Services</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                            <div class="flex flex-col gap-3 items-start bg-slate-50 p-4 border rounded-lg shadow-md ">
                                <img src="./images/serviceimages/pexels-pixabay-267569.jpg" alt="Rent Space"
                                    class="w-full h-56">
                                <h3 class="text-xl font-semibold mt-2">Space Rentals</h3>
                                <p class="text-gray-500">Discover unique spaces for any event, from intimate
                                    gatherings to
                                    large-scale
                                    functions.</p>
                            </div>
                            <div class="flex flex-col gap-3 items-start bg-slate-50 p-4 border rounded-lg shadow-md ">
                                <img src="./images/serviceimages/pexels-rdne-7414284.jpg" alt="Post Listings"
                                    class="w-full h-56">
                                <h3 class="text-xl font-semibold mt-2">Post Your Space</h3>
                                <p class="text-gray-500">Earn money by listing your home or commercial space for event
                                    rentals.
                                </p>
                            </div>
                            <div class="flex flex-col gap-3 items-start bg-slate-50 p-4 border rounded-lg shadow-md ">
                                <img src="./images/serviceimages/pexels-tima-miroshnichenko-6694575.jpg"
                                    alt="Book Event" class="w-full h-56">
                                <h3 class="text-xl font-semibold mt-2">Book an Event Space</h3>
                                <p class="text-gray-500">Easily browse and book spaces for weddings, meetings,
                                    parties,
                                    and
                                    more.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="ml-20 max-w-7xl mx-auto px-4 mb-8">
                    <h2 class="text-3xl font-bold mb-4">Featured Venues</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 w-full h-full" id="venueList">
                        <!-- Venue cards will be dynamically inserted here -->
                    </div>
                </section>

                <section class="ml-20 max-w-7xl mx-auto px-4 mb-8">
                    <div class="container mx-auto flex flex-col ">
                        <h2 class="text-3xl font-bold mb-4">About Us</h2>

                        <div class="flex flex-col gap-4">

                            <div
                                class="flex flex-col items-center bg-slate-50 border p-4 lg:p-4 lg:py-8 rounded-lg shadow-md gap-2">
                                <h3 class="text-xl font-semibold  text-red-500 italic">Our Story</h3>
                                <p>
                                    Hubvenue was born out of the need to streamline the often complex and time-consuming
                                    process of
                                    event
                                    planning. The journey began when our founders, faced with the daunting task of
                                    organizing
                                    multiple
                                    events, realized how fragmented the venue and catering service industry was. From
                                    endless phone
                                    calls to
                                    lengthy negotiations, the process was anything but easy. Inspired by the vision of a
                                    one-stop
                                    platform,
                                    Hubvenue was developed to centralize and simplify these interactions, allowing users
                                    to focus on
                                    creating memorable experiences instead of logistics.
                                </p>
                                <p>Throughout our journey, we faced challenges, such as integrating diverse services and
                                    building
                                    trust
                                    within the community. However, these obstacles only strengthened our commitment to
                                    innovation.
                                    Hubvenue
                                    continues to grow, expanding our network of partners and refining our platform based
                                    on user
                                    feedback,
                                    making it the ultimate event planning tool for everyone.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- mission -->
                                <div
                                    class="flex flex-col items-center bg-slate-50 border p-4 lg:p-4 lg:py-8 rounded-lg shadow-md gap-2">
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
                                    class="flex flex-col items-center bg-slate-50 border p-4 lg:p-4 lg:py-8 rounded-lg shadow-md gap-2">
                                    <h3 class="text-xl font-semibold  text-red-500 italic">Our Vision</h3>
                                    <p class="text-center">
                                        To be the go to platform for venue reservations, helping people connect with the
                                        perfect spaces
                                        for any event.
                                    </p>
                                </div>
                            </div>

                            <!-- FAQ -->
                            <div
                                class="flex flex-col bg-slate-50 border text-neutral-700 p-4 lg:p-4 lg:py-8 rounded-lg shadow-md">
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
                                                through the available options, select the space that suits your needs,
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
                                                space, upload photos, and set your availability and pricing. Once your
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
                                                halls, and more. The platform is designed to accommodate all types of
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
                                                typically a percentage of the total rental cost, while listing fees may
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
                                                our website, or by email at info@hubvenue.com. Our team is available to
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

                <?php require_once './components/footer.html' ?>

            </div>
>>>>>>> 4203bd179757a1732842751e0d17f76fe1427cec
        </main>
    </div>

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

        // Venue data
        const venues = [
<<<<<<< HEAD
            { name: "Mikonos, Greece", description: "Beach and ocean views", dates: "May 1 - 7", price: 308981, image: "https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2340&q=80" },
            { name: "Maleme, Greece", description: "Mountain and ocean views", dates: "Apr 1 - 6", price: 44128, image: "https://images.unsplash.com/photo-1533104816931-20fa691ff6ca?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3270&q=80" },
            { name: "Ko Samui, Thailand", description: "Bay views", dates: "Nov 1 - 6", price: 118326, image: "https://images.unsplash.com/photo-1570939274717-7eda259b50ed?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2340&q=80" },
            { name: "Plaka, Greece", description: "Sea views", dates: "Nov 2 - 7", price: 61437, image: "https://images.unsplash.com/photo-1530841377377-3ff06c0ca713?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2340&q=80" },
=======
            {
                id: 1,
                name: "Home in Davao City",
                description: "Spacious 2br budget friendly house",
                dates: "Nov 1 - 6",
                price: 1998,
                image: "https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80",
                rating: 4.91,
                reviews: 65,
                beds: "4 beds",
                tag: "Guest favorite"
            },
            {
                id: 2,
                name: "Apartment in Toril",
                description: "An affordable bachelor pad within toril...",
                dates: "Nov 1 - 6",
                price: 913,
                image: "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                rating: 4.82,
                reviews: 11,
                beds: "Free cancellation",
                tag: "Superhost"
            },
            {
                id: 3,
                name: "Place to stay in Mintal",
                description: "Casa Marias R (600Mbps Wifi, 2mins fro...",
                dates: "Nov 1 - 6",
                price: 912,
                image: "https://images.unsplash.com/photo-1505693314120-0d443867891c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80",
                rating: 4.35,
                reviews: 20,
                beds: "2 double beds",
                tag: ""
            },
            {
                id: 4,
                name: "Cozy Loft in Buhangin",
                description: "Modern loft with stunning city views",
                dates: "Nov 1 - 6",
                price: 1500,
                image: "https://images.unsplash.com/photo-1502005229762-cf1b2da7c5d6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                rating: 4.88,
                reviews: 42,
                beds: "1 queen bed",
                tag: "New listing"
            },
            {
                id: 5,
                name: "Seaside Villa in Samal",
                description: "Luxurious beachfront property with private pool",
                dates: "Nov 1 - 6",
                price: 3500,
                image: "https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80",
                rating: 4.95,
                reviews: 78,
                beds: "3 bedrooms",
                tag: "Luxury"
            }
>>>>>>> 4203bd179757a1732842751e0d17f76fe1427cec
        ];

        // Generate venue cards
        const venueList = document.getElementById('venueList');
        venues.forEach(venue => {
            const card = document.createElement('div');
<<<<<<< HEAD
            card.className = 'bg-white rounded-2xl overflow-hidden shadow-md';
            card.innerHTML = `
                <div class="relative">
                    <img src="${venue.image}" alt="${venue.name}" class="w-full h-72 object-cover rounded-t-2xl">
=======
            card.className = 'bg-white rounded-2xl overflow-hidden shadow-md cursor-pointer';
            card.onclick = () => window.location.href = `venues.php?id=${venue.id}`;
            card.innerHTML = `
                <div class="relative">
                    <img src="${venue.image}" alt="${venue.name}" class="w-full h-96 object-cover rounded-t-2xl">
>>>>>>> 4203bd179757a1732842751e0d17f76fe1427cec
                    <button class="absolute top-3 right-3 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </button>
<<<<<<< HEAD
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">${venue.name}</h3>
                    <p class="text-sm text-gray-500 mt-2">${venue.description}</p>
                    <p class="text-sm text-gray-500 mt-1">${venue.dates}</p>
                    <p class="mt-4">
                        <span class="font-semibold text-gray-900 text-lg">₱${venue.price.toLocaleString()}</span>
                        <span class="text-gray-900"> night</span>
=======
                    ${venue.tag ? `<span class="absolute top-3 left-3 bg-white text-black text-xs font-semibold px-2 py-1 rounded-full">${venue.tag}</span>` : ''}
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-center mb-1">
                        <h3 class="text-base font-semibold text-gray-900">${venue.name}</h3>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="text-sm font-semibold">${venue.rating}</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 leading-tight">${venue.description}</p>
                    <p class="text-sm text-gray-500 leading-tight">${venue.beds}</p>
                    <p class="text-sm text-gray-500 leading-tight">${venue.dates}</p>
                    <p class="mt-2">
                        <span class="font-semibold text-gray-900 text-base">₱${venue.price.toLocaleString()}</span>
                        <span class="text-gray-900 text-sm"> night</span>
>>>>>>> 4203bd179757a1732842751e0d17f76fe1427cec
                    </p>
                </div>
            `;
            venueList.appendChild(card);
        });
<<<<<<< HEAD

        // Function to update sidebar color based on scroll position
        function updateSidebarColor() {
            const sidebar = document.getElementById('sidebar');
            const firstSection = document.querySelector('.first-section');
            const sidebarButtons = sidebar.querySelectorAll('button');
            
            const firstSectionBottom = firstSection.offsetTop + firstSection.offsetHeight;
            const scrollPosition = window.scrollY;

            if (scrollPosition >= firstSectionBottom - sidebar.offsetHeight / 2) {
                sidebarButtons.forEach(button => {
                    button.style.color = '#4A5568'; // Change to a dark color that matches your design
                });
            } else {
                sidebarButtons.forEach(button => {
                    button.style.color = 'white';
                });
            }
        }

        // Add scroll event listener
        window.addEventListener('scroll', updateSidebarColor);
        // Initial call to set correct color on page load
        updateSidebarColor();
    </script>
</body>
</html>
=======
    </script>

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

        // Close modal when clicking outside
        // authModal.addEventListener('click', (e) => {
        //     if (e.target === authModal) {
        //         closeModalFunc();
        //     }
        // });

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

        // Form submission handling
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Add your login logic here
            console.log('Login submitted');
        });

        signupForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Add your signup logic here
            console.log('Signup submitted');
        });

        // Ensure the DOM is fully loaded before attaching event listeners
        document.addEventListener('DOMContentLoaded', (event) => {
            // Reattach event listeners to make sure they work
            closeModal.addEventListener('click', closeModalFunc);
            loginTab.addEventListener('click', () => switchTab(loginTab, signupTab, loginForm, signupForm));
            signupTab.addEventListener('click', () => switchTab(signupTab, loginTab, signupForm, loginForm));
        });
    </script>

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
>>>>>>> 4203bd179757a1732842751e0d17f76fe1427cec
