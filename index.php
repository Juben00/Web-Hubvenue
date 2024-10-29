<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HubVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #3490dc, #2779bd);
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
            fill: #FFFFFF;
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
</head>

<body class="min-h-screen text-gray-900 flex flex-col">
    <!-- Header -->
    <?php include './components/navbar.html'; ?>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar fixed left-0 top-1/2 transform -translate-y-1/2 w-20 flex flex-col items-center py-8 space-y-8 z-20">
            <button class=" flex flex-col items-center focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs mt-1">Home</span>
            </button>
            <button class="flex flex-col items-center text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span class="text-xs mt-1">Weddings</span>
            </button>
            <button class="flex flex-col items-center text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                </svg>
                <span class="text-xs mt-1">Parties</span>
            </button>
            <button class="flex flex-col items-center text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <span class="text-xs mt-1">Outdoor</span>
            </button>
            <button class="flex flex-col items-center text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                <span class="text-xs mt-1">Outings</span>
            </button>
            <button class="flex flex-col items-center text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
                <span class="text-xs mt-1">Unique</span>
            </button>
        </aside>

        <!-- Main content -->
        <main class="flex-1">
            <!-- First section -->
            <section class="first-section relative">
                <div class="ml-20 p-8"> <!-- Added ml-20 to account for sidebar width -->
                    <div
                        class="bg-white border border-gray-300 rounded-full shadow-lg p-2 mb-8 flex items-center max-w-5xl mx-auto">
                        <div class="flex-1 min-w-0 px-4">
                            <label for="where" class="block text-sm font-medium text-gray-700">Where</label>
                            <input type="text" id="where" placeholder="Search destinations"
                                class="w-full border-0 focus:ring-0 focus:outline-none text-lg bg-transparent">
                        </div>
                        <div class="w-px h-10 bg-gray-300 mx-2"></div>
                        <div class="flex-1 min-w-0 px-4">
                            <button id="checkInBtn" class="w-full text-left font-normal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span id="checkInText">Check in</span>
                            </button>
                        </div>
                        <div class="w-px h-10 bg-gray-300 mx-2"></div>
                        <div class="flex-1 min-w-0 px-4">
                            <button id="checkOutBtn" class="w-full text-left font-normal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span id="checkOutText">Check out</span>
                            </button>
                        </div>
                        <div class="w-px h-10 bg-gray-300 mx-2"></div>
                        <div class="flex-1 min-w-0 px-4">
                            <label for="guests" class="block text-sm font-medium text-gray-700">Who</label>
                            <input type="text" id="guests" placeholder="Add guests"
                                class="w-full border-0 focus:ring-0 focus:outline-none text-lg bg-transparent">
                        </div>
                        <button class="rounded-full bg-red-500 hover:bg-red-600 text-white p-2 mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Updated sign-in section -->
                    <div class="text-white rounded-3xl p-8 mb-8 max-w-5xl mx-auto relative">
                        <div class="flex items-center justify-between relative z-10">
                            <div>
                                <h2 class="text-5xl font-bold mb-2">Sign in, save money</h2>
                                <p class="text-xl mb-4">Save 10% on select properties with VenueSpot Rewards</p>
                                <button
                                    class="bg-white text-blue-500 font-semibold py-3 px-8 rounded-full hover:bg-blue-100 transition duration-300 text-lg">
                                    Sign in or register
                                </button>
                            </div>
                            <div class="hidden lg:block">
                                <!-- Replace this with your actual mascot image -->
                                <img src="https://placekitten.com/200/200" alt="VenueSpot Mascot"
                                    class="w-48 h-48 object-cover">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cloud-bottom absolute left-0 w-full overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none"
                        class="w-full h-32">
                        <path fill="#ffffff" fill-opacity="0.2"
                            d="M0,128L48,144C96,160,192,192,288,197.3C384,203,480,181,576,165.3C672,149,768,139,864,149.3C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                        </path>
                        <path fill="#ffffff" fill-opacity="0.4"
                            d="M0,192L48,181.3C96,171,192,149,288,149.3C384,149,480,171,576,181.3C672,192,768,192,864,181.3C960,171,1056,149,1152,144C1248,139,1344,149,1392,154.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                        </path>
                        <path fill="#ffffff" fill-opacity="0.6"
                            d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,213.3C672,224,768,224,864,213.3C960,203,1056,181,1152,170.7C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                        </path>
                        <path fill="#ffffff" fill-opacity="1"
                            d="M0,256L48,245.3C96,235,192,213,288,213.3C384,213,480,235,576,245.3C672,256,768,256,864,245.3C960,235,1056,213,1152,202.7C1248,192,1344,192,1392,192L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                        </path>
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
            { name: "Mikonos, Greece", description: "Beach and ocean views", dates: "May 1 - 7", price: 308981, image: "https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2340&q=80" },
            { name: "Maleme, Greece", description: "Mountain and ocean views", dates: "Apr 1 - 6", price: 44128, image: "https://images.unsplash.com/photo-1533104816931-20fa691ff6ca?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3270&q=80" },
            { name: "Ko Samui, Thailand", description: "Bay views", dates: "Nov 1 - 6", price: 118326, image: "https://images.unsplash.com/photo-1570939274717-7eda259b50ed?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2340&q=80" },
            { name: "Plaka, Greece", description: "Sea views", dates: "Nov 2 - 7", price: 61437, image: "https://images.unsplash.com/photo-1530841377377-3ff06c0ca713?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2340&q=80" },
        ];

        // Generate venue cards
        const venueList = document.getElementById('venueList');
        venues.forEach(venue => {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-2xl overflow-hidden shadow-md';
            card.innerHTML = `
                <div class="relative">
                    <img src="${venue.image}" alt="${venue.name}" class="w-full h-72 object-cover rounded-t-2xl">
                    <button class="absolute top-3 right-3 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">${venue.name}</h3>
                    <p class="text-sm text-gray-500 mt-2">${venue.description}</p>
                    <p class="text-sm text-gray-500 mt-1">${venue.dates}</p>
                    <p class="mt-4">
                        <span class="font-semibold text-gray-900 text-lg">₱${venue.price.toLocaleString()}</span>
                        <span class="text-gray-900"> night</span>
                    </p>
                </div>
            `;
            venueList.appendChild(card);
        });

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