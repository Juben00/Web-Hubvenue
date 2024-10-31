<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VenueSpot</title>
    <link rel="stylesheet" href="./output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #3490dc, #2779bd);
        }

        .cloud-bottom {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100vw;
            overflow: hidden;
            line-height: 0;
        }

        .cloud-bottom svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 128px;
        }

        .cloud-bottom .shape-fill {
            fill: #FFFFFF;
        }

        .first-section {
            height: 75vh;
        }

        input:focus,
        select:focus {
            outline: none !important;
            box-shadow: none !important;
        }
    </style>
</head>

<body class="min-h-screen text-gray-900 flex flex-col">
    <!-- Header -->
    <?php include 'pages/navbar.html'; ?>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <?php include 'pages/sidebar.html'; ?>

        <!-- Main content -->
        <main class="flex-1">
            <!-- First section -->
            <section class="first-section relative">
                <div class="ml-20 p-8">
                    <div
                        class="bg-slate-50 border mt-16 border-gray-300 rounded-full shadow-lg p-2 mb-8 flex items-center max-w-5xl mx-auto">
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

                    <div class="mt-16 text-white rounded-3xl p-8 mb-8 max-w-5xl mx-auto relative">
                        <div class="flex items-center justify-between relative z-10">
                            <div>
                                <h2 class="text-5xl font-bold mb-2">Welcome to HubVenue</h2>
                                <p class="text-xl mb-4">Plan your next event, party, or outing with us</p>
                                <button
                                    class="bg-slate-50 text-blue-500 font-semibold py-3 px-8 rounded-full hover:bg-blue-100 transition duration-300 text-lg"
                                    onclick="openModal()">
                                    Sign in or register
                                </button>
                            </div>
                            <div class="hidden lg:block border-2 border-red-500">
                                <img src="R.png" alt="HubVenue Mascot" class="w-80 h-80 object-contain transform">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cloud-bottom absolute left-0 w-full overflow-hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none"
                        class="w-full h-64">
                        <path fill="#ffffff" fill-opacity="0.2"
                            d="M0,224L40,229.3C80,235,160,245,240,229.3C320,213,400,171,480,165.3C560,160,640,192,720,192C800,192,880,160,960,165.3C1040,171,1120,213,1200,218.7C1280,224,1360,192,1400,176L1440,160L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
                        </path>
                        <path fill="#ffffff" fill-opacity="0.3"
                            d="M0,256L40,245.3C80,235,160,213,240,213.3C320,213,400,235,480,240C560,245,640,235,720,224C800,213,880,203,960,213.3C1040,224,1120,256,1200,261.3C1280,267,1360,245,1400,234.7L1440,224L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
                        </path>
                        <path fill="#ffffff" fill-opacity="0.4"
                            d="M0,288L40,277.3C80,267,160,245,240,234.7C320,224,400,224,480,229.3C560,235,640,245,720,250.7C800,256,880,256,960,245.3C1040,235,1120,213,1200,213.3C1280,213,1360,235,1400,245.3L1440,256L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
                        </path>
                        <path fill="#ffffff" fill-opacity="0.5"
                            d="M0,288L40,282.7C80,277,160,267,240,261.3C320,256,400,256,480,261.3C560,267,640,277,720,277.3C800,277,880,267,960,261.3C1040,256,1120,256,1200,261.3C1280,267,1360,277,1400,282.7L1440,288L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
                        </path>
                        <path fill="#ffffff"
                            d="M0,288L40,288C80,288,160,288,240,282.7C320,277,400,267,480,266.7C560,267,640,277,720,282.7C800,288,880,288,960,282.7C1040,277,1120,267,1200,266.7C1280,267,1360,277,1400,282.7L1440,288L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
                        </path>
                    </svg>
                </div>
            </section>

            <!-- Second section with venue cards -->
            <section class="bg-slate-50 py-16 relative z-10">
                <div class="ml-20 max-w-8xl mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-8">Featured Venues</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-8 w-full h-full"
                        id="venueList">
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
        ];

        // Generate venue cards
        const venueList = document.getElementById('venueList');
        venues.forEach(venue => {
            const card = document.createElement('div');
            card.className = 'bg-slate-50 rounded-2xl overflow-hidden shadow-md cursor-pointer';
            card.onclick = () => window.location.href = `venues.php?id=${venue.id}`;
            card.innerHTML = `
                <div class="relative">
                    <img src="${venue.image}" alt="${venue.name}" class="w-full h-96 object-cover rounded-t-2xl">
                    <button class="absolute top-3 right-3 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    ${venue.tag ? `<span class="absolute top-3 left-3 bg-slate-50 text-black text-xs font-semibold px-2 py-1 rounded-full">${venue.tag}</span>` : ''}
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
                    </p>
                </div>
            `;
            venueList.appendChild(card);
        });
    </script>

    <!-- Add this right before the closing </body> tag -->
    <div id="authModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-slate-50 rounded-lg p-8 max-w-2xl w-full mx-4 relative shadow-2xl"> <!-- Decreased max-width -->
            <!-- Close button -->
            <button id="closeModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Logo -->
            <div class="text-center mb-6">
                <svg class="w-16 h-16 mx-auto text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                    </path>
                </svg>
                <h2 class="mt-2 text-3xl font-bold text-gray-900">HubVenue</h2>
            </div>

            <!-- Tabs -->
            <div class="flex mb-6 relative">
                <button id="loginTab"
                    class="flex-1 py-2 px-4 text-center text-gray-500 font-semibold relative z-10 text-lg">Login</button>
                <button id="signupTab"
                    class="flex-1 py-2 px-4 text-center text-gray-500 font-semibold relative z-10 text-lg">Sign
                    Up</button>
                <div id="tabUnderline"
                    class="absolute bottom-0 left-0 w-1/2 h-0.5 bg-blue-500 transition-all duration-300 ease-in-out">
                </div>
            </div>

            <div class="w-full">
                <!-- Login Form -->
                <form id="loginForm" class="space-y-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0"
                            placeholder="Type your username">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0"
                            placeholder="Type your password">
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember"
                                class="h-4 w-4 rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                        <a href="#" class="text-sm text-blue-500 hover:text-blue-700">Forgot password?</a>
                    </div>
                    <button type="submit"
                        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Login
                    </button>
                </form>

                <!-- Sign Up Form -->
                <form id="signupForm" class="space-y-4 hidden">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" id="firstName"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0"
                                placeholder="Enter First Name">
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" id="lastName"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0"
                                placeholder="Enter Last Name">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="mi" class="block text-sm font-medium text-gray-700">M.I.</label>
                            <input type="text" id="mi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0"
                                placeholder="M.I.">
                        </div>
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                            <select id="gender"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday</label>
                            <input type="date" id="birthday"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0">
                        </div>
                        <div>
                            <label for="contactNumber" class="block text-sm font-medium text-gray-700">Contact
                                Number</label>
                            <input type="tel" id="contactNumber"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0"
                                placeholder="Enter Contact Number">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0"
                            placeholder="Enter Email">
                    </div>
                    <div>
                        <label for="signupPassword" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="signupPassword"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-0"
                            placeholder="Enter Password">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="agreeTerms"
                            class="h-4 w-4 rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                        <label for="agreeTerms" class="ml-2 block text-sm text-gray-700">I agree with all the <a
                                href="#" class="text-blue-500">terms and conditions</a> and <a href="#"
                                class="text-blue-500">privacy policies</a> of HubVenue</label>
                    </div>
                    <button type="submit"
                        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign Up
                    </button>
                </form>
            </div>

            <!-- Social Login -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-slate-50 text-gray-500">Or login using</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-3 gap-3">
                    <div>
                        <a href="#"
                            class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-slate-50 text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Sign in with Facebook</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>

                    <div>
                        <a href="#"
                            class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-slate-50 text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Sign in with Twitter</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path
                                    d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>

                    <div>
                        <a href="#"
                            class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-slate-50 text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Sign in with Google</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        authModal.addEventListener('click', (e) => {
            if (e.target === authModal) {
                closeModalFunc();
            }
        });

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
</body>

</html>