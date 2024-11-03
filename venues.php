<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Details - HubVenue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>
</head>

<body class="bg-slate-50">
    <!-- Header -->
    <?php include 'components/navbar.html'; ?>

    <main class="max-w-7xl pt-32 mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <div id="venueDetails">
            <!-- Venue details will be dynamically inserted here -->
        </div>
    </main>

    <script>
        // Constant venue data for demonstration
        const venue = {
            id: 1,
            name: "Entire farm place w/ dipping pool & sulfur spring",
            description: "We would like your stay to be special and with that, we made sure that you'll enjoy a wide array of activities beyond the usual farm stay without breaking the bank.\n\nThe space\nIt's a 3.5k sqm mtr private farm resort that has 2 casitas, tent accomodation, outdoor kitchen / dining and an entertainment area....",
            dates: "Nov 3 - Nov 8, 2024",
            price: 12729,
            originalPrice: 14281,
            image: "https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80",
            rating: 4.96,
            reviews: 90,
            guests: 12,
            bedrooms: 2,
            beds: 7,
            baths: 3,
            tag: "Guest favorite",
            host: "Oscar Jr",
            hostType: "Superhost",
            hostingTime: "3 years hosting",
            location: "Jala-jala, Philippines",
            amenities: [
                "Enjoy the pool and hot tub",
                "Designed for staying cool",
                "Great location"
            ],
            features: [
                "Canal view", "Garden view", "Lake access", "Kitchen", "Wifi",
                "Free parking on premises", "Private outdoor pool - available all year, open specific hours, pool cover",
                "Private hot tub - open 24 hours", "Private sauna"
            ],
            sleepingArrangements: [
                { name: "Living room", beds: "1 couch" },
                { name: "Bedroom 1", beds: "2 queen beds, 1 single bed, 2 floor mattresses" }
            ],
            priceDetails: {
                nights: 5,
                pricePerNight: 12729,
                cleaningFee: 300,
                serviceFee: 9028,
                total: 72975
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            const venueDetails = document.getElementById('venueDetails');
            venueDetails.innerHTML = `
                <div class="mb-6">
                    <h1 class="text-3xl font-semibold mb-2">${venue.name}</h1>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-sm font-semibold">${venue.rating} · ${venue.reviews} reviews</span>
                            <span class="mx-2">·</span>
                            <span class="text-sm font-semibold">${venue.tag}</span>
                            <span class="mx-2">·</span>
                            <span class="text-sm font-semibold">${venue.location}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2 mb-8 relative">
                    <img src="${venue.image}" alt="${venue.name}" class="col-span-2 row-span-2 w-full h-full object-cover rounded-l-lg">
                    <img src="${venue.image}" alt="" class="w-full h-full object-cover">
                    <img src="${venue.image}" alt="" class="w-full h-full object-cover rounded-tr-lg">
                    <button class="absolute bottom-4 right-4 bg-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">
                        Show all photos
                    </button>
                </div>

                <div class="flex gap-12">
                    <div class="w-2/3">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-2xl font-semibold">Farm stay in ${venue.location}</h2>
                                <p class="text-gray-600">${venue.guests} guests · ${venue.bedrooms} bedrooms · ${venue.beds} beds · ${venue.baths} baths</p>
                            </div>
                            <img src="https://via.placeholder.com/60" alt="${venue.host}" class="rounded-full">
                        </div>

                        <hr class="my-6">

                        ${venue.amenities.map(amenity => `
                            <div class="flex items-start mb-4">
                                <svg class="w-6 h-6 mr-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <div>
                                    <h3 class="font-semibold">${amenity.split(':')[0]}</h3>
                                    <p class="text-gray-600">${amenity.split(':')[1] || ''}</p>
                                </div>
                            </div>
                        `).join('')}

                        <hr class="my-6">

                        <p class="mb-4">${venue.description}</p>
                        <button class="font-semibold text-gray-600 hover:underline">Show more ></button>

                        <hr class="my-6">

                        <h3 class="text-xl font-semibold mb-4">Where you'll sleep</h3>
                        <div class="flex gap-4 mb-6">
                            ${venue.sleepingArrangements.map(room => `
                                <div class="border rounded-lg p-4 w-48">
                                    <h4 class="font-semibold mb-2">${room.name}</h4>
                                    <p class="text-gray-600">${room.beds}</p>
                                </div>
                            `).join('')}
                        </div>

                        <hr class="my-6">

                        <h3 class="text-xl font-semibold mb-4">What this place offers</h3>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            ${venue.features.slice(0, 10).map(feature => `
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>${feature}</span>
                                </div>
                            `).join('')}
                        </div>
                        <button class="border border-gray-900 rounded-lg px-6 py-3 font-semibold">Show all 57 amenities</button>
                    </div>
                         


            
                    <div class="w-1/3">
                        <div class="border rounded-xl p-6 shadow-lg mb-6">
                            <h3 class="text-xl font-semibold mb-4">Location</h3>
                            <div class="bg-gray-100 rounded-lg h-48 mb-4">
                                <div class="w-full h-full flex items-center justify-center text-gray-500">
                                    Map placeholder
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-start">
                                    <div class="text-lg">7.7 Very good</div>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.05 3.691c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.372 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.363-1.118L3.98 9.483c-.784-.57-.381-1.81.587-1.81H8.03a1 1 0 00.95-.69L9.05 3.691z" />
                                    </svg>
                                    <span>Very good location - 2.21 kilometers from city center</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>Exceptional for walking</span>
                                </div>
                                
                                <div class="mt-4">
                                    <h4 class="font-semibold mb-2">Walkable places</h4>
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <div class="flex justify-between">
                                            <span>West-Park Presbyterian Church</span>
                                            <span>70 m</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Upper West Side</span>
                                            <span>140 m</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Time for Children</span>
                                            <span>200 m</span>
                                        </div>
                                    </div>
                                    <button class="text-blue-600 hover:underline text-sm mt-3">SEE NEARBY PLACES</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border rounded-xl p-6 shadow-lg sticky top-6">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <span class="text-2xl font-semibold">₱${venue.price}</span>
                                    <span class="text-lg">night</span>
                                </div>
                                <div class="text-sm">
                                    <span class="font-semibold">${venue.rating}</span>
                                    <span class="text-gray-600">· ${venue.reviews} reviews</span>
                                </div>
                            </div>
                            <div class="border rounded-lg mb-4">
                                <div class="flex">
                                    <div class="w-1/2 p-2 border-r">
                                        <label class="block text-xs font-semibold">CHECK-IN</label>
                                        <input type="text" value="11/3/2024" class="w-full">
                                    </div>
                                    <div class="w-1/2 p-2">
                                        <label class="block text-xs font-semibold">CHECKOUT</label>
                                        <input type="text" value="11/8/2024" class="w-full">
                                    </div>
                                </div>
                                <div class="border-t p-2">
                                    <label class="block text-xs font-semibold">GUESTS</label>
                                    <select class="w-full">
                                        <option>1 guest</option>
                                    </select>
                                </div>
                            </div>
                            <button class="w-full bg-red-500 text-white rounded-lg py-3 font-semibold mb-4">Reserve</button>
                            <p class="text-center text-gray-600 mb-4">You won't be charged yet</p>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="underline">₱${venue.price} x ${venue.priceDetails.nights} nights</span>
                                    <span>₱${venue.priceDetails.pricePerNight * venue.priceDetails.nights}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="underline">Cleaning fee</span>
                                    <span>₱${venue.priceDetails.cleaningFee}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="underline">Airbnb service fee</span>
                                    <span>₱${venue.priceDetails.serviceFee}</span>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="flex justify-between font-semibold">
                                <span>Total before taxes</span>
                                <span>₱${venue.priceDetails.total}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    </script>
</body>

</html>