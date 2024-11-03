<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Your Venue - HubVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .progress-bar {
            height: 4px;
            background-color: #dddddd;
        }

        .progress {
            height: 100%;
            background-color: #000000;
            transition: width 0.3s ease;
        }

        .custom-checkbox {
            width: 24px;
            height: 24px;
            border: 2px solid #000;
            border-radius: 4px;
            display: inline-block;
            position: relative;
        }

        .custom-checkbox::after {
            content: '\2714';
            font-size: 20px;
            position: absolute;
            top: -2px;
            left: 3px;
            display: none;
        }

        input:checked+.custom-checkbox::after {
            display: block;
        }

        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background-color: white;
            border-bottom: none;
        }
    </style>
</head>

<body class="bg-white pt-16"> <!-- Added padding-top to account for fixed top bar -->
    <!-- New top bar -->
    <div class="top-bar">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div>
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation"
                    focusable="false"
                    style="display: block; fill: none; height: 32px; width: 32px; stroke: currentcolor; stroke-width: 4; overflow: visible;">
                    <g fill="none" fill-rule="nonzero">
                        <path d="m2 16h28"></path>
                        <path d="m2 24h28"></path>
                        <path d="m2 8h28"></path>
                    </g>
                </svg>
            </div>
            <div class="flex items-center space-x-4">
                <button class="text-black font-semibold">Questions?</button>
                <button class="bg-black text-white px-4 py-2 rounded-full hover:bg-gray-800">Save & exit</button>
            </div>
        </div>
    </div>

    <div class="container mt-32 mx-auto px-4 py-8 max-w-2xl"> <!-- Adjusted max-width -->
        <div id="step1" class="step active">
            <h2 class="text-2xl font-semibold mb-2">Step 1</h2>
            <h1 class="text-4xl font-bold mb-4">Tell us about your place</h1>
            <p class="text-xl text-gray-600 mb-8">In this step, we'll ask you which type of property you have and if
                guests will book the entire place or just a room. Then let us know the location and how many guests can
                stay.</p>
        </div>



        <div id="step2" class="step">
            <h2 class="text-xl font-semibold mb-4">Which of these best describes your place?</h2>
            <div class="grid grid-cols-3 gap-4">
                <button
                    class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    Apartment
                </button>
                <button
                    class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    House
                </button>
                <button
                    class="p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Cycladic home
                </button>
                <!-- Add more options as needed -->
            </div>
        </div>

        <div id="step3" class="step">
            <h1 class="text-3xl font-bold mb-6">What type of place will guests have?</h1>
            <div class="space-y-4">
                <button
                    class="w-full p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 mr-4" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true" role="presentation" focusable="false">
                            <path
                                d="m16 17c3.8659932 0 7 3.1340068 7 7s-3.1340068 7-7 7-7-3.1340068-7-7 3.1340068-7 7-7zm0 2c-2.7614237 0-5 2.2385763-5 5s2.2385763 5 5 5 5-2.2385763 5-5-2.2385763-5-5-5zm9.6666667-18.66666667c1.0543618 0 1.9181651.81587779 1.9945142 1.85073766l.0054858.14926234v6.38196601c0 .70343383-.3690449 1.35080636-.9642646 1.71094856l-.1413082.0779058-9.6666667 4.8333334c-.5067495.2533747-1.0942474.2787122-1.6171466.0760124l-.1717078-.0760124-9.66666666-4.8333334c-.62917034-.3145851-1.04315599-.93418273-1.09908674-1.62762387l-.00648607-.16123049v-6.38196601c0-1.05436179.81587779-1.91816512 1.85073766-1.99451426l.14926234-.00548574zm0 2h-19.33333337v6.38196601l9.66666667 4.83333336 9.6666667-4.83333336z">
                            </path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">An entire place</h3>
                            <p class="text-sm text-gray-500">Guests have the whole place to themselves.</p>
                        </div>
                    </div>
                </button>
                <button
                    class="w-full p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 mr-4" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true" role="presentation" focusable="false">
                            <path
                                d="m16 17c3.8659932 0 7 3.1340068 7 7s-3.1340068 7-7 7-7-3.1340068-7-7 3.1340068-7 7-7zm0 2c-2.7614237 0-5 2.2385763-5 5s2.2385763 5 5 5 5-2.2385763 5-5-2.2385763-5-5-5zm9.6666667-18.66666667c1.0543618 0 1.9181651.81587779 1.9945142 1.85073766l.0054858.14926234v6.38196601c0 .70343383-.3690449 1.35080636-.9642646 1.71094856l-.1413082.0779058-9.6666667 4.8333334c-.5067495.2533747-1.0942474.2787122-1.6171466.0760124l-.1717078-.0760124-9.66666666-4.8333334c-.62917034-.3145851-1.04315599-.93418273-1.09908674-1.62762387l-.00648607-.16123049v-6.38196601c0-1.05436179.81587779-1.91816512 1.85073766-1.99451426l.14926234-.00548574zm0 2h-19.33333337v6.38196601l9.66666667 4.83333336 9.6666667-4.83333336z">
                            </path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">A room</h3>
                            <p class="text-sm text-gray-500">Guests have their own room in a home, plus access to shared
                                spaces.</p>
                        </div>
                    </div>
                </button>
                <button
                    class="w-full p-4 border rounded-lg text-left hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 mr-4" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true" role="presentation" focusable="false">
                            <path
                                d="m16 17c3.8659932 0 7 3.1340068 7 7s-3.1340068 7-7 7-7-3.1340068-7-7 3.1340068-7 7-7zm0 2c-2.7614237 0-5 2.2385763-5 5s2.2385763 5 5 5 5-2.2385763 5-5-2.2385763-5-5-5zm9.6666667-18.66666667c1.0543618 0 1.9181651.81587779 1.9945142 1.85073766l.0054858.14926234v6.38196601c0 .70343383-.3690449 1.35080636-.9642646 1.71094856l-.1413082.0779058-9.6666667 4.8333334c-.5067495.2533747-1.0942474.2787122-1.6171466.0760124l-.1717078-.0760124-9.66666666-4.8333334c-.62917034-.3145851-1.04315599-.93418273-1.09908674-1.62762387l-.00648607-.16123049v-6.38196601c0-1.05436179.81587779-1.91816512 1.85073766-1.99451426l.14926234-.00548574zm0 2h-19.33333337v6.38196601l9.66666667 4.83333336 9.6666667-4.83333336z">
                            </path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">A shared room in a hostel</h3>
                            <p class="text-sm text-gray-500">Guests sleep in a shared room in a professionally managed
                                hostel with staff onsite 24/7.</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>

        <div id="step4" class="step">
            <h1 class="text-3xl font-bold mb-4">Share some basics about your place</h1>
            <p class="text-gray-600 mb-6">You'll add more details later, like bed types.</p>

            <div class="space-y-6">
                <div class="flex justify-between items-center">
                    <span class="text-xl">Guests</span>
                    <div class="flex items-center">
                        <button
                            class="w-8 h-8 rounded-full border border-gray-400 flex items-center justify-center">-</button>
                        <span class="mx-4 text-xl">4</span>
                        <button
                            class="w-8 h-8 rounded-full border border-gray-400 flex items-center justify-center">+</button>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-xl">Bedrooms</span>
                    <div class="flex items-center">
                        <button
                            class="w-8 h-8 rounded-full border border-gray-400 flex items-center justify-center">-</button>
                        <span class="mx-4 text-xl">1</span>
                        <button
                            class="w-8 h-8 rounded-full border border-gray-400 flex items-center justify-center">+</button>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-xl">Beds</span>
                    <div class="flex items-center">
                        <span class="mx-4 text-xl">1</span>
                        <button
                            class="w-8 h-8 rounded-full border border-gray-400 flex items-center justify-center">+</button>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-xl">Bathrooms</span>
                    <div class="flex items-center">
                        <button
                            class="w-8 h-8 rounded-full border border-gray-400 flex items-center justify-center">-</button>
                        <span class="mx-4 text-xl">1</span>
                        <button
                            class="w-8 h-8 rounded-full border border-gray-400 flex items-center justify-center">+</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="step5" class="step">
            <h1 class="text-3xl font-bold mb-4">Where's your place located?</h1>
            <p class="text-gray-600 mb-6">Your address is only shared with guests after they've made a reservation.</p>

            <div class="bg-blue-200 rounded-lg p-6 mb-6">
                <div class="bg-white rounded-full p-3 mb-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <input type="text" placeholder="Enter your address" class="w-full outline-none text-gray-700" />
                    </div>
                </div>
                <div class="w-full h-64 bg-blue-300 rounded-lg">
                    <!-- This is a placeholder for the map. You might want to integrate a real map service here -->
                    <img src="path_to_map_image.jpg" alt="Map" class="w-full h-full object-cover rounded-lg" />
                </div>
            </div>
        </div>


        <div id="step6" class="step">
            <h2 class="text-2xl font-semibold mb-2">Step 2</h2>
            <h1 class="text-4xl font-bold mb-4">What kind of place will you host?</h1>
            <p class="text-xl text-gray-600 mb-8">Choose the option that best describes your place.</p>
        </div>

        <div id="step7" class="step">
            <h1 class="text-3xl font-bold mb-4">Add some photos of your place</h1>
            <p class="text-gray-600 mb-6">You'll need 5 photos to get started. You can add more or make changes later.
            </p>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                <img src="path_to_camera_icon.jpg" alt="Camera Icon" class="mx-auto mb-4">
                <button
                    class="bg-white text-black font-semibold py-2 px-4 border border-black rounded hover:bg-gray-100">Add
                    photos</button>
            </div>
        </div>

        <div id="step8" class="step">
            <h1 class="text-3xl font-bold mb-4">Now, let's give your place a title</h1>
            <p class="text-gray-600 mb-6">Short titles work best. Have fun with it—you can always change it later.</p>
            <input type="text" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black"
                placeholder="Enter title here">
            <p class="text-right text-gray-500 mt-2">0/32</p>
        </div>

        <div id="step9" class="step">
            <h1 class="text-3xl font-bold mb-4">Next, let's describe your place</h1>
            <p class="text-gray-600 mb-6">Choose up to 2 highlights. We'll use these to get your description started.
            </p>
            <div class="flex flex-wrap gap-4">
                <button
                    class="px-4 py-2 border rounded-full hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    Peaceful
                </button>
                <button
                    class="px-4 py-2 border rounded-full hover:border-black focus:outline-none focus:ring-2 focus:ring-black">
                    Unique
                </button>
                <!-- Add more highlight options here -->
            </div>
        </div>

        <div id="step10" class="step">
            <h1 class="text-3xl font-bold mb-4">Create your description</h1>
            <p class="text-gray-600 mb-6">Share what makes your place special.</p>
            <textarea class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-black" rows="6"
                placeholder="You'll have a great time at this comfortable place to stay."></textarea>
            <p class="text-right text-gray-500 mt-2">59/500</p>
        </div>

        <div id="step11" class="step">
            <h2 class="text-2xl font-semibold mb-2">Step 3</h2>
            <h1 class="text-4xl font-bold mb-4">Finish up and publish</h1>
            <p class="text-xl text-gray-600 mb-8">Finally, you'll choose booking settings, set up pricing, and publish
                your listing.</p>
            <img src="path_to_house_image.jpg" alt="House" class="w-full rounded-lg mb-8">
        </div>

        <div id="step12" class="step">
            <h1 class="text-3xl font-bold mb-4">Pick your booking settings</h1>
            <p class="text-gray-600 mb-6">You can change this at any time. <a href="#"
                    class="text-black underline">Learn more</a></p>

            <div class="space-y-4">
                <div class="p-6 border rounded-xl">
                    <div class="flex items-center justify-between">
                        <div class="flex-grow">
                            <h2 class="text-xl font-semibold">Approve your first 5 bookings</h2>
                            <p class="text-green-600 text-sm">Recommended</p>
                            <p class="text-gray-600 text-sm mt-2">Start by reviewing reservation requests, then switch
                                to Instant Book, so guests can book automatically.</p>
                        </div>
                        <svg class="w-8 h-8 ml-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="p-6 border rounded-xl">
                    <div class="flex items-center justify-between">
                        <div class="flex-grow">
                            <h2 class="text-xl font-semibold">Use Instant Book</h2>
                            <p class="text-gray-600 text-sm mt-2">Let guests book automatically.</p>
                        </div>
                        <svg class="w-8 h-8 ml-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div id="step13" class="step">
            <h1 class="text-3xl font-bold mb-4">Choose who to welcome for your first reservation</h1>
            <p class="text-gray-600 mb-6">After your first guest, anyone can book your place. <a href="#"
                    class="text-black underline">Learn more</a></p>

            <div class="space-y-4">
                <div class="p-4 border rounded-lg flex items-center">
                    <input type="radio" name="guest_type" id="any_guest" class="mr-4">
                    <label for="any_guest">
                        <h2 class="text-xl font-semibold">Any Airbnb guest</h2>
                        <p class="text-gray-600">Get reservations faster when you welcome anyone from the Airbnb
                            community.</p>
                    </label>
                </div>
                <div class="p-4 border rounded-lg flex items-center">
                    <input type="radio" name="guest_type" id="experienced_guest" class="mr-4">
                    <label for="experienced_guest">
                        <h2 class="text-xl font-semibold">An experienced guest</h2>
                        <p class="text-gray-600">For your first guest, welcome someone with a good track record on
                            Airbnb who can offer tips for how to be a great Host.</p>
                    </label>
                </div>
            </div>
        </div>

        <div id="step14" class="step">
            <h1 class="text-3xl font-bold mb-2">Now, set your price</h1>
            <p class="text-gray-600 mb-6">You can change it anytime.</p>

            <div class="text-center mb-8">
                <h2 class="text-6xl font-bold mb-2">₱2,341</h2>
                <p class="text-gray-600">Guest price before taxes ₱2,671 <span class="text-black">▼</span></p>
            </div>

            <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center mb-8">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Similar listings ₱2,176 - ₱3,263</span>
            </div>

            <p class="text-center text-gray-600"><a href="#" class="text-black underline">Learn more about pricing</a>
            </p>
        </div>

        <div id="step15" class="step">
            <h1 class="text-3xl font-bold mb-2">Add discounts</h1>
            <p class="text-gray-600 mb-6">Help your place stand out to get booked faster and earn your first reviews.
            </p>

            <div class="space-y-4">
                <div class="p-6 bg-gray-100 rounded-xl flex items-center justify-between">
                    <div>
                        <div class="flex items-center">
                            <span class="text-2xl font-bold mr-2">20%</span>
                            <div>
                                <h2 class="text-xl font-semibold">New listing promotion</h2>
                                <p class="text-gray-600 text-sm">Offer 20% off your first 3 bookings</p>
                            </div>
                        </div>
                    </div>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" class="hidden" checked>
                        <span class="custom-checkbox"></span>
                    </label>
                </div>
                <div class="p-6 bg-gray-100 rounded-xl flex items-center justify-between">
                    <div>
                        <div class="flex items-center">
                            <span class="text-2xl font-bold mr-2">10%</span>
                            <div>
                                <h2 class="text-xl font-semibold">Weekly discount</h2>
                                <p class="text-gray-600 text-sm">For stays of 7 nights or more</p>
                            </div>
                        </div>
                    </div>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" class="hidden" checked>
                        <span class="custom-checkbox"></span>
                    </label>
                </div>
                <div class="p-6 bg-gray-100 rounded-xl flex items-center justify-between">
                    <div>
                        <div class="flex items-center">
                            <span class="text-2xl font-bold mr-2">20%</span>
                            <div>
                                <h2 class="text-xl font-semibold">Monthly discount</h2>
                                <p class="text-gray-600 text-sm">For stays of 28 nights or more</p>
                            </div>
                        </div>
                    </div>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" class="hidden" checked>
                        <span class="custom-checkbox"></span>
                    </label>
                </div>
            </div>

            <p class="text-center text-gray-600 text-sm mt-6">Only one discount will be applied per stay. <a href="#"
                    class="text-black underline">Learn more</a></p>
        </div>

        <div id="step16" class="step">
            <h1 class="text-3xl font-bold mb-4">Review your listing</h1>
            <p class="text-gray-600 mb-6">Here's what we'll show to guests. Make sure everything looks good.</p>

            <div class="bg-gray-100 rounded-lg p-4 mb-8">
                <button class="bg-white text-black font-semibold py-2 px-4 rounded">Show preview</button>
                <img src="path_to_map_image.jpg" alt="Map" class="w-full mt-4 rounded">
                <div class="mt-4">
                    <h2 class="text-xl font-semibold">asdas</h2>
                    <p class="text-gray-600"><span class="line-through">₱2,341</span> ₱1,873 night <span
                            class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full text-xs">New</span></p>
                </div>
            </div>

            <h2 class="text-2xl font-semibold mb-4">What's next?</h2>
            <div class="space-y-4">
                <div class="flex items-start">
                    <svg class="w-6 h-6 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold">Confirm a few details and publish</h3>
                        <p class="text-gray-600">We'll let you know if you need to verify your identity or register with
                            the local government.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-6 h-6 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <div>
                        <h3 class="font-semibold">Set up your calendar</h3>
                        <p class="text-gray-600">Choose which dates your listing is available. It will be visible 24
                            hours after you publish.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-6 h-6 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                        </path>
                    </svg>
                    <div>
                        <h3 class="font-semibold">Adjust your settings</h3>
                        <p class="text-gray-600">Set house rules, select a cancellation policy, choose how guests book,
                            and more.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <button onclick="prevStep()" class="text-black font-semibold hover:underline">Back</button>
            <div class="progress-bar w-1/3">
                <div id="progress" class="progress" style="width: 7.14%;"></div>
            </div>
            <button onclick="nextStep()"
                class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800">Next</button>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 16; // Increase the total steps by 2

        function nextStep() {
            if (currentStep < totalSteps) {
                document.getElementById(`step${currentStep}`).classList.remove('active');
                currentStep++;
                document.getElementById(`step${currentStep}`).classList.add('active');
                updateProgress();
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                document.getElementById(`step${currentStep}`).classList.remove('active');
                currentStep--;
                document.getElementById(`step${currentStep}`).classList.add('active');
                updateProgress();
            }
        }

        function updateProgress() {
            const progressBar = document.getElementById('progress');
            const progressPercentage = (currentStep / totalSteps) * 100;
            progressBar.style.width = `${progressPercentage}%`;
        }
    </script>
</body>

</html>